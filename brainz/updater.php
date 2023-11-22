<?php
    session_start();

    if($_SERVER ['REQUEST_METHOD'] === "POST"){
        
        require_once 'dbconnect.php';

        $originaltitle = strip_tags($_POST['OriginalTitle']);
        $pricechange = strip_tags($_POST['pricechange']);

        $sql = "SELECT * FROM bodyparts WHERE title=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $originaltitle);
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
        }
        else{
            $_SESSION['error101'] = "Incorrect Login Credentials";
            header("Location: ../login.php");    
        }

    }
?>