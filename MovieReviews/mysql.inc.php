<?php
//mysql.inc.php
session_start();	//now every page that talks to the database also can use session vars

$dbuser = "caoc0001";
$dbpass = "40709873";
$dbname = "caoc0001";
$dbhost = "localhost";

$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass) or die("DIEEEEEEEEEEE");
?>