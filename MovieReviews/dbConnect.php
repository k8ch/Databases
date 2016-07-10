<?php
//mysql.inc.php
session_start();
$conn_string = "host=localhost port=15432 dbname=example user=example password=example";
$dbconn = pg_connect($conn_string);
?>