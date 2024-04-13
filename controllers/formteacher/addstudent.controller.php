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
     // Check if a student registration number already exist class
     $existing_regnumber_query = $db->prepare( "SELECT * FROM students_per_class WHERE regnumber={$_POST['regnumber']} AND class_id={$_SESSION['class_id']} ");
     $existing_regnumber_query->execute(array());
     $existing_regnumber = $existing_regnumber_query->fetch();

    // Check if a student is already exist in the class
    $existing_student_query = $db->prepare( "SELECT * FROM students_per_class WHERE class_id={$_SESSION['class_id']} AND fname=? AND lname=?");
    $existing_student_query->execute(array($fname,$lname));
    $existing_student = $existing_student_query->fetch();
   
    if ($existing_student) {
        $error = "There is another student with the same first name and last name in this class";
    } else {
        if($existing_regnumber){
            $error = "This registration number have been used for another student in this class"; 
        }else{
            
            $query = $db->prepare('INSERT INTO students_per_class (regnumber, fname, lname, parent_address, Dob, Pob, class_id) VALUES (:regnumber, :fname, :lname, :parent_address, :Dob, :Pob, :class_id)');
            $query->bindParam(':regnumber', $regnumb);
            $query->bindParam(':fname', $fname);
            $query->bindParam(':lname', $lname);
            $query->bindParam(':parent_address', $paddress);
            $query->bindParam(':Dob', $Dob);
            $query->bindParam(':Pob', $pob); 
            $query->bindParam(':class_id', $_SESSION['class_id']);
            $query->execute();
            $success = "Student " . $fname . " " . $lname . " was added successfully";
        }

        }
    }


?>
