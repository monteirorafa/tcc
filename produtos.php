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
    <title>Produtos</title>
    <link rel="stylesheet" href="css/produtos.css">
</head>

<body>
    <div class="cabecalho">
        <h1 class="titulo">Produtos</h1>
        <?php
        $adm = isset($_SESSION['adm']) && $_SESSION['adm'] == 1;
        if ($adm) {
            echo "<a href='cadastroProduto.php' class='button'>Cadastrar Produto</a>";
        }
        ?>
    </div>

    <?php
    $cont = 0;
    $produtoDAO = new ProdutoDAO();
    $objetoProduto = $produtoDAO->consultaProdutos();
    ?>

    <div class="container">
        <div class="row">

            <?php
            foreach ($objetoProduto as $produto) {
                $produto = new Produto($produto);
                if ($cont % 4 === 0) {
                    echo "</div><div class='row'>";
                };
            ?>

            <div class="col s12 m6 l3">
                <div class="card product-card">
                    <div class="card-image">
                        <img class="custom-image" src="<?php echo $produto->getImagem() ?>">
                    </div>
                    <div class="card-content">
                        <p class="product-price" id="prod"> <?php echo $produto->getCategoria(); ?> </p>
                        <p class="product-price" id="prod"> <?php echo $produto->getNome(); ?> </p>
                        <p class="product-price"> <?php echo $produto->getDescricao(); ?> </p>
                        <div class="product-info">
                            <p name="valor" class="product-price" value="<?php echo $produto->getValor() ?>"
                                title="<?php echo $produto->getValor() ?>">R$ <?php echo $produto->getValor() ?>
                            </p>
                        </div>

                        <form method="post" action="produtos.php">
                            <button name="carrinho" value="<?php echo $produto->getId() ?>">Adicionar ao
                                Carrinho</button>
                        </form>

                        <?php if ($adm) { ?>
                        <form method="post" action="alteraProduto.php">
                            <button name="altera" value="<?php echo $produto->getId() ?>">Editar Produto</button>
                        </form>
                        <?php }; ?>

                    </div>
                </div>
            </div>

            <?php
                $cont++;
            }

            if (isset($_POST["carrinho"])) {
                $carrinhoDAO = new CarrinhoDAO();
                $carrinhoDAO->adicionaCarrinho($_POST["carrinho"], $_SESSION['id']);
            }
            ?>

        </div>
    </div>

</body>

</html>