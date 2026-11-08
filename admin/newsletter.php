<?php
declare(strict_types=1);
$adminPageTitle = 'Newsletter';
$adminActive = 'newsletter';
require dirname(__DIR__) . '/includes/admin_header.php';
?>

<section class="admin-page-intro">
  <div>
    <h2>Community update list</h2>
    <p>People who opted in for care guides, stories and local action notes from the site footer.</p>
  </div>
</section>

<section class="admin-panel">
  <div class="admin-table-wrap">
    <table id="table-newsletter" class="display admin-datatable" style="width:100%">
      <thead>
        <tr>
          <th>Email</th>
          <th>Source</th>
          <th>Consent</th>
          <th>Joined</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>
</section>

<?php
$adminExtraScripts = <<<'HTML'
<script>
window.AdminTables && window.AdminTables.initNewsletter();
</script>
HTML;
require dirname(__DIR__) . '/includes/admin_footer.php';
