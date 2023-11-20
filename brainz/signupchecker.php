<?php

    session_start();

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

        $is_valdi = false;
        $_SESSION[''] = "";

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
    
            $result = $stmt->get_result();

            if($result->num_rows == 0){
                
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
                    <h3>Akun udah ada</h3>
                    <br>resubmit form? 
                    <br><a href='../login.html'>Login</a>
                    </div>";
            }
        }
    }
?>