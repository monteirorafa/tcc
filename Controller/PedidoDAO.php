<?php

include_once __DIR__ . '/../Conexao/Conexao.php';
include_once __DIR__ . '/../Controller/Pedido.php';

class PedidoDAO
{

    private $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::getConexao();
    }

    public function finalizarPedido(Pedido $pedido)
    {
        $pstmt = $this->conexao->prepare("INSERT INTO pedidos (idCarrinho, idUsuario, idProduto, criacao, valor, entrega, situacao) 
        VALUES (:idCarrinho, :idUsuario, :validProdutoor, CURRENT_TIMESTAMP, :valor, :entrega, :situacao)");
        $pstmt->bindValue(":idCarrinho", $pedido->getIdCarrinho());
        $pstmt->bindValue(":idUsuario", $pedido->getIdUsuario());
        $pstmt->bindValue(":idProduto", $pedido->getIdProduto());
        $pstmt->bindValue(":valor", $pedido->getValor());
        $pstmt->bindValue(":entrega", $pedido->getEntrega());
        $pstmt->bindValue(":situacao", $pedido->getSituacao());
        echo $pedido;
        //$pstmt->execute();
        if ($pstmt) {
            echo "<script> alert('Pedido realizado.');</script>";
        } else {
            echo "Erro " . $pstmt . "<br>" . $this->conexao->errorInfo();
        }
    }
}
