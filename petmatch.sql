-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 07 juil. 2023 à 15:52
-- Version du serveur : 10.4.25-MariaDB
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `petmatch`
--

-- --------------------------------------------------------

--
-- Structure de la table `animaux`
--

CREATE TABLE `animaux` (
  `id` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `espece` varchar(255) NOT NULL,
  `age` int(2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `disponible` tinyint(1) DEFAULT 1,
  `image` varchar(255) DEFAULT 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png',
  `genre` enum('Femelle','Mâle') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `animaux`
--

INSERT INTO `animaux` (`id`, `nom`, `espece`, `age`, `description`, `disponible`, `image`, `genre`) VALUES
(1, 'Max', 'Chien', 3, "Max est un chien de 3 ans, joueur et plein d\'énergie.", 0, 'https://images.unsplash.com/photo-1637256963450-8022c79ca8c1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTZ8fGFuaW1hbHMlMjBhZG9wdHxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=500&q=60', 'Mâle'),
(2, 'Milo', 'Chien', 2, 'Milo est un chien de 2 ans, calme et affectueux.', 0, 'https://images.unsplash.com/photo-1584303597973-0401cd1f9796?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80', 'Mâle'),
(3, 'Bella', 'Chien', 5, 'Bella est une chienne de 5 ans, obéissante et protectrice.', 0, 'https://images.unsplash.com/photo-1591911949558-2b0b620d545a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=701&q=80', 'Femelle'),
(4, 'Luna', 'Chat', 1, "Luna est une chatte d\'1 an, curieuse et joueuse.", 1, 'https://images.unsplash.com/photo-1574226214263-455edaee56b7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80', 'Femelle'),
(5, 'Mistigri', 'Chat', 3, 'Mistigri est un chat de 3 ans, indépendant et câlin.', 1, 'https://images.unsplash.com/photo-1542736143-29a8432162bc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80', 'Mâle'),
(6, 'Rocky', 'Chien', 5, 'Rocky est un chien de 5 ans, intelligent et loyal.', 1, 'https://images.unsplash.com/photo-1623986577948-aacb01ad336a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8YW5pbWFscyUyMGFkb3B0fGVufDB8fDB8fHww&auto=format&fit=crop&w=500&q=60', 'Mâle'),
(7, 'Daisy', 'Chien', 4, 'Daisy est une chienne de 4 ans, douce et sociable.', 1, 'https://images.unsplash.com/photo-1544567734-9db483604201?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=735&q=80', 'Femelle'),
(8, 'Coco', 'Chien', 2, 'Coco est un chien de 2 ans, espiègle et intelligent.', 1, 'https://images.unsplash.com/photo-1576177129483-466c459d2798?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80', 'Mâle'),
(9, 'Pumpkin', 'Chien', 1, "Pumpkin est un chien d\'1 an, joueur et joyeux.", 1, 'https://images.unsplash.com/photo-1600107716910-38703d32aee7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1175&q=80', 'Mâle');

-- --------------------------------------------------------

--
-- Structure de la table `connexion`
--

CREATE TABLE `connexion` (
  `id` int(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `demandes_adoption`
--

CREATE TABLE `demandes_adoption` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `connexion_id` int(11) NOT NULL,
  `date_demande` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `depots_adoption`
--

CREATE TABLE `depots_adoption` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) DEFAULT NULL,
  `connexion_id` int(11) DEFAULT NULL,
  `date_depot` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `details_animaux`
--

CREATE TABLE `details_animaux` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) DEFAULT NULL,
  `vaccinations` varchar(255) DEFAULT NULL,
  `comportement` text DEFAULT NULL,
  `conditions_adoption` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `details_animaux`
--

INSERT INTO `details_animaux` (`id`, `animal_id`, `vaccinations`, `comportement`, `conditions_adoption`) VALUES
(1, 1, 'Vaccin 1, Vaccin 2', 'Joueur et sociable', 'Famille avec jardin préférable'),
(2, 2, 'Vaccin 1A, Vaccin 1B', 'Joueur et sociable', 'Famille avec enfants'),
(3, 3, 'Vaccin 2A, Vaccin 2B', 'Calme et affectueux', 'Maison avec jardin'),
(4, 4, 'Vaccin 3A, Vaccin 3B', 'Énergique et espiègle', 'Personne seule ou couple'),
(5, 5, 'Vaccin 4A, Vaccin 4B', 'Timide et réservé', 'Environnement calme'),
(6, 6, 'Vaccin 5A, Vaccin 5B', 'Intelligent et curieux', 'Expérience avec les animaux'),
(7, 7, 'Vaccin 6A, Vaccin 6B', 'Protecteur et loyal', "Présence d\'autres animaux domestiques"),
(8, 8, 'Vaccin 7A, Vaccin 7B', 'Indépendant et distant', 'Suivi vétérinaire régulier requis'),
(9, 9, 'Vaccin 8A, Vaccin 8B', 'Docile et obéissant', 'Engagement à long terme');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `animaux`
--
ALTER TABLE `animaux`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `connexion`
--
ALTER TABLE `connexion`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `demandes_adoption`
--
ALTER TABLE `demandes_adoption`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`),
  ADD KEY `connexion_id` (`connexion_id`);

--
-- Index pour la table `depots_adoption`
--
ALTER TABLE `depots_adoption`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`),
  ADD KEY `connexion_id` (`connexion_id`);

--
-- Index pour la table `details_animaux`
--
ALTER TABLE `details_animaux`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `animaux`
--
ALTER TABLE `animaux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT pour la table `connexion`
--
ALTER TABLE `connexion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `demandes_adoption`
--
ALTER TABLE `demandes_adoption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `depots_adoption`
--
ALTER TABLE `depots_adoption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `details_animaux`
--
ALTER TABLE `details_animaux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `demandes_adoption`
--
ALTER TABLE `demandes_adoption`
  ADD CONSTRAINT `demandes_adoption_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animaux` (`id`),
  ADD CONSTRAINT `demandes_adoption_ibfk_2` FOREIGN KEY (`connexion_id`) REFERENCES `connexion` (`id`);

--
-- Contraintes pour la table `depots_adoption`
--
ALTER TABLE `depots_adoption`
  ADD CONSTRAINT `depots_adoption_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animaux` (`id`),
  ADD CONSTRAINT `depots_adoption_ibfk_2` FOREIGN KEY (`connexion_id`) REFERENCES `connexion` (`id`);

--
-- Contraintes pour la table `details_animaux`
--
ALTER TABLE `details_animaux`
  ADD CONSTRAINT `details_animaux_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animaux` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
