<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once __DIR__ . '/../Conexao/Conexao.php';
include_once __DIR__ . '/../Controller/Live.php';

class LiveDAO
{

    private $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::getConexao();
    }

    public function iniciaLive(Live $live)
    {
        if ($live->getPlataforma() == "youtube") {
            $url = $live->getIdVideo();
            $inicio = strpos($url, "=") + 1;
            $fim = strpos($url, "&");
            $novoID = substr($url, $inicio, $fim - $inicio);
        } elseif ($live->getPlataforma() == "facebook") {
            $novoID = $live->getIdVideo();
        } elseif ($live->getPlataforma() == "instagram") {
            $url = $live->getIdVideo();
            $partes = explode('/', $url);
            $novoID = $partes[4];
        }
        $pstmt = $this->conexao->prepare("INSERT INTO live (idUsuario, idVideo, plataforma, live) 
                 VALUES (:idUsuario, :idVideo, :plataforma, :live)");
        $pstmt->bindValue(":idUsuario", $_SESSION['id']);
        $pstmt->bindValue(":idVideo", $novoID);
        $pstmt->bindValue(":plataforma", $live->getPlataforma());
        $pstmt->bindValue(":live", 1);
        $pstmt->execute();
        if ($pstmt) {
            echo "<script> alert('Live Iniciada.');
            window.location.href = 'index.php';
            </script>";
        } else {
            echo "Erro " . $pstmt . "<br>" . $this->conexao->errorInfo();
        }
    }

    public function pararLive()
    {
        $updateLive = $this->conexao->prepare("UPDATE live SET live=:live WHERE idUsuario = :idUsuario");
        $updateLive->bindValue(':live', 0);
        $updateLive->bindValue(":idUsuario", $_SESSION['id']);
        $updateLive->execute();
        if ($updateLive) {
            echo "<script> alert('Live finalizada.');
            window.location.href = 'index.php';
            </script>";
        } else {
            echo "Erro " . $updateLive . "<br>" . $this->conexao->errorInfo();
        }
    }

    public function selectLive()
    {
        $pstmt = $this->conexao->prepare("SELECT * FROM live WHERE live = 1");
        $pstmt->execute();
        $lista = $pstmt->fetchAll(PDO::FETCH_CLASS, Live::class);
        return $lista;
    }

    public function aoVivo()
    {
        $pstmt = $this->conexao->prepare("SELECT live FROM live WHERE live = 1");
        $pstmt->execute();
        $live = $pstmt->fetchColumn();
        return (int) $live;
    }
}
