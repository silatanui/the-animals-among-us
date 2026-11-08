<?php
$pageTitle = 'Take action';
$pageDescription = 'Safe, practical actions to improve the welfare of domesticated and working animals.';
$activeNav = 'action';
require __DIR__ . '/includes/header.php';

$actions = [
    [
        'title' => 'Learn',
        'copy' => 'Understand the basic needs of the animals around you. Start with a care guide and share reliable information.',
        'href' => 'care-guides.php',
        'cta' => 'Open guides',
        'icon' => 'fa-solid fa-book-open',
    ],
    [
        'title' => 'Notice',
        'copy' => 'Pay attention to signs that an animal may need water, rest, shelter or professional attention.',
        'href' => 'why-it-matters.php',
        'cta' => 'Why noticing matters',
        'icon' => 'fa-solid fa-eye',
    ],
    [
        'title' => 'Speak respectfully',
        'copy' => 'When it is safe and appropriate, encourage better practices without threats, insults or public humiliation.',
        'href' => 'community-guidelines.php',
        'cta' => 'Community guidelines',
        'icon' => 'fa-solid fa-comments',
    ],
    [
        'title' => 'Refer a concern',
        'copy' => 'Use a verified animal-welfare or veterinary contact. Share factual observations and keep yourself safe.',
        'href' => 'report.php',
        'cta' => 'Report privately',
        'icon' => 'fa-solid fa-shield-heart',
    ],
    [
        'title' => 'Support local work',
        'copy' => 'Volunteer, attend an outreach event or support a verified welfare initiative.',
        'href' => 'partners.php',
        'cta' => 'Find partners',
        'icon' => 'fa-solid fa-handshake-angle',
    ],
    [
        'title' => 'Share a positive story',
        'copy' => 'Help make humane care visible by celebrating owners and communities who are improving animal welfare.',
        'href' => 'community/submit.php',
        'cta' => 'Share a story',
        'icon' => 'fa-solid fa-pen-to-square',
    ],
    [
        'title' => 'Help grow this project',
        'copy' => 'Offer professional review, local knowledge, training, translation or verified referral support for this portfolio prototype.',
        'href' => 'contact.php',
        'cta' => 'Contact us',
        'icon' => 'fa-solid fa-seedling',
    ],
];
?>

<section class="page-hero">
  <div class="container">
    <p class="section__eyebrow">Take action</p>
    <h1>You do not have to own an animal to stand up for its wellbeing.</h1>
    <p class="lede">
      Standing up can be quiet and practical. Choose an action that is safe and within your ability.
      Change grows when communities make humane care, and honest conversation, part of ordinary life.
    </p>
  </div>
</section>

<section class="section">
  <div class="container reveal">
    <?= site_image(
      'tau-action-community-animal-care.jpg',
      'Community members practising everyday animal care together',
      '21 / 7',
      'site-media--contain',
      '1536',
      '1024'
    ) ?>
    <div class="action-grid" style="margin-top:2rem;">
      <?php foreach ($actions as $a): ?>
        <a class="action-card" href="<?= e(url($a['href'])) ?>">
          <span class="action-card__icon" aria-hidden="true">
            <i class="<?= e($a['icon']) ?>"></i>
          </span>
          <h3><?= e($a['title']) ?></h3>
          <p><?= e($a['copy']) ?></p>
          <strong class="action-card__cta"><?= e($a['cta']) ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></strong>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--deep">
  <div class="container reveal">
    <h2><i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i> Stay safe while helping</h2>
    <p>
      Do not put yourself in danger. Do not confront a person, trespass, attempt to seize an animal or provide treatment
      beyond your training. <?= e(SITE_NAME) ?> is not an emergency response service.
    </p>
    <div class="btn-row">
      <a class="btn btn--primary" href="<?= e(url('report.php')) ?>">
        <i class="fa-solid fa-shield-heart" aria-hidden="true"></i>
        Use the private concern form
      </a>
      <a class="btn btn--ghost" href="<?= e(url('partners.php')) ?>">
        <i class="fa-solid fa-address-book" aria-hidden="true"></i>
        View verified contacts
      </a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
