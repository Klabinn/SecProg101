<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/navbar.css">
</head>

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
                "<div class='login-container'>
                <h3>You are registered successfully.</h3>
                <br/>Click here to <a href='../login.html'>Login</a></div>";
            }
        }
    
    }
    else{
        echo 
            "<div class='login-container'>
            <h3>Akun udah ada bjir</h3>
            <br>resubmit form? 
            <br><a href='../login.html'>Login</a>
            </div>";
    }
    }
?>