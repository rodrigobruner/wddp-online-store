CREATE DATABASE  IF NOT EXISTS `kermet_store`;
USE `kermet_store`;

CREATE TABLE `inventory` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `inventory` VALUES (1,'product01.jpg','Dumper toy','Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit sint voluptate temporibus ad qui consequuntur voluptatem ducimus quis fugiat sequi et esse quidem eveniet culpa, consequatur, doloribus dignissimos quibusdam perspiciatis!',450.99),(2,'product02.jpg','Tractor toy','Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit sint voluptate temporibus ad qui consequuntur voluptatem ducimus quis fugiat sequi et esse quidem eveniet culpa, consequatur, doloribus dignissimos quibusdam perspiciatis!',564.55),(3,'product03.jpg','Teddy dragon','Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit sint voluptate temporibus ad qui consequuntur voluptatem ducimus quis fugiat sequi et esse quidem eveniet culpa, consequatur, doloribus dignissimos quibusdam perspiciatis!',60.95),(4,'product04.jpg','Summer clothing set','Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit sint voluptate temporibus ad qui consequuntur voluptatem ducimus quis fugiat sequi et esse quidem eveniet culpa, consequatur, doloribus dignissimos quibusdam perspiciatis!',35.95),(5,'product05.jpg','Winter clothing set','Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit sint voluptate temporibus ad qui consequuntur voluptatem ducimus quis fugiat sequi et esse quidem eveniet culpa, consequatur, doloribus dignissimos quibusdam perspiciatis!',29.99),(6,'product06.jpg','Octoberfast clothing set','Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit sint voluptate temporibus ad qui consequuntur voluptatem ducimus quis fugiat sequi et esse quidem eveniet culpa, consequatur, doloribus dignissimos quibusdam perspiciatis!',101.55);

CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `postcode` varchar(7) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `province` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
);

CREATE TABLE `shopping` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `date_time` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_shopping_user_idx` (`user_id`),
  CONSTRAINT `fk_shopping_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
);

CREATE TABLE `items` (
  `inventory_id` int NOT NULL,
  `shopping_id` int NOT NULL,
  `quantity` int DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  KEY `fk_itens_inventory1_idx` (`inventory_id`),
  KEY `fk_itens_shopping1_idx` (`shopping_id`),
  CONSTRAINT `fk_itens_inventory1` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`),
  CONSTRAINT `fk_itens_shopping1` FOREIGN KEY (`shopping_id`) REFERENCES `shopping` (`id`)
);
