<?php
include('../db/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['quantity'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Process the request, e.g., store it in the database
    // You can create a separate table to store requests or use an existing one

    // After processing, redirect back to view_order_details.php or a confirmation page
    header("Location: view_order_details.php");
    exit();
} else {
    // Redirect if the form is not submitted properly
    header("Location: view_order_details.php");
    exit();
}


