<?php

    session_start();

    echo "<link rel='stylesheet' href='assets/style.css'>
    <link rel='stylesheet' href='assets/navbar.css'>";

    $exists = false;

    if($_SERVER ['REQUEST_METHOD'] === "POST"){
        

        require_once 'dbconnect.php';

        $username = stripslashes($_POST['username']); 
        $username = mysqli_real_escape_string($conn, $username);
        $email = stripslashes($_POST['email']);
        $email = mysqli_real_escape_string($conn, $email);
        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($conn, $password);
        $cpassword = stripslashes($_POST['cpassword']);
        $cpassword = mysqli_real_escape_string($conn, $cpassword);


        $is_valdi = "";

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $is_valdi = "Invaldi Gmail.";
        }

        if (strlen($password) < 8) {
            $is_valdi = "Password too short la, must be at least 8 characters long.";
        }

        if ($is_valdi) {
            header("Location: ../signup.php");
            exit;
        }
        else{
            $sql = "SELECT * FROM users WHERE username=? AND password=?;";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
    
            $result = $conn->get_result()

            if(mysqli_num_rows($result) === 0){
                
                if(($password === $cpassword) && !$exists){

                #hashing dulu bos
                $hashed= password_hash($password, PASSWORD_DEFAULT);

                $query = "INSERT INTO users (username, password, email, date) VALUES ('?', '?', '?', current_timestamp())";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sss", $username, $password, $email);
                $stmt->execute();

                $result = $conn->get_result()
                
                if(isset($result)){
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
    }
?>