<?php
$pageTitle = 'Partner directory';
$pageDescription = 'Find reviewed animal-welfare organisations, veterinary services and community initiatives.';
$activeNav = '';
require __DIR__ . '/includes/header.php';

$partners = [
    [
        'name' => 'Sample welfare organisation',
        'summary' => 'Placeholder listing for a verified animal-welfare organisation serving working animals.',
        'services' => 'Advice · outreach · referrals',
        'coverage' => 'Nairobi and surrounding counties (example)',
        'animals' => 'Donkeys, dogs, cats',
        'verified' => 'Pending verification',
        'image' => 'tau-partner-sample-welfare-640x280.jpg',
    ],
    [
        'name' => 'Sample veterinary / animal-health provider',
        'summary' => 'Placeholder for a clinic or animal-health provider offering community services.',
        'services' => 'Clinical care · owner education',
        'coverage' => 'Central Kenya (example)',
        'animals' => 'Cattle, goats, sheep, poultry',
        'verified' => 'Pending verification',
        'image' => 'tau-partner-sample-vet-640x280.jpg',
    ],
    [
        'name' => 'Sample community initiative',
        'summary' => 'Placeholder for a local initiative training owners on humane handling and daily care.',
        'services' => 'Training · community sessions',
        'coverage' => 'Coastal region (example)',
        'animals' => 'Working equids',
        'verified' => 'Pending verification',
        'image' => 'tau-partner-sample-community-640x280.jpg',
    ],
];
?>

<section class="page-hero">
  <div class="container">
    <p class="section__eyebrow">Partners</p>
    <h1>Find people and organisations working to improve animal welfare.</h1>
    <p class="lede">
      Speaking up is stronger when it connects people to those already doing the work. This directory pattern helps
      visitors find credible welfare organisations, veterinary services, animal-health providers and community
      initiatives. Sample listings below are illustrative until partners are verified and consent to appear.
    </p>
  </div>
</section>

<section class="section">
  <div class="container reveal">
    <div class="callout">
      A listing is not a guarantee of service availability or endorsement of every activity. Contact the organisation
      directly to confirm services, fees, hours and eligibility. No organisation is presented as a formal partner without consent.
    </div>

    <div class="story-grid" style="margin-top:2rem;">
      <?php foreach ($partners as $p): ?>
        <article class="panel">
          <?= site_image($p['image'], $p['name'] . ' cover image', '16 / 7', '', '640', '280') ?>
          <div class="meta" style="margin-top:0.85rem;">
            <span class="tag tag--amber"><?= e($p['verified']) ?></span>
            <span><?= e($p['animals']) ?></span>
          </div>
          <h3><?= e($p['name']) ?></h3>
          <p><?= e($p['summary']) ?></p>
          <p><strong>Services:</strong> <?= e($p['services']) ?></p>
          <p><strong>Coverage:</strong> <?= e($p['coverage']) ?></p>
          <p class="form-note">Phone, email and website fields appear here after verification.</p>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="btn-row">
      <a class="btn btn--primary" href="<?= e(url('contact.php')) ?>">Request a listing or update</a>
      <a class="btn btn--secondary" href="<?= e(url('report.php')) ?>">Report a concern</a>
    </div>
  </div>
</section>

<section class="section section--soft">
  <div class="container split reveal">
    <div>
      <h2>Events &amp; outreach</h2>
      <p>
        Community care grows when people learn together. Join a local conversation, animal-care training session or
        volunteer activity. Events will list only confirmed activities with organiser, venue or online access, date,
        time, accessibility information and registration requirements.
      </p>
      <p class="form-note">Event listings will appear here once partners confirm dates and details.</p>
    </div>
    <?= site_image(
      'tau-partners-outreach-event-900x650.jpg',
      'Community outreach and training focused on working-animal care',
      '9 / 6.5',
      '',
      '900',
      '650'
    ) ?>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
