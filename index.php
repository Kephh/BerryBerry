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
        /* Your existing styles */
        #loading {
            display: none;
            text-align: center;
            padding: 10px;
        }
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 0px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        
        .modal-content {
            text-align: center;
        }
        
        .modal-header,
        .modal-footer {
            background-color: #f2f2f2;
            padding: 10px;
            margin-top: 10px;
        }
        
        .close {
            cursor: pointer;
        }
        
        .close:hover {
            color: black;
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

<main>
    <section class="product-list">
        <?php
            if (!isset($_GET['pageId'])) {
                // If not, shuffle the products and store the shuffled order in the session
                $products = getProducts();
                shuffle($products);
                $_SESSION['shuffledProducts'] = $products;
            } else {
                // If the shuffled order is already stored, use that order
                $products = $_SESSION['shuffledProducts'];
            }
            // Output initial set of products
            includeProducts($products);

            function includeProducts($products) {
                // Loop through products and output HTML
                foreach ($products as $product) {
                    echo '<div class="product">';
                    echo '<button class="open-modal-button" data-product-id="' . $product['productId'] . '" style="background: inherit;">';
                    echo "<img src='{$product['image']}' alt='{$product['name']}'>";
                    echo '<h2>' . $product['name'] . '</h2>';
                    echo '</button>';
                    // Display "like" or "likes" based on the count
                    $likeText = ($product['likes'] === 1) ? 'like' : 'likes';

                    echo '<br><a href="viewLikes.php?productId=' . $product['productId'] . '" target="_blank" style="text-decoration: none; color: inherit;">';
                    echo '<span class="like-count" id="like-count-' . $product['productId'] . '">';
                    echo $product['likes'] . ' ' . $likeText;
                    echo '</span></a><br><br>';

                    if (isAuthenticated()) {
                        $userIdDetails = getUserDetailsByUsername($_SESSION['user']['username']);
                        $userId = $userIdDetails['userId'];

                        if (hasLiked($userId, $product['productId'])) {
                            echo '<button class="unlike-button" data-product-id="' . $product['productId'] . '">Unlike</button>';
                        } else {
                            echo '<button class="like-button" data-product-id="' . $product['productId'] . '">Like</button>';
                        }
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

        // Modal functionality
        $(document).on('click', '.open-modal-button', function() {
            var productId = $(this).data('product-id');
            loadProductDetails(productId);
            $('.modal').show();
        });

        function loadProductDetails(productId) {
            // Replace the following line with your AJAX request to load content
            var content = '<p>Product ID: ' + productId + ' Details</p>';
            $('.modal-content').html(content);
        }
        $(document).on('click', '.open-modal-button', function() {
            var productId = $(this).data('product-id');
            loadProductDetails(productId);
            $('.modal').show();
        });

        $('.close').click(function() {
            $('.modal').hide();
        });

        function loadProductDetails(productId) {
            $.ajax({
                url: 'productDetail.php',
                type: 'GET',
                data: { productId: productId },
                success: function(response) {
                    $('#modalBody').html(response);
                },
                error: function(xhr, status, error) {
                    // Display a user-friendly error message
                    $('#modalBody').html('<p>Error loading product details.</p>');
                    console.error('Error loading product details:', status, error);
                }
            });
        }
    </script>
</main>

<!-- Modal -->
<div class="modal">
    <div class="modal-content">
        <div id="modalBody">
            <!-- Content will be dynamically loaded here -->
        </div>
    </div>
</div>

<footer>
<p>&copy; 2023 BerryBerry. All rights reserved.</p>
</footer>

</body>
</html>
