<?php
require_once __DIR__ . '/../../app/config.php';
require_once __DIR__ . '/../../app/db.php';
require_once __DIR__ . '/../../app/helpers.php';

require_login();

if (!is_post()) {
    redirect(base_url('admin/categories/index.php'));
}

if (!validate_csrf($_POST['csrf_token'] ?? '')) {
    set_flash('category', 'Token tidak valid.', 'danger');
    redirect(base_url('admin/categories/index.php'));
}

$id = (int) ($_POST['id'] ?? 0);
if ($id <= 0) {
    set_flash('category', 'Kategori tidak ditemukan.', 'danger');
    redirect(base_url('admin/categories/index.php'));
}

$checkStmt = $pdo->prepare('SELECT COUNT(*) FROM destinations WHERE category_id = ?');
$checkStmt->execute([$id]);
if ((int) $checkStmt->fetchColumn() > 0) {
    set_flash('category', 'Kategori tidak bisa dihapus karena masih digunakan.', 'danger');
    redirect(base_url('admin/categories/index.php'));
}

$deleteStmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
$deleteStmt->execute([$id]);
set_flash('category', 'Kategori berhasil dihapus.');
redirect(base_url('admin/categories/index.php'));
