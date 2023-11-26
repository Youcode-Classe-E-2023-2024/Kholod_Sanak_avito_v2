<?php

session_start();

// Include the TableCreator class
require_once '../../config/tables.php';
require_once '../../config/config.php';

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


/// Check if the form is submitted for modifying a product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifyProduct'])) {
    // Get form data
    $productIdToModify = $_POST['productIdToModify'];
    $newProductName = $_POST['newProductName'];
    $newDescription = $_POST['newDescription'];
    $newPrice = $_POST['newPrice'];
    $newImage = $_POST['newImage'];



    // Attempt to modify the product
    $modifyProductMessage = $tableCreator->modifyProduct(
        $productIdToModify,
        $newProductName,
        $newDescription,
        $newPrice,
        $newImage
    );

    // Output the result
    echo $modifyProductMessage;

    // Refresh the product list after modifying a product
    $userProducts = $tableCreator->getProductsByUser($authenticatedUsername);

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Display</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">

    <h3 class="text-xl mt-4">Modify Product:</h3>

<!-- form fields for modifying a product -->
    <form method="post" action="modify_product.php">
        <input type="hidden" name="productIdToModify" value="<?php echo $product['product_id']; ?>">
        <input type="text" name="newProductName" placeholder="New Product Name" required class="mr-2 px-2 py-1 border rounded">
        <textarea name="newDescription" placeholder="New Description" required class="mr-2 px-2 py-1 border rounded"></textarea>
        <input type="text" name="newPrice" placeholder="New Price" required class="mr-2 px-2 py-1 border rounded">
        <input type="text" name="newImage" placeholder="New Image" class="mr-2 px-2 py-1 border rounded">
        <input type="submit" name="modifyProduct" value="Modify" class="bg-blue-500 text-white px-4 py-2 rounded">
    </form>
    <a href="product_dashboard.php" > Return to dashboard </a>

</body>
</html>