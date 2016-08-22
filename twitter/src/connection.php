<?php
session_start();

require_once __DIR__."/user.php";
require_once __DIR__."/post.php";
require_once __DIR__."/comment.php";
require_once __DIR__."/message.php";
require_once __DIR__."/functions.php";

$db_host = 'localhost';
$db_user = 'root';
$db_password = "coderslab";
$db_name = "twitter";

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);
$conn->set_charset('utf8');

if($conn->connect_error){
    die('Bład' . $conn->connect_error);
}

?>