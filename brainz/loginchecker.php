<?php

    session_start();

    $is_login = false;

    if($_SERVER ['REQUEST_METHOD'] === "POST"){
        

        include 'dbconnect.php';

        $username = stripslashes($_POST['username']); 
        $username = mysqli_real_escape_string($conn, $username);
        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($conn, $password);

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $sql = "SELECT * FROM users WHERE username='$username' AND password='$hashed'";
        
        $result = mysqli_query($conn, $sql);
        $correct = mysqli_num_rows($result);


        if($correct){
            echo 
            "<script>alert('Welcome to the HackerDen');</script>";
            $is_login = true;
            header("Location: ../dashboard.php");
        }
        else{
            echo "<script>alert('Failed.')</script>; window.location.href='..\login.html';";          
        }

    }
?>