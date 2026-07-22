<?php
if (!session_id()) session_start();

// Generate CSRF Token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Global Security Helpers
function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
}

function esc($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

require_once '../core/App.php';
require_once '../core/Controller.php';
require_once '../core/Database.php';
require_once '../config/database.php';

$app = new App();
