<?php
session_start();
$error = null;
$success = null;
require_once('../app/Form/form.php');
$mysqli = require(__DIR__ . "/mail/database.php");
require(__DIR__ . "../../../database/DBConnection.php");

$form = new Form('Sign up', "signup", "Sign up");
$form->addField("text", "fname", "First name", "Enter First name");
$form->addField("text", "lname", "Last name", "Enter Last name");
$form->addField("text", "email", "Email", "Enter email");
$form->addField("password", "password", "Password", "Enter password");
$form->addField("password", "password_repeat", "Repeat password", "Repeat password entered");

if (isset($_POST['signup'])) {
    $first_name = htmlspecialchars($_POST['fname']);
    $last_name = htmlspecialchars($_POST['lname']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $repeat_password = htmlspecialchars($_POST['password_repeat']);
    //Check if an email is already used for another account
    $existing_email_query = $db->prepare('SELECT mail FROM users WHERE mail= ?');
    $existing_email_query->execute(array($email));
    $existing_email = $existing_email_query->fetch();
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($repeat_password)) {
        $error = "Please complete all fields";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Your email is incorrect";
    } elseif($existing_email){
        $error = "This email has been used for another account creation on this system";  
    }elseif (!preg_match("#[a-zA-Z]+#", $_POST['password']) ||
        !preg_match("#[0-9]+#", $_POST['password']) ||
        !preg_match("#[\!\@\#\$\%\^\&\*\(\)\_\+\-\=\[\]\{\}\;\:\'\"\,\<\>\.\?\/\`\~\\\|\ ]+#", $_POST['password'])) {
        $error = "Your password must contain at least one letter, one number, and one special character.";
} elseif ($password !== $repeat_password) {
        $error = "Passwords don't match.";
    } else {
        $hashed_password = password_hash($repeat_password, PASSWORD_DEFAULT);

        $query = $mysqli->prepare("SELECT * FROM users WHERE mail = ? AND fname = ? AND lname = ?");
        $query->bind_param("sss", $email, $first_name, $last_name);
        $query->execute();
        $mail_query = $query->get_result()->fetch_assoc();

        if ($mail_query) {
            $error = "There is another account created with this username and email address";
        } else {
            $_SESSION['fname'] = $first_name;
            $_SESSION['lname'] = $last_name;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $hashed_password;

            $mail = require __DIR__ . "/mail/mailer.php";
            $mail->setFrom("noreply@example.com");
            $mail->addAddress($email);
            $mail->Subject = "Account confirmation";
            $mail->Body = <<<END
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
                <title>Document</title>
                <style>
                    .roboto-thin-italic {
                        font-family: "Roboto", sans-serif;
                        font-weight: 100;
                        font-style: italic;
                    }
                    .central-div{
                        border: 1px solid;
                        background-color: #383c49;
                        padding: 0;
                        margin: 0;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-family: 'Montserrat-Regular.ttf';
                    }
                    .container{
                        margin: 50px;
                        background-color: #fff;
                        width:40%;
                        margin-left: auto;
                        margin-right: auto;
                        padding:1.25rem;
                        text-align:center;
                        border-radius: 0.375rem;
                    }
                    .btn{
                        margin: auto;
                        background-color: #383c49;
                        padding: 0.5rem;
                        width: 35%;
                        cursor:pointer;
                        color: white;
                        opacity: 0.75;
                        margin-top: 0.75rem;
                        margin-bottom: 0.75rem;
                        border-radius: 5px;
                    }
                    .btn a{
                        color:white;
                        text-decoration:none;
                    }
                    @media screen and (max-width:1000px) {
                        .container{
                            width: 70%;
                        }   
                    }
                    @media screen and (max-width:550px) {
                        .container{
                            width: 90%;
                        }   
                    }
                </style>
            </head>
            <body>
                <div class="central-div">
                    <div class="container">
                        <img class="mx-auto" src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTP0FN9vRGbZotUafE367RiGoiEl3rLPOqOlKZWscBVluj45fEZ" alt="" width="100px" height="120px">
                        <p>Hello $first_name $last_name,</p> 
                        <p>Thank you for registering to Student marksheet management system! We are excited to have you join our community. To complete the registration process, simply click on the “Confirm Account” button below:</p>
                        <p class="btn "><a href='http://localhost/armel-dashboard/controllers/signup/confirm-account.php'>Confirm account</a></p>
                        <hr>
                        <p style="font-size: 0.875rem;">If you did not request any registration to our account, you can ignore this email.</p>
                    </div>
                </div>
            </body>
            </html>
            END;
                
            try {
                $mail->send();
            } catch (Exception $e) {
                $error = "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
            }

            $success = "Message sent to your email, please check your inbox to confirm your account.";
        }
    }
}
?>
