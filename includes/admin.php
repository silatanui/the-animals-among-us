<?php
declare(strict_types=1);

function admin_logged_in(): bool
{
    return !empty($_SESSION['admin_logged_in']);
}

function admin_require_login(): void
{
    if (!admin_logged_in()) {
        header('Location: ' . url('admin/login.php'));
        exit;
    }
}

function admin_attempt_login(string $username, string $password): bool
{
    if (!hash_equals(ADMIN_USERNAME, $username) || !hash_equals(ADMIN_PASSWORD, $password)) {
        return false;
    }
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_user'] = ADMIN_USERNAME;
    $_SESSION['admin_login_at'] = date('c');
    return true;
}

function admin_logout(): void
{
    unset($_SESSION['admin_logged_in'], $_SESSION['admin_user'], $_SESSION['admin_login_at']);
}

function admin_json(array $payload, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

function admin_require_post_csrf(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_validate($_POST['csrf_token'] ?? null)) {
        admin_json(['ok' => false, 'error' => 'Invalid or expired session.'], 403);
    }
}

/**
 * Dashboard metrics + chart series for the portfolio admin overview.
 */
function admin_dashboard_stats(): array
{
    $pdo = db();

    $counts = $pdo->query(
        'SELECT
           (SELECT COUNT(*) FROM welfare_reports) AS reports,
           (SELECT COUNT(*) FROM welfare_reports WHERE status = "received") AS reports_new,
           (SELECT COUNT(*) FROM welfare_reports WHERE LOWER(immediate_danger) IN ("yes","y","urgent")) AS reports_urgent,
           (SELECT COUNT(*) FROM contact_messages) AS contacts,
           (SELECT COUNT(*) FROM contact_messages WHERE status = "new") AS contacts_new,
           (SELECT COUNT(*) FROM newsletter_subscribers) AS subscribers,
           (SELECT COUNT(*) FROM community_stories) AS stories,
           (SELECT COUNT(*) FROM community_stories WHERE status = "pending_moderation") AS stories_pending,
           (SELECT COUNT(*) FROM community_stories WHERE status = "published") AS stories_published'
    )->fetch() ?: [];

    $reportsByAnimal = $pdo->query(
        'SELECT animal_type AS label, COUNT(*) AS value
         FROM welfare_reports
         GROUP BY animal_type
         ORDER BY value DESC'
    )->fetchAll();

    $reportsByCounty = $pdo->query(
        'SELECT county AS label, COUNT(*) AS value
         FROM welfare_reports
         GROUP BY county
         ORDER BY value DESC
         LIMIT 8'
    )->fetchAll();

    $storiesByCategory = $pdo->query(
        'SELECT COALESCE(NULLIF(category, ""), "Uncategorised") AS label, COUNT(*) AS value
         FROM community_stories
         GROUP BY label
         ORDER BY value DESC'
    )->fetchAll();

    $contactsByCategory = $pdo->query(
        'SELECT category AS label, COUNT(*) AS value
         FROM contact_messages
         GROUP BY category
         ORDER BY value DESC'
    )->fetchAll();

    $reportTrend = $pdo->query(
        'SELECT DATE_FORMAT(created_at, "%Y-%m") AS label, COUNT(*) AS value
         FROM welfare_reports
         GROUP BY DATE_FORMAT(created_at, "%Y-%m")
         ORDER BY label ASC'
    )->fetchAll();

    $subscriberTrend = $pdo->query(
        'SELECT DATE_FORMAT(created_at, "%Y-%m") AS label, COUNT(*) AS value
         FROM newsletter_subscribers
         GROUP BY DATE_FORMAT(created_at, "%Y-%m")
         ORDER BY label ASC'
    )->fetchAll();

    $recentReports = $pdo->query(
        'SELECT reference_code, animal_type, county, status, immediate_danger, created_at
         FROM welfare_reports
         ORDER BY created_at DESC
         LIMIT 6'
    )->fetchAll();

    $recentStories = $pdo->query(
        'SELECT title, display_name, animal_type, status, created_at
         FROM community_stories
         ORDER BY created_at DESC
         LIMIT 5'
    )->fetchAll();

    return [
        'counts' => array_map('intval', $counts),
        'charts' => [
            'reports_by_animal' => $reportsByAnimal,
            'reports_by_county' => $reportsByCounty,
            'stories_by_category' => $storiesByCategory,
            'contacts_by_category' => $contactsByCategory,
            'report_trend' => $reportTrend,
            'subscriber_trend' => $subscriberTrend,
        ],
        'map_points' => admin_case_map_points(),
        'recent_reports' => $recentReports,
        'recent_stories' => $recentStories,
    ];
}
