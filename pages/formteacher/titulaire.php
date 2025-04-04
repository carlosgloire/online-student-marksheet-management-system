<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../asset/style.css">
    <link rel="stylesheet" href="../../asset/responsive.css">
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
        <!-- this div contain all the titulaires of different classes -->
        <div class="titulaire-container">
            <h2>All The Titulaires</h2>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Repellendus maxime fugit quasi et cum accusantium temporibus corrupti illo harum laborum.</p>

            <!-- adding a new titulaire-->
            <div class="add-titulaire">
                <div>
                    <i class="fa-solid fa-plus"></i>
                    <a href="./addNewTitulaire.php">Add a new titulaire</a>
                </div>
            </div>

            <!-- titulaire -->
            <div class="all-titulaire">
                <div class="titulaire-item">
                    <div class="item">
                        <p><img src="../../images/titulaire/anicet.jpg" alt="image of titulaire"></p>
                        <div>
                            <h4>Armel MBIATAT</h4>
                            <p>Titulaire first level</p>
                            <a class="modify" href="./editTitulaire.html"><i class="fa-solid fa-pencil"></i></a>
                            <button class="delete"><i class="fa-solid fa-trash-can"></i></button>
                        </div>
                    </div>
                </div>
                <div class="titulaire-item">
                    <div class="item">
                        <p><img src="../../images/titulaire/anicet.jpg" alt="image of titulaire"></p>
                        <div>
                            <h4>Armel MBIATAT</h4>
                            <p>Titulaire first level</p>
                            <a class="modify" href="./editTitulaire.html"><i class="fa-solid fa-pencil"></i></a>
                            <button class="delete"><i class="fa-solid fa-trash-can"></i></button>
                        </div>
                    </div>
                </div>
                <div class="titulaire-item">
                    <div class="item">
                        <p><img src="../../images/titulaire/anicet.jpg" alt="image of titulaire"></p>
                        <div>
                            <h4>Armel MBIATAT</h4>
                            <p>Titulaire first level</p>
                            <a class="modify" href="./editTitulaire.html"><i class="fa-solid fa-pencil"></i></a>
                            <button class="delete"><i class="fa-solid fa-trash-can"></i></button>
                        </div>
                    </div>
                </div>
                <div class="titulaire-item">
                    <div class="item">
                        <p><img src="../../images/titulaire/anicet.jpg" alt="image of titulaire"></p>
                        <div>
                            <h4>Armel MBIATAT</h4>
                            <p>Titulaire first level</p>
                            <a class="modify" href="./editTitulaire.html"><i class="fa-solid fa-pencil"></i></a>
                            <button class="delete"><i class="fa-solid fa-trash-can"></i></button>
                        </div>
                    </div>
                </div>
                <div class="titulaire-item">
                    <div class="item">
                        <p><img src="../../images/titulaire/anicet.jpg" alt="image of titulaire"></p>
                        <div>
                            <h4>Armel MBIATAT</h4>
                            <p>Titulaire first level</p>
                            <a class="modify" href="./editTitulaire.html"><i class="fa-solid fa-pencil"></i></a>
                            <button class="delete"><i class="fa-solid fa-trash-can"></i></button>
                        </div>
                    </div>
                </div>
                <div class="titulaire-item">
                    <div class="item">
                        <p><img src="../../images/titulaire/anicet.jpg" alt="image of titulaire"></p>
                        <div>
                            <h4>Armel MBIATAT</h4>
                            <p>Titulaire first level</p>
                            <a class="modify" href="./editTitulaire.html"><i class="fa-solid fa-pencil"></i></a>
                            <button class="delete"><i class="fa-solid fa-trash-can"></i></button>
                        </div>
                    </div>
                </div>
                <div class="titulaire-item">
                    <div class="item">
                        <p><img src="../../images/titulaire/anicet.jpg" alt="image of titulaire"></p>
                        <div>
                            <h4>Armel MBIATAT</h4>
                            <p>Titulaire first level</p>
                            <a class="modify" href="./editTitulaire.html"><i class="fa-solid fa-pencil"></i></a>
                            <button class="delete"><i class="fa-solid fa-trash-can"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- this is a popup for delete a module and for editing a module -->
    <div class="popup hidden-popup">
        <div class="popup-container">
            <h4>Dear user,</h4>
            <p>Do you want to delete this student</p>
            <p>into your system?</p>
            <div class="popup-btn">
                <button class="cancel-popup">Cancel</button>
                <button class="delete-popup">Delete</button>
            </div>
        </div>
    </div>

    <div class="hidden-popup"></div>

    <!-- This part contain the footer of our system -->
    <footer>
        <p>©Marksheet Management System</p>
    </footer>


    <script src="../../javascript/popup.js"></script>
</body>

</html>