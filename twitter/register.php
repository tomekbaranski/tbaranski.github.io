<?php
require_once __DIR__."/src/connection.php";

if($_SERVER["REQUEST_METHOD"] === 'POST'){
    $userToRegister = new User();
    $userToRegister->setLogin($_POST['login']);
    $userToRegister->setPassword($_POST['password1'], $_POST['password2']);
    $userToRegister->activate();
    $registerSucess = $userToRegister->saveToDB($conn);
    if($registerSucess){
        $_SESSION['loggedUserId'] = $userToRegister->getID();
        header("Location:index.php");
    } else {
        echo ' Rejestracja nieudana. Sprobuj ponownie';
    }
}
?>

<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<head>
    <title>Rejestracja</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery-1.12.4.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row ">
            <div class="col-lg-4"></div>
            <div class="col-lg-4 top-login">
                <h2>Register</h2>
                <p></p>
                <form action="#" method="post">
                    <fieldset>
                        <label>Login </label><input type="text" name="login" class="form-control input-lg"><br />
                        <label>Password </label><input type="password" name="password1" class="form-control input-lg"><br />
                        <label>Repeat password </label><input type="password" name="password2" class="form-control input-lg"><br />
                        <button type="submit" class="btn btn-primary">Join now</button>
                    </fieldset>
                </form>
                <p class="top-p">Allready have the account?<a href="login.php"> Log in</a></p>
            </div>
            <div class="col-lg-4"></div>
        </div>
    </div>
</body>
</html>





