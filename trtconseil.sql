-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 21 mars 2023 à 10:29
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `trtconseil`
--

-- --------------------------------------------------------

--
-- Structure de la table `candidate`
--

CREATE TABLE `candidate` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `candidate`
--

INSERT INTO `candidate` (`id`, `user_id`, `firstname`, `lastname`) VALUES
(1, 1, 'Jojo', 'Dugenou'),
(2, 6, 'Jan', 'Jan');

-- --------------------------------------------------------

--
-- Structure de la table `candidature`
--

CREATE TABLE `candidature` (
  `id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `job_offer_id` int(11) NOT NULL,
  `consultant_id` int(11) DEFAULT NULL,
  `validated` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `candidature`
--

INSERT INTO `candidature` (`id`, `candidate_id`, `job_offer_id`, `consultant_id`, `validated`) VALUES
(1, 1, 2, NULL, 0),
(2, 1, 5, NULL, 0),
(12, 2, 3, NULL, 0),
(13, 2, 5, NULL, 0),
(14, 2, 2, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `consultant`
--

CREATE TABLE `consultant` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `consultant`
--

INSERT INTO `consultant` (`id`, `user_id`) VALUES
(3, 1),
(1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20221104151639', '2023-03-15 16:28:07', 33),
('DoctrineMigrations\\Version20221104200001', '2023-03-15 16:28:07', 29);

-- --------------------------------------------------------

--
-- Structure de la table `job_offer`
--

CREATE TABLE `job_offer` (
  `id` int(11) NOT NULL,
  `recrutor_id` int(11) NOT NULL,
  `consultant_id` int(11) DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `location` varchar(100) NOT NULL,
  `detailled_description` longtext NOT NULL,
  `validated` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `job_offer`
--

INSERT INTO `job_offer` (`id`, `recrutor_id`, `consultant_id`, `title`, `location`, `detailled_description`, `validated`) VALUES
(1, 1, 1, 'Happiness manager', 'Tourcoing', 'Les équipes de MegaCorp de Tourcoing ont bien besoin d\'un peu de bonheur mais elles ne savent pas le gérer. Vous intervenez pour cela.', 0),
(2, 1, 1, 'Compteur de grains de sables', 'Montluçon', 'Controle qualité dans une usine de sablier : qualification du nombre de grain de sable dans chaque sablier par comptage', 1),
(3, 1, 1, 'Peigneur de caniche', 'Strasbourg', '12 ans d\'expérience demandées', 1),
(4, 1, 1, 'Presseur de Citron', 'Amalfi', 'Pour l\'usine Pulco d\'Amalfi, nous recherchons un presseur de citrons expérimenté qui travaillera en binome avec un coupeur de citrons', 0),
(5, 2, 1, 'Compteur de grévistes', 'Paris', 'Mission : évaluer le nombre de grévistes à chaque manifestations.\r\nCompétences attendues : mauvaise foi', 1),
(6, 2, NULL, 'Testeur de Controller', 'Lille', 'testeur de controller', 0);

-- --------------------------------------------------------

--
-- Structure de la table `recrutor`
--

CREATE TABLE `recrutor` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `enterprise_address` longtext DEFAULT NULL COMMENT '(DC2Type:array)',
  `enterprise_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `recrutor`
--

INSERT INTO `recrutor` (`id`, `user_id`, `enterprise_address`, `enterprise_name`) VALUES
(1, 2, 'a:0:{}', 'MegaCorp'),
(2, 4, 'a:0:{}', 'Global Industries');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
(1, 'Jon@test.com', '[\"ROLE_CANDIDATE\"]', '$2y$13$48t7NsJcNWIG25oYHVNRauKxjBK0NNjpO8v34PP1KRw9hFsU4cBCu'),
(2, 'Jun@test.com', '[\"ROLE_RECRUTOR\"]', '$2y$13$cbVIU3Y3P.d3pkVpj2HY4.D8AJUGO/Qw/WxPUbifsqUN3.sy7qMCu'),
(3, 'Jin@test.com', '[\"ROLE_CONSULTANT\"]', '$2y$13$clP3dgPujNee48nJEwZj.u/tjRyZkPsKeh8G8ULUSUIQSX.Mqffrq'),
(4, 'Jen@test.com', '[\"ROLE_RECRUTOR\"]', '$2y$13$SHis1e9annZ6gDWP7lk3S.GkF16cc6xmHNZUTqWW8cPumNvg33/0y'),
(6, 'Jan@test.com', '[\"ROLE_CANDIDATE\"]', '$2y$13$XRmbJp87IPaAY62cjHwTy.PkhZAujiG43b2oq4yBt9SOI63o2d9s.');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `candidate`
--
ALTER TABLE `candidate`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C8B28E44A76ED395` (`user_id`);

--
-- Index pour la table `candidature`
--
ALTER TABLE `candidature`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E33BD3B891BD8781` (`candidate_id`),
  ADD KEY `IDX_E33BD3B83481D195` (`job_offer_id`),
  ADD KEY `IDX_E33BD3B844F779A2` (`consultant_id`);

--
-- Index pour la table `consultant`
--
ALTER TABLE `consultant`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_441282A1A76ED395` (`user_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `job_offer`
--
ALTER TABLE `job_offer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_288A3A4E1C2B9A94` (`recrutor_id`),
  ADD KEY `IDX_288A3A4E44F779A2` (`consultant_id`);

--
-- Index pour la table `recrutor`
--
ALTER TABLE `recrutor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_CDC13C7A76ED395` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `candidate`
--
ALTER TABLE `candidate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `candidature`
--
ALTER TABLE `candidature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `consultant`
--
ALTER TABLE `consultant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `job_offer`
--
ALTER TABLE `job_offer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `recrutor`
--
ALTER TABLE `recrutor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `recrutor`
--
ALTER TABLE `recrutor`
  ADD CONSTRAINT `FK_CDC13C7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
