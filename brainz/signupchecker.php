<?php

    session_start(); 

    if($_SERVER ['REQUEST_METHOD'] === "POST"){
        
        require_once 'dbconnect.php';
        require_once 'sessionhandler.php';

        $username = strip_tags($_POST['username']);
        $email = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']);
        $cpassword = strip_tags($_POST['cpassword']);

        $_SESSION['error101'] = "";

        $regex = '/[*^()+=\[\]\'\/{}|<>~]/';

        if (preg_match($regex, $username) || preg_match($regex, $email) || preg_match($regex, $password)) {
            $_SESSION['error101'] = "No funny business!";
            header("Location: ../signup.php?error=1");
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error101'] = "Email not valid";
            header("Location: ../signup.php?error=1");
            exit;
        }

        if (strlen($password) < 8) {
            $_SESSION['error101'] = "Password is less than 8 characters";
            header("Location: ../signup.php?error=1");
            exit;
        }

        if (strcmp($password, $cpassword)) {
            $_SESSION['error101'] = "Password is not the same";
            header("Location: ../signup.php?error=1");
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