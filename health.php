<?php
declare(strict_types=1);

/**
 * Lightweight hosting check for cPanel. Safe to delete after go-live.
 */
header('Content-Type: text/plain; charset=utf-8');

echo "TAU health check\n";
echo "PHP: " . PHP_VERSION . "\n";
echo "PDO MySQL: " . (extension_loaded('pdo_mysql') ? 'yes' : 'NO') . "\n";

$configLocal = __DIR__ . '/includes/config.local.php';
echo "config.local.php: " . (is_file($configLocal) ? 'found' : 'MISSING') . "\n";

try {
    require_once __DIR__ . '/includes/config.php';
    echo "BASE_URL: " . BASE_URL . "\n";
    echo "DB_NAME: " . DB_NAME . "\n";
    echo "DB_USER: " . DB_USER . "\n";
    echo "DB_HOST: " . DB_HOST . "\n";

    $pdo = db();
    echo "DB connect: OK\n";

    foreach (['welfare_reports', 'community_stories', 'contact_messages', 'newsletter_subscribers'] as $table) {
        $count = (int) $pdo->query('SELECT COUNT(*) FROM `' . str_replace('`', '', $table) . '`')->fetchColumn();
        echo $table . ': ' . $count . " rows\n";
    }
    echo "STATUS: OK\n";
} catch (Throwable $e) {
    echo "STATUS: FAIL\n";
    echo "Error: " . $e->getMessage() . "\n";
}
