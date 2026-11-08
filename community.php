<?php
$pageTitle = 'Community stories';
$pageDescription = 'Everyday care stories from owners, neighbours, youth groups and community initiatives.';
$activeNav = 'community';
require __DIR__ . '/includes/header.php';

$stories = [
 [
 'href' => 'community/story-water-rest.php',
 'tag' => 'Positive care',
 'title' => 'Clean water changed our mornings',
 'excerpt' => 'A market transporter describes how a simple water stop reduced exhaustion for two working donkeys.',
 'image' => 'tau-home-story-water-640x400.jpg',
 'alt' => 'Working donkeys drinking at a clean water point',
 ],
 [
 'href' => 'community/story-harness.php',
 'tag' => 'Learning moment',
 'title' => 'What a better harness taught us',
 'excerpt' => 'An owner shares how checking sores and adjusting equipment protected both the animal and the livelihood.',
 'image' => 'tau-home-story-harness-640x400.jpg',
 'alt' => 'Owner adjusting a padded donkey harness',
 ],
 [
 'href' => 'community/story-school.php',
 'tag' => 'School & youth',
 'title' => 'Students map the animals beside us',
 'excerpt' => 'A classroom project helps young people notice welfare needs in animals they see every day.',
 'image' => 'tau-home-story-school-640x400.jpg',
 'alt' => 'Students outdoors with animal-care posters',
 ],
];
?>

<section class="page-hero">
 <div class="container">
 <p class="section__eyebrow">Community</p>
 <h1>Everyday care deserves a place in the conversation.</h1>
 <p class="lede">
 If we only talk about animals when something goes viral or tragic, we miss the ordinary moments that shape their lives.
 This is a space for people who notice, care and take positive steps. Share a lesson, a kindness or a change that made an animal safer.
 </p>
 <div class="btn-row">
 <a class="btn btn--primary" href="<?= e(url('community/submit.php')) ?>">Share a story</a>
 </div>
 </div>
</section>

<section class="section">
 <div class="container reveal">
 <div class="meta" style="margin-bottom:1rem;">
 <span class="tag">Positive care</span>
 <span class="tag">Community initiatives</span>
 <span class="tag">Learning moments</span>
 <span class="tag">Owner experiences</span>
 <span class="tag">School &amp; youth</span>
 <span class="tag">Events &amp; outreach</span>
 </div>
 <p>
 Read, learn and encourage one another. Keep contributions respectful, factual and focused on animal welfare.
 Stories that identify or accuse a private individual, expose personal details or contain graphic material will not be published.
 </p>
 <div class="story-grid">
 <?php foreach ($stories as $s): ?>
 <a class="story-card" href="<?= e(url($s['href'])) ?>">
 <?= site_image($s['image'], $s['alt'], '16 / 10', '', '640', '420') ?>
 <span class="tag"><?= e($s['tag']) ?></span>
 <h3><?= e($s['title']) ?></h3>
 <p><?= e($s['excerpt']) ?></p>
 </a>
 <?php endforeach; ?>
 </div>
 </div>
</section>

<section class="section section--soft">
 <div class="container split reveal">
 <div>
 <h2>Community principles</h2>
 <ul class="checklist">
 <li>Listen before judging; seek practical improvement.</li>
 <li>Promote humane solutions that also respect livelihoods.</li>
 <li>Keep people safe: no confrontation, trespass or seizure.</li>
 <li>Protect children and vulnerable people from exposure.</li>
 <li>No public case trials: use private reporting for serious concerns.</li>
 </ul>
 <a class="btn btn--secondary" href="<?= e(url('community-guidelines.php')) ?>">Read full guidelines</a>
 </div>
    <?= site_image(
      'tau-home-community-animal-welfare-1536x1024.jpg',
      'A community that cares for everyday animal welfare',
      '',
      'site-media--contain',
      '1536',
      '1024'
    ) ?>
 </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
