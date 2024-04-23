<?php
$error=null;
require_once('../../app/Form/form.php');
require_once('../../database/DBConnection.php');
$form= new Form("Sign in as principal","signin", "Sign in");
if(isset($_POST['signin'])){
    $mail=htmlspecialchars ($_POST['email']);
    if(isset($_POST['password'])){
      $password= htmlspecialchars($_POST['password']);
    }
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
      $request = $db->prepare("SELECT * FROM principals WHERE mail = :mail ");
      $request->bindValue(':mail', $mail);
      $request->execute();
      $principal = $request->fetch(PDO::FETCH_ASSOC);
      if($principal)
      {
        if (password_verify($password,$principal['password'])) {
          $_SESSION['email']=$principal['email'];
          $_SESSION['password']=$principal['password'];
          header("location: Formteacher.php");
          exit;
        }
      }
      else{
        $error ="Incorrect Username or Password !!!";
     }
    }

    
}

?>