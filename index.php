<?php
$pageTitle = 'The Animals Among Us';
$pageDescription = 'A portfolio project speaking up for domesticated and working animals: learning, stories and responsible action where we live.';
$activeNav = 'home';
require __DIR__ . '/includes/header.php';
?>

<section class="hero">
  <div class="hero__media" aria-hidden="true">
    <?= site_image(
      'tau-home-hero-1920x1080.jpg',
      'Working animals in daily life along a Kenyan roadside',
      '16 / 9',
      'site-media--flush img-placeholder--dark',
      '1672',
      '940'
    ) ?>
  </div>
  <div class="hero__shade"></div>
  <div class="hero__content">
    <p class="hero__brand">The Animals Among Us</p>
    <h1><?= e(t('home_hero_title')) ?></h1>
    <p><?= e(t('home_hero_body')) ?></p>
    <div class="btn-row">
      <a class="btn btn--primary" href="<?= e(url('care-guides.php')) ?>"><?= e(t('home_cta_care')) ?></a>
      <a class="btn btn--ghost" href="<?= e(url('community.php')) ?>"><?= e(t('home_cta_story')) ?></a>
    </div>
    <p style="margin-top:1rem;font-size:0.95rem;">
      <a href="<?= e(url('report.php')) ?>" style="color:var(--amber);"><?= e(t('home_cta_report')) ?></a>
    </p>
  </div>
</section>

<section class="section">
  <div class="container split reveal">
    <div>
      <p class="section__eyebrow"><?= e(t('home_overlooked_eyebrow')) ?></p>
      <h2><?= e(t('home_overlooked_title')) ?></h2>
      <p class="lede"><?= e(t('home_overlooked_lede')) ?></p>
      <p><?= e(t('home_overlooked_body')) ?></p>
    </div>
    <?= site_image(
      'tau-home-overlooked-neighbours-960x720.jpg',
      'Healthy cattle near a homestead with shade and water',
      '4 / 3',
      '',
      '960',
      '720'
    ) ?>
  </div>
</section>

<section class="section section--soft">
  <div class="container reveal">
    <p class="section__eyebrow"><?= e(t('home_care_eyebrow')) ?></p>
    <h2><?= e(t('home_care_title')) ?></h2>
    <p class="lede"><?= e(t('home_care_lede')) ?></p>
    <div class="need-grid">
      <article class="need-tile">
        <div class="need-tile__icon" aria-hidden="true">1</div>
        <h3><?= e(t('home_need_food')) ?></h3>
        <p><?= e(t('home_need_food_body')) ?></p>
      </article>
      <article class="need-tile">
        <div class="need-tile__icon" aria-hidden="true">2</div>
        <h3><?= e(t('home_need_water')) ?></h3>
        <p><?= e(t('home_need_water_body')) ?></p>
      </article>
      <article class="need-tile">
        <div class="need-tile__icon" aria-hidden="true">3</div>
        <h3><?= e(t('home_need_rest')) ?></h3>
        <p><?= e(t('home_need_rest_body')) ?></p>
      </article>
      <article class="need-tile">
        <div class="need-tile__icon" aria-hidden="true">4</div>
        <h3><?= e(t('home_need_health')) ?></h3>
        <p><?= e(t('home_need_health_body')) ?></p>
      </article>
      <article class="need-tile">
        <div class="need-tile__icon" aria-hidden="true">5</div>
        <h3><?= e(t('home_need_handling')) ?></h3>
        <p><?= e(t('home_need_handling_body')) ?></p>
      </article>
    </div>
  </div>
</section>

<section class="section">
  <div class="container reveal">
    <div class="split">
      <div>
        <p class="section__eyebrow"><?= e(t('home_stories_eyebrow')) ?></p>
        <h2><?= e(t('home_stories_title')) ?></h2>
        <p class="lede"><?= e(t('home_stories_lede')) ?></p>
      </div>
      <div class="btn-row" style="align-self:end;justify-content:flex-end;">
        <a class="btn btn--secondary" href="<?= e(url('community.php')) ?>"><?= e(t('home_stories_all')) ?></a>
      </div>
    </div>
    <div class="story-grid">
      <a class="story-card" href="<?= e(url('community/story-water-rest.php')) ?>">
        <?= site_image('tau-home-story-water-640x400.jpg', 'Working donkeys at a clean water point', '16 / 10', '', '640', '400') ?>
        <span class="tag">Positive care</span>
        <h3>Clean water changed our mornings</h3>
        <p>A market transporter describes how a simple water stop reduced exhaustion for two working donkeys.</p>
      </a>
      <a class="story-card" href="<?= e(url('community/story-harness.php')) ?>">
        <?= site_image('tau-home-story-harness-640x400.jpg', 'Owner adjusting a fitted donkey harness', '16 / 10', '', '640', '400') ?>
        <span class="tag">Learning moment</span>
        <h3>What a better harness taught us</h3>
        <p>An owner shares how checking sores and adjusting equipment protected both the animal and the livelihood.</p>
      </a>
      <a class="story-card" href="<?= e(url('community/story-school.php')) ?>">
        <?= site_image('tau-home-story-school-640x400.jpg', 'Youth group with animal-care learning posters', '16 / 10', '', '640', '400') ?>
        <span class="tag">School &amp; youth</span>
        <h3>Students map the animals beside us</h3>
        <p>A classroom project helps young people notice welfare needs in animals they see every day.</p>
      </a>
    </div>
  </div>
</section>

<section class="section section--soft">
  <div class="container reveal">
    <p class="section__eyebrow"><?= e(t('home_guides_eyebrow')) ?></p>
    <h2><?= e(t('home_guides_title')) ?></h2>
    <p class="lede"><?= e(t('home_guides_lede')) ?></p>
    <div class="guide-grid">
      <a class="guide-card" href="<?= e(url('care-guides/donkeys.php')) ?>">
        <?= site_image('tau-home-guide-donkeys-480x320.jpg', 'Working donkey resting in shade', '3 / 2', '', '480', '320') ?>
        <h3>Donkeys &amp; horses</h3>
        <p>Water, feeding, harness fit, workload and when to seek help.</p>
      </a>
      <a class="guide-card" href="<?= e(url('care-guides/cattle.php')) ?>">
        <?= site_image('tau-home-guide-cattle-480x320.jpg', 'Cattle with access to shade and water', '3 / 2', '', '480', '320') ?>
        <h3>Cattle &amp; oxen</h3>
        <p>Feeding basics, shelter, handling and signs of illness.</p>
      </a>
      <a class="guide-card" href="<?= e(url('care-guides/goats-sheep.php')) ?>">
        <?= site_image('tau-home-guide-goats-sheep-480x320.jpg', 'Goats and sheep near suitable housing', '3 / 2', '', '480', '320') ?>
        <h3>Goats &amp; sheep</h3>
        <p>Housing, feed, flock health and humane handling.</p>
      </a>
      <a class="guide-card" href="<?= e(url('care-guides/poultry.php')) ?>">
        <?= site_image('tau-home-guide-poultry-480x320.jpg', 'Poultry housing with clean waterers', '3 / 2', '', '480', '320') ?>
        <h3>Poultry</h3>
        <p>Housing, hygiene, feed and disease warning signs.</p>
      </a>
    </div>
    <div class="btn-row">
      <a class="btn btn--primary" href="<?= e(url('care-guides.php')) ?>"><?= e(t('home_guides_all')) ?></a>
    </div>
  </div>
</section>

<section class="section section--deep">
  <div class="container reveal">
    <p class="section__eyebrow"><?= e(t('home_change_eyebrow')) ?></p>
    <h2><?= e(t('home_change_title')) ?></h2>
    <p class="lede"><?= e(t('home_change_lede')) ?></p>
    <div class="btn-row">
      <a class="btn btn--primary" href="<?= e(url('take-action.php')) ?>"><?= e(t('home_change_cta')) ?></a>
      <a class="btn btn--ghost" href="<?= e(url('partners.php')) ?>"><?= e(t('home_partners_find')) ?></a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container reveal">
    <p class="section__eyebrow"><?= e(t('home_partners_eyebrow')) ?></p>
    <h2><?= e(t('home_partners_title')) ?></h2>
    <p class="lede"><?= e(t('home_partners_lede')) ?></p>
    <div class="partner-strip">
      <?= site_image('tau-partner-sample-welfare-640x280.jpg', 'Sample welfare organisation cover', '7 / 3', 'partner-logo', '640', '280') ?>
      <?= site_image('tau-partner-sample-vet-640x280.jpg', 'Sample veterinary provider cover', '7 / 3', 'partner-logo', '640', '280') ?>
      <?= site_image('tau-partner-sample-community-640x280.jpg', 'Sample community initiative cover', '7 / 3', 'partner-logo', '640', '280') ?>
      <?= site_image('tau-home-veterinary-care-640x400.jpg', 'Veterinary and animal-health care', '7 / 3', 'partner-logo', '640', '400') ?>
    </div>
    <div class="btn-row">
      <a class="btn btn--secondary" href="<?= e(url('partners.php')) ?>"><?= e(t('home_partners_open')) ?></a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
