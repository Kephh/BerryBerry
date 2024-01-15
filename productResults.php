<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Search Results</title>
    <style>
        .cart{
            margin-top: 50px;
            margin-left: 800px; /* Adjust the value as needed */
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

        <div class="cart">
            <?php
            if(isset($_GET['searchTerm']))
                $searchTerm=$_GET['searchTerm'];
                echo '<h1>Products</h1>';
                echo '<br>';
                // Set the number of comments to display per page
                $productsPerPage = 10;
                    // Fetch all products for the current userId
                    $allProducts = searchProducts($searchTerm);

                    $totalProducts = count($allProducts);

                    if ($totalProducts > 0) {
                        $totalPages = ceil($totalProducts / $productsPerPage);
                        $currentPage = isset($_GET['page']) ? max(1, min($_GET['page'], $totalPages)) : 1;
                        $offset = ($currentPage - 1) * $productsPerPage;
                        $products = array_slice($allProducts, $offset, $productsPerPage);

                        if (!empty($products)) {
                            foreach ($products as $product) {
                                $productId = $product['productId'];
                                $item = getProductDetails($productId);

                                echo '<div style="display: flex; align-items: center;">';
                                echo '<a href="productDetail.php?productId=' . $productId . '" style="text-decoration: none; color: inherit; display: inline-block; overflow: hidden; border-radius: 50%; margin-top: 10px; margin-right: 10px;">';
                                echo "<img src='{$item['image']}' alt='{$item['name']}' style='width: 50px; height: 50px; border-radius: 50%;'>";
                                echo '</a>';
                                echo '<span style="margin-left: 10px;">' . $item['name'] . '</span>';
                            if(isAuthenticated()){
                                if (hasSaved($userId, $productId)) {                            
                                    echo '<button style="background-color: #f87979; margin-left: 10px;"><a href="remove_from_cart.php?productId=' . $productId . '&userId=' . $userId . '" style="text-decoration: none; color: white;">Not Anymore</a></button>';
                                } else {
                                    echo '<button style="background-color: #a0f19a; margin-left: 10px;"><a href="add_to_cart.php?productId=' . $productId . '&userId=' . $userId . '" style="text-decoration: none; color: black;">Eye-Catcher</a></button>';
                                }
                            }
                                echo '</div>';
                                echo '<br>';

                                }
                            } else {
                                echo 'No products for this user on this page.';
                            }

                        // Display pagination links
                        echo '<div class="pagination">';
                        for ($i = 1; $i <= $totalPages; $i++) {
                            $activeClass = ($i == $currentPage) ? 'active' : '';
                            echo '<a class="' . $activeClass . '" href="?searchTerm=' . $searchTerm . '&page=' . $i . '">' . $i . '</a>';
                        }
                        echo '</div>';
                    } else {
                        echo 'No products for this term.';
                    }
            ?>
        </div>
</body>
</html>
