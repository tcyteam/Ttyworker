--
-- Structure de la table `adn`
--

CREATE TABLE IF NOT EXISTS `adn` (
  `id` int(11) NOT NULL auto_increment,
  `uid` varchar(64) NOT NULL,
  `user` varchar(35) character set utf8 collate utf8_bin NOT NULL,
  `pass` varchar(40) NOT NULL,
  `hash_validation` varchar(64) NOT NULL,
  `gid` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `lostpass` varchar(40) NOT NULL,
  `date_naissance` date NOT NULL,
  `date_inscription` datetime NOT NULL,
  `ville` text NOT NULL,
  `pays` text NOT NULL,
  `code_postal` int(8) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `adn`
--

INSERT INTO `adn` (`id`, `uid`, `user`, `pass`, `hash_validation`, `gid`, `email`, `lostpass`, `date_naissance`, `date_inscription`, `ville`, `pays`, `code_postal`) VALUES
(1, '8', 'administrator', '5e5f282e750ce7c5a8da8c7656685c8b281fb4bb', '', '1', 'tcyteam@gmail.com', '', '1986-09-01', '2011-06-03 19:57:00', 'bruxelles', 'Belgique', 1090);


-- --------------------------------------------------------

--
-- Structure de la table `allright`
--

CREATE TABLE IF NOT EXISTS `allright` (
  `id` int(11) NOT NULL auto_increment,
  `allright` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_bin AUTO_INCREMENT=2 ;

--
-- Contenu de la table `allright`
--

INSERT INTO `allright` (`id`, `allright`) VALUES
(1, 119);


--
-- Structure de la table `commentaire`
--

CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `nom`, `email`, `comment`) VALUES
(1, 'test', 'tcyteam@gmail.com', 'tdftgdt'),
(2, 'bobo', 'tcyteam@gmail.com', 'un autre test');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(30) NOT NULL,
  `id_name` varchar(35) NOT NULL,
  `liens` int(60) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `contact`
--

INSERT INTO `contact` (`id`, `uid`, `id_name`, `liens`) VALUES
(1, 8, 'tcyteam', 65600),
(2, 65536, 'test', 8),
(3, 64, 'test2', 8);

-- --------------------------------------------------------

--
-- Structure de la table `droit`
--

CREATE TABLE IF NOT EXISTS `droit` (
  `id` int(11) NOT NULL auto_increment,
  `permission` varchar(120) NOT NULL,
  `signification` text NOT NULL,
  `module` text NOT NULL,
  `nom` text NOT NULL,
  `explication` varchar(70) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `permission` (`permission`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Contenu de la table `droit`
--

INSERT INTO `droit` (`id`, `permission`, `signification`, `module`, `nom`, `explication`) VALUES
(1, '100', 'connect', 'adn', 'Page de membre', 'Voir le menu de membre'),
(2, '101', 'disconnect', 'adn', 'Se deconnecter', 'Permet de se deconnecter  de la page de membre'),
(3, '102', 'viewmember', 'adn', 'Gestion de compte', 'Permet de modifier les informations relatives au compte'),
(4, '103', 'administration', 'adn', 'Administration', 'Administration des users et modules'),
(5, '104', 'index', 'messagerie', 'Boite de reception', 'Permet de recevoir des messages de ses contacts'),
(6, '105', 'addmessage', 'messagerie', 'Envoyer un message', 'Permet d''envoyer des messages a ces contacts'),
(7, '106', 'updatemember', 'adn', 'Mis a jour utilisateur', 'Permet de mettre a jour des informations utilisateur'),
(8, '107', 'addgroup', 'adn', 'Ajouter un groupe ', 'Ajoute un nouveau groupe de droits'),
(9, '108', 'updategroup', 'adn', 'Mis a jour du groupe', 'Ajoute ou supprime des droits au groupe'),
(10, '109', 'adddroit', 'adn', 'Ajouter une permission', 'Ajoute une nouvelle permission'),
(11, '110', 'viewgroup', 'adn', 'Voir la liste des groupes', 'Voir la liste des groupes'),
(12, '111', 'insertsend', 'adn', 'insertsend', 'Permet de rajouter un client'),
(13, '112', 'index', 'commande', 'commander', 'Permet de faire une commande'),
(14, '113', 'printer', 'commande', 'imprimer', 'Permet l impression de la commande'),
(15, '114', 'send', 'commande', 'Enregistre une commande', 'enregistre une nouvelle commande'),
(16, '115', 'test', 'adn', 'test', 'Page de devellopement'),
(17, '116', 'search', 'commande', 'Chercher une commande ', 'Permet de prÃ©charger une commande existante.'),
(18, '117', 'delivertome', 'commande', 'Se faire livrer un colis', 'permet de se livrer un colis'),
(19, '118', 'printerw', 'commande', 'Imprimer bordereau version 2', 'Permet de convertir en pdf les informations de la commande');

-- --------------------------------------------------------

--
-- Structure de la table `expediteur_exterieur`
--

CREATE TABLE IF NOT EXISTS `expediteur_exterieur` (
  `id` int(11) NOT NULL auto_increment,
  `id_client` int(11) NOT NULL,
  `societe_dest` varchar(50) collate latin1_german1_ci NOT NULL,
  `societe` varchar(40) character set utf8 collate utf8_bin NOT NULL,
  `rue` varchar(50) character set utf8 collate utf8_bin NOT NULL,
  `postal` int(7) NOT NULL,
  `ville` text character set utf8 collate utf8_bin NOT NULL,
  `pays` text character set utf8 collate utf8_bin NOT NULL,
  `tel` int(11) NOT NULL,
  `nom_exp` text character set utf8 collate utf8_bin NOT NULL,
  `prenom_exp` text character set utf8 collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `expediteur_exterieur`
--

INSERT INTO `expediteur_exterieur` (`id`, `id_client`, `societe_dest`, `societe`, `rue`, `postal`, `ville`, `pays`, `tel`, `nom_exp`, `prenom_exp`) VALUES
(1, 52, 'Another  BelgiÃ©', 'TantÃ©e bis', 'TantÃ©e bis', 1090, 0x54616e74c3a96520626973, 0x54616e74c3a96520626973, 494675249, 0x416e6f74686572202042656c6769c3a9, 0x416e6f74686572202042656c6769c3a9);

-- --------------------------------------------------------

--
-- Structure de la table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL auto_increment,
  `id_group` varchar(10) NOT NULL,
  `group_name` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id_name` (`id_group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `group`
--

INSERT INTO `group` (`id`, `id_group`, `group_name`) VALUES
(1, '1', 'Administrators'),
(2, '91', 'Users'),
(3, '4', 'HelpDesks'),
(4, '2', 'Devs'),
(5, '3', 'Hacks'),
(6, '5', 'Banneds'),
(7, '6', 'Testers'),
(8, '7', 'Disableds'),
(9, '10', 'TempAdministrators'),
(10, '11', 'TempsUsersAdminstrators');

-- --------------------------------------------------------

--
-- Structure de la table `group_permission`
--

CREATE TABLE IF NOT EXISTS `group_permission` (
  `id` int(11) NOT NULL auto_increment,
  `id_group` int(11) NOT NULL,
  `permission` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- Contenu de la table `group_permission`
--

INSERT INTO `group_permission` (`id`, `id_group`, `permission`) VALUES
(1, 1, 100),
(2, 1, 101),
(3, 1, 102),
(4, 1, 103),
(5, 1, 104),
(12, 1, 105),
(7, 1, 106),
(8, 1, 107),
(9, 1, 108),
(13, 1, 109),
(11, 1, 110),
(14, 1, 111),
(15, 3, 100),
(16, 3, 101),
(17, 91, 100),
(18, 91, 101),
(19, 3, 102),
(20, 3, 102),
(21, 3, 111),
(22, 3, 112),
(23, 3, 113),
(24, 3, 114),
(25, 91, 111),
(26, 91, 112),
(27, 91, 113),
(28, 1, 113),
(36, 91, 116),
(30, 91, 114),
(31, 1, 112),
(32, 1, 114),
(33, 1, 112),
(34, 91, 102),
(35, 1, 115),
(37, 91, 117),
(38, 91, 118);

-- --------------------------------------------------------

--
-- Structure de la table `messagerie`
--

CREATE TABLE IF NOT EXISTS `messagerie` (
  `id` int(11) NOT NULL auto_increment,
  `id_exp` varchar(15) NOT NULL,
  `id_dest` varchar(15) NOT NULL,
  `objet` text NOT NULL,
  `message` varchar(400) NOT NULL,
  `date` datetime NOT NULL,
  `lu` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `messagerie`
--

INSERT INTO `messagerie` (`id`, `id_exp`, `id_dest`, `objet`, `message`, `date`, `lu`) VALUES
(6, 'test', 'tcyteam', 'message en couleur', '<p>\r\n	<span style="color:#ffd700;">Cecic est un message en couleur.</span></p>\r\n', '2011-06-08 00:00:00', 0),
(7, 'test', 'tcyteam', 'nouveau tet', '<p>\r\n	Un autre test</p>\r\n', '2011-06-09 16:07:53', 0);

-- --------------------------------------------------------

--
-- Structure de la table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL auto_increment,
  `module_name` text NOT NULL,
  `module_version` varchar(15) NOT NULL,
  `module_auteur` text NOT NULL,
  `module_actif` int(1) NOT NULL,
  `commentaire` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `modules`
--

INSERT INTO `modules` (`id`, `module_name`, `module_version`, `module_auteur`, `module_actif`, `commentaire`) VALUES
(1, 'adn', '1.0', 'Martins Yannick', 1, 'Gestion des utilisateurs et groupes de permissions.');

-- --------------------------------------------------------

--
-- Structure de la table `parametres_vues`
--

CREATE TABLE IF NOT EXISTS `parametres_vues` (
  `id` int(11) NOT NULL auto_increment,
  `vue_name` varchar(32) collate latin1_german1_ci NOT NULL,
  `elem_id` int(11) NOT NULL,
  `actived` int(2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=1 ;

--
-- Contenu de la table `parametres_vues`
--


-- --------------------------------------------------------

--
-- Structure de la table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL auto_increment,
  `droits` varchar(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `test`
--

INSERT INTO `test` (`id`, `droits`) VALUES
(1, '0x02');

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

CREATE TABLE IF NOT EXISTS `theme` (
  `name` text NOT NULL,
  `directory` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `theme`
--

INSERT INTO `theme` (`name`, `directory`) VALUES
('base', 'base/');

-- --------------------------------------------------------

--
-- Structure de la table `vues`
--

CREATE TABLE IF NOT EXISTS `vues` (
  `id` int(11) NOT NULL auto_increment,
  `module` varchar(64) collate latin1_german1_ci NOT NULL,
  `name` varchar(32) collate latin1_german1_ci NOT NULL,
  `actived` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `vues`
--

INSERT INTO `vues` (`id`, `module`, `name`, `actived`) VALUES
(1, 'adn', 'connect', 1);
