<!--db_connection.php-->
<?php

// Define database credentials
define('DB_HOST', 'sql203.infinityfree.com');
define('DB_USER', 'if0_35516756');
define('DB_PASSWORD', 'FeoT8QUP7nZ3');
define('DB_NAME', 'if0_35516756_Page');

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
