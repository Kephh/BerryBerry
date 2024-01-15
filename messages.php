<!-- comments.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Message</title>
    <style>
        .cart {
            width: 100px;
        }
        .messages{
            display: inline-block;
        }
        .align-left{
            float: left;
        }
        .align-right{
            float: right;
        }
        .user-image-circle {
        width: 30px; /* Adjust the size as needed */
        height: 30px;
        border-radius: 50%; /* This creates a circular shape */
        overflow: hidden; /* Ensures the image doesn't overflow the circular container */
        display: inline-block; /* or use other display property based on your layout */
        }

        .user-image-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensures the image covers the circular container */
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
                $self=$userId;
                
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

    if (isset($_GET['userId'])) {
        $other = $_GET['userId'];
        echo '<main style="display: flex;">';
        echo '<section class="profile-info">';

        //<!-- Add more profile details as needed -->
        echo '</section>';

        echo '<div class="messages">';
        if (isAuthenticated()) {
            $messagesPerPage = 10;

            // Fetch all comments for the current productId with usernames
            $allMessages = getMessage($self, $other);

            // Calculate the total number of comments
            $totalMessages = count($allMessages);

            // Calculate the total number of pages
            $totalPages = ceil($totalMessages / $messagesPerPage);

            // Get the current page number from the URL, default to 1 if not set
            $currentPage = isset($_GET['page']) ? max(1, min($_GET['page'], $totalPages)) : 1;

            // Calculate the offset for fetching comments based on the current page
            $offset = ($currentPage - 1) * $messagesPerPage;

            // Fetch comments for the current page
            $messages = array_slice($allMessages, $offset, $messagesPerPage);

            if (!empty($messages)) {
                foreach ($messages as $message) {
                    $user = getUserDetails($message['sender']);
                    $isSelf = ($self == $message['sender']);

                    // Output the message and apply styling based on the condition
                    echo '<div class="' . ($isSelf ? 'align-right' : 'align-left') . '">';
                    if(!$isSelf)
                        echo '<div class="user-image-circle"><a href="profile.php?userId=' . $other . '"><img src="' . $user['image'] . '"></a></div>';
                    echo '  <button>' . $message['message'] . '</button>  ';
                    if($isSelf)
                        echo '<div class="user-image-circle"><a href="profile.php?userId=' . $other . '"><img src="' . $user['image'] . '"></a></div>';
                    echo '</div>';
                    echo '<br><br>';
                }
            } else {
                echo 'No messages on this page.';
            }

            // Display pagination links
            echo '<div class="pagination">';
            for ($i = 1; $i <= $totalPages; $i++) {
                $activeClass = ($i == $currentPage) ? 'active' : '';
                echo '<a class="' . $activeClass . '" href="?userId=' . $other . '&page=' . $i . '">' . $i . '</a>';
                echo '  ';
            }
            echo '</div>';

            // Display the comment form
            echo '<form action="send_message.php" method="post">';
            echo '<input type="hidden" name="self" value="' . $self . '">';
            echo '<input type="hidden" name="other" value="' . $other . '">';
            echo '<textarea id="messageInput" style=" border-radius: 5%;" name="message" rows="4" cols="50" placeholder="Text here" required>' . $_SESSION['savedMessage'] . '</textarea><br>';
            echo '<input type="submit" value="Send" style="background-color: #a0f19a; border-radius: 10%;">';
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        setInterval(function() {
            location.reload(true); // Reload the page
        }, 15000); // Refresh every 15 seconds
        $(document).ready(function () {
        // Save message to session before refreshing
        window.addEventListener("beforeunload", function (event) {
            var messageContent = $("#messageInput").val();

            $.ajax({
                type: "POST",
                url: "save_message_to_session.php", // Change this to the actual path of your PHP script
                data: { savedMessage: messageContent },
                success: function () {
                    // Do something if the AJAX request is successful
                },
                error: function () {
                    // Handle errors if needed
                },
                async: true, // Set to true for asynchronous request
            });
        });
    });

    </script>
</body>

</html>