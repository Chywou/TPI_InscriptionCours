-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 04 juin 2021 à 09:27
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
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Ado'),
(2, 'Adulte'),
(3, 'Senior'),
(4, 'Enfant');

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
('DoctrineMigrations\\Version20210517084130', '2021-05-17 10:44:14', 746),
('DoctrineMigrations\\Version20210601063035', '2021-06-01 08:31:05', 805);

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
(3, 2, 1, '2021-05-30', '11:00:00', '14:00:00', 5),
(4, 1, 1, '2021-05-26', '14:30:00', '16:00:00', 4),
(5, 2, 1, '2021-05-20', '10:00:00', '12:00:00', 4),
(7, 1, 1, '2021-05-20', '16:00:00', '18:00:00', 4),
(10, 2, 1, '2021-05-17', '12:00:00', '13:00:00', 4),
(11, 2, 1, '2021-05-29', '13:00:00', '16:00:00', 3),
(12, 1, 2, '2021-05-21', '15:00:00', '16:00:00', 5),
(13, 2, 1, '2021-05-21', '12:00:00', '13:00:00', 5),
(14, 2, 1, '2021-05-28', '14:00:00', '15:00:00', 7),
(15, 2, 2, '2021-05-22', '13:00:00', '23:00:00', 10),
(16, 3, 2, '2021-05-31', '13:00:00', '14:35:00', 8),
(17, 2, 1, '2021-05-31', '13:00:00', '13:40:00', 24),
(18, 2, 1, '2021-05-27', '14:00:00', '15:00:00', 10),
(19, 2, 1, '2021-06-03', '13:00:00', '16:00:00', 5),
(20, 2, 1, '2021-06-04', '15:00:00', '16:00:00', 6),
(21, 2, 2, '2021-06-03', '12:00:00', '14:30:00', 8),
(22, 1, 2, '2021-06-06', '18:00:00', '20:00:00', 6),
(23, 1, 1, '2021-06-03', '03:00:00', '05:00:00', 5);

-- --------------------------------------------------------

--
-- Structure de la table `participant`
--

CREATE TABLE `participant` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dog_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
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
(24, 11, 'sQQSsQ', 'QSQS', 'WADADAsds'),
(25, 1, 'test2', 'test2', 'wadadwa'),
(26, 1, 'drgdgd', 'grdg', 'drggrdg'),
(27, 1, 'esfsfse', 'sfef', 'sefsfs'),
(28, 1, 'dadad', 'adada', 'addada'),
(29, 1, 'fsefsefs13123', 'sfesfsefs', 'fsefsfse'),
(30, 1, '3423424fesfes', 'sefse', 'fsefse'),
(31, 1, 'dawdaww342432', 'dwadaw', 'awdwada'),
(32, 1, 'ààààà', 'awdawdaw', 'wadawdda'),
(33, 17, 'dawda', 'adawda4545:', 'addad'),
(34, 17, 'adawda4545:____', 'adawda4545:', 'adwadawdaw'),
(35, 17, 'adawda4545:', 'adawda4545:', 'fafsfe'),
(36, 18, 'Steiner', 'Jérémiah', 'Smoko'),
(37, 21, 'test', 'test', 'test'),
(38, 21, 'test', 'test', 'test'),
(39, 20, 'test', 'test', 'test'),
(40, 19, 'AWFAFA', 'FAWFA', 'AFFA'),
(41, 23, 'hj', 'gj', 'hj'),
(42, 23, 'asdasd', 'asdasd', '\"as\"'),
(43, 23, 'asdsad', 'asdasdds', '\''),
(44, 21, 'asdasd', 'asdasddas', '\'\''),
(45, 21, 'sadsd', 'asdasdsa', '\"\"'),
(46, 19, 'asdasd', 'asdasdsa', '``'),
(47, 23, 'dawdawd', 'awdawdwadsdsadawda', 'adwdwa'),
(48, 23, 'dwad', 'awdwad', 'awdawd'),
(49, 19, 'ffawfaw', 'afaw', 'awfaf'),
(50, 19, 'fwafaf', 'awfawf', 'fwa');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `last_name`, `first_name`) VALUES
(1, NULL, '[\"ROLE_MANAGER\"]', NULL, 'Dupont', 'Jean'),
(2, 'admin@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$SDdLLnpQNzQ2ejlUVlVvTg$OwdchxnhSKA6+J2otypukcQcrK6NTuTs4nsHFLHgsPU', 'test', 'test'),
(5, 'test@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$VEJaZ1hjWmtzVk9VeGdQQg$GgARYhew04Mc55B6ShZ6M1RB+ET5jtC/3pjjLqkdj0I', 'sefsfs', 'sfsef'),
(6, 'pikou@gmail.com', '[\"ROLE_ADMIN\"]', NULL, 'guidetti', 'Pikou'),
(7, 'Smoko@gmail.com', '[\"ROLE_ADMIN\"]', NULL, 'Steiner', 'Smoko'),
(17, 'Steiner@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$b0N6YzJsS3ZjLzU5MmNzcA$DLNSvvFVgqARhdBkrzoocnsdiunZ+o6FsAqfrL5em0o', 'dwadawd', 'awda'),
(18, 'pookie.adrian@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$WXhnVk1tOTN6TWxYek9nMA$Rm1YOmGQm5obetT2SnbjSahI2CN0vtUrMB60SGbvJDE', 'Adru', 'pookie'),
(19, 'jeremiah@hispeed.ch', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$ckhYanZnVkNub2VZNXV1Vw$eGCBJRPwdNjbrRU1xH59+zHHGzH4nALKM30E4J+44+o', 'Steiner', 'Jeremiaj'),
(20, NULL, '[\"ROLE_MANAGER\"]', NULL, 'test', 'test'),
(21, 'jeremiah.steiner@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$UFM2YjBDNzVkSThKUk1aaw$v80PQ4jNOkfcCGlQTUuWlme24LY+IhQoQnWPz9NO23o', 'Steiner', 'Jeremiaht'),
(22, 'fafawaw@hispeed.ch', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$eXRvcGdBaVFOc2I2MEguZw$pxehLDs34ep2M3fvKvOHWwN74QFeWo6rVUviUJ1q2ew', 'wafawfawfaw', 'fafawf'),
(26, 'test2@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$eDJMNXJVVXUxN1F5V3h5Rg$fnWcG1hREd0hcAsP/WvEJJXyzRCtFaKzfUvyrBdykGY', 'adwdad', 'awdwadaw'),
(28, 'test7@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$djJocVhEUHcueVo2MzRBVQ$XpmYKL3SC3Elx7f8VhDAgAyPKl5Zl10FDgcqZEPKtrI', 'awfawfawf', 'afawf'),
(29, 'test.test@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$RnEyRVM5RlhUL2FmSGtHYw$bGKoa1ORPCWpqL7Sy+3uZhtzn2+9Rp8O624zdSL4xiw', 'test', 'test'),
(30, 'sebastien@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$WWppdUFKT2tKQVVZeUc2OQ$M1JqpU/nACC9cVA+WNz3cqjhGsZagsc/53GlDd9BmYg', 'Pas de nom', 'Sebastien'),
(31, 'adawdaw@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$Nlk1eUJGNU5BNDB3RXFFTw$r0NawYHLAUikACL5TRTzR9chEZldltndzGu1ghJLH4k', 'awfafaw', 'awfawfa'),
(32, 'dawdawdaw@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$T1NWbm90UDAzMHFRQ1ZEZQ$GWelicuE6UqqMlcUMHmnB5WCXtcbx3H8P72/3KjwRug', 'wafawfawfaw', 'awfwaf'),
(33, 'awdawdw@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$SVFyaGFMUjFkVVZOdGdFTQ$agrGnBADw3QddK/tLRCQX+ccL5BsZFR0BCUGEdQk8mQ', 'awddaw', 'wadada'),
(35, 'laetitia.guidetti@eduvaud.ch', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$WUY3bHBXcGIyc1NuS3ZsLg$Sfo1qFH7AbrV4krMKA1Mq8GQX/vePjwBoZBaalhbyEk', 'Guidetti', 'Laetitia'),
(36, 'test5@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$eFlPZ1E2TXRFLnh4MFRrSQ$C+7OghB9AsxkFlv/hXI6y01QXrEJdNRZkxJ9Q4YF5Ag', 'sfsfe', 'esfesf');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `lesson`
--
ALTER TABLE `lesson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `participant`
--
ALTER TABLE `participant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

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
