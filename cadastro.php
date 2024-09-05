<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/cadastro.css">
</head>

<body>
    <div class="box">
        <form action="cadastro.php" method="post">
            <fieldset>
                <legend>Cadastro de Usuário</legend>
                <div class="inputbox">
                    <input type="text" name="nome" id="nome" class="inputUser" autocomplete="one-time-code" required>
                    <label for="nome" class="labelInput">Nome Completo</label>
                </div>
                <div class="inputbox">
                    <input type="text" name="cpf" id="cpf" class="inputUser" autocomplete="one-time-code" required>
                    <label for="cpf" class="labelInput">CPF</label>
                </div>
                <div class="inputbox">
                    <input type="text" name="email" id="email" class="inputUser" autocomplete="one-time-code" required>
                    <label for="email" class="labelInput">E-mail</label>
                </div>
                <div class="inputbox">
                    <input type="text" name="cidade" id="cidade" class="inputUser" autocomplete="one-time-code"
                        required>
                    <label for="cidade" class="labelInput">Cidade</label>
                </div>
                <div class="inputbox">
                    <input type="text" name="endereco" id="endereco" class="inputUser" autocomplete="one-time-code"
                        required>
                    <label for="endereco" class="labelInput">Endereço</label>
                </div>
                <div class="inputbox">
                    <input type="text" name="numero" id="numero" class="inputUser" autocomplete="one-time-code"
                        required>
                    <label for="numero" class="labelInput">Número</label>
                </div>
                <div class="inputbox">
                    <input type="text" name="estado" id="estado" class="inputUser" autocomplete="one-time-code"
                        required>
                    <label for="estado" class="labelInput">Estado</label>
                </div>
                <div class="inputbox">
                    <input type="text" name="cep" id="cep" class="inputUser" pattern="[0-9]{8}" maxlength="8"
                        title="Somente números, máximo 8." autocomplete="one-time-code" required>
                    <label for="cep" class="labelInput">CEP</label>
                </div>
                <div class="inputbox">
                    <input type="text" name="telefone" id="telefone" class="inputUser" pattern="[0-9]{11}"
                        maxlength="11" autocomplete="one-time-code" required>
                    <label for="telefone" class="labelInput">Telefone</label>
                </div>
                <div class="inputbox">
                    <input type="password" name="senha" id="senha" class="inputUser" maxlength="20"
                        autocomplete="one-time-code" autocomplete="one-time-code" required>
                    <label for="senha" class="labelInput">Senha</label>
                    <span class="lnr lnr-eye"></span>
                </div>

                <input type="hidden" value="0" name="adm">
                <input type="submit" name="Cadastrar" value="Cadastrar" id="button" class="submit">

                <a href="index.php" id="button" class="voltar">Voltar</a>

            </fieldset>
        </form>
    </div>

    <?php
    include_once __DIR__ . '../Controller/Usuario.php';
    include_once __DIR__ . '../Controller/UsuarioDAO.php';

    if (isset($_POST["Cadastrar"])) {
        $userDAO = new UsuarioDAO();
        $user = new Usuario($_POST);
        $userDAO->cadastro($user);
    }
    ?>

</body>

</html>