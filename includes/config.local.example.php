<?php
/**
 * Copy this file to config.local.php on the server and fill in cPanel values.
 * config.local.php is ignored by git so local XAMPP and live hosting stay separate.
 *
 * In cPanel → MySQL® Databases, names are usually prefixed with your cPanel username:
 *   Example cPanel user: silatanui
 *   Database: silatanui_tau
 *   User:     silatanui_tau
 */
declare(strict_types=1);

return [
    'DB_HOST' => 'localhost',
    'DB_PORT' => 3306,
    'DB_NAME' => 'YOUR_CPANEL_USER_tau',
    'DB_USER' => 'YOUR_CPANEL_USER_tau',
    'DB_PASS' => 'REPLACE_WITH_STRONG_PASSWORD',
    'DB_CHARSET' => 'utf8mb4',

    // Optional: change these on live if you want
    // 'ADMIN_USERNAME' => 'admin',
    // 'ADMIN_PASSWORD' => 'animals2026',
    // 'SITE_EMAIL' => 'hello@yourdomain.com',
];
