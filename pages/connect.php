<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../asset/style.css">
    <link rel="stylesheet" href="../asset/responsive.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect</title>
</head>

<body>
    <section class="connect-section">
        <div class="connect">
            <h3>Sign In to Account</h3>
            <form action="">
                <div class="input-content">
                    <div class="all-inputs">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" placeholder="Enter your email" required>
                    </div>
                </div>
                <div class="input-content">
                    <div class="all-inputs">
                        <i class="fa-solid fa-lock"></i>
                        <input class="password" type="password" placeholder="Enter your password" required>
                        <div class="eyes">
                            <i class="fa-solid fa-eye open"></i>
                            <i class="fa-solid fa-eye-slash close hidden"></i>

                        </div>
                    </div>
                </div>
                <div class="forgotten-password">
                    <p>Forgotten password</p>
                    <a href="../pages/forgot-password.php">click here</a>
                </div>
                <div class="btn">
                    <button type="submit">Sign in</button>
                </div>
            </form>
        </div>
    </section>

    <!-- This part contain the footer of our system -->
    <footer>
        <p>©Marksheet Management System</p>
    </footer>

    <script src="../javascript/app.js"></script>
</body>

</html>