<?php

// add_comment.php

include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isAuthenticated()){
    if (isset($_POST['productId']) && isset($_POST['userId']) && isset($_POST['comment'])) {
        $productId = $_POST['productId'];
        $userId = $_POST['userId'];
        $comment = $_POST['comment'];

        // In a real application, you would get the username from the user's session
        // For simplicity, let's assume the username is 'Anonymous'

        // Add the comment to the database
        addComment($userId, $productId, $comment);

        // Redirect back to the comments page
        header("Location: comments.php?productId=$productId&userId=$userId");
        exit();
    } else {
        echo 'Invalid request.';
    }
} else {
    echo 'Invalid request method.';
}}
else{
    echo '<a href="sign_in.php?productId=' . $productId . '" style="text-decoration: none; color: inherit; display: inline-block; overflow: hidden; border-radius: 50%; margin-top: 10px; margin-right: 10px;">';

}
?>
