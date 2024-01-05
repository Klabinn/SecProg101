<?php

    function generateCookie($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $shuffledString = str_shuffle($characters);
        $hashedString = hash('md5', $shuffledString);
        return substr($shuffledString, 0, $length);
    }

    function sessionChecker(){
        global $conn;

        $username = $_SESSION['username'];
        $currentCookie = $_COOKIE[$username];
        $current_time = time();
        $query = "SELECT * FROM usession WHERE sessionID = ? AND expdate > ?;";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('si', $currentCookie, $current_time);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 1){
            $_SESSION['is_login'] = true;
        }
        else{
            $_SESSION['is_login'] = false;
            $_SESSION['error101'] = 'Gak usah macam macam kau';
            header("Location: ../SECPROG101/signup.php?error=1");
        }
    }

    function destroyCookies(){
        global $conn;

        $current_time = time();
        $sql = "DELETE FROM usession WHERE expdate < $current_time";
        $conn->query($sql);
    }
?>