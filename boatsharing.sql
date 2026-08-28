-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Ago 29, 2026 alle 00:56
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `boatsharing`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `boats`
--

CREATE TABLE `boats` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `start_cap` varchar(5) NOT NULL,
  `start_city` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `img` varchar(64) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `boats`
--

INSERT INTO `boats` (`id`, `name`, `start_cap`, `start_city`, `destination`, `img`, `userid`) VALUES
(1, 'Barca a motore', '90121', 'Palermo', 'Palermo', 'template1.jpg', 1),
(2, 'Barca a vela', '80020', 'Napoli', 'Grecia', 'template2.jpg', 1),
(3, 'Mini Yatch', '16100', 'Genova', 'Livorno', 'template3.jpg', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `boatid` int(11) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `chatid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `content` varchar(100) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `chat_participants`
--

CREATE TABLE `chat_participants` (
  `id` int(11) NOT NULL,
  `chatid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `color` varchar(6) NOT NULL DEFAULT '000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `user`, `password`, `color`) VALUES
(1, 'admin', '$2y$10$u9UCV2Y4uHbG3MJWJ/C1devcoMk3cFCQGjHNWbDkOvuW8W4HdFJAa', '1f80ff');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `boats`
--
ALTER TABLE `boats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cst_userid_key` (`userid`);

--
-- Indici per le tabelle `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `boatid` (`boatid`);

--
-- Indici per le tabelle `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chatid` (`chatid`,`userid`),
  ADD KEY `user_id_ibkf_2` (`userid`);

--
-- Indici per le tabelle `chat_participants`
--
ALTER TABLE `chat_participants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid_link` (`userid`),
  ADD KEY `chatid` (`chatid`,`userid`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user` (`user`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `boats`
--
ALTER TABLE `boats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT per la tabella `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT per la tabella `chat_participants`
--
ALTER TABLE `chat_participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `boats`
--
ALTER TABLE `boats`
  ADD CONSTRAINT `cst_userid_key` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`boatid`) REFERENCES `boats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`chatid`) REFERENCES `chats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id_ibkf_2` FOREIGN KEY (`userid`) REFERENCES `chat_participants` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `chat_participants`
--
ALTER TABLE `chat_participants`
  ADD CONSTRAINT `chatid_link` FOREIGN KEY (`chatid`) REFERENCES `chats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userid_link` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
