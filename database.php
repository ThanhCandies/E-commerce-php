<?php
	$servername = "localhost";
	$dbname = "codestar";
	$username = "root";
	$password = "";
	$port ="3306";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;port=$port;charset=utf8", $username, $password);

    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
