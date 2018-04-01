-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 15, 2017 alle 11:31
-- Versione del server: 10.1.22-MariaDB
-- Versione PHP: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `progetto`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `bid_exceeded`
--

DROP TABLE IF EXISTS `bid_exceeded`;
CREATE TABLE `bid_exceeded` (
  `ID` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `item` int(11) NOT NULL,
  `bid` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(255) NOT NULL,
  `maxbid` float DEFAULT NULL,
  `currentbid` float NOT NULL DEFAULT '1',
  `user` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `item`
--

INSERT INTO `item` (`ID`, `name`, `description`, `picture`, `maxbid`, `currentbid`, `user`) VALUES
(1, 'Jedi Cat', 'The force is strong with this one.', 'ned.jpg', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `familyname` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`email`, `password`, `firstname`, `familyname`) VALUES
('a@p.it', '$2y$10$jMGretoyBbWD/A3nK8AbeuKiODW8pXlOO/lXgUCUXz0uUY/2m1vUa', 'A', 'A'),
('b@p.it', '$2y$10$Ptk1iK539nQV7BFnILg0V.eQlFUDzfmj6H1LVNEcx61wxBtHrk1/y', 'B', 'B'),
('c@p.it', '$2y$10$MGriFUJsh70gH/ezFpFNJuxZeypx07zJB01NqlNbuOO8B.qEzuI4e', 'C', 'C');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `bid_exceeded`
--
ALTER TABLE `bid_exceeded`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `bid_exceeded`
--
ALTER TABLE `bid_exceeded`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `item`
--
ALTER TABLE `item`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
