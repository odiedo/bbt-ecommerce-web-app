    <footer>
        <div id="btmNav">
            <ul>
                <li><a href="user_profile.php" class="fas fa-user"></a></li>
                <li><a href="checkout.php" class="fas fa-bomb"></a></li>
                <li><a href="inquiries.php" class="fab fa-searchengin"></a></li>
                <li>
                    <a href="cart.php" class="fas fa-shopping-cart">
                        <span id="cart-count">
                            <?php
                            $cartItemCount = 0;
                            $userId = $_SESSION['id'];
                            $cartCountSql = "SELECT COUNT(*) AS itemCount FROM cart WHERE user_id = $userId";
                            $cartCountResult = $conn->query($cartCountSql);
                            if ($cartCountResult && $cartCountResult->num_rows > 0) {
                                $cartCountRow = $cartCountResult->fetch_assoc();
                                $cartItemCount = $cartCountRow['itemCount'];
                            }

                            echo $cartItemCount;?>
                        </span>
                    </a>
                </li>
                <li><a href="../index.php" class="fas fa-home"></a></li>
            </ul>
        </div>
    </footer>
</body>
</html>
