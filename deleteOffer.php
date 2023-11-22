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
        <a class="active" href="signout.php">SignOut</a>
        <a href="bodyparts.php">BodyParts</a>
        <a href="offer.php">Auction Register</a>
        <a href="offerAudit.php">Auction Audit</a>
    </div> 
    
    <div class="login-container">
        <h2>Organ Listing Canceler 403</h2>
        <form action="brainz/deletor.php" method="POST">
            <label for="ttd">Title to delete:</label>
            <input type="text" id="ttd" name="ttd" required>

            <input type="submit" value="Deletus">
        </form>
        <br>
        <a href="offerAudit.php">Nvm!</a>

        <?php 
                if(isset($_GET['error'])) {
                    if(isset($_SESSION["error101"])) {
                        $errorMessage = $_SESSION["error101"];
                        echo '<br><div style="color:Purple;">' . $errorMessage . '</div>';
                    }
                }
                unset($_SESSION['error_message']);
            ?>
    </div>
</body>
</html>