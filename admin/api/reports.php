<?php
declare(strict_types=1);
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once dirname(__DIR__, 2) . '/includes/functions.php';
require_once dirname(__DIR__, 2) . '/includes/admin.php';

admin_require_login();

$action = $_GET['action'] ?? $_POST['action'] ?? 'list';

if ($action === 'list') {
    $status = trim((string) ($_GET['status'] ?? ''));
    $sql = 'SELECT id, reference_code, animal_type, concern_types, county, area, immediate_danger, status, created_at
            FROM welfare_reports';
    $params = [];
    if ($status !== '') {
        $sql .= ' WHERE status = :status';
        $params[':status'] = $status;
    }
    $sql .= ' ORDER BY created_at DESC';
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll();
    foreach ($rows as &$row) {
        $concerns = json_decode((string) $row['concern_types'], true);
        $row['concern_types'] = is_array($concerns) ? $concerns : [];
    }
    unset($row);
    admin_json(['data' => $rows]);
}

if ($action === 'get') {
    $id = (int) ($_GET['id'] ?? 0);
    $stmt = db()->prepare('SELECT * FROM welfare_reports WHERE id = :id LIMIT 1');
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();
    if (!$row) {
        admin_json(['ok' => false, 'error' => 'Report not found.'], 404);
    }
    $concerns = json_decode((string) $row['concern_types'], true);
    $row['concern_types'] = is_array($concerns) ? $concerns : [];
    admin_json(['ok' => true, 'item' => $row]);
}

if ($action === 'update_status') {
    admin_require_post_csrf();
    $id = (int) ($_POST['id'] ?? 0);
    $status = trim((string) ($_POST['status'] ?? ''));
    $allowed = ['received', 'in_review', 'referred', 'closed'];
    if ($id < 1 || !in_array($status, $allowed, true)) {
        admin_json(['ok' => false, 'error' => 'Invalid status update.'], 422);
    }
    $stmt = db()->prepare('UPDATE welfare_reports SET status = :status WHERE id = :id');
    $stmt->execute([':status' => $status, ':id' => $id]);
    admin_json(['ok' => true]);
}

if ($action === 'delete') {
    admin_require_post_csrf();
    $id = (int) ($_POST['id'] ?? 0);
    $stmt = db()->prepare('DELETE FROM welfare_reports WHERE id = :id');
    $stmt->execute([':id' => $id]);
    admin_json(['ok' => true]);
}

admin_json(['ok' => false, 'error' => 'Unknown action.'], 400);
