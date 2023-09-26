<?php



    $is_login = false;

    if($_SERVER ['REQUEST_METHOD'] === "POST"){
        

        include 'dbconnect.php';

        $username = $_POST['username']; 
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

        $sql = "SELECT * FROM users WHERE username='$username'";
        
        $result = mysqli_query($conn, $sql);
        $avail = mysqli_num_rows($result);


        // var_dump($username);
        // var_dump($password);

        if($username === "admin" && $password ==="admin")
            echo"Login Sucess, Username: $username";
        else
            echo"Login Failed, Username: $username";

    }
?>