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
            $query = "SELECT * FROM users WHERE username=?;";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $_SESSION['username']);
            $stmt->execute();

            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            $userid = $row['userID'];

            $query = "INSERT INTO bodyparts (userID, title, description, price) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sssi', $userid, $title, $desc, $price);
            $stmt->execute();
            $result = $stmt->get_result();

            $stmt->close();

            if(isset($result)){

                $_SESSION['success200'] = "I hope you sell your organ soon!";
                header("Location: ../offer.php?success=1");
            }
        }
    }
?>