
<?php
    session_start();
    require_once('../../../app/Form/form.php');
    require_once('../../../functions.php');
    require_once('../../../database/DBConnection.php');
    logout_formteacher2();
    $request = $db->prepare("SELECT * FROM students_per_class WHERE class_id = {$_SESSION['class_id']} ");
    $request->execute();
   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../../css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of students</title>
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
        </nav>

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
            <?php
                if($request->rowCount() > 0){
                    while( $students = $request->fetch(PDO::FETCH_ASSOC)){
                        
                        ?>
                          <div class="list-student">
                            <div class="student-identity">
                                <div class="stdt"><p class="regnumber"><?=$students['regnumber'] ?></p></p><?=$students['fname']." ".$students['lname']?><p></div>
                                <div>
                                    <a class="modify" href="./edit_student.php?student_id=<?= $students['student_id']?>"><i class="fa-solid fa-pencil"></i></a>
                                    <button  class="delete" data-formteacher-id="<?= $students['student_id'] ?>"><i class="fa-solid fa-trash-can"></i></button>
                                </div>
                            </div>
                            <?= popup_delete2("principal","Are you sure you want to remove",$students['fname'],$students['lname'],$students['student_id'])?>
                        </div>
                        <?php
                    }
                }
                else{
                    ?>
                        <p style="color:red; text-align:center;"><?= "No student already added !!"?></p>
                    <?php
                }

            ?>
        </div>
    </section>
   
                
  
    <div class="hidden-popup"></div>

    <!-- This part contain the footer of our system -->
    <footer>
        <p>©Marksheet Management System</p>
    </footer>
</body>
</html>
<?php require_once('../../../javascript/popupdelete_formTeacher.php');