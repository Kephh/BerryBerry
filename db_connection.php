<!--db_connection.php-->
<?php

// Define database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'user');
define('DB_PASSWORD', 'password');
define('DB_NAME', 'db_name');

function openDatabaseConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function closeDatabaseConnection($conn) {
    $conn->close();
}
