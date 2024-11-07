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
    <title>Produtos</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/produtos.css">

</head>

<main>
    <div class="container">
        <div class="titulo">
            <h1>Produtos</h1>

            <?php
            $adm = isset($_SESSION['adm']) && $_SESSION['adm'] == 1;
            if ($adm) { ?>
                <button class="button" onclick="window.location.href='cadastroProduto.php';">
                    <span class="button-content">Cadastrar</span>
                </button>
            <?php }
            ?>

        </div>

        <form method="post" action="produtos.php">
            <div class="form-group">
                <label for="categoria">Categoria:</label>
                <select name="categoria" id="categoria" onchange="this.form.submit()">
                    <option value=""
                        <?php echo (isset($_POST['categoria']) && $_POST['categoria'] == '') ? 'selected' : ''; ?>>--Sem
                        Filtro--</option>
                    <option value="Calçados"
                        <?php echo (isset($_POST['categoria']) && $_POST['categoria'] == 'Calçados') ? 'selected' : ''; ?>>
                        Calçados</option>
                    <option value="Decoração"
                        <?php echo (isset($_POST['categoria']) && $_POST['categoria'] == 'Decoração') ? 'selected' : ''; ?>>
                        Decoração</option>
                    <option value="Eletrônicos"
                        <?php echo (isset($_POST['categoria']) && $_POST['categoria'] == 'Eletrônicos') ? 'selected' : ''; ?>>
                        Eletrônicos</option>
                    <option value="Roupas"
                        <?php echo (isset($_POST['categoria']) && $_POST['categoria'] == 'Roupas') ? 'selected' : ''; ?>>
                        Roupas</option>
                </select>
            </div>
        </form>


        <?php
        $cont = 0;
        $produtoDAO = new ProdutoDAO();

        if (isset($_POST["search"])) {
            $objetoProduto = $produtoDAO->buscaProdutos($_POST["search"]);
            $busca = true;
        ?>

            <div class="limpar">
                <span class="termo"><?php echo $_POST["search"] ?></span>
                <span class="divisor"></span>
                <i class="tiny material-icons closed" onclick="window.location.href='produtos.php';">close</i>
            </div>

        <?php
        } else {
            $categoria = $_POST["categoria"] ?? "";
            if ($categoria == "" || $categoria == "--Sem Filtro--") {
                $objetoProduto = $produtoDAO->consultaProdutos();
            } else {
                $objetoProduto = $produtoDAO->filtraCategoria($categoria);
            }
            $busca = false;
        }
        ?>

        <div class="row">

            <script src="js/produtos.js"></script>

            <?php
            foreach ($objetoProduto as $produto) {
                $produto = new Produto($produto);
                if ($cont % 4 === 0) {
                    echo "</div><div class='row'>";
                };
            ?>

                <div class="col s12 m3">
                    <div class="card">

                        <div class="card-image">
                            <img class="custom-image" src="<?php echo $produto->getImagem() ?>" alt="">

                            <?php
                            $adm = isset($_SESSION['adm']) && $_SESSION['adm'] == 1;
                            if ($adm && isset($_SESSION['id'])) { ?>

                                <form method="post" action="alteraProduto.php"
                                    id="productForm-<?php echo $produto->getId(); ?>">
                                    <input type="hidden" name="altera" value="<?php echo $produto->getId(); ?>">
                                    <a class="btn-floating halfway-fab waves-effect waves-light indigo darken-4 tooltipped custom-tooltip changeBtn"
                                        id="changeBtn-<?php echo $produto->getId(); ?>" data-position="left"
                                        data-tooltip="Alterar Produto"><i class="material-icons">edit</i></a>
                                </form>

                            <?php } elseif (isset($_SESSION['id'])) { ?>
                                <form method="post" action="produtos.php" id="productForm-<?php echo $produto->getId(); ?>">
                                    <input type="hidden" name="carrinho" value="<?php echo $produto->getId(); ?>">
                                    <a class="btn-floating halfway-fab waves-effect waves-light indigo darken-4 tooltipped custom-tooltip"
                                        id="submitBtn-<?php echo $produto->getId(); ?>" data-position="left"
                                        data-tooltip="Adicionar ao Carrinho" onclick="this.blur();">
                                        <i class="material-icons">add</i>
                                    </a>
                                </form>

                            <?php }; ?>

                        </div>

                        <div class="card-content">
                            <span class="card-title"><?php echo $produto->getNome(); ?></span>
                            <span class="categoria"><?php echo $produto->getCategoria(); ?></span>
                            <p class="descricao"><?php echo $produto->getDescricao(); ?></p>
                            <div class="card-footer">
                                <span name="valor" class="product-price" value="<?php echo $produto->getValor(); ?>"
                                    title="<?php echo $produto->getValor(); ?>">R$ <?php echo $produto->getValor(); ?>
                                </span>
                                <?php if ($adm && isset($_SESSION['id'])) { ?>
                                    <span class="estoque">Estoque: <?php echo $produto->getQuantidade(); ?></span>
                                <?php } ?>
                            </div>
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

</main>

<?php include_once __DIR__ . '/footer.php'; ?>

</html>