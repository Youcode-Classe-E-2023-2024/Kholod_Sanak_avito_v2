<?php
session_start();

// Include the TableCreator class
require_once '../config/tables.php';
require_once '../config/config.php';

// Create an instance of the TableCreator class
$tableCreator = new TableCreator($conn);

// Get the list of regular users
$regularUsers = $tableCreator->getRegularUsers(); // Assuming you have a method to retrieve regular users

// Display the list of regular users
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
<h2>Welcome, Admin!</h2>

<h3>List of Regular Users:</h3>
<ul>
    <?php foreach ($regularUsers as $user): ?>
        <li><?php echo $user['username']; ?></li>
    <?php endforeach; ?>
</ul>

<p><a href="logout.php">Logout</a></p>
</body>
</html>

