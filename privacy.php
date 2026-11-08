<?php
$pageTitle = 'Privacy notice';
$pageDescription = 'How The Animals Among Us collects and uses information, including private welfare concern reports.';
$activeNav = '';
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="container container--narrow">
    <p class="section__eyebrow">Legal</p>
    <h1>Privacy notice</h1>
    <p class="lede">Short summary for this portfolio project. Expand with legal review if the site becomes an accountable operating entity.</p>
  </div>
</section>

<section class="section">
  <div class="container container--narrow prose reveal">
    <p>
      We collect only the information needed to operate the website, manage community content and review welfare
      concerns. Information submitted through the private concern form is not published. Access is limited to
      authorised reviewers and may be shared with a relevant organisation or authority only where appropriate, lawful
      and necessary for referral.
    </p>
    <p>
      We do not promise that every report will result in an investigation or intervention.
    </p>
    <h2>What this full notice should include before launch</h2>
    <ul>
      <li>Identity of the data controller / accountable organisation</li>
      <li>Lawful basis for each processing activity</li>
      <li>Retention periods for stories, contact messages and welfare reports</li>
      <li>User rights and how to exercise them</li>
      <li>Security measures for private evidence</li>
      <li>Contact point and complaint route under applicable Kenyan law</li>
    </ul>
    <p>
      Contact: <a href="mailto:<?= e(SITE_EMAIL) ?>"><?= e(SITE_EMAIL) ?></a>
    </p>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
