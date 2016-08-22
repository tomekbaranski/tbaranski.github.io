-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 06 Cze 2016, 22:30
-- Wersja serwera: 5.5.44-0ubuntu0.14.04.1
-- Wersja PHP: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `twitter`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment` text,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Zrzut danych tabeli `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `comment`, `creation_date`) VALUES
(32, 58, 17, 'True', '2016-06-06 08:32:53');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message` text,
  `is_read` tinyint(4) DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `receiver_id` (`receiver_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Zrzut danych tabeli `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `is_read`, `creation_date`) VALUES
(45, 17, 15, 'How are You?', 1, '2016-06-06 08:37:07');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `post_text` varchar(140) DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

--
-- Zrzut danych tabeli `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `post_text`, `creation_date`) VALUES
(51, 12, 'I know where Im going and I know the truth, and I dont have to be what you want me to be. Im free to be what I want.', '2016-02-01 09:20:12'),
(52, 13, 'Love all, trust a few, do wrong to none.', '2016-04-21 08:22:08'),
(53, 14, 'Efforts and courage are not enough without purpose and direction. ', '2016-05-10 08:22:59'),
(54, 15, 'Health is the greatest gift, contentment the greatest wealth, faithfulness the best relationship.', '2016-05-26 08:23:49'),
(55, 17, 'It does not matter how slowly you go as long as you do not stop.', '2016-05-30 04:37:40'),
(56, 12, 'I don''t have to be what you want me to be', '2016-06-01 16:38:49'),
(57, 13, 'Doubt thou the stars are fire, Doubt that the sun doth move. Doubt truth to be a liar, But never doubt I love', '2016-06-03 08:29:49'),
(58, 15, 'Three things cannot be long hidden: the sun, the moon, and the truth', '2016-06-06 05:29:49'),
(59, 17, 'Real knowledge is to know the extent of one''s ignorance', '2016-06-06 08:31:49');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `hassed_password` char(60) NOT NULL,
  `user_description` text,
  `is_active` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `login`, `hassed_password`, `user_description`, `is_active`) VALUES
(12, 'Muhammad Ali', '$2y$10$UUS81sk1FgJFNXsXBVNS8e05IMjxxkBQXM0Eh1eEqrNXMkTq1jRfe', '', 1),
(13, 'William Shakespeare', '$2y$10$C8Djt0Oi2DaQEBOc0cq7cu791gC6le3f109uup.ioS.prOnQahMuK', '', 1),
(14, 'John F. Kennedy', '$2y$10$3g4tpdWFR4GJEhUJRLwaLu6upZVZgS1pi1.MQfyccG7OKBcA9Yb6G', '', 1),
(15, 'Buddha', '$2y$10$lHt2.x4/0cdTV2/v7BkKgOOZonDcMrIQdytnSYNqPVa2YiJVnfsvG', '', 1),
(16, 'Theodore Roosevelt', '$2y$10$RXe09lU1QNK1hDrVBO7mDOuXkTFCFLyZp6MQjcEMA/CTGT7jovn1e', '', 1),
(17, 'Confucius', '$2y$10$Exliksdjr2KVTxfwlzkIVOiF.7DOpyQqU0PGJC5Zvl4ir3FnG9STe', '', 1);

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
