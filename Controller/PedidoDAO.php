<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once __DIR__ . '/../Conexao/Conexao.php';
include_once __DIR__ . '/../Controller/Pedido.php';

class PedidoDAO
{

    private $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::getConexao();
    }

    public function adicionaPedido(Pedido $pedido, $idUsuario)
    {
        $pstmt = $this->conexao->prepare("INSERT INTO pedidos (idCarrinho, idUsuario, criado, total, pagamento, entrega, situacao) 
        VALUES (:idCarrinho, :idUsuario, CURRENT_TIMESTAMP, :total, :pagamento, :entrega, :situacao)");
        $pstmt->bindValue(":idCarrinho", $pedido->getIdCarrinho());
        $pstmt->bindValue(":idUsuario", $pedido->getIdUsuario());
        $pstmt->bindValue(":total", $pedido->getTotal());
        $pstmt->bindValue(":pagamento", $pedido->getPagamento());
        $pstmt->bindValue(":entrega", $pedido->getEntrega());
        $pstmt->bindValue(":situacao", $pedido->getSituacao());

        if ($pstmt->execute()) {
            $selectPedido = $this->conexao->prepare("SELECT * FROM itemcarrinho WHERE idCarrinho = :idCarrinho");
            $selectPedido->bindValue(":idCarrinho", $pedido->getIdCarrinho());
            $selectPedido->execute();
            $itens = $selectPedido->fetchAll(PDO::FETCH_ASSOC);

            if ($itens) {
                foreach ($itens as $item) {
                    $estoque = $this->conexao->prepare("UPDATE produto SET quantidade = quantidade - :quantidade WHERE id = :idProduto");
                    $estoque->bindValue(":quantidade", $item["quantidade"]);
                    $estoque->bindValue(":idProduto", $item["idProduto"]);
                    $estoque->execute();
                }

                $carrinho = $this->conexao->prepare("UPDATE carrinho SET situacao = :situacao WHERE idUsuario = :idUsuario");
                $carrinho->bindValue(":situacao", "inativo");
                $carrinho->bindValue(":idUsuario", $idUsuario);
                $carrinho->execute();
            }

            echo "<script> alert('Pedido realizado.');</script>";
            header('Location: index.php');
        } else {
            echo "Erro " . $pstmt . "<br>" . $this->conexao->errorInfo();
        }
    }

    public function consultaPedido(array $idCarrinho)
    {
        $arrayIds = implode(',', array_fill(0, count($idCarrinho), '?'));
        $pstmt = $this->conexao->prepare("SELECT * FROM pedidos WHERE idCarrinho IN ($arrayIds)");
        $pstmt->execute(array_values($idCarrinho));
        $lista = $pstmt->fetchAll(PDO::FETCH_CLASS, Pedido::class);
        return $lista;
    }
}
