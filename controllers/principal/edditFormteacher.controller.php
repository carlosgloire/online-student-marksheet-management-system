<?php
$success = null;
$error = null;

require_once('../../database/DBConnection.php');

if (isset($_GET['tutor_id']) && !empty($_GET['tutor_id'])) {
    //Getting the form teacher id
    $id = $_GET['tutor_id'];
    $request = $db->prepare("SELECT * FROM form_tutors WHERE tutor_id = ?");
    $request->execute([$id]);
    $stmt = $request->fetch();
    if(isset($_POST['classes'])){
        $class_id = htmlspecialchars($_POST['classes']);
       // Check if a form teacher is already assigned to this class
        $existing_teacher_query = $db->prepare('SELECT * FROM form_tutors WHERE class_id = ?');
        $existing_teacher_query->execute(array($class_id));
        $existing_teacher = $existing_teacher_query->fetch();
        if ($existing_teacher AND $existing_teachername) {
        
            $error = "There is a form teacher already assigned to this class and <br/> with the same name you provided!";
        }
    }        


    if ($stmt) {
        $fname_fetched = $stmt['fname'];
        $lname_fetched = $stmt['lname'];
        $email_fetched = $stmt['email'];
        $profile_photo_fetched = $stmt['profile_photo'];
        $class_id_fetched = $stmt['class_id'];
    } else {
        echo '<script>alert("Form teacher not found");</script>';
        echo '<script>window.location.href="Formteacher.php";</script>';
        exit;
    }
}

if (isset($_POST['modify'])) {
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $email = htmlspecialchars($_POST['email']);
   
    $filename = $stmt['profile_photo']; // Default to previous profile photo
     // Check if a form teacher name is already assigned to this class
     $existing_teachername_query = $db->prepare('SELECT fname,lname FROM form_tutors WHERE fname = ? AND lname = ?');
     $existing_teachername_query->execute(array($fname,$lname));
     $existing_teachername = $existing_teachername_query->fetch();
     if(empty($fname) || empty($lname) || empty($email) ){
        $error = "Please complete all fields"; 
    }
    elseif (!empty($_FILES['uploadfile']['name'])) {
        $filename = $_FILES["uploadfile"]["name"];
        $filesize = $_FILES["uploadfile"]["size"];
        $tempname = $_FILES["uploadfile"]["tmp_name"];
        $folder = "./profile_photo/" . $filename;
        $allowedExtensions = ['png', 'jpg', 'jpeg'];
        $pattern = '/\.(' . implode('|', $allowedExtensions) . ')$/i';
        
        if (!preg_match($pattern, $filename)) {
            $error = "Your file must be in 'jpg', 'jpeg' or 'png' format";
        } elseif ($filesize > 3000000) {
            $error = "Your file must not exceed 3MB";
        } elseif (!move_uploaded_file($tempname, $folder)) {
            $error = "Error while uploading";
        }
    }
  
    // Check if a new class is selected
    elseif (!empty($_POST['classes'])) {
        $class = htmlspecialchars($_POST['classes']);

        // Check if the new class_id exists in the 'classes' table
        $checkClass = $db->prepare("SELECT * FROM classes WHERE class_id = ?");
        $checkClass->execute([$class_id]);
        if (!$checkClass->fetch()) {
            $error = "Please select the class!!";
        }
    }
       
    if(empty($error)){
       
        // Update form_tutors with the new data
        $updateTeacher = $db->prepare('UPDATE form_tutors SET fname = ?, lname = ?, email = ?, profile_photo = ?, class_id = ? WHERE tutor_id = ?');
        $updateTeacher->execute([$fname, $lname, $email, $filename, $class, $id]);
        echo '<script>alert("Form teacher updated successfully");</script>';
        echo '<script>window.location.href="Formteacher.php";</script>';
        exit;
    }
}
?>
