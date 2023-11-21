<?php

    session_start();

    if($_SERVER ['REQUEST_METHOD'] === "POST"){
        
        require_once 'dbconnect.php';

        $username = stripslashes($_POST['username']); 
        $password = stripslashes($_POST['password']);

        $ver = "SELECT * FROM users WHERE username=?;";
        $stmt = $conn->prepare($ver);
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->num_rows === 1){

            $row = $result->fetch_assoc();

            $hashverif = $row['password'];
            // verifnya pake password_verify
            if(password_verify($password, $hashverif)) {
                $row['password'];
                $_SESSION['is_login'] = true;
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                header("Location: ../dashboard.php");
            }
        }
        else{
            $_SESSION['login_failed'] = "Incorrect Login Credentials";
            header("Location: ../login.php");    
        }

    }
?>