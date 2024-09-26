<?php
include_once __DIR__ . '/Controller/Menu.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Google Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- JQuery para o menu hamburguer funcionar -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="js/menu.js"></script>

    <!-- Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css" rel="stylesheet">

    <!-- Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <link rel="stylesheet" href="css/menu.css">
</head>

<body>
    <nav class="nav-border">
        <div class="nav-wrapper">
            <div class="container">
                <div class="row">

                    <div class="col s2">
                        <a href="#" class="brand-logo">Nome</a>
                        <a href="#" data-activates="mobile-menu" class="button-collapse"><i
                                class="material-icons">menu</i></a>
                    </div>

                    <div class="col s8 hide-on-med-and-down" id="pesq">
                        <form>
                            <div class="input-field">
                                <input id="search" type="search" placeholder="Buscar..." required>
                                <label class="label-icon" for="search"><i class="material-icons">search</i>
                                </label>
                                <i class="material-icons closed">close</i>
                            </div>
                        </form>
                    </div>

                    <div class="right hide-on-med-and-down">
                        <ul class="right">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="produtos.php">Produtos</a></li>
                            <?php (new Menu)->menuPrincipal(); ?>
                        </ul>
                    </div>

                    <div>
                        <ul class="side-nav" id="mobile-menu">
                            <li><a href="index.php"><i class="material-icons left grey-text">home</i>Home</a></li>
                            <li><a href="produtos.php"><i class="material-icons left grey-text">favorite</i>Produtos</a>
                            </li>
                            <?php (new Menu)->menuMobile(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</body>

</html>