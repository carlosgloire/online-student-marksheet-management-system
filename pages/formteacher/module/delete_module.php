
<?php

require_once('../../../database/DBConnection.php');

 if(isset($_GET['course_id']) AND !empty($_GET['course_id'])){
    $getid = $_GET['course_id'];
    $recup_id = $db->prepare('SELECT *FROM courses WHERE course_id = ? ');
    $recup_id->execute(array($getid));
    if($recup_id->rowCount() > 0){
        $delete_product = $db->prepare('DELETE FROM courses WHERE course_id = ? ');
        $delete_product->execute(array($getid));
        echo '<script>alert("Module deleted successfully");</script>';
        echo '<script>window.location.href="modules.php";</script>';
        exit;
 }
 else{
    echo '<script>alert("No module found");</script>';
    echo '<script>window.location.href="modules.php";</script>';
    exit;
 }

}
