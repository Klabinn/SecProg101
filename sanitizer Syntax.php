<?php

//Buat search biar gk bisa di SQLI
$user_input = $_POST['user_input']; // Assuming user_input comes from a form

// Sanitize the user input before using it in an SQL query
$sanitized_input = mysqli_real_escape_string($conn, $user_input);

// Use $sanitized_input in your SQL query
$sql = "SELECT * FROM users WHERE username = '$sanitized_input'";
$result = mysqli_query($conn, $sql);



?>


<?php
require('db.php');
// If form submitted, insert values into the database.
if (isset($_REQUEST['username'])){
        // removes backslashes
    $username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
    $username = mysqli_real_escape_string($con,$username); 
    $email = stripslashes($_REQUEST['email']);
    $email = mysqli_real_escape_string($con,$email);
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($con,$password);
    $trn_date = date("Y-m-d H:i:s");
    $query = "INSERT into `users` (username, password, email, trn_date)
VALUES ('$username', '".md5($password)."', '$email', '$trn_date')";
        $result = mysqli_query($con,$query);
        if($result){
            echo "<div class='form'>
<h3>You are registered successfully.</h3>
<br/>Click here to <a href='login.php'>Login</a></div>";
        }
    }
?>