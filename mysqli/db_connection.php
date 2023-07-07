<?php
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'php_login';

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

// CHECKING THE DATABASE CONNECTION
if(mysqli_connect_errno()){
    echo "Connection Failed - ".mysqli_connect_error();
    exit;
}