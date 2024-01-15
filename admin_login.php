<?php
session_start();
include 'functions.php';

// Check if the user is already logged in
if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    // Redirect to success page or display a message
    header('Location: success.php');
    exit();
}

// Process the admin login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and save admin login details (customize as needed)
    $adminUsername = $_POST['username'];
    $adminPassword = $_POST['password'];

    // Authenticate admin (customize as needed)
    if (authenticateAdmin($adminUsername, $adminPassword)) {
        // Successful admin login
        $_SESSION['admin'] = true;
        $successMessage = "Login successful. Welcome, $adminUsername!";
        header('Location: success.php');
        exit();
    } else {
        // Failed admin login, display an error message
        $error = "Invalid admin credentials. Please try again.";
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
    <title>Admin Login</title>
</head>
<body>

    <main>
        <section class="signin-form">
            <h1>Login to your Admin account to manage all the services and explore our tools</h1>
            <form action="admin_login.php" method="post">
                <label for="username"></label>
                <input type="text" id="username" name="username" required placeholder="Username ">
                
                <label for="password"></label>
                <input type="password" id="password" name="password" required placeholder="Password">

                <button type="submit" >Sign In</button>
            </form>
            <p>Not an admin? <a href="sign_in.php">Sign in</a></p>
        </section>
		<section class="signin-form2">
			<div class="symbol">
				<img src="image/e4e79f34-1f74-4c1f-95be-85677543be8b.jpeg" alt="Berry Berry ">
			</div>
			<h1>Welcome to Berry Berry </h1>
			<p>Enjoy your Admin priviledge </p>

		</section>
    </main>

</body>
</html><?php
session_start();
include 'functions.php';

// Check if the user is already logged in
if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    // Redirect to success page or display a message
    header('Location: success.php');
    exit();
}

// Process the admin login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and save admin login details (customize as needed)
    $adminUsername = $_POST['username'];
    $adminPassword = $_POST['password'];

    // Authenticate admin (customize as needed)
    if (authenticateAdmin($adminUsername, $adminPassword)) {
        // Successful admin login
        $_SESSION['admin'] = true;
        $successMessage = "Login successful. Welcome, $adminUsername!";
        header('Location: success.php');
        exit();
    } else {
        // Failed admin login, display an error message
        $error = "Invalid admin credentials. Please try again.";
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
    <title>Admin Login</title>
</head>
<body>

    <main>
        <section class="signin-form">
            <h1>Login to your Admin account to manage all the services and explore our tools</h1>
            <form action="admin_login.php" method="post">
                <label for="username"></label>
                <input type="text" id="username" name="username" required placeholder="Username ">
                
                <label for="password"></label>
                <input type="password" id="password" name="password" required placeholder="Password">

                <button type="submit" >Sign In</button>
            </form>
            <p>Not an admin? <a href="sign_in.php">Sign in</a></p>
        </section>
		<section class="signin-form2">
			<div class="symbol">
				<img src="image/e4e79f34-1f74-4c1f-95be-85677543be8b.jpeg" alt="Berry Berry ">
			</div>
			<h1>Welcome to Berry Berry </h1>
			<p>Enjoy your Admin priviledge </p>

		</section>
    </main>

</body>
</html>