<?php
require_once __DIR__ . '/../../app/config.php';
require_once __DIR__ . '/../../app/db.php';
require_once __DIR__ . '/../../app/helpers.php';

require_login();

if (!is_post()) {
    redirect(base_url('admin/messages/index.php'));
}

if (!validate_csrf($_POST['csrf_token'] ?? '')) {
    set_flash('message', 'Token tidak valid.', 'danger');
    redirect(base_url('admin/messages/index.php'));
}

$id = (int) ($_POST['id'] ?? 0);
if ($id <= 0) {
    set_flash('message', 'Pesan tidak ditemukan.', 'danger');
    redirect(base_url('admin/messages/index.php'));
}

$stmt = $pdo->prepare('DELETE FROM messages WHERE id = ?');
$stmt->execute([$id]);

set_flash('message', 'Pesan berhasil dihapus.');
redirect(base_url('admin/messages/index.php'));
