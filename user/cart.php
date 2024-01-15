<?php
session_start();
include('../includes/header.php');
include('../db/config.php');
$userId = $_SESSION['id'];

$sql = "SELECT products.id, products.name, products.price, products.image_url, cart.quantity
        FROM cart
        INNER JOIN products ON cart.product_id = products.id
        WHERE cart.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<div id="header_top">
    <h2><i class="fas fa-arrow-left" onclick="window.history.back();"></i></h2>
    <h2>Cart <i class="fas fa-shopping-cart"></i> </h2>
</div>

<div class="container">
    <form action="checkout.php" method="post">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="cart-item">';
                echo '<input type="checkbox" name="selected_products[]" value="' . htmlspecialchars($row['id']) . '">';
                echo '<div class="product-img">';
                echo '<img src="' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['name']) . '" class="product-image" loading="lazy">';
                echo '</div>';
                echo '<div class="product-details">';
                echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                echo '<h4>' . htmlspecialchars($row['quantity']) . ' @ kshs. ' . htmlspecialchars($row['price']) .  '</h4> ';
                echo '</div>';
                echo '</div>';
            }

            echo '<div id="checkout">';
            echo '<button type="submit" class="checkout-btn">Proceed to Checkout</button>';
            echo '</div>';
        } else {
            echo '<p>Your cart is empty.</p>';
        }

        $stmt->close();
        ?>
    </form>
</div>

<?php include('../includes/footer.php'); ?>
