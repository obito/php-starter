-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  lun. 28 mars 2022 à 18:31
-- Version du serveur :  5.7.26
-- Version de PHP :  7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `projetweb1A1`
--

-- --------------------------------------------------------

--
-- Structure de la table `iw_user`
--

CREATE TABLE `iw_user` (
  `id` int(11) NOT NULL,
  `email` varchar(320) NOT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `pwd` varchar(255) NOT NULL,
  `country` char(2) NOT NULL,
  `birthday` date NOT NULL,
  `pseudo` varchar(60) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `date_inserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp DEFAULT now() ON UPDATE CURRENT_TIMESTAMP,
  `token` char(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `iw_user`
--

INSERT INTO `iw_user` (`id`, `email`, `firstname`, `lastname`, `pwd`, `country`, `birthday`, `pseudo`, `status`, `date_inserted`, `date_updated`, `token`) VALUES
(9, 'y.skrzypczyk@gmail.com', 'Yves', 'SKRZYPCZYK', '$2y$10$oHnAf2HYOm8/kceE2PWQouUNNLZOaGykpddqJGZSeqrOFb93TqBKm', 'fr', '1986-11-29', 'Prof', 0, '2022-03-28 16:17:52', '2022-03-28 16:17:56', 'c6c6191be3b8868ac6ce1706a97e6afc70b19769');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `iw_user`
--
ALTER TABLE `iw_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `iw_user`
--
ALTER TABLE `iw_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
