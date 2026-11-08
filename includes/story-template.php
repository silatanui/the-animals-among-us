<?php
declare(strict_types=1);
$pageTitle = $storyTitle ?? 'Community story';
$pageDescription = $pageDescription ?? ($storyTitle . ' | community story from The Animals Among Us.');
$activeNav = 'community';
require __DIR__ . '/header.php';
?>

<article>
 <section class="page-hero">
 <div class="container">
 <p class="section__eyebrow">Community story</p>
 <div class="meta" style="margin-bottom:0.75rem;">
 <span class="tag"><?= e($category) ?></span>
 <span><?= e($animalType) ?></span>
 <span><?= e($publishedAt) ?></span>
 <span>By <?= e($author) ?></span>
 </div>
 <h1><?= e($storyTitle) ?></h1>
 <p class="lede"><?= e($summary) ?></p>
 </div>
 </section>

 <section class="section">
 <div class="container container--narrow reveal">
 <?= site_image(
 $heroImage ?? '',
 $heroLabel,
 '12 / 7',
 '',
 '1200',
 '700'
 ) ?>
 <div class="prose" style="margin-top:2rem;">
 <?php foreach ($paragraphs as $p): ?>
 <p><?= e($p) ?></p>
 <?php endforeach; ?>

 <div class="callout">
 <strong>What can we learn from this story?</strong>
 <?= e($takeaway) ?>
 </div>

 <h2>Related guides</h2>
 <div class="btn-row">
 <?php foreach ($relatedGuides as $g): ?>
 <a class="btn btn--secondary" href="<?= e(url($g['href'])) ?>"><?= e($g['label']) ?></a>
 <?php endforeach; ?>
 </div>

 <p class="disclaimer">
 Comments are moderated before display. Do not post accusations, private details or graphic material.
 Serious concerns belong on the <a href="<?= e(url('report.php')) ?>">private report form</a>.
 </p>
 </div>
 </div>
 </section>
</article>

<?php require __DIR__ . '/footer.php'; ?>
