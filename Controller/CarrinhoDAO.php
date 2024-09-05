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

    public function adicionaCarrinho($idProduto)
    {
        $querryProduto = $this->conexao->prepare("SELECT valor FROM produto WHERE id = :id");
        $querryProduto->bindValue(':id', $idProduto);
        $querryProduto->execute();
        $valorProduto = $querryProduto->fetch();

        $produtoExiste = $this->conexao->prepare("SELECT idProduto FROM carrinho WHERE idProduto = :idProduto AND idUsuario = :idUsuario");
        $produtoExiste->bindValue(':idProduto', $idProduto);
        $produtoExiste->bindValue(":idUsuario", $_SESSION['id']);
        $produtoExiste->execute();
        $existe = $produtoExiste->fetch();

        if ($existe === false) {
            $criarCarrinho = $this->conexao->prepare("INSERT INTO carrinho (idUsuario, idProduto, vInicial, quantidade, situacao) 
            VALUES (:idUsuario, :idProduto, :vInicial, :quantidade, :situacao)");
            $criarCarrinho->bindValue(":idUsuario", $_SESSION['id']);
            $criarCarrinho->bindValue(":idProduto", $idProduto);
            $criarCarrinho->bindValue(":vInicial", (float) $valorProduto[0]);
            $criarCarrinho->bindValue(":quantidade", "1");
            $criarCarrinho->bindValue(":situacao", "Ativo");
            $criarCarrinho->execute();
            if ($criarCarrinho) {
                echo "<script> alert('Adicionado ao carrinho com sucesso.');</script>";
            } else {
                echo "Erro " . $criarCarrinho . "<br>" . $this->conexao->errorInfo();
            }
        } else {
            $updateCarrinho = $this->conexao->prepare("UPDATE carrinho SET quantidade=quantidade+1 WHERE idProduto = :idProduto AND idUsuario = :idUsuario");
            $updateCarrinho->bindValue(':idProduto', $idProduto);
            $updateCarrinho->bindValue(":idUsuario", $_SESSION['id']);
            $updateCarrinho->execute();
            if ($updateCarrinho) {
                echo "<script> alert('Adicionado ao carrinho com sucesso.');</script>";
            } else {
                echo "Erro " . $updateCarrinho . "<br>" . $this->conexao->errorInfo();
            }
        }

        /*Adiciona ao Carrinho
        > Criar carrinho com id do usuário caso não exista (statusAtivo=0)
        > Caso exista adicionar produto ao mesmo id do carrinho (statusAtivo>=1)

        Remover do Carrinho
        > Se remover um item mas existir outros só remove o item (statusAtivo>=1)
        > Se remover item e carrinho ficar vazio (statusAtivo=0)

        Compra finalizada
        > Todos os itens do id do usuário se tornam inativos
        > Trigger de atualização de estoque*/
    }

    public function consultaCarrinho()
    {
        $pstmt = $this->conexao->prepare("SELECT * FROM carrinho WHERE idUsuario = '" . $_SESSION['id'] . "'");
        $pstmt->execute();
        $lista = $pstmt->fetchAll(PDO::FETCH_CLASS, Carrinho::class);
        return $lista;
    }

    public function editarCarrinho($idProduto, $quantidade)
    {
        $updateCarrinho = $this->conexao->prepare("UPDATE carrinho SET quantidade=:quantidade WHERE idProduto = :idProduto AND idUsuario = :idUsuario");
        $updateCarrinho->bindValue(':quantidade', $quantidade);
        $updateCarrinho->bindValue(':idProduto', $idProduto);
        $updateCarrinho->bindValue(":idUsuario", $_SESSION['id']);
        $updateCarrinho->execute();
        if ($updateCarrinho) {
            echo "<script> alert('Quantidade modificada.');
            window.location.href = 'Carrinho.php';
            </script>";
        } else {
            echo "Erro " . $updateCarrinho . "<br>" . $this->conexao->errorInfo();
        }
    }

    public function excluirCarrinho($idProduto)
    {
        $deleteCarrinho = $this->conexao->prepare("DELETE FROM carrinho WHERE idProduto = :idProduto");
        $deleteCarrinho->bindValue(':idProduto', $idProduto);
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
