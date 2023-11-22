<?php

    session_start();

    if($_SESSION['is_login'] !== true){
        
        header("Location: login.php");
    }

    if($_SERVER ['REQUEST_METHOD'] === "POST"){
        
        require_once 'dbconnect.php';
        require_once 'sessionhandler.php';

        $title = strip_tags($_POST['title']);
        $desc = strip_tags($_POST['desc']);
        $price = strip_tags($_POST['price']);

        $_SESSION['error101'] = "";

        $regex = '/[*^()+=\[\]\'\/{}|<>~]/';

        if (preg_match($regex, $title) || preg_match($regex, $price)) {
            $_SESSION['error101'] = "I see what you tryna do, but dont use wierd symbols.";
            header("Location: ../offer.php?error=1");
            exit;
        }

        else{

            query = "SELECT INTO "

            $userid = $_SESSION['userid'];

            $query = "INSERT INTO bodyparts (userID, tittle, description) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sss', $userid, $title, $price);
            $stmt->execute();
            $stmt->close();
        }
    }
?>