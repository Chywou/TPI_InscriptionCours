-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 21 mai 2021 à 16:15
-- Version du serveur :  10.4.18-MariaDB
-- Version de PHP : 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_registerlesson`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Ado'),
(2, 'Adulte'),
(3, 'Senior');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210517084130', '2021-05-17 10:44:14', 746);

-- --------------------------------------------------------

--
-- Structure de la table `lesson`
--

CREATE TABLE `lesson` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_lesson` date NOT NULL,
  `start_hour` time NOT NULL,
  `end_hour` time NOT NULL,
  `people_number` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lesson`
--

INSERT INTO `lesson` (`id`, `category_id`, `user_id`, `date_lesson`, `start_hour`, `end_hour`, `people_number`) VALUES
(1, 1, 1, '2021-05-26', '11:00:00', '12:00:00', 10),
(3, 2, 1, '2021-05-22', '11:00:00', '14:00:00', 5),
(4, 1, 1, '2021-05-26', '14:30:00', '16:00:00', 4),
(5, 2, 1, '2021-05-20', '10:00:00', '12:00:00', 4),
(7, 1, 1, '2021-05-20', '16:00:00', '18:00:00', 4),
(10, 2, 1, '2021-05-17', '12:00:00', '13:00:00', 4),
(11, 2, 1, '2021-05-25', '13:00:00', '16:00:00', 3),
(12, 1, 2, '2021-05-21', '15:00:00', '16:00:00', 5),
(13, 2, 1, '2021-05-21', '12:00:00', '13:00:00', 5),
(14, 2, 1, '2021-05-21', '14:00:00', '15:00:00', 7),
(15, 2, 2, '2021-05-22', '13:00:00', '23:00:00', 10),
(16, 3, 2, '2021-05-22', '13:00:00', '14:35:00', 8);

-- --------------------------------------------------------

--
-- Structure de la table `participant`
--

CREATE TABLE `participant` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dog_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `participant`
--

INSERT INTO `participant` (`id`, `lesson_id`, `last_name`, `first_name`, `dog_name`) VALUES
(1, 4, 'Boulanger', 'Marie', 'Medor'),
(2, 4, 'Jean', 'Dupont', 'Chienchien'),
(3, 4, 'DuCommun', 'Hugo', 'Milou'),
(4, 4, 'Steiner', 'Jeremiah', 'Smoko'),
(5, 3, 'fefsefs', 'fesffeefef', 'esffefefe'),
(6, 1, 'fesfse', 'fsefeffe', 'fefeef'),
(7, 11, 'dgrdgrd', 'gdrgdrgr', 'dgdgdr'),
(8, 3, 'dwadwad', 'wadawdaw', 'dawdawd'),
(9, 3, 'dwadwad', 'wadawdaw', 'dawdawd'),
(10, 3, 'dwadwad', 'wadawdaw', 'dawdawd'),
(11, 3, 'dwadwad', 'wadawdaw', 'dawdawd'),
(12, 15, 'fhfthftt', 'dhtfth', 'htfhtfhfhtfh'),
(13, 15, 'rdhdhd', 'hdrhdhd', 'dhhdhdhd'),
(14, 16, 'dwadwa', 'dwadwa', 'dwadwa'),
(15, 15, 'wadwadwa', 'awdadwwadwa', 'dwadawdawdaw'),
(16, 15, 'dawdawdaw', 'dawdwad', 'ddawdawda'),
(17, 15, 'dawdawdaw', 'dawdwad', 'ddawdawda'),
(18, 15, 'dadawd', 'dadad', 'ddadw'),
(19, 15, 'dadawd', 'dadad', 'ddadw'),
(20, 15, 'dawdaw', 'adawd', 'dwadawdawdaw'),
(21, 15, 'fesfse', 'fesfsef', 'fsefes'),
(22, 15, 'awdaw', 'wadad', 'ddawdawda'),
(23, 11, 'sesfsf', 'efsfe', 'esfsfs'),
(24, 11, 'sQQSsQ', 'QSQS', 'WADADAsds');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `last_name`, `first_name`) VALUES
(1, NULL, '[\"ROLE_MANAGER\"]', NULL, 'Dupont', 'Jean'),
(2, 'admin@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$UDZpdUw5bXVTWDRjLy5CNw$YNA038zruOOG4UXKrT6f9Pqjj67urjb2xTukaLaKLPI', 'testdadwa', 'test');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `lesson`
--
ALTER TABLE `lesson`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F87474F312469DE2` (`category_id`),
  ADD KEY `IDX_F87474F3A76ED395` (`user_id`);

--
-- Index pour la table `participant`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D79F6B11CDF80196` (`lesson_id`);

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
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `lesson`
--
ALTER TABLE `lesson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `participant`
--
ALTER TABLE `participant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `lesson`
--
ALTER TABLE `lesson`
  ADD CONSTRAINT `FK_F87474F312469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_F87474F3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `participant`
--
ALTER TABLE `participant`
  ADD CONSTRAINT `FK_D79F6B11CDF80196` FOREIGN KEY (`lesson_id`) REFERENCES `lesson` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
