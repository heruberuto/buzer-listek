-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE `fulfillment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day` date NOT NULL COMMENT 'Den v buzer-lístku',
  `value` varchar(255) NOT NULL COMMENT 'Hodnota',
  `habit_id` int(11) NOT NULL COMMENT 'Návyk',
  `note` varchar(255) DEFAULT NULL COMMENT 'Poznámka',
  `excused` tinyint(1) NOT NULL COMMENT 'Nesplněno z objektivních důvodů',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Čas vytvoření',
  PRIMARY KEY (`id`),
  UNIQUE KEY `habit_id_day` (`habit_id`,`day`),
  KEY `idx_fulfillment__habit_id` (`habit_id`),
  KEY `day` (`day`),
  CONSTRAINT `fulfillment_ibfk_1` FOREIGN KEY (`habit_id`) REFERENCES `habit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabulka plnění návyků';


CREATE TABLE `habit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT 'Návyk',
  `condition_json` json DEFAULT NULL COMMENT 'Podmínka splnění',
  `note` varchar(255) DEFAULT NULL COMMENT 'Poznámka',
  `habit_list_id` int(11) NOT NULL COMMENT 'Buzer-lístek',
  `order` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'Pořadí',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Čas vytvoření',
  PRIMARY KEY (`id`),
  KEY `idx_habit__habit_list_id` (`habit_list_id`),
  KEY `order` (`order`),
  CONSTRAINT `habit_ibfk_1` FOREIGN KEY (`habit_list_id`) REFERENCES `habit_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabulka návyků ve sloupcích buzer-lístku';


CREATE TABLE `habit_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'Uživatel',
  `since` date NOT NULL COMMENT 'Začátek',
  `until` date NOT NULL COMMENT 'Konec',
  `note` varchar(255) DEFAULT NULL COMMENT 'Poznámka',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Čas vytvoření',
  PRIMARY KEY (`id`),
  KEY `idx_habit_list__user_id` (`user_id`),
  CONSTRAINT `habit_list_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabulka buzer-lístků uživatel';


CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL COMMENT 'E-mail',
  `password` varchar(64) NOT NULL COMMENT 'Heslo',
  `auth_key` varchar(32) NOT NULL COMMENT 'Autorizační klíč (Yii2)',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Čas registrace',
  `has_admin_rights` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Administrátorské oprávnění',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabulka uživatel systému';


-- 2018-01-16 22:36:37
