<?php

class Menu
{

    public function menuPrincipal()
    {
        $adm = isset($_SESSION['adm']) && $_SESSION['adm'] == 1;
        if ($adm) {
            echo "<li><a href='#.php'>Live</a></li>";
            echo "<li><a href='#.php'>Parar Live</a></li>";
            echo "<li><a href='#.php'>R.Vendas</a></li>";
            echo "<li><a href='Controller/Login.php?function=logout'>Sair</a></li>";
        } elseif (isset($_SESSION['sessaoID'])) {
            echo "<li><a href='minhascompras.php'>Minhas Compras</a></li>";
            echo "<li><a href='carrinho.php'>Carrinho</a></li>";
            echo "<li><a href='Controller/Login.php?function=logout'>Sair</a></li>";
        } else {
            echo "<li><a href='login.php'>Login</a></li>";
            echo "<li><a href='cadastro.php'>Cadastre-se</a></li>";
        }
    }

    public function menuMobile()
    {
        $adm = isset($_SESSION['adm']) && $_SESSION['adm'] == 1;
        if ($adm) {
            echo "<li><a href='#.php'><i class='material-icons left grey-text'>live_tv</i>Live</a></li>";
            echo "<li><a href='#.php'><i class='material-icons left grey-text'>stop_screen_share</i>Parar
            Live</a></li>";
            echo "<li><a href='#.php'><i class='material-icons left grey-text'>monetization_on</i>R.Vendas</a></li>";
            echo "<li><a href='Controller/Login.php?function=logout'><i class='material-icons left grey-text'>keyboard_backspace</i>Sair</a></li>";
        } elseif (isset($_SESSION['sessaoID'])) {
            echo "<li><a href='minhascompras.php'><i class='material-icons left grey-text'>computer</i>Minhas
            Compras</a></li>";
            echo "<li><a href='carrinho.php'><i class='material-icons left grey-text'>shopping_cart</i>Carrinho</a></li>";
            echo "<li><a href='Controller/Login.php?function=logout'><i class='material-icons left grey-text'>keyboard_backspace</i>Sair</a></li>";
        } else {
            echo "<li><a href='login.php'><i class='material-icons left grey-text'>keyboard_tab</i>Login</a></li>";
            echo "<li><a href='cadastro.php'><i class='material-icons left grey-text'>assignment_ind</i>Cadastre-se</a></li>";
        }
    }
}
