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

    // Create an instance of the TableCreator class
    $tableCreator = new TableCreator($conn);

    // Attempt to authenticate the user
    $authenticated = $tableCreator->authenticateUser($username, $password);

    // Check if the authentication was successful
    if ($authenticated) {
        // Set user data in the session (you can adjust this based on your needs)
        $_SESSION['username'] = $username;

        // Redirect the user to a new page or perform any other actions
        header('Location: product_dashboard.php');
        exit();
    } else {
        // Authentication failed, display an error message
        echo "Invalid username or password.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
</head>
<body>
<h2>Sign In</h2>
<form method="post" action="signin.php">
    <label for="username">Username:</label>
    <input type="text" name="username" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br>

    <input type="submit" value="Sign In">
</form>
</body>
</html>
