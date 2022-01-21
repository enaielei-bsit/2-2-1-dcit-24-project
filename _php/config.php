<?php

$db_username = "root";
$db_password = '';
$db_name = "db_stms";
$tbl_name = "tbl_sample";

$db_connection = new PDO('mysql:host=localhost;dbname=' . $db_name . ";charset=utf8", $db_username, $db_password);
$db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>