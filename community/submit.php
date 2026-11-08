<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 if (!csrf_validate($_POST['csrf_token'] ?? null)) {
 flash_set('error', 'Your session expired. Please try again.');
 header('Location: ' . url('community/submit.php'));
 exit;
 }

 $title = trim((string) ($_POST['title'] ?? ''));
 $body = trim((string) ($_POST['body'] ?? ''));
 $animal = trim((string) ($_POST['animal_type'] ?? ''));
 $location = trim((string) ($_POST['location'] ?? ''));
 $name = trim((string) ($_POST['display_name'] ?? ''));
 $consent = isset($_POST['consent']);

 if ($title === '' || $body === '' || $animal === '' || $name === '' || !$consent) {
 flash_set('error', 'Please complete the required fields and confirm consent.');
 header('Location: ' . url('community/submit.php'));
 exit;
 }

 try {
  $photoPath = store_upload($_FILES['photo'] ?? [], 'stories');
  db_save_story([
   'status' => 'pending_moderation',
   'title' => $title,
   'body' => $body,
   'animal_type' => $animal,
   'location' => $location,
   'display_name' => $name,
   'category' => trim((string) ($_POST['category'] ?? '')),
   'photo_path' => $photoPath,
   'consent' => true,
  ]);
 } catch (Throwable $e) {
  flash_set('error', $e->getMessage() !== '' ? $e->getMessage() : 'We could not save your story right now. Please try again shortly.');
  header('Location: ' . url('community/submit.php'));
  exit;
 }

 flash_set('success', 'Thank you. Your story was received and will be reviewed before publication.');
 header('Location: ' . url('community.php'));
 exit;
}

$pageTitle = 'Share a story';
$pageDescription = 'Submit a community story about animal care for moderation and possible publication.';
$activeNav = 'community';
require dirname(__DIR__) . '/includes/header.php';
?>

<section class="page-hero">
 <div class="container">
 <p class="section__eyebrow">Community</p>
 <h1>Share a story</h1>
 <p class="lede">
 Add a title, your experience, the animal type, an approximate location if relevant, and an optional photograph.
 You must confirm that you have permission to share any image you upload.
 </p>
 </div>
</section>

<section class="section">
 <div class="container container--narrow reveal">
    <?= site_image(
      'tau-home-community-water-feeding-1536x1024.jpg',
      'Community water and feeding station for shared animal care',
      '',
      'site-media--contain',
      '1536',
      '1024'
    ) ?>
 <form class="form" method="post" action="" style="margin-top:1.5rem;" enctype="multipart/form-data">
 <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
 <div class="form-field">
 <label for="title">Story title</label>
 <input id="title" name="title" required maxlength="140">
 </div>
 <div class="form-row form-row--2">
 <div class="form-field">
 <label for="display_name">Display name</label>
 <input id="display_name" name="display_name" required maxlength="80">
 </div>
 <div class="form-field">
 <label for="animal_type">Animal type</label>
 <select id="animal_type" name="animal_type" required>
 <option value="">Select…</option>
 <option>Donkey</option>
 <option>Horse</option>
 <option>Cattle</option>
 <option>Ox</option>
 <option>Goat</option>
 <option>Sheep</option>
 <option>Poultry</option>
 <option>Dog</option>
 <option>Cat</option>
 <option>Other / multiple</option>
 </select>
 </div>
 </div>
 <div class="form-row form-row--2">
 <div class="form-field">
 <label for="category">Category</label>
 <select id="category" name="category">
 <option>Positive care stories</option>
 <option>Community initiatives</option>
 <option>Learning moments</option>
 <option>Owner experiences</option>
 <option>School and youth projects</option>
 <option>Events and outreach</option>
 </select>
 </div>
 <div class="form-field">
 <label for="location">Approximate location <span class="hint">(optional)</span></label>
 <input id="location" name="location" maxlength="120" placeholder="County / town or area">
 </div>
 </div>
 <div class="form-field">
 <label for="body">Your story</label>
 <textarea id="body" name="body" required maxlength="8000" placeholder="Describe what happened and what others can learn."></textarea>
 </div>
 <div class="form-field">
 <label for="photo">Optional photograph</label>
 <input id="photo" name="photo" type="file" accept="image/*">
 <span class="hint">Do not upload graphic images or photos that identify private individuals without permission. Preferred future size: 1200×700 px.</span>
 </div>
 <label class="checkbox">
 <input type="checkbox" name="consent" value="1" required>
 <span>
 I confirm that this story is based on my experience or information I am allowed to share. I have permission
 to submit any photograph included. I understand an editor may contact me, request changes or decline publication.
 I will not include private information about another person without a lawful basis and appropriate permission.
 </span>
 </label>
 <button class="btn btn--primary" type="submit">Submit story for review</button>
 </form>
 </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
