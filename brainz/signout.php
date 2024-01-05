<?php
    session_start();

    require_once 'dbconnect.php';
    require_once 'sessionhandler.php';

    $rahasia = $_SESSION['cookie'];

    $sql = "DELETE FROM usession WHERE sessionID = $rahasia";
    $conn->query($sql);

    setcookie("user", "", time() - 36000, "/");
    destroyCookies();
    session_destroy();

    header("Location: ../home.php");
?>