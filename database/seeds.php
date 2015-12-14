<?php

$pdo = new PDO('mysql:host=localhost;dbname=db_starwars', 'yoda', 'yoda');

$pdo->query("INSERT INTO categories (title) VALUES ('Jouets')");
$pdo->query("INSERT INTO categories (title) VALUES ('Films')");
$pdo->query("INSERT INTO categories (title) VALUES ('Equipements')");
$pdo->query("INSERT INTO categories (title) VALUES ('Sabres')");

$pdo->query("INSERT INTO tags (name) VALUES ('galaxy'), ('star'), ('jedi')");
$pdo->query("INSERT INTO products (title, category_id, abstract, price, published_at, content) VALUES ('Sabre laser', '4', 'Le sabre laser est une arme principalement utilisée par les Jedi et les Sith.', '100.00', '03-09-2015', 'Le premier sabre laser que mania Luke fut celui de son père\, Anakin Skywalker. Obi-Wan Kenobi le lui avait donné en hommage à son père. Malheureusement\, le jeune homme le perdit\, ainsi que sa main droite\, lors de son duel face à Dark Vador\, dans les entrailles de la Cité des Nuages de Bespin. Cest là que le Seigneur Noir des Sith annonça que le Jedi était son fils. ')");
$pdo->query("INSERT INTO products (title, category_id, abstract, price, published_at) VALUES ('Casque dark Vador', '3', 'Le casque de dark vador noir.', '1250.00', '24-11-2015')");
$pdo->query("INSERT INTO products (title, category_id, abstract, price, published_at) VALUES ('Drone Millenium', '1', 'Petit drone de univers de Star Wars', '350.00', '22-11-2015')");
$pdo->query("INSERT INTO products (title, category_id, abstract, price, published_at) VALUES ('Lego Star Wars', '1', 'lego de star wars', '19.00', '18-10-2015')");
$pdo->query("INSERT INTO images (product_id, uri) VALUES ('1', 'laser.jpg')");
$pdo->query("INSERT INTO images (product_id, uri) VALUES ('2', 'casqueVador.jpg')");
$pdo->query("INSERT INTO images (product_id, uri) VALUES ('3', 'drone.jpg')");
$pdo->query("INSERT INTO images (product_id, uri) VALUES ('4', 'lego.jpg')");

$pdo->query("INSERT INTO product_tag (tag_id, product_id) VALUES ('1', '1')");
$pdo->query("INSERT INTO product_tag (tag_id, product_id) VALUES ('3', '1')");
$pdo->query("INSERT INTO product_tag (tag_id, product_id) VALUES ('1', '2')");
$pdo->query("INSERT INTO product_tag (tag_id, product_id) VALUES ('3', '2')");
$pdo->query("INSERT INTO product_tag (tag_id, product_id) VALUES ('1', '3')");
$pdo->query("INSERT INTO product_tag (tag_id, product_id) VALUES ('2', '3')");
$pdo->query("INSERT INTO product_tag (tag_id, product_id) VALUES ('1', '4')");
$pdo->query("INSERT INTO product_tag (tag_id, product_id) VALUES ('2', '4')");
$pdo->query("INSERT INTO product_tag (tag_id, product_id) VALUES ('3', '4')");






