<?php
include('../includes/admin_header.php');
include('../db/config.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the request
    $orderId = $_POST['order_id'];
    $productIds = isset($_POST['product_ids']) ? $_POST['product_ids'] : [];

    // Get the current admin ID (replace with your admin authentication logic)
    $adminId = 1; // Replace with the actual admin ID

    // Update the orders table
    $updateOrderSql = "UPDATE orders SET admin_id = ?, order_request = 'rq_sent' WHERE order_id = ?";
    $updateOrderStmt = $conn->prepare($updateOrderSql);

    if (!$updateOrderStmt) {
        die('Error in SQL query: ' . $conn->error);
    }

    $updateOrderStmt->bind_param("ii", $adminId, $orderId);
    $updateResult = $updateOrderStmt->execute();
    $updateOrderStmt->close();

    if (!$updateResult) {
        die('Error updating orders table: ' . $conn->error);
    }

    // Insert records in the store_requests table
    foreach ($productIds as $productId) {
        $insertRequestSql = "INSERT INTO store_requests (order_id, product_id) VALUES (?, ?)";
        $insertRequestStmt = $conn->prepare($insertRequestSql);

        if (!$insertRequestStmt) {
            die('Error in SQL query: ' . $conn->error);
        }

        $insertRequestStmt->bind_param("ii", $orderId, $productId);
        $insertResult = $insertRequestStmt->execute();
        $insertRequestStmt->close();

        if (!$insertResult) {
            die('Error inserting into store_requests table: ' . $conn->error);
        }
    }

    echo '<p>Product request processed successfully!</p>';
    
    // Redirect to prevent form resubmission
    header('Location: view_order_details.php?order_id=' . $orderId);
    exit();

} else {
    // Fetch order ID from the URL parameter
    if (isset($_GET['order_id'])) {
        $orderId = $_GET['order_id'];

        // Fetch order details from the database
        $orderSql = "SELECT * FROM orders WHERE order_id = $orderId";
        $orderResult = $conn->query($orderSql);

        // Fetch order items related to the order ID
        $orderItemsSql = "SELECT * FROM order_items WHERE order_id = $orderId";
        $orderItemsResult = $conn->query($orderItemsSql);

        // Fetch product details based on the product IDs in order_items
        $productDetails = [];
        while ($orderItem = $orderItemsResult->fetch_assoc()) {
            $productId = $orderItem['product_id'];
            $productSql = "SELECT * FROM products WHERE id = $productId";
            $productResult = $conn->query($productSql);

            if ($productResult->num_rows > 0) {
                $productDetails[] = $productResult->fetch_assoc();
            }
        }
    ?>
    <div class="container">
        <h2>Product Request</h2>
        <?php if ($orderResult->num_rows > 0) : ?>
            <?php while ($order = $orderResult->fetch_assoc()) : ?>
                <div class="orders_det">
                    <label>Order ID:</label>
                    <span><?php echo $order['order_id']; ?></span>
                </div>
            <?php endwhile; ?>
            <h3>Order Items</h3>
            <?php if ($orderItemsResult->num_rows > 0) : ?>
                <form action="view_order_details.php" method="post">
                    <input type="hidden" name="order_id" value="<?php echo $orderId; ?>">
                    <table border="1">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productDetails as $key => $product) : ?>
                                <tr>
                                    <td><?php echo $product['id']; ?></td>
                                    <td><?php echo $product['name']; ?></td>
                                    <td><?php echo $product['quantity']; ?></td>
                                    <td>
                                        <input type="checkbox" name="product_ids[]" value="<?php echo $product['id']; ?>">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="submit">Submit Request</button>
                </form>
            <?php
            else :
                echo '<p>No items found for this order.</p>';
            endif;
        else :
            echo '<div class="orders_det"><p>Order not found.</p></div>';
        endif;
    ?>
    </div>
<?php
}}
include('../includes/admin_footer.php');
?>