<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Altera Produtos</title>
    <link rel="stylesheet" href="css/cadastro.css">
</head>

<body>

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

    <div class="box">
        <form action="alteraProduto.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Altera Produto</legend>
                <div class="inputbox">
                    <input type="text" name="nome" id="nome" class="inputUser"
                        value="<?php echo $produto->getNome(); ?>" autocomplete="one-time-code" required>
                    <label for="nome" class="labelInput">Nome do Produto</label>
                </div>
                <div class="inputbox">
                    <label for="categoria" class="inputUser">Categoria:</label>
                    <select name="categoria" id="categoria" class="selectBox" required>
                        <option value="" disabled>--Selecione--</option>
                        <option value="Calçados" <?php if ($produto->getCategoria() == 'Calçados') echo 'selected'; ?>>
                            Calçados</option>
                        <option value="Decoração"
                            <?php if ($produto->getCategoria() == 'Decoração') echo 'selected'; ?>>Decoração</option>
                        <option value="Eletrônicos"
                            <?php if ($produto->getCategoria() == 'Eletrônicos') echo 'selected'; ?>>Eletrônicos
                        </option>
                        <option value="Roupas" <?php if ($produto->getCategoria() == 'Roupas') echo 'selected'; ?>>
                            Roupas</option>
                    </select>
                </div>
                <div class="inputbox">
                    <input type="text" name="valor" id="valor" class="inputUser"
                        value="<?php echo $produto->getValor(); ?>" pattern="[0-9,]*"
                        title="Somente números e vírgula para centavos, máximo 10." required>
                    <label for="valor" class="labelInput">Valor</label>
                </div>
                <div class="inputbox">
                    <input type="text" name="quantidade" id="quantidade" class="inputUser"
                        value="<?php echo $produto->getQuantidade(); ?>" pattern="[0-9,]*"
                        title="Somente números e vírgula para centavos, máximo 10." required>
                    <label for="quantidade" class="labelInput">Quantidade</label>
                </div>
                <div class="inputbox">
                    <input type="text" name="descricao" id="descricao" class="inputUser"
                        value="<?php echo $produto->getDescricao(); ?>" required>
                    <label for="descricao" class="labelInput">Descrição</label>
                </div>

                <div class="field-wrap">
                    <img class="img" src="<?php echo $produto->getImagem(); ?>"></img>
                    <label for="imagem" class="labelInputFile">Imagem do Produto</label>
                    <input type="file" name="imagem" id="imagem" class="imagem" accept="image/*" required />
                </div>

                <input type="hidden" value="<?php echo $produto->getId(); ?>" name="id">
                <input type="hidden" value="<?php echo $produto->getCriado(); ?>" name="criado">
                <input type="submit" name="Alterar" value="Alterar" id="button" class="submit">

                <a href="produtos.php" id="button" class="voltar">Voltar</a>
            </fieldset>
        </form>
    </div>

</body>

</html>