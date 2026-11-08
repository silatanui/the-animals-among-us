<?php
declare(strict_types=1);
$adminPageTitle = 'Welfare reports';
$adminActive = 'reports';
require dirname(__DIR__) . '/includes/admin_header.php';
?>

<section class="admin-page-intro">
  <div>
    <h2>Private concern queue</h2>
    <p>Triage submissions from the public report form. Update status as cases move from received to reviewed or referred.</p>
  </div>
</section>

<section class="admin-panel">
  <div class="admin-table-toolbar">
    <label>
      Status
      <select id="filter-report-status">
        <option value="">All</option>
        <option value="received">Received</option>
        <option value="in_review">In review</option>
        <option value="referred">Referred</option>
        <option value="closed">Closed</option>
      </select>
    </label>
  </div>
  <div class="admin-table-wrap">
    <table id="table-reports" class="display admin-datatable" style="width:100%">
      <thead>
        <tr>
          <th>Reference</th>
          <th>Animal</th>
          <th>Concerns</th>
          <th>County</th>
          <th>Danger</th>
          <th>Status</th>
          <th>Received</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>
</section>

<dialog class="admin-dialog" id="report-dialog">
  <form method="dialog" class="admin-dialog__inner">
    <header>
      <h3 id="report-dialog-title">Report detail</h3>
      <button type="submit" class="admin-dialog__close" aria-label="Close">&times;</button>
    </header>
    <div id="report-dialog-body" class="admin-dialog__body"></div>
  </form>
</dialog>

<?php
$adminExtraScripts = <<<'HTML'
<script>
window.AdminTables && window.AdminTables.initReports();
</script>
HTML;
require dirname(__DIR__) . '/includes/admin_footer.php';
