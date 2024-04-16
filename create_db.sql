CREATE DATABASE IF NOT EXISTS goods;

USE goods;

DROP TABLE IF EXISTS products;

CREATE TABLE `products` (
    `id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `sku` VARCHAR(255) NOT NULL DEFAULT '00000',
    `name` VARCHAR(255) NOT NULL,
    `price` DECIMAL(6,2) NOT NULL DEFAULT 0.0)
    ENGINE=MyISAM
    DEFAULT CHARSET=utf8;

LOCK TABLES `products` WRITE;

INSERT INTO `products` (`sku`, `name`, `price`) VALUES
	('JVC200123', 'Acme DISC', 1.00),
	('JVC200124', 'Acme DISC', 1.32),
	('JVC200125', 'SONY DISC', 1.50),
	('JVC200140', 'BASF DISC', 2.70),
	('GGWP0007', 'War and World', 20.00),
	('GGEO0008', 'Eugeny Onegin', 15.67),
	('GGZP0009', 'Fathers and Childrens', 50.00),
	('GGAM0010', 'Great Gatsby', 120.00),
	('TR120555', 'Chair', 39.99),
	('TR120556', 'Door', 140.89),
	('TR120557', 'Bed', 399.99),
	('TR120558', 'Table', 70.00);

UNLOCK TABLES;

DROP TABLE IF EXISTS types;

CREATE TABLE `types` (
    `id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `prod_descr` VARCHAR(255) NOT NULL,
    `attribute` VARCHAR(255) NOT NULL)
    ENGINE=MyISAM
    DEFAULT CHARSET=utf8;

LOCK TABLES `types` WRITE;

INSERT INTO `types` (`name`, `prod_descr`, `attribute`) VALUES
	('DVD', 'Please, provide size', 'Size'),
	('Book', 'Please, provide weight', 'Weight'),
	('Furniture', 'Please, provide dimensions', 'Dimension');

UNLOCK TABLES;

DROP TABLE IF EXISTS `fields`;

CREATE TABLE `fields` (
    `id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(128) NOT NULL,
    `units` VARCHAR(128) NOT NULL)
    ENGINE=MyISAM
    DEFAULT CHARSET=utf8;

LOCK TABLES `fields` WRITE;

INSERT INTO `fields` (`name`, `units`) VALUES
	('Size', '(MB)'),
	('Weight', '(KG)'),
	('Height', '(CM)'),
	('Width', '(CM)'),
	('Length', '(CM)');

UNLOCK TABLES;

DROP TABLE IF EXISTS `attributes`;

CREATE TABLE `attributes` (
    `prod_id` INT(10) NOT NULL,
    `fields_id` INT(10) NOT NULL,
    `value` INT(10) NOT NULL,
    FOREIGN KEY (`prod_id`) REFERENCES products(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`fields_id`) REFERENCES fields(`id`) ON DELETE CASCADE)
    ENGINE=MyISAM
    DEFAULT CHARSET=utf8;

LOCK TABLES `attributes` WRITE;

INSERT INTO `attributes` (`prod_id`, `fields_id`, `value`) VALUES
	(1, 1, 700),
	(2, 1, 650),
	(3, 1, 250),
	(4, 1, 700),
	(5, 2, 2),
	(6, 2, 1),
	(7, 2, 3),
	(8, 2, 2),
	(9, 3, 24),
	(9, 4, 45),
	(9, 5, 45),
	(10, 3, 60),
	(10, 4, 90),
	(10, 5, 10),
	(11, 3, 60),
	(11, 4, 45),
	(11, 5, 90),
	(12, 3, 50),
	(12, 4, 100),
	(12, 5, 50);

UNLOCK TABLES;

DROP TABLE IF EXISTS `type_fields`;

CREATE TABLE `type_fields` (
    `type_id` INT(10) NOT NULL,
    `field_id` INT(10) NOT NULL,
    FOREIGN KEY (`type_id`) REFERENCES types(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`field_id`) REFERENCES fields(`id`) ON DELETE CASCADE)
    ENGINE=MyISAM
    DEFAULT CHARSET=utf8;

LOCK TABLES `type_fields` WRITE;

INSERT INTO `type_fields` (`type_id`, `field_id`) VALUES
	(1, 1),
	(2, 2),
	(3, 3),
	(3, 4),
	(3, 5);

UNLOCK TABLES;
