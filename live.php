<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live</title>
    <link rel="stylesheet" href="css/cadastro.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>

<body class="live">
    <div class="row">
        <div class="form-container">
            <form action="live.php" method="post" class="form">
                <div class="form-group">
                    <label for="idVideo">Link da sua Live</label>
                    <input type="text" name="idVideo" id="idVideo" autocomplete="one-time-code" required>
                </div>
                <div class="form-group">
                    <br><label id="">Selecione a Plataforma</label>
                </div>
                <div class="radio-inputs">
                    <label>
                        <input class="radio-input" type="radio" id="plataforma" name="plataforma" value="youtube"
                            required>
                        <span class="radio-tile">
                            <span class="radio-icon-youtube">
                                <i class="fab fa-youtube"></i>
                            </span>
                            <span class="radio-label">YouTube</span>
                        </span>
                    </label>
                    <label>
                        <input class="radio-input" type="radio" id="plataforma" name="plataforma" value="facebook"
                            required>
                        <span class="radio-tile">
                            <span class="radio-icon-facebook">
                                <i class="fab fa-facebook"></i>
                            </span>
                            <span class="radio-label">Facebook</span>
                        </span>
                    </label>
                    <label>
                        <input class="radio-input" type="radio" id="plataforma" name="plataforma" value="instagram"
                            required>
                        <span class="radio-tile">
                            <span class="radio-icon-instagram">
                                <i class="fab fa-instagram"></i>
                            </span>
                            <span class="radio-label">Instagram</span>
                        </span>
                    </label>
                </div>

                <div class="button-container">
                    <button name="Cadastrar" value="Cadastrar">Iniciar Live</button>
                    <button type="button" class="button" onclick="window.location.href='index.php';">
                        <span class="button-content">Voltar</span>
                    </button>
                </div>

            </form>
        </div>
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