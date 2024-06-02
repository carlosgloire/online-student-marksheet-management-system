<?php
session_start();
require_once('../../../app/Form/form.php');
require_once('../../../functions.php');
require_once('../../../database/DBConnection.php');
logout_formteacher2();
verifysession2();

$search = isset($_GET['search']) ? $_GET['search'] : '';

try {
    if ($search) {
        $query = "SELECT * FROM students_per_class WHERE class_id = :class_id AND (fname LIKE :search OR lname LIKE :search OR regnumber LIKE :search)";
        $request = $db->prepare($query);
        $request->execute(array('class_id' => $_SESSION['class_id'], 'search' => '%' . $search . '%'));
    } else {
        $query = "SELECT * FROM students_per_class WHERE class_id = :class_id";
        $request = $db->prepare($query);
        $request->execute(array('class_id' => $_SESSION['class_id']));
    }
    $students = $request->fetchAll(PDO::FETCH_OBJ);
    if ($students === false) {
        $students = [];
    }
} catch (Exception $e) {
    $students = [];
    error_log("Error fetching students: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../../css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Students</title>
</head>
<body>
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

        <div class="class-content">
            <div class="tutor-connected">
                <p><img src="../../principal/profile_photo/<?= $_SESSION['file']?>"></p>
                <h5><?= $_SESSION['fname']." ".$_SESSION['lname']?></h5>
            </div>
            <div class="title">
                <h2>List of Students</h2>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequuntur iste impedit, possimus tempore reiciendis veniam nesciunt molestiae facere eligendi aliquid iusto, voluptas voluptates blanditiis ipsum aut est odit nulla cupiditate.</p>
            </div>
            <div class="add-student">
                <div>
                    <i class="fa-solid fa-plus"></i>
                    <a href="addStudent.php">Add student</a>
                </div>
            </div>

            <?php if ($search && count($students) === 0): ?>
                <p style="color:red; text-align:center;">No result found !!</p>
            <?php elseif (count($students) > 0): ?>
                <?php foreach ($students as $student): ?>
                    <div class="list-student">
                        <div class="student-identity">
                            <div class="stdt">
                                <p class="regnumber"><?= $student->regnumber ?></p>
                                <p><?= $student->fname . " " . $student->lname ?></p>
                            </div>
                            <div>
                                <a class="modify" href="./edit_student.php?student_id=<?= $student->student_id ?>"><i class="fa-solid fa-pencil"></i></a>
                                <button class="delete" data-formteacher-id="<?= $student->student_id ?>"><i class="fa-solid fa-trash-can"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="popup hidden-popup">
                        <div class="popup-container">
                            <h4>Dear Form teacher,</h4>
                            <p>Are sure you want to delete this student</p>
                            <p>into your system?</p>
                            <div class="popup-btn">
                                <button style="cursor:pointer" class="cancel-popup">Cancel</button>
                                <button style="cursor:pointer" class="delete-popup">Delete</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color:red; text-align:center;">No students already added !!</p>
            <?php endif; ?>
        </div>

    </section>

    <!-- This part contains the footer of our system -->
    <footer>
        <p>©Marksheet Management System</p>
    </footer>
</body>
</html>
<script src="../../../javascript/popup.js"></script>
