<?php
$pageTitle = 'Community guidelines';
$pageDescription = 'Community guidelines for respectful discussion and safe participation on The Animals Among Us.';
$activeNav = '';
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
 <div class="container container--narrow">
 <p class="section__eyebrow">Community</p>
 <h1>Community guidelines</h1>
 <p class="lede">Keep discussions respectful, useful and focused on animal welfare.</p>
 </div>
</section>

<section class="section">
 <div class="container container--narrow prose reveal">
 <p>
 <?= e(SITE_NAME) ?> exists because the animals beside us deserve a public conversation that is honest and useful.
 We welcome different experiences and perspectives: owners, handlers, professionals, neighbours and community
 organisations, as long as the focus stays on welfare, not humiliation.
 </p>
 <p>
 Keep discussions respectful and useful. Describe what you observed, share information you can support and focus
 on practical ways to improve animal wellbeing. Do not threaten, harass, expose private information or encourage
 anyone to confront another person. Posts that make unverified accusations, reveal personal details or include
 graphic material may be removed. Serious welfare concerns should be submitted through the private reporting route
 or referred directly to an appropriate local service.
 </p>
 <h2>Short version</h2>
 <ul class="checklist">
 <li>Respect animals and people.</li>
 <li>Discuss behaviour and welfare conditions, not insults or personal attacks.</li>
 <li>Share truthful information and distinguish what you saw from what you assume.</li>
 <li>Do not post private addresses, phone numbers, faces or identifying details without permission.</li>
 <li>Do not post graphic content or encourage confrontation.</li>
 <li>Do not give medical instructions unless appropriately qualified and content has been reviewed.</li>
 <li>Follow moderator decisions and use the contact route for appeals.</li>
 </ul>
 <div class="btn-row">
 <a class="btn btn--primary" href="<?= e(url('report.php')) ?>">Report a concern privately</a>
 <a class="btn btn--secondary" href="<?= e(url('contact.php')) ?>">Contact the team</a>
 </div>
 </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
