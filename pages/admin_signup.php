<?php
session_start();

// Include the TableCreator class
require_once '../config/tables.php';
require_once '../config/config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];


    // Create an instance of the TableCreator class
    $tableCreator = new TableCreator($conn);

    // Determine which form was submitted (signup or signin)
    if (isset($_POST['signup'])) {
        // Attempt to create an admin user
        $message = $tableCreator->addAdmin($username, $email, $password, $phone);
        echo $message;
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup and Signin</title>
</head>
<body>
<h2>Admin Signup</h2>
<form method="post" action="admin_signup.php">
    <label for="username">Username:</label>
    <input type="text" name="username" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br>

    <label for="email">Email:</label>
    <input type="email" name="email" required><br>

    <label for="phone">Phone:</label>
    <input type="tel" name="phone" required><br>

    <input type="submit" name="signup" value="Sign Up">
</form>

