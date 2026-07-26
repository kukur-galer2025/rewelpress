<?php
require 'config/database.php';
require 'core/Database.php';

$db = new Database();
$db->query("ALTER TABLE order_items ADD COLUMN item_type ENUM('book', 'ebook') NOT NULL DEFAULT 'book' AFTER order_id");
$db->execute();

$db->query("ALTER TABLE order_items MODIFY COLUMN book_id INT NULL");
$db->execute();

$db->query("ALTER TABLE order_items ADD COLUMN ebook_id INT NULL AFTER book_id");
$db->execute();

echo "Database updated!";
