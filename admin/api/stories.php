<?php
declare(strict_types=1);
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once dirname(__DIR__, 2) . '/includes/admin.php';

admin_require_login();

$action = $_GET['action'] ?? $_POST['action'] ?? 'list';

if ($action === 'list') {
    $status = trim((string) ($_GET['status'] ?? ''));
    $sql = 'SELECT id, title, display_name, animal_type, category, location, status, created_at
            FROM community_stories';
    $params = [];
    if ($status !== '') {
        $sql .= ' WHERE status = :status';
        $params[':status'] = $status;
    }
    $sql .= ' ORDER BY created_at DESC';
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    admin_json(['data' => $stmt->fetchAll()]);
}

if ($action === 'get') {
    $id = (int) ($_GET['id'] ?? 0);
    $stmt = db()->prepare('SELECT * FROM community_stories WHERE id = :id LIMIT 1');
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();
    if (!$row) {
        admin_json(['ok' => false, 'error' => 'Story not found.'], 404);
    }
    admin_json(['ok' => true, 'item' => $row]);
}

if ($action === 'update_status') {
    admin_require_post_csrf();
    $id = (int) ($_POST['id'] ?? 0);
    $status = trim((string) ($_POST['status'] ?? ''));
    $allowed = ['pending_moderation', 'published', 'needs_changes', 'declined'];
    if ($id < 1 || !in_array($status, $allowed, true)) {
        admin_json(['ok' => false, 'error' => 'Invalid status update.'], 422);
    }
    $stmt = db()->prepare('UPDATE community_stories SET status = :status WHERE id = :id');
    $stmt->execute([':status' => $status, ':id' => $id]);
    admin_json(['ok' => true]);
}

if ($action === 'delete') {
    admin_require_post_csrf();
    $id = (int) ($_POST['id'] ?? 0);
    $stmt = db()->prepare('SELECT photo_path FROM community_stories WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $photo = $stmt->fetchColumn();
    $del = db()->prepare('DELETE FROM community_stories WHERE id = :id');
    $del->execute([':id' => $id]);
    if (is_string($photo) && $photo !== '') {
        $path = ROOT_PATH . 'data' . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $photo);
        if (is_file($path)) {
            @unlink($path);
        }
    }
    admin_json(['ok' => true]);
}

admin_json(['ok' => false, 'error' => 'Unknown action.'], 400);
