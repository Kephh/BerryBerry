<?php
// Assume that you have a function to check if the user is authenticated
// and another function to get user details by userId
include 'functions.php';

// Check if the user is authenticated
if (!isAuthenticated()) {
    // Redirect to login page if not authenticated
    header('Location: sign_in.php');
    exit();
}

// Get logged-in user details
$loggedInUserId = getLoggedInUserId();
$loggedInUserDetails = getUserDetails($loggedInUserId);


// Check if userId is set in the URL
if (isset($_GET['userId'])) {
    $profileUserId = htmlspecialchars($_GET['userId']);
    $profileUserDetails = getUserDetails($profileUserId);
    
    // Check if the logged-in user is viewing their own profile
    $isOwnProfile = $loggedInUserId == $profileUserId;

} else {
    // Redirect to an error page or handle the situation where userId is not set
    header('Location: error.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title><?php echo $profileUserDetails['username']; ?>'s Profile</title>
    
    <style>
        body {
            display: flex;
            flex-direction: column;
        }

        main {
            display: flex;
            width: 80%; /* You can adjust this width as needed */
            margin-top: 20px;
        }

        
    </style>

</head>
<body>

<header>
        <div class="logo">
            <a href="index.php"><img src="image\d3361aa9-dc32-4045-a24e-76aa01a5e9bf.jpeg" alt="Berry Berry "></a>
        </div>
        <div class="search-bar">
            <form action="search.php" method="post">
            <input type="text" id="searchTerm" name="searchTerm" required placeholder="Search Here">
            <button>Search</button>
            </form>
        </div>
        
        <div class="user-options" style="display: flex; align-items: center;">
            <?php
            if (isAuthenticated()) {
                $userIdDetails = getUserDetailsByUsername($_SESSION['user']['username']);
                $userId = $userIdDetails['userId'];
                echo '<a href="profile.php?userId=' . $userId . '" style="text-decoration: none; color: inherit; display: inline-block; overflow: hidden; border-radius: 50%; margin-top: 10px; margin-right: 10px;">';
                echo "<img src='{$userIdDetails['image']}' alt='Profile' style='width: 50px; height: 50px; border-radius: 50%;'>";
                echo '</a>';}
            
                echo '<a href="index.php" style="margin-right: 10px;">Home</a>';
                if (isAuthenticated()) {
                    echo '<a href="viewMessages.php?userId=' . $userId . '">Messages</a>';
                    echo '<a href="contactUs.php?userId=' . $userId . '">Reach us</a>';
                }
            
            if (isAuthenticated()) {
                $userIdDetails = getUserDetailsByUsername($_SESSION['user']['username']);
                $userId = $userIdDetails['userId'];
                
                echo '<a href="cart.php?userId=' . $userId . '" target="_blank" style="text-decoration: none; color: inherit;">';
                echo 'Eye-Catcher';
                echo '</a>';
                
                echo "<a href=\"logout.php\"> Log out</a>";
            }
            else{
                echo "<a href=\"sign_in.php\"> Sign in</a>";   
            }
            ?>
    </div>
</header>
        
        <main style="display: flex;">
            <section class="profile-info">
                <div class="profile-photo">
                    <img src="<?php echo $profileUserDetails['image']; ?>" alt="Profile Photo">
                </div>
                
                <!-- Add more profile details as needed -->
        </section>
        <div class="profile-details">
            <?php
                echo '<h1>' . $profileUserDetails['username'] . '\'s Profile</h1>';
                if($profileUserDetails['name'])
                echo '<p>Name: ' . $profileUserDetails['name'] . '</p>';
            if($isOwnProfile)
                echo '<p><a href="editProfile.php?userId=' . $userId . ' " style="text-decoration: none; color: inherit; display: inline-block; overflow: hidden; margin-top: 10px; margin-right: 10px;">Edit Profile</a></p>';
                ?>
        <section class="profile-actions">
            <?php if ($isOwnProfile): ?>
                <!-- Display options for the logged-in user's own profile -->
                <a href="cart.php?userId=<?php echo $loggedInUserId; ?>">Eye-Catcher</a>
                <a href="liked_products.php?userId=<?php echo $profileUserId; ?>">Show Liked Products</a>
            <?php else: ?>
                <!-- Display options for viewing another user's profile -->
                <a href="messages.php?userId=<?php echo $profileUserId; ?>">Send Message</a>
            <?php endif; ?>
        </section>
            </div>
    </main>

</body>
</html>
