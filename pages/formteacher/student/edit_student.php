<?php
   session_start();
   require_once('../../../database/DBConnection.php');
   require_once('../../../functions.php');
   require_once('../../../models/GenericModel.php');
   require_once('../../../database/DBConnection.php');
   require_once('../../../controllers/formteacher/editstudent.controller.php');
   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../../asset/style.css">
    <link rel="stylesheet" href="../../../asset/responsive.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Student</title>
</head>

<body>
    <section class="connect-section">
        <div class="connect">
            <h3>Edit Student</h3>
            <form action="" method="post" >
                <div class="input-content">
                <div class="all-inputs">
                        <label for="name">Registration number:</label>
                        <input type="text" name="regnumber" placeholder="Enter first name" value="<?=$regnumber_fetched?>" required>
                    </div>
                    <div class="all-inputs">
                        <label for="name">First name:</label>
                        <input type="text" name="fname" placeholder="Enter first name" value="<?=$fname_fetched?>" required>
                    </div>
                </div>
                <div class="input-content">
                    <div class="all-inputs">
                        <label for="name">Last name:</label>
                        <input type="text" name="lname" placeholder="Enter last name" value="<?=$lname_fetched?>"  required>
                    </div>
                </div>
                <div class="input-content">
                    <div class="all-inputs">
                        <label for="name">Date of birth:</label>
                        <input type="date" name="dob"  value="<?=$bob_fetched?>"  required>
                    </div>
                </div>
                <div class="input-content">
                    <div class="all-inputs">
                        <label for="name">Place of birth:</label>
                        <input type="text" name="pob" placeholder="Enter the place of birth" value="<?=$pob_fetched?>"  required>
                    </div>
                </div>
                <div class="input-content">
                    <div class="all-inputs">
                        <label for="name">Parent address:</label>
                        <input type="text" name="parent_address" placeholder="Enter the parent address"  value="<?=$parentAddress_fetched?>"  required>
                    </div>
                </div>
                <div class="btn">
                    <button type="submit" name="modify">Save change</button>
                </div>
                </p><p class="success"><?= $success ?><p class="error"><?= $error ?></p>
            </form>
        </div>
    </section>
</body>

</html>