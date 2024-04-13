<?php
$success = null;
$error = null;



if (isset($_GET['student_id']) && !empty($_GET['student_id'])) {
    //Getting the form teacher id
    $id = $_GET['student_id'];
    $request = $db->prepare("SELECT * FROM students_per_class WHERE student_id = ?");
    $request->execute([$id]);
    $stmt = $request->fetch();
 

    if ($stmt) {
        $fname_fetched = $stmt['fname'];
        $lname_fetched = $stmt['lname'];
        $regnumber_fetched= $stmt['regnumber'];
    
    } else {
        echo '<script>alert("student not found");</script>';
        echo '<script>window.location.href="../student/student_list.php";</script>';
        exit;

    }
}

if (isset($_POST['modify'])) {
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
     $regnumber= htmlspecialchars($_POST['regnumber']);
     
    // Check if a student registration number already exist class
    $existing_regnumber_query = $db->prepare( "SELECT * FROM students_per_class WHERE regnumber={$_POST['regnumber']} AND class_id={$_SESSION['class_id']} ");
    $existing_regnumber_query->execute(array());
    $existing_regnumber = $existing_regnumber_query->fetch();

    // Check if a student is already exist in the class
    $existing_student_query = $db->prepare( "SELECT * FROM students_per_class WHERE class_id={$_SESSION['class_id']} AND fname=? AND lname=?");
    $existing_student_query->execute(array($fname,$lname));
    $existing_student = $existing_student_query->fetch(PDO::FETCH_ASSOC);
     if ($existing_student  AND $fname == $existing_student['fname'] AND $lname == $existing_student['lname']) {
        $error = "There is another student with the same first and last name  in this class otherwise you didn't change anything on the student identies ";
    }
    else{
        if ($existing_regnumber) {
            $error = "There is another student with the same registration this class otherwise you didn't change anything on the student registrarion number";
        }
        else{
                // Update form_tutors with the new data
            $updateTeacher = $db->prepare('UPDATE students_per_class SET regnumber=?, fname = ?, lname = ? WHERE student_id = ?');
            $updateTeacher->execute([$regnumber,$fname, $lname,$id]);
            echo '<script>alert("Student identinties updated successfully");</script>';
            echo '<script>window.location.href="../student/student_list.php";</script>';
            exit;

        }
        }
    }
?>
