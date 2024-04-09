<?php
//principal page
session_start();
function logout(){
    if(isset($_POST['logout'])){
        session_destroy();
        header('location: ../login.php');
        exit();
    }
}

function notconnected(){
    if (! isset($_SESSION['admin'])) {
        // Redirect to the login page if not logged in
        header("Location: ../login.php");
        exit();
    }
}

//principal page


function notconnected_tutor(){
    if (! isset($_SESSION['tutors'])) {
        // Redirect to the login page if not logged in
        header("Location: connect.php");
        exit();
    }
}