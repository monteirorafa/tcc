<?php
session_start();
include_once __DIR__ . '/menu.php';
include_once __DIR__ . '/Conexao/Conexao.php';
include_once __DIR__ . '../Controller/Usuario.php';
include_once __DIR__ . '../Controller/UsuarioDAO.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>

    <link rel="stylesheet" href="css/index.css">
</head>

<main>

    <div class=" container">

        <div class="titulo">
            <h1>Clientes</h1>
        </div>

        <form class="searchForm" action="clientes.php" method="post">
            <input class="busca" id="search" name="search" type="search" placeholder="Buscar...">
        </form>

        <table class="highlight centered responsive-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                    <th>Cidade</th>
                    <th>CEP</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $usuarioDAO = new UsuarioDAO();

                if (isset($_POST["search"])) {
                    $objetoUsuario = $usuarioDAO->buscaUsuarios($_POST["search"]);
                    $busca = true; ?>

                <div class="limpar">
                    <span class="termo"><?php echo $_POST["search"] ?></span>
                    <span class="divisor"></span>
                    <i class="tiny material-icons closed" onclick="window.location.href='clientes.php';">close</i>
                </div>

                <?php
                } else {
                    $objetoUsuario = $usuarioDAO->selectUsuarios();
                    $busca = false;
                }

                foreach ($objetoUsuario as $usuario) {
                    $usuario = new Usuario($usuario);
                ?>

                <tr>
                    <td><?php echo $usuario->getNome() ?></td>
                    <td><?php echo $usuario->getCPF() ?></td>
                    <td><?php echo $usuario->getEmail() ?></td>
                    <td><?php echo $usuario->getTelefone() ?></td>
                    <td><?php echo $usuario->getEndereco() .  ", " . $usuario->getNumero() ?></td>
                    <td><?php echo $usuario->getCidade() .  " / " . $usuario->getEstado() ?></td>
                    <td><?php echo $usuario->getCep() ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>

</main>

<?php include_once __DIR__ . '/footer.php'; ?>

</html>