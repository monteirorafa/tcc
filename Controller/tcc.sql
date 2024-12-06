-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06-Set-2024 às 00:32
-- Versão do servidor: 10.4.8-MariaDB
-- versão do PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `tcc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinho`
--

CREATE TABLE `carrinho` (
  `id` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `situacao` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cartao`
--

CREATE TABLE `cartao` (
  `id` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `vencimento` date NOT NULL,
  `cvv` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `itemcarrinho`
--

CREATE TABLE `itemcarrinho` (
  `id` int(11) NOT NULL,
  `idCarrinho` int(11) NOT NULL,
  `idProduto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `live`
--

CREATE TABLE `live` (
  `id` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idVideo` varchar(150) DEFAULT NULL,
  `plataforma` varchar(150) DEFAULT NULL,
  `live` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `idCarrinho` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `criado` datetime NOT NULL,
  `total` double(10,2) NOT NULL,
  `pagamento` varchar(150) NOT NULL,
  `entrega` varchar(150) NOT NULL,
  `situacao` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `categoria` varchar(150) NOT NULL,
  `valor` double(10,2) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `descricao` varchar(150) NOT NULL,
  `imagem` varchar(150) NOT NULL,
  `criado` datetime NOT NULL,
  `atualizado` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `cpf` varchar(150) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `cidade` varchar(150) NOT NULL,
  `endereco` varchar(150) NOT NULL,
  `numero` varchar(150) NOT NULL,
  `estado` varchar(150) NOT NULL,
  `cep` varchar(150) NOT NULL,
  `telefone` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `adm` tinyint(1) NOT NULL,
  `sessaoID` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `cpf`, `nome`, `email`, `cidade`, `endereco`, `numero`, `estado`, `cep`, `telefone`, `senha`, `adm`, `sessaoID`) VALUES
(1, '01376520036', 'Rafael Monteiro', '6.monteiro@gmail.com', 'Mata', 'Rua do Comércio', 405, 'RS', '97410000', '55999255135', '$2y$10$.9is8tGY1CPicfCcVcATU.d.lO2DZMga/sXLBOc/V.zTdJ2tk1b6m', 1, '');

INSERT INTO `produto` (`id`, `nome`, `categoria`, `valor`, `quantidade`, `descricao`, `imagem`, `criado`, `atualizado`) VALUES
(1, 'Bota Anatomic Gel', 'Calçados', '324.90', '10', 'Projetada para oferecer conforto e flexibilidade em cada passo. Com a tecnologia exclusiva 360°.', 'img/c1.png', '2024-12-04 15:33:30', ''),
(2, 'Social Marluvas', 'Calçados', '169.90', '10', 'Sapato ocupacional confeccionado em couro.  Biqueira True Line.  Colarinho soft acolchoado.  Fechamento em cadarço.', 'img/c2.png', '2024-12-04 15:33:30', ''),
(3, 'Knu Skool Black', 'Calçados', '549.90', '10', 'Relançamento do tênis de cano baixo dos anos 90. Cabedal de camurça resistente com lingueta e colarinho acolchoados.', 'img/c3.png', '2024-12-04 15:33:30', ''),
(4, 'Olympikus Venum', 'Calçados', '149.90', '10', 'O seu solado possui dupla camada da Tecnologia Evasense, que proporciona conforto e amortecimento.', 'img/c4.png', '2024-12-04 15:33:30', ''),
(5, 'Globo Plasma', 'Decoração', '124.45', '10', 'Luminária de Mesa funciona somente com fio, tomada 110v. Botão Liga/Desliga com função de música.', 'img/d1.png', '2024-12-04 15:33:30', ''),
(6, 'Mesa De Canto', 'Decoração', '78.15', '10', 'Kit 2 Mesinha Lateral Redonda, Cor Branca. 29 cm de diâmetro e pés com altura de 40 cm.', 'img/d2.png', '2024-12-04 15:33:30', ''),
(7, 'Luminária Pixar', 'Decoração', '59.99', '10', 'Bivolt 110/220v Base Flexivel. Seu design clean e elegante faz com que ela se destaque em qualquer ambiente.', 'img/d3.png', '2024-12-04 15:33:30', ''),
(8, 'Tripé Ibiza', 'Decoração', '279.50', '10', 'Ilumine seu espaço com estilo! A escolha perfeita para adicionar elegância, conforto e funcionalidade à sua casa.', 'img/d4.png', '2024-12-04 15:33:30', ''),
(9, 'RisoPhy Mouse', 'Eletrônicos', '340.31', '10', 'Mouse gamer bluetooth, preto e azul. Com RGB configurável. Inclui código para software de configuração.', 'img/e1.png', '2024-12-04 15:33:30', ''),
(10, 'PlayStation®5 Slim', 'Eletrônicos', '3352.55', '10', 'Edição Digital com SSD de 1TB, modelo CFI-2000. BiVolt, cor branca, acompanha 1 controle.', 'img/e2.png', '2024-12-04 15:33:30', ''),
(11, 'SSD M2 1TB Kingston', 'Eletrônicos', '409.89', '10', 'SSD encaixe M2 de 1TB marca Kingston Nvme2 Pcie 4.0 3500 Mb/s Cor Preto SNV2 1000G.', 'img/e3.png', '2024-12-04 15:33:30', ''),
(12, 'Galaxy Buds 2', 'Eletrônicos', '699.00', '10', 'Fones de ouvido Samsung Galaxy Buds 2, sem fi, R177 Onyx Black. Bateria com duração de até 30 horas, acompanha cabo.', 'img/e4.png', '2024-12-04 15:33:30', ''),
(13, 'Greenk QR Code', 'Roupas', '119.90', '10', 'Camiseta confortável e estilosa de algodão. Ideal para uso diário, combinando facilmente com qualquer look casual.', 'img/r1.png', '2024-12-04 15:33:30', ''),
(14, 'Mini Jeans Jogger', 'Roupas', '341.05', '10', 'Feita de denim de alta qualidade. Possui elástico na cintura e nos tornozelos, proporcionando um visual moderno.', 'img/r2.png', '2024-12-04 15:33:30', ''),
(15, 'Boné Liso', 'Roupas', '29.50', '10', 'Um boné preto, feito de tecido resistente com ajuste traseiro. Versátil, elegante e ideal para qualquer ocasião casual.', 'img/r3.png', '2024-12-04 15:33:30', ''),
(16, 'Casaco de Couro', 'Roupas', '147.59', '10', 'Masculina, cor Preta em couro ecológico. Estilo motoqueiro. Jaqueta de inverno, com bolsos abertos.', 'img/r4.png', '2024-12-04 15:33:30', '');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKidUsuario` (`idUsuario`);

--
-- Índices para tabela `cartao`
--
ALTER TABLE `cartao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKidUsuario` (`idUsuario`);

--
-- Índices para tabela `itemcarrinho`
--
ALTER TABLE `itemcarrinho`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKidCarrinho` (`idCarrinho`),
  ADD KEY `FKidProduto` (`idProduto`);

--
-- Índices para tabela `itemcarrinho`
--
ALTER TABLE `live`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pedido`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKidCarrinho` (`idCarrinho`),
  ADD KEY `FKidUsuario` (`idUsuario`);

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carrinho`
--
ALTER TABLE `carrinho`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cartao`
--
ALTER TABLE `cartao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `itemcarrinho`
--
ALTER TABLE `itemcarrinho`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `live`
--
ALTER TABLE `live`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pedido`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD CONSTRAINT `carrinhoFKidUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`);

--
-- Limitadores para a tabela `carrinho`
--
ALTER TABLE `cartao`
  ADD CONSTRAINT `cartaoFKidUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`);

--
-- Limitadores para a tabela `itemcarrinho`
--
ALTER TABLE `itemcarrinho`
  ADD CONSTRAINT `itemFKidCarrinho` FOREIGN KEY (`idCarrinho`) REFERENCES `carrinho` (`id`),
  ADD CONSTRAINT `itemFKidProduto` FOREIGN KEY (`idProduto`) REFERENCES `produto` (`id`);

--
-- Limitadores para a tabela `live`
--
ALTER TABLE `live`
  ADD CONSTRAINT `liveFKidUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`);

--
-- Limitadores para a tabela `pedido`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidoFKidCarrinho` FOREIGN KEY (`idCarrinho`) REFERENCES `carrinho` (`id`),
  ADD CONSTRAINT `pedidoFKidUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
