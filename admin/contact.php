<?php
declare(strict_types=1);
$adminPageTitle = 'Contact inbox';
$adminActive = 'contact';
require dirname(__DIR__) . '/includes/admin_header.php';
?>

<section class="admin-page-intro">
  <div>
    <h2>Enquiries and partnership notes</h2>
    <p>Messages from the contact form about content ideas, directory corrections and collaboration.</p>
  </div>
</section>

<section class="admin-panel">
  <div class="admin-table-toolbar">
    <label>
      Status
      <select id="filter-contact-status">
        <option value="">All</option>
        <option value="new">New</option>
        <option value="in_progress">In progress</option>
        <option value="resolved">Resolved</option>
      </select>
    </label>
  </div>
  <div class="admin-table-wrap">
    <table id="table-contact" class="display admin-datatable" style="width:100%">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Category</th>
          <th>Subject</th>
          <th>Status</th>
          <th>Received</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>
</section>

<dialog class="admin-dialog" id="contact-dialog">
  <form method="dialog" class="admin-dialog__inner">
    <header>
      <h3 id="contact-dialog-title">Message detail</h3>
      <button type="submit" class="admin-dialog__close" aria-label="Close">&times;</button>
    </header>
    <div id="contact-dialog-body" class="admin-dialog__body"></div>
  </form>
</dialog>

<?php
$adminExtraScripts = <<<'HTML'
<script>
window.AdminTables && window.AdminTables.initContact();
</script>
HTML;
require dirname(__DIR__) . '/includes/admin_footer.php';
