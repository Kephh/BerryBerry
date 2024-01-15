<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Likes</title>
    <style>
        .like{
            margin-top: 50px;
            margin-left: 800px;
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
            include 'functions.php';
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
    <div class="like">
    <?php

    $productId = $_GET['productId'];
    //echo 'Product ID: ' . $productId;
    
    // Fetch likes for the current productId
    $likes = getLikesForProduct($productId);    
    echo '<h2>People who liked : </h2>';
    echo '<br><br>';
    echo '<div class="user-details" style="display: flex; align-items: center;">';

    if (!empty($likes)) {
        foreach ($likes as $like) {
            echo '<a href="profile.php?userId=' . $like['userId'] . '" style="text-decoration: none; color: inherit; display: inline-block; overflow: hidden; border-radius: 50%; margin-top: 10px; margin-right: 10px;">';
            echo "<img src='{$like['image']}' alt='{$like['name']}' style='width: 50px; height: 50px; border-radius: 50%;'>";
            echo '</a>';

            echo '<a href="profile.php?userId=' . $like['userId'] . '" target="_blank" style="text-decoration: none; color: inherit;">';
            echo $like['username'] ;
            echo '</a>';
        }
    } else {
        echo 'No likes for this product yet.';
    }
    echo '</div>';
    ?>
</div>
</body>
</html>