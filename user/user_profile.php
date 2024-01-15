<?php
session_start();
include('../includes/header.php');
include('../db/config.php');
$userId = $_SESSION['id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
?>
<div id="header_top">
    <h2><?php echo $user['username']; ?></h2>
    <h2><i class="fas fa-arrow-left" onclick="window.history.back();"></i></h2>
</div>
<div class="container" id="user_profile">
    <div class="profile">
        <img src="../includes/img/acc.jpg" alt="user_profile" loading="lazy">
        <!-- <i class="fas fa-user-circle-o"></i> -->
    </div>
    <div class="profile_details" style="display: flex; width: 80%; margin: auto;    margin-bottom: 10px;  justify-content: space-around;">
        <span style="color: white; font-family: serif; font-size: 20px; text-shadow: 9px 1px 9px #000; font-weight: 900"><?php echo $user['username']; ?></span>
        <i class="fas fa-equalizer">Edit</i>
    </div>
    <div class="profile_details">
        <label for="username">Username:</label>
        <span><?php echo $user['username']; ?></span>
    </div>
    <div class="profile_details">
        <label for="email">Email:</label>
        <span><?php echo $user['email']; ?></span>
    </div>
</div>
<div id="points">
    <fieldset>
        <legend>myPoints</legend>
        <div class="buy_points" onclick="boxShow();">
            <p class="buy">
                <h2>400</h2>
                <h6><i>Kshs.</i> 300</h6>
            </p>
            <span>Click to Redeem</span>
        </div>
        <!-- <div class="buy_points" onclick="boxShow();">
            <p class="buy">
                <h2>400</h2>
                <h6><i>Kshs.</i> 300</h6>
            </p>
            <span>Redeem Discounts</span>
        </div> -->
    </fieldset>
</div>

<?php
} else {
    echo '<p>User not found.</p>';
}
include('../includes/footer.php');
?>
