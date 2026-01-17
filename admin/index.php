<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/db.php';
require_once __DIR__ . '/../app/helpers.php';

require_login();

$pageTitle = 'Dashboard Admin - Portal Tegal';

$destCount = (int) $pdo->query('SELECT COUNT(*) FROM destinations')->fetchColumn();
$catCount = (int) $pdo->query('SELECT COUNT(*) FROM categories')->fetchColumn();
$msgCount = (int) $pdo->query('SELECT COUNT(*) FROM messages')->fetchColumn();
?>
<?php include __DIR__ . '/../app/header.php'; ?>
<?php include __DIR__ . '/../app/admin_navbar.php'; ?>

<main class="container my-5">
  <h1 class="section-title">Dashboard</h1>
  <p class="section-subtitle">Ringkasan cepat pengelolaan portal.</p>

  <div class="row g-4 mt-3">
    <div class="col-md-4">
      <div class="card destination-card p-4">
        <h5>Total Destinasi</h5>
        <div class="display-6 fw-semibold"><?php echo e($destCount); ?></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card destination-card p-4">
        <h5>Total Kategori</h5>
        <div class="display-6 fw-semibold"><?php echo e($catCount); ?></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card destination-card p-4">
        <h5>Pesan Masuk</h5>
        <div class="display-6 fw-semibold"><?php echo e($msgCount); ?></div>
      </div>
    </div>
  </div>
</main>

<?php include __DIR__ . '/../app/footer.php'; ?>
