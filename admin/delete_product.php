<?php include('../includes/admin_header.php'); ?>

<div class="container">
    <h2>Delete Product</h2>

    <?php
    // Handle product deletion logic here
    include('../db/functions.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productId = $_POST['product_id'];

        // Call the deleteProduct function
        $deleted = deleteProduct($productId);

        if ($deleted) {
            echo '<p>Product deleted successfully!</p>';
        } else {
            echo '<p>Error deleting product.</p>';
        }
    }
    ?>

    <form method="post" action="delete_product.php">
        <label for="product_id">Product ID:</label>
        <input type="number" id="product_id" name="product_id" required>

        <button type="submit">Delete Product</button>
    </form>
</div>