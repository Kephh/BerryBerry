<!--db_connection.php-->
<?php

// Define database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'kephh');
define('DB_PASSWORD', 'kkkk');
define('DB_NAME', 'test');

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
