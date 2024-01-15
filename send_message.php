<?php

include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isAuthenticated()){
    if (isset($_POST['self']) && isset($_POST['other']) && isset($_POST['message'])) {
        $self = $_POST['self'];
        $other = $_POST['other'];
        $message = $_POST['message'];
        $timestamp=time();

        // In a real application, you would get the username from the user's session
        // For simplicity, let's assume the username is 'Anonymous'

        // Add the comment to the database
        sendMessage($self, $other, $message, $timestamp);

        $_SESSION['savedMessage']='';

        // Redirect back to the comments page
        header("Location: messages.php?userId=$other");
        exit();
    } else {
        echo 'Invalid request.';
    }
} else {
    echo 'Invalid request method.';
}}
?>
