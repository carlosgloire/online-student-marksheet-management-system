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
    $trimester=htmlspecialchars($_POST['courses']);
    $sequence = htmlspecialchars($_POST['sequence']);
    $composition = htmlspecialchars($_POST['composition']);
    $total = ((floatval($sequence) + floatval($composition)) / 2) * floatval($coefficient);

        // Check if a student is already assigned to this class
        $existing_marks_query = $db->prepare("SELECT * FROM marksheets WHERE course_id=:course_id AND student_id=:student_id AND trim_id=:trim_id");
        $existing_marks_query->execute(array('course_id'=>$id,'student_id'=>$_SESSION['studentID'],'trim_id'=>$trimester));
        $existing_marks = $existing_marks_query->fetch(PDO::FETCH_ASSOC);

        // Check if marks exist for this student in this module
        if ($existing_marks) {
            $seq = $existing_marks['SQ'];
            $comp = $existing_marks['comp'];
            
            // Check if marks exist for sequence
            if (! empty($seq)) {
                $error = "You have already given the marks to this student in this existing module in sequence";
                if (! empty($seq)) {
                    $error = "You have already given the marks to this student in this existing module in sequence";
                } 
                
                // Check if marks exist for composition
                if (!empty($comp)) {
                    $error = "You have already given the marks to this student in this existing module in composition";
                } 
                
                // Check if marks exist for both sequence and composition
                if (!empty($seq) && !empty($comp)) {
                    $error = "You have already given the marks to this student in this existing module in sequence and composition";
                }
                            } 
            // Check if marks exist for composition
            elseif (!empty($comp) ) {
                $error = "You have already given the marks to this student in this existing module in composition";
            } 
            // Check if marks exist for both sequence and composition
            elseif (!empty($seq) && !empty($comp )) {
                $error = "You have already given the marks to this student in this existing module in sequence and composition";
            }  
        } else {
            // Insert marks into marksheets table
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

?>
