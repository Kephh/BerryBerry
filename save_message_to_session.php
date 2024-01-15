<?php
session_start();

if (isset($_POST['savedMessage'])) {
    $_SESSION['savedMessage'] = $_POST['savedMessage'];
}
?>
