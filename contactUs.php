<?php
// Include functions.php at the beginning
include 'functions.php';

if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];
    $userDetails = getUserDetails($userId);
} else {
    echo 'NO userId';
}

// Process the registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and save user registration details
    $feedbackDescription = $_POST['description'];

    sendFeedback($userId, $feedbackDescription);
    header('Location: index.php');
    exit();

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Reach Us</title>
</head>
<body>
    <main>
        <section class="signin-form">
            <h1>Share your experience.</h1>
            <form action="contactUs.php?userId=<?php echo $userId; ?>" method="post">

                <label for="description">Description:</label>
                <textarea id="description" name="description" placeholder="Let us know..."></textarea>

                <button type="submit">Submit</button>
            </form>

        </section>
    </main>
</body>
</html>
