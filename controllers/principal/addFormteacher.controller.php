<?php
$success = null;
$error = null;
require_once('../../app/Form/form.php');
require_once('../../database/DBConnection.php');
$form = new Form("Add a Form teacher", "add", "Add Form teacher");
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
    if($infos){
        $classId_fetched= $infos['class_id'];
    }
    else{
        session_destroy();
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        echo '<script>alert("No class not found");</script>';
        echo '<script>window.location.href="connect.php";</script>';
        exit;
    }
}

if (isset($_POST['add'])) {
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $filename = $_FILES["uploadfile"]["name"];
    $filesize = $_FILES["uploadfile"]["size"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./profile_photo/" . $filename;
    $allowedExtensions = ['png', 'jpg', 'jpeg'];
    $pattern = '/\.(' . implode('|', $allowedExtensions) . ')$/i';

    // Check if a form teacher name is already assigned to this class
    $existing_teachername_query = $db->prepare('SELECT fname,lname FROM form_tutors WHERE fname = ? AND lname = ?');
    $existing_teachername_query->execute(array($fname,$lname));
    $existing_teachername = $existing_teachername_query->fetch();

     // Check if an email is already used for another account
     $existing_email_query = $db->prepare('SELECT email FROM form_tutors WHERE email= ?');
     $existing_email_query->execute(array($email));
     $existing_email = $existing_email_query->fetch();
    if(  empty($fname) || empty($lname) || empty($email) || empty($password)){
        $error = "Please complete all fields"; 
    }
    elseif(empty($filename)){
        $error = "Choosing a profile photo is mendatory !!"; 
    }
    elseif (!preg_match($pattern, $_FILES['uploadfile']['name']) && !empty($_FILES['uploadfile']['name'])) {
        $error = "Your file must be in \"jpg, jpeg or png\" format";
    } elseif ($filesize > 5000000) {
        $error = "Your file must not exceed 5Mb";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Your email is incorrect";
    }
    elseif($existing_email){
        $error = "This email has been used for another account creation on this system";  
    }
    // Validate password complexity
    elseif (!preg_match("#[a-zA-Z]+#", $_POST['password']) ||
    !preg_match("#[0-9]+#", $_POST['password']) ||
    !preg_match("#[\!\@\#\$\%\^\&\*\(\)\_\+\-\=\[\]\{\}\;\:\'\"\,\<\>\.\?\/\`\~\\\|\ ]+#", $_POST['password'])) {
    $error = "Your password must contain at least one letter, one number, and one special character.";
}

  else {
        // Check if a form teacher is already assigned to this class
        $existing_teacher_query = $db->prepare('SELECT * FROM form_tutors WHERE class_id = ?');
        $existing_teacher_query->execute(array($id));
        $existing_teacher = $existing_teacher_query->fetch();

        if ($existing_teacher) {
            $error = "There is a form teacher already assigned to this class!";
        } 
       
        else {
            if (!move_uploaded_file($tempname, $folder)) {
                $error = "Error while uploading";
            } else {
                if ($existing_teachername) {
                    $error = "Thre is a form teacher with the same name you provided!";
                }
                else{
                    // Insert the new form tutor
                    $query = $db->prepare('INSERT INTO form_tutors (fname, lname, email, profile_photo, password, class_id) VALUES (:fname, :lname, :email, :profile_photo, :password, :class_id)');
                    $query->bindParam(':fname', $fname);
                    $query->bindParam(':lname', $lname);
                    $query->bindParam(':email', $email);
                    $query->bindParam(':profile_photo', $filename);
                    $query->bindParam(':password', $hashedPassword);
                    $query->bindParam(':class_id', $id);
                    $query->execute();
                    echo '<script>alert("Form teacher added successfully");</script>';
                    echo '<script>window.location.href="classes.php";</script>';
                    exit;
                    }

            }
        }
    }
}
?>
