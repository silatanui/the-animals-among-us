<?php
/**
 * The Animals Among Us site configuration
 */
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('SITE_NAME', 'The Animals Among Us');
define('SITE_TAGLINE', 'Care begins where we live.');
define('SITE_SUPPORTING', 'Respect the animals who live and work beside us.');
define('SITE_PITCH', 'A portfolio project speaking up for the domesticated and working animals we live beside every day.');
define('SITE_EMAIL', 'hello@theanimalsamongus.org');
define('ROOT_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// MySQL (XAMPP defaults). Forms write here: reports, contact, newsletter, stories.
define('DB_HOST', '127.0.0.1');
define('DB_PORT', 3306);
define('DB_NAME', 'animals_among_us');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Portfolio admin login (change before any real deployment)
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'animals2026');

// Public URL base for this project folder (works from root or subfolders)
$docRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '') ?: '';
$projectRoot = realpath(ROOT_PATH) ?: ROOT_PATH;
$relative = '';
if ($docRoot && str_starts_with($projectRoot, $docRoot)) {
    $relative = str_replace('\\', '/', substr($projectRoot, strlen($docRoot)));
}
define('BASE_URL', rtrim(str_replace(' ', '%20', $relative), '/') . '/');
define('ASSET_URL', BASE_URL . 'assets/');

require_once __DIR__ . '/i18n.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/kenya_geo.php';

$navItems = [
    ['label_key' => 'nav_home', 'href' => 'index.php', 'key' => 'home'],
    ['label_key' => 'nav_about', 'href' => 'about.php', 'key' => 'about'],
    ['label_key' => 'nav_why', 'href' => 'why-it-matters.php', 'key' => 'why'],
    ['label_key' => 'nav_guides', 'href' => 'care-guides.php', 'key' => 'guides'],
    ['label_key' => 'nav_community', 'href' => 'community.php', 'key' => 'community'],
    ['label_key' => 'nav_action', 'href' => 'take-action.php', 'key' => 'action'],
    ['label_key' => 'nav_report', 'href' => 'report.php', 'key' => 'report'],
    ['label_key' => 'nav_contact', 'href' => 'contact.php', 'key' => 'contact'],
];
