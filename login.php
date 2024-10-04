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
    <link rel="stylesheet" href="css/cadastro.css">
</head>

<body class="live">
    <div class="row-small">

        <form action="Controller/Login.php?function=login" method="post" class="form">

            <h1>Login</h1>

            <div class="form-container">
                <div class="form-group">
                    <input type="text" placeholder="E-mail" name="email" autocomplete="new-password">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Senha" name="senha" autocomplete="one-time-code">
                </div>

                <a href="cadastro.php" class="cadastro">Não possui cadastro? Clique Aqui.</a>

                <div id="erro">
                    <?php
                    if (isset($_GET["erro"])) {
                        echo "<p>Usuário ou Senha Inválidos.</p>";
                    }
                    ?>
                </div>

                <div class="col s12 button-container">
                    <button name="Entrar" value="Entrar">Entrar</button>
                    <button type="button" class="button" onclick="window.location.href='index.php';">
                        <span class="button-content">Voltar</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>