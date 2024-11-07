<?php
if (!isset($_SESSION['id'])) {
    session_start();
}
include_once __DIR__ . '/menu.php';
include_once __DIR__ . '/Conexao/Conexao.php';
include_once __DIR__ . '../Controller/Produto.php';
include_once __DIR__ . '../Controller/ProdutoDAO.php';
include_once __DIR__ . '../Controller/Carrinho.php';
include_once __DIR__ . '../Controller/CarrinhoDAO.php';
include_once __DIR__ . '../Controller/ItemCarrinho.php';
include_once __DIR__ . '../Controller/ItemCarrinhoDAO.php';
include_once __DIR__ . '../Controller/Usuario.php';
include_once __DIR__ . '../Controller/UsuarioDAO.php';
include_once __DIR__ . '../Controller/Pedido.php';
include_once __DIR__ . '../Controller/PedidoDAO.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/minhascompras.css">
    <script src="js/minhascompras.js"></script>
</head>

<main>

    <div class="container">

        <?php
        $adm = isset($_SESSION['adm']) && $_SESSION['adm'] == 1;
        $produtoDAO = new ProdutoDAO();
        $carrinhoDAO = new CarrinhoDAO();

        if ($adm) {
            $objetoCarrinho = $produtoDAO->todosInativo();
            $carrinhoID = $carrinhoDAO->consultaTodosCarrinhoInativo();
            echo "<title>Minhas Vendas</title>";
            echo "<div class='titulo'>";
            echo "<h1>Minhas Vendas</h1>";
            echo "</div>";
        } else {
            $objetoCarrinho = $produtoDAO->produtosCarrinhoInativo();
            $carrinhoID = $carrinhoDAO->consultaCarrinhoInativo();
            echo "<title>Minhas Compras</title>";
            echo "<div class='titulo'>";
            echo "<h1>Minhas Compras</h1>";
            echo "</div>";
        } ?>

        <form class="searchForm" action="minhascompras.php" method="post">
            <input class="busca" id="search" name="search" type="search" placeholder="Buscar...">
        </form>

        <?php
        if (isset($_POST['search'])) { ?>

            <div class="limpar">
                <span class="termo"><?php echo $_POST["search"] ?></span>
                <span class="divisor"></span>
                <i class="tiny material-icons closed" onclick="<?php if ($adm) {
                                                                    echo "window.location.href='clientes.php';";
                                                                } else {
                                                                    echo "window.location.href='minhascompras.php';";
                                                                } ?>">
                    close
                </i>
            </div>

            <?php }
        foreach ($carrinhoID as $carrinho) {
            $itemDAO = new ItemCarrinhoDAO();
            $objetoItem = $itemDAO->consultaInativo($carrinho);

            $pedidoDAO = new PedidoDAO();
            $pedidos = $pedidoDAO->consultaPedido($carrinho);

            $itensPorProduto = [];

            foreach ($objetoItem as $itemData) {
                $item = new ItemCarrinho($itemData);
                $produtoId = $item->getIdProduto();
                if (!isset($itensPorProduto[$produtoId])) {
                    $itensPorProduto[$produtoId] = [];
                }
                $itensPorProduto[$produtoId][] = $item;
            }

            foreach ($pedidos as $pedido) {

                if ($pedido->getSituacao() == "Cancelado") {
                    $collapsible = "vermelho";
                } elseif ($pedido->getSituacao() == "Entregue") {
                    $collapsible = "verde";
                } elseif ($pedido->getSituacao() == "Enviado") {
                    $collapsible = "azul";
                } elseif ($pedido->getSituacao() == "Processando") {
                    $collapsible = "amarelo";
                }

                if ($adm) {
                    $usuarioDAO = new UsuarioDAO();
                    $usuarios = $usuarioDAO->consultaUsuario($pedido->getIdUsuario());
                    foreach ($usuarios as $usuario) { ?>

                        <ul class="collapsible <?php echo $collapsible ?>">
                            <li>
                                <div class="collapsible-header"><i class="material-icons">directions_bus</i>
                                    <span class="item">Nº: <?php echo $pedido->getId() ?></span>
                                    <span class="item">Comprador: <?php echo $usuario->getNome() ?></span>
                                    <span class="item">Valor Total: R$ <?php echo $pedido->getTotal() ?></span>
                                    <span class="item">Status: <?php echo $pedido->getSituacao() ?></span>
                                    <i class="material-icons">arrow_drop_down</i>
                                </div>

                                <div class="collapsible-body">

                                    <p class="topo">Pedido realizado: <?php echo $pedido->getCriado() ?></p>
                                    <p class="topo">Forma de pagamento: <?php echo $pedido->getPagamento() ?></p>
                                    <p class="topo">Forma de envio: <?php echo $pedido->getEntrega() ?></p>

                                    <?php
                                    if ($pedido->getSituacao() == "Processando") { ?>
                                        <form action="minhascompras.php" method="post">
                                            <button type="submit" name="enviar" value="<?php echo $pedido->getId() ?>" class="button">
                                                <span class="button-content">Pedido enviado</span>
                                            </button>
                                        </form>

                                    <?php } elseif ($pedido->getSituacao() == "Enviado") { ?>
                                        <form action="minhascompras.php" method="post">
                                            <button type="submit" name="finalizar" value="<?php echo $pedido->getId() ?>" class="button">
                                                <span class="button-content">Pedido entregue</span>
                                            </button>
                                        </form>

                                        <?php
                                    }
                                    foreach ($objetoCarrinho as $produtoData) {
                                        $produto = new Produto($produtoData);
                                        $produtoId = $produto->getId();
                                        if (isset($itensPorProduto[$produtoId])) {
                                            foreach ($itensPorProduto[$produtoId] as $item) {
                                        ?>

                                                <div class="container" id="items">
                                                    <ul class="collection">
                                                        <li class="collection-item avatar">
                                                            <img src="<?php echo $produto->getImagem() ?>" alt="" class="circle">
                                                            <span class="title"><?php echo $produto->getNome() ?></span>
                                                            <p><?php echo $produto->getDescricao() ?></p>
                                                            <p>R$: <?php echo $produto->getValor() ?></p>
                                                            <p><?php echo $item->getQuantidade() . " unidades" ?></p>
                                                            <p class="secondary-content">Valor total deste item: R$
                                                                <?php echo $pTotal = $produto->getValor() * $item->getQuantidade(); ?></p>
                                                        </li>
                                                    </ul>
                                                </div>

                                    <?php
                                            }
                                        }
                                    }
                                    ?>

                                    <div class="container" id="info">
                                        <ul class="collapsible custom-collapsible">
                                            <li>
                                                <div class="collapsible-header"><i class="material-icons">info_outline</i>
                                                    <span>Informações do Comprador</span>
                                                    <i class="material-icons">arrow_drop_down</i>
                                                </div>
                                                <div class="collapsible-body">
                                                    <p>CPF: <?php echo $usuario->getNome() ?></p>
                                                    <p>CPF: <?php echo $usuario->getCpf() ?></p>
                                                    <p>E-mail: <?php echo $usuario->getEmail() ?></p>
                                                    <p>Telefone: <?php echo $usuario->getTelefone() ?></p>
                                                    <p>Endereço:
                                                        <?php echo $usuario->getEndereco() . ", " . $usuario->getNumero() . ". " . $usuario->getCidade() . "/" . $usuario->getEstado() . ". " . $usuario->getCep() . "." ?>
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>

                    <?php
                    }
                } else { ?>

                    <ul class="collapsible <?php echo $collapsible ?>">
                        <li>
                            <div class="collapsible-header"><i class="material-icons">directions_bus</i>
                                <span class="item">Nº: <?php echo $pedido->getId() ?></span>
                                <span class="item">Data da Compra: <?php echo $pedido->getCriado() ?></span>
                                <span class="item">Valor Total: <?php echo $pedido->getTotal() ?></span>
                                <span class="item">Status: <?php echo $pedido->getSituacao() ?></span>
                                <i class="material-icons">arrow_drop_down</i>
                            </div>

                            <div class="collapsible-body">

                                <p class="topo">Forma de pagamento: <?php echo $pedido->getPagamento() ?></p>
                                <p class="topo">Forma de recebimento: <?php echo $pedido->getEntrega() ?></p>

                                <?php
                                if ($pedido->getSituacao() == "Processando" || $pedido->getSituacao() == "Enviado") { ?>
                                    <form action="minhascompras.php" method="post">
                                        <button type="submit" name="cancelar" value="<?php echo $pedido->getId() ?>" class="button">
                                            <span class="button-content">Cancelar Compra</span>
                                        </button>
                                    </form>

                                <?php } elseif ($pedido->getSituacao() == "Entregue") { ?>
                                    <form action="minhascompras.php" method="post">
                                        <button type="submit" name="devolver" value="<?php echo $pedido->getId() ?>" class="button">
                                            <span class="button-content">Devolver Compra</span>
                                        </button>
                                    </form>

                                    <?php }
                                foreach ($objetoCarrinho as $produtoData) {
                                    $produto = new Produto($produtoData);
                                    $produtoId = $produto->getId();
                                    if (isset($itensPorProduto[$produtoId])) {
                                        foreach ($itensPorProduto[$produtoId] as $item) {
                                    ?>

                                            <div class="container" id="items">
                                                <ul class="collection">
                                                    <li class="collection-item avatar">
                                                        <img src="<?php echo $produto->getImagem() ?>" alt="" class="circle">
                                                        <span class="title"><?php echo $produto->getNome() ?></span>
                                                        <p><?php echo $produto->getDescricao() ?></p>
                                                        <p>R$: <?php echo $produto->getValor() ?></p>
                                                        <p><?php echo $item->getQuantidade() . " unidades" ?></p>
                                                        <p class="secondary-content">Valor total deste item: R$
                                                            <?php echo $pTotal = $produto->getValor() * $item->getQuantidade(); ?></p>
                                                    </li>
                                                </ul>
                                            </div>

                                <?php
                                        }
                                    }
                                }
                                ?>

                            </div>
                        </li>
                    </ul>
        <?php }
            }
        }
        ?>

    </div>

    <?php
    if (isset($_POST["enviar"])) {
        $mudarPedido = new PedidoDAO();
        $mudarPedido->pedidoEnviado($_POST["enviar"]);
    }
    if (isset($_POST["finalizar"])) {
        $mudarPedido = new PedidoDAO();
        $mudarPedido->pedidoEntregue($_POST["finalizar"]);
    }
    if (isset($_POST["devolver"])) {
        $mudarPedido = new PedidoDAO();
        $mudarPedido->extorno($_POST["devolver"]);
    }
    if (isset($_POST["cancelar"])) {
        $mudarPedido = new PedidoDAO();
        $mudarPedido->extorno($_POST["cancelar"]);
    }
    ?>

</main>

<?php include_once __DIR__ . '/footer.php'; ?>

</html>