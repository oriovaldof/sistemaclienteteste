-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 23/11/2016 às 16:54
-- Versão do servidor: 5.7.16-0ubuntu0.16.04.1
-- Versão do PHP: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistemaCliente`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `adress`
--

CREATE TABLE `adress` (
  `adressCod` int(11) NOT NULL,
  `clientCod` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `addressNumber` varchar(255) DEFAULT NULL,
  `addressZipCode` varchar(255) DEFAULT NULL,
  `addressComplement` varchar(255) DEFAULT NULL,
  `addressNeighborhood` varchar(255) DEFAULT NULL,
  `addressCity` varchar(255) DEFAULT NULL,
  `addressState` varchar(255) DEFAULT NULL,
  `addressCountries` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `adress`
--

INSERT INTO `adress` (`adressCod`, `clientCod`, `address`, `addressNumber`, `addressZipCode`, `addressComplement`, `addressNeighborhood`, `addressCity`, `addressState`, `addressCountries`) VALUES
(10, 14, 'rua 01', '1999', '78.000-000', '', 'Brasil', 'Brasileira', 'Mato Grosso', 'Brasil');

-- --------------------------------------------------------

--
-- Estrutura para tabela `client`
--

CREATE TABLE `client` (
  `clientCod` int(11) NOT NULL,
  `clientNomeRazaoSocial` varchar(255) NOT NULL,
  `clientNomeFantasia` varchar(255) DEFAULT NULL,
  `clientTipo` enum('PJ','PF') DEFAULT NULL,
  `clientCpfCnpj` varchar(18) DEFAULT NULL,
  `clientInscricaoEstadual` varchar(45) DEFAULT NULL,
  `clientDateInsert` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `client`
--

INSERT INTO `client` (`clientCod`, `clientNomeRazaoSocial`, `clientNomeFantasia`, `clientTipo`, `clientCpfCnpj`, `clientInscricaoEstadual`, `clientDateInsert`) VALUES
(14, 'Fulano de Tal', '', 'PF', '169.137.546-20', '', '2016-11-23 16:50:37');

-- --------------------------------------------------------

--
-- Estrutura para tabela `contact`
--

CREATE TABLE `contact` (
  `contactCod` int(11) NOT NULL,
  `clientCod` int(11) NOT NULL,
  `contactType` enum('TL','EM') NOT NULL DEFAULT 'TL' COMMENT 'TL = Telefone, EM = E-mail',
  `contactValue` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `contact`
--

INSERT INTO `contact` (`contactCod`, `clientCod`, `contactType`, `contactValue`) VALUES
(12, 14, 'TL', '(55) 55555-5555'),
(13, 14, 'EM', 'dfsdf@gmail.com');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `adress`
--
ALTER TABLE `adress`
  ADD PRIMARY KEY (`adressCod`);

--
-- Índices de tabela `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`clientCod`);

--
-- Índices de tabela `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contactCod`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `adress`
--
ALTER TABLE `adress`
  MODIFY `adressCod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de tabela `client`
--
ALTER TABLE `client`
  MODIFY `clientCod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de tabela `contact`
--
ALTER TABLE `contact`
  MODIFY `contactCod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
