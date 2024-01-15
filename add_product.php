<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = htmlspecialchars($_POST['productName']);
    $productDescription = htmlspecialchars($_POST['description']);
    $productPrice = htmlspecialchars($_POST['price']);

    // Validate product price as a valid number
    if (!is_numeric($productPrice)) {
        echo "Invalid product price.";
        exit();
    }

    // Check if a file was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $targetFolder = 'uploads/';
        $uploadedImagePath = $targetFolder . basename($_FILES['image']['name']);

        // Check file type and size before moving the file
        $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif', 'jfif', 'heif'];
        $maxFileSize = 5 * 1024 * 1024; // 5 MB

        $fileExtension = strtolower(pathinfo($uploadedImagePath, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedFileTypes)) {
            echo "Invalid file type. Allowed types: " . implode(', ', $allowedFileTypes);
            exit();
        }

        if ($_FILES['image']['size'] > $maxFileSize) {
            echo "File size exceeds the maximum limit (5 MB).";
            exit();
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadedImagePath)) {
            // Add the product to the database
            $success = addProduct($productName, $productDescription, $productPrice, $uploadedImagePath);

            if ($success) {
                // Redirect to the product listing page
                header('Location: add_product.php');
                exit();
            } else {
                echo "Error adding product to the database.";
            }
        } else {
            echo "Error uploading image.";
        }
    } else {
        echo "No image uploaded.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>



    <section class="productView-form">
            <h1>Add Products</h1>
            <form action="add_product.php" method="post" enctype="multipart/form-data">
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName" required>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <label for="image"><br>Choose an image:</label>
        <input type="file" name="image" id="image" accept="image/*">

        <button type="submit">Add Product</button>
    </form>

        </section>
		
</div>

</body>
</html>
