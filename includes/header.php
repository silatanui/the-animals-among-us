<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

$pageTitle = $pageTitle ?? SITE_NAME;
$pageDescription = $pageDescription ?? 'A community platform for the animals living and working beside us.';
$activeNav = $activeNav ?? '';
$bodyClass = $bodyClass ?? '';
$flash = flash_get();
$lang = current_lang();
?>
<!DOCTYPE html>
<html lang="<?= e($lang) ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?= e($pageDescription) ?>">
  <title><?= e($pageTitle) ?><?= $pageTitle === SITE_NAME ? '' : ' · ' . e(SITE_NAME) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer">
  <link rel="stylesheet" href="<?= e(asset('css/main.css')) ?>">
  <link rel="icon" href="<?= e(asset('images/Mobile Website Logo.png')) ?>" type="image/png">
</head>
<body class="<?= e($bodyClass) ?>">
  <a class="skip-link" href="#main"><?= e(t('skip_to_content')) ?></a>

  <header class="site-header" id="top">
    <div class="site-header__inner">
      <a class="brand" href="<?= e(url('index.php')) ?>" aria-label="<?= e(t('brand_home')) ?>">
        <img
          class="brand__mark"
          src="<?= e(asset('images/brand-mark.png')) ?>"
          alt=""
          width="72"
          height="64"
          decoding="async"
        >
        <span class="brand__divider" aria-hidden="true"></span>
        <span class="brand__text">
          <span class="brand__name">
            <span class="brand__name-dark">The Animals</span>
            <span class="brand__name-light">Among Us</span>
          </span>
          <span class="brand__tagline"><?= e(t('brand_tagline')) ?></span>
        </span>
      </a>

      <div class="site-header__actions">
        <div class="lang-switch" role="group" aria-label="<?= e(t('language')) ?>">
          <a
            class="lang-switch__btn<?= $lang === 'en' ? ' is-active' : '' ?>"
            href="?lang=en"
            hreflang="en"
            lang="en"
            aria-pressed="<?= $lang === 'en' ? 'true' : 'false' ?>"
          >EN</a>
          <a
            class="lang-switch__btn<?= $lang === 'sw' ? ' is-active' : '' ?>"
            href="?lang=sw"
            hreflang="sw"
            lang="sw"
            aria-pressed="<?= $lang === 'sw' ? 'true' : 'false' ?>"
          >SW</a>
        </div>
        <a class="btn btn--report" href="<?= e(url('report.php')) ?>"><?= e(t('report_concern')) ?></a>
        <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-nav" aria-label="<?= e(t('open_menu')) ?>">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>

    <nav class="primary-nav" id="primary-nav" aria-label="Primary">
      <ul class="primary-nav__list">
        <?php foreach ($navItems as $item): ?>
          <li>
            <a
              href="<?= e(url($item['href'])) ?>"
              class="<?= $activeNav === $item['key'] ? 'is-active' : '' ?>"
              <?= $activeNav === $item['key'] ? 'aria-current="page"' : '' ?>
            ><?= e(t($item['label_key'])) ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
  </header>

  <?php if (is_sw()): ?>
    <div class="lang-banner" role="status">
      <div class="container">
        <p><?= e(t('lang_partial_note')) ?></p>
      </div>
    </div>
  <?php endif; ?>

  <?php if ($flash): ?>
    <div class="flash flash--<?= e($flash['type']) ?>" role="status">
      <div class="container">
        <p><?= e($flash['message']) ?></p>
      </div>
    </div>
  <?php endif; ?>

  <main id="main">
