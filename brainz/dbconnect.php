<?php

	$servername = "localhost";
	$username = "root";
	$password = "";

	$database = "secureSQL";

	$conn = mysqli_connect($servername, $username, $password, $database);

// for debuging only
	if($conn) {
		echo "masshook";
	}
	else {
		die("Error". mysqli_connect_error());
	}
?>
