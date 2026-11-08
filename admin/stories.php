<?php
declare(strict_types=1);
$adminPageTitle = 'Community stories';
$adminActive = 'stories';
require dirname(__DIR__) . '/includes/admin_header.php';
?>

<section class="admin-page-intro">
  <div>
    <h2>Story moderation</h2>
    <p>Approve community care stories for publication, request changes, or decline submissions that do not meet the guidelines.</p>
  </div>
</section>

<section class="admin-panel">
  <div class="admin-table-toolbar">
    <label>
      Status
      <select id="filter-story-status">
        <option value="">All</option>
        <option value="pending_moderation">Pending</option>
        <option value="published">Published</option>
        <option value="needs_changes">Needs changes</option>
        <option value="declined">Declined</option>
      </select>
    </label>
  </div>
  <div class="admin-table-wrap">
    <table id="table-stories" class="display admin-datatable" style="width:100%">
      <thead>
        <tr>
          <th>Title</th>
          <th>Author</th>
          <th>Animal</th>
          <th>Category</th>
          <th>Location</th>
          <th>Status</th>
          <th>Submitted</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>
</section>

<dialog class="admin-dialog" id="story-dialog">
  <form method="dialog" class="admin-dialog__inner">
    <header>
      <h3 id="story-dialog-title">Story detail</h3>
      <button type="submit" class="admin-dialog__close" aria-label="Close">&times;</button>
    </header>
    <div id="story-dialog-body" class="admin-dialog__body"></div>
  </form>
</dialog>

<?php
$adminExtraScripts = <<<'HTML'
<script>
window.AdminTables && window.AdminTables.initStories();
</script>
HTML;
require dirname(__DIR__) . '/includes/admin_footer.php';
