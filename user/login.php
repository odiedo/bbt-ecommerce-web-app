<?php
include('../includes/header.php');
include('../db/config.php');

// Start the session
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE phone = ?");
    $stmt->bind_param('s', $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        if (password_verify($password, $hashedPassword)) {
            // Set session variables
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            echo '<div class="success-message">You are now logged in!</div>';
            header("Location: ../index.php");
            exit(); // Ensure no further code is executed after redirection
        } else {
            echo '<div class="error-message">Incorrect password. Please try again.</div>';
        }
    } else {
        echo '<div class="error-message">User not found. Please check your phone number.</div>';
    }
}
?>

<div class="container">
    <h2>User Login</h2>

    <!-- User Login Form -->
    <form method="post" action="login.php">
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>
