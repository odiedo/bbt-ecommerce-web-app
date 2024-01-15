<?php 
session_start();
include('db/config.php'); 
$userId = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.1/css/all.min.css">
    <script type="text/javascript" src="includes/jquery-3.3.1.min.js"></script>
    <title>BbT </title>
    <script>
    function showResult(str) {
      if (str.length==0) {
        document.getElementById("livesearch").innerHTML="";
        document.getElementById("livesearch").style.border="0px";
        return;
      }
      if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      } else {  // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
          document.getElementById("livesearch").innerHTML=this.responseText;
          document.getElementById("livesearch").style.border="1px solid #A5ACB2";
        }
      }
      xmlhttp.open("GET","search_products.php?q="+str,true);
      xmlhttp.send();
    }
    </script>
</head>
<body>
<header>
    <div id="not_head">
        <div id="not_ad">
            <span>Free Delivery Within Malaba</span>
        </div>
    </div>
    <div id="topNav">
        <div class="logo">
            <img src="includes/img/logo/logo.png">
        </div>
        <form>
            <div class="search" id="searchBox">
                <input type="text" name="search" placeholder="Search..." onkeyup="showResult(this.value); searchA()" onkeydown="searchC()">
                <i class="fas fa-search"></i>
            </div>

        </form>
    </div>   
    <br> 
    <br> 
    <div id="category">
        <h2>Hot Deals</h2>
        <div class="sub_cat">
            <div class="sub_cat_1">
                <img src="includes/img/tv.jpg"><br>
                <span>Televisions</span>
            </div>
            <div class="sub_cat_1">
                <img src="includes/img/acc.jpg"><br>
                <span>Accessories</span>
            </div>
            <div class="sub_cat_1">
                <img src="includes/img/phones.jpg"><br>
                <span>Phones</span>
            </div>
            <div class="sub_cat_1">
                <img src="includes/img/appliances.jpg"><br>
                <span>Appliances</span>
            </div>
            <div class="sub_cat_1">
                <img src="includes/img/computing.jpg"><br>
                <span>Computing</span>
            </div>
            <div class="sub_cat_1">
                <img src="includes/img/baby.jpg"><br>
                <span>Baby Products</span>
            </div>
        </div>
    </div>
</header>
<div id="livesearch">
    <i class="fas fa-times-circle" onclick="searchD()"></i>
</div>
<div class="categories">
    <i class="fas fa-th"></i>
    <span>Phones</span>
    <span>laptops</span>
    <span>School</span>
</div>
<div class="container">
    <div id="products">
        <h2>Products</h2>
        <div class="product_list">
            <?php
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product_card" onclick="window.location.href=\'user/view_product.php?id=' . $row['id'] . '\'">';
                    echo '<div class="product_image"><img src="' . $row['image_url'] . '" alt="' . $row['name'] . '"></div>';
                    echo '<div class="product_desc">';
                    echo '<h3>' . $row['name'] . '</h3>';
                        echo '<h2> Kshs. ' . $row['price'] . '</h2>';
                    echo '<p> <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half"></i></p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No products found.</p>';
            }
            ?>
        </div>
    </div>
    <br>
    <br>
    <br>
</div>

<!-- footer  -->
<footer>
    <div id="btmNav">
        <ul>
            <li><a href="user/user_profile.php" class="fas fa-user"></a></li>
            <li><a href="#" class="fas fa-bomb"></a></li>
            <li><a href="user/inquiries.php" class="fab fa-searchengin"></a></li>
            <li><a href="user/cart.php" class="fas fa-shopping-cart">
                    <span id="cart-count">
                        <?php
                        $cartItemCount = 0;
                        $userId = 1;
                        $cartCountSql = "SELECT COUNT(*) AS itemCount FROM cart WHERE user_id = $userId";
                        $cartCountResult = $conn->query($cartCountSql);

                        if ($cartCountResult && $cartCountResult->num_rows > 0) {
                            $cartCountRow = $cartCountResult->fetch_assoc();
                            $cartItemCount = $cartCountRow['itemCount'];
                        }
                        echo $cartItemCount;
                        ?>
                    </span>
                </a>                
            </li>
            <li><a href="index.php" class="fas fa-home"></a></li>
        </ul>
    </div>
</footer>
<script>
    var searchB = document.getElementById('searchBox');
    var products = document.getElementById('products');
    var cat = document.getElementById('category');
    var livesearch = document.getElementById('livesearch');
    var btmNav = document.getElementById('btmNav');
    function searchA() {
        products.style.display = 'none';
        btmNav.style.display = 'none';
        cat.style.display = 'none';
    }
    function searchC() {
        livesearch.style.display = 'block';
        products.style.display = 'block';
        btmNav.style.display = 'block';
        cat.style.display = 'block';
    }
    function searchD() {
        livesearch.style.display = 'none';
        products.style.display = 'block';
        btmNav.style.display = 'block';
        cat.style.display = 'block';
    }

</script>
</body>
</html>
