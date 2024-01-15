<?php
//include 'db_connection.php';
include 'functions.php';
if(isAuthenticated()){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json');

        $action = $_POST['action'];
        $productId = $_POST['productId'];
        $userIdDetails = getUserDetailsByUsername($_SESSION['user']['username']);
        $userId = $userIdDetails['userId'];
        if ($action === 'like') {
            $likeCount = likeProduct($productId, $userId);
            if ($likeCount !== false) {
                echo json_encode(['status' => 'success', 'likeCount' => $likeCount]);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error updating like count.']);
                exit;
            }
        }
    }
    else if (isset($_GET['productId'])) {
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
        if (likeProduct($productId, $userId)) {
        // Redirect back to the product details page
        header("Location: index.php?pageId=1");
        exit();
        } else {
        // Handle the case when addToCart fails (e.g., product or user not found)
        echo 'Error: Failed to like the product.';
        exit();
        }
}
else{
    header('Location: sign_in.php');
    exit();
}

?>
