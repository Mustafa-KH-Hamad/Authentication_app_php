<?php
require('database.php');
$toDatabase = new database();

session_start();
    if (isset($_POST['say_meow'])){
        echo '<p>meow</p>';
    }
    if (isset($_POST['logout_btn'])){
        session_destroy();
    }  
    if (isset($_COOKIE['auth_cookie'])){
        $isAvalabileToken = $toDatabase->CheckToken($_COOKIE['auth_cookie']);
        echo '<div>
        <h3>Hello  '.$_SESSION["email"].'</h3>
        Start testing the authentication app
    </div>
    <form action="index.php" method="post">
        <button type="submit" name="say_meow">Cat!</button>
    </form>
    <form action="sign_in.php" method="post">
        <button type="submit" name="logout_btn">log out</button>
    </form>';
        
    }else if (isset($_SESSION['email'])){
        echo '<div>
        <h3>Hello  '.$_SESSION["email"].'</h3>
        Start testing the authentication app
    </div>
    <form action="index.php" method="post">
        <button type="submit" name="say_meow">Cat!</button>
    </form>
    <form action="sign_in.php" method="post">
        <button type="submit" name="logout_btn">log out</button>
        
    </form>';
    
       exit();
    } 
     else{
        session_destroy();
        header('Location:sign_in.php');
        exit();
    }
        
           
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication app</title>
</head>
<body>
    
</body>
</html>