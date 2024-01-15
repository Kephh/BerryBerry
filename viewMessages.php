<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Messages</title>
    <style>
        .like {
            margin-top: 50px;
            margin-left: 800px;
        }

        .user-details {
            display: block;
            text-align: left;
        }

        .user-details img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .user-details a {
            text-decoration: none;
            color: inherit;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination a {
            text-decoration: none;
            color: #007BFF;
            margin: 0 8px;
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
        $userIdDetails = getUserDetailsByUsername($_SESSION['user']['username']);
        $userId = $userIdDetails['userId'];

        // Fetch likes for the current productId
        $itemsPerPage = 5; // Set the number of items per page
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $item = getMessageList($userId);

        // Pagination calculation
        $totalItems = count($item);
        $totalPages = ceil($totalItems / $itemsPerPage);
        $startIndex = ($currentPage - 1) * $itemsPerPage;
        $itemsToShow = array_slice($item, $startIndex, $itemsPerPage);

        echo '<div class="user-details">';

        if (!empty($itemsToShow)) {
            $previousUser = null;

            foreach ($itemsToShow as $message) {
                $user = $message['sender'] == $userId ? getUserDetails($message['receiver']) : getUserDetails($message['sender']);

                // Check if the current user is the same as the previous user
                if ($previousUser == $user['userId']) {
                    continue;
                }

                // Update the previousUser variable
                $previousUser = $user['userId'];

                // Display user details
                echo '<div style="margin-top: 10px;">';
                echo '<a href="profile.php?userId=' . $user['userId'] . '" style="text-decoration: none; color: inherit; overflow: hidden; border-radius: 50%;">';
                echo "<img src='{$user['image']}' alt='{$user['name']}' style='width: 50px; height: 50px; border-radius: 50%;'>";
                echo '</a>';

                echo '<a href="profile.php?userId=' . $user['userId'] . '" target="_blank" style="text-decoration: none; color: inherit; margin-top: 5px;">';
                echo $user['username'];
                echo '</a>';
                echo '</div>';
            }

            // Pagination links
            echo '<div class="pagination">';
            if ($currentPage > 1) {
                echo '<a href="?page=' . ($currentPage - 1) . '">Previous</a>';
            }
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<a href="?page=' . $i . '">' . $i . '</a>';
            }
            if ($currentPage < $totalPages) {
                echo '<a href="?page=' . ($currentPage + 1) . '">Next</a>';
            }
            echo '</div>';
        } else {
            echo 'No messages found.';
        }

        echo '</div>';
        ?>
    </div>
</body>

</html>
