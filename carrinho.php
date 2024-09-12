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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
    <link rel="stylesheet" href="css/produtos.css">
    <script src="js/carrinho.js"></script>
</head>

<body>
    <div class="cabecalho">
        <h1 class="titulo">Carrinho</h1>
    </div>

    <?php
    $vFinal = 0;
    $produtoDAO = new ProdutoDAO();
    $carrinhoDAO = new CarrinhoDAO();
    $objetoCarrinho = $produtoDAO->produtosCarrinho();
    ?>

    <div class="container">
        <div class="row">

            <?php
            $vTotal = 0;
            $cont = 0;
            if (empty($objetoCarrinho)) {
                echo "O carrinho está vazio.";
            } else {
                $carrinhoID = $carrinhoDAO->consultaCarrinhoId();
                $itemDAO = new ItemCarrinhoDAO();
                $objetoItem = $itemDAO->consultaItem($carrinhoID);
                $itensPorProduto = [];
            ?>

                <form action="compra.php" method="post">
                    <div class="button">
                        <button name="continua" id="continua" <?php if (empty($objetoItem)) {
                                                                    echo "disabled";
                                                                } ?>>Continuar</button>
                    </div>
                </form>

                <?php

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
                            if ($cont % 4 === 0) {
                                echo "</div><div class='row'>";
                            }
                ?>

                            <div class="col s12 m6 l3">
                                <div class="card product-card">
                                    <div class="card-image">
                                        <img class="custom-image" src="<?php echo $produto->getImagem() ?>">
                                    </div>
                                    <div class="card-content">
                                        <p class="product-price"> <?php echo $produto->getNome(); ?> </p>
                                        <p class="product-price"> <?php echo $produto->getDescricao(); ?> </p>
                                        <p class="product-price"> Quantidade: </p>
                                        <p class="subTotal"> R$
                                            <?php echo $pTotal = $produto->getValor() * $item->getQuantidade(); ?>
                                        </p>
                                        <form action="carrinho.php" method="post">
                                            <div class="product-price">
                                                <input type="button" name="diminuir" value="-" class="decrement">
                                                <input type="text" name="quantidade" value=""
                                                    placeholder="<?php echo $item->getQuantidade(); ?>" readonly>
                                                <label id="Aux" hidden><?php echo $produto->getQuantidade() ?></label>
                                                <?php if ($item->getQuantidade() < $produto->getQuantidade()) { ?>
                                                    <input type="button" name="aumentar" value="+" class="increment">
                                                <?php } else { ?>
                                                    <input type="button" name="aumentar" value="+" class="increment" disabled>
                                                <?php } ?>
                                            </div>
                                    </div>
                                </div>

                                <input type="hidden" value="<?php echo $item->getIdProduto(); ?>" name="idProduto">
                                <input type="hidden" value="<?php echo $item->getIdCarrinho(); ?>" name="idCarrinho">
                                <input type="submit" name="editar" value="editar" id="button" class="submit">
                                <input type="submit" name="excluir" value="excluir" id="button" class="submit">
                                </form>
                            </div>

            <?php
                            $cont++;
                            $vTotal += $pTotal;
                        }
                    }
                }
            }
            ?>

        </div>
    </div>

    <div class="total">Total R$ <?php echo $vTotal ?> </div>

    <?php
    if (isset($_POST["editar"])) {
        $carrinhoDAO = new CarrinhoDAO();
        $itemCarrinho = new ItemCarrinho($_POST);
        $carrinhoDAO->editarCarrinho($itemCarrinho);
    }

    if (isset($_POST["excluir"])) {
        $carrinhoDAO = new CarrinhoDAO();
        $itemCarrinho = new ItemCarrinho($_POST);
        $carrinhoDAO->excluirCarrinho($itemCarrinho);
    }
    ?>

</body>

</html>