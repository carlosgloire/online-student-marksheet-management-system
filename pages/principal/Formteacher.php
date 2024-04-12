<?php 
     session_start();
     require_once('../../functions.php');
     require_once('../../models/GenericModel.php');
     require_once('../../database/DBConnection.php');
     require_once('delete_formTeacher.php');
     logout_principal();
     notconnected_principal();
     verifysession_principal();
     $model = new Joiningtables($db, 'form_tutors',"classes","class_id");
     $records = $model->getAll();
   
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
    <title>Titulaire</title>
</head>

<body>
     <!-- this is the menu bar  of our system-->
     <?php require_once('../header.php')?>
    <section class="principal-Section">
        <!-- this is the nav bar for the left side of our system-->
        <?php require_once('../navbar.php')?>
        <!-- this div contain all the titulaires of different classes -->
        <div class="titulaire-container">
            <h2>All the form teachers</h2>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Repellendus maxime fugit quasi et cum accusantium temporibus corrupti illo harum laborum.</p>

            <!-- adding a new titulaire-->
            <div class="add-titulaire">
                <div>
                    <i class="fa-solid fa-plus"></i>
                    <a href="./classes.php">Add a new titulaire</a>
                </div>
            </div>

            <!-- titulaire -->
            <div class="all-titulaire">
                <?php
                    if(count($records) > 0){
                        foreach($records as $record){
                            ?>
                                <div class="titulaire-item">
                                    <div class="item">
                                        <p><img src="profile_photo/<?= $record->profile_photo?>" alt="image of form teacher"></p>
                                        <div>
                                            <h4><?=$record->fname." ".$record->lname?></h4>
                                            <p><?= $record->class_name?></p>
                                            <a class="modify" href="./editTitulaire.php?tutor_id=<?=$record->tutor_id?>"><i class="fa-solid fa-pencil"></i></a>
                                            <button class="delete" data-formteacher-id="<?= $record->tutor_id ?>"><i class="fa-solid fa-trash-can"></i></button>
                                            <?= popup_delete($record,"principal","are you sure you want to remove","fname","lname","tutor_id")?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
                    }
                    else{
                        ?>
                            <p style="color:red; text-align:center;"><?= "No Form teacher have been added !!"?></p>
                        <?php
                    }
                ?>
 
            </div>
        </div>
    </section>

    <!-- this is a popup for delete a module and for editing a module -->
   

    <div class="hidden-popup"></div>

    <!-- This part contain the footer of our system -->
    <footer>
        <p>©Marksheet Management System</p>
    </footer>
</body>
</html>
<script>
        // JavaScript code
    const deleteButtons = document.querySelectorAll('.delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default link behavior
            const productId = this.getAttribute('data-formteacher-id');
            const popup = this.nextElementSibling;
            popup.style.display = 'block';

            const closePopup = popup.querySelector('.cancel-popup');
            closePopup.addEventListener('click', function() {
                popup.style.display = 'none';
            });
        });
    });
</script>