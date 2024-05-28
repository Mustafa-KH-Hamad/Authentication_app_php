<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication app</title>
</head>
<body>
    <form action="sign_up.php" method="post">
        <label for="sign_up_email">Email :</label>
        <input type="email" id="sign_up_email" class="email_input" name="sign_up_email" required>
        <label for="sign_up_password">Password : </label>
        <input type="password" maxlength="30" id="sign_up_password" name="sign_up_password" class="password_input" required>
        <button type="submit" class="submit_btn" name="submit_sign_up">Sign up</button>
    </form>
    <form action="sign_in.php" method="post">
        <button type="submit" class="submit_btn" name="to_sign_in">Sign in</button>
    </form>
</body>
</html>
<?php 
require ('database.php');
$toDatabase= new database();
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        if (!empty($_POST['sign_up_email']) && !empty($_POST['sign_up_password'])) {

            if (isset($_POST['submit_sign_up'])) {

                if(!$toDatabase->CheckEmail($_POST['sign_up_email'])){

                    $toDatabase->InsertData($_POST['sign_up_email'],$_POST['sign_up_password']);
                    header("Location: sign_in.php");
                    exit();

                }else echo "Email is taken by another User";

            }else echo "Press submit button "; 

        }

        else echo "Email and password requiered !";}

    else echo 'server error';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['to_sign_in'])){

    header("Location: sign_in.php");
    exit();
    
}
?>