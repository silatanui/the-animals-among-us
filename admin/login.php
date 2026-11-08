<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/admin.php';

if (admin_logged_in()) {
    header('Location: ' . url('admin/index.php'));
    exit;
}

$error = '';
$wantsDemo = isset($_GET['demo']) || (($_POST['demo_access'] ?? '') === '1');

if ($wantsDemo) {
    // Portfolio convenience: one-click / one-link demo entry.
    if (admin_attempt_login(ADMIN_USERNAME, ADMIN_PASSWORD)) {
        header('Location: ' . url('admin/index.php'));
        exit;
    }
    $error = 'Demo access could not start. Please use the credentials below.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['csrf_token'] ?? null)) {
        $error = 'Your session expired. Please try again.';
    } else {
        $user = trim((string) ($_POST['username'] ?? ''));
        $pass = (string) ($_POST['password'] ?? '');
        if (admin_attempt_login($user, $pass)) {
            header('Location: ' . url('admin/index.php'));
            exit;
        }
        $error = 'Those credentials do not match this portfolio admin.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex,nofollow">
  <title>Admin sign in · <?= e(SITE_NAME) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= e(asset('css/admin.css')) ?>">
  <link rel="icon" href="<?= e(asset('images/Mobile Website Logo.png')) ?>" type="image/png">
</head>
<body class="admin-login-body">
  <main class="admin-login">
    <div class="admin-login__panel">
      <div class="admin-login__visual" aria-hidden="true">
        <img src="<?= e(asset('images/Logo White BG.png')) ?>" alt="">
        <p>Care for the animals who share our everyday lives.</p>
      </div>
      <div class="admin-login__form">
        <p class="admin-login__eyebrow">Portfolio demo</p>
        <h1>Open the admin desk</h1>
        <p class="admin-login__lede">
          This is a portfolio project, so access is open for reviewers. Use the one-click button, or the shared demo login.
        </p>

        <?php if ($error !== ''): ?>
          <div class="admin-flash admin-flash--error" role="alert"><?= e($error) ?></div>
        <?php endif; ?>

        <div class="admin-demo-card">
          <p class="admin-demo-card__label">Quick access</p>
          <form method="post" action="">
            <input type="hidden" name="demo_access" value="1">
            <button class="admin-btn admin-btn--primary admin-btn--block" type="submit">
              Enter demo admin
            </button>
          </form>
          <p class="admin-demo-card__or">or use these credentials</p>
          <dl class="admin-demo-creds">
            <div>
              <dt>Username</dt>
              <dd><code><?= e(ADMIN_USERNAME) ?></code></dd>
            </div>
            <div>
              <dt>Password</dt>
              <dd><code><?= e(ADMIN_PASSWORD) ?></code></dd>
            </div>
          </dl>
          <a class="admin-demo-card__link" href="<?= e(url('admin/login.php?demo=1')) ?>">Direct demo link</a>
        </div>

        <details class="admin-login-manual">
          <summary>Sign in manually</summary>
          <form method="post" action="" class="admin-login-manual__form">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
            <label>
              <span>Username</span>
              <input name="username" autocomplete="username" required value="<?= e(ADMIN_USERNAME) ?>">
            </label>
            <label>
              <span>Password</span>
              <input name="password" type="text" autocomplete="current-password" required value="<?= e(ADMIN_PASSWORD) ?>">
            </label>
            <button class="admin-btn admin-btn--ghost" type="submit">Enter dashboard</button>
          </form>
        </details>

        <a class="admin-login__back" href="<?= e(url('index.php')) ?>">Back to public site</a>
      </div>
    </div>
  </main>
</body>
</html>
