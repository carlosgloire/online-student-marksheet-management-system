<?php
$success = null;
$error = null;

require_once('../../database/DBConnection.php');

if (isset($_GET['tutor_id']) && !empty($_GET['tutor_id'])) {
    // Getting the form tutor id
    $id = $_GET['tutor_id'];
    $request = $db->prepare("SELECT * FROM form_tutors WHERE tutor_id = ?");
    $request->execute([$id]);
    $stmt = $request->fetch();

    if ($stmt) {
        $fname_fetched = $stmt['fname'];
        $lname_fetched = $stmt['lname'];
        $email_fetched = $stmt['email'];
        $profile_photo_fetched = $stmt['profile_photo'];
    } else {
        echo '<script>alert("Form tutor not found");</script>';
        echo '<script>window.location.href="Formteacher.php";</script>';
        exit;
    }
}

if (isset($_GET['class_id']) && !empty($_GET['class_id'])) {
    // Getting the class id
    $classID = $_GET['class_id'];
    $request = $db->prepare("SELECT * FROM classes WHERE class_id = ?");
    $request->execute([$classID]);
    $stmt = $request->fetch();

    if ($stmt) {
        $class_id_fetched = $stmt['class_id'];
    } else {
        echo '<script>alert("Class not found");</script>';
        echo '<script>window.location.href="Formteacher.php";</script>';
        exit;
    }
}

if (isset($_POST['modify'])) {
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $email = htmlspecialchars($_POST['email']);
    $class_id = htmlspecialchars($_POST['classes']);
    $filename = $profile_photo_fetched; // Default to previous profile photo

    if (empty($fname) || empty($lname) || empty($email) || empty($class_id)) {
        $error = "Please complete all fields";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "The email you writted is incorrect";
    } 
    elseif($class_id == 'select'){
        $error = " Please select the class to modify";  
    }
    else {
        // Check if a form tutor is already assigned to this class
        $existing_teacher_query = $db->prepare('SELECT * FROM form_tutors WHERE class_id = ?');
        $existing_teacher_query->execute([$class_id]);
        $existing_teacher = $existing_teacher_query->fetch();

        if ($existing_teacher && $existing_teacher['tutor_id'] != $id) {
            $error = "There is already a form tutor assigned to this class!";
        }

        // Check if a form tutor with the same name already exists
        $existing_teachername_query = $db->prepare('SELECT * FROM form_tutors WHERE fname = ? AND lname = ?');
        $existing_teachername_query->execute([$fname, $lname]);
        $existing_teachername = $existing_teachername_query->fetch();

        if ($existing_teachername && $existing_teachername['tutor_id'] != $id) {
            $error = "A form tutor with the same name already exists!";
        }

        if (!empty($_FILES['uploadfile']['name'])) {
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
    }

    if (empty($error)) {
        // Update form_tutors with the new data
        $updateTeacher = $db->prepare('UPDATE form_tutors SET fname = ?, lname = ?, email = ?, profile_photo = ?, class_id = ? WHERE tutor_id = ?');
        $updateTeacher->execute([$fname, $lname, $email, $filename, $class_id, $id]);
        echo '<script>alert("Form tutor updated successfully");</script>';
        echo '<script>window.location.href="Formteacher.php";</script>';
        exit;
    }
}
?>
