<?php
require_once('../database/DBConnection.php');
require_once('../html_partials/header_html.php');
require_once('../controllers/loginControllers.php');
?>

    <section class="login-section">
        <div class="login-container">
            <div class="welcome-login">
                <div>
                    <h2>Hello friends</h2>
                    <p>Enter your personals details and</p>
                    <p>start your journey with us</p>
                    <span>Welcome</span>
                </div>
            </div>
            <div class="login-form">
                <h3>Log in to Account</h3>
                <form action="" method="post">
                    <div class="input-content">
                        <div class="all-inputs">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" name="mail" placeholder="Enter your email" required>
                        </div>
                    </div>
                    <div class="input-content">
                        <div class="all-inputs">
                            <i class="fa-solid fa-lock"></i>
                            <input class="password" name="password" type="password" placeholder="Enter your password" required>
                            <div class="eyes">
                                <i class="fa-solid fa-eye open"></i>
                                <i class="fa-solid fa-eye-slash close hidden"></i>

                            </div>
                        </div>
                    </div>
                    <div class="forgotten-password">
                        <p>Forgotten password</p>
                        <a href="#">click here</a>
                    </div>
                    <div class="btn">
                        <button type="submit" name="login">Sign up</button>
                    </div>
                </form>
            </div>
            <?= $error?>
        </div>
    </section>
    <script src="../javascript/app.js"></script>
<?php
require_once('../html_partials/footer_html.php');
?>