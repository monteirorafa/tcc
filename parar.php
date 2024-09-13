<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parar Live</title>
    <link rel="stylesheet" href="css/cadastro.css">
</head>

<body>
    <div class="box">
        <form action="parar.php" method="post">
            <fieldset>
                <legend>Parar Live</legend>

                Tem certeza que deseja encerrar a transmissão?

                <input type="submit" name="Sim" value="Sim" id="button" class="submit">

                <a href="index.php" id="button" class="voltar">Voltar</a>

            </fieldset>
        </form>
    </div>

    <?php
    include_once __DIR__ . '../Controller/Live.php';
    include_once __DIR__ . '../Controller/LiveDAO.php';

    if (isset($_POST["Sim"])) {
        $liveDAO = new LiveDAO();
        $liveDAO->pararLive();
    }
    ?>

</body>

</html>