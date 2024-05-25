<?php
$success = null;
$error = null;

// Get the class id
if (isset($_GET['course_id']) && !empty($_GET['course_id'])) {
    $id = $_GET['course_id'];
    $recupcourseid = $db->prepare('SELECT * FROM courses WHERE course_id = ?');
    $recupcourseid->execute(array($id));
    $infos = $recupcourseid->fetch();
    if($infos){
        $courseId_fetched= $infos['course_id'];
        $coefficient=$infos['coefficient'];
    }
    else{
        session_destroy();
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        echo '<script>alert("No course not found");</script>';
        echo '<script>window.location.href="../pages/connect.php";</script>';
        exit;
    }
}
if (isset($_POST['add'])) {
    $trimester = htmlspecialchars($_POST['courses']);
    $sequence = htmlspecialchars($_POST['sequence']);
    $composition = htmlspecialchars($_POST['composition']);
    
    // Check if a student is already assigned to this class
    $existing_marks_query = $db->prepare("SELECT * FROM marksheets WHERE course_id=:course_id AND student_id=:student_id AND trim_id=:trim_id");
    $existing_marks_query->execute(array('course_id'=>$id,'student_id'=>$_SESSION['studentID'],'trim_id'=>$trimester));
    $existing_marks = $existing_marks_query->fetch(PDO::FETCH_ASSOC);

    // Check if $sequence and $composition are empty
    if ($sequence === '' || $composition === '') {
        $error = "Please complete all the fields";
    } 
    elseif(!empty($existing_marks['SQ']) || !empty($existing_marks['comp'])) {
        $error = "You have already marked this student in this trimester";
    }
    else {
        if(($sequence <0 || $sequence >20) || ($composition<0 || $composition >20)  ){
            $error = "The marks should be less than 0 and above 20";
        }else{
            // If $sequence or $composition are not empty, convert them to float
            $sequence = $sequence !== '' ? floatval($sequence) : 0;
            $composition = $composition !== '' ? floatval($composition) : 0;

            $total = (($sequence + $composition) / 2) * floatval($coefficient);

            $query = $db->prepare('INSERT INTO marksheets (SQ, comp, total, student_id, course_id, trim_id, class_id) VALUES (:SQ, :comp, :total, :student_id, :course_id, :trim_id, :class_id)');
            $query->bindParam(':SQ', $sequence);
            $query->bindParam(':comp', $composition);
            $query->bindParam(':total', $total);
            $query->bindParam(':student_id', $_SESSION['studentID']);
            $query->bindParam(':course_id', $id);
            $query->bindParam(':trim_id', $trimester);
            $query->bindParam(':class_id', $_SESSION['class_id']);
            $query->execute();
            $success = "Marks added successfully";
        }

    }
}
?>
