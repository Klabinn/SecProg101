<?php

    function generateCookie($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $shuffledString = str_shuffle($characters);
        $hashedString = hash('md5', $shuffledString);
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

        setcookie($_SESSION['username'], $cookie, $expTime, '/');
        $_SESSION['cookie'] = $cookie;

        unset($_SESSION['userID']);
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
        $conn->close();
    }
?>