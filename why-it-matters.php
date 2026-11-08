<?php
$pageTitle = 'Why it matters';
$pageDescription = 'Why domesticated and working animals deserve everyday care: sentience, welfare needs and community roles.';
$activeNav = 'why';
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
 <div class="container">
 <p class="section__eyebrow">Why it matters</p>
 <h1>Useful to us does not mean less deserving of care.</h1>
 <p class="lede">
 Domesticated animals are part of the fabric of everyday life. They help households earn a living, support farming,
 provide food and move goods. Because they are familiar, their needs can become easy to overlook: 
 and what we overlook, we stop talking about. Familiarity should never make suffering invisible.
 </p>
 </div>
</section>

<section class="section">
 <div class="container split reveal">
 <div class="prose">
 <h2>Animals experience the conditions around them</h2>
 <p>
 Animal welfare includes an animal’s physical and mental state. Food, water, shelter, health, comfort,
 social and behavioural needs, and freedom from fear all contribute to wellbeing. The way people handle
 animals can improve or undermine those conditions.
 </p>
 </div>
 <?= site_image(
 'tau-why-environment-1000x750.jpg',
 'Cow and calf in shaded pasture with clean water nearby',
 '4 / 3',
 '',
 '1000',
 '750'
 ) ?>
 </div>
</section>

<section class="section section--soft">
 <div class="container split split--reverse reveal">
 <?= site_image(
 'tau-why-manageable-load-1000x750.jpg',
 'Working donkey with a manageable load resting beside a cart',
 '4 / 3',
 '',
 '1000',
 '750'
 ) ?>
 <div class="prose">
 <h2>Working animals need limits and attention</h2>
 <p>
 A working animal needs appropriate equipment, manageable work, suitable food and water, rest, a safe
 environment and veterinary attention when sick or injured.
 </p>
 <p>
 When a load cannot be moved safely, the answer is to stop, assess the situation and seek practical help, 
 not to increase force.
 </p>
 </div>
 </div>
</section>

<section class="section">
 <div class="container reveal">
 <h2>Owners deserve practical support too</h2>
 <p class="lede">
 Better welfare is not only a moral concern. Healthy animals are more likely to remain able to support household
 livelihoods. Education, access to animal-health services and supportive community networks can help owners make
 improvements.
 </p>
 <div class="callout">
 Economic pressure is real, but an animal should not be made to carry that pressure through avoidable suffering.
 </div>
 </div>
</section>

<section class="section section--soft">
 <div class="container reveal">
 <h2>Everyone has a role</h2>
 <div class="need-grid">
 <article class="panel">
 <h3>Owners &amp; handlers</h3>
 <p>Provide daily care: water, feed, rest, suitable equipment and observation.</p>
 </article>
 <article class="panel">
 <h3>Neighbours</h3>
 <p>Share reliable information and raise concerns safely when something looks wrong.</p>
 </article>
 <article class="panel">
 <h3>Professionals</h3>
 <p>Offer advice, treatment and reviewed educational content.</p>
 </article>
 <article class="panel">
 <h3>Organisations &amp; leaders</h3>
 <p>Provide services, encourage humane practices and coordinate referrals.</p>
 </article>
 </div>
 <div class="btn-row">
 <a class="btn btn--primary" href="<?= e(url('care-guides.php')) ?>">Start with one animal</a>
 <a class="btn btn--secondary" href="<?= e(url('take-action.php')) ?>">See ways to help</a>
 </div>
 </div>
</section>

<section class="section">
 <div class="container reveal">
 <?= site_image(
 'tau-why-panorama-1400x520.jpg',
 'Everyday scenes of domesticated and working animals in community life',
 '21 / 8',
 '',
 '1400',
 '520'
 ) ?>
 <p class="disclaimer">
 Positioning note: this platform expands compassion; it does not compete with wildlife conservation.
 Care for animals in parks and care for animals beside us can and should coexist.
 </p>
 </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
