<?php
    session_start();
    include('../includes/header.php');
    include('../db/config.php');
    $userId = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedProducts = isset($_POST['selected_products']) ? $_POST['selected_products'] : [];
    $cartSql = "SELECT products.*, products.price, cart.quantity FROM products
                INNER JOIN cart ON products.id = cart.product_id
                WHERE cart.user_id = $userId AND products.id IN (" . implode(',', $selectedProducts) . ")";
    $cartResult = $conn->query($cartSql);
} else {
    $cartSql = "SELECT products.*, products.price, cart.quantity FROM products
                INNER JOIN cart ON products.id = cart.product_id
                WHERE cart.user_id = $userId";
    $cartResult = $conn->query($cartSql);
}

?>
<div id="header_top">
    <h2>Checkout</h2>
    <h2><i class="fas fa-arrow-left" onclick="window.history.back();"></i></h2>
</div>
<div class="container" style="margin-top: 10%">
    <?php if ($cartResult->num_rows > 0) : ?>
        <form action="process_order.php" method="post">
            <div class="order-summary">
                <h3>Order Summary</h3>
                <?php
                $totalAmount = 0;
                while ($cartItem = $cartResult->fetch_assoc()) {
                    $itemTotal = $cartItem['price'] * $cartItem['quantity'];
                    $totalAmount += $itemTotal;
                ?>
                    <div class="order-summary-item">
                        <span><?php echo $cartItem['name']; ?> (<?php echo $cartItem['quantity']; ?>):</span>
                        <i>Kshs. <?php echo $itemTotal; ?></i>
                    </div>
                <?php } ?>
                <div class="order-summary-item">
                    <span>Delivery Fee:</span>
                    <i>Kshs. 50</i>
                </div>
                <div class="order-summary-item total">
                    <span>Total:</span>
                    <i>Kshs. <?php echo $totalAmount + 50; ?></i>
                </div>
            </div>

            <div class="payment_method">
                <div class="payment_method_head">
                    <h3>Payment Method</h3>                    
                </div>
                <div class="payment_method_list">
                    <input type="radio" name="payment_method" value="lipa_na_mpesa" required>
                    <label>Lipa na M-pesa on Delivery</label>
                </div>
                <div class="payment_method_list">
                    <input type="radio" name="payment_method" value="cash_on_delivery" required>
                    <label>Cash on Delivery</label>
                </div>
            </div>

            <div class="customer-address">
                <div class="customer-address-head">
                    <h3>Customer Address</h3>
                    <a href="#">Change</a>
                </div>
                <div class="customer-address-list">
                    | Odiedo | Uplands | Block A and B<br>
                    | +254 759 680 813<br>
                    <input type="text" name="delivery_location" required>
                </div>
            </div>

            <div class="delivery-method">
                <h3>Delivery Method</h3>
                <div class="delivery-method-list">
                    <input type="radio" name="delivery_means" value="door_delivery">
                    <label>Door Delivery</label>
                </div>
                <div class="delivery-method-list">
                    <input type="radio" name="delivery_means" value="pickup_station" disabled>
                    <label style="color: grey; ">Pickup Station</label>
                </div>
            </div>
            
            <div id="checkout">
                <button type="submit" class="checkout-btn">Complete Order</button>
            </div>
        </form>
    <?php else : ?>
        <p>Your cart is empty. Add some products <a href="../index.php">here</a>.</p>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>
