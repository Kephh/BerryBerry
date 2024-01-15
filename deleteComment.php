<?php
include 'functions.php';

if (isset($_GET['commentId'])) {
    $commentId = $_GET['commentId'];
    $userId = $_GET['userId'];
    $productId = $_GET['productId'];


    // Delete the comment
    deleteComment($commentId);

    // Redirect back to the comments page
    header("Location: comments.php?productId=$productId&userId=$userId");
    exit();
} else {
    echo 'Invalid request.';
}
?>
