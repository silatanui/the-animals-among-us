<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . url('index.php'));
    exit;
}

if (!csrf_validate($_POST['csrf_token'] ?? null)) {
    flash_set('error', 'Your session expired. Please try again.');
    header('Location: ' . url('index.php'));
    exit;
}

$email = trim((string) ($_POST['email'] ?? ''));
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    flash_set('error', 'Please enter a valid email address to join the community updates.');
    header('Location: ' . url('index.php'));
    exit;
}

try {
    db_save_newsletter($email, 'footer');
} catch (Throwable $e) {
    flash_set('error', 'We could not save your email right now. Please try again shortly.');
    header('Location: ' . url('index.php'));
    exit;
}

flash_set('success', 'Welcome. You are on the list for occasional care guides, stories and event updates.');
header('Location: ' . url('index.php'));
exit;
