<?php
include('../includes/admin_header.php');
include('../db/config.php');

// Assume you have a user ID (replace with your actual user authentication logic)
$userId = 1;

// Fetch all categories
$categoriesSql = "SELECT * FROM categories";
$categoriesResult = $conn->query($categoriesSql);

?>

<div class="container">
    <h2>Product Categories</h2>
    <div id="category-list">
        <?php
        if ($categoriesResult->num_rows > 0) {
            while ($category = $categoriesResult->fetch_assoc()) {
                echo '<a href="products.php?category=' . $category['id'] . '">' . $category['name'] . '</a> <br>';
            }
        } else {
            echo '<p>No categories found.</p>';
        }
        ?>
    </div>

    <?php
    if (isset($_GET['category'])) {
        $categoryId = $_GET['category'];

        // Fetch products for the selected category
        $productsSql = "SELECT * FROM products WHERE category_id = $categoryId";
        $productsResult = $conn->query($productsSql);

        if ($productsResult->num_rows > 0) {
            echo '<div id="product-list">';
            while ($product = $productsResult->fetch_assoc()) {
                echo '<div class="product-item">';
                echo '<h3>' . $product['name'] . '</h3>';
                echo '<p>Price: Kshs. ' . $product['price'] . '</p>';
                // Add more product details as needed
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>No products found in this category.</p>';
        }
    }
    ?>

</div>

