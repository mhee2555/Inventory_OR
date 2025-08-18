<?php
date_default_timezone_set("Asia/Bangkok");
// $p_DB = "1";
// $serverName = '10.11.9.6';
// $userName = 'sa';
// $userPassword = 'A$192dijd';
// $dbName = 'dental_bhq_test';




if($db == 1){

	$host = '10.11.9.21'; // e.g., localhost, 127.0.0.1
	$dbname = 'inventory_or';
	$username = 'root';
	$password = 'A$192dijd';
	$charset = 'utf8mb4'; // Recommended charset

	$conn = "mysql:host=$host;dbname=$dbname;charset=$charset";
	$options = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false,
	];
	
	try {
		$conn = new PDO($conn, $username, $password, $options);
	} catch (PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}
}else{

	$p_DB = "1";
	$serverName = '10.11.9.21';
	$userName = 'sa';
	$userPassword = 'A$192dijd';
	$dbName = 'or_smc';


	try{
		$conn = new PDO("sqlsrv:server=$serverName; Database = $dbName", $userName, $userPassword);
		$conn->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_UTF8);
	}
	catch(Exception $e){
		die(print_r($e->getMessage()));
	}
}
 





