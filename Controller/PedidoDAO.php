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
            echo "<script> alert('Pedido realizado com sucesso.');
            window.location.href = 'index.php';
            </script>";
        } else {
            echo "Erro " . $pstmt . "<br>" . $this->conexao->errorInfo();
        }
    }

    public function consultaPedido(array $idCarrinho)
    {
        $arrayIds = implode(',', array_fill(0, count($idCarrinho), '?'));
        $pstmt = $this->conexao->prepare("SELECT * FROM pedidos WHERE idCarrinho IN ($arrayIds) ORDER BY criado");
        $pstmt->execute(array_values($idCarrinho));
        $lista = $pstmt->fetchAll(PDO::FETCH_CLASS, Pedido::class);
        return $lista;
    }

    public function consultaSituacao()
    {
        $pstmt = $this->conexao->prepare("SELECT situacao FROM pedidos");
        $pstmt->execute();
        $situacao = $pstmt->fetchColumn();
        return (string) $situacao;
    }

    public function pedidoEnviado($id)
    {
        $pstmt = $this->conexao->prepare("UPDATE pedidos SET situacao = :situacao WHERE id = :id");
        $pstmt->bindValue(":situacao", "Enviado");
        $pstmt->bindValue(":id", $id);
        $pstmt->execute();
        echo "<script> alert('Pedido marcado como enviado.');
        window.location.href = 'minhascompras.php';
        </script>";
    }

    public function pedidoEntregue($id)
    {
        $pstmt = $this->conexao->prepare("UPDATE pedidos SET situacao = :situacao WHERE id = :id");
        $pstmt->bindValue(":situacao", "Entregue");
        $pstmt->bindValue(":id", $id);
        $pstmt->execute();
        echo "<script> alert('Pedido marcado como entregue.');
        window.location.href = 'minhascompras.php';
        </script>";
    }

    public function extorno($id)
    {
        $pstmt = $this->conexao->prepare("UPDATE pedidos SET situacao = :situacao WHERE id = :id");
        $pstmt->bindValue(":situacao", "Cancelado");
        $pstmt->bindValue(":id", $id);

        if ($pstmt->execute()) {
            $carrinho = $this->conexao->prepare("SELECT * FROM pedidos WHERE id = :id");
            $carrinho->bindValue(":id", $id);
            $carrinho->execute();
            $lista = $carrinho->fetchAll(PDO::FETCH_CLASS, Pedido::class);

            if (!empty($lista)) {
                $pedido = $lista[0]; // Supondo que ID seja único, pegamos o primeiro item do array
                $selectPedido = $this->conexao->prepare("SELECT * FROM itemcarrinho WHERE idCarrinho = :idCarrinho");
                $selectPedido->bindValue(":idCarrinho", $pedido->getIdCarrinho());
                $selectPedido->execute();
                $itens = $selectPedido->fetchAll(PDO::FETCH_ASSOC);

                if ($itens) {
                    foreach ($itens as $item) {
                        $estoque = $this->conexao->prepare("UPDATE produto SET quantidade = quantidade + :quantidade WHERE id = :idProduto");
                        $estoque->bindValue(":quantidade", $item["quantidade"]);
                        $estoque->bindValue(":idProduto", $item["idProduto"]);
                        $estoque->execute();
                    }
                }
            }
            echo "<script> alert('Compra cancelada.');
        window.location.href = 'minhascompras.php';
        </script>";
        } else {
            echo "Erro: " . $pstmt->errorInfo()[2];
        }
    }

    public function buscaPedido($termo)
    {
        $pstmt = $this->conexao->prepare("SELECT * FROM usuario WHERE nome LIKE :termo OR cpf LIKE :termo OR email LIKE :termo OR cidade LIKE :termo ORDER BY nome, email, cpf, cidade");
        $termo = "%" . $termo . "%";
        $pstmt->bindParam(':termo', $termo, PDO::PARAM_STR);
        $pstmt->execute();
        $usuario = $pstmt->fetchAll(PDO::FETCH_CLASS, Usuario::class);
        return $usuario;
    }
}