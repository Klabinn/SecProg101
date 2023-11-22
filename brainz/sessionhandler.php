<?php

    function generateCookie($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $shuffledString = str_shuffle($characters);
        return substr($shuffledString, 0, $length);
    }

    function sessionCreate($userID) {
        global $conn;
        $SID = "SID_" . uniqid();
        $cookie = generateCookie(40);
        $expTime = time() + 1800; // 30 minutes

        $_SESSION['SID'] = $SID;
        $_SESSION['cookie'] = $cookie;
        $_SESSION['expTime'] = $expTime;
        $userid = $_SESSION['userID'];

        $query = "INSERT INTO usession (SID, userID, sessionID, expdate) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssi', $SID, $userid, $cookie, $expTime);
        $stmt->execute();
        $stmt->close();

        setcookie('user', $cookie, $expTime, '/');
        $_SESSION['cookie'] = $cookie;

        unset($_SESSION['userID']);
    }

    function sessionChecker(){
        global $conn;

        $currentCookie = $_COOKIE['value'];
        $current_time = time();

        $query = "SELECT *  FROM usession WHERE sessionID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $currentCookie);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();
        if($result->num_rows === 1){
            $_SESSION['is_login'] = true;
        }
        else{
            $_SESSION['is_login'] = false;
        }
    }

    function destroyCookies(){
        global $conn;
        
        $current_time = time();
        $sql = "DELETE FROM usession WHERE expiration_time < $current_time";
        $conn->query($sql);
        $conn->close();
    }
?>