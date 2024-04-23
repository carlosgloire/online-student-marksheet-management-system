
<?php
    session_start();
    require_once('../../app/Form/form.php');
    require_once('../../functions.php');
    require_once('../../database/DBConnection.php');
    logout_formteacher2();
    if (isset($_GET['student_id']) && !empty($_GET['student_id'])) {
        //Getting the form teacher id
        $id = $_GET['student_id'];
        $_SESSION['studentID']=$id;
        $request = $db->prepare("SELECT * FROM students_per_class WHERE student_id = ?");
        $request->execute([$id]);
        $stmt = $request->fetch();
        if ($stmt) {
            $course_fetched = $stmt['student_id'];

        
        } else {
            echo '<script>alert("student not found");</script>';
            echo '<script>window.location.href="../student/student_list.php";</script>';
            exit;
    
        }
    }
    $request = $db->prepare("SELECT ft.*,st.* FROM courses ft LEFT JOIN classes st ON ft.class_id = st.class_id WHERE  ft.class_id = {$_SESSION['class_id']} ");
    $request->execute();
    


   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modules</title>
</head>

<body>
    <header>
        <div>
            <h3>Dashboard</h3>
        </div>
        <div class="user">
            <div class="search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" placeholder="Enter something">
            </div>
    </header>
    <section class="principal-Section">
         <!-- this is the nav bar for the left side of our system-->
         <?php require_once('navbar.php')?>

        <div class="design-modules">
            <div class="tutor-connected">
                <p><img src="../principal/profile_photo/<?= $_SESSION['file']?>"></p>
                <h5><?= $_SESSION['fname']." ".$_SESSION['lname']?></h5>
            </div>
            <h2> Modules of
            <?php
                $request2 = $db->prepare("SELECT class_name FROM classes  WHERE  class_id = {$_SESSION['class_id']} ");
                $request2->execute();
                $class=$request2->fetch();
                echo strtolower($class['class_name']);
             ?> 
            </h2>
            <!-- this section contain all the modules that we have in this class -->
            
                <?php
                if($request->rowCount() > 0){
                    while( $modules = $request->fetch(PDO::FETCH_ASSOC)){
                        ?>
                           <div class="module-name" style="margin-top: 15px;">
                                <p class="regnumber"><?=$modules['course_name'] ?></p>
                                <div>
                                    <div class="add-marks">
                                        <div>
                                            <i class="fa-solid fa-plus"></i>
                                            <a href="addMarks.php?course_id=<?=$modules['course_id']?>">Add marks</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }
                }
                else{
                    ?>
                        <p style="color:red; text-align:center;"><?= "No module already added !!"?></p>
                    <?php
                }

            ?>
               
            </div>
            
    </section>

    <!-- this is a popup for delete a module and for editing a module -->
    <div class="popup hidden-popup">
        <div class="popup-container">
            <h4>Dear user,</h4>
            <p>Do you want to delete this student</p>
            <p>into your system?</p>
            <div class="popup-btn">
                <button class="cancel-popup">Cancel</button>
                <button class="delete-popup">Delete</button>
            </div>
        </div>
    </div>

    <div class="hidden-popup"></div>

    <!-- This part contain the footer of our system -->
    <footer>
        <p>©Marksheet Management System</p>
    </footer>

</body>
</html>
<?php
require_once('../../javascript/popupdelete_formTeacher.php');