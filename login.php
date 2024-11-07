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

        <form action="login.php" method="post" class="form">

            <h1>Login</h1>

            <div class="form-container">
                <div class="form-group">
                    <input type="text" placeholder="E-mail" name="email" autocomplete="new-password">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Senha" name="senha" autocomplete="one-time-code">
                </div>

                <p class="signin">Não possui cadastro? <a href="cadastro.php">Clique Aqui.</a> </p>

                <div class="col s12 button-container">
                    <button name="Entrar" value="Entrar">Entrar</button>
                    <button type="button" class="button" onclick="window.location.href='index.php';">
                        <span class="button-content">Voltar</span>
                    </button>
                </div>
            </div>
        </form>

        <?php
    include_once __DIR__ . '../Controller/UsuarioDAO.php';

    if (isset($_POST["Entrar"])) {
        $email = $_POST["email"];
        $senha = $_POST["senha"];

        $userDAO = new UsuarioDAO();
        $user = $userDAO->buscaPorEmail($email);

        if ($user) {
            if (password_verify($senha, $user->getSenha())) {

                session_start();
                session_regenerate_id();
                $sessaoID = session_id();

                $userDAO->atualizaSessao($user->getId(), $sessaoID);

                $_SESSION['id'] = $user->getId();
                $_SESSION['sessaoID'] = $sessaoID;
                $_SESSION['adm'] = $user->getAdm();

                echo "DEU CERTO:";
                header('location: index.php');
                exit();
            } else {
    ?>

        <div id="erro">
            <p class='erro'>Usuário ou Senha Inválidos.</p>
        </div>

        <?php
                exit();
            }
        } else {
            ?>

        <div id="erro">
            <p class='erro'>Usuário ou Senha Inválidos.</p>
        </div>

        <?php
            exit();
        }
    }
    ?>

    </div>

</body>

</html>