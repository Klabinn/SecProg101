<?php

    session_start(); 

    if($_SERVER ['REQUEST_METHOD'] === "POST"){
        
        require_once 'dbconnect.php';
        require_once 'sessionhandler.php';

        destroyCookies();

        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $cpassword = trim($_POST['cpassword']);

        $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');
        $cpassword = htmlspecialchars($cpassword, ENT_QUOTES, 'UTF-8');

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

                        $SID = "SID_" . uniqid();
                        $cookie = generateCookie(40);
                        $expTime = time() + 1800;

                        $query = "INSERT INTO usession (SID, userID, sessionID, expdate) VALUES (?, ?, ?, ?)";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param('sssi', $SID, $userid, $cookie, $expTime);
                        $stmt->execute();
                        $stmt->close();

                        setcookie('user', $cookie, $expTime, '/');
                        header("Location: ../dashboard.php");
                    }
                }
            }
        }
    }
?>