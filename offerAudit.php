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
        <a class="active" href="home.php">SignOut</a>
        <a href="bodyparts.php">BodyParts</a>
        <a href="offer.php">Auction Register</a>
        <a href="offerAudit.php">Auction Audit</a>
    </div> 

    <div class="form-actions">
        <button href="updateOffer.php">
    </div>
    <div class="form-actions">
        <button href="deleteOffer.php">
    </div>
    

</body>
</html>