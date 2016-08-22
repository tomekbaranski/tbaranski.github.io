<?php
require_once __DIR__."/src/connection.php";

if(isset($_SESSION['loggedUserId'])){
    $loggedUser = new User();
    $loggedUser->loadFromDB($conn, $_SESSION['loggedUserId']);
}else{
    header("Location:login.php");
}

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $loadPost = new Post();
    $loadPost->loadFromDB($conn, $_GET['id']);

    $postAuthor = new User();
    $postAuthor->loadFromDB($conn, $loadPost->getUserId());

    $getAllCommentsForPost = Comment::GetAllCommentsForPost($conn, $_GET['id']);
}

$_SESSION['postID'] = $loadPost->getID();

?>

<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<head>
    <title>Post</title>
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
            <div class="col-lg-6 text-center top-latest-post">
                <table class="table table-bordered">
                    <tbody>
                        <tr class="post-table">
                            <td><?php echo '<a href="showuser.php?id=' . $postAuthor->getID() . '">' . $postAuthor->getLogin() . '</a>' ?></td>
                            <td><?php echo timeElapsedString($loadPost->getCreationDate())?></td>
                        </tr>
                        <tr class="post-table"><td colspan="2"><?php echo $loadPost->getPostText() ?></td></tr>
                    <tr><td colspan="2" class="right-table">Comments</td></tr>
                    <tr>
                        <td colspan="2">
                            <?php
                            if(count($getAllCommentsForPost) > 0){
                                foreach ($getAllCommentsForPost as $comment){
                                    echo  "<table class='table'><tbody>
                                   <tr><td> ". $comment['login'] ."</td><td>" . timeElapsedString($comment['creation_date']) . "</td></tr>
                                   <tr><td colspan='2'>" . $comment['comment'] . "</td></tr>
                                   </tbody></table>";
                                }
                            }else{
                                echo 'Brak komentarzy. Napisz pierwszy.<br />';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <form action="savecomment.php" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input type="text" name="newCommnet" class="form-control input-lg"><br />
                                    <button type="submit" class="btn btn-primary">Comment</button>
                                </div>
                            </fieldset>
                            </form>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-3"></div>
        </div>
        <div class="row">
            <div class="col-lg-12 copyright">© copyright 2016 - tbaranski.com</div>
        </div>
    </div>
</body>
</html>








