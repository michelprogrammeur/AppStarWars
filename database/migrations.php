<?php

$pdo = new PDO('mysql:host=localhost;dbname=db_starwars', 'yoda', 'yoda');

$pdo->exec("
    CREATE TABLE IF NOT EXISTS users(
      id INT UNSIGNED NOT NULL AUTO_INCREMENT,
      username VARCHAR(20),
      password VARCHAR(100),
      PRIMARY KEY(id)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

    CREATE TABLE IF NOT EXISTS customers(
      id INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `email` VARCHAR(100),
      `address` TEXT,
      `number` VARCHAR(100),
      `number_command` INT UNSIGNED,
      PRIMARY KEY(id)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

    CREATE TABLE IF NOT EXISTS categories(
      id INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `title` VARCHAR(255),
      `description` TEXT,
      PRIMARY KEY(id)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

    CREATE TABLE IF NOT EXISTS products(
      id INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `category_id` INT UNSIGNED,
      `title` VARCHAR(255),
      `abstract` VARCHAR(255),
      `content` TEXT,
      `published_at` DATETIME,
      `price` DECIMAL(5,2),
      `status` ENUM('published', 'unpublished') DEFAULT 'unpublished',
      PRIMARY KEY(id),
      CONSTRAINT `products_category_id_categories` FOREIGN KEY(`category_id`) REFERENCES `categories`(`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

    CREATE TABLE IF NOT EXISTS images(
      id INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `product_id` INT UNSIGNED,
      `name` VARCHAR(50),
      `uri` VARCHAR(255),
      `published_at` DATETIME,
      `status` ENUM('published', 'unpublished') DEFAULT 'unpublished',
      PRIMARY KEY(id),
      CONSTRAINT `images_product_id_products` FOREIGN KEY(`product_id`) REFERENCES `products`(`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

    CREATE TABLE IF NOT EXISTS histories(
      id INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `product_id` INT UNSIGNED,
      `customer_id` INT UNSIGNED,
      `price` DECIMAL(10,2),
      `total` DECIMAL(10,2),
      `quantity` INT UNSIGNED,
      `status` ENUM('done', 'todo') NOT NULL DEFAULT 'todo',
      PRIMARY KEY(id),
      CONSTRAINT `histories_product_id_products` FOREIGN KEY(`product_id`) REFERENCES `products`(`id`),
      CONSTRAINT `histories_customer_id_customers` FOREIGN KEY(`customer_id`) REFERENCES `customers`(`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

    CREATE TABLE IF NOT EXISTS tags(
      id INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` VARCHAR(50),
      PRIMARY KEY(id)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

    CREATE TABLE IF NOT EXISTS product_tag(
      `product_id` INT UNSIGNED,
      `tag_id` INT UNSIGNED,
      CONSTRAINT `product_tag_product_id_products` FOREIGN KEY(`product_id`) REFERENCES `products`(`id`),
      CONSTRAINT `product_tag_tag_id_tags` FOREIGN KEY(`tag_id`) REFERENCES `tags`(`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

");