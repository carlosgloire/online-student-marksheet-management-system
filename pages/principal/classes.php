<?php
      
    session_start();
    require_once('../../functions.php');
    require_once('../../models/GenericModel.php');
    require_once('../../database/DBConnection.php');
    notconnected_principal();
    verifysession();
   
    $query = $db->prepare("SELECT 
    c.class_id AS classID, 
    c.class_name AS className, 
    ft.fname AS fname,ft.lname AS lname,tutor_id AS teacherID
    FROM classes c
    
    LEFT JOIN form_tutors ft ON c.class_id = ft.class_id
    GROUP BY c.class_id, c.class_name, ft.tutor_id, ft.fname,ft.lname
    ORDER BY c.class_id, c.class_name");

$query->execute();
$records = $query->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows
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
    <title>Add a new form teacher</title>
</head>

<body>
     <!-- this is the menu bar  of our system-->
     <?php require_once('../header.php')?>
    <section class="principal-Section">
        <!-- this is the nav bar for the left side of our system-->
        <?php require_once('../navbar.php')?>
        <div class="class-content">
            <div class="title">
                <h2>Add a form teacher in a class</h2>
            </div>

            <div class="all-classes">
    <?php
    foreach ($records as $record) {
        ?>
        <div class="classe-content">
            <strong><?= $record['classID'] ?></strong>
            <p style="margin-bottom: 10px;"><?= $record['className'] ?></p>
            <?php
            if (empty($record['fname']) && empty($record['lname'])) {
                // No form teacher assigned
                
                ?>
                    <p style="color: red;">No form teacher in this class</p>
                    <div style="margin-top: 5px;" class="icons-view">
                        <a class="details" href="addNewform_teacher.php?class_id=<?= $record['classID'] ?>">Click here to Add</a>
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                <?php
            } else {
                ?>
                <p style="color: green;">Form teacher: <?= $record['fname']." ".$record['lname'] ?></p>
                <div style="margin-top: 5px;" class="icons-view">
                    <a class="details" href="editTitulaire.php?tutor_id=<?= $record['teacherID'] ?>&class_id=<?= $record['classID'] ?>">Click here to modify</a>
                    <i class="fa-solid fa-arrow-right"></i>
                </div>
                <?php
                
            }
            ?>
             
              
                
        </div>
        <?php
    }
    ?>
</div>

        </div>
    </section>

    <!-- This part contain the footer of our system -->
    <footer>
        <p>©Marksheet Management System</p>
    </footer>

</body>

</html>