<?php

    $exists = false;

    if($_SERVER ['REQUEST_METHOD'] === "POST"){
        

        include 'dbconnect.php';

        $username = stripslashes($_POST['username']); 
        $username = mysqli_real_escape_string($conn, $username);
        $email = stripslashes($_POST['email']);
        $email = mysqli_real_escape_string($conn, $email);
        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($conn, $password);
        $cpassword = stripslashes($_POST['cpassword']);

        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) == 0){
            
            if(($password === $cpassword) && !$exists){

            #hashing dulu bos
            $hashed= password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (username, password, email, date) VALUES ('$username', '$hashed', '$email', current_timestamp())";
            
            $result = mysqli_query($conn, $query);
            
            if($result){
                echo 
                "<div class='form'>
                <h3>You are registered successfully.</h3>
                <br/>Click here to <a href='../login.html'>Login</a></div>";
            }
        }
        else{
            $exists = true;
        }
    }



    }
?>