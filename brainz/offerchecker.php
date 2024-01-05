<?php

    session_start();

    if($_SESSION['is_login'] !== true){
        
        header("Location: login.php");
    }

    if($_SERVER ['REQUEST_METHOD'] === "POST"){
        
        require_once 'dbconnect.php';
        require_once 'sessionhandler.php';

        destroyCookies();

        $title = trim($_POST['title']);
        $desc = trim($_POST['desc']);
        $price = trim($_POST['price']);

        $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        $desc = htmlspecialchars($desc, ENT_QUOTES, 'UTF-8');
        $price = htmlspecialchars($price, ENT_QUOTES, 'UTF-8');

        $_SESSION['error101'] = "";

        if(strlen($title) > 50){
            $_SESSION['error101'] = "Please write the title with a maximum length of 50 characters.";
            header("Location: ../offer.php?error=1");
            exit;
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

        $number = '/[0-9]/';

        if (!preg_match($number, $price)) {
            $_SESSION['error101'] = "Price is number.";
            header("Location: ../offer.php?error=1");
            exit;
        }

        if (isset($_FILES['file'])) {
            $unique = uniqid();
            $attachment = $_FILES['file'];
            $attachment_name = trim($attachment['name']);
            $attachment_name = htmlspecialchars($attachment_name, ENT_QUOTES, 'UTF-8');
            $extensions = ['png', 'jpg', 'jpeg'];

            if (!in_array(strtolower(pathinfo($attachment_name, PATHINFO_EXTENSION)), $extensions)) {
                $_SESSION['error101'] = "Invalid format! Please use: PNG, JPG, JPEG.";
                header("Location: ../offer.php?error=1");
                exit;
            }

            $maxSize = 25 * 1024 * 1024;
            if ($attachment['size'] > $maxSize) {
                $_SESSION['error101'] = "File size too big! Please use a smaller file. (Max: 25 MB)";
                header("Location: ../offer.php?error=1");
                exit;
            }

            $attachment_tmp_name = trim($attachment['tmp_name']);
            $attachment_tmp_name = htmlspecialchars($attachment_tmp_name, ENT_QUOTES, 'UTF-8');
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
                }
            }

            $stmt->close();
        }
    }
?>