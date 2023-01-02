<?php 
//File changed in the web, because of the URLs.
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ferreteria | Ecommerce</title>
        <!-- This one -->
        <link rel="stylesheet" href="/Project_Ecommerce/css/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/bee6767e27.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="header">
            <div class="container">
                <div class="navbar">
                    <div class="logo">
                    <!---<img src="images/background.jpg" width="125px">---->
                    </div>
                    <nav>
                        <ul id="MenuItems">
                            <!-- This one -->
                            <li><a href="/Project_Ecommerce/index.php">Inicio</a></li>
                            <!-- This one -->
                            <li><a href="/Project_Ecommerce/products.php">Productos</a></li>
                            <li><a href="">Sobre Nosotros</a></li>
                            <!-- This one -->
                            <li><a href="/Project_Ecommerce/account.php">Cuenta</a></li> 
                        </ul>
                    </nav>
                    <!-- This one -->
                    <a href="/Project_Ecommerce/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                    <!-- This one -->
                    <img src="/Project_Ecommerce/images/icon-menu.png" class="menu-icon" onclick="menutoggle()">
                </div>
            </div>
        </div>