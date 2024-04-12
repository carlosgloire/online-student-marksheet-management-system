<?php
//principal page
function logout(){
    if(isset($_POST['logout'])){
        session_destroy();
        header('location: ../login.php');
        exit();
    }
}
function logout_principal(){
    if(isset($_POST['logout'])){
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        header('location: connect.php');
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


function notconnected_principal(){
    if (! isset($_SESSION['email']) AND ! isset($_SESSION['password']) ) {
        // Redirect to the login page if not logged in
        header("Location: connect.php");
        exit();
    }
}
//Function to check session expiration
function verifysession_principal(){
    // Set the session expiration time
$expiration = 20* 60; // 24 hours of activity

// Check if the session has expired
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $expiration)) {
    // Session expired, unset the session
    session_unset();
    session_destroy();
    echo '<script>alert("Votre session a expire");</script>';
    echo '<script>window.location.href="../login.php";</script>';
    exit;
}
// Update the last activity time
$_SESSION['LAST_ACTIVITY'] = time();
}

function popup_delete($record){
       
    ?> 
      <div class="popup hidden-popup">
        <div class="popup-container">
            <h4>Dear principal,</h4>
            <p>Are you sure you want to remove <br><span><?= $record->fname." ".$record->lname?></span> From your system?</p>
            <div class="popup-btn">
                <button class="cancel-popup">Cancel</button>
                <a href="delete_formTeacher.php?tutor_id=<?= $record->tutor_id?>" class="delete-popup">Delete</a>
            </div>
        </div>
    </div>
    <?php
    }

