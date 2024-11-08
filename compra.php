<?php
if (!isset($_SESSION['id'])) {
    session_start();
}
include_once __DIR__ . '/menu.php';
include_once __DIR__ . '/Conexao/Conexao.php';
include_once __DIR__ . '../Controller/Produto.php';
include_once __DIR__ . '../Controller/ProdutoDAO.php';
include_once __DIR__ . '../Controller/Carrinho.php';
include_once __DIR__ . '../Controller/CarrinhoDAO.php';
include_once __DIR__ . '../Controller/ItemCarrinho.php';
include_once __DIR__ . '../Controller/ItemCarrinhoDAO.php';
include_once __DIR__ . '../Controller/Usuario.php';
include_once __DIR__ . '../Controller/UsuarioDAO.php';
include_once __DIR__ . '../Controller/Pedido.php';
include_once __DIR__ . '../Controller/PedidoDAO.php';
include_once __DIR__ . '../Controller/Cartao.php';
include_once __DIR__ . '../Controller/CartaoDAO.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra</title>
    <link rel="stylesheet" href="css/minhascompras.css">
</head>

<main>

    <div class="container">
        <form action="compra.php" method="post">

            <div class='titulo'>
                <h1>Confira seus dados</h1>
            </div>

            <?php
            $arrayPedidos = array();
            $vTotal = 0;
            $usuarioDAO = new UsuarioDAO();
            $objetoUsuario = $usuarioDAO->consultaEndereco();
            foreach ($objetoUsuario as $usuario) {
                $usuario = new Usuario($usuario);
            ?>

                <div class="card-content row">
                    <div class="radio col s12 m4 l4">
                        <p>Selecione uma forma de entrega:</p>
                        <label>
                            <input type="radio" name="entrega" value="Retirada" required>
                            <span>Retirar na Loja</span>
                        </label>
                        <label>
                            <input type="radio" name="entrega" value="Entrega" class="entrega" data-id="1">
                            <span>Correios</span>
                        </label>
                    </div>

                    <div class="radio col s12 m4 l4">
                        <p>Selecione a forma de pagamento:</p>
                        <label>
                            <input type="radio" name="pagamento" value="Pix" required>
                            <span>Pix</span>
                        </label>
                        <label>
                            <input type="radio" name="pagamento" value="Cartão" class="pagamento" data-id="2">
                            <span>Cartão</span>
                        </label>
                        <label>
                            <input type="radio" name="pagamento" value="Boleto">
                            <span>Boleto</span>
                        </label>
                    </div>

                </div>

                <div class="card-content row">
                    <div class="radio col s12 m4 l4">
                        <div class="ent form-1">
                            <p>Confira seu endereço de entrega:</p>
                            <p class="product-price"> Endereço:
                                <?php echo $usuario->getEndereco() . ", " . $usuario->getNumero(); ?> </p>
                            <p class="product-price"> Cidade:
                                <?php echo $usuario->getCidade() . "/ " . $usuario->getEstado(); ?></p>
                            <p class="product-price"> CEP: <?php echo $usuario->getCep(); ?></p>
                            <p class="product-price"> Contato: <?php echo $usuario->getTelefone(); ?></p>
                            <div class="editar"><a href="perfil.php">Mudar dados de entrega</a></div>
                        </div>
                    </div>

                    <div class="radio col s12 m4 l4 offset-6">
                        <div class="ent form-2">

                            <?php
                            $cartaoDAO = new CartaoDAO();
                            $objetoCartao = $cartaoDAO->consultaCartao();
                            $cartaoVazio = empty($objetoCartao) ? true : false;
                            ?>

                            <script>
                                var cartaoVazio = <?php echo $cartaoVazio; ?>;
                            </script>
                            <script src="js/cartao.js"></script>

                            <?php
                            if (!empty($objetoCartao)) {
                                foreach ($objetoCartao as $cartao) {
                                    $cartao = new Cartao($cartao); ?>

                                    <p>Confira seus dados de pagamento:</p>
                                    <p class="product-price"> Número do Cartão:
                                        <?php echo $cartao->getNumero(); ?> </p>
                                    <p class="product-price"> Vencimento:
                                        <?php echo $cartao->getVencimento(); ?></p>
                                    <p class="product-price"> CVV: *** </p>
                                    <div class="editar"><a href="perfil.php">Mudar dados de pagamento</a></div>

                                <?php   }
                            } else { ?>

                                <p class="signin">Por favor cadastre um cartão.<a href="cadastro.php"> Clique aqui.</a></p>

                        <?php }
                            $produtoDAO = new ProdutoDAO();
                            $carrinhoDAO = new CarrinhoDAO();
                            $objetoCarrinho = $produtoDAO->produtosCarrinho();
                            $carrinhoID = $carrinhoDAO->consultaCarrinhoId();

                            $itemDAO = new ItemCarrinhoDAO();
                            $objetoItem = $itemDAO->consultaItem($carrinhoID);
                            $itensPorProduto = [];

                            foreach ($objetoItem as $itemData) {
                                $item = new ItemCarrinho($itemData);
                                $produtoId = $item->getIdProduto();
                                if (!isset($itensPorProduto[$produtoId])) {
                                    $itensPorProduto[$produtoId] = [];
                                }
                                $itensPorProduto[$produtoId][] = $item;
                            }

                            foreach ($objetoCarrinho as $produtoData) {
                                $produto = new Produto($produtoData);
                                $produtoId = $produto->getId();
                                if (isset($itensPorProduto[$produtoId])) {
                                    foreach ($itensPorProduto[$produtoId] as $item) {
                                        $pTotal = $produto->getValor() * $item->getQuantidade();
                                        $vTotal += $pTotal;
                                    }
                                }
                            }
                        }
                        ?>

                        </div>
                    </div>
                </div>

                <input type="hidden" value="<?php echo $item->getIdCarrinho() ?>" name="idCarrinho">
                <input type="hidden" value="<?php echo $_SESSION['id'] ?>" name="idUsuario">
                <input type="hidden" value="<?php echo $vTotal ?>" name="total">
                <input type="hidden" value="Processando" name="situacao">

                <div class="fim">
                    <div class="price">Total R$ <?php echo $vTotal ?> </div>

                    <button class="button" onclick="window.location.href='index.php';" name="finalizar" value="finalizar>"
                        disabled>
                        <span class="button-content">Finalizar Compra</span>
                    </button>
                </div>

                <?php if (isset($_POST["finalizar"])) {
                    $pedidoDAO = new PedidoDAO();
                    $pedido = new Pedido($_POST);
                    $pedidoDAO->adicionaPedido($pedido, $_SESSION['id']);
                }
                ?>
        </form>

    </div>

</main>

</html>