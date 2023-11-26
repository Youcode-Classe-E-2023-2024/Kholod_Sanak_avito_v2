<?php

session_start();

// Include the TableCreator class
require_once '../../config/tables.php';
require_once '../../config/config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

    // Create an instance of the TableCreator class
    $tableCreator = new TableCreator($conn);

    // Attempt to create a regular user
    $message = $tableCreator->createRegularUser($username, $email, $password, $phone);

    // Check if the user was created successfully
    if (strpos($message, "successfully") !== false) {
        // Set user data in the session (you can adjust this based on your needs)
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;

        // Redirect the user to a new page or perform any other actions
        header('Location: signin.php');
        exit();
    } else {
        // Output the result
        echo $message;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
<h2>Sign Up</h2>
<form method="post" action="signup.php">
    <label for="username">Username:</label>
    <input type="text" name="username" required><br>

    <label for="email">Email:</label>
    <input type="email" name="email" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br>

    <label for="phone">Phone:</label>
    <input type="text" name="phone" required><br>

    <input type="submit" value="Sign Up">
</form>
</body>
</html>
