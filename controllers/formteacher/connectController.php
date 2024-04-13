<?php
$error=null;

require_once('../../database/DBConnection.php');
require_once('../../app/Form/form.php');
$form= new Form("Sign in as form teacher","signin", "Sign in");
if(isset($_POST['signin'])){
    $mail=htmlspecialchars($_POST['email']);
    $password=htmlspecialchars($_POST['password']);
    $request = $db->prepare("SELECT * FROM form_tutors WHERE email = :email ");
       //Connect the user with their name or email
         $request->bindValue(':email', $mail);
         $request->execute();
         $formteacher = $request->fetch(PDO::FETCH_ASSOC);
         $_SESSION['class_id']=$formteacher['class_id'];
         $_SESSION['id']=$formteacher['tutor_id'];
         $_SESSION['file']=$formteacher['profile_photo'];
         $_SESSION['fname']=$formteacher['fname'];
         $_SESSION['lname']=$formteacher['lname'];
         

         if ($formteacher && password_verify($password,$formteacher['password']) ) {
            $_SESSION['email_formteacher']=$formteacher['email'];
            $_SESSION['password_formteacher']=$formteacher['password'];
            header("location: formteacher_interface.php");
            exit;
        }
         else{
               $error ="Incorrect Username or Password !!!";
         }
    
}

?>