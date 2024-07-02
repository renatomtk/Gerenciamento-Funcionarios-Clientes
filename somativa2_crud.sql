-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/06/2024 às 04:35
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `somativa2_crud`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(140) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `address` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clients`
--

INSERT INTO `clients` (`id`, `name`, `email`, `phone`, `address`, `created_at`) VALUES
(1, 'João Silva', 'joao@example.com', '42123456789', 'Rua A, 123', '2024-06-21 14:52:32'),
(2, 'Maria Souza', 'maria@example.com', '42987654321', 'Av. B, 456', '2024-06-21 14:52:32'),
(3, 'Pedro Santos', 'pedro@example.com', '42111222333', 'Pç. C, 789', '2024-06-21 14:52:32'),
(4, 'Ana Oliveira', 'ana@example.com', '42444555666', 'Al. D, 987', '2024-06-21 14:52:32'),
(5, 'Carlos Pereira', 'carlos@example.com', '42999888777', 'Travessa E, 654', '2024-06-21 14:52:32'),
(6, 'Mariana Costa', 'mariana@example.com', '42333222111', 'Rodovia F, 321', '2024-06-21 14:52:32');

-- --------------------------------------------------------

--
-- Estrutura para tabela `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(140) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `address` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `client_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `phone`, `address`, `created_at`, `client_id`) VALUES
(1, 'Fernanda Costa', 'fernanda.costa@email.com', '42987651234', 'Rua G, 567', '2024-06-25 01:57:24', 1),
(2, 'Rafael Oliveira', 'rafael.oliveira@email.com', '42976543210', 'Av. H, 890', '2024-06-25 01:57:24', 2),
(3, 'Juliana Santos', 'juliana.santos@email.com', '42988887777', 'Rua I, 1234', '2024-06-25 01:57:24', 3),
(4, 'Pedro Almeida', 'pedro.almeida@email.com', '42966665555', 'Av. J, 5678', '2024-06-25 01:57:24', 4),
(5, 'Larissa Lima', 'larissa.lima@email.com', '42954321098', 'Rua K, 987', '2024-06-25 01:57:24', 5),
(6, 'Gustavo Silva', 'gustavo.silva@email.com', '42943210987', 'Av. L, 654', '2024-06-25 01:57:24', 6);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `client_id` (`client_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
