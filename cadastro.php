<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <link rel="stylesheet" href="css/cadastro.css">
</head>

<body class="cadastro">
    <div class="row">

        <form action="cadastro.php" method="post" class="form">

            <h1>Cadastro</h1>

            <div class="col s6 form-container">
                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <input type="text" name="nome" id="nome" autocomplete="one-time-code" required>
                </div>
                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input type="text" name="cpf" id="cpf" pattern="[0-9]{11}" title="Somente números, máximo 11"
                        maxlength="11" autocomplete="one-time-code" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="text" name="email" id="email" autocomplete="one-time-code" required>
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" name="telefone" id="telefone" pattern="[0-9]{11}"
                        title="Somente números, máximo 11" maxlength="11" autocomplete="one-time-code" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" maxlength="20" autocomplete="one-time-code"
                        autocomplete="one-time-code" required>
                    <span class="lnr lnr-eye"></span>
                </div>
            </div>

            <div class="col s6 form-container">
                <div class="form-group">
                    <label for="cidade">Cidade</label>
                    <input type="text" name="cidade" id="cidade" autocomplete="one-time-code" required>
                </div>
                <div class="form-group">
                    <label for="endereco">Endereço</label>
                    <input type="text" name="endereco" id="endereco" autocomplete="one-time-code" required>
                </div>
                <div class="form-group">
                    <label for="numero">Número</label>
                    <input type="text" name="numero" id="numero" autocomplete="one-time-code" required>
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <input type="text" name="estado" id="estado" autocomplete="one-time-code" required>
                </div>
                <div class="form-group">
                    <label for="cep">CEP</label>
                    <input type="text" name="cep" id="cep" pattern="[0-9]{8}" maxlength="8"
                        title="Somente números, máximo 8." autocomplete="one-time-code" required>
                </div>
            </div>
            <input type="hidden" value="0" name="adm">

            <div class="col s12 button-container">
                <button name="Cadastrar" value="Cadastrar">Cadastrar</button>
                <button type="button" class="button" onclick="window.location.href='index.php';">
                    <span class="button-content">Voltar</span>
                </button>
            </div>
        </form>

    </div>

    <?php
    if (isset($_POST["Cadastrar"])) {
        include_once __DIR__ . '../Controller/Usuario.php';
        include_once __DIR__ . '../Controller/UsuarioDAO.php';

        $userDAO = new UsuarioDAO();

        $senha = $_POST["senha"];
        if (!$userDAO->validarForcaSenha($senha)) { ?>
            <div id="erro">
                <p class='erro'><?php die("A senha deve ter no mínimo 8 caracteres, incluindo letras maiúsculas, minúsculas, números e
            caracteres especiais."); ?></p>
            </div>
    <?php }

        $senhaHashed = password_hash($senha, PASSWORD_DEFAULT);

        $dadosUsuario = $_POST;
        $dadosUsuario['senha'] = $senhaHashed;

        $user = new Usuario($dadosUsuario);

        $userDAO->cadastro($user);
    }
    ?>

</body>

</html>