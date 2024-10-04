<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parar Live</title>
    <link rel="stylesheet" href="css/cadastro.css">
</head>

<body class="live">
    <div class="row">
        <div class="form-container">
            <form action="parar.php" method="post">
                <div class="form-group">
                    <label>Parar Live</label>

                    <label>Tem certeza que deseja encerrar a transmissão?</label>

                    <div class="button-container">
                        <button name="Sim" value="Sim">Parar Live</button>
                        <button class="button" onclick="window.location.href='index.php';">
                            <span class="button-content">Voltar</span>
                        </button>
                    </div>

                </div>
            </form>
        </div>
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