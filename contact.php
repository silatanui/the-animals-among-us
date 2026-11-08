<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['csrf_token'] ?? null)) {
        flash_set('error', 'Your session expired. Please try again.');
        header('Location: ' . url('contact.php'));
        exit;
    }

    $name = trim((string) ($_POST['name'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $subject = trim((string) ($_POST['subject'] ?? ''));
    $message = trim((string) ($_POST['message'] ?? ''));
    $category = trim((string) ($_POST['category'] ?? ''));
    $consent = isset($_POST['consent']);

    if ($name === '' || $email === '' || $subject === '' || $message === '' || $category === '' || !$consent) {
        flash_set('error', 'Please complete all required fields and consent to be contacted.');
        header('Location: ' . url('contact.php'));
        exit;
    }

    try {
        db_save_contact([
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
            'category' => $category,
            'consent' => true,
        ]);
    } catch (Throwable $e) {
        flash_set('error', 'We could not save your message right now. Please try again shortly.');
        header('Location: ' . url('contact.php'));
        exit;
    }

    flash_set('success', 'Thank you. Your message has been received. For urgent animal welfare concerns, use the Report a Concern page.');
    header('Location: ' . url('contact.php'));
    exit;
}

$pageTitle = 'Contact';
$pageDescription = 'Contact The Animals Among Us about the platform, partnerships, content suggestions or directory corrections.';
$activeNav = 'contact';
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="container">
    <p class="section__eyebrow">Contact</p>
    <h1>Have a question, a resource or an idea for working together?</h1>
    <p class="lede">
      <?= e(SITE_NAME) ?> is a portfolio project with a clear aim: keep the conversation about everyday animal welfare alive.
      Reach out about the platform, educational content, partnership ideas or directory corrections.
      For urgent animal welfare concerns, use the
      <a href="<?= e(url('report.php')) ?>">Report a Concern</a> page. General contact messages are not monitored as an emergency channel.
    </p>
  </div>
</section>

<section class="section">
  <div class="container split reveal">
    <div>
      <?= site_image(
        'tau-contact-partnership-800x900.jpg',
        'People reviewing partnership and care-guide materials together',
        '8 / 9',
        '',
        '800',
        '900'
      ) ?>
      <div class="panel" style="margin-top:1rem;">
        <h3>Email</h3>
        <p><a href="mailto:<?= e(SITE_EMAIL) ?>"><?= e(SITE_EMAIL) ?></a></p>
        <p class="form-note">Replace with confirmed operating-entity contacts before public launch.</p>
      </div>
    </div>

    <form class="form" method="post" action="">
      <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
      <div class="form-row form-row--2">
        <div class="form-field">
          <label for="name">Name</label>
          <input id="name" name="name" required maxlength="120" autocomplete="name">
        </div>
        <div class="form-field">
          <label for="email">Email</label>
          <input id="email" name="email" type="email" required maxlength="160" autocomplete="email">
        </div>
      </div>
      <div class="form-field">
        <label for="category">Enquiry category</label>
        <select id="category" name="category" required>
          <option value="">Select…</option>
          <option>General question</option>
          <option>Educational content suggestion</option>
          <option>Partnership enquiry</option>
          <option>Directory correction</option>
          <option>Press / communications</option>
          <option>Other</option>
        </select>
      </div>
      <div class="form-field">
        <label for="subject">Subject</label>
        <input id="subject" name="subject" required maxlength="160">
      </div>
      <div class="form-field">
        <label for="message">Message</label>
        <textarea id="message" name="message" required maxlength="5000"></textarea>
      </div>
      <label class="checkbox">
        <input type="checkbox" name="consent" value="1" required>
        <span>I consent to be contacted about this enquiry and have read the <a href="<?= e(url('privacy.php')) ?>">privacy notice</a>.</span>
      </label>
      <button class="btn btn--primary" type="submit">Send message</button>
    </form>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
