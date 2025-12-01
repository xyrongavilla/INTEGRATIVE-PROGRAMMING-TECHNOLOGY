<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Contact Us</title>
<style>
    body { font-family: Arial; max-width: 600px; margin: 40px auto; }
    input, textarea { width: 100%; padding: 10px; margin-bottom: 10px; }
    button { padding: 10px 15px; cursor: pointer; }
    .msg { padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    .success { background:#d4ffd4; border:1px solid #5cb85c; }
    .error { background:#ffd4d4; border:1px solid #d9534f; }
</style>
</head>
<body>

<h2>Contact Us</h2>

<?php
if (isset($_GET['status'])) {
    if ($_GET['status'] === 'success') {
        echo "<div class='msg success'>Message sent successfully!</div>";
    } elseif ($_GET['status'] === 'error') {
        echo "<div class='msg error'>Error saving message.</div>";
    } elseif ($_GET['status'] === 'empty') {
        echo "<div class='msg error'>Please fill in all fields.</div>";
    } elseif ($_GET['status'] === 'invalid_email') {
        echo "<div class='msg error'>Invalid email address.</div>";
    }
}
?>

<form action="contact_process.php" method="POST">
    <input type="text" name="name" placeholder="Your Name" required>

    <input type="email" name="email" placeholder="Your Email" required>

    <textarea name="message" rows="5" placeholder="Your Message" required></textarea>

    <button type="submit">Send</button>
</form>

</body>
</html>
