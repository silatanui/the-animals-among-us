<?php
declare(strict_types=1);
$adminPageTitle = 'Dashboard';
$adminActive = 'dashboard';
require dirname(__DIR__) . '/includes/admin_header.php';

$stats = admin_dashboard_stats();
$c = $stats['counts'];
?>

<section class="admin-hero">
  <div>
    <h2>Everyday welfare, at a glance</h2>
    <p>A living snapshot of concerns, care stories and community interest across domesticated and working animals.</p>
  </div>
  <div class="admin-hero__actions">
    <a class="admin-btn admin-btn--ghost" href="<?= e(url('admin/reports.php')) ?>">Review reports</a>
    <a class="admin-btn admin-btn--primary" href="<?= e(url('admin/stories.php')) ?>">Moderate stories</a>
  </div>
</section>

<section class="admin-kpi-grid">
  <article class="admin-kpi">
    <span class="admin-kpi__label">Welfare reports</span>
    <strong><?= (int) $c['reports'] ?></strong>
    <small><?= (int) $c['reports_new'] ?> awaiting triage · <?= (int) $c['reports_urgent'] ?> flagged urgent</small>
  </article>
  <article class="admin-kpi">
    <span class="admin-kpi__label">Community stories</span>
    <strong><?= (int) $c['stories'] ?></strong>
    <small><?= (int) $c['stories_pending'] ?> pending · <?= (int) $c['stories_published'] ?> published</small>
  </article>
  <article class="admin-kpi">
    <span class="admin-kpi__label">Contact inbox</span>
    <strong><?= (int) $c['contacts'] ?></strong>
    <small><?= (int) $c['contacts_new'] ?> new enquiries</small>
  </article>
  <article class="admin-kpi">
    <span class="admin-kpi__label">Newsletter list</span>
    <strong><?= (int) $c['subscribers'] ?></strong>
    <small>People following care updates</small>
  </article>
</section>

<section class="admin-panel admin-panel--map">
  <header class="admin-panel__head">
    <div>
      <h3>Where cases are being heard</h3>
      <p>Kenya GeoJSON counties with translucent dots sized by case volume. Overlaps stay readable through opacity.</p>
    </div>
    <div class="admin-map-legend" aria-hidden="true">
      <span><i class="admin-map-legend__dot admin-map-legend__dot--sm"></i> Fewer</span>
      <span><i class="admin-map-legend__dot admin-map-legend__dot--lg"></i> More</span>
    </div>
  </header>
  <div id="kenya-cases-map" class="admin-map" role="img" aria-label="Map of welfare report cases across Kenya"></div>
</section>

<section class="admin-chart-grid">
  <article class="admin-panel">
    <header class="admin-panel__head">
      <h3>Concern trend</h3>
      <p>Reports received over time</p>
    </header>
    <div class="admin-chart-wrap">
      <canvas id="chart-report-trend" height="140"></canvas>
    </div>
  </article>
  <article class="admin-panel">
    <header class="admin-panel__head">
      <h3>Animals in focus</h3>
      <p>Which neighbours are being reported</p>
    </header>
    <div class="admin-chart-wrap admin-chart-wrap--donut">
      <canvas id="chart-animals" height="140"></canvas>
    </div>
  </article>
  <article class="admin-panel">
    <header class="admin-panel__head">
      <h3>Where concerns arise</h3>
      <p>Top counties in the demo dataset</p>
    </header>
    <div class="admin-chart-wrap">
      <canvas id="chart-counties" height="140"></canvas>
    </div>
  </article>
  <article class="admin-panel">
    <header class="admin-panel__head">
      <h3>Story themes</h3>
      <p>What communities choose to share</p>
    </header>
    <div class="admin-chart-wrap admin-chart-wrap--donut">
      <canvas id="chart-stories" height="140"></canvas>
    </div>
  </article>
  <article class="admin-panel">
    <header class="admin-panel__head">
      <h3>Enquiry mix</h3>
      <p>Why people write in</p>
    </header>
    <div class="admin-chart-wrap">
      <canvas id="chart-contacts" height="140"></canvas>
    </div>
  </article>
  <article class="admin-panel">
    <header class="admin-panel__head">
      <h3>Audience growth</h3>
      <p>Newsletter joins by month</p>
    </header>
    <div class="admin-chart-wrap">
      <canvas id="chart-subscribers" height="140"></canvas>
    </div>
  </article>
</section>

<section class="admin-split">
  <article class="admin-panel">
    <header class="admin-panel__head">
      <h3>Latest welfare reports</h3>
      <a href="<?= e(url('admin/reports.php')) ?>">Open queue</a>
    </header>
    <div class="admin-table-wrap">
      <table class="admin-mini-table">
        <thead>
          <tr>
            <th>Reference</th>
            <th>Animal</th>
            <th>County</th>
            <th>Status</th>
            <th>When</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($stats['recent_reports'] as $row): ?>
            <tr>
              <td><code><?= e($row['reference_code']) ?></code></td>
              <td><?= e($row['animal_type']) ?></td>
              <td><?= e($row['county']) ?></td>
              <td><span class="admin-status admin-status--<?= e(preg_replace('/[^a-z0-9]+/i', '-', strtolower($row['status']))) ?>"><?= e($row['status']) ?></span></td>
              <td><?= e(date('d M Y', strtotime((string) $row['created_at']))) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </article>

  <article class="admin-panel">
    <header class="admin-panel__head">
      <h3>Stories in moderation</h3>
      <a href="<?= e(url('admin/stories.php')) ?>">Open queue</a>
    </header>
    <ul class="admin-feed">
      <?php foreach ($stats['recent_stories'] as $story): ?>
        <li>
          <div>
            <strong><?= e($story['title']) ?></strong>
            <span><?= e($story['display_name']) ?> · <?= e($story['animal_type']) ?></span>
          </div>
          <span class="admin-status admin-status--<?= e(preg_replace('/[^a-z0-9]+/i', '-', strtolower($story['status']))) ?>"><?= e(str_replace('_', ' ', $story['status'])) ?></span>
        </li>
      <?php endforeach; ?>
    </ul>
  </article>
</section>

<script type="application/json" id="admin-dashboard-data"><?= json_encode($stats['charts'], JSON_UNESCAPED_UNICODE) ?></script>
<script type="application/json" id="admin-map-data"><?= json_encode([
  'geojson' => asset('geo/kenya-counties.geojson'),
  'points' => $stats['map_points'],
], JSON_UNESCAPED_UNICODE) ?></script>

<?php
$adminExtraScripts = '<script>window.AdminDashboard && window.AdminDashboard.init();</script>';
require dirname(__DIR__) . '/includes/admin_footer.php';
