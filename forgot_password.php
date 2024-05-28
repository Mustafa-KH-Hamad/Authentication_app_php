<?php
session_start();
require('database.php');
$toDatabase =  new database();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication app</title>
</head>
<body>
    <form action="forgot_password.php" method="post">
        <label for="email_input">Enter your email :</label>
        <input type="text" name="email_input" id="email_input" class="email_input">
        <button type="submit" name="submit_email">Get email</button>
    </form>
    <form action="sign_in.php" method="post">
        <button type="submit" name="logout_btn">Go Back!</button>
    </form>
</body>
</html>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

if(!empty($_POST['email_input'])){
    if(isset($_POST['submit_email'])){
        if($toDatabase->CheckEmail($_POST['email_input'])){
            
            $mail = new PHPMailer(true);

            try {
                $_SESSION['email_input']=$_POST['email_input'];
            // Server settings
            $mail->isSMTP();$mail->SMTPDebug  = SMTP::DEBUG_SERVER;
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = "email"; // Your Gmail address
            $mail->Password   = "password";   // Your Gmail app password (if 2FA enabled)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            
            // Recipients
            $mail->setFrom('rayanali996@gmail.com', 'mustafa Name');
            $mail->addAddress($_POST['email_input'], $_POST['email_input']."nameeee"); // Add a recipient
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
            $mail->send();
            echo 'Message has been sent';
            header('Location: sign_in.php');
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        
    }else{
        echo 'there is no account with that email';
        }

    }else echo 'press btn';

}echo 'enter email ';
?>