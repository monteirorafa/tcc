<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once __DIR__ . '/../Conexao/Conexao.php';
include_once __DIR__ . '/../Controller/ItemCarrinho.php';

class ItemCarrinhoDAO
{

    private $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::getConexao();
    }

    public function consultaItem($idCarrinho)
    {
        $consulta = $this->conexao->prepare("SELECT i.* FROM usuario u, carrinho c, itemcarrinho i, produto p WHERE u.id = c.idUsuario AND c.id = i.idCarrinho AND p.id = i.idProduto AND i.idCarrinho = :idCarrinho");
        $consulta->bindValue(":idCarrinho", (int) $idCarrinho);
        $consulta->execute();
        $item = $consulta->fetchAll(PDO::FETCH_CLASS, ItemCarrinho::class);
        return $item;
    }

    public function consultaInativo(array $idCarrinho)
    {
        $arrayIds = implode(',', array_fill(0, count($idCarrinho), '?'));
        $consulta = $this->conexao->prepare("SELECT i.* FROM usuario u, carrinho c, itemcarrinho i, produto p WHERE u.id = c.idUsuario AND c.id = i.idCarrinho AND p.id = i.idProduto AND i.idCarrinho IN ($arrayIds)");
        $consulta->execute(array_values($idCarrinho));
        $itens = $consulta->fetchAll(PDO::FETCH_CLASS, ItemCarrinho::class);
        return $itens;
    }
}
