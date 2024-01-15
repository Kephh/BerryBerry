<!--register.php-->
<?php

// Include functions.php at the beginning
include 'functions.php';

// Check if the user is already logged in
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    session_start();
    exit();
}

// Rest of the code...


// Process the registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and save user registration details
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

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
            // Add the product to the database
            $registrationSuccess = addUser($uploadedImagePath, $username, $password, $email);


            if ($registrationSuccess) {
                // Retrieve user ID and store it in the session
                $userDetails = getUserDetailsByUsername($username);
                $_SESSION['user'] = $userDetails;
                header('Location: index.php');
                session_start();
                exit();
            } else {
                // Registration failed, display an error message
                $error = "Registration failed. Please try again.";
            }
        } else {
            echo "Error uploading image.";
        }
    } else {
        $registrationSuccess = addUser('profile/defaultProfile.jpg', $username, $password, $email);
        if ($registrationSuccess) {
            // Retrieve user ID and store it in the session
            $userDetails = getUserDetailsByUsername($username);
            $_SESSION['user'] = $userDetails;
            header('Location: index.php');
            session_start();
            exit();
        } else {
            // Registration failed, display an error message
            $error = "Registration failed. Please try again.";
        }
    }
}
?>

<!--sign_in.php-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Sign In</title>
</head>
<body>

    <main>
        <section class="signin-form">
            <h1>Register an account to manage all the services and explore our tools</h1>
            <form action="register.php" method="post" enctype="multipart/form-data">

                <label for="image"><br>Choose an image:</label>
                <input type="file" name="image" id="image" accept="image/*">

                <label for="username"></label>
                <input type="text" id="username" name="username" required placeholder="Username ">
                
                <label for="password"></label>
                <input type="password" id="password" name="password" required placeholder="Password">
                
                <label for="email"></label>
                <input type="email" id="email" name="email" required placeholder="Email ">

                <button type="submit" >Register</button>
            </form>

            <p>Already have an account? <a href="sign_in.php">Log in</a></p>
        </section>
		<section class="signin-form2">
			<div class="symbol">
				<img src="image\d3361aa9-dc32-4045-a24e-76aa01a5e9bf.jpeg" alt="Berry Berry ">
			</div>
			<h1>Welcome to Berry Berry </h1>
			<p>Enjoy your shopping </p>

		</section>
    </main>

</body>
</html>