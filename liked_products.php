<?php
    include 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Berry Berry</title>
    <style>
        /* Add your styles as needed */
        #loading {
            display: none;
            text-align: center;
            padding: 10px;
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

    <!--<nav>
        <a href="#">Best Sellers</a>
        <a href="#">Today's Deals</a>
        <a href="#">New Releases</a>
        <a href="#">Customer Service</a>
    </nav>-->

    <main>
        <section class="product-list">
            <?php
                $products = getProductDetailsFromLike($userId);
                // Output initial set of products
                includeProducts($products);

                function includeProducts($products) {
                    // Loop through products and output HTML
                    foreach ($products as $product) {
                        $productId = $product['productId'];
                        $item = getProductDetails($productId);
                        echo '<div class="product">';
                        echo '<a href="productDetail.php?productId=' . $product['productId'] . '" style="text-decoration: none; color: inherit;">';
                        echo "<img src='{$item['image']}' alt='{$item['name']}'>";
                        echo '<h2>' . $item['name'] . '</h2>';
                        echo '</a>';
                        

                        if (isAuthenticated()) {
                            $userIdDetails = getUserDetailsByUsername($_SESSION['user']['username']);
                            $userId = $userIdDetails['userId'];
                            echo '<a href="comments.php?productId=' . $product['productId'] . '&userId=' . $userId . '" target="_blank" style="text-decoration: none; color: inherit;">';
                            echo 'Comments';
                            echo '</a>';
                        } else {
                            echo '<a href="sign_in.php">Sign in to engage</a>';
                        }

                        echo '</div>';
                    }
                }
            ?>
            <!-- Add more products as needed -->
            <div id="loading">...</div>
        </section>
        <script src="script.js"></script>
        <script>
            // Infinite scroll
            $(document).ready(function() {
                var page = 2; // Initial page number

                $(window).scroll(function() {
                    if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                        loadMoreData(page);
                        page++;
                    }
                });

                function loadMoreData(page) {
                    $('#loading').show();

                    $.ajax({
                        url: 'loadmore.php?page=' + page,
                        type: 'get',
                        success: function(response) {
                            $('#loading').hide();
                            $('.product-list').append(response);
                        }
                    });
                }
            });
        </script>
    </main>

    <footer>
        <p>&copy; 2023 BerryBerry. All rights reserved.</p>
    </footer>
</body>
</html>
