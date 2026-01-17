<?php
require_once __DIR__ . '/../../app/config.php';
require_once __DIR__ . '/../../app/db.php';
require_once __DIR__ . '/../../app/helpers.php';

require_login();

if (!is_post()) {
    redirect(base_url('admin/destinations/index.php'));
}

if (!validate_csrf($_POST['csrf_token'] ?? '')) {
    set_flash('destination', 'Token tidak valid.', 'danger');
    redirect(base_url('admin/destinations/index.php'));
}

$id = (int) ($_POST['id'] ?? 0);
if ($id <= 0) {
    set_flash('destination', 'Destinasi tidak ditemukan.', 'danger');
    redirect(base_url('admin/destinations/index.php'));
}

$stmt = $pdo->prepare('SELECT * FROM destinations WHERE id = ?');
$stmt->execute([$id]);
$destination = $stmt->fetch();

if (!$destination) {
    set_flash('destination', 'Destinasi tidak ditemukan.', 'danger');
    redirect(base_url('admin/destinations/index.php'));
}

$galleryStmt = $pdo->prepare('SELECT file_name FROM destination_images WHERE destination_id = ?');
$galleryStmt->execute([$id]);
$gallery = $galleryStmt->fetchAll(PDO::FETCH_COLUMN);

$pdo->prepare('DELETE FROM destination_images WHERE destination_id = ?')->execute([$id]);
$pdo->prepare('DELETE FROM destinations WHERE id = ?')->execute([$id]);

$thumbPath = UPLOAD_DIR . '/' . $destination['thumbnail'];
if ($destination['thumbnail'] && is_file($thumbPath)) {
    unlink($thumbPath);
}

foreach ($gallery as $img) {
    $filePath = UPLOAD_DIR . '/' . $img;
    if ($img && is_file($filePath)) {
        unlink($filePath);
    }
}

set_flash('destination', 'Destinasi berhasil dihapus.');
redirect(base_url('admin/destinations/index.php'));
