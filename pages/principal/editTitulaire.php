
<?php
    session_start();
     require_once('../../functions.php');
     require_once('../../database/DBConnection.php');
     notconnected_principal();
     verifysession_principal();
     require_once('../../controllers/principal/edditFormteacher.controller.php');

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
    <title>Modify titulaire</title>
</head>

<body>
    <section class="connect-section">
        <div class="connect">
            <h3>Edit tutilaire</h3>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="input-content">
                    <div class="all-inputs">
                        <label for="name">First name:</label>
                        <input type="text" name="fname" value="<?= $fname_fetched?>" placeholder="Enter first name" required>
                    </div>
                </div>
                <div class="input-content">
                    <div class="all-inputs">
                        <label for="name">Last name:</label>
                        <input type="text" name="lname" value="<?= $lname_fetched?>" placeholder="Enter last name" required>
                    </div>
                </div>
                <div class="input-content">
                    <div class="all-inputs">
                        <label for="email">Email:</label>
                        <input type="email" name="email" value="<?= $email_fetched?>" placeholder="Enter the class of titulaire" required>
                    </div>
                </div>
                <div class="input-content">
                    <div class="all-inputs">
                        <label for="email">Class:</label>
                       <select name="classes" id="classes">
                        <option value=" ">Select the class</option>
                       <?php
                            $query = $db->prepare("SELECT * FROM classes ORDER BY class_id ASC");
                            $query->execute();
                            $classes = $query->fetchAll();
                            foreach ($classes as $class) {
                            ?>
                                <option value='<?=  $class['class_id'] ?> '> <?= $class['class_name'] ?> </option>
                            <?php    
                        }
                        ?>
                       </select>
                    </div>
                </div>
                <div class="input-content">
                    <div class="all-inputs">
                        <label for="name">Profile image:</label>
                        <input type="file" name="uploadfile" value="<?= $profile_photo_fetched?>"  placeholder="Enter the class of titulaire">
                    </div>
                </div>
                <div class="forgotten-password">
                    <p>Change password ?</p>
                    <a href="#">click here</a>
                </div>
                <div class="btn">
                    <button type="submit" name="modify">Save changes</button>
                </div>
            </form>
            <p class="error"><?= $error?></p><p class="success"><?= $success ?></p>
        </div>
    </section>
</body>

</html>
