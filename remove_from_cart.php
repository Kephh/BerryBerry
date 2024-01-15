<?php
include 'functions.php';
if(isAuthenticated()){
    if (isset($_GET['productId'])) {
    $productId = $_GET['productId'];

    }else {
        // Handle the case when productId is not set in the form
        echo 'Error: Product ID not provided.';
        exit();
    }
    
    $userIdDetails = getUserDetailsByUsername($_SESSION['user']['username']);
    $userId = $userIdDetails['userId'];
    // Delete the comment
    if(removeFromCart($userId, $productId)){

    // Redirect back to the comments page
    header("Location: index.php?pageId=1");
    exit();
    }
}
else{
    header('Location: sign_in.php');
    exit();
}
?>
