<?php
if (!isset($_SESSION['id'])) {
    session_start();
}
include_once __DIR__ . '/menu.php';
include_once __DIR__ . '/Conexao/Conexao.php';
include_once __DIR__ . '../Controller/Usuario.php';
include_once __DIR__ . '../Controller/UsuarioDAO.php';
include_once __DIR__ . '../Controller/Cartao.php';
include_once __DIR__ . '../Controller/CartaoDAO.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>

    <link rel="stylesheet" href="css/perfil.css">
    <script src="js/cartao.js"></script>
</head>

<main>

    <div class="container">
        <div class="row">
            <div class='titulo'>
                <h1>Seus dados</h1>
            </div>

            <?php
            $usuarioDAO = new UsuarioDAO();
            $objetoUsuario = $usuarioDAO->consultaUsuario($_SESSION['id']);
            foreach ($objetoUsuario as $usuario) {
                $usuario = new Usuario($usuario);
            ?>

                <form action="perfil.php" method="post" class="form row custom-row">
                    <h1>Cadastro</h1>

                    <div class="col s12 m6 form-container">
                        <div class="form-group">
                            <label for="nome">Nome Completo</label>
                            <input type="text" name="nome" id="nome" autocomplete="one-time-code" required
                                value="<?php echo $usuario->getNome() ?>">
                        </div>
                        <div class="form-group">
                            <label for="cpf">CPF</label>
                            <input type="text" name="cpf" id="cpf" autocomplete="one-time-code" required
                                value="<?php echo $usuario->getCpf() ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="text" name="email" id="email" autocomplete="one-time-code" required
                                value="<?php echo $usuario->getEmail() ?>">
                        </div>
                        <div class="form-group">
                            <label for="telefone">Telefone</label>
                            <input type="text" name="telefone" id="telefone" pattern="[0-9]{11}" maxlength="11"
                                autocomplete="one-time-code" required value="<?php echo $usuario->getTelefone() ?>">
                        </div>
                        <div class="form-group">
                            <label for="senha">Senha</label>
                            <input type="password" name="senha" id="senha" maxlength="20" autocomplete="one-time-code"
                                required value="*">
                            <span class="lnr lnr-eye"></span>
                        </div>
                    </div>

                    <div class="col s12 m6 form-container">
                        <div class="form-group">
                            <label for="cidade">Cidade</label>
                            <input type="text" name="cidade" id="cidade" autocomplete="one-time-code" required
                                value="<?php echo $usuario->getCidade() ?>">
                        </div>
                        <div class="form-group">
                            <label for="endereco">Endereço</label>
                            <input type="text" name="endereco" id="endereco" autocomplete="one-time-code" required
                                value="<?php echo $usuario->getEndereco() ?>">
                        </div>
                        <div class="form-group">
                            <label for="numero">Número</label>
                            <input type="text" name="numero" id="numero" autocomplete="one-time-code" required
                                value="<?php echo $usuario->getNumero() ?>">
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <input type="text" name="estado" id="estado" autocomplete="one-time-code" required
                                value="<?php echo $usuario->getEstado() ?>">
                        </div>
                        <div class="form-group">
                            <label for="cep">CEP</label>
                            <input type="text" name="cep" id="cep" pattern="[0-9]{8}" maxlength="8"
                                title="Somente números, máximo 8." autocomplete="one-time-code" required
                                value="<?php echo $usuario->getCep() ?>">
                        </div>
                    </div>

                    <input type="hidden" value="<?php echo $usuario->getCpf(); ?>" name="cpf">

                    <div class="col s12 button-container">
                        <button name="AtualizarCad" value="AtualizarCad">Atualizar Cadastro</button>
                    </div>
                </form>

            <?php }
            $cartaoDAO = new CartaoDAO();
            $objetoCartao = $cartaoDAO->consultaCartao();
            $cartaoExistente = null;

            if (!empty($objetoCartao)) {
                $cartaoExistente = new Cartao($objetoCartao[0]);
            }
            ?>

            <form action="perfil.php" method="post" class="form-small row custom-row">
                <h1>Cartão</h1>

                <div class="col s12 form-container">
                    <div class="form-group">
                        <label for="numero">Número</label>
                        <input type="text" name="numero" id="numero" pattern="[0-9]{16,20}" minlength="16"
                            maxlength="20" title="Somente números, mínimo 16 e máximo 20." autocomplete="one-time-code"
                            value="<?php echo $cartaoExistente ? $cartaoExistente->getNumero() : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="vencimento">Vencimento</label>
                        <input type="date" name="vencimento" id="vencimento" autocomplete="one-time-code"
                            value="<?php echo $cartaoExistente ? $cartaoExistente->getVencimento() : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input type="password" name="cvv" id="cvv" pattern="[0-9]{3}" maxlength="3"
                            title="Somente números, máximo 3." autocomplete="one-time-code"
                            value="<?php echo $cartaoExistente ? "*" : ''; ?>" required>
                    </div>
                </div>

                <input type="hidden" name="idUsuario"
                    value="<?php echo htmlspecialchars($usuario->getId(), ENT_QUOTES, 'UTF-8'); ?>">

                <div class="col s12 button-container">
                    <button type="submit" name="AtualizarCart">Atualizar Cartão</button>
                </div>
            </form>
        </div>

        <?php
        if (isset($_POST["AtualizarCad"])) {
            $senhaHashed = password_hash($_POST["senha"], PASSWORD_DEFAULT);

            $dadosUsuario = $_POST;
            $dadosUsuario['senha'] = $senhaHashed;

            $user = new Usuario($dadosUsuario);

            $userDAO = new UsuarioDAO();
            $userDAO->atualizaCadastro($user);
        }

        if (isset($_POST["AtualizarCart"])) {
            $senhaHashed = password_hash($_POST["cvv"], PASSWORD_DEFAULT);

            $dadosUsuario = $_POST;
            $dadosUsuario['cvv'] = $senhaHashed;

            $user = new Cartao($dadosUsuario);

            $userDAO = new CartaoDAO();
            $userDAO->cartao($user);
        }
        ?>

    </div>
</main>

</html>