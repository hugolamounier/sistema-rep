-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 25-Jul-2020 às 19:22
-- Versão do servidor: 8.0.17
-- versão do PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `republica`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `group_`
--

CREATE TABLE `group_` (
  `groupId` int(16) NOT NULL,
  `groupName` varchar(40) NOT NULL,
  `groupOwner` varchar(200) NOT NULL,
  `groupType` int(1) NOT NULL,
  `groupAddress` varchar(255) NOT NULL,
  `groupCEP` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `group_member`
--

CREATE TABLE `group_member` (
  `groupId` int(16) NOT NULL,
  `userEmail` varchar(200) NOT NULL,
  `memberAuthority` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `type` int(2) NOT NULL,
  `agent` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `log`
--

INSERT INTO `log` (`id`, `type`, `agent`, `module`, `message`, `date`, `file`) VALUES
(2, 1, 'SYSTEM', 'addUser()', 'Column \'userName\' cannot be null\nErro ao inserir informações no banco de dados.', '2020-07-15 21:46:07', 'D:\\AppServ\\www\\gestao_republica_2\\class\\User.class.php');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `userEmail` varchar(200) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `userProfilePicture` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '/images/profile/no_image.jpg',
  `userStatus` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`userEmail`, `userPassword`, `userName`, `userProfilePicture`, `userStatus`) VALUES
('beatrizcristinabca@gmail.com', '$2y$10$ozvjE5afeGrh5KpFBWLkXOKwgCLjXH3JkocgJqRyxJWHY0um3u5sO', 'Beatriz Cristina Alcântara', '/images/profile/no_image.jpg', 0),
('hugolamo@gmail.com', '$2y$10$9f73GiRkfZn0PvKTDxGJ1OJhtSPHpMBDAm52lTDScJEyR8W7H3mmm', 'Hugo Lamounier', '/images/profile/no_image.jpg', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `group_`
--
ALTER TABLE `group_`
  ADD PRIMARY KEY (`groupId`),
  ADD KEY `groupOwner` (`groupOwner`);

--
-- Índices para tabela `group_member`
--
ALTER TABLE `group_member`
  ADD KEY `userEmail` (`userEmail`),
  ADD KEY `groupId` (`groupId`) USING BTREE;

--
-- Índices para tabela `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userEmail`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `group_`
--
ALTER TABLE `group_`
  MODIFY `groupId` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `group_`
--
ALTER TABLE `group_`
  ADD CONSTRAINT `group__ibfk_1` FOREIGN KEY (`groupOwner`) REFERENCES `user` (`userEmail`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Limitadores para a tabela `group_member`
--
ALTER TABLE `group_member`
  ADD CONSTRAINT `group_member_ibfk_1` FOREIGN KEY (`groupId`) REFERENCES `group_` (`groupId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `group_member_ibfk_2` FOREIGN KEY (`userEmail`) REFERENCES `user` (`userEmail`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
