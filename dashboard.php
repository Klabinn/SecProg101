<?php
    session_start();

    if($_SESSION['is_login'] !== true){

        header("Location: login.php");
    }


?>

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
        <a class="active" href="home.html">SignOut</a>
        <a href="#news">BodyParts</a>
        <a href="signup.html">Purchases</a>
        <a href="login.html">Forum</a>
    </div>
</body>
</html>

