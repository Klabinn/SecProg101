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
    </div> 

    <h1 text-align:center> List your entry</h1>
    <form class="form" method="POST" action="./brainz/offerchecker.php">
            <fieldset>
                <label>Title:</label>
                <input id="title" name="title" type="text" cols="50">
            </fieldset>
            <fieldset>
                <label>Description:</label>
                <textarea id="desc" name="desc" rows="7" cols="85"> </textarea>
            </fieldset>
            <fieldset>
                <label>Price:</label>
                <input id="price" name="price" type="interger">
            </fieldset>
            <fieldset>
                <label>Upload your the bodypart you want to sell:</label>
                <input id="file" name="file" type="file" placeholder="upload your the bodypart you want to sell"> 
            </fieldset>
            <div class="form-actions">
                <input type="submit" class="btn btn-primary btn-block btn-ghost" name="send" />
            </div>
        </form>
        <?php 
                if(isset($_GET['error'])) {
                    if(isset($_SESSION["error101"])) {
                        $errorMessage = $_SESSION["error101"];
                        echo '<br><div style="color:Purple;">' . $errorMessage . '</div>';
                    }
                }
                unset($_SESSION['error_message']);
            ?>
</body>
</html>


