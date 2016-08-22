<?php
require_once __DIR__."/src/connection.php";

if(isset($_SESSION['loggedUserId']) === FALSE) {
    header("Location:login.php");
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $userName = $_POST['userName'];
    $allUsers = User::GetUsers($conn, $userName);
}
?>

<!DOCTYPE html>
<html>
<meta charset='UTF-8'>
<head>
    <title>Szukaj uzytkownika</title>
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
                <h3>Search for users</h3>
                <form action="#" method="post">
                <fieldset>
                    <input type="text" maxlength="20" name="userName" class="form-control input-lg"><br />
                    <button type="submit" class="btn btn-primary">Search</button>
                </fieldset>
                </form>
                <br />
                <?php
                if($_SERVER['REQUEST_METHOD'] === 'POST'){
                    if(count($allUsers) > 0){
                        foreach ($allUsers as $user){
                            echo $user->getLogin() . '<br />';
                            if(!empty($user->getDescription())){
                                echo $user->getDescription() . '<br />';
                            }
                            echo "<a href='showuser.php?id={$user->getId()}'>Zobacz posty </a><br/><br/>";
                        }
                    }else{
                        echo 'No results';
                    }
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