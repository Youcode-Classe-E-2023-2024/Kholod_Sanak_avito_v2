<?php
session_start();

// Include the TableCreator class
require_once '../config/tables.php';
require_once '../config/config.php';

// Check if the user is authenticated
if (!isset($_SESSION['username'])) {
    // If not authenticated, redirect to the sign-in page
    header('Location: signin.php');
    exit();
}

// Get the authenticated username
$authenticatedUsername = $_SESSION['username'];

// Create an instance of the TableCreator class
$tableCreator = new TableCreator($conn);

// Get products associated with the authenticated user
$userProducts = $tableCreator->getProductsByUser($authenticatedUsername);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Display</title>
</head>
<body>
<h2>Welcome, <?php echo $authenticatedUsername; ?>!</h2>

<?php if (!empty($userProducts)) : ?>
    <h3>Your Products:</h3>
    <ul>
        <?php foreach ($userProducts as $product) : ?>
            <li><?php echo $product['product_name']; ?></li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p>You have no products added yet.</p>
<?php endif; ?>

<!-- Add link/button to add new product -->
<a href="add_product.php">Add New Product</a>

<!-- Add link/button to modify user details -->
<a href="modify_user.php">Modify User Details</a>

<!-- Add link/button to sign out -->
<a href="logout.php">Log Out</a>
</body>
</html>
