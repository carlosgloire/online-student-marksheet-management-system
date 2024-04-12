<?php
$success = null;
$error = null;
require_once('../../app/Form/form.php');
require_once('../../database/DBConnection.php');
$form = new Form("Add a Form tutor", "add", "Add Form tutor");
$form->addField("text", "fname", "First name", "Enter First name");
$form->addField("text", "lname", "Last name", "Enter Last name");
$form->addField("email", "email", "Email", "Enter email");
$form->addField("file", "uploadfile", "Teacher profile", "");
$form->addField("password", "password", "Password", "Create a password");

// Get the class id
if (isset($_GET['class_id']) && !empty($_GET['class_id'])) {
    $id = $_GET['class_id'];
    $recupproduct = $db->prepare('SELECT * FROM classes WHERE class_id = ?');
    $recupproduct->execute(array($id));
    $infos = $recupproduct->fetch();
    $class_name = $infos['class_name'];
}

if (isset($_POST['add'])) {
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars(password_hash($_POST['password'], PASSWORD_BCRYPT));

    $filename = $_FILES["uploadfile"]["name"];
    $filesize = $_FILES["uploadfile"]["size"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./profile_photo/" . $filename;
    $allowedExtensions = ['png', 'jpg', 'jpeg'];
    $pattern = '/\.(' . implode('|', $allowedExtensions) . ')$/i';

    // Validate uploaded file
    if (!preg_match($pattern, $_FILES['uploadfile']['name']) && !empty($_FILES['uploadfile']['name'])) {
        $error = "Your file must be in \"jpg, jpeg or png\" format";
    } elseif ($filesize > 5000000) {
        $error = "Your file must not exceed 5Mb";
    }

    // Validate password complexity
    elseif (!preg_match("#[a-zA-Z]+#", $_POST['password']) ||
            !preg_match("#[0-9]+#", $_POST['password']) ||
            !preg_match("#[-_@%&*!$^]+#", $_POST['password'])) {
        $error = "Your password must contain at least one letter, one number, and one of these special characters: - _ @ % & * ! $ ^";
    } else {
        // Check if a form teacher is already assigned to this class
        $existing_teacher_query = $db->prepare('SELECT * FROM form_tutors WHERE class_id = ?');
        $existing_teacher_query->execute(array($id));
        $existing_teacher = $existing_teacher_query->fetch();

        if ($existing_teacher) {
            $error = "There is a form teacher already assigned to this class!";
        } else {
            if (!move_uploaded_file($tempname, $folder)) {
                $error = "Error while uploading";
            } else {
                // Insert the new form tutor
                $query = $db->prepare('INSERT INTO form_tutors (fname, lname, email, profile_photo, password, class_id) VALUES (:fname, :lname, :email, :profile_photo, :password, :class_id)');
                $query->bindParam(':fname', $fname);
                $query->bindParam(':lname', $lname);
                $query->bindParam(':email', $email);
                $query->bindParam(':profile_photo', $filename);
                $query->bindParam(':password', $password);
                $query->bindParam(':class_id', $id);
                $query->execute();
                $success = "Form teacher " . $fname . " " . $lname . " was added successfully";
            }
        }
    }
}
?>
