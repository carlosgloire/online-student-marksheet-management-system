<?php
$success = null;
$error = null;



if (isset($_GET['course_id']) && !empty($_GET['course_id'])) {
    //Getting the form teacher id
    $id = $_GET['course_id'];
    $request = $db->prepare("SELECT * FROM courses WHERE course_id = ?");
    $request->execute([$id]);
    $stmt = $request->fetch();
 

    if ($stmt) {
        $course_fetched = $stmt['course_name'];
        $coefficient_fetched = $stmt['coefficient'];
    
    } else {
        echo '<script>alert("student not found");</script>';
        echo '<script>window.location.href="../student/student_list.php";</script>';
        exit;

    }
}

if (isset($_POST['modify'])) {
    $coefficient = htmlspecialchars($_POST['coefficient']);
    $course_name = htmlspecialchars($_POST['course_name']);
   
    
    // Check if a course is already exist in the class
    $existing_course_query = $db->prepare( "SELECT * FROM courses WHERE class_id={$_SESSION['class_id']}  AND course_name=?");
    $existing_course_query->execute(array($course_name));
    $existing_course = $existing_course_query->fetch(PDO::FETCH_ASSOC);
     if(empty($coefficient) || empty($course_name)){
        $error = "Please complete all the fields ";
     }
   
    else{
        if ($existing_course  AND $course_name != $course_fetched ) {
            $error = "There is another module with the same  name  in this class ";
        }else{
              // Update form_tutors with the new data
            $updatecourse = $db->prepare('UPDATE courses SET course_name=?, coefficient = ? WHERE course_id = ?');
            $updatecourse->execute([$course_name,$coefficient,$id]);
            echo '<script>alert("Course updated successfully");</script>';
            echo '<script>window.location.href="../module/modules.php";</script>';
            exit;
        }
          

        }
}

?>
