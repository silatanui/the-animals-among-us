<?php
declare(strict_types=1);
/**
 * Shared care-guide detail layout.
 * Expected vars: $guideTitle, $animalTag, $readingTime, $reviewedAt, $heroLabel, $heroBrief,
 * $intro, $checklist (array), $whenToCall (array), $reviewer
 * Optional: $heroImage, $secondaryImage
 */
$pageTitle = $guideTitle ?? 'Care guide';
$pageDescription = $pageDescription ?? ($guideTitle . ' | practical welfare guidance from The Animals Among Us.');
$activeNav = 'guides';
require __DIR__ . '/header.php';
?>

<section class="page-hero">
 <div class="container">
 <p class="section__eyebrow">Care guide</p>
 <div class="meta" style="margin-bottom:0.75rem;">
 <span class="tag"><?= e($animalTag) ?></span>
 <span><?= e($readingTime) ?> read</span>
 <span>Last reviewed: <?= e($reviewedAt) ?></span>
 </div>
 <h1><?= e($guideTitle) ?></h1>
 <p class="lede"><?= e($intro) ?></p>
 </div>
</section>

<section class="section">
 <div class="container split reveal">
 <div class="prose">
 <h2>Daily care checklist</h2>
 <ul class="checklist">
 <?php foreach ($checklist as $item): ?>
 <li><?= e($item) ?></li>
 <?php endforeach; ?>
 </ul>
 <h2>When to call a professional</h2>
 <ul class="checklist">
 <?php foreach ($whenToCall as $item): ?>
 <li><?= e($item) ?></li>
 <?php endforeach; ?>
 </ul>
 <div class="callout callout--warn">
 Do not rely on guesswork when an animal is in pain. Contact a veterinarian or trained animal-health provider.
 </div>
 <p class="disclaimer">
 Reviewer: <?= e($reviewer) ?>. This content is for general education only and does not replace professional care.
 <?= e(SITE_NAME) ?> does not diagnose or prescribe treatment online.
 </p>
 <div class="btn-row">
 <a class="btn btn--primary" href="<?= e(url('care-guides.php')) ?>">All guides</a>
 <a class="btn btn--secondary" href="<?= e(url('partners.php')) ?>">Find verified help</a>
 </div>
 </div>
 <div>
 <?= site_image(
 $heroImage ?? '',
 $heroLabel,
 '4 / 5',
 '',
 '800',
 '1000'
 ) ?>
 <?= site_image(
 $secondaryImage ?? '',
 $secondaryLabel ?? 'Care detail: environment',
 '8 / 5',
 '',
 '800',
 '500'
 ) ?>
 </div>
 </div>
</section>

<?php require __DIR__ . '/footer.php'; ?>
