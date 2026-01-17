<?php
require_once __DIR__ . '/../../app/config.php';
require_once __DIR__ . '/../../app/db.php';
require_once __DIR__ . '/../../app/helpers.php';

require_login();

$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM messages WHERE id = ?');
$stmt->execute([$id]);
$message = $stmt->fetch();

if (!$message) {
    redirect(base_url('admin/messages/index.php'));
}

$pageTitle = 'Detail Pesan - Portal Tegal';
?>
<?php include __DIR__ . '/../../app/header.php'; ?>
<?php include __DIR__ . '/../../app/admin_navbar.php'; ?>

<main class="container my-5" style="max-width: 760px;">
  <h1 class="section-title">Detail Pesan</h1>
  <div class="card filter-card p-4">
    <p class="text-muted mb-1"><strong>Nama:</strong> <?php echo e($message['name']); ?></p>
    <p class="text-muted mb-1"><strong>Email:</strong> <?php echo e($message['email']); ?></p>
    <p class="text-muted mb-1"><strong>Subjek:</strong> <?php echo e($message['subject']); ?></p>
    <p class="text-muted mb-3"><strong>Tanggal:</strong> <?php echo e($message['created_at']); ?></p>
    <div class="border rounded p-3 bg-light">
      <?php echo nl2br(e($message['message'])); ?>
    </div>
    <div class="mt-4 d-flex gap-2">
      <a href="<?php echo e(base_url('admin/messages/index.php')); ?>" class="btn btn-outline-secondary">Kembali</a>
      <form method="post" action="<?php echo e(base_url('admin/messages/delete.php')); ?>" onsubmit="return confirm('Hapus pesan ini?');">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="id" value="<?php echo e($message['id']); ?>">
        <button type="submit" class="btn btn-outline-danger">Hapus</button>
      </form>
    </div>
  </div>
</main>

<?php include __DIR__ . '/../../app/footer.php'; ?>
