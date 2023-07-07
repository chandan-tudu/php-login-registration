<?php
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'php_login';

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// CHECK DATABASE CONNECTION
if($conn->error){
    echo "Connection Failed - ".$db_connection->connect_error;
    exit;
}