<?php
session_start();
require('database.php');
$toDatabase = new database();

if(isset($_SESSION["email_input"])){
    if(isset($_POST["change_password_input"])){
    $toDatabase->ChangePassword($_SESSION["email_input"],$_POST['new_password']);
    }else echo 'press the btn';
}else {
    echo 'email does not match you cant chagne the password';
    header('Location : sign_in.php');
    exit();
}
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication app </title>
</head>
<body>
    <form action="rest_password.php" method="post">
        <label for="new_password">Enter new Password </label>
        <input type="password" maxlength="30" class="password_input" id="new_password" name="new_password">
        <button type="submit" name="change_password_btn">Change password</button>

    </form>
</body>
</html>