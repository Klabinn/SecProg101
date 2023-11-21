<?php
    require __DIR__ . "/../Creds/configdb.php";
    
    $conn = new mysqli(
        $config["server"],
        $config["username"],
        $config["password"],
        $config["database"]
    );
?>