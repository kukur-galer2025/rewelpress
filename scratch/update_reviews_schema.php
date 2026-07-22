<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/Database.php';

$db = new Database();

// Check existing columns
$db->query("SHOW COLUMNS FROM reviews");
$cols = $db->resultSet();
$colNames = array_column($cols, 'Field');

if (!in_array('order_id', $colNames)) {
    $db->query("ALTER TABLE reviews ADD COLUMN order_id INT(11) NULL AFTER item_id");
    $db->execute();
    echo "Added order_id column.\n";
} else {
    echo "order_id column already exists.\n";
}

if (!in_array('is_verified_buyer', $colNames)) {
    $db->query("ALTER TABLE reviews ADD COLUMN is_verified_buyer TINYINT(1) DEFAULT 1 AFTER order_id");
    $db->execute();
    echo "Added is_verified_buyer column.\n";
} else {
    echo "is_verified_buyer column already exists.\n";
}

echo "Reviews table schema verification complete.\n";
