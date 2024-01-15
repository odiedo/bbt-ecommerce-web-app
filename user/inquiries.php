<?php
    session_start();
    include('../includes/header.php');
    include('../db/config.php');
    $userId = $_SESSION['id'];
?>

<div class="container">
    <h2>Your Inquiries</h2>

    <?php
    $stmt = $conn->prepare("SELECT * FROM inquiries WHERE user_id = ? ");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="inquiry">';
            echo '<h3>Subject: ' . $row['subject'] . '</h3>';
            echo '<p>Message: ' . $row['message'] . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>You have not made any inquiries yet.</p>';
    }
    ?>

    <h2>Make an Inquiry</h2>
    <form method="post" action="process_inquiry.php">
        <div class="form_fields">
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required>
        </div>
        <div class="form_fields">
            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>
        </div>
        <button type="submit">Submit Inquiry</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>
