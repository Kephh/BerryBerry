<!--auth.php-->
<?php

session_start();

function isAuthenticated() {
    return isset($_SESSION['user']);
}

if (!isAuthenticated()) {
    header('Location: login.php');
    exit();
}
?>
