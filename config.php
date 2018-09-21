<?php

define('DB_SERVER','localhost');
define('DB_USERNAME','swasthaadmin');
define('DB_PASSWORD','admin@123');
define('DB_NAME','swastha');

try{
    $pdo = new PDO("mysql:host=". DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
	$pdo-> setAttribute (PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
	die("ERROR: COULD NOT CONNECT:".$e-> getMessage());

}
?>
