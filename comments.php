<!-- comments.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Comments</title>
    <style>
        .cart {
            width: 100px;
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
        <?php

// Set the number of comments to display per page

if (isset($_GET['productId']) && isset($_GET['userId'])) {
    $productId = $_GET['productId'];
    $userId = $_GET['userId'];
    $product=getProductDetails($productId);
    echo '<main style="display: flex;">';
    echo '<section class="profile-info">';
                echo '<div class="profile-photo">';
                    echo '<img src="' . $product['image'] . '" alt="Product image">';
                echo '</div>';
                
                //<!-- Add more profile details as needed -->
        echo '</section>';
        
    echo '<div class="comments">';
            if (isAuthenticated()) {
                echo '<h1>Comments</h1>';
                $commentsPerPage = 10;

                // Fetch all comments for the current productId with usernames
                $allComments = getComments($productId, $userId);

                // Calculate the total number of comments
                $totalComments = count($allComments);

                // Calculate the total number of pages
                $totalPages = ceil($totalComments / $commentsPerPage);

                // Get the current page number from the URL, default to 1 if not set
                $currentPage = isset($_GET['page']) ? max(1, min($_GET['page'], $totalPages)) : 1;

                // Calculate the offset for fetching comments based on the current page
                $offset = ($currentPage - 1) * $commentsPerPage;

                // Fetch comments for the current page
                $comments = array_slice($allComments, $offset, $commentsPerPage);

                if (!empty($comments)) {
                    foreach ($comments as $comment) {
                        echo '' . $comment['username'] . ' - ' . $comment['comment'] . '    ';
                        if ($userId == $comment['userId']) {
                            echo '<button style="background-color: #f87979;"><a href="deleteComment.php?commentId=' . $comment['commentId'] . '&productId=' . $productId . '&userId=' . $userId . '" style="text-decoration: none; color: white;">Delete</a></button>';
                        }
                        echo '<br>';
                        echo '<br>';
                    }
                } else {
                    echo 'No comments for this product on this page.';
                }

                // Display pagination links
                echo '<div class="pagination">';
                for ($i = 1; $i <= $totalPages; $i++) {
                    $activeClass = ($i == $currentPage) ? 'active' : '';
                    echo '<a class="' . $activeClass . '" href="?productId=' . $productId . '&userId=' . $userId . '&page=' . $i . '">' . $i . '</a>';
                }
                echo '</div>';

                // Display the comment form
                echo '<h2>Add a Comment</h2>';
                echo '<form action="add_comment.php" method="post">';
                echo '<input type="hidden" name="productId" value="' . $productId . '">';
                echo '<input type="hidden" name="userId" value="' . $userId . '">';
                echo '<textarea name="comment" rows="4" cols="50" placeholder="Type your comment here" required></textarea><br>';
                echo '<input type="submit" value="Add Comment" style="background-color: #a0f19a;">';
                echo '</form>';
            } else {
                // Redirect to sign_in page with productId for redirection after sign-in
                $redirectUrl = 'sign_in.php?productId=' . $productId;
                header('Location: ' . $redirectUrl);
                exit;
            }
        } else {
            echo 'Invalid request.';
        }
        ?>

    </div>
    </main>
</body>

</html>