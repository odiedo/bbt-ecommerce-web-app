<?php
include('../includes/admin_header.php');
include('../db/config.php');

// Fetch orders from the database
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
?>

<div class="container">
    <h2>View Orders</h2>

    <?php if ($result->num_rows > 0) : ?>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Order Status</th>
                    <th>Request</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr onclick="window.location.href='view_order_details.php?order_id=<?php echo $row["order_id"]; ?>'">
                        <td><?php echo $row['order_id']; ?></td>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['order_status']; ?></td>
                        <?php 
                            if ($row['order_request'] == 'rq_sent') {
                                echo '<td style="color: orange;">Requested</td>';
                            } elseif ($row['order_request'] == 'received') {
                                echo '<td style="color: blue; ">Received</td>';
                            } else {
                                echo '<td style="color: red;">Pending</td>';
                            }
                        ?>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No orders available.</p>
    <?php endif; ?>
</div>
<?php include('../includes/admin_footer.php');?>