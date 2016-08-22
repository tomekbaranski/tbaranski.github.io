<?php

require_once __DIR__."/src/connection.php";

if(isset($_SESSION['loggedUserId'])){
    $loggedUser = new User();
    $loggedUser->loadFromDB($conn, $_SESSION['loggedUserId']);
}else{
    header("Location:login.php");
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newCommnet = new Comment();
    $newCommnet->setPostId($_SESSION['postID']);
    $newCommnet->setUserID($_SESSION['loggedUserId']);
    $newCommnet->setComment($_POST['newCommnet']);
    $newCommnet->saveToDB($conn);
}
$post_id = $_SESSION['postID'];
unset($_SESSION['postID']);
header("Location:showpost.php?id=$post_id");

?>