<?php
declare(strict_types=1);
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once dirname(__DIR__, 2) . '/includes/admin.php';

admin_require_login();

$action = $_GET['action'] ?? $_POST['action'] ?? 'list';

if ($action === 'list') {
    $rows = db()->query(
        'SELECT id, email, source, consent, created_at
         FROM newsletter_subscribers
         ORDER BY created_at DESC'
    )->fetchAll();
    admin_json(['data' => $rows]);
}

if ($action === 'delete') {
    admin_require_post_csrf();
    $id = (int) ($_POST['id'] ?? 0);
    $stmt = db()->prepare('DELETE FROM newsletter_subscribers WHERE id = :id');
    $stmt->execute([':id' => $id]);
    admin_json(['ok' => true]);
}

admin_json(['ok' => false, 'error' => 'Unknown action.'], 400);
