<?php
$error=null;
require_once('../../app/Form/form.php');
require_once('../../database/DBConnection.php');
$form= new Form("Sign in as principal","signin", "Sign in");
if(isset($_POST['signin'])){
    $mail=htmlspecialchars($_POST['email']);
    $password=htmlspecialchars($_POST['password']);
    $request = $db->prepare("SELECT email,password FROM principals WHERE email = :email AND password = :password ");
       //Connect the user with their name or email
         $request->bindValue(':email', $mail);
         $request->bindValue(':password', $password);
         $request->execute();
         if(empty($_POST['email']) & empty($_POST['password'])){
            $error ="Incorrect Username or Password !!!";
         }
         if ($tutor = $request->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['email']=$tutor['email'];
            $_SESSION['password']=$tutor['password'];
            header("location: Formteacher.php");
            exit;
        }
         else{
               $error ="Incorrect Username or Password !!!";
         }
    
}

?>