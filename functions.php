<!--functions.php__
<?php
include_once 'db_connection.php';

function authenticateAdmin($username, $password) {
    $conn = openDatabaseConnection();
    $username = $conn->real_escape_string($username);

    $sql = "SELECT * FROM admin WHERE username = '$username'";
    $result = $conn->query($sql);
    $adminDetails = $result->fetch_assoc();

    if ($adminDetails && password_verify($password, $adminDetails['password'])) {
        return true;
    }

    return false;
}

function getUserDetailsByUsername($username) {
    $conn = openDatabaseConnection();
    $username = $conn->real_escape_string($username);

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    $userDetails = $result->fetch_assoc();
    closeDatabaseConnection($conn);
    return $userDetails;
}

function login($username, $password) {
    // Validate the username and password (this is just a basic example)
    if (isValidCredentials($username, $password)) {
        // Set user information in the session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
            $_SESSION['user'] = [
            'username' => $username,
            // Add more fields as needed
        ];
        // Redirect after setting session variables
        return true; // Ensure the script stops after the redirect
    } else {
        return false; // Invalid credentials
    }
}
function logout() {
    $_SESSION = array();

    session_destroy();
}


function isValidCredentials($username, $password){
    $conn = openDatabaseConnection();
    $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result($dbUsername, $dbPasswordHash);
    
    // Fetch the result
    $stmt->fetch();
    
    // Close the statement and database connection
    $stmt->close();
    $conn->close();
    
    // Check if the provided credentials match the database records
    return ($dbUsername === $username) && password_verify($password, $dbPasswordHash);
}

function isAuthenticated() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
        return isset($_SESSION['user']['username']);
}

function getLoggedInUserId() {
    // Check if the user is authenticated
    if (isAuthenticated()) {
        // Return the user ID from the session
        $username=$_SESSION['user']['username'];
        $user=getUserDetailsByUsername($username);
        return $user['userId'];
    }

    // If not authenticated, return null or another suitable value
    return null;
}

function addUser($imagePath, $username, $password, $email) {

    $imagePath = htmlspecialchars($imagePath);
    $conn = openDatabaseConnection();
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (image, username, password, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $imagePath, $username, $hashedPassword, $email);
    
    if ($stmt->execute()) {
        closeDatabaseConnection($conn);
        return true;
    } else {
        echo "Error: " . $stmt->error;
        closeDatabaseConnection($conn);
        return false;
    }
}

function updateUser($imagePath, $name, $username, $password, $email, $userId) {

    $imagePath = htmlspecialchars($imagePath);
    $conn = openDatabaseConnection();
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET image=?, name=?, password=?, email=?, username=? WHERE userId=?");
    $stmt->bind_param("sssssi", $imagePath, $name, $hashedPassword, $email, $username, $userId);
    
    if ($stmt->execute()) {
        closeDatabaseConnection($conn);
        return true;
    } else {
        echo "Error: " . $stmt->error;
        closeDatabaseConnection($conn);
        return false;
    }
}

function sendFeedback($userId, $feedbackDescription){
    $conn = openDatabaseConnection();
    $userId=$userId;
    $feedbackDescription=$feedbackDescription;

    $stmt = $conn->prepare("INSERT INTO feedback (userId, feedbackDescription) VALUES (?, ?)");
    
    // Bind parameters with the correct data types
    $stmt->bind_param("is", $userId, $feedbackDescription);

    // Execute the statement
    $success = $stmt->execute();

    // Close the statement and database connection
    $stmt->close();
    $conn->close();

}

function searchUsers($searchTerm){
    $conn = openDatabaseConnection();
    $searchTerm = "%$searchTerm%";

    $stmt = $conn->prepare("SELECT * FROM users WHERE username LIKE ? OR name LIKE ?");
    $stmt->bind_param("ss", $searchTerm, $searchTerm);

    // Execute the statement
    $stmt->execute();
    
    // Get the result set
    $result = $stmt->get_result();
    
    // Fetch all rows
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    // Close the statement
    $stmt->close();

    // Close the result set
    $result->close();

    // Close the database connection
    closeDatabaseConnection($conn);

    return $rows;
}

function searchProducts($searchTerm){
    $conn = openDatabaseConnection();
    $searchTerm = "%$searchTerm%";

    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ?");
    $stmt->bind_param("s", $searchTerm);

    // Execute the statement
    $stmt->execute();
    
    // Get the result set
    $result = $stmt->get_result();
    
    // Fetch all rows
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    // Close the statement
    $stmt->close();

    // Close the result set
    $result->close();

    // Close the database connection
    closeDatabaseConnection($conn);

    return $rows;
}


function addProduct($productName, $productDescription, $productPrice, $imagePath) {
    // Sanitize input data to prevent SQL injection
    $productName = htmlspecialchars($productName);
    $productDescription = htmlspecialchars($productDescription);
    $imagePath = htmlspecialchars($imagePath);

    // Connect to the database (implement your own database connection function)
    $conn = openDatabaseConnection();

    // Prepare the SQL statement to insert a new product
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
    
    // Bind parameters with the correct data types
    $stmt->bind_param("ssds", $productName, $productDescription, $productPrice, $imagePath);

    // Execute the statement
    $success = $stmt->execute();

    // Close the statement and database connection
    $stmt->close();
    $conn->close();

    return $success;
}




function updateProduct($productId, $name, $description) {
    $conn = openDatabaseConnection();
    $productId = (int)$productId;
    $name = $conn->real_escape_string($name);
    $description = $conn->real_escape_string($description);

    $sql = "UPDATE products SET name = '$name', description = '$description' WHERE id = $productId";
    $conn->query($sql);
    closeDatabaseConnection($conn);
}

function deleteProduct($productId) {
    $conn = openDatabaseConnection();
    $productId = (int)$productId;

    $sql = "DELETE FROM products WHERE id = $productId";
    $conn->query($sql);
    closeDatabaseConnection($conn);
}

function countProducts() {
    $conn = openDatabaseConnection();
    $sql = "SELECT COUNT(*) as total FROM products";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    closeDatabaseConnection($conn);

    return $row['total'];
}

function getProducts() {
    // Connect to the database
    $conn = openDatabaseConnection();

    // Check the connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare and execute the query
    $query = "SELECT * FROM products";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Fetch products
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Close the database connection
    closeDatabaseConnection($conn);

    return $products;
}

function hasSaved($userId, $productId) {
    $conn = openDatabaseConnection();

    // Validate and sanitize input
    $userId = (int)$userId;
    $productId = (int)$productId;

    // Use prepared statements to prevent SQL injection
    $sqlCheckLike = $conn->prepare("SELECT COUNT(*) as entry FROM cart WHERE userId = ? AND productId = ?");
    $sqlCheckLike->bind_param("ii", $userId, $productId);
    $sqlCheckLike->execute();

    // Fetch the like count
    $result = $sqlCheckLike->get_result();
    $row = $result->fetch_assoc();
    $entries = $row['entry'];

    $sqlCheckLike->close();
    closeDatabaseConnection($conn);

    // Return true if the user has already liked the product, false otherwise
    return ($entries > 0);
}

function addToCart($userId, $productId){
    $conn = openDatabaseConnection();
    
    $productId = (int) $productId;
    $userId = (int) $userId;

    $sqlAdd = $conn->prepare("INSERT INTO cart (userId, productId) VALUES (?, ?)");
    $sqlAdd->bind_param("ii", $userId, $productId);
    $sqlAdd->execute();

    $success = ($sqlAdd->affected_rows > 0);

    $sqlAdd->close();
    closeDatabaseConnection($conn);

    return $success;
}

function removeFromCart($userId, $productId){
    $conn = openDatabaseConnection();
    
    $productId = (int) $productId;
    $userId = (int) $userId;

    $sqlRemove = $conn->prepare("DELETE FROM cart WHERE userId = ? AND productId = ?");
    $sqlRemove->bind_param("ii", $userId, $productId);
    $sqlRemove->execute();

    $success = ($sqlRemove->affected_rows > 0);

    $sqlRemove->close();
    closeDatabaseConnection($conn);

    return $success;
}


function getProductDetailsFromCart($userId) {
    $conn = openDatabaseConnection();
    
    $userId = (int) $userId;

    $sqlAdd = $conn->prepare("SELECT * FROM cart WHERE userId = ?");
    $sqlAdd->bind_param("i", $userId);
    $sqlAdd->execute();

    $result = $sqlAdd->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    $sqlAdd->close();
    $result->close();
    closeDatabaseConnection($conn);

    return $rows;
}


function hasLiked($userId, $productId) {
    $conn = openDatabaseConnection();

    // Validate and sanitize input
    $userId = (int)$userId;
    $productId = (int)$productId;

    // Use prepared statements to prevent SQL injection
    $sqlCheckLike = $conn->prepare("SELECT COUNT(*) as likeCount FROM likes WHERE userId = ? AND productId = ?");
    $sqlCheckLike->bind_param("ii", $userId, $productId);
    $sqlCheckLike->execute();

    // Fetch the like count
    $result = $sqlCheckLike->get_result();
    $row = $result->fetch_assoc();
    $likeCount = $row['likeCount'];

    $sqlCheckLike->close();
    closeDatabaseConnection($conn);

    // Return true if the user has already liked the product, false otherwise
    return ($likeCount > 0);
}



function likeProduct($productId,$userId) {
    $conn = openDatabaseConnection();

    // Validate and sanitize input
    $productId = (int)$productId;

    // Fetch the user ID from the session or wherever it is stored during authentication
    
    // Use prepared statements to prevent SQL injection
    $sqlUpdate = $conn->prepare("UPDATE products SET likes = likes + 1 WHERE productId = ?");
    $sqlUpdate->bind_param("i", $productId);
    $sqlUpdate->execute();

    $sqlUpdateLikes = $conn->prepare("INSERT INTO likes (userId, productId) VALUES (?, ?)");
    $sqlUpdateLikes->bind_param("ii", $userId, $productId);
    $sqlUpdateLikes->execute();

    // Check for success
    if ($sqlUpdate->affected_rows > 0) {
        // Query the updated like count using another prepared statement
        $sqlSelect = $conn->prepare("SELECT likes FROM products WHERE productId = ?");
        $sqlSelect->bind_param("i", $productId);
        $sqlSelect->execute();

        // Fetch the new like count
        $result = $sqlSelect->get_result();
        $row = $result->fetch_assoc();
        $newLikeCount = $row['likes'];

        $sqlUpdate->close();
        $sqlSelect->close();
        closeDatabaseConnection($conn);

        return $newLikeCount;
    } else {
        // Handle update failure
        $sqlUpdate->close();
        closeDatabaseConnection($conn);
        return false;
    }
}

function unlikeProduct($productId,$userId) {
    $conn = openDatabaseConnection();

    // Validate and sanitize input
    $productId = (int)$productId;

    // Fetch the user ID from the session or wherever it is stored during authentication
    
    // Use prepared statements to prevent SQL injection
    $sqlUpdate = $conn->prepare("UPDATE products SET likes = likes - 1 WHERE productId = ?");
    $sqlUpdate->bind_param("i", $productId);
    $sqlUpdate->execute();

    $sqlUpdateLikes = $conn->prepare("DELETE FROM likes WHERE userId = ? AND productId = ?");
    $sqlUpdateLikes->bind_param("ii", $userId, $productId);
    $sqlUpdateLikes->execute();

    // Check for success
    if ($sqlUpdate->affected_rows > 0) {
        // Query the updated like count using another prepared statement
        $sqlSelect = $conn->prepare("SELECT likes FROM products WHERE productId = ?");
        $sqlSelect->bind_param("i", $productId);
        $sqlSelect->execute();

        // Fetch the new like count
        $result = $sqlSelect->get_result();
        $row = $result->fetch_assoc();
        $newLikeCount = $row['likes'];

        $sqlUpdate->close();
        $sqlSelect->close();
        closeDatabaseConnection($conn);

        return $newLikeCount;
    } else {
        // Handle update failure
        $sqlUpdate->close();
        closeDatabaseConnection($conn);
        return false;
    }
}

function getProductDetailsFromLike($userId) {
    $conn = openDatabaseConnection();
    
    $userId = (int) $userId;

    $sqlAdd = $conn->prepare("SELECT * FROM likes WHERE userId = ?");
    $sqlAdd->bind_param("i", $userId);
    $sqlAdd->execute();

    $result = $sqlAdd->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    $sqlAdd->close();
    $result->close();
    closeDatabaseConnection($conn);

    return $rows;
}

function getUserDetails($userId) {
    $conn = openDatabaseConnection();
    $userId = (int)$userId;
    $sql = "SELECT * FROM users WHERE userId = $userId";
    $result = $conn->query($sql);
    $userDetails = $result->fetch_assoc();
    closeDatabaseConnection($conn);
    return $userDetails;
}

function getProductImages($productId) {
    $conn = openDatabaseConnection();
    $productId = (int)$productId;
    $sql = "SELECT * FROM product_images WHERE product_id = $productId";
    $result = $conn->query($sql);
    $images = [];
    while ($row = $result->fetch_assoc()) {
        $images[] = $row['image_path'];
    }
    closeDatabaseConnection($conn);
    return $images;
}

function createOrder($userId, $totalAmount, $productIds, $quantities, $prices) {
    $conn = openDatabaseConnection();
    $userId = (int)$userId;
    $totalAmount = (float)$totalAmount;

    $sql = "INSERT INTO orders (user_id, total_amount) VALUES ($userId, $totalAmount)";
    $conn->query($sql);
    $orderId = $conn->insert_id;

    for ($i = 0; $i < count($productIds); $i++) {
        $productId = (int)$productIds[$i];
        $quantity = (int)$quantities[$i];
        $price = (float)$prices[$i];

        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ($orderId, $productId, $quantity, $price)";
        $conn->query($sql);
    }

    closeDatabaseConnection($conn);

    return $orderId;
}

function getProductDetails($productId) {
    $conn = openDatabaseConnection();
    $productId = (int)$productId;
    $sql = "SELECT * FROM products WHERE productId = $productId";
    $result = $conn->query($sql);
    $productDetails = $result->fetch_assoc();
    closeDatabaseConnection($conn);
    return $productDetails;
}

function getLikesForProduct($productId) {
    $conn = openDatabaseConnection();
    
    // Validate and sanitize input
    $productId = (int)$productId;

    // Use prepared statements to prevent SQL injection
    $sql = $conn->prepare("
    SELECT *
    FROM likes
    INNER JOIN users ON likes.userId = users.userId
    WHERE likes.productId = ?");
    $sql->bind_param("i", $productId);
    $sql->execute();

    $result = $sql->get_result();

    $likes = $result->fetch_all(MYSQLI_ASSOC);

    $sql->close();
    closeDatabaseConnection($conn);

    return $likes;
}


function getComments($productId, $userId) {
    $conn = openDatabaseConnection();
    $productId = (int)$productId;

    $sql = $conn->prepare("SELECT * FROM comments
    INNER JOIN users ON comments.userId = users.userId
    WHERE comments.productId = ? ORDER BY commentId DESC");
    $sql->bind_param("i", $productId);
    $sql->execute();

    $result = $sql->get_result();
    $comments = [];

    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }

    $sql->close();
    closeDatabaseConnection($conn);

    return $comments;
}


function addComment($userId, $productId, $comment) {
    $conn = openDatabaseConnection();

    // Validate and sanitize input
    $productId = mysqli_real_escape_string($conn, $productId);
    $userId = mysqli_real_escape_string($conn, $userId);
    $comment = mysqli_real_escape_string($conn, $comment);
    // Use prepared statements to prevent SQL injection
    $query = "INSERT INTO comments (userId, productId, comment) VALUES ('$userId', '$productId', '$comment')";

    // Execute the query
    mysqli_query($conn, $query);

    // Close the database connection
    closeDatabaseConnection($conn);
}



function editComment($commentId, $newComment) {
    $conn = openDatabaseConnection();
    $commentId = (int)$commentId;
    $newComment = $conn->real_escape_string($newComment);

    $sql = "UPDATE comments SET comment = '$newComment' WHERE id = $commentId";
    $conn->query($sql);
    closeDatabaseConnection($conn);
}

function getCommentDetails($commentId) {
    $conn = openDatabaseConnection();
    $commentId = (int)$commentId;
    $sql = "SELECT * FROM comments WHERE id = $commentId";
    $result = $conn->query($sql);
    $commentDetails = $result->fetch_assoc();
    closeDatabaseConnection($conn);
    return $commentDetails;
}

function deleteComment($commentId) {
    $conn = openDatabaseConnection();
    $commentId = (int)$commentId;

    $sql = "DELETE FROM comments WHERE commentId = $commentId";
    $conn->query($sql);
    closeDatabaseConnection($conn);
}

function checkTable($userId) {
    $conn = openDatabaseConnection();

    try {
        $stmt = $conn->prepare("SELECT * FROM messageTable$userId");

        if ($stmt->execute()) {
            $stmt->close();
            closeDatabaseConnection($conn);
            return true;
        } else {
            $stmt->close();
            closeDatabaseConnection($conn);
            return false;
        }
    } catch (Exception $e) {
        // Handle the exception here (e.g., log the error)
        closeDatabaseConnection($conn);
        return false;
    }
}


function createTable($userId){
    $conn=openDatabaseConnection();
    $stmt = $conn->prepare("CREATE TABLE messageTable$userId (
        messageId INT AUTO_INCREMENT PRIMARY KEY,
        sender INT,
        receiver INT,
        message TEXT,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (sender) REFERENCES users(userId),
        FOREIGN KEY (receiver) REFERENCES users(userId)
    )");

// Bind parameters (if any)
// Since there are no placeholders in this query, there is no need to bind parameters

// Execute the CREATE TABLE statement
if ($stmt->execute()) {
echo "Table created successfully";
} else {
echo "Error creating table: " . $stmt->error;
}

// Close the statement
$stmt->close();
closeDatabaseConnection($conn);
}

function sendMessage($self, $other, $text) {
    $conn = openDatabaseConnection();

    try {
        $stmt = $conn->prepare("INSERT INTO messageTable$self (sender, receiver, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $self, $other, $text);

        $success = $stmt->execute();

        if ($success) {
            $sql = $conn->prepare("INSERT INTO messageTable$other (sender, receiver, message) VALUES (?, ?, ?)");
            $sql->bind_param("iis", $self, $other, $text);

            if (!$sql->execute()) {
                throw new Exception("Error in subquery: " . $sql->error);
            }

            $sql->close();
        } else {
            throw new Exception("Error in main query: " . $stmt->error);
        }

        $stmt->close();
        closeDatabaseConnection($conn);
        return true;
    } catch (Exception $e) {
        // Log the error
        error_log($e->getMessage());

        // Close the connection in case of an error
        if ($conn) {
            $conn->close();
        }

        return false;
    }
}

function getMessageList($self){
    $conn = openDatabaseConnection();

    $stmt = $conn->prepare("SELECT DISTINCT sender, receiver FROM messageTable$self WHERE sender=? OR receiver=? ORDER BY `timestamp` DESC");
    $stmt->bind_param("ii", $self, $self);


    $success = $stmt->execute();
    if ($success) {
        $result = $stmt->get_result();
        $messages = [];

        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }

        $stmt->close();
        closeDatabaseConnection($conn);

        return $messages;
    } else {
        echo "Error: " . $stmt->error;
        closeDatabaseConnection($conn);
        return false;
}

}

function getMessage($self, $other){
    $conn = openDatabaseConnection();

    $stmt = $conn->prepare("SELECT * FROM messageTable$self WHERE sender=? OR receiver=? ORDER BY `timestamp` DESC");
    $stmt->bind_param("ii", $other, $other);


    $success = $stmt->execute();
    if ($success) {
        $result = $stmt->get_result();
        $messages = [];

        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }

        $stmt->close();
        closeDatabaseConnection($conn);

        return $messages;
    } else {
        echo "Error: " . $stmt->error;
        closeDatabaseConnection($conn);
        return false;
}

}

?>
