<?php
include('../includes/admin_header.php');
include('../db/functions.php');

// Handle product addition logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product_name'];
    $productDescription = $_POST['product_description'];
    $productPrice = $_POST['product_price'];
    $productCategory = $_POST['product_category'];
    $productImageUrl = $_POST['product_image_url'];

    // Call the addProduct function
    $added = addProduct($productName, $productDescription, $productPrice, $productCategory, $productImageUrl);

    if ($added) {
        echo '<div class="success-message">Product added successfully!</div>';
    } else {
        echo '<div class="error-message">Error adding product.</div>';
    }
}
?>

<div class="container">
    <h2>Add Product</h2>
    <form method="post" action="add_product.php">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required>

        <label for="product_description">Product Description:</label>
        <textarea id="product_description" name="product_description" required></textarea>

        <label for="product_price">Product Price:</label>
        <input type="number" id="product_price" name="product_price" step="0.01" required>

        <label for="product_category">Product Category:</label>
        <input type="text" id="product_category" name="product_category" required>

        <label for="product_image_url">Product Image URL:</label>
        <input type="text" id="product_image_url" name="product_image_url" required>

        <button type="submit">Add Product</button>
    </form>
</div>
<?php include('../includes/admin_footer.php');?>
