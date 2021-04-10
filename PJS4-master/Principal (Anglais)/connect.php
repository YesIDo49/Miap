<?php
	$hostname = "localhost";	//or localhost
	$base= "miap_bdd";
	$loginBD= "root";	//or "root"
	$passBD="root";
	//$pdo = null;

try {

	$pdo = new PDO ("mysql:server=$hostname; dbname=$base", "$loginBD", "$passBD");
}

catch (PDOException $e) {
	die  ("Log in failure : " . $e->getMessage() . "\n");
}