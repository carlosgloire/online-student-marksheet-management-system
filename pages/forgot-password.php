<?php
session_start();
require_once('../mail/send-password-reset.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot password</title>
</head>

<body>
    <section class="connect-section">
        <div class="connect">
            <h3>Forgot password</h3>
            <form action="" method="post">
              <div class="input-content">
                    <div class="all-inputs">
                        <label for="">Email</label>
                        <input type="email" name="email" placeholder="Enter your email">
                    </div>
                </div>
                <div class="btn">
                    <button type="submit" name="send">Send</button>
                </div>
                <p class="error"><?= $error?></p><p class="success"><?= $success ?></p>
            </form>
        </div>
    </section>
</body>
</html>
