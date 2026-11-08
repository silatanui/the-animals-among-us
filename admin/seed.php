<?php
declare(strict_types=1);

/**
 * One-click demo seeder for portfolio hosting (cPanel).
 * Visit /admin/seed.php while logged in, or /admin/seed.php?demo=1
 */
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/admin.php';

if (isset($_GET['demo'])) {
    admin_attempt_login(ADMIN_USERNAME, ADMIN_PASSWORD);
}

admin_require_login();

header('Content-Type: text/plain; charset=utf-8');

try {
    require dirname(__DIR__) . '/sql/seed_demo.php';
} catch (Throwable $e) {
    echo "Seed failed: " . $e->getMessage() . "\n";
    exit(1);
}
