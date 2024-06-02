<?php
session_start();
require_once('../../functions.php');
require_once('../../models/GenericModel.php');
require_once('../../database/DBConnection.php');
require_once('delete_formTeacher.php');
logout_principal();
notconnected_principal();
verifysession();

$search = isset($_GET['search']) ? $_GET['search'] : '';

try {
    $model = new Joiningtables($db, 'form_tutors', 'classes', 'class_id', 'class_id');
    if ($search) {
        $query = "SELECT * FROM form_tutors 
                  INNER JOIN classes ON form_tutors.class_id = classes.class_id
                  WHERE form_tutors.fname LIKE :search OR form_tutors.lname LIKE :search OR classes.class_name LIKE :search";
        $stmt = $db->prepare($query);
        $stmt->execute(['search' => '%' . $search . '%']);
        $records = $stmt->fetchAll(PDO::FETCH_OBJ);
    } else {
        $records = $model->getAll();
    }
} catch (Exception $e) {
    $records = [];
    error_log("Error fetching form teachers: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of form teachers</title>
</head>
<body>
     <!-- this is the menu bar  of our system-->
    <header>
        <div>
            <h3>Dashboard</h3>
        </div>
        <div class="user">
            <div class="search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <form action="" method="get">
                    <input type="search" id="search" name="search" placeholder="Enter something">
                    <button type="submit" name="search_button" style="display: none;"></button>
                </form>
            </div>
        </div>    
    </header>
    <section class="principal-Section">
        <!-- this is the nav bar for the left side of our system-->
        <?php require_once('navbar.php')?>
        <!-- this div contain all the titulaires of different classes -->
        <div class="titulaire-container">
            <h2>List of form teachers</h2>
            <p>Here is the list of all form teachers and their associated classes starting from the first level up to the terminal level, they can simply be deleted and modified.</p>

            <!-- adding a new titulaire-->
            <div style="display: flex;gap:20px;justify-content:right">
                <div class="add-titulaire">
                    <div>
                        <i class="fa-solid fa-plus"></i>
                        <a href="./classes.php">Add a new form teacher</a>
                    </div>
                </div>
                <div class="add-titulaire">
                    <div>
                        <i class="fa-solid fa-bullhorn"></i>
                        <a href="../../mail/announce.php">Announce</a>
                    </div>
                </div>
            </div>

            <!-- titulaire -->
            <div class="all-titulaire">
                <?php
                    if ($search && count($records) === 0) {
                        echo '<p style="color:red; text-align:center;">No result found !!</p>';
                    } elseif (count($records) > 0) {
                        foreach ($records as $record) {
                            ?>
                                <div class="titulaire-item">
                                    <div class="item">
                                        <p><img src="profile_photo/<?= $record->profile_photo ?>" alt="image of form teacher"></p>
                                        <div>
                                            <h4><?= $record->fname . " " . $record->lname ?></h4>
                                            <p style="font-size: 12px;"><?= $record->email ?></p>
                                            <p><?= $record->class_name ?></p>
                                            <a class="modify" href="./editTitulaire.php?tutor_id=<?= $record->tutor_id ?>"><i class="fa-solid fa-pencil"></i></a>
                                            <button class="delete" data-formteacher-id="<?= $record->tutor_id ?>"><i class="fa-solid fa-trash-can"></i></button>
                                            <?= popup_delete($record, "principal", "Are you sure you want to remove", "fname", "lname", "tutor_id") ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
                    } else {
                        echo '<p style="color:red; text-align:center;">No Form teacher have been added !!</p>';
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
<?php require_once('../../javascript/popupdelete_formTeacher.php')?>
