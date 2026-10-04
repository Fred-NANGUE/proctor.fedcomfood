-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 12 Janvier 2026 à 03:49
-- Version du serveur :  10.1.16-MariaDB
-- Version de PHP :  7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gestion_discipline`
--
CREATE DATABASE IF NOT EXISTS `gestion_discipline` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `gestion_discipline`;

-- --------------------------------------------------------

--
-- Structure de la table `absence`
--

CREATE TABLE `absence` (
  `identifiant` char(25) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `classe` varchar(50) NOT NULL,
  `date_heure` date DEFAULT NULL,
  `heure` int(10) DEFAULT NULL,
  `motif` varchar(255) DEFAULT NULL,
  `statut` varchar(10) DEFAULT NULL,
  `id_cour` char(10) DEFAULT NULL,
  `total_absent` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `absence`
--

INSERT INTO `absence` (`identifiant`, `nom`, `prenom`, `classe`, `date_heure`, `heure`, `motif`, `statut`, `id_cour`, `total_absent`) VALUES
('ici', 'ddf', 'fdf', 'CF039', '2025-11-26', 10, '0', '0', '0', 0),
('IUC', 'NANGUE', 'FEULEFACK', 'TI 1', NULL, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `absence_etudiant`
--

CREATE TABLE `absence_etudiant` (
  `id_cour_COURS` char(10) NOT NULL,
  `identifiant_ABSENCE` char(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `matricule` varchar(25) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL DEFAULT 'frednangue@gmail.com',
  `mot_de_passe` varchar(20) NOT NULL DEFAULT 'g55ssd6d616d',
  `hobby` varchar(20) DEFAULT NULL,
  `voiture_preferer` varchar(20) DEFAULT NULL,
  `film_preferer` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `administrateur`
--

INSERT INTO `administrateur` (`matricule`, `nom`, `prenom`, `email`, `mot_de_passe`, `hobby`, `voiture_preferer`, `film_preferer`) VALUES
('fred1510101607', 'NANGUE', 'FRED', 'frednangue@gmail.com', '1510101607', 'cuisine', 'yaris', 'the last ship'),
('U17', 'nangue', 'alarn', 'alarnnangue@gmail.com', '2010', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `affecter`
--

CREATE TABLE `affecter` (
  `matricule_et_ETUDIANT` char(15) NOT NULL,
  `identifiant_ABSENCE` char(25) NOT NULL,
  `matricule_en_ENSEIGNANT` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `associer`
--

CREATE TABLE `associer` (
  `matricule_en_ENSEIGNANT` char(15) NOT NULL,
  `id_cour_COURS` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

CREATE TABLE `classe` (
  `matricule_cl` char(5) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `nombre_etudiant` int(200) DEFAULT NULL,
  `nombre_matiere` int(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `classe`
--

INSERT INTO `classe` (`matricule_cl`, `nom`, `nombre_etudiant`, `nombre_matiere`) VALUES
('CF017', 'CF017', NULL, NULL),
('CF039', 'CF039', 17, 14),
('CF248', 'CF248', NULL, NULL),
('CF249', 'CF249', NULL, NULL),
('CF147', 'TI 1', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE `cours` (
  `id_cour` char(10) NOT NULL,
  `intitule` varchar(50) DEFAULT NULL,
  `classe_associe` varchar(25) DEFAULT NULL,
  `enseignant_associe` char(55) DEFAULT NULL,
  `nombre_absent` int(200) DEFAULT NULL,
  `heure_debut` int(6) DEFAULT NULL,
  `heure_fin` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `cours`
--

INSERT INTO `cours` (`id_cour`, `intitule`, `classe_associe`, `enseignant_associe`, `nombre_absent`, `heure_debut`, `heure_fin`) VALUES
('01', 'P.O.O', 'CF039', 'NGOUDJOU', NULL, 8, 12),
('02', 'PROGRAMMATION JAVA', 'CF039', 'NGUEFACK', NULL, 12, 17);

-- --------------------------------------------------------

--
-- Structure de la table `enseignant`
--

CREATE TABLE `enseignant` (
  `matricule_en` char(15) NOT NULL,
  `nom` char(25) NOT NULL,
  `prenom` char(25) NOT NULL,
  `discipline` char(70) NOT NULL,
  `age` int(2) NOT NULL,
  `sexe` char(10) NOT NULL,
  `numero_de_telephone` int(9) NOT NULL,
  `emailEnseignant` varchar(100) NOT NULL,
  `liste_absence` varchar(2555) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `enseignant`
--

INSERT INTO `enseignant` (`matricule_en`, `nom`, `prenom`, `discipline`, `age`, `sexe`, `numero_de_telephone`, `emailEnseignant`, `liste_absence`) VALUES
('DELTA 14', 'NGOUDJOU', 'GUY VALERE', 'MECANIQUE DU SOLIDE', 39, 'Masculin', 515466684, 'valerengoudjou@gmail.com', ''),
('IUC24E00081095', 'NGUEFACK', 'BRICE', 'ALGEBRE 1A', 38, 'Masculin', 698336644, 'bricenguefack@gmail.com', '');

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `matricule_et` char(15) NOT NULL,
  `nom` char(55) DEFAULT NULL,
  `prenom` char(55) DEFAULT NULL,
  `classe` varchar(25) DEFAULT NULL,
  `liste_des_absences` varchar(500) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `sexe` varchar(10) DEFAULT NULL,
  `adresse_mail` varchar(100) DEFAULT NULL,
  `emailParent` varchar(50) NOT NULL,
  `numero_de_telephone` int(9) DEFAULT NULL,
  `numero_parent` int(9) DEFAULT NULL,
  `matricule_cl_CLASSE` char(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `etudiant`
--

INSERT INTO `etudiant` (`matricule_et`, `nom`, `prenom`, `classe`, `liste_des_absences`, `age`, `sexe`, `adresse_mail`, `emailParent`, `numero_de_telephone`, `numero_parent`, `matricule_cl_CLASSE`) VALUES
('ici', 'ddf', 'fdf', 'CF039', '', 44, 'Masculin', 'sdsdsd', 'DFDF', 454545, 3434343, NULL),
('ICIA', 'FRED', 'ALIAS', 'CF249', '', 45, 'Feminin', '767*6', '445445', 4644, 54545, NULL),
('IUC', 'NANGUE', 'FEULEFACK', 'TI 1', '', 18, 'Masculin', 'SBK@gmail.com', 'j@gmail.com', 66, 645712577, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `historique absence`
--

CREATE TABLE `historique absence` (
  `matricule` varchar(25) NOT NULL,
  `nom` varchar(55) DEFAULT NULL,
  `prenom` varchar(70) DEFAULT NULL,
  `classe` varchar(10) DEFAULT NULL,
  `date_absence` date NOT NULL,
  `heure` int(25) NOT NULL,
  `motif` varchar(25) DEFAULT NULL,
  `statut` varchar(25) DEFAULT NULL,
  `totalAbsences` int(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `historique_connexion`
--

CREATE TABLE `historique_connexion` (
  `id_user` varchar(25) NOT NULL,
  `nom_user` varchar(55) DEFAULT NULL,
  `heure_connexion` time(6) NOT NULL,
  `date_connexion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `historique_connexion`
--

INSERT INTO `historique_connexion` (`id_user`, `nom_user`, `heure_connexion`, `date_connexion`) VALUES
('U17', NULL, '01:55:39.210000', '2025-11-26'),
('U17', NULL, '02:04:01.510000', '2025-11-26'),
('U17', NULL, '06:45:47.534000', '2025-11-26'),
('U17', NULL, '06:50:33.441000', '2025-11-26'),
('U17', NULL, '06:55:13.952000', '2025-11-26'),
('U17', NULL, '07:00:07.123000', '2025-11-26'),
('U17', NULL, '07:08:39.765000', '2025-11-26'),
('U17', NULL, '07:11:21.354000', '2025-11-26'),
('U17', NULL, '07:13:00.768000', '2025-11-26'),
('U17', NULL, '07:15:42.776000', '2025-11-26'),
('U17', NULL, '07:16:50.699000', '2025-11-26'),
('U17', NULL, '07:18:53.912000', '2025-11-26'),
('U17', NULL, '08:02:39.943000', '2025-11-26'),
('U17', NULL, '08:06:29.959000', '2025-11-26'),
('U17', NULL, '08:09:43.534000', '2025-11-26'),
('U17', NULL, '08:24:05.955000', '2025-11-26'),
('U17', NULL, '08:28:47.213000', '2025-11-26'),
('U17', NULL, '08:38:19.811000', '2025-11-26'),
('U17', NULL, '08:39:54.996000', '2025-11-26'),
('U17', NULL, '08:45:25.627000', '2025-11-26'),
('U17', NULL, '09:56:01.242000', '2025-11-26'),
('U17', NULL, '10:02:50.316000', '2025-11-26'),
('fred1510101607', NULL, '10:04:59.279000', '2025-11-26'),
('U17', NULL, '10:19:02.570000', '2025-11-26'),
('U17', NULL, '10:33:37.583000', '2025-11-26'),
('U17', NULL, '10:38:47.767000', '2025-11-26'),
('U17', NULL, '10:43:13.132000', '2025-11-26'),
('U17', NULL, '10:47:07.148000', '2025-11-26'),
('U17', NULL, '10:57:27.632000', '2025-11-26'),
('U17', NULL, '11:02:35.623000', '2025-11-26'),
('U17', NULL, '11:03:52.422000', '2025-11-26'),
('U17', NULL, '11:11:41.637000', '2025-11-26'),
('U17', NULL, '11:13:28.007000', '2025-11-26'),
('U17', NULL, '11:29:35.413000', '2025-11-26'),
('U17', NULL, '11:30:22.136000', '2025-11-26'),
('U17', NULL, '11:35:10.023000', '2025-11-26'),
('U17', NULL, '11:53:51.262000', '2025-11-26'),
('U17', NULL, '11:55:14.272000', '2025-11-26'),
('U17', NULL, '12:09:07.758000', '2025-11-26'),
('U17', NULL, '12:54:48.511000', '2025-11-26'),
('U17', NULL, '12:56:05.317000', '2025-11-26'),
('U17', NULL, '12:56:51.573000', '2025-11-26'),
('U17', NULL, '13:15:49.104000', '2025-11-26'),
('U17', NULL, '13:22:01.594000', '2025-11-26'),
('U17', NULL, '13:22:57.884000', '2025-11-26'),
('U17', NULL, '13:27:51.171000', '2025-11-26'),
('U17', NULL, '13:45:53.964000', '2025-11-26'),
('U17', NULL, '15:12:40.956000', '2025-11-26'),
('U17', NULL, '18:07:09.526000', '2025-11-29'),
('U17', NULL, '18:07:20.377000', '2025-11-29'),
('U17', NULL, '18:07:54.055000', '2025-11-29'),
('U17', NULL, '18:08:13.861000', '2025-11-29'),
('U17', NULL, '18:08:55.611000', '2025-11-29'),
('U17', NULL, '18:09:33.057000', '2025-11-29'),
('U17', NULL, '15:24:11.161000', '2025-12-14'),
('U17', NULL, '08:53:01.417000', '2025-12-24'),
('U17', NULL, '08:54:01.009000', '2025-12-24'),
('U17', NULL, '08:54:13.611000', '2025-12-24'),
('U17', NULL, '08:59:22.775000', '2025-12-24'),
('U17', NULL, '10:31:34.716000', '2025-12-24');

-- --------------------------------------------------------

--
-- Structure de la table `rejoindre`
--

CREATE TABLE `rejoindre` (
  `matricule_en_ENSEIGNANT` char(15) NOT NULL,
  `matricule_cl_CLASSE` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `absence`
--
ALTER TABLE `absence`
  ADD PRIMARY KEY (`identifiant`),
  ADD KEY `date_heure` (`date_heure`,`motif`(191),`total_absent`);

--
-- Index pour la table `absence_etudiant`
--
ALTER TABLE `absence_etudiant`
  ADD PRIMARY KEY (`id_cour_COURS`,`identifiant_ABSENCE`),
  ADD KEY `FK_absence_etudiant_identifiant_ABSENCE` (`identifiant_ABSENCE`);

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`matricule`);

--
-- Index pour la table `affecter`
--
ALTER TABLE `affecter`
  ADD PRIMARY KEY (`matricule_et_ETUDIANT`,`identifiant_ABSENCE`,`matricule_en_ENSEIGNANT`),
  ADD KEY `FK_Affecter_identifiant_ABSENCE` (`identifiant_ABSENCE`),
  ADD KEY `FK_Affecter_matricule_en_ENSEIGNANT` (`matricule_en_ENSEIGNANT`);

--
-- Index pour la table `associer`
--
ALTER TABLE `associer`
  ADD PRIMARY KEY (`matricule_en_ENSEIGNANT`,`id_cour_COURS`),
  ADD KEY `FK_Associer_id_cour_COURS` (`id_cour_COURS`);

--
-- Index pour la table `classe`
--
ALTER TABLE `classe`
  ADD PRIMARY KEY (`matricule_cl`),
  ADD KEY `nom` (`nom`,`nombre_etudiant`,`nombre_matiere`);

--
-- Index pour la table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`id_cour`),
  ADD KEY `intitule` (`intitule`,`classe_associe`,`enseignant_associe`,`nombre_absent`,`heure_debut`,`heure_fin`);

--
-- Index pour la table `enseignant`
--
ALTER TABLE `enseignant`
  ADD PRIMARY KEY (`matricule_en`),
  ADD KEY `nom` (`nom`,`prenom`,`discipline`,`age`,`sexe`,`numero_de_telephone`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`matricule_et`),
  ADD KEY `nom` (`nom`,`prenom`,`classe`,`liste_des_absences`(191),`age`,`sexe`,`adresse_mail`,`numero_de_telephone`,`numero_parent`),
  ADD KEY `FK_ETUDIANT_matricule_cl_CLASSE` (`matricule_cl_CLASSE`);

--
-- Index pour la table `rejoindre`
--
ALTER TABLE `rejoindre`
  ADD PRIMARY KEY (`matricule_en_ENSEIGNANT`,`matricule_cl_CLASSE`),
  ADD KEY `FK_rejoindre_matricule_cl_CLASSE` (`matricule_cl_CLASSE`);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `absence_etudiant`
--
ALTER TABLE `absence_etudiant`
  ADD CONSTRAINT `FK_absence_etudiant_id_cour_COURS` FOREIGN KEY (`id_cour_COURS`) REFERENCES `cours` (`id_cour`),
  ADD CONSTRAINT `FK_absence_etudiant_identifiant_ABSENCE` FOREIGN KEY (`identifiant_ABSENCE`) REFERENCES `absence` (`identifiant`);

--
-- Contraintes pour la table `affecter`
--
ALTER TABLE `affecter`
  ADD CONSTRAINT `FK_Affecter_identifiant_ABSENCE` FOREIGN KEY (`identifiant_ABSENCE`) REFERENCES `absence` (`identifiant`),
  ADD CONSTRAINT `FK_Affecter_matricule_en_ENSEIGNANT` FOREIGN KEY (`matricule_en_ENSEIGNANT`) REFERENCES `enseignant` (`matricule_en`),
  ADD CONSTRAINT `FK_Affecter_matricule_et_ETUDIANT` FOREIGN KEY (`matricule_et_ETUDIANT`) REFERENCES `etudiant` (`matricule_et`);

--
-- Contraintes pour la table `associer`
--
ALTER TABLE `associer`
  ADD CONSTRAINT `FK_Associer_id_cour_COURS` FOREIGN KEY (`id_cour_COURS`) REFERENCES `cours` (`id_cour`),
  ADD CONSTRAINT `FK_Associer_matricule_en_ENSEIGNANT` FOREIGN KEY (`matricule_en_ENSEIGNANT`) REFERENCES `enseignant` (`matricule_en`);

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `FK_ETUDIANT_matricule_cl_CLASSE` FOREIGN KEY (`matricule_cl_CLASSE`) REFERENCES `classe` (`matricule_cl`);

--
-- Contraintes pour la table `rejoindre`
--
ALTER TABLE `rejoindre`
  ADD CONSTRAINT `FK_rejoindre_matricule_cl_CLASSE` FOREIGN KEY (`matricule_cl_CLASSE`) REFERENCES `classe` (`matricule_cl`),
  ADD CONSTRAINT `FK_rejoindre_matricule_en_ENSEIGNANT` FOREIGN KEY (`matricule_en_ENSEIGNANT`) REFERENCES `enseignant` (`matricule_en`);
--
-- Base de données :  `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Structure de la table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(11) NOT NULL,
  `dbase` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `user` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `query` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Structure de la table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_length` text COLLATE utf8_bin,
  `col_collation` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) COLLATE utf8_bin DEFAULT '',
  `col_default` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Structure de la table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `column_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Structure de la table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `settings_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Structure de la table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `export_type` varchar(10) COLLATE utf8_bin NOT NULL,
  `template_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `template_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Structure de la table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Structure de la table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sqlquery` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Structure de la table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Structure de la table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Structure de la table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Contenu de la table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{"db":"reservation_system","table":"reservation"},{"db":"reservation_system","table":"client"},{"db":"reservation_system","table":"produit"},{"db":"reservation_system","table":"employe"},{"db":"reservation_system","table":"commentaire"},{"db":"reservation_system","table":"administrateur"},{"db":"reservation_system","table":"services"},{"db":"reservation_system","table":"subscription"}]');

-- --------------------------------------------------------

--
-- Structure de la table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Structure de la table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Structure de la table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT '0',
  `x` float UNSIGNED NOT NULL DEFAULT '0',
  `y` float UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Structure de la table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `display_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Structure de la table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `prefs` text COLLATE utf8_bin NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Structure de la table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text COLLATE utf8_bin NOT NULL,
  `schema_sql` text COLLATE utf8_bin,
  `data_sql` longtext COLLATE utf8_bin,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') COLLATE utf8_bin DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Structure de la table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `config_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Contenu de la table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2026-01-11 04:59:17', '{"lang":"fr","collation_connection":"utf8mb4_unicode_ci"}');

-- --------------------------------------------------------

--
-- Structure de la table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL,
  `tab` varchar(64) COLLATE utf8_bin NOT NULL,
  `allowed` enum('Y','N') COLLATE utf8_bin NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Structure de la table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Index pour les tables exportées
--

--
-- Index pour la table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Index pour la table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Index pour la table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Index pour la table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Index pour la table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Index pour la table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Index pour la table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Index pour la table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Index pour la table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Index pour la table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Index pour la table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Index pour la table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Index pour la table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Index pour la table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Index pour la table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Index pour la table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Index pour la table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Index pour la table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;--
-- Base de données :  `reservation_system`
--
CREATE DATABASE IF NOT EXISTS `reservation_system` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `reservation_system`;

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` int(20) NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelleImageAD` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `administrateur`
--

INSERT INTO `administrateur` (`id`, `nom`, `prenom`, `numero`, `email`, `password`, `libelleImageAD`) VALUES
(1, 'NANGUE FEULEFACK', 'FRED MIGUEL', 688724499, 'fredmiguelnanguefeulefack@gmail.com', '$2y$10$OHwjQe8OIuOhmn3i95FHeurg98AulhUaA.SIkY4BeEFtu2ad43p26', 'IMG_20250530_173246_009.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` int(15) NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libelleImageCL` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`id`, `nom`, `prenom`, `numero`, `email`, `password`, `libelleImageCL`) VALUES
(9, 'NANGUE', 'FRED MIGUEL', 672921799, 'fredmiguelnanguefeulefack@gmail.com', '$2y$10$vnxfscKAu7X9lG9pRpN4Ue.WwTuPPEfeongBYbyfzdkyMYAmXk.RO', 'IMG_20250530_173246_009.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id` int(11) NOT NULL,
  `idproduit` int(11) NOT NULL,
  `nom_produit` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_client` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commentaire` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `idproduit`, `nom_produit`, `nom_client`, `email`, `commentaire`) VALUES
(1, 1, 'Double Ketchup', 'la', 'lamenace@gmail.com', 'tres bon'),
(2, 1, 'Double Ketchup', 'la', 'lamenace@gmail.com', 'tres bon'),
(3, 19, 'Omelette', 'la', 'lamenace@gmail.com', 'merci'),
(4, 23, 'Poisson grillé', 'NANGUE', 'fredmiguelnanguefeulefack@gmail.com', 'pardon laisser moi comme ca, il poisson cila c''est la dégaine');

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

CREATE TABLE `employe` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` int(15) NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `libelleImagePersonnel` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `employe`
--

INSERT INTO `employe` (`id`, `nom`, `prenom`, `specialite`, `numero`, `email`, `password`, `libelleImagePersonnel`) VALUES
(1, 'FEULEFACK', 'FRED', 'gg', 672921799, 'fredmiguelnanguefeulefack@gmail.c', NULL, 'IMG_20250107_154835_225.jpg'),
(2, 'NANGUE', 'ALAIN', 'serveur', 671086249, 'alainmichelnangue29@gmail.com', NULL, 'IMG_20251127_125734_283.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id` int(11) NOT NULL,
  `categorie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  `quantite` int(11) NOT NULL,
  `libelleImage` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `produit`
--

INSERT INTO `produit` (`id`, `categorie`, `nom`, `description`, `prix`, `quantite`, `libelleImage`) VALUES
(1, 'Premier_repas\r\n', 'Double Ketchup', 'Le plat le plus popuplaire de Limoge France. Avec ...', 2500, 17, '5f4a01c7a43ff.jpg\r\n'),
(19, 'Premier_repas', 'Omelette', 'Omelette aux œufs et fromage', 1500, 10, 'omelette.jpeg'),
(20, 'Dejeuner', 'Poulet braisé', 'Poulet braisé avec des frites', 3500, 15, 'poulet_braise.jpeg'),
(21, 'Diner', 'Soupe de légumes', 'Soupe de légumes frais', 2000, 20, 'soupe_legumes.jpeg'),
(22, 'Premier_repas', 'Pain beurré', 'Pain beurré avec du café', 1000, 25, 'pain_beurre.jpeg'),
(23, 'Dejeuner', 'Poisson grillé', 'Poisson grillé avec des légumes', 4000, 12, 'poisson_grille.jpeg'),
(24, 'Diner', 'Riz sauté', 'Riz sauté avec des légumes et viande', 2500, 18, 'riz_saute.jpeg'),
(25, 'Premier_repas', 'Yaourt', 'Yaourt nature ou aux fruits', 800, 30, 'yaourt.jpeg'),
(26, 'Dejeuner', 'Ndolé', 'Ndolé avec du poisson', 3000, 10, 'ndole.jpeg'),
(27, 'Diner', 'Poulet au curry', 'Poulet au curry avec du riz', 3500, 15, 'poulet_curry.jpeg'),
(28, 'Premier_repas', 'Café', 'Café noir ou avec du lait', 500, 50, 'cafe.jpeg'),
(29, 'Dejeuner', 'Frites', 'Frites avec du ketchup', 1500, 20, 'frites.jpeg'),
(30, 'Diner', 'Salade', 'Salade de légumes frais', 2000, 15, 'salade.jpeg'),
(31, 'Premier_repas', 'Jus d''orange', 'Jus d''orange frais', 1000, 25, 'jusOrange.jpeg'),
(32, 'Dejeuner', 'Viande braisée', 'Viande braisée avec des frites', 4000, 10, 'viande_braisee.jpeg'),
(33, 'Diner', 'Gâteau', 'Gâteau au chocolat', 2500, 12, 'gateau.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `nom_client` varchar(255) NOT NULL,
  `email` varchar(2500) NOT NULL,
  `telephone_client` varchar(255) NOT NULL,
  `mode_paiement` enum('Orange_Money','Especes') NOT NULL,
  `prix_total` double NOT NULL,
  `numero_table` enum('Table1','Table2','Table3','Table4','Table5','Table6','Table7','Table8','Table9','Table10') NOT NULL,
  `date_presence` date NOT NULL,
  `heure_presence` time NOT NULL,
  `periode_actuel_reservation` datetime NOT NULL,
  `details_panier` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `statut` enum('en_attente','confirmee','annulee') NOT NULL DEFAULT 'en_attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `reservation`
--

INSERT INTO `reservation` (`id`, `nom_client`, `email`, `telephone_client`, `mode_paiement`, `prix_total`, `numero_table`, `date_presence`, `heure_presence`, `periode_actuel_reservation`, `details_panier`, `statut`) VALUES
(1, 'la menace', 'lamenace@gmail.com', '124578', 'Orange_Money', 17500, 'Table6', '0000-00-00', '00:00:00', '2026-01-11 00:00:00', '[{"nom":"Omelette","prix":1500,"qte":1},{"nom":"Double Ketchup","prix":2500,"qte":1},{"nom":"Omelette","prix":1500,"qte":9}]', 'annulee'),
(3, 'la menace', 'lamenace@gmail.com', '124578', 'Especes', 7800, 'Table1', '2008-07-21', '00:00:00', '2026-01-11 00:00:00', '[{"nom":"Yaourt","prix":800,"qte":1},{"nom":"Frites","prix":1500,"qte":1},{"nom":"Ndolé","prix":3000,"qte":1},{"nom":"Double Ketchup","prix":2500,"qte":1}]', 'annulee'),
(4, 'NANGUE ALARN', 'alarnnangue@gmail.com', '671024666', 'Orange_Money', 7800, 'Table1', '0000-00-00', '00:00:00', '2026-01-11 00:00:00', '[{"nom":"Yaourt","prix":800,"qte":1},{"nom":"Ndolé","prix":3000,"qte":1},{"nom":"Poisson grillé","prix":4000,"qte":1}]', 'en_attente'),
(5, 'la menace', 'lamenace@gmail.com', '124578', 'Orange_Money', 12500, 'Table1', '2015-07-14', '00:00:00', '2026-01-11 00:00:00', '[{"nom":"Omelette","prix":1500,"qte":1},{"nom":"Double Ketchup","prix":2500,"qte":1},{"nom":"Double Ketchup","prix":2500,"qte":1},{"nom":"Gâteau","prix":2500,"qte":1},{"nom":"Poulet braisé","prix":3500,"qte":1}]', 'confirmee'),
(6, 'NANGUE FRED MIGUEL', 'fredmiguelnanguefeulefack@gmail.com', '688724499', 'Orange_Money', 12500, 'Table1', '0000-00-00', '00:00:00', '2026-01-11 00:00:00', '[{"nom":"Omelette","prix":1500,"qte":1},{"nom":"Double Ketchup","prix":2500,"qte":1},{"nom":"Double Ketchup","prix":2500,"qte":1},{"nom":"Gâteau","prix":2500,"qte":1},{"nom":"Poulet braisé","prix":3500,"qte":1}]', 'confirmee'),
(7, 'NANGUE FRED MIGUEL', 'fredmiguelnanguefeulefack@gmail.com', '2147483647', 'Especes', 6000, 'Table1', '0000-00-00', '14:46:00', '2026-01-11 00:00:00', '[{"nom":"Gâteau","prix":2500,"qte":1},{"nom":"Poulet braisé","prix":3500,"qte":1}]', 'confirmee'),
(8, 'NANGUE FRED MIGUEL', 'fredmiguelnanguefeulefack@gmail.com', '2147483647', 'Especes', 15000, 'Table1', '2026-01-16', '16:21:00', '2026-01-11 18:23:00', '[{"nom":"Double Ketchup","prix":2500,"qte":5},{"nom":"Double Ketchup","prix":2500,"qte":1}]', 'en_attente');

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `duration` int(11) NOT NULL COMMENT 'Durée en minutes',
  `price` decimal(10,2) NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `subscription`
--

CREATE TABLE `subscription` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_souscription` date NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `subscription`
--

INSERT INTO `subscription` (`id`, `email`, `date_souscription`, `message`) VALUES
(5, 'fredmiguelnanguefeulefack@gmail.com', '0000-00-00', 'trop cool, cette application');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `employe`
--
ALTER TABLE `employe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;--
-- Base de données :  `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
