<?php
require_once __DIR__."/src/connection.php";

if(isset($_SESSION['loggedUserId'])){
    header("Location:index.php");
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $loggedUser = User::LogIn($conn, $_POST['login'], $_POST['password']);
    if($loggedUser != null){
        $_SESSION['loggedUserId'] = $loggedUser->getID();
        header("Location:index.php");
    } else {
        $errorMessage = 'Incorrect login or password. Try again.';
    }
}
?>

<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<head>
    <title>Sign in</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery-1.12.4.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row ">
            <div class="col-lg-4"></div>
            <div class="col-lg-4 top-login">

                <h2>Welcome</h2>
                <p></p>
                <form action="#" method="post">
                <fieldset>
                    <label>Login</label><input type="text" name="login" class="form-control input-lg"><br />
                    <label>Password</label><input type="password" name="password" class="form-control input-lg"><br />
                    <button type="submit" class=" btn btn-primary">Sign in</button>
                </fieldset>
                </form>
                <p class="top-p">Not a member? <a href="register.php">Join in</a></p>
            </div>
            <div class="col-lg-4"></div>
        </div>
        <?php
        if(isset($errorMessage)) {
            echo '<div class="row">
                         <div class="col-lg-3"></div>
                         <div class="col-lg-6 error-message">' . $errorMessage . '</div>
                         <div class="col-lg-3"></div>
                   </div>';
        }
        ?>
    </div>
</body>
</html>

