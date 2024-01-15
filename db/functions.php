<?php
include('config.php'); // Make sure to include your database configuration

function addProduct($productName, $productDescription, $productPrice, $productCategory, $productImageUrl) {
    global $conn;

    // Validate inputs to prevent SQL injection (you may want to use prepared statements)
    $productName = mysqli_real_escape_string($conn, $productName);
    $productDescription = mysqli_real_escape_string($conn, $productDescription);
    $productPrice = mysqli_real_escape_string($conn, $productPrice);
    $productCategory = mysqli_real_escape_string($conn, $productCategory);
    $productImageUrl = mysqli_real_escape_string($conn, $productImageUrl);

    // Implement code to add the product to the database
    $sql = "INSERT INTO products (name, description, price, category, image_url) VALUES ('$productName', '$productDescription', $productPrice, '$productCategory', '$productImageUrl')";

    if ($conn->query($sql) === TRUE) {
        // Product added successfully
        return true;
    } else {
        // Error adding product
        return false;
    }
}



function deleteProduct($productId) {
    global $conn;

    // Validate $productId to prevent SQL injection (you may want to use prepared statements)
    $productId = mysqli_real_escape_string($conn, $productId);

    // Implement code to delete the product from the database
    $sql = "DELETE FROM products WHERE id = $productId";

    if ($conn->query($sql) === TRUE) {
        // Product deleted successfully
        return true;
    } else {
        // Error deleting product
        return false;
    }
}

?>
