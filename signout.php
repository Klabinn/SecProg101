<?php

    setcookie('user', '', time() - 3600, '/');
    destroyCookies();
    session_destroy();
    header("Location: /home.php");
?>