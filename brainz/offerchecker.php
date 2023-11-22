<?php

    session_start();


    if($_SERVER ['REQUEST_METHOD'] === "POST"){
        
        require_once 'dbconnect.php';
        require_once 'sessionhandler.php';

        $title = striplashes(strip_tags($_POST['title']));
        $desc = striplashes(strip_tags($_POST['desc']));
        $price = striplashes(strip_tags($_POST['price']));

        $_SESSION['error101'] = "";

        $regex = '/[*^()+=\[\]\'\/{}|<>~]/';

        if (preg_match($regex, $title) || preg_match($regex, $price)) {
            $_SESSION['error101'] = "I see what you tryna do, but dont use wierd symbols.";
            header("Location: ../offer.php?error=1");
            exit;
        }

        else{
            $sql = "SELECT * FROM users WHERE username=? OR email=?;";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
    
            $result = $stmt->get_result();

            if($result->num_rows !== 0){
                $_SESSION['error101'] = "User already existed, please login.";
                header("Location: ../login.php?error=1");
            }
            else{
                if(($password === $cpassword)){
                    $hashed = password_hash($password, PASSWORD_DEFAULT);
                    $userid = "UID_".uniqid();
                    // echo $userid;
                    
                    $query = "INSERT INTO users(userID, roles, username, email, password, date) VALUES (?, 'user', ?, ?, ?, current_timestamp());";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('ssss', $userid, $username, $email, $hashed);
                    $stmt->execute();
                    
                    $result = $stmt->get_result();
                    
                    if(isset($result)){

                        $_SESSION['is_login'] = true;
                        $_SESSION['username'] = $username;
                        $_SESSION['email'] = $email;

                        sessionCreate($userid);

                        $SID = $_SESSION['SID'];
                        $cookie = $_SESSION['cookie'];
                        $expTime = $_SESSION['expTime'];

                        $query = "INSERT INTO usession (SID, userID, sessionID, expdate) VALUES (?, ?, ?, ?)";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param('sssi', $SID, $userid, $cookie, $expTime);
                        $stmt->execute();
                        $stmt->close();

                        setcookie('user', $cookie, $expTime);
                        $_SESSION['cookie'] = $cookie;

                        header("Location: ../dashboard.php");
                    }
                }
            }
        }
    }
?>