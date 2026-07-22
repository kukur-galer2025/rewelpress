<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'press_unsoed_db');
define('BASEURL', 'http://localhost/rewelpress/public');

// Google OAuth Configuration
define('GOOGLE_CLIENT_ID', '188521249663-qemfcplc9quceqv16iea66skg9qaodbh.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_REDIRECT_URI', BASEURL . '/auth/google_callback');

// SMTP Configuration (for PHPMailer)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', 'kukurdell@gmail.com');
define('SMTP_PASS', 'nynrtzfzhpofpvrq'); // Gmail App Password
define('SMTP_PORT', 587);
