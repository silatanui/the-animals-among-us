<?php
$pageTitle = 'Terms of use';
$pageDescription = 'Terms of use for The Animals Among Us website.';
$activeNav = '';
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="container container--narrow">
    <p class="section__eyebrow">Legal</p>
    <h1>Terms of use</h1>
    <p class="lede">Working terms for this portfolio project website. Obtain legal review before any public organisational launch.</p>
  </div>
</section>

<section class="section">
  <div class="container container--narrow prose reveal">
    <h2>Using this website</h2>
    <p>
      <?= e(SITE_NAME) ?> is a portfolio project that provides educational information, community stories and pathways
      for responsible action related to domesticated and working animals. Content is for general information and does
      not replace veterinary advice, legal advice or emergency services.
    </p>
    <h2>Community contributions</h2>
    <p>
      Stories and comments may be reviewed, edited for clarity or declined. Do not submit unlawful content, threats,
      personal data of others without a lawful basis, or graphic material.
    </p>
    <h2>Welfare reports</h2>
    <p>
      Submitting a concern creates a private record for review. It is not a public accusation and does not guarantee
      investigation, rescue or any particular outcome.
    </p>
    <h2>Service limits</h2>
    <p>
      The platform is not an emergency dispatch service, veterinary clinic or law-enforcement body. We may update,
      suspend or remove features as operations require.
    </p>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
