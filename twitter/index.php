<?php
require_once __DIR__."/src/connection.php";

if(isset($_SESSION['loggedUserId'])){
    $loggedUser = new User();
    $loggedUser->loadFromDB($conn, $_SESSION['loggedUserId']);
}else{
    header("Location:login.php");
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $newPost = new Post();
    $newPost->setUserId($_SESSION['loggedUserId']);
    $newPost->setPostText($_POST['PostText']);
    $newPost->saveToDB($conn);
}
?>

<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<head>
    <title>Twitter</title>
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
                <h2>Write something</h2>
                <form action="#" method="post">
                    <fieldset>
                        <div class="form-group"><input type="text" name="PostText" minlength="1" class="form-control input-lg"></div>
                        <button type="submit" class="btn btn-primary">Post it!</button>
                    </fieldset>
                </form>
            </div>
            <div class="col-lg-3"></div>
        </div>
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6 text-center top-latest-post">
                <h3>Latest posts</h3>
                <?php
                $allPosts = Post::GetAllPosts($conn);
                if(count($allPosts)>0){
                    $lastTenPosts = array_slice($allPosts, 0, 8);
                    foreach ($lastTenPosts as $user){
                        echo  "<table class='table table-bordered'><tbody>
                    <tr><td> ". $user['login'] ."</td><td>" . timeElapsedString($user['creation_date']) . "</td></tr>
                    <tr><td colspan='2'>" . $user['post_text'] . "</td></tr>
                    <tr><td colspan='2' class='show-comments'><a href='showpost.php?id=" . $user['id'] . "'>Show comments</a></td></tr>
                    </tbody></table><br />";
                    }
                }else{
                    echo '<h2>Write the first post!</h2>';
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








