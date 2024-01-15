<?php
include('../includes/header.php');
include('../db/config.php'); // Include your database configuration
?>
<!-- Header Start -->
<header>
    <div id="not_head">
        <span>Free Delivery Within Malaba</span>
    </div>
</header>
<!-- Header End -->
<?php
// Get the product ID from the URL parameter
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Retrieve product details from the database
    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // Get the category of the current product
        $categoryId = $product['category'];

        // Fetch related products from the same category
        $relatedSql = "SELECT * FROM products WHERE category = $categoryId AND id != $productId LIMIT 4";
        $relatedResult = $conn->query($relatedSql);

        // Display the current product
        echo '<div id="product_view">';
        // echo '<div class="pdt"><img src="../includes/img/acc.jpg" alt="product name"></div>';
        echo '<div class="pdt"><img src="' . $product['image_url'] . '" alt="' . $product['name'] . '" load="lazy"></div>';
        echo '<h2><b>' . $product['name'] . '</b> <b style="color: White">kshs. ' . $product['price'] . '</b></h2>';
        echo '<p> <b class="desc">' . $product['description'] . '</b></p>';
        echo '<button onclick="addToCart(' . $product['id'] . ')">Add to Cart</button>';
        echo '</div>';

        // Display related products
        if ($relatedResult->num_rows > 0) {
            echo '<hr><h3>Related Products</h3>';
            echo '<div id="related_products" class="product_list">';
            while ($relatedProduct = $relatedResult->fetch_assoc()) {
                // Display each related product
                echo '<div class="product_card" onclick="window.location.href=\'view_product.php?id=' . $relatedProduct['id'] . '\'">';
                //echo '<div class="product_image"><img src="../includes/img/acc.jpg" alt=" " load="lazy"></div>';
                 echo '<div class="product_image"><img src="' . $relatedProduct['image_url'] . '" alt="' . $relatedProduct['name'] . '" load="lazy"></div>';
                echo '<div class="product_desc">';
                echo '<h3>' . $relatedProduct['name'] . '</h3>';
                echo '<h2> Kshs. ' . $relatedProduct['price'] . '</h2>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        }
        echo "<script>
            function addToCart(productId) {
                // Implement logic to add the product to the cart, e.g., make an AJAX request
                console.log('Product added to cart:', productId);
            }
        </script>";
    } else {
        echo '<p>Product not found.</p>';
    }
} else {
    echo '<p>Invalid product ID.</p>';
}
?>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php include('../includes/footer.php'); ?>
<script>
    function addToCart(productId) {
        // Prompt the user to enter the quantity
        var quantity = prompt('Enter quantity:', '1');

        if (quantity !== null && quantity !== '' && !isNaN(quantity) && parseInt(quantity) > 0) {
            // Implement AJAX logic to add the product to the cart
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log('Product added to cart:', productId, 'Quantity:', quantity);
                        alert('Product added to cart!');

                        // Update the cart count on the bottom navigation
                        updateCartCount();
                    } else {
                        console.error('Failed to add product to cart.');
                    }
                }
            };

            // Adjust the URL and method based on your server-side implementation
            xhr.open('POST', 'add_to_cart.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('productId=' + productId + '&quantity=' + quantity);
        } else {
            alert('Invalid quantity. Please enter a valid number greater than 0.');
        }
    }

    // Function to update the cart count on the bottom navigation
    function updateCartCount() {
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Parse the response to get the current cart count
                    var currentCartCount = parseInt(xhr.responseText);

                    // Update the cart count in the bottom navigation
                    var cartCountElement = document.getElementById('cart-count');
                    if (cartCountElement) {
                        cartCountElement.innerHTML = currentCartCount;
                    }
                } else {
                    console.error('Failed to fetch current cart count.');
                }
            }
        };

        // Adjust the URL and method based on your server-side implementation
        xhr.open('GET', 'get_cart_count.php', true);
        xhr.send();
    }
</script>

