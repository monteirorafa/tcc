<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once __DIR__ . '/../Conexao/Conexao.php';
include_once __DIR__ . '/../Controller/Cartao.php';

class CartaoDAO
{

    private $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::getConexao();
    }

    public function cartao(Cartao $cartao)
    {
        $cartaoAtivo = $this->conexao->prepare("SELECT * FROM cartao WHERE idUsuario = :idUsuario");
        $cartaoAtivo->bindValue(":idUsuario", $_SESSION['id']);
        $cartaoAtivo->execute();
        $ativo = $cartaoAtivo->fetchAll(PDO::FETCH_CLASS, Cartao::class);

        if ($ativo) {
            $atualizaCartao = $this->conexao->prepare("UPDATE cartao SET numero = :numero, vencimento = :vencimento, cvv = :cvv WHERE idUsuario = :idUsuario");
            $atualizaCartao->bindValue(":numero", $cartao->getNumero());
            $atualizaCartao->bindValue(":vencimento", $cartao->getVencimento());
            $atualizaCartao->bindValue(":cvv", $cartao->getCvv());
            $atualizaCartao->bindValue(":idUsuario", $_SESSION['id']);
            if ($atualizaCartao->execute()) {
                echo "<script> alert('Cartão atualizado com sucesso.');
                window.location.href = 'perfil.php';
                </script>";
            }
        } else {
            $criaCartao = $this->conexao->prepare("INSERT INTO cartao (idUsuario, numero, vencimento, cvv) VALUES (:idUsuario, :numero, :vencimento, :cvv)");
            $criaCartao->bindValue(":idUsuario", $_SESSION['id']);
            $criaCartao->bindValue(":numero", $cartao->getNumero());
            $criaCartao->bindValue(":vencimento", $cartao->getVencimento());
            $criaCartao->bindValue(":cvv", $cartao->getCvv());
            if ($criaCartao->execute()) {
                echo "<script> alert('Cartão inserido com sucesso.');
                window.location.href = 'perfil.php';
                </script>";
            }
        }
    }


    public function consultaCartao()
    {
        $pstmt = $this->conexao->prepare("SELECT * FROM cartao WHERE idUsuario = :idUsuario");
        $pstmt->bindValue(":idUsuario", $_SESSION['id']);
        $pstmt->execute();
        $cartao = $pstmt->fetchAll(PDO::FETCH_CLASS, Cartao::class);
        return $cartao;
    }
}