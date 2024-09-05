<?php
session_start();
if (isset($_SESSION['sessaoID'])) {
    header('location:home.php');
}
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="login">
        <h1>Login</h1>
        <form method="post" action="Controller/Login.php?function=login">
            <div id="erro">
                <?php
                if (isset($_GET["erro"])) {
                    echo "Usuário ou Senha Inválidos.";
                }
                ?>
            </div>
            <input type="text" placeholder="E-mail" name="email">
            <input type="password" placeholder="Senha" name="senha">
            <input type="submit" name="submit" value="Entrar" class="botao">
            <a href="index.php" id="button" class="voltar">Voltar</a>
            <a href="cadastro.php" class="cadastro">Não possui cadastro? Clique Aqui.</a>
        </form>
    </div>
</body>

</html>