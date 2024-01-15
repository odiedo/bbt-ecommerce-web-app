<?php
include('db/config.php');

// Get the q parameter from URL
$q = $_GET["q"];

// Lookup all links from the products table in the database if length of q > 0
if (strlen($q) > 0) {
    $hint = "";
    $sql = "SELECT * FROM products WHERE name LIKE '%$q%' OR description LIKE '%$q%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $hint .= "<div class='search-result'>";
            $hint .= "<p><a href='user/view_product.php?id=" . $row['id'] . "'>" . $row['name'] . "</a></p>";
            $hint .= "</div>";
        }
    }
}
// Set output to "no suggestion" if no hint was found or to the correct values
if ($hint === "") {
    $response = "no suggestion";
} else {
    $response = $hint;
}

// Output the response
$s = '<div class="closeBtn"><i class="fas fa-times-circle" onclick="searchD()"></i></div>';
echo $s;
echo $response;
?>
