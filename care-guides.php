<?php
$pageTitle = 'Care guides';
$pageDescription = 'Practical, reviewed care guides for donkeys, cattle, goats, sheep, poultry, dogs and cats.';
$activeNav = 'guides';
require __DIR__ . '/includes/header.php';

$guides = [
    [
        'href' => 'care-guides/donkeys.php',
        'title' => 'Donkeys & horses',
        'topics' => 'Daily care · harness fit · workload · hoof care',
        'image' => 'tau-guides-cover-donkeys-640x420.jpg',
        'alt' => 'Healthy working donkey resting near shade and water',
    ],
    [
        'href' => 'care-guides/cattle.php',
        'title' => 'Cattle & oxen',
        'topics' => 'Water · feeding · shelter · illness signs',
        'image' => 'tau-guides-cover-cattle-640x420.jpg',
        'alt' => 'Cattle at a water trough with shade nearby',
    ],
    [
        'href' => 'care-guides/goats-sheep.php',
        'title' => 'Goats & sheep',
        'topics' => 'Housing · flock health · humane handling',
        'image' => 'tau-guides-cover-goats-sheep-640x420.jpg',
        'alt' => 'Goats and sheep near suitable housing',
    ],
    [
        'href' => 'care-guides/poultry.php',
        'title' => 'Poultry',
        'topics' => 'Housing · hygiene · disease warning signs',
        'image' => 'tau-guides-cover-poultry-640x420.jpg',
        'alt' => 'Well-kept poultry housing with clean feeders and waterers',
    ],
    [
        'href' => 'care-guides/dogs-cats.php',
        'title' => 'Dogs & cats',
        'topics' => 'Ownership · vaccinations · safe handling',
        'image' => 'tau-guides-cover-dogs-cats-640x420.jpg',
        'alt' => 'Companion dog or cat with a caring guardian',
    ],
];
?>

<section class="page-hero">
  <div class="container">
    <p class="section__eyebrow">Care guides</p>
    <h1>Practical care starts with understanding what an animal needs.</h1>
    <p class="lede">
      Explore simple, reviewed guides about feeding, clean water, shelter, rest, humane handling, health checks
      and when to seek veterinary help.
    </p>
  </div>
</section>

<section class="section">
  <div class="container reveal">
    <div class="callout callout--warn">
      These guides provide general education. They do not replace a veterinarian or a qualified animal-health professional.
      Never attempt a treatment based only on an online post.
    </div>
    <div class="guide-grid">
      <?php foreach ($guides as $g): ?>
        <a class="guide-card" href="<?= e(url($g['href'])) ?>">
          <?= site_image($g['image'], $g['alt'], '16 / 10', '', '640', '420') ?>
          <h3><?= e($g['title']) ?></h3>
          <p><?= e($g['topics']) ?></p>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--soft">
  <div class="container split reveal">
    <?= site_image(
      'tau-guides-library-overview-900x600.jpg',
      'Printed care checklists and learning materials for animal welfare',
      '3 / 2',
      '',
      '900',
      '600'
    ) ?>
    <div>
      <h2>What each guide includes</h2>
      <ul class="checklist">
        <li>Reading time and last reviewed date</li>
        <li>Animal type and topic tags</li>
        <li>Clear short sections with checklists</li>
        <li>“When to call a professional” guidance</li>
        <li>Source / reviewer name where consented</li>
        <li>A clear educational disclaimer</li>
      </ul>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
