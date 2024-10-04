<?php

include_once __DIR__ . '/../Controller/UsuarioDAO.php';

class Menu
{

    public function menuPrincipal()
    {
        if (isset($_SESSION['id'])) {
            $usuario = new UsuarioDAO();
            $nome = $usuario->consultaNome();
        }
        $adm = isset($_SESSION['adm']) && $_SESSION['adm'] == 1;
        if ($adm) {
            echo "<li><a href='minhascompras.php'>Minhas Vendas</a></li>";
            echo "<li><a href='clientes.php'>Clientes</a></li>";
            echo "<li><a href='Controller/Login.php?function=logout'>Sair</a></li>";
            echo "<li><span> || Olá " . $nome . " (ADM) ||</span></li>";
        } elseif (isset($_SESSION['sessaoID'])) {
            echo "<li><a href='minhascompras.php'>Minhas Compras</a></li>";
            echo "<li><a href='carrinho.php'>Carrinho</a></li>";
            echo "<li><a href='Controller/Login.php?function=logout'>Sair</a></li>";
            echo "<li><span> || Olá " . $nome . " ||</span></li>";
        } else {
            echo "<li><a href='login.php'>Login</a></li>";
            echo "<li><a href='cadastro.php'>Cadastre-se</a></li>";
        }
    }

    public function menuMobile()
    {
        $adm = isset($_SESSION['adm']) && $_SESSION['adm'] == 1;
        if ($adm) {
            echo "<li><a href='live.php'><i class='material-icons left grey-text'>live_tv</i>Live</a></li>";
            echo "<li><a href='parar.php'><i class='material-icons left grey-text'>stop_screen_share</i>Parar
            Live</a></li>";
            echo "<li><a href='minhascompras.php'><i class='material-icons left grey-text'>monetization_on</i>Minhas Vendas</a></li>";
            echo "<li><a href='clientes.php'><i class='material-icons left grey-text'>person</i>Clientes</a></li>";
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

    public function menuFooter()
    {
        $adm = isset($_SESSION['adm']) && $_SESSION['adm'] == 1;
        if ($adm) {
            echo "<li class='lista'><a class='listaBorder' href='minhascompras.php'>Minhas Vendas</a></li>";
            echo "<li class='lista'><a class='listaBorder' href='clientes.php'>Clientes</a></li>";
            echo "<li class='lista'><a class='listaBorder' href='Controller/Login.php?function=logout'>Sair</a></li>";
        } elseif (isset($_SESSION['sessaoID'])) {
            echo "<li class='lista'><a class='listaBorder' href='minhascompras.php'>Minhas Compras</a></li>";
            echo "<li class='lista'><a class='listaBorder' href='carrinho.php'>Carrinho</a></li>";
            echo "<li class='lista'><a class='listaBorder' href='Controller/Login.php?function=logout'>Sair</a></li>";
        } else {
            echo "<li class='lista'><a class='listaBorder' href='login.php'>Login</a></li>";
            echo "<li class='lista'><a class='listaBorder' href='cadastro.php'>Cadastre-se</a></li>";
        }
    }
}
