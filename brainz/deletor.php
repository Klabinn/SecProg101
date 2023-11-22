<?php
    session_start();

    if($_SESSION['is_login'] !== true){
        
        header("Location: login.php");
    }

    if($_SERVER ['REQUEST_METHOD'] === "POST"){
        
        require_once 'dbconnect.php';

        $sql = "SELECT * FROM users WHERE username=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $userid = $row['userID'];
        $stmt->close();

        $ttd = strip_tags($_POST['ttd']);

        $sql = "SELECT * FROM bodyparts WHERE title = ? && userID = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $ttd, $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if($result->num_rows === 1){
            $sql = "DELETE FROM bodyparts WHERE title = ? AND userID =?;";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $ttd, $userid);
            $stmt->execute();
            $stmt->close();

            $_SESSION['error101'] = "Yah Masa kamu  gak jadi jual? D:";
            header("Location: ../offerAudit.php?error=1");  
        }
        else{
            $_SESSION['error101'] = "Salah Mas/Mbak Cek lgi ya.";
            header("Location: ../deleteOffer.php?error=1");    
        }

    }
?>