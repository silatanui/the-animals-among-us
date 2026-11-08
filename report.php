<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$reportSuccess = null;
$reportError = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['csrf_token'] ?? null)) {
        $reportError = 'Your session expired. Please try again.';
    } else {
        $animal = trim((string) ($_POST['animal_type'] ?? ''));
        $observations = trim((string) ($_POST['observations'] ?? ''));
        $concerns = $_POST['concern_types'] ?? [];
        if (!is_array($concerns)) {
            $concerns = [];
        }
        $privacy = isset($_POST['privacy_confirm']);
        $danger = trim((string) ($_POST['immediate_danger'] ?? ''));
        $county = trim((string) ($_POST['county'] ?? ''));
        $area = trim((string) ($_POST['area'] ?? ''));

        if ($animal === '' || $observations === '' || $concerns === [] || !$privacy || $danger === '' || $county === '' || $area === '') {
            $reportError = 'Please complete the required fields, select at least one concern type, and confirm the privacy notice.';
        } else {
            $reference = 'TAU-' . strtoupper(bin2hex(random_bytes(3)));
            try {
                db_save_report([
                    'reference_code' => $reference,
                    'status' => 'received',
                    'animal_type' => $animal,
                    'concern_types' => array_values($concerns),
                    'observations' => $observations,
                    'event_date' => trim((string) ($_POST['event_date'] ?? '')),
                    'event_time' => trim((string) ($_POST['event_time'] ?? '')),
                    'not_sure_when' => isset($_POST['not_sure_when']),
                    'county' => $county,
                    'area' => $area,
                    'precise_location' => trim((string) ($_POST['precise_location'] ?? '')),
                    'immediate_danger' => $danger,
                    'contact_name' => trim((string) ($_POST['contact_name'] ?? '')),
                    'contact_email' => trim((string) ($_POST['contact_email'] ?? '')),
                    'contact_phone' => trim((string) ($_POST['contact_phone'] ?? '')),
                ]);
                $reportSuccess = $reference;
            } catch (Throwable $e) {
                $reportError = 'We could not save your report right now. Please try again shortly.';
            }
        }
    }
}

$pageTitle = 'Report a welfare concern';
$pageDescription = 'Private form to share a concern about an animal that may be distressed, injured, neglected or mistreated.';
$activeNav = 'report';
$bodyClass = 'page-report';
require __DIR__ . '/includes/header.php';

$concernTypes = [
    'Possible overwork',
    'Lack of water or food',
    'Injury or illness',
    'Unsafe housing',
    'Harmful handling',
    'Abandonment',
    'Other',
];
?>

<section class="page-hero page-hero--compact">
  <div class="container">
    <p class="section__eyebrow"><?= e(t('report_eyebrow')) ?></p>
    <h1><?= e(t('report_title')) ?></h1>
    <p class="lede"><?= e(t('report_lede')) ?></p>
  </div>
</section>

<section class="section section--report">
  <div class="container">

    <aside class="report-safety" aria-label="<?= e(t('report_safety_title')) ?>">
      <div class="report-safety__grid">
        <div>
          <h2><?= e(t('report_safety_title')) ?></h2>
          <ul class="report-safety__list">
            <li><?= e(t('report_safety_1')) ?></li>
            <li><?= e(t('report_safety_2')) ?></li>
            <li><?= e(t('report_safety_3')) ?></li>
            <li><?= e(t('report_safety_4')) ?></li>
          </ul>
        </div>
        <div class="report-safety__aside">
          <p><?= e(t('report_need_contact')) ?></p>
          <a class="btn btn--secondary" href="<?= e(url('partners.php')) ?>"><?= e(t('report_open_partners')) ?></a>
        </div>
      </div>
    </aside>

    <?php if ($reportSuccess): ?>
      <div class="report-success reveal is-visible" role="status">
        <p class="report-success__eyebrow"><?= e(t('report_success_eyebrow')) ?></p>
        <h2><?= e(t('report_success_title')) ?></h2>
        <p><?= e(t('report_success_body')) ?></p>
        <p class="report-success__code" aria-label="Reference code"><?= e($reportSuccess) ?></p>
        <p class="report-success__note">
          <?= e(t('report_success_note')) ?>
          <a href="<?= e(url('partners.php')) ?>"><?= e(t('footer_partners')) ?></a>.
        </p>
        <div class="btn-row">
          <a class="btn btn--primary" href="<?= e(url('care-guides.php')) ?>"><?= e(t('report_success_guides')) ?></a>
          <a class="btn btn--secondary" href="<?= e(url('report.php')) ?>"><?= e(t('report_success_another')) ?></a>
        </div>
      </div>
    <?php else: ?>

      <?php if ($reportError): ?>
        <div class="report-error" role="alert">
          <p><?= e($reportError) ?></p>
        </div>
      <?php endif; ?>

      <div class="report-layout reveal">
        <form class="form form--report" method="post" action="" enctype="multipart/form-data" novalidate>
          <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

          <section class="form-section">
            <header class="form-section__head">
              <span class="form-section__step">1</span>
              <div>
                <h2><?= e(t('report_step1')) ?></h2>
                <p><?= e(t('report_step1_help')) ?></p>
              </div>
            </header>

            <div class="form-field">
              <label for="animal_type"><?= e(t('report_animal_type')) ?></label>
              <select id="animal_type" name="animal_type" required>
                <option value=""><?= e(t('report_select')) ?></option>
                <option>Donkey</option>
                <option>Horse</option>
                <option>Cattle</option>
                <option>Ox</option>
                <option>Goat</option>
                <option>Sheep</option>
                <option>Poultry</option>
                <option>Dog</option>
                <option>Cat</option>
                <option>Other</option>
                <option value="Unsure"><?= e(t('report_unsure')) ?></option>
              </select>
            </div>

            <fieldset class="form-field">
              <legend><?= e(t('report_concern_type')) ?> <span class="hint"><?= e(t('report_select_all')) ?></span></legend>
              <div class="chip-list">
                <?php foreach ($concernTypes as $type): ?>
                  <label class="chip">
                    <input type="checkbox" name="concern_types[]" value="<?= e($type) ?>">
                    <span><?= e($type) ?></span>
                  </label>
                <?php endforeach; ?>
              </div>
            </fieldset>
          </section>

          <section class="form-section">
            <header class="form-section__head">
              <span class="form-section__step">2</span>
              <div>
                <h2><?= e(t('report_step2')) ?></h2>
                <p><?= e(t('report_step2_help')) ?></p>
              </div>
            </header>

            <div class="form-field">
              <label for="observations"><?= e(t('report_observation')) ?></label>
              <textarea
                id="observations"
                name="observations"
                required
                maxlength="8000"
                placeholder="Example: Around 7am near the market junction, a donkey pulling a cart appeared unsteady and was not offered water during a long stop."
              ></textarea>
              <span class="hint"><?= e(t('report_observation_hint')) ?></span>
            </div>
          </section>

          <section class="form-section">
            <header class="form-section__head">
              <span class="form-section__step">3</span>
              <div>
                <h2><?= e(t('report_step3')) ?></h2>
                <p><?= e(t('report_step3_help')) ?></p>
              </div>
            </header>

            <div class="form-row form-row--2" id="when-fields">
              <div class="form-field">
                <label for="event_date"><?= e(t('report_date')) ?></label>
                <input id="event_date" name="event_date" type="date">
              </div>
              <div class="form-field">
                <label for="event_time"><?= e(t('report_time')) ?></label>
                <input id="event_time" name="event_time" type="time">
              </div>
            </div>

            <label class="checkbox">
              <input type="checkbox" name="not_sure_when" id="not_sure_when" value="1">
              <span><?= e(t('report_not_sure_when')) ?></span>
            </label>

            <div class="form-row form-row--2">
              <div class="form-field">
                <label for="county"><?= e(t('report_county')) ?></label>
                <input id="county" name="county" required maxlength="120" autocomplete="address-level1">
              </div>
              <div class="form-field">
                <label for="area"><?= e(t('report_area')) ?></label>
                <input id="area" name="area" required maxlength="120" autocomplete="address-level2">
              </div>
            </div>

            <div class="form-field">
              <label for="precise_location"><?= e(t('report_precise')) ?> <span class="hint"><?= e(t('report_optional')) ?></span></label>
              <input id="precise_location" name="precise_location" maxlength="200" placeholder="Road, market, landmark or nearest known point">
            </div>
          </section>

          <section class="form-section">
            <header class="form-section__head">
              <span class="form-section__step">4</span>
              <div>
                <h2><?= e(t('report_step4')) ?></h2>
                <p><?= e(t('report_step4_help')) ?></p>
              </div>
            </header>

            <div class="form-field">
              <label for="immediate_danger"><?= e(t('report_danger')) ?></label>
              <select id="immediate_danger" name="immediate_danger" required>
                <option value=""><?= e(t('report_select')) ?></option>
                <option value="yes"><?= e(t('report_yes')) ?></option>
                <option value="no"><?= e(t('report_no')) ?></option>
                <option value="unsure"><?= e(t('report_unsure')) ?></option>
              </select>
            </div>

            <div id="urgent-guidance" class="callout callout--warn" hidden>
              <strong><?= e(t('report_urgent_title')) ?></strong>
              <?= e(t('report_urgent_body')) ?>
              <a href="<?= e(url('partners.php')) ?>"><?= e(t('footer_partners')) ?></a>.
            </div>
          </section>

          <section class="form-section">
            <header class="form-section__head">
              <span class="form-section__step">5</span>
              <div>
                <h2><?= e(t('report_step5')) ?> <span class="hint"><?= e(t('report_optional')) ?></span></h2>
                <p><?= e(t('report_step5_help')) ?></p>
              </div>
            </header>

            <div class="form-field">
              <label for="evidence"><?= e(t('report_evidence')) ?></label>
              <input id="evidence" name="evidence" type="file" accept="image/*,video/*">
              <span class="hint"><?= e(t('report_evidence_hint')) ?></span>
            </div>
          </section>

          <section class="form-section">
            <header class="form-section__head">
              <span class="form-section__step">6</span>
              <div>
                <h2><?= e(t('report_step6')) ?> <span class="hint"><?= e(t('report_optional')) ?></span></h2>
                <p><?= e(t('report_step6_help')) ?></p>
              </div>
            </header>

            <div class="form-row form-row--2">
              <div class="form-field">
                <label for="contact_name"><?= e(t('report_name')) ?></label>
                <input id="contact_name" name="contact_name" maxlength="120" autocomplete="name">
              </div>
              <div class="form-field">
                <label for="contact_phone"><?= e(t('report_phone')) ?></label>
                <input id="contact_phone" name="contact_phone" maxlength="40" autocomplete="tel">
              </div>
            </div>

            <div class="form-field">
              <label for="contact_email"><?= e(t('report_email')) ?></label>
              <input id="contact_email" name="contact_email" type="email" maxlength="160" autocomplete="email">
            </div>

            <label class="checkbox checkbox--consent">
              <input type="checkbox" name="privacy_confirm" value="1" required>
              <span>
                <?= e(t('report_privacy_confirm')) ?>
                <a href="<?= e(url('privacy.php')) ?>"><?= e(t('footer_privacy')) ?></a>.
              </span>
            </label>
          </section>

          <button class="btn btn--primary btn--block" type="submit"><?= e(t('report_submit')) ?></button>
          <p class="form-note"><?= e(t('report_submit_note')) ?></p>
        </form>

        <aside class="report-side">
          <?= site_image(
            'tau-report-documenting-concerns-900x650.jpg',
            'Calm private documentation of an animal welfare concern',
            '4 / 5',
            '',
            '900',
            '650'
          ) ?>

          <div class="report-side__card">
            <h2><?= e(t('report_next_title')) ?></h2>
            <ol class="report-steps">
              <li><?= e(t('report_next_1')) ?></li>
              <li><?= e(t('report_next_2')) ?></li>
              <li><?= e(t('report_next_3')) ?></li>
              <li><?= e(t('report_next_4')) ?></li>
            </ol>
          </div>

          <div class="report-side__card report-side__card--soft">
            <h2><?= e(t('report_also_title')) ?></h2>
            <ul class="report-side__links">
              <li><a href="<?= e(url('care-guides.php')) ?>"><?= e(t('report_also_guides')) ?></a></li>
              <li><a href="<?= e(url('take-action.php')) ?>"><?= e(t('report_also_action')) ?></a></li>
              <li><a href="<?= e(url('community-guidelines.php')) ?>"><?= e(t('report_also_guidelines')) ?></a></li>
            </ul>
          </div>
        </aside>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
