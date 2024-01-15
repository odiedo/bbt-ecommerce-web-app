<?php
include('../includes/header.php');
include('../db/config.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST["password"]), PASSWORD_DEFAULT);
    $reg_date = date("Y-m-d H-i-s"); 
    $status = 1;
    $points = 0;
    $sql = "INSERT INTO users (username, phone, email, password, points, status, reg_date) VALUES (?, ?, ?, ?, ?, ?, ?)";    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $username, $phone, $email, $password, $points, $status, $reg_date);
    if ($stmt->execute()) {
        echo "<div class='success-message'>User registered successfuly</div>";
        header("location: login.php");
    } else {
        echo '<div class="error-message">Error creating an account. Please try again Later.</div>';
    }

    $stmt->close();
}
$conn->close();
?>

<div class="container">
    <h2>User Registration</h2>
    <form method="post" action="register.php">
        <div class="form_fields">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <br>
        <div class="form_fields">
            <label for="email">Phone:</label>
            <input type="tel" id="phone" name="phone" required>
        </div>
        <br>
        <div class="form_fields">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <br>
        <div class="form_fields">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <br>
        <button type="submit">Register</button>
    </form>
</div>
<div class="reg_footer">
    <span>Beyond Border Trade</span>
    <i>Your Market Freedom</i>
</div>