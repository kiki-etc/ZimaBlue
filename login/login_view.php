<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login </title>
    <link rel="stylesheet" href="../css/login_style.css">
</head>

<body>
    <div class="container">
        <input type="checkbox" id="check">
        <div class="login form">
            <header>Login</header>
            <form action="../actions/login_action.php" method="post">
                <?php
                if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error'] ?></p>
                <?php } ?>
                <input type="text" placeholder="Enter your email" name="email">
                <input type="password" placeholder="Enter your password" name="passwrd">
                <a href="#">Forgot password?</a>
                <input type="submit" class="button" name="submit_button" value="Login">
            </form>
            <div class="signup">
                <span class="signup">Don't have an account?
                    <label for="check"><a href="signup_view.php">Signup<a></label>
                </span>
            </div>
        </div>

    </div>
</body>

</html>