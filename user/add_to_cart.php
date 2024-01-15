<?php
session_start();
include('../includes/header.php');
include('../db/config.php');

$userId = $_SESSION['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productId'], $_POST['quantity'])) {
    $productId = $_POST['productId'];
    $quantity = $_POST['quantity'];

    // check if the product is already in the cart
    $checkSql = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param('ii', $userId, $productId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows === 0) {
        // insert into the cart
        $addToCartSql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $addToCartStmt = $conn->prepare($addToCartSql);
        $addToCartStmt->bind_param('iii', $userId, $productId, $quantity);
        $addToCartStmt->execute();
        echo 'Product added to cart successfully.';
    } else {
        echo 'Product is already in the cart. If you want to update the quantity, please go to your cart.';
    }

    $checkStmt->close();
    $addToCartStmt->close();
} else {
    echo 'Invalid request.';
}
?>
