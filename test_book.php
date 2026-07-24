<?php
ini_set('display_errors',1); error_reporting(E_ALL);
require 'config/database.php';
require 'core/Database.php';
$db = new Database();
$db->query('SELECT id, title, slug, category_id FROM books');
var_dump($db->resultSet());

require 'app/models/BookModel.php';
$b = new BookModel();
$db->query('SELECT books.*, categories.name as category_name, categories.slug as category_slug, parent.name as parent_category_name, COALESCE(rev.avg_rating, 0) AS avg_rating, COALESCE(rev.review_count, 0) AS review_count FROM books JOIN categories ON books.category_id = categories.id LEFT JOIN categories parent ON categories.parent_id = parent.id LEFT JOIN (SELECT item_id, ROUND(AVG(rating), 1) AS avg_rating, COUNT(*) AS review_count FROM reviews WHERE item_type = "book" GROUP BY item_id) rev ON books.id = rev.item_id WHERE books.id = 14');
var_dump($db->single());

// Check if any PDO error
var_dump($db->stmt->errorInfo());
