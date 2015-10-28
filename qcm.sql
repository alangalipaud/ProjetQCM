-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mer 28 Octobre 2015 à 16:55
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `qcm`
--
CREATE DATABASE IF NOT EXISTS `qcm` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `qcm`;

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `askForRandomQuestionsByTheme`(IN `numberOfQuestions` INT, IN `themeId` INT, IN `registrationId` INT)
    MODIFIES SQL DATA
INSERT INTO issueraffling (
SELECT DISTINCT null as id, 0 as 'isMarqueted', question.id as 'questionId', registrationId as 'registrationId'
FROM question 
INNER JOIN theme ON question.themeId = theme.id 
INNER JOIN section ON theme.id = section.themeId 
WHERE section.themeId = themeId 
ORDER BY RAND() LIMIT numberOfQuestions)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `creationOfUserTest`(IN `p_registrationId` INT)
    MODIFIES SQL DATA
BEGIN
	DECLARE v_finished INTEGER DEFAULT 0;
    DECLARE v_testId INTEGER DEFAULT 0;
	DECLARE v_themeId INTEGER DEFAULT 0;
	DECLARE v_issuerafflingId INTEGER DEFAULT 0;
	DECLARE v_timePassing INTEGER DEFAULT 0;
	DECLARE v_numberOfQuestionsAsked INTEGER DEFAULT 0;
 
	 -- declare cursor for employee email
	 DECLARE registration_cursor CURSOR FOR 
	 SELECT testId FROM registration where id = p_registrationId;
	 
	 DECLARE section_cursor CURSOR FOR 
	 SELECT themeId, numberOfQuestionsAsked FROM section WHERE testId = v_testId;
	 
	 DECLARE issueraffling_cursor CURSOR FOR 
	 Select id from issueraffling where registrationId = p_registrationId order by id asc limit 1;
	 
	 DECLARE test_cursor CURSOR FOR
	 select timePassing from test where id = v_testId;
	 
	 -- declare NOT FOUND handler
	 DECLARE CONTINUE HANDLER 
			FOR NOT FOUND SET v_finished = 1;
	 
	 OPEN registration_cursor;
		BEGIN
			get_testId: LOOP
	 
			FETCH registration_cursor INTO v_testId;
	 
				IF v_finished = 1 THEN 
					LEAVE get_testId;
				END IF;
	 
			END LOOP get_testId;
		END;
	 CLOSE registration_cursor;
	 
	 
	/* ************************************************ */
	
	
	SET v_finished = 0;
	 
	 OPEN section_cursor;
		BEGIN
			get_section: LOOP
	 
			IF v_finished = 1 THEN 
				LEAVE get_section;
			END IF;
			
			CALL askForRandomQuestionsByTheme(v_numberOfQuestionsAsked, v_themeId, p_registrationId);
			FETCH section_cursor INTO v_themeId, v_numberOfQuestionsAsked;
			
	 
			END LOOP get_section;
			END;
	 CLOSE section_cursor;
	 
	 /* ************************************************ */
	 
	 SET v_finished = 0;
	 
	 OPEN issueraffling_cursor;
	 BEGIN
	 get_id: LOOP
	 
	 FETCH issueraffling_cursor INTO v_issuerafflingId;
	 
	 IF v_finished = 1 THEN 
	 LEAVE get_id;
	 END IF;
	 
	 END LOOP get_id;
	 END;
	 CLOSE issueraffling_cursor;
	 
	 /* ************************************************ */
	 
	 SET v_finished = 0;
	 
	 OPEN test_cursor;
	 BEGIN
	 get_timePassing: LOOP
	 
	 FETCH test_cursor INTO v_timePassing;
	 
	 IF v_finished = 1 THEN 
	 LEAVE get_timePassing;
	 END IF;
	 
	 END LOOP get_timePassing;
	 END;
	 CLOSE test_cursor;
	 
	 
	 INSERT INTO currenttest VALUES (p_registrationId, v_issuerafflingId, v_timePassing,0);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `answer`
--

CREATE TABLE IF NOT EXISTS `answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wording` varchar(250) NOT NULL,
  `isValid` tinyint(1) NOT NULL,
  `questionId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_answer_question` (`questionId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Contenu de la table `answer`
--

INSERT INTO `answer` (`id`, `wording`, `isValid`, `questionId`) VALUES
(1, 'HttpServlet.doHead()', 0, 1),
(2, 'HttpServlet.doPost()', 1, 1),
(3, 'HttpServlet.doForm() ', 0, 1),
(4, 'ServletRequest.doGet()', 0, 1),
(5, 'ServletRequest.doPost()', 0, 1),
(6, 'ServletRequest.doForm()', 0, 1),
(7, 'Il redéfinit la méthode service().', 0, 2),
(8, 'Il redéfinit une méthode doXXX() (par ex. goGet ou doPost).', 1, 2),
(9, 'Il appelle la méthode service() depuis une méthode doXXX() (par ex. doGet() ou doPost()).', 0, 2),
(10, 'Il appelle la méthode service() depuis la méthode init().', 0, 2),
(11, 'Il n’a rien à faire…', 0, 2),
(12, 'HttpSession', 1, 4),
(13, 'ServletRequest', 1, 4),
(14, 'ServletResponse', 0, 4),
(15, 'ServletContext', 1, 4),
(16, 'ServletConfig', 0, 4),
(17, 'SessionConfig', 0, 4),
(18, 'Un nombre aléatoire. ', 0, 5),
(19, '<%= Math.random() ;> ', 0, 5),
(20, 'out.println("Math.random();") ; ', 0, 5),
(21, 'Elle n’affiche rien… (il manque le « % » dans « %> » + pas de « ; » dans ce tag).', 1, 5),
(22, '<@        > ', 0, 6),
(23, '<%        >', 1, 6),
(24, '<%=       >', 1, 6),
(25, '<%!       >', 0, 6),
(26, '<%$       >', 0, 6),
(27, 'La ligne 5 sera insérée dans la réponse mais pas la ligne 6.', 1, 7),
(28, 'Les lignes 5 et 6 seront insérées dans la réponse.', 0, 7),
(29, 'Les lignes 5 et 6 ne seront pas insérées dans la réponse.', 0, 7),
(30, 'La ligne 6 sera insérée dans la réponse mais pas la ligne 5.', 0, 7),
(31, '${Etudiant.nom}', 1, 8),
(32, '${Etudiant.getNom()}', 0, 8),
(33, '${sessionScope.Etudiant["nom"]}', 1, 8),
(34, '${session["Etudiant"].nom}', 0, 8),
(35, '3,5,7,8,', 0, 10),
(36, '[3,5,7,]', 1, 10),
(37, '[3,5,7,8,]', 0, 10),
(38, '[3,5,7]', 0, 10),
(39, '2,3,4,5,6,7,8', 0, 10);

-- --------------------------------------------------------

--
-- Structure de la table `answergiven`
--

CREATE TABLE IF NOT EXISTS `answergiven` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issueRafflingId` int(11) NOT NULL,
  `answerId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`issueRafflingId`,`answerId`),
  KEY `fk_answerGiven_answer` (`answerId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Contenu de la table `answergiven`
--

-- --------------------------------------------------------

--
-- Structure de la table `currenttest`
--

CREATE TABLE IF NOT EXISTS `currenttest` (
  `registrationId` int(11) NOT NULL,
  `issueRafflingId` int(11) DEFAULT NULL,
  `currentTime` time NOT NULL,
  `isCompleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`registrationId`),
  KEY `fk_currenttest_issueraffling` (`issueRafflingId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `currenttest`
--

INSERT INTO `currenttest` (`registrationId`, `issueRafflingId`, `currentTime`, `isCompleted`) VALUES
(6, 59, '00:10:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `issueraffling`
--

CREATE TABLE IF NOT EXISTS `issueraffling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isMarqueted` tinyint(1) NOT NULL,
  `questionId` int(11) DEFAULT NULL,
  `registrationId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_issueRaffling_question` (`questionId`),
  KEY `fk_issueRaffling_registration` (`registrationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Contenu de la table `issueraffling`
--

INSERT INTO `issueraffling` (`id`, `isMarqueted`, `questionId`, `registrationId`) VALUES
(58, 0, 1, 6),
(59, 0, 4, 6),
(61, 0, 8, 6),
(62, 0, 7, 6);

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wording` varchar(2048) NOT NULL,
  `themeId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_question_theme` (`themeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `question`
--

INSERT INTO `question` (`id`, `wording`, `themeId`) VALUES
(1, 'Quelles sont les méthodes utilisées par un servlet pour gérer les données envoyées par un client\r\nvia un formulaire HTML ?', 1),
(2, 'Comment un développeur gère-t-il la méthode service() de son servlet, lorsque ce dernier étend\r\nHttpServlet ? ', 1),
(4, 'Sur quels types d’objets peut-on utiliser les méthodes getAttribute() et setAttribute() ?', 1),
(5, ' Soit le code suivant :\r\n\r\n<html>\r\n <body>\r\nLe chiffre à deviner est : <%= Math.random();>\r\n </body>\r\n</html>\r\n\r\nQu’affiche cette JSP à la suite de « Le chiffre à deviner est : » ?', 2),
(6, 'Parmi les balises suivantes quelles sont celles que l’on peut utiliser dans une JSP pour afficher la\r\nvaleur d’une expression Java sur la sortie ?\r\n', 2),
(7, 'Soit le code de la JSP test.jsp suivant :\r\n\r\n1 <html>\r\n2 <head><title>A Comment Test</title></head>\r\n3 <body>\r\n4 <h2>A Test of Comments</h2>\r\n5 <!-- This is Html Hidden Comment -->\r\n6 <%-- This is JSP Hidden Comment --%>\r\n7 </body>\r\n8 </html>\r\n\r\nA l’exécution de test.jsp, devinez quel sera la sortie correspondante ?', 2),
(8, 'Quelle(s) sont(est) les EL valables qui permettent de retourner la property « nom » du bean\r\nEtudiant ayant pour scope la session :', 2),
(10, 'Qu’affiche le code suivant ?\r\n\r\n<c:forEach step="2" begin="3" end="8" varStatus="status">\r\n<c:if test="${status.first}">[</c:if>\r\n${status.index},\r\n<c:if test="${status.last}">]</c:if>\r\n</c:forEach>', 2);

-- --------------------------------------------------------

--
-- Structure de la table `registration`
--

CREATE TABLE IF NOT EXISTS `registration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `testId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_registration_user` (`userId`),
  KEY `fk_registration_test` (`testId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `registration`
--

INSERT INTO `registration` (`id`, `startDate`, `endDate`, `userId`, `testId`) VALUES
(1, '2015-10-22 14:00:00', '2016-10-22 14:00:00', 1, 1),
(5, '2015-10-26 00:00:00', '2016-10-26 00:00:00', 1, 1),
(6, '2015-10-26 00:00:00', '2016-10-26 00:00:00', 6, 1);

--
-- Déclencheurs `registration`
--
DROP TRIGGER IF EXISTS `trigger_insert_into_registration`;
DELIMITER //
CREATE TRIGGER `trigger_insert_into_registration` AFTER INSERT ON `registration`
 FOR EACH ROW BEGIN
	CALL creationOfUserTest(NEW.id);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `section`
--

CREATE TABLE IF NOT EXISTS `section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `themeId` int(11) NOT NULL,
  `testId` int(11) NOT NULL,
  `numberOfQuestionsAsked` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`themeId`,`testId`),
  KEY `IDX_2D737AEF31B588BA` (`testId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `section`
--

INSERT INTO `section` (`id`, `themeId`, `testId`, `numberOfQuestionsAsked`) VALUES
(1, 1, 1, 2),
(2, 2, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wording` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `status`
--

INSERT INTO `status` (`id`, `wording`) VALUES
(1, 'stagiaire'),
(2, 'formateur');

-- --------------------------------------------------------

--
-- Structure de la table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `timePassing` time NOT NULL,
  `description` varchar(2048) DEFAULT NULL,
  `step1` double NOT NULL,
  `step2` double NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `test`
--

INSERT INTO `test` (`id`, `name`, `timePassing`, `description`, `step1`, `step2`) VALUES
(1, 'Java EE - Débutant', '00:10:00', 'Le terme « Java EE » signifie Java Enterprise Edition, et était anciennement raccourci en « J2EE ». Il fait quant à lui référence à une extension de la plate-forme standard. Autrement dit, la plate-forme Java EE est construite sur le langage Java et la plate-forme Java SE, et elle y ajoute un grand nombre de bibliothèques remplissant tout un tas de fonctionnalités que la plate-forme standard ne remplit pas d''origine. L''objectif majeur de Java EE est de faciliter le développement d''applications web robustes et distribuées, déployées et exécutées sur un serveur d''applications.', 40, 70);

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

CREATE TABLE IF NOT EXISTS `theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `theme`
--

INSERT INTO `theme` (`id`, `name`) VALUES
(1, 'Méthodes de base en Java EE'),
(2, 'JSP');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastName` varchar(50) DEFAULT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `mail` varchar(128) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `statusId` int(11) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `username_canonical` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_canonical` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_status` (`statusId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `lastName`, `firstName`, `mail`, `password`, `statusId`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`) VALUES
(1, 'stagiaire', 'ENI', 'stagiaire@eni.fr', 'E239F67756BBA3AF660E4226C340183A9CA4BDC40038C0CFDEA2FBAA59605BE32548DF2535E5A9F9CEEDB12D9666C6FB153ADA99830ED5CD84EB0C2C4D00260A', 1, 'stagiaire', '', 'stagiaire@eni.fr', '', 0, '', NULL, 0, 0, NULL, NULL, NULL, '', 0, NULL),
(2, 'formateur', 'ENI', 'formateur@eni.fr', 'Pa$$w0rd', 2, '', '', 'formateur@eni.fr', '', 0, '', NULL, 0, 0, NULL, NULL, NULL, '', 0, NULL),
(6, NULL, NULL, NULL, '$2y$13$po4c6qaiwc0owccs80kooelguqCFbQoczvdlwzAr12G20Luf3xobi', NULL, 'toto', 'toto', 'toto@toto.com', 'toto@toto.com', 1, 'po4c6qaiwc0owccs80koogc8gcg4wos', '2015-10-27 09:02:54', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `fk_answer_question` FOREIGN KEY (`questionId`) REFERENCES `question` (`id`);

--
-- Contraintes pour la table `answergiven`
--
ALTER TABLE `answergiven`
  ADD CONSTRAINT `fk_answerGiven_answer` FOREIGN KEY (`answerId`) REFERENCES `answer` (`id`),
  ADD CONSTRAINT `fk_answerGiven_issueRaffling` FOREIGN KEY (`issueRafflingId`) REFERENCES `issueraffling` (`id`);

--
-- Contraintes pour la table `currenttest`
--
ALTER TABLE `currenttest`
  ADD CONSTRAINT `fk_currenttest_issueraffling` FOREIGN KEY (`issueRafflingId`) REFERENCES `issueraffling` (`id`),
  ADD CONSTRAINT `fk_currenttest_registration` FOREIGN KEY (`registrationId`) REFERENCES `registration` (`id`);

--
-- Contraintes pour la table `issueraffling`
--
ALTER TABLE `issueraffling`
  ADD CONSTRAINT `fk_issueRaffling_question` FOREIGN KEY (`questionId`) REFERENCES `question` (`id`),
  ADD CONSTRAINT `fk_issueRaffling_registration` FOREIGN KEY (`registrationId`) REFERENCES `registration` (`id`);

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `fk_question_theme` FOREIGN KEY (`themeId`) REFERENCES `theme` (`id`);

--
-- Contraintes pour la table `registration`
--
ALTER TABLE `registration`
  ADD CONSTRAINT `fk_registration_test` FOREIGN KEY (`testId`) REFERENCES `test` (`id`),
  ADD CONSTRAINT `fk_registration_user` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `fk_section_test` FOREIGN KEY (`testId`) REFERENCES `test` (`id`),
  ADD CONSTRAINT `fk_section_theme` FOREIGN KEY (`themeId`) REFERENCES `theme` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_status` FOREIGN KEY (`statusId`) REFERENCES `status` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
