<?php

$db_host = 'localhost';
$db_user = 'root';
$db_password = "coderslab";
$db_name = "bookshelf";

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);
$conn->set_charset('utf8');

if($conn->connect_error){
    die('Bład' . $conn->connect_error);
}
?>