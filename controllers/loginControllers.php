<?php
$error=null;
if(isset($_POST['login'])){
    $mail=htmlspecialchars($_POST['mail']);
    $password=htmlspecialchars($_POST['password']);
    $request = $db->prepare("SELECT mail,password FROM users WHERE mail = :mail AND password = :password ");
      //Connect the user with their name or email
      $request->bindValue(':mail', $mail);
      $request->bindValue(':password', $password);
      $request->execute();
      if(empty($_POST['mail']) || empty($_POST['password'])){
         $error ="Please complete all the fields!";
      }
      if(empty($_POST['mail'])){
         $error ="Please complete enter email address!";
      }
      elseif(empty($_POST['password'])){
         $error ="Please enter the password!";
      }
      else{
         if ($admin = $request->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['admin']=$admin;
            header("location: classes/classes.php");
            exit;
         }
         else{
               $error ="Incorrect Username or Password !!!";
         }
      }
}

?>