<?php
require_once __DIR__."/src/connection.php";

if(isset($_SESSION['loggedUserId']) === FALSE) {
    header("Location:login.php");
}

$getUserMessages = Message::GetUserMessages($conn);
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
                <h3>All messages</h3>
                <?php
                if(count($getUserMessages) > 0){
                    foreach ($getUserMessages as $message){
                        if($message['is_read'] === '0'){
                            echo "<table class='table table-bordered'><tbody>
                                  <tr><td><strong>" . $message['login'] . "</td><td>" . timeElapsedString($message['creation_date']) . "</td></tr>
                                  <tr><td colspan='2'>" . substr($message['message_text'],0,100) . "</td></tr>
                                  <tr><td colspan='2'><a href='showmessage.php?id=" . $message['id'] . "'>Show message</a></td></tr>
                                  </tbody></table>";
                        } else{
                            echo "<table class='table table-bordered'><tbody>
                                  <tr><td>" . $message['login'] . "</td><td>" . timeElapsedString($message['creation_date']) . "</td></tr>
                                  <tr><td colspan='2'>" . substr($message['message_text'],0,100) . "</td></tr>
                                  <tr><td colspan='2'><a href='showmessage.php?id=" . $message['id'] . "'>Show message</a></td></tr>
                                  </tbody></table>";
                        }
                    }
                }else{
                    echo 'There`s no message to you';
                }
                ?>
            </div>
            <div class="col-lg-3"></div>
        </div>
        <div class="row">
            <div class="col-lg-12 copyright">© copyright 2016 - tbaranski.com</div>
        </div>
    </div>
</body>
</html>
