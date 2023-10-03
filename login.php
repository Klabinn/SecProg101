<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/navbar.css">
</head>
<body>
    <div class="topnav"> <!--navbar kita ini-->
        <a href="home.php">Home</a>
        <a href="#news">News</a>
        <a href="signup.php">SignUp</a>
        <a class="active" href="login.php">Login</a>
    </div>
    
    <div class="login-container">
        <h2>Login</h2>
        <form action="brainz/loginchecker.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>