<?php
include 'functions.php';

if (isAuthenticated()) {
    if (isset($_GET['productId'])) {
    $productId = $_GET['productId'];
    // Assuming you have a function to validate and sanitize user input
    // It's crucial to validate and sanitize user input to prevent SQL injection
    // In this example, let's assume you have a function called sanitizeInput
    //$productId = sanitizeInput($productId);
    } else {
    // Handle the case when productId is not set in the form
    echo 'Error: Product ID not provided.';
    exit();
    }

    $userIdDetails = getUserDetailsByUsername($_SESSION['user']['username']);
    $userId = $userIdDetails['userId'];

    // Add the product to the cart
    if (addToCart($userId, $productId)) {
    // Redirect back to the product details page
    header("Location: index.php?pageId=1");
    exit();
    } else {
    // Handle the case when addToCart fails (e.g., product or user not found)
    echo 'Error: Failed to add the product to the cart.';
    exit();
    }

    } else {
    header('Location: sign_in.php');
    exit();
}
?>
