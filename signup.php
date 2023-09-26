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
        <a class="active" href="signup.php">SignUp</a>
        <a href="login.php">Login</a>
    </div>
    
    <div class="login-container">
        <h2>SignUp</h2>
        <form action="brainz/signupchecker.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="username">Email:</label>
            <input type="text" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="cpassword">Confirm Password:</label>
            <input type="password" id="cpassword" name="cpassword" required>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>