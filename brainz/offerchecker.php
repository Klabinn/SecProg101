<?php

    session_start();

    if($_SESSION['is_login'] !== true){
        
        header("Location: login.php");
    }

    if($_SERVER ['REQUEST_METHOD'] === "POST"){
        
        require_once 'dbconnect.php';
        require_once 'sessionhandler.php';

        $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
        $desc = htmlspecialchars($_POST['desc'], ENT_QUOTES, 'UTF-8');
        $price = htmlspecialchars($_POST['price'], ENT_QUOTES, 'UTF-8');

        $_SESSION['error101'] = "";

        if(strlen($title) > 50){
            $_SESSION['error101'] = "Please write the title with a maximum length of 50 characters.";
            header("Location: ../offer.php?error=1");
        }

        if(strlen($desc) < 10) {
            $_SESSION['error101'] = "Please write the description with a minimum length of 10 characters.";
            header("Location: ../offer.php?error=1");
            exit;
        }

        if(strlen($desc) > 300) {
            $_SESSION['error101'] = "Please write the description with a maximum length of 300 characters.";
            header("Location: ../offer.php?error=1");
            exit;
        }

        if (isset($_FILES['file'])) {
            $unique = uniqid();
            $attachment = $_FILES['file'];
            $attachment_name = $attachment['name'];
            $attachment_tmp_name = $attachment['tmp_name'];
            $uniq_attach_name = $unique . "_" . $attachment_name;
            $upload_path = "../uploads/" . $uniq_attach_name;
            $attachment_dir = "uploads/" . $uniq_attach_name;
        } else {
            $upload_path = null;
            $attachment_name = null;
            $attachment_tmp_name = null;
        }

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

            $query = "INSERT INTO bodyparts (userID, title, description, price, attachment) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sssis', $userid, $title, $desc, $price, $attachment_dir);
            $stmt->execute();
            $result = $stmt->get_result();

            if(isset($result)) {
                if(!empty($attachment_tmp_name)) {
                    move_uploaded_file($attachment_tmp_name, $upload_path);
                    $_SESSION['success200'] = "File Uploaded Successfully. I hope you sell your organ soon!";
                    header("Location: ../offer.php?success=1");
                    destroyCookies();
                }
            }

            $stmt->close();
        }
    }
?>