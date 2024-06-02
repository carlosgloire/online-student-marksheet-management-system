
<?php

require_once('../../../database/DBConnection.php');

 if(isset($_GET['student_id']) AND !empty($_GET['student_id'])){
    $getid = $_GET['student_id'];
    $recup_id = $db->prepare('SELECT *FROM students_per_class WHERE student_id = ? ');
    $recup_id->execute(array($getid));
    if($recup_id->rowCount() > 0){
        $delete_product = $db->prepare('DELETE FROM students_per_class WHERE student_id = ? ');
        $delete_product->execute(array($getid));
        echo '<script>alert("Student deleted successfully");</script>';
        echo '<script>window.location.href="student_list.php";</script>';
        exit;
 }
 else{
    echo '<script>alert("No student found");</script>';
    echo '<script>window.location.href="student_list.php";</script>';
    exit;
 }

}
