<?php
include('../includes/header.php');
include('../db/config.php');

// Assume you have a user ID (replace with your actual user authentication logic)
$userId = 1;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';
    $deliveryMeans = isset($_POST['delivery_means']) ? $_POST['delivery_means'] : '';
    $phoneNumber = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
    $deliveryLocation = isset($_POST['delivery_location']) ? $_POST['delivery_location'] : '';

    // Fetch the user's cart items
    $cartSql = "SELECT products.id, products.price, cart.quantity 
                FROM products
                INNER JOIN cart ON products.id = cart.product_id
                WHERE cart.user_id = $userId";
    $cartResult = $conn->query($cartSql);

    if ($cartResult->num_rows > 0) {
        // Calculate total amount
        $totalAmount = 0;
        while ($cartItem = $cartResult->fetch_assoc()) {
            $totalAmount += ($cartItem['price'] * $cartItem['quantity']);
        }

        // Insert order details into the orders table
        $orderInsertSql = "INSERT INTO orders (user_id, payment_method, delivery_means, phone_number, delivery_location, total_amount) VALUES (?, ?, ?, ?, ?, ?)";
        $orderStmt = $conn->prepare($orderInsertSql);
        $orderStmt->bind_param("issssd", $userId, $paymentMethod, $deliveryMeans, $phoneNumber, $deliveryLocation, $totalAmount);
        $orderStmt->execute();
        $orderId = $orderStmt->insert_id;
        $orderStmt->close();

        // Move cart items to order_items table
        $moveToOrderItemsSql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $moveToOrderItemsStmt = $conn->prepare($moveToOrderItemsSql);

        $cartResult->data_seek(0); // Reset the result set to the beginning
        while ($cartItem = $cartResult->fetch_assoc()) {
            $moveToOrderItemsStmt->bind_param("iiid", $orderId, $cartItem['id'], $cartItem['quantity'], $cartItem['price']);
            $moveToOrderItemsStmt->execute();
        }

        $moveToOrderItemsStmt->close();

        // Clear the user's cart for the selected items
        $selectedProducts = isset($_POST['selected_products']) ? $_POST['selected_products'] : [];
        if (!empty($selectedProducts)) {
            $deleteSelectedSql = "DELETE FROM cart WHERE user_id = $userId AND product_id IN (" . implode(',', $selectedProducts) . ")";
            $conn->query($deleteSelectedSql);
        }

        // Display a confirmation message
        echo '<div class="container">';
        echo '<h2>Order Placed Successfully!</h2>';
        echo '<p>Thank you for shopping with us. Your order has been placed successfully.</p>';
        echo '<p>Order ID: ' . $orderId . '</p>';
        echo '</div>';
    } else {
        echo '<p>Your cart is empty.</p>';
    }
} else {
    // If the form is not submitted, redirect to the checkout page
    header("Location: checkout.php");
    exit();
}

// Close the database connection
$conn->close();
?>
