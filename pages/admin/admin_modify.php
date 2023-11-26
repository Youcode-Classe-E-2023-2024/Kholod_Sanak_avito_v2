<?php
// Include the TableCreator class
require_once '../../config/tables.php';
require_once '../../config/config.php';

// Create an instance of the TableCreator class
$tableCreator = new TableCreator($conn);

// Check if the form is submitted for modifying a regular user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifyRegularUser'])) {
    // Get form data
    $userIdToModify = $_POST['userIdToModify'];
    $newUsername = $_POST['newUsername'];
    $newEmail = $_POST['newEmail'];
    $newPhone = $_POST['newPhone'];

    // Attempt to modify the regular user
    $modifyUserMessage = $tableCreator->modifyRegularUser($userIdToModify, $newUsername, $newEmail, $newPhone);

    // Output the result
    echo $modifyUserMessage;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="p-8">

<h3 class="mt-8 mb-4 text-xl">Modify User</h3>
<form method="post" action="admin_modify.php">
    <!-- Add form fields for modifying a regular user -->
    <label for="userIdToModify" class="block">User ID to Modify:</label>
    <input type="text" name="userIdToModify" required class="w-full border p-2 mb-2">

    <label for="newUsername" class="block">New Username:</label>
    <input type="text" name="newUsername" required class="w-full border p-2 mb-2">

    <label for="newEmail" class="block">New Email:</label>
    <input type="email" name="newEmail" required class="w-full border p-2 mb-2">

    <label for="newPhone" class="block">New Phone:</label>
    <input type="text" name="newPhone" required class="w-full border p-2 mb-2">

    <input type="submit" name="modifyRegularUser" value="Modify Regular User" class="bg-blue-500 text-white px-4 py-2 rounded">
</form>
<a href="admin_logout.php" class="mt-8 text-blue-500 hover:underline">Logout</a>

<a href="admin_dashboard.php" > Return to dashboard </a>
</body>
</html>

