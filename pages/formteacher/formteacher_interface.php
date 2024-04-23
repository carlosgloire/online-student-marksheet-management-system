<?php
    session_start();
    require_once('../../functions.php');
    require_once('../../database/DBConnection.php');
    //require_once('delete_formTeacher.php');
    logout_formteacher();
    notconnected_formteacher();
    verifysession();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_SESSION['fname']." ".$_SESSION['lname']?></title>
</head>

<body>
     <!-- this is the menu bar  of our system-->
     <?php require_once('../header.php')?>
    <section class="principal-Section">
        <!-- this is the nav bar for the left side of our system-->
        <?php require_once('navbar.php')?>

        <div class="class-content">
            
            <div class="tutor-connected">
                <p><img src="../principal/profile_photo/<?= $_SESSION['file']?>"></p>
                <h5><?= $_SESSION['fname']." ".$_SESSION['lname']?></h5> 
            </div>
            <div class="title">
                <h2>Form teacher </h2>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequuntur iste impedit, possimus tempore reiciendis veniam nesciunt molestiae facere eligendi aliquid iusto, voluptas voluptates blanditiis ipsum aut est odit nulla cupiditate.</p>
            </div>

            <div class="tutor-content">
                <div class="tutor-item">
                    <i class="fa-regular fa-user tutor-icon"></i>
                    <h2>Students</h2>
                    <div class="click-div">
                        <a href="./student/student_list.php">View in details</a>
                        <i class="fa-regular fa-hand-point-up"></i>
                    </div>
                </div>
                <div class="tutor-item">
                    <i class="fa-solid fa-gear tutor-icon"></i>
                    <h2>Modules</h2>
                    <div class="click-div">
                        <a href="./module/modules.php">View in details</a>
                        <i class="fa-regular fa-hand-point-up"></i>
                    </div>
                </div>
                <div class="tutor-item">
                    <i class="fa-brands fa-maxcdn tutor-icon"></i>
                    <h2>Marks</h2>
                    <div class="click-div">
                        <a href="../marks/student_list.php">View in details</a>
                        <i class="fa-regular fa-hand-point-up"></i>
                    </div>
                </div>
                <div class="tutor-item">
                    <i class="fa-regular fa-circle-dot tutor-icon"></i>
                    <h2>Bulletin</h2>
                    <div class="click-div">
                        <a href="#">View in details</a>
                        <i class="fa-regular fa-hand-point-up"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- This part contain the footer of our system -->
    <footer>
        <p>©Marksheet Management System</p>
    </footer>
</body>

</html>