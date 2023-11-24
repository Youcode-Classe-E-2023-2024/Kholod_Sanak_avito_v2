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

// Check if the form is submitted for adding a new product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addProduct'])) {
    // Get form data
    $productName = $_POST['productName'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    // Attempt to add a new product
    $addProductMessage = $tableCreator->addProduct($authenticatedUsername, $productName,$description, $price, $image);
    // Output the result
    echo $addProductMessage;

    // Refresh the product list after adding a product
    /** @var TYPE_NAME $userProducts */
    $userProducts = $tableCreator->getProductsByUser($authenticatedUsername);
    //header('Location: product_dashbord.php');
}

// Check if the form is submitted for modifying a product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifyProduct'])) {
    // Get form data
    $productIdToModify = $_POST['productIdToModify'];
    $newProductName = $_POST['newProductName'];

    // Attempt to modify the product
    $modifyProductMessage = $tableCreator->modifyProduct($productIdToModify, $newProductName);

    // Output the result
    echo $modifyProductMessage;

    // Refresh the product list after modifying a product
    $userProducts = $tableCreator->getProductsByUser($authenticatedUsername);
}

// Check if the form is submitted for deleting a product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteProduct'])) {
    // Get form data
    $productIdToDelete = $_POST['productIdToDelete'];

    // Attempt to delete the product
    $deleteProductMessage = $tableCreator->deleteProduct($productIdToDelete);

    // Output the result
    echo $deleteProductMessage;

    // Refresh the product list after deleting a product
    $userProducts = $tableCreator->getProductsByUser($authenticatedUsername);
}
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
            <li>
                <?php echo $product['product_name']; ?>

                <!-- Add form fields for modifying a product -->
                <form method="post" action="product_dashboard.php">
                    <input type="hidden" name="productIdToModify" value="<?php echo $product['product_id']; ?>">
                    <input type="text" name="newProductName" placeholder="New Product Name" required>
                    <input type="submit" name="modifyProduct" value="Modify">
                </form>

                <!-- Add form fields for deleting a product -->
                <form method="post" action="product_dashboard.php">
                    <input type="hidden" name="productIdToDelete" value="<?php echo $product['product_id']; ?>">
                    <input type="submit" name="deleteProduct" value="Delete">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p>You have no products added yet.</p>
<?php endif; ?>

<!-- Form to add new product -->
<h3>Add New Product:</h3>
<form method="post" action="product_dashboard.php">
    <label for="productName">Product Name:</label>
    <input type="text" name="productName" required><br>

    <label for="description">Description:</label>
    <textarea name="description" required></textarea><br>

    <label for="price">Price:</label>
    <input type="text" name="price" required><br>

    <label for="image">Image:</label>
    <input type="text" name="image"><br>

    <input type="submit" name="addProduct" value="Add Product">
</form>

<!-- Add link/button to modify user details -->
<a href="modify_user.php">Modify User Details</a>

<!-- Add link/button to sign out -->
<a href="logout.php">Log Out</a>
</body>
</html>
