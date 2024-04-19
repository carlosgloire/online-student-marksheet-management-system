<?php
$error = null;

require_once('../../database/DBConnection.php');
require_once('../../app/Form/form.php');

$form = new Form("Sign in as form teacher", "signin", "Sign in");

if (isset($_POST['signin'])) {
    $mail = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if (empty($_POST['email']) || empty($_POST['password'])) {
        $error = "Please complete all the fields!";
    } elseif (empty($_POST['email'])) {
        $error = "Please enter email address!";
    } elseif (empty($_POST['password'])) {
        $error = "Please enter the password!";
    } else {
        $request = $db->prepare("SELECT * FROM form_tutors WHERE email = :email ");
        $request->bindValue(':email', $mail);
        $request->execute();
        
        $formteacher = $request->fetch(PDO::FETCH_ASSOC);
        
        if ($formteacher) {
            // User found, now verify password
            if (password_verify($password, $formteacher['password'])) {
                $_SESSION['class_id'] = $formteacher['class_id'];
                $_SESSION['id'] = $formteacher['tutor_id'];
                $_SESSION['file'] = $formteacher['profile_photo'];
                $_SESSION['fname'] = $formteacher['fname'];
                $_SESSION['lname'] = $formteacher['lname'];
                $_SESSION['email_formteacher'] = $formteacher['email'];
                $_SESSION['password_formteacher'] = $formteacher['password'];
                header("location: formteacher_interface.php");
                exit;
            } else {
                $error = "Incorrect Username or Password !!!";
            }
        } else {
            $error = "No user found with this email address.";
        }
    }
}

?>