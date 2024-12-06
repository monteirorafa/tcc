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

<main>

    <?php
    $vFinal = 0;
    $produtoDAO = new ProdutoDAO();
    $carrinhoDAO = new CarrinhoDAO();
    $objetoCarrinho = $produtoDAO->produtosCarrinho();
    ?>

    <div class="container">
        <div class="row">

            <div class='titulo'>
                <h1>Carrinho</h1>
            </div>

            <?php
            $vTotal = 0;
            $cont = 0;
            if (empty($objetoCarrinho)) {
                echo "<div class='vazio'>";
                echo "<p>O carrinho está vazio.</p>";
                echo "</div>";
            } else {
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

                            <div class="container">
                                <ul class="collection">
                                    <li class="collection-item avatar">
                                        <img src="<?php echo $produto->getImagem() ?>" alt="" class="circle">
                                        <span class="title"><?php echo $produto->getNome() ?></span>
                                        <p><?php echo $produto->getDescricao() ?></p>
                                        <p>R$: <?php echo $produto->getValor() ?></p>

                                        <form method="post" action="carrinho.php" id="productForm-<?php echo $item->getId(); ?>">
                                            <input type="hidden" name="editar" value="<?php echo $produto->getId(); ?>">
                                            <div class="quantity">
                                                <button class="minus" aria-label="Decrease">&minus;</button>
                                                <input type="number" class="input-box" name="quantidade"
                                                    value="<?php echo $item->getQuantidade(); ?>" min="1"
                                                    max="<?php echo $produto->getQuantidade() ?>">
                                                <button class="plus" aria-label="Increase">&plus;</button>
                                            </div>
                                        </form>

                                        <form method="post" action="carrinho.php" id="productForm-<?php echo $item->getId(); ?>">
                                            <input type="hidden" value="<?php echo $produto->getId(); ?>" name="excluir">
                                            <input type="hidden" value="<?php echo $carrinhoID; ?>" name="idCarrinho">
                                            <button class="btn">
                                                <svg viewBox="0 0 15 17.5" height="17.5" width="15" xmlns="http://www.w3.org/2000/svg"
                                                    class="icon">
                                                    <path transform="translate(-2.5 -1.25)"
                                                        d="M15,18.75H5A1.251,1.251,0,0,1,3.75,17.5V5H2.5V3.75h15V5H16.25V17.5A1.251,1.251,0,0,1,15,18.75ZM5,5V17.5H15V5Zm7.5,10H11.25V7.5H12.5V15ZM8.75,15H7.5V7.5H8.75V15ZM12.5,2.5h-5V1.25h5V2.5Z"
                                                        id="Fill"></path>
                                                </svg>
                                            </button>
                                        </form>


                                        <p class="secondary-content">Valor total deste item: R$
                                            <?php echo $pTotal = $produto->getValor() * $item->getQuantidade(); ?></p>
                                    </li>
                                </ul>
                            </div>

            <?php
                            $cont++;
                            $vTotal += $pTotal;
                        }
                    }
                }
            }
            ?>

            <div class="container">
                <div class="checkout">
                    <label class="title">Checkout</label>
                    <div class="details">
                        <span>Total dos seus produtos:</span>
                        <span><?php echo "R$ " . $vTotal ?></span>
                        <span>Frete:</span>
                        <span>R$ 0.00</span>
                    </div>
                    <div class="checkout--footer">
                        <label class="price"><?php echo "R$ " . $vTotal ?></label>
                    </div>
                    <div class="finalizar">
                        <button onclick="window.location.href='compra.php';" <?php if (empty($objetoItem)) {
                                                                                    echo "disabled";
                                                                                } ?> class="button">
                            <span class="button-content">Finalizar Compra</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php

    if (isset($_POST["editar"]) && isset($_POST["quantidade"])) {
        $id = $_POST["editar"];
        $quantidade = $_POST["quantidade"];
        $carrinhoDAO = new CarrinhoDAO();
        $carrinhoDAO->editarCarrinho($id, $quantidade);
    }

    if (isset($_POST["excluir"])) {
        $carrinhoDAO = new CarrinhoDAO();
        $carrinhoDAO->excluirCarrinho($_POST['excluir'], $_POST['idCarrinho']);
    }
    ?>

</main>

</html>