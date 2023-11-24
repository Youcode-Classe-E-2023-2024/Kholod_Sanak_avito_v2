<?php
session_start();

// Include the TableCreator class
require_once '../config/tables.php';
require_once '../config/config.php';


// Create an instance of the TableCreator class
$tableCreator = new TableCreator($conn);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['signin'])) {
        // Get form data
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Attempt to authenticate the admin user
        $authenticated = $tableCreator->authenticateAdmin($username, $password);

        if ($authenticated) {
            // Successful signin, you can redirect to a dashboard or perform other actions
            //echo "Admin Signin successful!";
            header('Location: admin_dashboard.php');
            exit();
        } else {
            // Failed signin, display an error message
            echo "Invalid username or password.";
        }
    }
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
<h2>Admin Signin</h2>
<form method="post" action="admin_signin.php">
    <label for="username">Username:</label>
    <input type="text" name="username" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br>

    <input type="submit" name="signin" value="Sign In">
</form>
</body>
</html>

