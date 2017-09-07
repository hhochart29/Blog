-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 06 Septembre 2017 à 17:06
-- Version du serveur :  5.7.19-0ubuntu0.16.04.1
-- Version de PHP :  7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog_herve`
--

-- --------------------------------------------------------

--
-- Structure de la table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `titre` text NOT NULL,
  `auteur` text NOT NULL,
  `contenu` text NOT NULL,
  `image` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `blog`
--

INSERT INTO `blog` (`id`, `titre`, `auteur`, `contenu`, `image`, `date`) VALUES
(36, 'Dernier stage', 'HervÃ©', 'J\'ai effectuÃ© mon stage dans une agence web QuimpÃ©roise. L\'agence web propose des sites vitrines et site e-commerce \r\npetite / moyenne envergure aux artisans et commerces locaux.\r\nElle travaille exclusivement sur Wordpress un des gÃ©nÃ©rateur un thÃ¨me qui propose un \'Builder\' de pages.\r\nLe stage a durÃ© 3 mois pendant lesquels j\'ai pu apprendre et faire adopter le SASS Ã  l\'entreprise afin de faciliter l\'intÃ©gration des maquettes.\r\nJe n\'ai malheureusement pas pu dÃ©velopper autant que je l\'aurai souhaiter en PHP.', './assets/images/uploads/Dernier-stage_36.jpg', '2017-09-05 20:04:32'),
(37, 'Flux HTML', 'HervÃ©', 'Le flux HTML correspond au \'sens de lecture\' d\'un navigateur, qui parcourt la page de haut en bas en placement les Ã©lÃ©ment les uns en dessous des autres (ou Ã  cÃ´tÃ© en fonction des rÃ¨gles appliquÃ©es aux Ã©lÃ©ments)s.\r\nIl est possible de faire sortir certains Ã©lÃ©ments du flux afin de les faire dÃ©roger Ã  cette rÃ¨gle de lecture (notamment par un positionnement absolue ou fixe)\r\nLe Flux HTML dÃ©termine donc la faÃ§on de disposer les Ã©lÃ©ments sur la page.', './assets/images/uploads/Flux-HTML_37.jpg', '2017-09-06 07:02:13'),
(38, 'Positionnement CSS', 'HervÃ©', 'Les 3 positionnements CSS permettent de dÃ©finir et placer des \'blocs\' dans le DOM.\r\nLe positionnement relative est le positionnement par dÃ©faut d\'un Ã©lÃ©ment, il se comporte comme un bloc solide, il ne peut Ãªtre\r\ntraversÃ© ou superposÃ© avec un autre.\r\n\r\nLe positionnement absolue permet de faire \'flotter\' un Ã©lÃ©ment par rapport Ã  son Ã©lÃ©ment parent (ou le premier Ã©lÃ©ment en position relative)\r\nLe positionnement absolue est donc dÃ©pendant d\'un bloc ayant un position relative. Il permet de placer lâ€™Ã©lÃ©ment sans tenir comptes\r\ndes autres Ã©lÃ©ments prÃ©sents au mÃªme niveau.\r\n\r\nLe dernier positionnement, le positionnement fixe, est un positionnement qui ne tient compte d\'aucun autre Ã©lÃ©ment et qui est relative\r\nÃ  la fenÃªtre de l\'utilisateur. il permet de faire \'sortir\' un Ã©lÃ©ment du document et de le placer prÃ©cisÃ©ment Ã  l\'endroit voulue.\r\n\r\nLe positionnement fixe est le moins utilisÃ© de tous, car il est utile uniquement sur certains Ã©lÃ©ments trÃ¨s prÃ©cis (une fenÃªtre pop-up ou une barre', './assets/images/uploads/Positionnement-CSS_38.jpg', '2017-09-05 20:06:05');

-- --------------------------------------------------------

--
-- Structure de la table `blog_tags`
--

CREATE TABLE `blog_tags` (
  `id` int(255) NOT NULL,
  `id_article` int(255) NOT NULL,
  `id_tag` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `blog_tags`
--

INSERT INTO `blog_tags` (`id`, `id_article`, `id_tag`) VALUES
(54, 36, 1),
(55, 36, 3),
(56, 36, 4),
(57, 38, 1),
(58, 38, 4),
(59, 37, 1),
(60, 37, 4);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`id`, `id_article`, `title`, `content`, `date`) VALUES
(1, 36, 'Titre du premier commentaire de l\'article', 'Ceci est un premier commentaire', '2017-09-06 07:28:46'),
(2, 37, 'Titre du deuxieme commentaire en bdd', 'testestestestset', '2017-09-06 08:02:43'),
(3, 38, 'Super article', 'quoique un peu long', '2017-09-06 10:05:55'),
(4, 38, 'Super article', 'quoique un peu long', '2017-09-06 10:06:11'),
(7, 37, 'aeaze', 'azeaze', '2017-09-06 12:43:50');

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
(1, 'Web'),
(2, 'Mobile'),
(3, 'Developpement'),
(4, 'Integration'),
(5, 'Logiciels');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(16) NOT NULL,
  `password` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `name`, `password`) VALUES
(1, 'admin', 'admin');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `blog_tags`
--
ALTER TABLE `blog_tags`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT pour la table `blog_tags`
--
ALTER TABLE `blog_tags`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
