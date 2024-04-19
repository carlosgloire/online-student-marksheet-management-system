<?php
$error=null;
require_once('../../app/Form/form.php');
require_once('../../database/DBConnection.php');
$form= new Form("Sign in as principal","signin", "Sign in");
if(isset($_POST['signin'])){
    $mail=htmlspecialchars ($_POST['email']);
    $password=htmlspecialchars($_POST['password']);
    $request = $db->prepare("SELECT email,password FROM principals WHERE email = :email AND password = :password ");
         $request->bindValue(':email', $mail);
         $request->bindValue(':password', $password);
         $request->execute();
         $principal = $request->fetch(PDO::FETCH_ASSOC);
         if(empty($_POST['email']) || empty($_POST['password'])){
            $error ="Please complete all the fields!";
          }
          if(empty($_POST['email'])){
            $error ="Please complete enter email address!";
          }
          elseif(empty($_POST['password'])){
            $error ="Please enter the password!";
          }
          else{
            if ($principal) {
               $_SESSION['email']=$principal['email'];
               $_SESSION['password']=$principal['password'];
               header("location: Formteacher.php");
               exit;
            }
            else{
                  $error ="Incorrect Username or Password !!!";
            }
          }

    
}

?>