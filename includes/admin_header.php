<!-- admin_header.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BbT::a-Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.1/css/all.min.css">
</head>
<body>

<!-- Admin Navigation Menu -->
<nav id="admin_nav">
    <ul>
        <li><span class="nav_top">Manage</span></li>
        <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
        <li><a href="products.php"><i class="fas fa-tags"></i> <span>Products</span></a></li>
        <!-- <li><a href="add_product.php"><i class="fas fa-plus-square"></i> <span>Add Product</span></a></li>
        <li><a href="delete_product.php"><i class="fas fa-trash-alt"></i> <span>Delete Product</span></a></li>
        <li><a href="manage_categories.php"><i class="fas fa-cogs"></i> <span>Manage Categories</span></a></li> -->
    </ul>
    <ul>
        <li><span class="nav_top">Orders</span></li>
        <li><a href="view_orders.php"><i class="fas fa-hourglass"></i><span>View Orders</span> </a></li>
        <li><a href="process_orders.php"><i class="fas fa-check-square"></i><span>Process Orders</span> </a></li>
    </ul>
    <ul>
        <li><span class="nav_top">Inquiries</span></li>
        <li><a href="view_inquiries.php"><i class="fas fa-envelope"></i><span>View Inquiries</span> </a></li>
        <li><a href="respond_inquiries.php"><i class="fas fa-reply"></i><span>Respond to Inquiries</span>  </a></li>
    </ul>
</nav>
<!-- Admin Content -->
<div id="admin_content">
