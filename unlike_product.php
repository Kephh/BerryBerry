<?php
// include 'db_connection.php';
include 'functions.php';

if (isAuthenticated()) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json');

        $action = $_POST['action'];
        $productId = $_POST['productId'];
        $userIdDetails = getUserDetailsByUsername($_SESSION['user']['username']);
        $userId = $userIdDetails['userId'];

        if ($action === 'unlike') {
            $likeCount = unlikeProduct($productId, $userId);
            if ($likeCount !== false) {
                echo json_encode(['status' => 'success', 'likeCount' => $likeCount]);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error updating like count.']);
                exit;
            }
        }
    } else if (isset($_GET['productId'])) {
        $productId = $_GET['productId'];
    } else {
        // Handle the case when productId is not set in the form
        echo 'Error: Product ID not provided.';
        exit();
    }
    $userIdDetails = getUserDetailsByUsername($_SESSION['user']['username']);
    $userId = $userIdDetails['userId'];
    // Delete the comment
    if (unlikeProduct($productId, $userId)) {
        // Redirect back to the index page
        header("Location: index.php?pageId=1");
        exit();
    } else {
        // Handle the case when addToCart fails (e.g., product or user not found)
        header("Location: index.php?pageId=1");
        exit();
    }
}
