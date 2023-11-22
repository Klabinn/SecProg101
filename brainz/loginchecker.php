<?php
    session_start();

    if($_SERVER ['REQUEST_METHOD'] === "POST"){
        
        require_once 'dbconnect.php';

        $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8'); 
        $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

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
                $_SESSION['is_login'] = true;
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                header("Location: ../dashboard.php");
            }
            else{
                $_SESSION['error101'] = "Incorrect Login Credentials";
                header("Location: ../login.php?error=1"); 
            }
        }
        else{
            $_SESSION['error101'] = "Incorrect Login Credentials";
            header("Location: ../login.php?error=1");    
        }

    }
?>