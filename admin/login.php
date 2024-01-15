<div class="container">
    <h2>Admin Login</h2>

    <?php
    // Handle login logic here, check credentials, etc.
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Implement your login logic here, check credentials in the database
        // For simplicity, let's assume a static admin username and password
        $adminUsername = 'admin';
        $adminPassword = 'admin123';

        if ($username === $adminUsername && $password === $adminPassword) {
            // Successful login
            header("Location: dashboard.php");
        } else {
            // Failed login
            echo '<p>Login failed. Please check your username and password.</p>';
        }
    }
    ?>

    <form method="post" action="login.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>
