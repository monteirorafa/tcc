<?php
if (!isset($_SESSION['id'])) {
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
}