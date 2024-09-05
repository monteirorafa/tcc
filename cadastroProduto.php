<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
    <link rel="stylesheet" href="css/cadastro.css">
</head>

<body>
    <div class="box">
        <form action="cadastroProduto.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Cadastro de Produto</legend>
                <div class="inputbox">
                    <input type="text" name="nome" id="nome" class="inputUser" autocomplete="one-time-code" required>
                    <label for="nome" class="labelInput">Nome do Produto</label>
                </div>
                <div class="inputbox">
                    <label for="categoria" class="inputUser">Categoria:</label>
                    <select name="categoria" id="categoria" class="selectBox" required>
                        <option value="" disabled selected>--Selecione--</option>
                        <option value="Calçados">Calçados</option>
                        <option value="Decoração">Decoração</option>
                        <option value="Eletrônicos">Eletrônicos</option>
                        <option value="Roupas">Roupas</option>
                    </select>
                </div>
                <div class="inputbox">
                    <input type="text" name="valor" id="valor" class="inputUser" pattern="[0-9,]*"
                        title="Somente números e vírgula para centavos, máximo 10." required>
                    <label for="valor" class="labelInput">Valor</label>
                </div>
                <div class="inputbox">
                    <input type="text" name="quantidade" id="quantidade" class="inputUser" pattern="[0-9.]*"
                        title="Somente números e ponto para centavos, máximo 10." required>
                    <label for="quantidade" class="labelInput">Quantidade</label>
                </div>
                <div class="inputbox">
                    <input type="text" name="descricao" id="descricao" class="inputUser" required>
                    <label for="descricao" class="labelInput">Descrição</label>
                </div>

                <div class="field-wrap">
                    <label for="imagem" class="labelInputFile">Imagem do Produto</label>
                    <input type="file" name="imagem" id="imagem" class="imagem" accept="image/*" required />
                </div>

                <input type='hidden' value='' name='criado'>
                <input type="submit" name="Cadastrar" value="Cadastrar" id="button" class="submit">

                <a href="produtos.php" id="button" class="voltar">Voltar</a>
            </fieldset>
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