<?php
    require "../Creds/configdb.php";
    
    $conn = new mysqli(
        $config["server"],
        $config["username"],
        $config["password"],
        $config["database"]
    );
?>