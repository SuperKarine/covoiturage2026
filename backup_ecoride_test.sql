-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : db-test:3306
-- Généré le : mar. 26 mai 2026 à 19:06
-- Version du serveur : 10.11.13-MariaDB-ubu2204
-- Version de PHP : 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecoride2026Test`
--

-- --------------------------------------------------------

--
-- Structure de la table `Compte`
--

CREATE TABLE `Compte` (
  `id_compte` int(11) NOT NULL,
  `date_creation` datetime NOT NULL,
  `solde` float NOT NULL,
  `id_utilisateurs` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Compte`
--

INSERT INTO `Compte` (`id_compte`, `date_creation`, `solde`, `id_utilisateurs`) VALUES
(1, '2026-04-20 09:00:00', 0, 1),
(2, '2026-04-20 09:10:10', 25.5, 2),
(3, '2026-04-20 09:20:06', 12, 3),
(4, '2026-04-20 10:03:02', 40.75, 4),
(5, '2026-04-20 11:04:14', 8.2, 5),
(6, '2026-04-20 10:17:53', 0, 6),
(7, '2026-04-20 10:18:53', 0, 7);

-- --------------------------------------------------------

--
-- Structure de la table `DistanceVille`
--

CREATE TABLE `DistanceVille` (
  `id_distance_ville` int(11) NOT NULL,
  `id_ville_depart` int(11) NOT NULL,
  `id_ville_arrivee` int(11) NOT NULL,
  `km` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `DistanceVille`
--

INSERT INTO `DistanceVille` (`id_distance_ville`, `id_ville_depart`, `id_ville_arrivee`, `km`) VALUES
(1, 1, 2, 140),
(2, 2, 4, 200),
(3, 1, 3, 110),
(4, 1, 4, 75),
(5, 3, 6, 35),
(6, 1, 5, 52),
(7, 5, 2, 61),
(8, 11, 1, 40),
(9, 12, 1, 35),
(10, 2, 7, 80),
(11, 2, 8, 60),
(12, 8, 9, 55),
(13, 1, 10, 52),
(14, 10, 11, 33);

-- --------------------------------------------------------

--
-- Structure de la table `MessagerieMail`
--

CREATE TABLE `MessagerieMail` (
  `id_messagerie_mail` int(11) NOT NULL,
  `type` enum('inscription','reset','compte','Autre') NOT NULL,
  `Sujet` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `date_envoi` datetime NOT NULL,
  `statut` enum('envoye','Brouillon','reçu') NOT NULL,
  `id_utilisateurs` int(11) NOT NULL,
  `id_reservation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Messagerie mail pour inscription et validation reservation';

--
-- Déchargement des données de la table `MessagerieMail`
--

INSERT INTO `MessagerieMail` (`id_messagerie_mail`, `type`, `Sujet`, `contenu`, `date_envoi`, `statut`, `id_utilisateurs`, `id_reservation`) VALUES
(1, 'inscription', 'Inscription', 'Bienvenue sur Covoiturage2026,\r\nVotre inscription est confirmée. Vous pouvez dès maintenant réserver ou proposer des trajets.', '2026-04-20 10:15:18', 'envoye', 1, NULL),
(2, 'inscription', 'Inscription', 'Confirmation de création de compte,\r\nMerci pour votre inscription. Votre compte utilisateur est actif.', '2026-04-20 10:20:40', 'envoye', 2, NULL),
(3, 'reset', 'Réinitialisation mot de passe', 'Cliquez sur le lien pour réinitialiser votre mot de passe. Le lien expire dans 30 minutes.\r\n ', '2026-04-21 09:00:00', 'envoye', 3, NULL),
(4, 'compte', 'Modification de votre profil', 'Votre profil utilisateur a bien été mis à jour.\r\n ', '2026-04-21 12:30:53', 'envoye', 4, NULL),
(5, 'Autre', 'Bienvenue dans l’équipe covoiturage', 'Nous sommes heureux de vous compter parmi nos utilisateurs actifs.\r\n', '2026-04-21 18:00:00', 'envoye', 5, NULL),
(6, 'compte', 'Vérification de votre compte', 'Merci de vérifier votre adresse email pour activer toutes les fonctionnalités.', '2026-04-22 08:45:39', 'envoye', 1, NULL),
(7, 'inscription', 'Compte validé avec succès', 'Votre compte a été validé. Bon voyage sur Covoiturage2026 !', '2026-04-22 14:23:52', 'envoye', 2, 7),
(8, 'compte', 'Réservation confirmée', 'Votre réservation de trajet Lille → Amiens a bien été confirmée.', '2026-04-22 14:26:12', 'envoye', 3, 8),
(9, 'compte', 'Annulation de réservation', 'Votre réservation pour le trajet Amiens → Calais a été annulée.\r\n', '2026-04-22 16:27:22', 'envoye', 3, 9),
(10, 'Autre', 'Rappel de trajet', 'N’oubliez pas votre trajet prévu demain matin. Soyez à l’heure au point de rendez-vous.', '2026-04-23 07:29:00', 'envoye', 4, 10);

-- --------------------------------------------------------

--
-- Structure de la table `Notes`
--

CREATE TABLE `Notes` (
  `id_note` int(11) NOT NULL,
  `note` int(11) DEFAULT NULL,
  `id_utilisateurs` int(11) NOT NULL,
  `id_trajet` int(11) NOT NULL,
  `id_auteur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='passager donne note au chauffeur';

--
-- Déchargement des données de la table `Notes`
--

INSERT INTO `Notes` (`id_note`, `note`, `id_utilisateurs`, `id_trajet`, `id_auteur`) VALUES
(1, 5, 6, 1, 2),
(2, 4, 6, 1, 3),
(3, 5, 7, 2, 4),
(4, 3, 7, 2, 5),
(5, 4, 6, 3, 2),
(6, 5, 6, 3, 4),
(7, 4, 7, 4, 3);

-- --------------------------------------------------------

--
-- Structure de la table `Reservation`
--

CREATE TABLE `Reservation` (
  `id_reservation` int(11) NOT NULL,
  `status` enum('en attente','valide','annulée') NOT NULL,
  `date_reservation` datetime NOT NULL,
  `id_trajet` int(11) NOT NULL,
  `id_utilisateurs` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='réserver un trajet';

--
-- Déchargement des données de la table `Reservation`
--

INSERT INTO `Reservation` (`id_reservation`, `status`, `date_reservation`, `id_trajet`, `id_utilisateurs`) VALUES
(7, 'valide', '2026-04-20 10:00:36', 1, 2),
(8, 'en attente', '2026-04-20 10:05:33', 2, 3),
(9, 'valide', '2026-04-20 10:10:21', 3, 4),
(10, 'annulée', '2026-04-20 10:15:02', 4, 5),
(11, 'valide', '2026-04-20 10:20:48', 5, 2);

-- --------------------------------------------------------

--
-- Structure de la table `Role`
--

CREATE TABLE `Role` (
  `id_role` int(11) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Role`
--

INSERT INTO `Role` (`id_role`, `name`) VALUES
(1, 'Admin'),
(2, 'passager'),
(3, 'chauffeur');

-- --------------------------------------------------------

--
-- Structure de la table `Trajets`
--

CREATE TABLE `Trajets` (
  `id_trajet` int(11) NOT NULL,
  `nbr_places_dispo` int(11) NOT NULL,
  `fumeur` tinyint(1) NOT NULL,
  `animaux` tinyint(1) NOT NULL,
  `prix` float NOT NULL,
  `date_depart` datetime NOT NULL,
  `id_utilisateurs` int(11) NOT NULL,
  `id_ville_depart` int(11) NOT NULL,
  `id_ville_arrivee` int(11) NOT NULL,
  `id_voiture` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Trajets`
--

INSERT INTO `Trajets` (`id_trajet`, `nbr_places_dispo`, `fumeur`, `animaux`, `prix`, `date_depart`, `id_utilisateurs`, `id_ville_depart`, `id_ville_arrivee`, `id_voiture`) VALUES
(1, 3, 0, 1, 15, '2026-04-25 08:00:08', 6, 1, 2, 1),
(2, 2, 0, 0, 18.5, '2026-04-25 09:30:23', 7, 2, 3, 2),
(3, 4, 1, 1, 10, '2026-04-26 07:46:42', 6, 1, 4, 1),
(4, 3, 0, 1, 10, '2026-04-26 16:49:58', 7, 4, 1, 2),
(5, 2, 0, 0, 17, '2026-04-27 10:51:30', 6, 3, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Transactions`
--

CREATE TABLE `Transactions` (
  `id_transactions` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `statut` enum('validé','en attente','annulée') NOT NULL,
  `type` enum('debit','credit') NOT NULL,
  `montant` float NOT NULL,
  `id_compte_source` int(11) NOT NULL,
  `id_compte_destination` int(11) NOT NULL,
  `id_reservation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='pour débiter un passager et créditer un chauffeur par rappor';

--
-- Déchargement des données de la table `Transactions`
--

INSERT INTO `Transactions` (`id_transactions`, `date`, `statut`, `type`, `montant`, `id_compte_source`, `id_compte_destination`, `id_reservation`) VALUES
(1, '2026-04-20 10:05:17', 'validé', 'debit', 15, 1, 2, 7),
(2, '2026-04-20 11:46:25', 'validé', 'credit', 15, 2, 1, 7),
(3, '2026-04-20 10:07:24', 'en attente', 'debit', 15, 3, 2, 8),
(4, '2026-04-20 10:49:33', 'validé', 'debit', 18.5, 2, 3, 8),
(5, '2026-04-20 10:50:43', 'validé', 'credit', 18.5, 4, 3, 9),
(6, '2026-04-20 11:52:05', 'annulée', 'debit', 18.5, 3, 4, 9),
(7, '2026-04-20 10:53:16', 'validé', 'debit', 10, 5, 4, 10),
(8, '2026-04-20 10:55:01', 'validé', 'credit', 10, 4, 5, 10),
(9, '2026-04-20 17:56:02', 'en attente', 'debit', 10, 2, 5, 11);

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateurs`
--

CREATE TABLE `Utilisateurs` (
  `id_utilisateurs` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `mail` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `confirmation_token` varchar(100) DEFAULT NULL,
  `is_confirmed` tinyint(1) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `id_compte` int(11) NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Table des utilisateurs';

--
-- Déchargement des données de la table `Utilisateurs`
--

INSERT INTO `Utilisateurs` (`id_utilisateurs`, `nom`, `prenom`, `username`, `mail`, `password`, `confirmation_token`, `is_confirmed`, `tel`, `id_compte`, `id_role`) VALUES
(1, 'Admin', 'Systeme', 'sysad', 'admin@covoiturage2026.fr', '$2y$10$abcdefghijklmnopqrstuv', NULL, 0, '600000001', 1, 1),
(2, 'Dupont', 'Jean', 'jeadu', 'jean.dupont@mail.com', '$2y$10$abcdefghijklmnopqrstuv', NULL, 0, '600000002', 2, 2),
(3, 'Martin', 'Claire', 'claima', 'claire.martin@mail.com', '$2y$10$abcdefghijklmnopqrstuv', NULL, 0, '600000003', 3, 2),
(4, 'Bernard', 'Lucas', 'luber', 'lucas.bernard@mail.com', '$2y$10$abcdefghijklmnopqrstuv', NULL, 0, '600000004', 4, 2),
(5, 'Petit', 'Sophie', 'sopet', 'sophie.petit@mail.com', '$2y$10$abcdefghijklmnopqrstuv', NULL, 0, '600000005', 5, 2),
(6, 'Durand', 'Marc', 'madur', 'marc.durand@mail.com', '$2y$10$hash', NULL, 0, '600000006', 6, 3),
(7, 'Moreau', 'Julie', 'jumo', 'julie.moreau@mail.com', '$2y$10$hash', NULL, 0, '600000007', 7, 3);

-- --------------------------------------------------------

--
-- Structure de la table `Ville`
--

CREATE TABLE `Ville` (
  `id_ville` int(11) NOT NULL,
  `nom` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Ville`
--

INSERT INTO `Ville` (`id_ville`, `nom`) VALUES
(1, 'Lille'),
(2, 'Amiens'),
(3, 'Calais'),
(4, 'Dunkerque'),
(5, 'Arras'),
(6, 'Boulogne-sur-mer'),
(7, 'Saint-Quentin'),
(8, 'Beauvais'),
(9, 'Compiègne'),
(10, 'Valenciennes'),
(11, 'Douai'),
(12, 'Lens');

-- --------------------------------------------------------

--
-- Structure de la table `Voitures`
--

CREATE TABLE `Voitures` (
  `id_voiture` int(11) NOT NULL,
  `marque` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `nbr_places` int(11) NOT NULL,
  `id_utilisateurs` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Les voitures des utilisateurs ';

--
-- Déchargement des données de la table `Voitures`
--

INSERT INTO `Voitures` (`id_voiture`, `marque`, `model`, `nbr_places`, `id_utilisateurs`) VALUES
(1, 'Dacia', 'Sandero', 4, 6),
(2, 'peugeot', '308', 5, 7),
(3, 'Toyota', 'Yaris', 4, 6),
(4, 'Volkswagen', 'Golf', 5, 7);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Compte`
--
ALTER TABLE `Compte`
  ADD PRIMARY KEY (`id_compte`),
  ADD KEY `id_utilisateurs` (`id_utilisateurs`);

--
-- Index pour la table `DistanceVille`
--
ALTER TABLE `DistanceVille`
  ADD PRIMARY KEY (`id_distance_ville`),
  ADD KEY `id_ville_depart` (`id_ville_depart`),
  ADD KEY `id_ville_arrivee` (`id_ville_arrivee`);

--
-- Index pour la table `MessagerieMail`
--
ALTER TABLE `MessagerieMail`
  ADD PRIMARY KEY (`id_messagerie_mail`),
  ADD KEY `id_reservation` (`id_reservation`),
  ADD KEY `id_utilisateurs` (`id_utilisateurs`);

--
-- Index pour la table `Notes`
--
ALTER TABLE `Notes`
  ADD KEY `id_utilisateurs` (`id_utilisateurs`),
  ADD KEY `id_trajet` (`id_trajet`),
  ADD KEY `id_auteur` (`id_auteur`);

--
-- Index pour la table `Reservation`
--
ALTER TABLE `Reservation`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `id_trajet` (`id_trajet`),
  ADD KEY `id_utilisateurs` (`id_utilisateurs`);

--
-- Index pour la table `Role`
--
ALTER TABLE `Role`
  ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `Trajets`
--
ALTER TABLE `Trajets`
  ADD PRIMARY KEY (`id_trajet`),
  ADD KEY `id_utilisateurs` (`id_utilisateurs`),
  ADD KEY `id_ville_depart` (`id_ville_depart`),
  ADD KEY `id_ville_arrivee` (`id_ville_arrivee`),
  ADD KEY `id_voiture` (`id_voiture`);

--
-- Index pour la table `Transactions`
--
ALTER TABLE `Transactions`
  ADD KEY `id_compte_source` (`id_compte_source`),
  ADD KEY `id_compte_destination` (`id_compte_destination`),
  ADD KEY `id_reservation` (`id_reservation`);

--
-- Index pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  ADD PRIMARY KEY (`id_utilisateurs`),
  ADD KEY `id_compte` (`id_compte`),
  ADD KEY `id_role` (`id_role`);

--
-- Index pour la table `Ville`
--
ALTER TABLE `Ville`
  ADD PRIMARY KEY (`id_ville`);

--
-- Index pour la table `Voitures`
--
ALTER TABLE `Voitures`
  ADD PRIMARY KEY (`id_voiture`),
  ADD KEY `id_utilisateurs` (`id_utilisateurs`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Compte`
--
ALTER TABLE `Compte`
  MODIFY `id_compte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `DistanceVille`
--
ALTER TABLE `DistanceVille`
  MODIFY `id_distance_ville` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `MessagerieMail`
--
ALTER TABLE `MessagerieMail`
  MODIFY `id_messagerie_mail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `Reservation`
--
ALTER TABLE `Reservation`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `Role`
--
ALTER TABLE `Role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `Trajets`
--
ALTER TABLE `Trajets`
  MODIFY `id_trajet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  MODIFY `id_utilisateurs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `Ville`
--
ALTER TABLE `Ville`
  MODIFY `id_ville` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `Voitures`
--
ALTER TABLE `Voitures`
  MODIFY `id_voiture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Compte`
--
ALTER TABLE `Compte`
  ADD CONSTRAINT `Compte_ibfk_1` FOREIGN KEY (`id_utilisateurs`) REFERENCES `Utilisateurs` (`id_utilisateurs`);

--
-- Contraintes pour la table `DistanceVille`
--
ALTER TABLE `DistanceVille`
  ADD CONSTRAINT `DistanceVille_ibfk_1` FOREIGN KEY (`id_ville_depart`) REFERENCES `Ville` (`id_ville`),
  ADD CONSTRAINT `DistanceVille_ibfk_2` FOREIGN KEY (`id_ville_arrivee`) REFERENCES `Ville` (`id_ville`);

--
-- Contraintes pour la table `MessagerieMail`
--
ALTER TABLE `MessagerieMail`
  ADD CONSTRAINT `MessagerieMail_ibfk_1` FOREIGN KEY (`id_reservation`) REFERENCES `Reservation` (`id_reservation`),
  ADD CONSTRAINT `MessagerieMail_ibfk_2` FOREIGN KEY (`id_utilisateurs`) REFERENCES `Utilisateurs` (`id_utilisateurs`);

--
-- Contraintes pour la table `Notes`
--
ALTER TABLE `Notes`
  ADD CONSTRAINT `Notes_ibfk_1` FOREIGN KEY (`id_utilisateurs`) REFERENCES `Utilisateurs` (`id_utilisateurs`),
  ADD CONSTRAINT `Notes_ibfk_2` FOREIGN KEY (`id_trajet`) REFERENCES `Trajets` (`id_trajet`),
  ADD CONSTRAINT `Notes_ibfk_3` FOREIGN KEY (`id_auteur`) REFERENCES `Utilisateurs` (`id_utilisateurs`);

--
-- Contraintes pour la table `Reservation`
--
ALTER TABLE `Reservation`
  ADD CONSTRAINT `Reservation_ibfk_1` FOREIGN KEY (`id_trajet`) REFERENCES `Trajets` (`id_trajet`),
  ADD CONSTRAINT `Reservation_ibfk_2` FOREIGN KEY (`id_utilisateurs`) REFERENCES `Utilisateurs` (`id_utilisateurs`);

--
-- Contraintes pour la table `Trajets`
--
ALTER TABLE `Trajets`
  ADD CONSTRAINT `Trajets_ibfk_1` FOREIGN KEY (`id_utilisateurs`) REFERENCES `Utilisateurs` (`id_utilisateurs`),
  ADD CONSTRAINT `Trajets_ibfk_2` FOREIGN KEY (`id_ville_depart`) REFERENCES `Ville` (`id_ville`),
  ADD CONSTRAINT `Trajets_ibfk_3` FOREIGN KEY (`id_ville_arrivee`) REFERENCES `Ville` (`id_ville`),
  ADD CONSTRAINT `Trajets_ibfk_4` FOREIGN KEY (`id_voiture`) REFERENCES `Voitures` (`id_voiture`);

--
-- Contraintes pour la table `Transactions`
--
ALTER TABLE `Transactions`
  ADD CONSTRAINT `Transactions_ibfk_1` FOREIGN KEY (`id_compte_source`) REFERENCES `Compte` (`id_compte`),
  ADD CONSTRAINT `Transactions_ibfk_2` FOREIGN KEY (`id_compte_destination`) REFERENCES `Compte` (`id_compte`),
  ADD CONSTRAINT `Transactions_ibfk_3` FOREIGN KEY (`id_reservation`) REFERENCES `Reservation` (`id_reservation`);

--
-- Contraintes pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  ADD CONSTRAINT `Utilisateurs_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `Compte` (`id_compte`),
  ADD CONSTRAINT `Utilisateurs_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `Role` (`id_role`);

--
-- Contraintes pour la table `Voitures`
--
ALTER TABLE `Voitures`
  ADD CONSTRAINT `Voitures_ibfk_1` FOREIGN KEY (`id_utilisateurs`) REFERENCES `Utilisateurs` (`id_utilisateurs`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
