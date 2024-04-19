<?php
    session_start();
    require_once('../../functions.php');
    require_once('../../models/GenericModel.php');
    require_once('../../database/DBConnection.php');
    logout();
    notconnected();

    
// Query to select classes, count of students, count of courses, and form teacher for each class
$query = $db->prepare("SELECT 
    c.class_id AS classID, 
    c.class_name AS className, 
    COUNT(DISTINCT s.student_id) AS student_count,
    COUNT(DISTINCT cr.course_id) AS course_count,
    ft.fname AS fname,ft.lname AS lname
    FROM classes c
    LEFT JOIN students_per_class s ON c.class_id = s.class_id
    LEFT JOIN courses cr ON c.class_id = cr.class_id
    LEFT JOIN form_tutors ft ON c.class_id = ft.class_id
    GROUP BY c.class_id, c.class_name, ft.fname,ft.lname
    ORDER BY c.class_id, c.class_name");

$query->execute();
$results = $query->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows

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
    <title>Dashboard</title>
</head>

<body>
       <!-- this is the menu bar  of our system-->
       <?php require_once('../header.php')?>
       <section class="principal-Section">
           <!-- this is the nav bar for the left side of our system-->
           <?php require_once('../navbar.php')?>
        <div class="class-content">
            <div class="title">
                <h2>Classes</h2>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequuntur iste impedit, possimus tempore reiciendis veniam nesciunt molestiae facere eligendi aliquid iusto, voluptas voluptates blanditiis ipsum aut est odit nulla cupiditate.</p>
            </div>
            <div class="all-classes">
                <?php

             
                    foreach($results as $result){
                        ?>
                            <div  class="classe-content">
                                <strong><?= $result['classID']?></strong>
                                <h4><?= $result['className']?></h4>
                                <div style="display: flex;gap:10px"><p>Number of students: </p><p style="font-weight: bold;"><?= $result['student_count'] ?></p></div>
                                <div style="display: flex;gap:10px"><p>Number of modules: </p><p style="font-weight: bold;"><?= $result['course_count'] ?></p></div>
                                <div class="class-titular">
                                    <p>Form teacher: </p>
                                    <span><?=! empty($result['fname']) && !empty($result['lname']) ? ($result['fname'])." ".($result['lname']): " No form teacher " ?></span>
                                </div>
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