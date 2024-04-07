<?php
require_once('../../functions.php');
require_once('../../models/GenericModel.php');
require_once('../../database/DBConnection.php');
$model = new GenericModel($db, 'classes');
$records = $model->getAll();
$start=0;
$length=25;
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
        <?php require_once('../navbar.php')?>
        <div class="class-content">
            <div class="title">
                <h2>Classes</h2>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequuntur iste impedit, possimus tempore reiciendis veniam nesciunt molestiae facere eligendi aliquid iusto, voluptas voluptates blanditiis ipsum aut est odit nulla cupiditate.</p>
            </div>
            <div class="all-classes">
                <?php
                    foreach($records as $record){
                        ?>
                            <div href="protectected_interface.php?class-id=<?= $record->class_id?>" class="items">
                                <strong>0<?= $record->class_id?></strong>
                                <p><?= $record->class_name?></p>
                                <span><?=substr($record->description,$start,$length) ?>...</span>
                                <div>
                                    <a class="details" href="../connect.html">View in details</a>
                                    <i class="fa-solid fa-arrow-right"></i>
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