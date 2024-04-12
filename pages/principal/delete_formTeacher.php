
<?php

require_once('../../database/DBConnection.php');

 if(isset($_GET['tutor_id']) AND !empty($_GET['tutor_id'])){
    $getid = $_GET['tutor_id'];
    $recup_id = $db->prepare('SELECT *FROM form_tutors WHERE tutor_id = ?');
    $recup_id->execute(array($getid));
    if($recup_id->rowCount() > 0){
        $delete_product = $db->prepare('DELETE FROM form_tutors WHERE tutor_id = ? ');
        $delete_product->execute(array($getid));
        echo '<script>alert("Form teacher deleted successfully");</script>';
        echo '<script>window.location.href="Formteacher.php";</script>';
        exit;
 }
 else{
    echo '<script>alert("No form teacher found");</script>';
    echo '<script>window.location.href="Formteacher.php";</script>';
    exit;
 }

}
