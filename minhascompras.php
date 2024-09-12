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
    <title>Minhas Compras</title>
</head>

<body>

    <div class="container">
        <h1 class="titulo">Minhas Compras</h1>

        <?php
        $adm = isset($_SESSION['adm']) && $_SESSION['adm'] == 1;
        $produtoDAO = new ProdutoDAO();
        $carrinhoDAO = new CarrinhoDAO();

        if ($adm) {
            $objetoCarrinho = $produtoDAO->todosInativo();
            $carrinhoID = $carrinhoDAO->consultaTodosCarrinhoInativo();
        } else {
            $objetoCarrinho = $produtoDAO->produtosCarrinhoInativo();
            $carrinhoID = $carrinhoDAO->consultaCarrinhoInativo();
        }

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
                if ($adm) {
                    $usuarioDAO = new UsuarioDAO();
                    $usuarios = $usuarioDAO->consultaUsuario($pedido->getIdUsuario());
                    foreach ($usuarios as $usuario) {
        ?>

                        <ul class="collapsible">
                            <li>
                                <div class="collapsible-header"><i class="material-icons">directions_bus</i>Pedido Número:
                                    <?php echo $pedido->getId() ?>
                                    <span>Valor Total: <?php echo $pedido->getTotal() ?></span>
                                    <span>Comprador: <?php echo $usuario->getNome() ?></span>
                                    <span>Clique para detalhes</span>
                                </div>

                                <div class="collapsible-body">

                                    <?php
                                    foreach ($objetoCarrinho as $produtoData) {
                                        $produto = new Produto($produtoData);
                                        $produtoId = $produto->getId();
                                        if (isset($itensPorProduto[$produtoId])) {
                                            foreach ($itensPorProduto[$produtoId] as $item) {
                                    ?>

                                                <ul class="collection">
                                                    <li class="collection-item avatar">
                                                        <img src="<?php echo $produto->getImagem() ?>" alt="" class="circle">
                                                        <span class="title"><?php echo $produto->getNome() ?></span>
                                                        <p><?php echo $produto->getDescricao() ?><br>
                                                            R$: <?php echo $produto->getValor() ?> <br>
                                                            <?php echo $item->getQuantidade() . " unidades" ?>
                                                        </p>
                                                        <p class="secondary-content">Valor total deste item: R$
                                                            <?php echo $pTotal = $produto->getValor() * $item->getQuantidade(); ?></p>
                                                    </li>
                                                </ul>

                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                    <p>Pedido realizado: <?php echo $pedido->getCriado() ?></p>
                                    <p>Forma de pagamento: <?php echo $pedido->getPagamento() ?></p>
                                    <p>Status da entrega: <?php echo $pedido->getSituacao() ?></p>
                                    <p>Nome: <?php echo $usuario->getNome() ?></p>
                                    <p>CPF: <?php echo $usuario->getCpf() ?></p>
                                    <p>E-mail: <?php echo $usuario->getEmail() ?></p>
                                    <p>Telefone: <?php echo $usuario->getTelefone() ?></p>
                                    <p>Endereço: <?php echo $usuario->getEndereco() . ", " . $usuario->getNumero() ?></p>
                                    <p>Cidade: <?php echo $usuario->getCidade() . "/" . $usuario->getEstado() ?></p>
                                    <p>CEP: <?php echo $usuario->getCep() ?></p>



                                </div>
                            </li>
                        </ul>

                    <?php
                    }
                } else { ?>
                    <ul class="collapsible">
                        <li>
                            <div class="collapsible-header"><i class="material-icons">directions_bus</i>Pedido Número:
                                <?php echo $pedido->getId() ?>
                                <span>Valor Total: <?php echo $pedido->getTotal() ?></span>
                                <span>Clique para detalhes</span>
                            </div>

                            <div class="collapsible-body">

                                <?php
                                foreach ($objetoCarrinho as $produtoData) {
                                    $produto = new Produto($produtoData);
                                    $produtoId = $produto->getId();
                                    if (isset($itensPorProduto[$produtoId])) {
                                        foreach ($itensPorProduto[$produtoId] as $item) {
                                ?>

                                            <ul class="collection">
                                                <li class="collection-item avatar">
                                                    <img src="<?php echo $produto->getImagem() ?>" alt="" class="circle">
                                                    <span class="title"><?php echo $produto->getNome() ?></span>
                                                    <p><?php echo $produto->getDescricao() ?><br>
                                                        R$: <?php echo $produto->getValor() ?> <br>
                                                        <?php echo $item->getQuantidade() . " unidades" ?>
                                                    </p>
                                                    <p class="secondary-content">Valor total deste item: R$
                                                        <?php echo $pTotal = $produto->getValor() * $item->getQuantidade(); ?></p>
                                                </li>
                                            </ul>

                                <?php
                                        }
                                    }
                                }
                                ?>
                                <p>Pedido realizado: <?php echo $pedido->getCriado() ?></p>
                                <p>Forma de pagamento: <?php echo $pedido->getPagamento() ?></p>
                                <p>Status da entrega: <?php echo $pedido->getSituacao() ?></p>

                            </div>
                        </li>
                    </ul>
        <?php }
            }
        }
        ?>

    </div>

</body>

</html>