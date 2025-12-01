<?php
require "db.php"; // make sure this file connects to MySQL properly

// Check if POST request
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: contact.php");
    exit;
}

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

// Basic validation
if ($name === '' || $email === '' || $message === '') {
    header("Location: contact.php?status=empty");
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: contact.php?status=invalid_email");
    exit;
}

$sql = "INSERT INTO messages (name, email, message) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sss", $name, $email, $message);

if(mysqli_stmt_execute($stmt)){
    header("Location: contact.php?status=success");
    exit;
} else {
    header("Location: contact.php?status=error");
    exit;
}
