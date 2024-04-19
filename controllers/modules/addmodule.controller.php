<?php
$success = null;
$error = null;

$form = new Form("Add a new module", "add", "Add module");
$form->addField("number", "coeff", "Coefficient", " Add the coefficient");
$form->addField("text", "modname", "Module name", "Enter the module name");


if (isset($_POST['add'])) {
    $coeff= htmlspecialchars($_POST['coeff']);
    $modname = htmlspecialchars($_POST['modname']);
 
  
    // Check if a student is already assigned to this class
    $existing_module_query = $db->prepare("SELECT *FROM courses WHERE class_id={$_SESSION['class_id']} AND course_name=?");
    $existing_module_query->execute(array($modname));
    $existing_module = $existing_module_query->fetch();
    if(empty($coeff) || empty($modname)){
        $error = "Please complete all the fields ";
     }
   else {
        if ($existing_module) {
            $error = "There is another module with the same name in this class!";
        } else{
            $query = $db->prepare('INSERT INTO courses (course_name, class_id, coefficient) VALUES (:course_name, :class_id, :coefficient)');
            $query->bindParam(':course_name', $modname);
            $query->bindParam(':class_id', $_SESSION['class_id']);
            $query->bindParam(':coefficient', $coeff);
            $query->execute();
            $success = "The module of " . $modname .  " was added successfully";
        }
           
        }
    }


?>
