<?php declare(strict_types=1); ?>
      </div>
    </div>
  </div>

  <input type="hidden" id="admin-csrf" value="<?= e(csrf_token()) ?>">
  <script>window.ADMIN_BASE = <?= json_encode(BASE_URL) ?>;</script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script src="<?= e(asset('js/admin.js')) ?>"></script>
  <?php if (!empty($adminExtraScripts)): ?>
    <?= $adminExtraScripts ?>
  <?php endif; ?>
</body>
</html>
