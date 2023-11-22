<?php
    session_start();
    require_once "brainz/dbconnect.php";
    require_once "brainz/sessionhandler.php";

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

    <div>
        <?php
            // $user_id = $_SESSION['user_id'];
            $quer = "SELECT u.username, b.title, b.description, b.price, b.attachment
                    FROM bodyparts b
                    JOIN users u ON b.userID = u.userID
                    WHERE b.userID = u.userID";
            $result = $conn->query($quer);

            if ($result->num_rows > 0){
                while($row = $result->fetch_assoc()) {
                    echo "<header class='title'>Seller: " . $row['username'] . "</header>";
                    echo "<header class='title'>Bodypart: " . $row['title'] . "</header>";
                    echo "<div class='card-content'>";
                    echo "<div class='innern'>Description: " . $row['description'] . "</div>";
                    echo "<div class='innern'>Price: " . $row['price'] . "</div>";
                    echo "<div class='inner'>" . "<img src=\"" . $row['attachment'] . "\" alt=\"attachment\" style=\"max-width:100%; height:auto;\">" . "</div>";
                }
            }

        ?>
    </div>
</body>
</html>


