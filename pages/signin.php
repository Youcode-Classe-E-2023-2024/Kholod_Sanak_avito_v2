<?php
session_start();

// Check if the user is already logged in, redirect to display_products.php
if (isset($_SESSION["user_id"])) {
    header("Location: display_products.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Perform user authentication (add your database logic here)

    // Assuming authentication is successful, set user_id in session
    $_SESSION["user_id"] = 1; // Replace with the actual user ID from your database

    // Redirect to display_products.php after successful login
    header("Location: display_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signin</title>
</head>
<body>
<h2>Signin</h2>
<form method="post" action="">
    <label for="username">Username:</label>
    <input type="text" name="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" required>
    <br>
    <input type="submit" value="Signin">
</form>
</body>
</html>
