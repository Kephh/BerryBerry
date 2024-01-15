<?php
    // Assuming you have a functions.php file with necessary functions like getProductDetailsById
    include 'functions.php';

    if(isAuthenticated()){
        $userIdDetails = getUserDetailsByUsername($_SESSION['user']['username']);
        $userId = $userIdDetails['userId'];
    }

    // Check if productId is set in the URL
    if (isset($_GET['productId'])) {
        $productId = $_GET['productId'];

        // Retrieve product details by productId
        $product = getProductDetails($productId);

        if ($product) {
            // Display product details
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Product Detail - Berry Berry</title>
    <style>
        
        .product-detail {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
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

        <div class="user-options">
            <a href="index.php">Home</a>
            <?php
                if (isAuthenticated()) :
                    echo "<a href=\"logout.php\"> Log out</a>";
                else :
                    echo "<a href=\"sign_in.php\"> Sign in</a>";
                endif;
                
                ?>
            <span class="close" onclick="closeModalInNav()">&times;</span>
        </div>
    </header>
    <main>
        <section class="product-detail">
            <div class="product">
                <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                <h2><?= $product['name'] ?></h2>
                <p>Description: <?= $product['description'] ?></p>
                <p>Price: $<?= $product['price'] ?></p>
                <!-- Add more details as needed -->
            </div>
            <div>
                <?php
                    echo '<a href="viewLikes.php?productId=' . $product['productId'] . '" target="_blank" style="text-decoration: none; color: inherit;">';
                        echo '<span class="like-count" id="like-count-' . $product['productId'] . '">';
                        echo $product['likes'] . '  likes ';
                        echo '</span></a><br><br>';

                        if (isAuthenticated()) {
                            $userIdDetails = getUserDetailsByUsername($_SESSION['user']['username']);
                            $userId = $userIdDetails['userId'];

                            if (hasLiked($userId, $product['productId'])) {
                                echo '<button style="background-color: #a0f19a;"><a href="unlike_product.php?productId=' . $productId . '&userId=' . $userId . '" style="text-decoration: none; color: black;">Unlike</a></button>';
                            } else {
                                echo '<button style="background-color: #a0f19a;"><a href="like_product.php?productId=' . $productId . '&userId=' . $userId . '" style="text-decoration: none; color: black;">Like</a></button>';
                            }
                            echo '<a href="comments.php?productId=' . $product['productId'] . '&userId=' . $userId . '" target="_blank" style="text-decoration: none; color: inherit;">';
                            echo 'Comments<br><br>';
                            echo '</a>';
                            
                            if (hasSaved($userId, $product['productId'])) {
                                echo '<button style="background-color: #f87979;"><a href="remove_from_cart.php?productId=' . $productId . '&userId=' . $userId . '" style="text-decoration: none; color: white;">Not Anymore</a></button>';
                            } else {
                                echo '<button style="background-color: #a0f19a;"><a href="add_to_cart.php?productId=' . $productId . '&userId=' . $userId . '" style="text-decoration: none; color: black;">Eye-Catcher</a></button>';
                            }
                        }
                ?>
            </div>
        </section>
    </main>
    <footer>
        <h5>
            <p>&copy; 2023 BerryBerry. All rights reserved.</p>
        </h5>
    </footer>
    <script>
    function closeModalInNav() {
        $('.modal').hide();
    }
</script>
</body>
</html>
<?php
        } else {
            echo 'Product not found.';
        }
    } else {
        echo 'Product ID not provided.';
    }
?>