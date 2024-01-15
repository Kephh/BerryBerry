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
            <h1>Login to your account to manage all the services and explore our tools</h1>
            <form action="login.php" method="post">
                <label for="username"></label>
                <input type="text" id="username" name="username" required placeholder="Username ">
                
                <label for="password"></label>
                <input type="password" id="password" name="password" required placeholder="Password">

                <?php
                if (isset($_GET['productId'])) {
                    $productId = htmlspecialchars($_GET["productId"]);
                    echo '<input type="hidden" name="productId" value="' . $productId . '">';
                }
                ?>

                <button type="submit" >Sign In</button>
            </form>

            <p>Don't have an account? <a href="register.php">Sign up</a></p>
            <button><a href="admin_login.php">Admin login</a></button>
        </section>
		<section class="signin-form2">
			<div class="symbol">
				<img src="image/d3361aa9-dc32-4045-a24e-76aa01a5e9bf.jpeg" alt="Berry Berry ">
			</div>
			<h1>Welcome to Berry Berry </h1>
			<p>Enjoy your shopping </p>

		</section>
    </main>

</body>
</html>