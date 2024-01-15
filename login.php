<!--login.php-->
<?php
include 'functions.php';

// Check if the user is already logged in
if (isAuthenticated()) {
    //echo "ALREADY";
    header('Location: index.php');
    exit();
}

// Process the login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate username and password (replace this with actual validation)
    if (isValidCredentials($username, $password)) {
        // If validation is successful, call the login function
        login($username, $password);

        $userId=getUserDetailsByUsername($username)['userId'];

        if(!checkTable($userId)){
            createTable($userId);
        }
            header('Location: index.php');
            exit();
    } else {
        // If validation fails, you might want to handle the error (e.g., display a message)
        echo "Invalid username or password";
    }
}

?>
