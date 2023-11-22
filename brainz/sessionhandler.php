<?php

    require "../Creds/configdb.php";

    $conn = new mysqli(
        $config["server"],
        $config["username"],
        $config["password"],
        $config["database"]
    );

    function generateCookie($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $shuffledString = str_shuffle($characters);
        return substr($shuffledString, 0, $length);
    }

    function sessionCreate($userID) {
        $SID = "SID_" . uniqid();
        $cookie = generateCookie(20);
        $expTime = time() + 1800; // 30 minutes

        $_SESSION['SID'] = $SID;
        $_SESSION['cookie'] = $cookie;
        $_SESSION['expTime'] = $expTime;
    }

    function sessionChecker(){

        
    }

    function destroyCookies(){


    }
?>