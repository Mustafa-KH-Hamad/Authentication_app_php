<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication app</title>
</head>
<body>
    <form action="sign_in.php" method="post">
        <label for="sign_in_email">Email: </label>
        <input type="email" name="sign_in_email" class="email_input" id="sign_in_email"  required>
        <label for="sign_in_password">Password: </label>
        <input type="password" maxlength="30" name="sign_in_password" class="password_input" id="sign_in_password" required>
        <input type="checkbox" name="sign_in_chechbox" id="submit_sign_in" class="chechbox_input" value="Remember me">
        <label for="sign_in_chechbox">Remember me </label>
        Forgot your Password Click <a href="forgot_password.php">here (NOT working)</a>
        <button type="submit" name="submit_sign_in" class="submit_btn">Sign in</button>
    </form>
    <form action="sign_up.php" method="post">
        <button type="submit" class="submit_btn" name="to_sign_up">Sign up</button>
    </form>
</body>
</html>
<?php 
require ('database.php');
$toDatabase= new database();
    if($_SERVER['REQUEST_METHOD'] == 'POST' ){

        if (isset($_POST['sign_in_email']) && isset($_POST['sign_in_password'])) {

            if (isset($_POST['submit_sign_in'])) {
    
                if ($toDatabase->CheckEmail($_POST['sign_in_email']) &&
                 $toDatabase->CheckPassword($_POST['sign_in_email'],$_POST['sign_in_password'])) {
                    
                    if (isset($_POST['sign_in_chechbox'])) {
                        $token = bin2hex(random_bytes(16));
                        setcookie('auth_cookie', $token, time() + (60 * 60 * 24 * 30),'/');
                        $toDatabase->InsertToken($_POST['sign_in_email'],$token);
                    }else {
                        setcookie('auth_cookie', '', time() +3600,'/');
                        $toDatabase->InsertToken($_POST['sign_in_email'],null);
                    }
                    $_SESSION["email"]=$_POST['sign_in_email'];
                    header('Location: index.php');
                    exit();

                }else echo'incorrect email or password';

            }else echo'error accured server submit btn';

        }else echo 'no  entery data';
    }

    else echo 'Server error';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['to_sign_up'])) {
    header('Location: sign_up.php');
    exit();
}
?>