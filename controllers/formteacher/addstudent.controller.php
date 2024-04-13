<?php
$success = null;
$error = null;

$form = new Form("Add a new student", "add", "Add student");
$form->addField("text", "regnumber", "Registration number", "Enter the student registration number");
$form->addField("text", "fname", "First name", "Enter First name");
$form->addField("text", "lname", "Last name", "Enter Last name");
$form->addField("text", "pob", "Place of birth", "Enter the place of birth");
$form->addField("date", "dob", "Date of birth", "Enter the place of birth");
$form->addField("text", "parentAdd", "Parent Address", "Enter the parent address");


if (isset($_POST['add'])) {
    $regnumb= htmlspecialchars($_POST['regnumber']);
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $pob= htmlspecialchars($_POST['pob']);
    $Dob= htmlspecialchars($_POST['dob']);
    $paddress = htmlspecialchars($_POST['parentAdd']);
  
    // Check if a form teacher is already assigned to this class
    $existing_teacher_query = $db->prepare('SELECT fname,lname FROM students_per_class WHERE fname = ? AND lname = ?');
    $existing_teacher_query->execute(array($fname,$lname));
    $existing_teacher = $existing_teacher_query->fetch();

    if ($existing_teacher) {
        $error = "There is a student already assigned to this class!";
    } else {
        
            $query = $db->prepare('INSERT INTO students_per_class (regnumber, fname, lname, parent_address, Dob, Pob, class_id) VALUES (:regnumber, :fname, :lname, :parent_address, :Dob, :Pob, :class_id)');
            $query->bindParam(':regnumber', $regnumb);
            $query->bindParam(':fname', $fname);
            $query->bindParam(':lname', $lname);
            $query->bindParam(':parent_address', $paddress);
            $query->bindParam(':Dob', $Dob);
            $query->bindParam(':Pob', $pob); // Corrected parameter name here
            $query->bindParam(':class_id', $_SESSION['class_id']); // Assuming $class_id is defined somewhere
            $query->execute();
            $success = "Student " . $fname . " " . $lname . " was added successfully";
        }
    }


?>
