<!--logout.php-->
<?php
include 'functions.php';

// Check if the user is logged in
if (!isAuthenticated()) {
    header('Location: index.php');
    exit();
}

// Process the logout action
logout();

// Redirect to the main page after logout
header('Location: index.php');
exit();
?>
