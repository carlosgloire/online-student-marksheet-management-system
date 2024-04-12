<?php
$success = null;
$error = null;

require_once('../../database/DBConnection.php');

if (isset($_GET['tutor_id']) && !empty($_GET['tutor_id'])) {
    $id = $_GET['tutor_id'];
    $request = $db->prepare("SELECT * FROM form_tutors WHERE tutor_id = ?");
    $request->execute([$id]);
    $stmt = $request->fetch();

    if ($stmt) {
        $fname_fetched = $stmt['fname'];
        $lname_fetched = $stmt['lname'];
        $email_fetched = $stmt['email'];
        $profile_photo_fetched = $stmt['profile_photo'];
        $class_id_fetched = $stmt['class_id'];
    } else {
        $error = "Tutor not found";
    }
}

if (isset($_POST['modify'])) {
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $email = htmlspecialchars($_POST['email']);

    // Set default values for filename and class
    $filename = $stmt['profile_photo']; // Default to previous profile photo
    $class = $stmt['class_id']; // Default to previous class_id

    // Check if a new file is uploaded
    if (!empty($_FILES['uploadfile']['name'])) {
        $filename = $_FILES["uploadfile"]["name"];
        $filesize = $_FILES["uploadfile"]["size"];
        $tempname = $_FILES["uploadfile"]["tmp_name"];
        $folder = "./profile_photo/" . $filename;
        $allowedExtensions = ['png', 'jpg', 'jpeg'];
        $pattern = '/\.(' . implode('|', $allowedExtensions) . ')$/i';

        if (!preg_match($pattern, $filename)) {
            $error = "Your file must be in 'jpg', 'jpeg' or 'png' format";
        } elseif ($filesize > 5000000) {
            $error = "Your file must not exceed 5MB";
        } elseif (!move_uploaded_file($tempname, $folder)) {
            $error = "Error while uploading";
        }
    }

    // Check if a new class is selected
    if (!empty($_POST['classes'])) {
        $class = htmlspecialchars($_POST['classes']);

        // Check if the new class_id exists in the 'classes' table
        $checkClass = $db->prepare("SELECT * FROM classes WHERE class_id = ?");
        $checkClass->execute([$class]);
        if (!$checkClass->fetch()) {
            $error = "Please select the class!!";
        }
    }

    if (empty($error)) {
        // Update form_tutors with the new data
        $updateTeacher = $db->prepare('UPDATE form_tutors SET fname = ?, lname = ?, email = ?, profile_photo = ?, class_id = ? WHERE tutor_id = ?');
        $updateTeacher->execute([$fname, $lname, $email, $filename, $class, $id]);
        $success = "Form teacher updated successfully";
    }
}
?>
