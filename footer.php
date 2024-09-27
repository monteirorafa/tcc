<?php
include_once __DIR__ . '/Controller/Menu.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://kit.fontawesome.com/afb7fe2592.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/footer.css">
</head>

<footer class="page-footer">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">Acesse nossas redes sociais</h5>
                <ul class="wrapper">
                    <li class="icon facebook" onclick="window.location.href='https://www.facebook.com';">
                        <span class="tooltip">Facebook</span>
                        <span><i class="fab fa-facebook"></i></i></span>
                    </li>
                    <li class="icon twitter" onclick="window.location.href='https://www.twitter.com';">
                        <span class="tooltip">Twitter</span>
                        <span><i class="fab fa-twitter"></i></span>
                    </li>
                    <li class="icon instagram" onclick="window.location.href='https://www.instagram.com';">
                        <span class="tooltip">Instagram</span>
                        <span><i class="fab fa-instagram"></i></span>
                    </li>
                    <li class="icon github" onclick="window.location.href='https://www.github.com';">
                        <span class="tooltip">Github</span>
                        <span><i class="fab fa-github"></i></span>
                    </li>
                    <li class="icon youtube" onclick="window.location.href='https://www.youtube.com';">
                        <span class="tooltip">Youtube</span>
                        <span><i class="fab fa-youtube"></i></span>
                    </li>
                </ul>
            </div>

            <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Links</h5>
                <ul class="wrapper">
                    <li class="lista"><a href="produtos.php">Produtos</a></li>
                    <?php (new Menu)->menuFooter(); ?>
                </ul>
            </div>
        </div>
    </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            © 2024 Projeto TCC Rafael Monteiro
            <a class="grey-text text-lighten-4 right" href="https://github.com/monteirorafa">Meu GitHub</a>
        </div>
    </div>
</footer>

</html>