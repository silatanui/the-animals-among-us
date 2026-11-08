<?php
declare(strict_types=1);

/**
 * Language helpers for EN / SW.
 */
$allowedLangs = ['en', 'sw'];

// Allow ?lang=sw or ?lang=en to set preference
if (isset($_GET['lang']) && in_array($_GET['lang'], $allowedLangs, true)) {
    $chosen = $_GET['lang'];
    setcookie('tau_lang', $chosen, [
        'expires' => time() + 60 * 60 * 24 * 365,
        'path' => '/',
        'samesite' => 'Lax',
    ]);
    $_COOKIE['tau_lang'] = $chosen;

    // Redirect back without the query string so refresh stays clean
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    $parts = parse_url($uri);
    $path = $parts['path'] ?? '/';
    $query = [];
    if (!empty($parts['query'])) {
        parse_str($parts['query'], $query);
        unset($query['lang']);
    }
    $target = $path;
    if ($query !== []) {
        $target .= '?' . http_build_query($query);
    }
    header('Location: ' . $target);
    exit;
}

$currentLang = $_COOKIE['tau_lang'] ?? 'en';
if (!in_array($currentLang, $allowedLangs, true)) {
    $currentLang = 'en';
}

define('SITE_LANG', $currentLang);

$translationsEn = require ROOT_PATH . 'lang' . DIRECTORY_SEPARATOR . 'en.php';
$translationsSw = require ROOT_PATH . 'lang' . DIRECTORY_SEPARATOR . 'sw.php';
$translations = SITE_LANG === 'sw' ? $translationsSw : $translationsEn;

/**
 * Translate a key. Falls back to English, then the key itself.
 */
function t(string $key, ?string $fallback = null): string
{
    global $translations, $translationsEn;
    if (isset($translations[$key]) && $translations[$key] !== '') {
        return (string) $translations[$key];
    }
    if (isset($translationsEn[$key]) && $translationsEn[$key] !== '') {
        return (string) $translationsEn[$key];
    }
    return $fallback ?? $key;
}

function current_lang(): string
{
    return SITE_LANG;
}

function is_sw(): bool
{
    return SITE_LANG === 'sw';
}
