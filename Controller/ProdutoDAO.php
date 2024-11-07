<?php

include_once __DIR__ . '/../Conexao/Conexao.php';
include_once __DIR__ . '/../Controller/Produto.php';

class ProdutoDAO
{

    private $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::getConexao();
    }

    public function cadastro(Produto $produto)
    {
        $pstmt = $this->conexao->prepare("INSERT INTO produto (nome, categoria, valor, quantidade, descricao, imagem, criado) 
                 VALUES (:nome, :categoria, :valor, :quantidade, :descricao, :imagem, CURRENT_TIMESTAMP)");
        $pstmt->bindValue(":nome", $produto->getNome());
        $pstmt->bindValue(":categoria", $produto->getCategoria());
        $pstmt->bindValue(":valor", $produto->getValor());
        $pstmt->bindValue(":quantidade", $produto->getQuantidade());
        $pstmt->bindValue(":descricao", $produto->getDescricao());
        $pstmt->bindValue(":imagem", $produto->getImagem());
        $pstmt->execute();
        if ($pstmt) {
            echo "<script> alert('Cadastrado com sucesso.');</script>";
        } else {
            echo "Erro " . $pstmt . "<br>" . $this->conexao->errorInfo();
        }
    }

    public function consultaProdutos()
    {
        $pstmt = $this->conexao->prepare("SELECT * FROM produto WHERE quantidade > 0");
        $pstmt->execute();
        $lista = $pstmt->fetchAll(PDO::FETCH_CLASS, Produto::class);
        return $lista;
    }

    public function selectProduto($idProduto)
    {
        $pstmt = $this->conexao->prepare("SELECT * FROM produto WHERE id = :id");
        $pstmt->bindValue(':id', $idProduto);
        $pstmt->execute();
        $produto = $pstmt->fetchAll(PDO::FETCH_CLASS, Produto::class);
        return $produto;
    }

    public function produtosCarrinho()
    {
        $consultaItens = $this->conexao->prepare("SELECT p.* FROM usuario u, carrinho c, itemcarrinho i, produto p WHERE u.id = c.idUsuario AND c.id = i.idCarrinho AND p.id = i.idProduto AND u.id = :id AND c.situacao = :situacao");
        $consultaItens->bindValue(":id", $_SESSION['id']);
        $consultaItens->bindValue(":situacao", "ativo");
        $consultaItens->execute();
        $produto = $consultaItens->fetchAll(PDO::FETCH_CLASS, Produto::class);
        return $produto;
    }

    public function produtosCarrinhoInativo()
    {
        $consultaItens = $this->conexao->prepare("SELECT p.* FROM usuario u, carrinho c, itemcarrinho i, produto p WHERE u.id = c.idUsuario AND c.id = i.idCarrinho AND p.id = i.idProduto AND u.id = :id AND c.situacao = :situacao");
        $consultaItens->bindValue(":id", $_SESSION['id']);
        $consultaItens->bindValue(":situacao", "inativo");
        $consultaItens->execute();
        $produto = $consultaItens->fetchAll(PDO::FETCH_CLASS, Produto::class);
        return $produto;
    }

    public function todosInativo()
    {
        $consultaItens = $this->conexao->prepare("SELECT p.* FROM usuario u, carrinho c, itemcarrinho i, produto p WHERE u.id = c.idUsuario AND c.id = i.idCarrinho AND p.id = i.idProduto AND c.situacao = :situacao");
        $consultaItens->bindValue(":situacao", "inativo");
        $consultaItens->execute();
        $produto = $consultaItens->fetchAll(PDO::FETCH_CLASS, Produto::class);
        return $produto;
    }

    public function alteraProduto(Produto $produto)
    {
        $pstmt = $this->conexao->prepare("UPDATE produto SET nome=:nome, categoria=:categoria, valor=:valor, quantidade=:quantidade, descricao=:descricao, imagem=:imagem, criado=:criado, atualizado=CURRENT_TIMESTAMP WHERE id=:id");
        $pstmt->bindValue(":nome", $produto->getNome());
        $pstmt->bindValue(":categoria", $produto->getCategoria());
        $pstmt->bindValue(":valor", $produto->getValor());
        $pstmt->bindValue(":quantidade", $produto->getQuantidade());
        $pstmt->bindValue(":descricao", $produto->getDescricao());
        $pstmt->bindValue(":imagem", $produto->getImagem());
        $pstmt->bindValue(":criado", $produto->getCriado());
        $pstmt->bindValue(":id", $produto->getId());
        $pstmt->execute();
        if ($pstmt) {
            echo "<script> alert('Alterado com sucesso.');</script>";
            header('Location: produtos.php');
        } else {
            echo "Erro " . $pstmt . "<br>" . $this->conexao->errorInfo();
        }
    }

    public function randomIndex()
    {
        $pstmt = $this->conexao->prepare("SELECT * FROM produto ORDER BY RAND() LIMIT 8");
        $pstmt->execute();
        $produto = $pstmt->fetchAll(PDO::FETCH_CLASS, Produto::class);
        return $produto;
    }

    public function buscaProdutos($termo)
    {
        $pstmt = $this->conexao->prepare("SELECT * FROM produto WHERE nome LIKE :termo OR descricao LIKE :termo ORDER BY nome, descricao");
        $termo = "%" . $termo . "%";
        $pstmt->bindParam(':termo', $termo, PDO::PARAM_STR);
        $pstmt->execute();
        $produto = $pstmt->fetchAll(PDO::FETCH_CLASS, Produto::class);
        return $produto;
    }

    public function filtraCategoria($categoria)
    {
        $pstmt = $this->conexao->prepare("SELECT * FROM produto WHERE categoria = :categoria");
        $pstmt->bindValue(":categoria", $categoria);
        $pstmt->execute();
        $produto = $pstmt->fetchAll(PDO::FETCH_CLASS, Produto::class);
        return $produto;
    }
}
