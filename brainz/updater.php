<?php
    session_start();

    if($_SESSION['is_login'] !== true){
        
        header("Location: login.php");
    }

    if($_SERVER ['REQUEST_METHOD'] === "POST"){
        
        require_once 'dbconnect.php';
        require_once "sessionhandler.php";

        destroyCookies();

        $sql = "SELECT * FROM users WHERE username=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $userid = $row['userID'];
        $stmt->close();
        
        $originaltitle = trim($_POST['OriginalTitle']);
        $pricechange = trim($_POST['pricechange']);

        $originaltitle = htmlspecialchars($originaltitle, ENT_QUOTES, 'UTF-8');
        $pricechange = htmlspecialchars($pricechange, ENT_QUOTES, 'UTF-8');

        $sql = "SELECT * FROM bodyparts WHERE title = ? && userID = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $originaltitle, $userid);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows === 1){
            $sql = "UPDATE bodyparts SET price=? WHERE userID =?;";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $pricechange, $userid);
            $stmt->execute();
            $stmt->close();

            $_SESSION['error101'] = "Ganti harga ya? Wes tak ganti yo.";
            header("Location: ../offerAudit.php?error=1");  
        }
        else{
            $_SESSION['error101'] = "Salah Mas/Mbak Cek lgi?";
            header("Location: ../updateOffer.php?error=1");    
        }

    }
?>