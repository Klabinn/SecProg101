<?php

    session_start();

    $exists = false;

    if($_SERVER ['REQUEST_METHOD'] === "POST"){
        

        require_once 'dbconnect.php';

        $username = stripslashes($_POST['username']); 
        $email = stripslashes($_POST['email']);
        $password = stripslashes($_POST['password']);
        $cpassword = stripslashes($_POST['cpassword']);



        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['email_notvalid'] = "Email not valid";
            header("Location: ../signup.php");
            exit;
        }

        if (strlen($password) < 8) {
            $_SESSION['password_notvalid'] = "Password is less than 8 characters";
            header("Location: ../signup.php");
            exit;
        }

        if ($is_valdi) {
            header("Location: ../signup.php");
            exit;
        }
        else{
            $sql = "SELECT * FROM users WHERE username=? OR email=?;";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
    
            $result = $stmt->get_result();

            if($result->num_rows !== 0){
                $_SESSION['exists'] = "User already existed, please login.";
                header("Location: ../login.php");
            }
            else{
                if(($password === $cpassword) && !$exists){
                    $hashed = password_hash($password, PASSWORD_DEFAULT);
                    $userid = "UID_".uniqid();
                    echo $userid;
                    
                    $query = "INSERT INTO users(userID, roles, username, email, password, date) VALUES (?, 'user', ?, ?, ?, current_timestamp());";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('ssss', $userid, $username, $email, $hashed);
                    $stmt->execute();
                    
                    $result = $stmt->get_result();
                    
                    if(isset($result)){
                        // echo 
                        // "<div class='login-container'>
                        // <h3>You are registered successfully.</h3>
                        // <br/>Click here to <a href='../login.html'>Login</a></div>";
                        header("Location: ../dashboard.php");
                    }
                }
            }
        }
    }
?>