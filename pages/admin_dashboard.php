<?php
// Include the TableCreator class
require_once '../config/tables.php';
require_once '../config/config.php';

// Create an instance of the TableCreator class
$tableCreator = new TableCreator($conn);

// Check if the form is submitted for adding a new regular user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addRegularUser'])) {
    // Get form data
    $newUsername = $_POST['newUsername'];
    $newEmail = $_POST['newEmail'];
    $newPassword = $_POST['newPassword'];
    $newPhone = $_POST['newPhone'];

    // Attempt to add a new regular user
    $addUserMessage = $tableCreator->addRegularUser($newUsername, $newEmail, $newPassword, $newPhone);

    // Output the result
    echo $addUserMessage;
}

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

// Check if the form is submitted for deleting a regular user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteRegularUser'])) {
    // Get form data
    $userIdToDelete = $_POST['userIdToDelete'];

    // Attempt to delete the regular user
    $deleteUserMessage = $tableCreator->deleteRegularUser($userIdToDelete);

    // Output the result
    echo $deleteUserMessage;
}

// Get regular users with product counts
$regularUsersWithCounts = $tableCreator->getRegularUsersWithProductCounts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
<h2>Admin Dashboard</h2>

<!-- Display regular users with product counts -->
<table border="1">
    <tr>
        <th>Username</th>
        <th>Product Count</th>
    </tr>
    <?php foreach ($regularUsersWithCounts as $user): ?>
        <tr>
            <td><?= $user['username']; ?></td>
            <td><?= $user['product_count']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h3>Add New Regular User</h3>
<form method="post" action="admin_dashboard.php">
    <!-- Add form fields for new regular user -->
    <label for="newUsername">Username:</label>
    <input type="text" name="newUsername" required><br>

    <label for="newEmail">Email:</label>
    <input type="email" name="newEmail" required><br>

    <label for="newPassword">Password:</label>
    <input type="password" name="newPassword" required><br>

    <label for="newPhone">Phone:</label>
    <input type="text" name="newPhone" required><br>

    <input type="submit" name="addRegularUser" value="Add Regular User">
</form>

<h3>Modify Regular User</h3>
<form method="post" action="admin_dashboard.php">
    <!-- Add form fields for modifying a regular user -->
    <label for="userIdToModify">User ID to Modify:</label>
    <input type="text" name="userIdToModify" required><br>

    <label for="newUsername">New Username:</label>
    <input type="text" name="newUsername" required><br>

    <label for="newEmail">New Email:</label>
    <input type="email" name="newEmail" required><br>

    <label for="newPhone">New Phone:</label>
    <input type="text" name="newPhone" required><br>

    <input type="submit" name="modifyRegularUser" value="Modify Regular User">
</form>

<h3>Delete Regular User</h3>
<form method="post" action="admin_dashboard.php">
    <!-- Add form fields for deleting a regular user -->
    <label for="userIdToDelete">User ID to Delete:</label>
    <input type="text" name="userIdToDelete" required><br>

    <input type="submit" name="deleteRegularUser" value="Delete Regular User">
</form>
</body>
</html>
