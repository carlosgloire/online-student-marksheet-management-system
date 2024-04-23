<?php
//principal page
function logout(){
    if(isset($_POST['logout'])){
        session_destroy();
        header('location: ../login.php');
        exit();
    }
}
//Function to gout the principal
function logout_principal(){
    if(isset($_POST['logout'])){
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        header('location: connect.php');
        exit();
    }
}
//Function to check if the principal is connected
function notconnected(){
    if (! isset($_SESSION['admin'])) {
        // Redirect to the login page if not logged in
        header("Location: ../login.php");
        exit();
    }
}

//Function to gout the principal
function logout_formteacher(){
    if(isset($_POST['logout'])){
        unset($_SESSION['email_formteacher']);
        unset($_SESSION['password_formteacher']);
        header('location: connect.php');
        exit();
    }
}
//Function to gout the principal
function logout_formteacher2(){
    if(isset($_POST['logout'])){
        unset($_SESSION['email_formteacher']);
        unset($_SESSION['password_formteacher']);
        header('location: ../connect.php');
        exit();
    }
}

//Function to check if the principal is connected
function notconnected_formteacher(){
    if (! isset($_SESSION['email_formteacher']) AND ! isset($_SESSION['password_formteacher'])) {
        // Redirect to the login page if not logged in
        header("Location: connect.php");
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
function verifysession(){
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

//Function to check session expiration
function verifysession2(){
    // Set the session expiration time
$expiration = 20* 60; // 24 hours of activity

// Check if the session has expired
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $expiration)) {
    // Session expired, unset the session
    session_unset();
    session_destroy();
    echo '<script>alert("Votre session a expire");</script>';
    echo '<script>window.location.href="../../login.php";</script>';
    exit;
}
// Update the last activity time
$_SESSION['LAST_ACTIVITY'] = time();
}

function popup_delete($record,$function,$message,$fname,$lname,$id){  
    ?> 
      <div class="popup hidden-popup">
        <div class="popup-container">
            <h4>Dear <?= $function?>,</h4>
            <p><?= $message ?><br><span><?= $record->$fname." ".$record->$lname?></span> From your system?</p>
            <div class="popup-btn">
                <button class="cancel-popup">Cancel</button>
                <a href="delete_formTeacher.php?tutor_id=<?= $record->$id?>" class="delete-popup">Delete</a>
            </div>
        </div>
    </div>
    <?php
    }

    function popup_delete2($function,$message,$modulename,$id){  
        ?> 
          <div class="popup hidden-popup">
            <div class="popup-container">
                <h4>Dear <?= $function?>,</h4>
                <p><?= $message ?><br><span><?= $modulename ?></span> From your system?</p>
                <div class="popup-btn">
                    <button class="cancel-popup">Cancel</button>
                    <a href="delete_formTeacher.php?tutor_id=<?= $id?>" class="delete-popup">Delete</a>
                </div>
            </div>
        </div>
        <?php
        }
    