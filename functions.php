<?php
session_start();
function logout(){
    if(isset($_POST['logout'])){
        session_destroy();
        header('location: ../login.php');
        exit();
    }
}
logout();
function notconnected(){
    if (! isset($_SESSION['admin'])) {
        // Redirect to the login page if not logged in
        header("Location: ../login.php");
        exit();
    }
}

notconnected();