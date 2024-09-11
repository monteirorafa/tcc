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
    <title>Finalizar Compra</title>
</head>

<body>

    <div class="container">
        <form action="index.php" method="post">
            <h1 class="titulo">Confira seus dados</h1>
            <div class="card">
                <div class="card-content row">

                    <!--
                <div class="col s2">
                    <div class="center-align">
                        <img src="img_end/420.png" alt="Imagem do endereço">
                    </div>
                </div>
                    -->

                    <?php
                    $arrayPedidos = array();
                    $vTotal = 0;
                    $usuarioDAO = new UsuarioDAO();
                    $objetoUsuario = $usuarioDAO->consultaEndereco();
                    foreach ($objetoUsuario as $usuario) {
                        $usuario = new Usuario($usuario);
                    ?>

                    <div class="col s10">
                        <span class="card-title">Dados de entrega:</span>
                        <p class="product-price"> Endereço:
                            <?php echo $usuario->getEndereco() . ", " . $usuario->getNumero(); ?> </p>
                        <p class="product-price"> Cidade:
                            <?php echo $usuario->getCidade() . "/ " . $usuario->getEstado(); ?></p>
                        <p class="product-price"> CEP: <?php echo $usuario->getCep(); ?></p>
                        <p class="product-price"> Contato: <?php echo $usuario->getTelefone(); ?></p>
                        <div class="editar"><a href="#.php">Editar endereço</a></div>
                    </div>

                    <p>Selecione o tipo de entrega:</p>
                    <input type="radio" id="retirada" name="entrega" value="retirada" required checked>
                    <label for="retirada">Retirar na Loja</label><br>
                    <input type="radio" id="correios" name="entrega" value="correios">
                    <label for="correios">Correios</label><br>
                    <input type="radio" id="transportadora" name="entrega" value="transportadora">
                    <label for="transportadora">Transportadora</label>

                </div>

                <div>
                    <p>Selecione a forma de pagamento:</p>
                    <input type="radio" id="pix" name="pagamento" value="pix" required checked>
                    <label for="pix">Pix</label><br>
                    <input type="radio" id="cartao" name="pagamento" value="cartao">
                    <label for="cartao">Cartão</label><br>
                    <input type="radio" id="Boleto" name="pagamento" value="Boleto">
                    <label for="Boleto">Boleto</label>
                </div>

            </div>

            <?php

                        $carrinhoDAO = new CarrinhoDAO();
                        $objetoCarrinho = $carrinhoDAO->consultaCarrinho();
                        $carrinhoID = $carrinhoDAO->consultaCarrinhoId();
                        $itemDAO = new ItemCarrinhoDAO();
                        $objetoItem = $itemDAO->consultaItem($carrinhoID);
                        $itensPorProduto = [];
                        foreach ($objetoItem as $itemData) {
                            $item = new ItemCarrinho($itemData);
                            $produtoId = $item->getIdProduto();
                            if (!isset($itensPorProduto[$produtoId])) {
                                $itensPorProduto[$produtoId] = [];
                            }
                            $itensPorProduto[$produtoId][] = $item;
                        }

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

                                    $vTotal += $pTotal;
                                }
                            }
                        }
                    }
        ?>

            <input type="hidden" value="<?php echo $item->getIdCarrinho() ?>" name="idCarrinho">
            <input type="hidden" value="<?php echo $_SESSION['id'] ?>" name="idUsuario">
            <input type="hidden" value="<?php echo $vTotal ?>" name="total">
            <input type="hidden" value="processando" name="situacao">

            <div class="total">Total R$ <?php echo $vTotal ?> </div>

            <button name="finalizar" value="finalizar>">Finalizar Compra</button>


            <?php if (isset($_POST["finalizar"])) {
            // $pedidoDAO = new PedidoDAO();
            // $pedido = new Pedido($_POST);
            // $pedidoDAO->adicionaPedido($pedido, $_SESSION['id']);
        }
        ?>
        </form>

    </div>

</body>

</html>