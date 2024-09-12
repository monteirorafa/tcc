<?php
if (!isset($_SESSION['id'])) {
    session_start();
}
include_once __DIR__ . '/../Conexao/Conexao.php';
include_once __DIR__ . '/../Controller/Carrinho.php';

class CarrinhoDAO
{

    private $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::getConexao();
    }

    public function adicionaCarrinho($idProduto, $idUsuario)
    {
        $carrinhoAtivo = $this->conexao->prepare("SELECT id FROM carrinho WHERE idUsuario = :idUsuario AND situacao = 'ativo'");
        $carrinhoAtivo->bindValue(":idUsuario", $idUsuario);
        $carrinhoAtivo->execute();
        $ativo = $carrinhoAtivo->fetch(PDO::FETCH_ASSOC);

        if ($ativo) {
            $idCarrinho = $ativo['id'];
        } else {

            $criaCarrinho = $this->conexao->prepare("INSERT INTO carrinho (idUsuario, situacao) VALUES (:idUsuario, :situacao)");
            $criaCarrinho->bindValue(":idUsuario", $idUsuario);
            $criaCarrinho->bindValue(":situacao", "ativo");
            $criaCarrinho->execute();

            $idCarrinho = $this->conexao->lastInsertId();
        }

        $selectItemID = $this->conexao->prepare("SELECT id FROM itemcarrinho WHERE idCarrinho = :idCarrinho AND idProduto = :idProduto");
        $selectItemID->bindValue(":idCarrinho", $idCarrinho);
        $selectItemID->bindValue(":idProduto", $idProduto);
        $selectItemID->execute();
        $itemCarrinhoID = $selectItemID->fetch(PDO::FETCH_ASSOC);

        if ($itemCarrinhoID) {
            $selectQuantidade = $this->conexao->prepare("UPDATE itemcarrinho SET quantidade = quantidade + 1 WHERE id = :id");
            $selectQuantidade->bindValue(":id", $itemCarrinhoID["id"]);
            $selectQuantidade->execute();

            return "Quantidade do item atualizada com sucesso!";
        } else {

            $criaItemCarrinho = $this->conexao->prepare("INSERT INTO itemcarrinho (idCarrinho, idProduto, quantidade) VALUES (:idCarrinho, :idProduto, :quantidade)");
            $criaItemCarrinho->bindValue(":idCarrinho", $idCarrinho);
            $criaItemCarrinho->bindValue(":idProduto", $idProduto);
            $criaItemCarrinho->bindValue(":quantidade", 1);
            $criaItemCarrinho->execute();

            return "Item adicionado com sucesso!";
        }
    }

    public function consultaCarrinhoId()
    {
        $consultaID = $this->conexao->prepare("SELECT c.id FROM usuario u, carrinho c, itemcarrinho i, produto p WHERE u.id = c.idUsuario AND c.id = i.idCarrinho AND p.id = i.idProduto AND u.id = :id AND c.situacao = :situacao");
        $consultaID->bindValue(":id", $_SESSION['id']);
        $consultaID->bindValue(":situacao", "ativo");
        $consultaID->execute();
        $id = $consultaID->fetch(PDO::FETCH_ASSOC);
        return (int) $id['id'];
    }

    public function consultaCarrinhoInativo()
    {
        $consultaID = $this->conexao->prepare("SELECT DISTINCT c.id FROM usuario u, carrinho c, itemcarrinho i, produto p WHERE u.id = c.idUsuario AND c.id = i.idCarrinho AND p.id = i.idProduto AND u.id = :id AND c.situacao = :situacao");
        $consultaID->bindValue(":id", $_SESSION['id']);
        $consultaID->bindValue(":situacao", "inativo");
        $consultaID->execute();
        $id = $consultaID->fetchAll(PDO::FETCH_ASSOC);
        return $id;
    }

    public function consultaTodosCarrinhoInativo()
    {
        $consultaID = $this->conexao->prepare("SELECT DISTINCT c.id FROM usuario u, carrinho c, itemcarrinho i, produto p WHERE u.id = c.idUsuario AND c.id = i.idCarrinho AND p.id = i.idProduto AND c.situacao = :situacao");
        $consultaID->bindValue(":situacao", "inativo");
        $consultaID->execute();
        $id = $consultaID->fetchAll(PDO::FETCH_ASSOC);
        return $id;
    }

    public function editarCarrinho(ItemCarrinho $itemcarrinho)
    {
        $updateCarrinho = $this->conexao->prepare("UPDATE itemcarrinho SET quantidade=:quantidade WHERE idProduto = :idProduto AND idCarrinho = :idCarrinho");
        $updateCarrinho->bindValue(':quantidade', $itemcarrinho->getQuantidade());
        $updateCarrinho->bindValue(':idProduto', $itemcarrinho->getIdProduto());
        $updateCarrinho->bindValue(":idCarrinho", $itemcarrinho->getIdCarrinho());
        $updateCarrinho->execute();
        if ($updateCarrinho) {
            echo "<script> alert('Quantidade modificada.');
            window.location.href = 'Carrinho.php';
            </script>";
        } else {
            echo "Erro " . $updateCarrinho . "<br>" . $this->conexao->errorInfo();
        }
    }

    public function excluirCarrinho(ItemCarrinho $itemcarrinho)
    {
        $deleteCarrinho = $this->conexao->prepare("DELETE FROM itemcarrinho WHERE idProduto = :idProduto AND idCarrinho = :idCarrinho");
        $deleteCarrinho->bindValue(':idProduto', $itemcarrinho->getIdProduto());
        $deleteCarrinho->bindValue(':idCarrinho', $itemcarrinho->getIdCarrinho());
        $deleteCarrinho->execute();
        if ($deleteCarrinho) {
            echo "<script> alert('Item excluido com sucesso.');
            window.location.href = 'Carrinho.php';
            </script>";
        } else {
            echo "Erro " . $deleteCarrinho . "<br>" . $this->conexao->errorInfo();
        }
    }
}
