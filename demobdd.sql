SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `demobd`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nomutilisateur` varchar(255) NOT NULL,
  `motdepasse` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `admin`
--

INSERT INTO `admin` (`id`, `nomutilisateur`, `motdepasse`) VALUES
(1, 'Admin', 'ab4f63f9ac65152575886860dde480a1');

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `idauteur` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `articles`
--

INSERT INTO `articles` (`id`, `idauteur`, `titre`, `contenu`) VALUES
(1, 1, 'Mon premier article', '<p>Quelle serait selon vous la voiture idéale pour un Hacker ?</p>'),
(2, 1, 'Les femmes Hackers', '<p>De nombreuses femmes sont connues pour leurs exploits. </p>'),
(3, 1, 'Tempus ullamcorper', '<p>Et harum quidem rerum facilis est et expedita distinctio. </p>'),
(4, 1, 'Sed etiam facilis', '<p>Curabitur rhoncus lacus maximus, bibendum sapien ut. </p>'),
(5, 1, 'Feugiat lorem aenean', '<p>Nulla auctor egestas mi sed mattis. Donec pellentesque.</p>'),
(6, 1, 'Amet varius aliquam', '<p>Nulla non lacus condimentum, pretium tortor id. </p>');

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` int(11) NOT NULL,
  `idarticle` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `commentaire` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `commentaires`
--

INSERT INTO `commentaires` (`id`, `idarticle`, `pseudo`, `commentaire`) VALUES
(1, 1, 'Trolleur', 'Un hacker ne conduit pas, il pirate les voitures à distance.'),
(2, 6, 'Trolleur', 'rien compris...');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE USER 'demoutilisateur'@'localhost' IDENTIFIED BY 'Mdp@Ass3zSécuris3';
GRANT ALL PRIVILEGES ON demobd.* To 'demoutilisateur'@'localhost';
FLUSH PRIVILEGES;
