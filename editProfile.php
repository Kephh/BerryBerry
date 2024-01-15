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
    $username = htmlspecialchars($_POST['username']);
    $name = htmlspecialchars($_POST['name']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    // Get the previous image path
    $previousImagePath = isset($userDetails['image']) ? $userDetails['image'] : '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $targetFolder = 'profile/';
        $uploadedImagePath = $targetFolder . basename($_FILES['image']['name']);

        // Check file type and size before moving the file
        $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif', 'jfif', 'heif'];
        $maxFileSize = 5 * 1024 * 1024; // 5 MB

        $fileExtension = strtolower(pathinfo($uploadedImagePath, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedFileTypes)) {
            echo "Invalid file type. Allowed types: " . implode(', ', $allowedFileTypes);
            exit();
        }

        if ($_FILES['image']['size'] > $maxFileSize) {
            echo "File size exceeds the maximum limit (5 MB).";
            exit();
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadedImagePath)) {
            // Delete the previous image if it's not the default profile image
            if ($previousImagePath != 'profile/defaultProfile.jpg' && file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }

            // Update the user details in the database
            $updateSuccess = updateUser($uploadedImagePath, $name, $username, $password, $email, $userId);

            if ($updateSuccess) {
                header('Location: profile.php?userId=' . $userId);
                exit();
            } else {
                // Update failed, display an error message
                $error = "Update failed. Please try again.";
            }
        } else {
            echo "Error uploading image.";
        }
    } else {
        // Update failed, display an error message
        $error = "Update failed. Please try again.";
    }
}
?>

<!-- HTML code with pre-filled form fields -->
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
        <section class="signin-form">
            <h1>Update your profile to stay updated.</h1>
            <form action="editProfile.php?userId=<?php echo $userId; ?>" method="post" enctype="multipart/form-data">

                <label for="image"><br>Update image:</label>
                <input type="file" name="image" id="image" accept="image/*">

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Name" value="<?php echo isset($userDetails['name']) ? $userDetails['name'] : ''; ?>">

                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Username" value="<?php echo isset($userDetails['username']) ? $userDetails['username'] : ''; ?>">

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Password">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Email" value="<?php echo isset($userDetails['email']) ? $userDetails['email'] : ''; ?>">

                <button type="submit">Update</button>
            </form>

            <p>Update later? <a href="index.php">Home</a></p>
        </section>
    </main>
</body>
</html>
