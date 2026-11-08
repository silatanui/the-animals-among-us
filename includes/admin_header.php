<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/admin.php';

admin_require_login();

$adminPageTitle = $adminPageTitle ?? 'Dashboard';
$adminActive = $adminActive ?? 'dashboard';
$adminBodyClass = $adminBodyClass ?? '';

$adminNav = [
    ['key' => 'dashboard', 'href' => 'admin/index.php', 'label' => 'Dashboard', 'icon' => 'fa-chart-pie'],
    ['key' => 'reports', 'href' => 'admin/reports.php', 'label' => 'Welfare reports', 'icon' => 'fa-shield-halved'],
    ['key' => 'stories', 'href' => 'admin/stories.php', 'label' => 'Community stories', 'icon' => 'fa-book-open'],
    ['key' => 'contact', 'href' => 'admin/contact.php', 'label' => 'Contact inbox', 'icon' => 'fa-envelope'],
    ['key' => 'newsletter', 'href' => 'admin/newsletter.php', 'label' => 'Newsletter', 'icon' => 'fa-newspaper'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex,nofollow">
  <title><?= e($adminPageTitle) ?> · Admin · <?= e(SITE_NAME) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
  <link rel="stylesheet" href="<?= e(asset('css/admin.css')) ?>">
  <link rel="icon" href="<?= e(asset('images/Mobile Website Logo.png')) ?>" type="image/png">
</head>
<body class="admin-body <?= e($adminBodyClass) ?>">
  <div class="admin-shell">
    <aside class="admin-sidebar" id="admin-sidebar">
      <a class="admin-brand" href="<?= e(url('admin/index.php')) ?>">
        <img src="<?= e(asset('images/Logo White BG.png')) ?>" alt="" width="44" height="36">
        <span>
          <strong>Admin</strong>
          <small><?= e(SITE_NAME) ?></small>
        </span>
      </a>

      <nav class="admin-nav" aria-label="Admin">
        <?php foreach ($adminNav as $item): ?>
          <a
            class="admin-nav__link<?= $adminActive === $item['key'] ? ' is-active' : '' ?>"
            href="<?= e(url($item['href'])) ?>"
          >
            <i class="fa-solid <?= e($item['icon']) ?>" aria-hidden="true"></i>
            <span><?= e($item['label']) ?></span>
          </a>
        <?php endforeach; ?>
      </nav>

      <div class="admin-sidebar__foot">
        <a href="<?= e(url('index.php')) ?>" target="_blank" rel="noopener">
          <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
          View public site
        </a>
        <a href="<?= e(url('admin/logout.php')) ?>">
          <i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i>
          Sign out
        </a>
      </div>
    </aside>

    <div class="admin-main">
      <header class="admin-topbar">
        <button class="admin-menu-btn" type="button" aria-controls="admin-sidebar" aria-expanded="false" aria-label="Open menu">
          <span></span><span></span><span></span>
        </button>
        <div>
          <p class="admin-topbar__eyebrow">Portfolio operations</p>
          <h1><?= e($adminPageTitle) ?></h1>
        </div>
        <div class="admin-topbar__meta">
          <span class="admin-pill">Demo mode</span>
          <span class="admin-user"><?= e($_SESSION['admin_user'] ?? 'admin') ?></span>
        </div>
      </header>

      <div class="admin-content">
        <?php $flash = flash_get(); if ($flash): ?>
          <div class="admin-flash admin-flash--<?= e($flash['type']) ?>" role="status"><?= e($flash['message']) ?></div>
        <?php endif; ?>
