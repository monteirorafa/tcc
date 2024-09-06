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
        $pstmt = $this->conexao->prepare("INSERT INTO pedidos (idCarrinho, idUsuario, idProduto, numero, criacao, valor, pagamento, entrega, situacao) 
        VALUES (:idCarrinho, :idUsuario, :idProduto, :numero, CURRENT_TIMESTAMP, :valor, :pagamento, :entrega, :situacao)");
        $pstmt->bindValue(":idCarrinho", $pedido->getIdCarrinho());
        $pstmt->bindValue(":idUsuario", $pedido->getIdUsuario());
        $pstmt->bindValue(":idProduto", $pedido->getIdProduto());
        $pstmt->bindValue(":numero", $pedido->getNumero());
        $pstmt->bindValue(":valor", $pedido->getValor());
        $pstmt->bindValue(":pagamento", $pedido->getPagamento());
        $pstmt->bindValue(":entrega", $pedido->getEntrega());
        $pstmt->bindValue(":situacao", $pedido->getSituacao());
        $pstmt->execute();
        if ($pstmt) {
            echo "<script> alert('Pedido realizado.');</script>";
        } else {
            echo "Erro " . $pstmt . "<br>" . $this->conexao->errorInfo();
        }
    }

    public function atribuiNumero()
    {
        $verificaPedidos = $this->conexao->prepare("SELECT IFNULL(MAX(numero), 0) + 1 FROM pedidos");
        $numero = $verificaPedidos->execute();
        return $numero;
    }
}
