<?php
$error=null;
if(isset($_POST['login'])){
   $mail=htmlspecialchars($_POST['mail']);
   $password=htmlspecialchars($_POST['password']);
   //Connect the user with their name or email
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
      $request = $db->prepare("SELECT mail,password FROM users WHERE mail = :mail ");
      $request->bindValue(':mail', $mail);
      $request->execute();
      $admin = $request->fetch(PDO::FETCH_ASSOC);
      if($admin){
         if (password_verify($password,$admin['password'])) {
            $_SESSION['admin']=$admin;
            header("location: classes/classes.php");
            exit;
         }
         else{
            $error ="Email  or Password is incorrect!";
         }
      } else {
         $error = "No user found with this email address.";
      }
   }

}

?>