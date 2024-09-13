<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live</title>
    <link rel="stylesheet" href="css/cadastro.css">
</head>

<body>
    <div class="box">
        <form action="live.php" method="post">
            <fieldset>
                <legend>Iniciar uma Live</legend>
                <div class="inputbox">
                    <input type="text" name="idVideo" id="idVideo" class="inputUser" autocomplete="one-time-code"
                        required>
                    <label for="idVideo" class="labelInput">Link da sua Live</label>
                </div>

                <div class="inputbox">
                    <input type="radio" id="plataforma" name="plataforma" value="youtube" required>
                    <label for="youtube">Youtube</label><br>
                    <input type="radio" id="plataforma" name="plataforma" value="facebook">
                    <label for="facebook">Facebook</label><br>
                    <input type="radio" id="plataforma" name="plataforma" value="instagram">
                    <label for="instagram">Instagram</label>
                </div>

                <input type="submit" name="Cadastrar" value="Cadastrar" id="button" class="submit">

                <a href="index.php" id="button" class="voltar">Voltar</a>

            </fieldset>
        </form>
    </div>

    <?php
    include_once __DIR__ . '../Controller/Live.php';
    include_once __DIR__ . '../Controller/LiveDAO.php';

    if (isset($_POST["Cadastrar"])) {
        $liveDAO = new LiveDAO();
        $live = new Live($_POST);
        $liveDAO->iniciaLive($live);
    }
    ?>

</body>

</html>