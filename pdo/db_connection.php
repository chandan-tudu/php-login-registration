<?php
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'php_login';

// DSN(Database Source Name)
$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8";

try {
   
   $conn = new PDO($dsn, $db_user, $db_password);
   // SET THE PDO ERROR MODE TO EXCEPTION
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
   echo "Connection failed - " . $e->getMessage();
   exit;
}