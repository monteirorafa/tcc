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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
    <link rel="stylesheet" href="css/carrinho.css">
    <script src="js/carrinho.js"></script>
</head>

<body>
    <div class="cabecalho">
        <h1 class="titulo">Carrinho</h1>
    </div>

    <?php
    $vFinal = 0;
    $carrinhoDAO = new CarrinhoDAO();
    $objetoCarrinho = $carrinhoDAO->consultaCarrinho();
    ?>

    <div class="container">
        <div class="row">

            <?php
            $vTotal = 0;
            if (empty($objetoCarrinho)) {
                echo "O carrinho está vazio.";
            } else {
                foreach ($objetoCarrinho as $carrinho) {
                    $carrinho = new Carrinho($carrinho);
                    $produtoDAO = new ProdutoDAO();
                    $objetoProduto = $produtoDAO->selectProduto($carrinho->getIdProduto());
                    foreach ($objetoProduto as $produto) {
                        $produto = new Produto($produto);
            ?>

            <div class="col s12">
                <form action="carrinho.php" method="post" enctype="multipart/form-data">
                    <div class="product-card">
                        <img src="<?php echo $produto->getImagem() ?>">
                        <div class="product-details">
                            <p class="Nome"> <?php echo $produto->getNome();  ?> </p>
                            <p class="Descricao"> <?php echo $produto->getDescricao(); ?> </p>
                            <p class="Qualidade"> Quantidade: </p>

                            <div class="Cont">
                                <input type="button" name="diminuir" value="-" class="decrement">
                                <input type="text" name="quant" value=""
                                    placeholder="<?php echo $carrinho->getQuantidade() ?>" readonly>
                                <label id="Aux" hidden><?php echo $produto->getQuantidade() ?></label>
                                <?php if ($carrinho->getQuantidade() < $produto->getQuantidade()) { ?>
                                <input type="button" name="aumentar" value="+" class="increment">
                                <?php } else { ?>
                                <input type="button" name="aumentar" value="+" class="increment" disabled>
                                <?php } ?>
                            </div>

                            <p class="subTotal"> R$
                                <?php echo $pTotal = $produto->getValor() * $carrinho->getQuantidade(); ?></p>
                        </div>
                    </div>

                    <div class="button">
                        <button name="editar" value="<?php echo $produto->getId() ?>"
                            title="<?php echo $produto->getId() ?>" class="Edit">Editar</button>
                    </div>

                    <div class="button">
                        <button name="excluir" value="<?php echo $produto->getId() ?>"
                            title="<?php echo $produto->getId() ?>" class="Edit">Excluir</button>
                    </div>

                </form>
            </div>

            <?php
                        $vTotal += $pTotal;
                    }
                }
                ?>

        </div>
    </div>

    <div class="total">Total R$ <?php echo $vTotal ?> </div>

    <form action="#.php" method="post" enctype="multipart/form-data">
        <div class="button">
            <button name="Des" id="Continua">Continuar</button>
        </div>
    </form>

    <?php }

            if (isset($_POST["editar"])) {
                $carrinhoDAO = new CarrinhoDAO();
                $carrinhoDAO->editarCarrinho($_POST["editar"], $_POST["quant"]);
            }

            if (isset($_POST["excluir"])) {
                $carrinhoDAO = new CarrinhoDAO();
                $carrinhoDAO->excluirCarrinho($_POST["excluir"]);
            }
?>

</body>

</html>