<?php
    include 'functions.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $searchTerm = $_POST['searchTerm'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        .search-page{
            max-width: 400px;
            height: 400px;
            width: 700px;
            margin: 0 auto;
            position: absolute;
            top: 50%;
            left: 75%;
            border: 2px solid white;
            transform: translate(-50%,-50%);
            text-align: center;
            background-color: rgba(255, 255, 255, 0.5);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            padding: 20px;
            border-radius: 0px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
        }
    </style>
</head>
<body>
    </body>
    </html>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>Update Profile</title>
    </head>
    <body>
        <main>
            <section class="search-page">
                <p><h1>Search Results for "<?php echo $searchTerm; ?>":</h1> </p>
                <br><br>
                <button style="background-color: #a0f19a" ><a href="userResults.php?searchTerm=<?php echo urlencode($searchTerm); ?>" style="text-decoration: none; color: black;">Users</a></button>
                <button style="background-color: #a0f19a" ><a href="productResults.php?searchTerm=<?php echo urlencode($searchTerm); ?>" style="text-decoration: none; color: black;">Products</a></button>
        </section>
    </main>
</body>
</html>
