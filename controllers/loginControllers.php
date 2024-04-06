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
         if ($admin = $request->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['admin']=$admin;
            header("location:../admin/");
            exit;
        }
     else{
          $error ="Incorrect Username or Password !!!";
     }
    
}

?>