<?php
require_once __DIR__."/src/connection.php";

if(isset($_SESSION['loggedUserId']) === FALSE) {
    header("Location:login.php");
}

if(!empty($_GET)){
    !empty($_GET['toId']) && !empty($_GET['fromId']) ? ($_SESSION['toId'] = $_GET['toId']) && ($_SESSION['fromId'] = $_GET['fromId']) : '';
}else{
    header("Location:index.php");
}
$_SESSION['lastSiteUrl'] = lastSiteUrl();
?>

<!DOCTYPE html>
<html>
<meta charset='UTF-8'>
<head>
    <title>Uzytkownik</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery-1.12.4.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row ">
            <div class="col-lg-2 text-center"><a href="index.php" title="Main page">Logo Twitter</a></div>
            <div class="col-lg-1 col-lg-offset-6 text-center">
                <a href="showallusers.php" title="Search"><span class="glyphicon glyphicon-search"></span></a>
            </div>
            <div class="col-lg-1 text-center">
                <?php
                $unreadMessages = Message::CountUnreadMessages($conn);
                if($unreadMessages > 0 ){
                    echo '<a href="showmessages.php" title="New messages!"><span class="glyphicon glyphicon-envelope unread-message"> (' . $unreadMessages . ')</span></a></strong>';
                }else{
                    echo '<a href="showmessages.php" title="Messages"><span class="glyphicon glyphicon-envelope"></span></a>';
                }
                ?>
            </div>
            <div class="col-lg-1 text-center"><a href="edituser.php" title="Settings"><span class="glyphicon glyphicon-cog"></span></a></div>
            <div class="col-lg-1 text-center"><a href="logout.php" title="Sing out"><span class="glyphicon glyphicon-off"></span></a></div>
        </div>
        <div class="row top-buffer">
            <div class="col-lg-3"></div>
            <div class="col-lg-6 text-center">
                <h4>Write your message</h4>
                <form action="savemessage.php" method="post">
                <fieldset>
                    <input type="text" name="messageText" minlength="1" class="form-control input-lg input-height"><br />
                    <button type="submit" class="btn btn-primary">Send</button>
                </fieldset>
                </form>
            </div>
            <div class="col-lg-3"></div>
        </div>
        <div class="row">
            <div class="col-lg-12 copyright">© copyright 2016 - tbaranski.com</div>
        </div>
    </div>
</body>
</html>
