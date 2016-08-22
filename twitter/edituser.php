<?php
require_once __DIR__."/src/connection.php";

if(isset($_SESSION['loggedUserId'])){
    $loggedUser = new User();
    $loggedUser->loadFromDB($conn, $_SESSION['loggedUserId']);
}else{
    header("Location:login.php");
}

$user = new User();
$user->loadFromDB($conn, $_SESSION['loggedUserId']);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['changeDescription'])){
        $user->setDescription($_POST['changeDescription']);
        $user->saveToDB($conn);
        $statment = 'Description change';
    }elseif (isset($_POST['passwordChange'])){
        if($_POST['newPassword1'] === $_POST['newPassword2']){
            if($user->verifyPassword($_POST['currentPassword'])){
                $user->setPassword($_POST['newPassword1'], $_POST['newPassword2']);
                $user->saveToDB($conn);
                $statment = 'Password changed';
        }else{
                $statment = 'wrong password';
            }
        }else{
            $statment = 'not equal';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<head>
    <title>Ustawienia</title>
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
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
                <h3>Settings</h3>
                <br />
                <?php
                echo '<h5>Login: <strong>' . $user->getLogin() . '</strong></h5>';
                echo '<h5>Description: <strong> ' . $user->getDescription() . '</strong></h5>';
                ?>

                <?php
                if($statment === 'Password changed'){
                    echo 'Hasło zmienione <br />';
                }elseif($statment === 'wrong password'){
                    echo 'Podane hasło nieprawidłowe <br />';
                }elseif($statment === 'not equal'){
                    echo 'Podane hasła są różne <br />';
                }elseif($statment === 'Description change'){
                    echo 'Opis został zmieniony <br />';
                }
                ?>

                <br />
                <h4>Change description</h4>
                <form action="#" method="post">
                <fieldset>
                    <div class="form-group">
                        <input type="text" maxlength="500" name="changeDescription" minlength="1" class="form-control input-lg input-height"><br />
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </fieldset>
                </form>
                <br /><br />
                <h4>Change password</h4>
                <form action="#" method="post">
                <fieldset>
                    <div class="form-group"></div>
                        <table>
                            <tbody>
                                <tr><td style="width:160px"><label>Current password</label></td><td><input type="password" name="currentPassword" class="form-control-password"></td></tr>
                                <tr><td><label>New password</label></td><td><input type="password" name="newPassword1" minlength="5" maxlength="15" class="form-control-password"></td></tr>
                                <tr><td><label>Retype new password</label></td><td><input type="password" name="newPassword2" minlength="5" maxlength="15" class="form-control-password"></td></tr>
                                <tr><td colspan="2"><button type="submit" name="passwordChange" class="btn btn-primary">Save</button></td></tr>
                            </tbody>
                        </table>
                    </div>
                </fieldset>
                </form>
            </div>
            <div class="col-lg-1"></div>
        </div>
        <div class="row">
            <div class="col-lg-12 copyright">© copyright 2016 - tbaranski.com</div>
        </div>
    </div>
</body>
</html>








