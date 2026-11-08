<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/admin.php';

admin_logout();
flash_set('success', 'Signed out of the admin desk.');
header('Location: ' . url('admin/login.php'));
exit;
