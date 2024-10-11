<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Altera Produtos</title>
    <link rel="stylesheet" href="css/cadastro.css">
</head>

<body class="cadastro">

    <?php
    include_once __DIR__ . '../Controller/Produto.php';
    include_once __DIR__ . '../Controller/ProdutoDAO.php';

    if (isset($_POST["Alterar"])) {
        if ($_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
            $arquivo = $_FILES['imagem'];
            $_POST['imagem'] = "img/" . $arquivo['name'];
            if (move_uploaded_file($arquivo["tmp_name"], $_POST['imagem'])) {
                $userDAO = new ProdutoDAO();
                $user = new Produto($_POST);
                $userDAO->alteraProduto($user);
            } else {
                echo "Erro ao mover o arquivo.";
            }
        } else {
            echo "Erro no upload do arquivo.";
        }
    }

    if (isset($_POST["altera"])) {
        $produtoDAO = new ProdutoDAO();
        $objetoProduto = $produtoDAO->selectProduto($_POST["altera"]);

        foreach ($objetoProduto as $produto) {
            $produto = new Produto($produto);
        }
    }
    ?>

    <div class="row">
        <form action="alteraProduto.php" method="post" enctype="multipart/form-data">

            <h1>Altera Produto</h1>

            <div class="form-container">
                <div class="form-group">
                    <label for="nome">Nome do Produto</label>
                    <input type="text" name="nome" id="nome" value="<?php echo $produto->getNome(); ?>"
                        autocomplete="one-time-code" required>
                </div>

                <div class="form-group">
                    <label for="categoria">Categoria:</label>
                    <span class="select-group">
                        <select name="categoria" required>
                            <option value="" disabled>--Selecione--</option>
                            <option value="Calçados"
                                <?php if ($produto->getCategoria() == 'Calçados') echo 'selected'; ?>>
                                Calçados</option>
                            <option value="Decoração"
                                <?php if ($produto->getCategoria() == 'Decoração') echo 'selected'; ?>>
                                Decoração</option>
                            <option value="Eletrônicos"
                                <?php if ($produto->getCategoria() == 'Eletrônicos') echo 'selected'; ?>>Eletrônicos
                            </option>
                            <option value="Roupas" <?php if ($produto->getCategoria() == 'Roupas') echo 'selected'; ?>>
                                Roupas</option>
                        </select>
                    </span>
                </div>

                <div class="form-group">
                    <label for="valor">Valor</label>
                    <input type="text" name="valor" id="valor" value="<?php echo $produto->getValor(); ?>"
                        pattern="[0-9.]*" title="Somente números e ponto para centavos, máximo 10." required>

                </div>

                <div class="form-group">
                    <label for="quantidade">Quantidade</label>
                    <input type="text" name="quantidade" id="quantidade"
                        value="<?php echo $produto->getQuantidade(); ?>" pattern="[0-9]*" title="Somente números."
                        required>

                </div>

                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <input type="text" name="descricao" id="descricao" value="<?php echo $produto->getDescricao(); ?>"
                        required>

                </div>

                <div class="form-group">
                    <p class="imagem"><label for="imagem">Imagem do Produto</label></p>
                    <p class="imagem"><img class="img" src="<?php echo $produto->getImagem(); ?>"></img></p>
                    <p class="imagem"><input type="file" name="imagem" accept="image/*" required /></p>
                </div>
            </div>

            <input type="hidden" value="<?php echo $produto->getId(); ?>" name="id">
            <input type="hidden" value="<?php echo $produto->getCriado(); ?>" name="criado">

            <div class="button-container">
                <button name="Alterar" value="Alterar">Alterar</button>
                <button class="button" onclick="history.back();">
                    <span class="button-content">Voltar</span>
                </button>
            </div>

        </form>
    </div>

</body>

</html>