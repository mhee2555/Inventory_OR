<?php
date_default_timezone_set("Asia/Bangkok");
// $p_DB = "1";
// $serverName = '10.11.9.6';
// $userName = 'sa';
// $userPassword = 'A$192dijd';
// $dbName = 'dental_bhq_test';

$p_DB = "1";
$serverName = '10.11.9.6';
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

