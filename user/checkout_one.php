<?php
    session_start();
    include('../includes/header.php');
    include('../db/config.php');
    $userId = $_SESSION['id'];

$cartSql = "SELECT products.*, cart.quantity FROM products
            INNER JOIN cart ON products.id = cart.product_id
            WHERE cart.user_id = $userId";
$cartResult = $conn->query($cartSql);

?>

<div class="container">
    <h2>Checkout</h2>

    <?php if ($cartResult->num_rows > 0) : ?>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalAmount = 0;
                while ($cartItem = $cartResult->fetch_assoc()) {
                    $totalAmount += ($cartItem['price'] * $cartItem['quantity']);
                ?>
                    <tr>
                        <td><?php echo $cartItem['name']; ?></td>
                        <td><?php echo $cartItem['quantity']; ?></td>
                        <td>$<?php echo $cartItem['price']; ?></td>
                        <td>$<?php echo $cartItem['price'] * $cartItem['quantity']; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="4">Total Amount:</td>
                    <td>$<?php echo $totalAmount; ?></td>
                </tr>
            </tbody>
        </table>

        <form action="process_order.php" method="post">
            <button type="submit">Proceed to Payment</button>
        </form>
    <?php else : ?>
        <p>Your cart is empty. Add some products <a href="index.php">here</a>.</p>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>
