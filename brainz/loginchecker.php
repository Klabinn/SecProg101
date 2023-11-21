<?php

    session_start();

    if($_SERVER ['REQUEST_METHOD'] === "POST"){
        

        require_once 'dbconnect.php';

        $username = stripslashes($_POST['username']); 
        $password = stripslashes($_POST['password']);

        #Passwordnya gua hash jadi validasinya harus pake hash ini
        $hashed = password_hash($password, PASSWORD_DEFAULT);


        // prep statement
        $sql = "SELECT * FROM users WHERE username=? AND password=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        $result = $conn->get_result()
        

        if($result->num_rows === 1){

            $row = $result->fetch_assoc(); #fetch assoc adalah method untuk manipulasi data di DB 

            $row['password'];

            $_SESSION['is_login'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];


            header("Location: ../dashboard.php");
        }
        else{
            // $is_login = "wrong";
            echo ' salah ';
            header("Location: ../login.php");    
        }

    }
?>