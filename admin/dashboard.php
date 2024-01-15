<?php 
include('../includes/admin_header.php');
?>

<div class="container">
    <h2>Admin Dashboard</h2>

    <div>
        <h3>Manage Products</h3>
        <p><a href="add_product.php">Add Product</a></p>
        <p><a href="delete_product.php">Delete Product</a></p>
        <p><a href="manage_categories.php">Manage Categories</a></p>
    </div>

    <div>
        <h3>Orders</h3>
        <p><a href="view_orders.php">View Orders</a></p>
        <p><a href="process_orders.php">Process Orders</a></p>
    </div>

    <div>
        <h3>Customer Inquiries</h3>
        <p><a href="view_inquiries.php">View Inquiries</a></p>
        <p><a href="respond_inquiries.php">Respond to Inquiries</a></p>
    </div>

    <!-- Add more sections as needed -->

</div>
<?php include('../includes/admin_footer.php');?>