<?php

require_once __DIR__."/src/connection.php";

if(isset($_SESSION['loggedUserId'])){
    $loggedUser = new User();
    $loggedUser->loadFromDB($conn, $_SESSION['loggedUserId']);
}else{
    header("Location:login.php");
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newMessage = new Message();
    $newMessage->setSenderId($_SESSION['fromId']);
    $newMessage->setReceiverId($_SESSION['toId']);
    $newMessage->setMessageText($_POST['messageText']);
    $newMessage->messageNotOpened();
    $newMessage->saveToDB($conn);
}
$receiverId = $_SESSION['toId'];
unset($_SESSION['toid']);
unset($_SESSION['fromId']);

$_SESSION['lastSiteUrl'] === 'showmessage.php' ? header("Location:showmessages.php") : header("Location:showuser.php?id=$receiverId");

?>