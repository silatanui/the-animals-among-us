<?php
$pageTitle = 'About';
$pageDescription = 'Why The Animals Among Us was built: a portfolio project speaking up for the domesticated and working animals we live beside every day.';
$activeNav = 'about';
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="container">
    <p class="section__eyebrow"><?= e(t('about_eyebrow')) ?></p>
    <h1><?= e(t('about_title')) ?></h1>
    <p class="lede"><?= e(t('about_lede')) ?></p>
  </div>
</section>

<section class="section">
  <div class="container split reveal">
    <div class="prose">
      <h2>Why this exists</h2>
      <p>
        Around me, domesticated and working animals carry real loads, literally and figuratively.
        Donkeys pull carts. Cattle feed families. Dogs and cats share compounds. Poultry and goats
        sit at the edge of everyday life. Their usefulness is visible. Their welfare too often is not.
      </p>
      <p>
        I built this project because silence helps nothing. Care for wildlife in parks and reserves
        matters, and so does care for the animals we meet before we ever reach a gate. Someone needs
        to name that gap, keep the tone respectful, and point people toward practical next steps.
      </p>
      <div class="callout">
        This is not a finished organisation or an emergency service. It is a public, working prototype:
        a portfolio piece with a clear conscience. It offers education, community stories, responsible reporting
        pathways and room to grow with partners who already do the hard work on the ground.
      </div>
    </div>
    <?= site_image(
      'tau-home-story-young-generation-640x400.jpg',
      'A child gently caring for a donkey beside clean drinking water',
      '16 / 10',
      'site-media--contain',
      '640',
      '400'
    ) ?>
  </div>
</section>

<section class="section section--soft">
  <div class="container reveal">
    <h2>What standing up looks like here</h2>
    <p class="lede">
      Speaking up does not mean shaming owners or turning social media into a courtroom. Many families
      depend on animals for income, transport and food. The goal is clearer care, safer action and
      honest conversation, not humiliation.
    </p>
    <div class="need-grid" style="margin-top:2rem;">
      <article class="panel">
        <h3>Notice</h3>
        <p>Pay attention to the animals that share our everyday routes and compounds.</p>
      </article>
      <article class="panel">
        <h3>Learn</h3>
        <p>Share simple, practical knowledge about water, rest, feed, equipment and health.</p>
      </article>
      <article class="panel">
        <h3>Speak responsibly</h3>
        <p>Describe what you see. Avoid insults, public accusations and unsafe confrontation.</p>
      </article>
      <article class="panel">
        <h3>Connect</h3>
        <p>Point concerns toward verified welfare contacts and professional help when needed.</p>
      </article>
    </div>
  </div>
</section>

<section class="section">
  <div class="container split split--reverse reveal">
    <?= site_image(
      'tau-about-collaboration-900x650.jpg',
      'Owners, veterinary staff and community facilitators reviewing care guidance outdoors',
      '',
      'site-media--contain',
      '900',
      '650'
    ) ?>
    <div class="prose">
      <h2>A portfolio with a purpose</h2>
      <p>
        <?= e(SITE_NAME) ?> demonstrates what a Kenya-first community platform for domesticated and
        working animals could look like: clear messaging, care guides, stories, a private concern form
        and a partner directory pattern.
      </p>
      <p>
        If you are a veterinarian, welfare organisation, teacher, owner or neighbour who wants to help
        refine the content, verify contacts or take this idea further, I want to hear from you.
        The animals among us deserve more than indifference, and this project is one way of saying so.
      </p>
      <div class="callout callout--warn">
        <strong>Honest limits:</strong> this site is not an emergency dispatch service, veterinary clinic,
        public register of alleged offenders, or a channel for confrontation.
      </div>
      <div class="btn-row">
        <a class="btn btn--primary" href="<?= e(url('take-action.php')) ?>">See ways to help</a>
        <a class="btn btn--secondary" href="<?= e(url('contact.php')) ?>">Get in touch</a>
      </div>
    </div>
  </div>
</section>

<section class="section section--deep">
  <div class="container reveal">
    <h2>Mission &amp; vision</h2>
    <div class="split" style="align-items:start;">
      <div>
        <h3>Mission</h3>
        <p>
          To open a caring, informed conversation about the everyday welfare of domesticated and working
          animals through education, shared experiences, responsible action and trusted connections.
        </p>
      </div>
      <div>
        <h3>Vision</h3>
        <p>
          Communities where every animal is treated with dignity, where people understand that animals can experience
          pain and distress, and where earning a living never requires indifference to an animal’s welfare.
        </p>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
