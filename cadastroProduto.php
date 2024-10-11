<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
    <link rel="stylesheet" href="css/cadastro.css">
</head>

<body class="cadastro">
    <div class="row">

        <form action="cadastroProduto.php" method="post" enctype="multipart/form-data">

            <h1>Cadastro de Produto</h1>

            <div class="form-container">
                <div class="form-group">
                    <label for="nome">Nome do Produto</label>
                    <input type="text" name="nome" id="nome" autocomplete="one-time-code" required>
                </div>

                <div class="form-group">
                    <label for="categoria">Categoria:</label>
                    <span class="select-group">
                        <select name="categoria" required>
                            <option value="" disabled selected>--Selecione--</option>
                            <option value="Calçados">Calçados</option>
                            <option value="Decoração">Decoração</option>
                            <option value="Eletrônicos">Eletrônicos</option>
                            <option value="Roupas">Roupas</option>
                        </select>
                    </span>
                </div>

                <div class="form-group">
                    <label for="valor">Valor</label>
                    <input type="text" name="valor" id="valor" pattern="[0-9,]*"
                        title="Somente números e vírgula para centavos, máximo 10." required>
                </div>

                <div class="form-group">
                    <label for="quantidade">Quantidade</label>
                    <input type="text" name="quantidade" id="quantidade" pattern="[0-9]*" title="Somente números."
                        required>
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <input type="text" name="descricao" id="descricao" required>
                </div>

                <div class="form-group">
                    <label for="imagem" class="labelInputFile">Imagem do Produto</label>
                    <input type="file" name="imagem" id="imagem" class="imagem" accept="image/*" required />
                </div>
            </div>
            <input type="hidden" value="" name="criado">

            <div class="button-container">
                <button name="Cadastrar" value="Cadastrar">Cadastrar</button>
                <button class="button" onclick="window.location.href='produtos.php';">
                    <span class="button-content">Voltar</span>
                </button>
            </div>

        </form>
    </div>

    <?php
    include_once __DIR__ . '../Controller/Produto.php';
    include_once __DIR__ . '../Controller/ProdutoDAO.php';

    if (isset($_POST["Cadastrar"])) {
        if ($_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
            $arquivo = $_FILES['imagem'];
            $_POST['imagem'] = "img/" . $arquivo['name'];
            if (move_uploaded_file($arquivo["tmp_name"], $_POST['imagem'])) {
                $userDAO = new ProdutoDAO();
                $user = new Produto($_POST);
                $userDAO->cadastro($user);
            } else {
                echo "Erro ao mover o arquivo.";
            }
        } else {
            echo "Erro no upload do arquivo.";
        }
    }
    ?>

</body>

</html>