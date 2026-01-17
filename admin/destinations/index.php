<?php
require_once __DIR__ . '/../../app/config.php';
require_once __DIR__ . '/../../app/db.php';
require_once __DIR__ . '/../../app/helpers.php';

require_login();

$pageTitle = 'Kelola Destinasi - Portal Tegal';
$flash = get_flash('destination');

$q = trim($_GET['q'] ?? '');
$where = '';
$params = [];
if ($q !== '') {
    $where = 'WHERE d.name LIKE :q OR d.slug LIKE :q';
    $params[':q'] = '%' . $q . '%';
}

$stmt = $pdo->prepare('SELECT d.*, c.name AS category_name FROM destinations d JOIN categories c ON c.id = d.category_id ' . $where . ' ORDER BY d.created_at DESC');
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->execute();
$destinations = $stmt->fetchAll();
?>
<?php include __DIR__ . '/../../app/header.php'; ?>
<?php include __DIR__ . '/../../app/admin_navbar.php'; ?>

<main class="container my-5">
  <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
    <div>
      <h1 class="section-title">Destinasi</h1>
      <p class="section-subtitle">Kelola data destinasi wisata dan budaya.</p>
    </div>
    <a href="<?php echo e(base_url('admin/destinations/create.php')); ?>" class="btn btn-cta">Tambah Destinasi</a>
  </div>

  <?php if ($flash) : ?>
    <div class="alert alert-<?php echo e($flash['type']); ?>"><?php echo e($flash['message']); ?></div>
  <?php endif; ?>

  <form method="get" class="card filter-card p-3 mb-3">
    <div class="row g-2 align-items-center">
      <div class="col-md-9">
        <input type="text" name="q" class="form-control" placeholder="Cari destinasi" value="<?php echo e($q); ?>">
      </div>
      <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-cta flex-fill">Cari</button>
        <a href="<?php echo e(base_url('admin/destinations/index.php')); ?>" class="btn btn-outline-secondary">Reset</a>
      </div>
    </div>
  </form>

  <div class="table-responsive table-admin">
    <table class="table table-hover mb-0">
      <thead class="table-light">
        <tr>
          <th>Nama</th>
          <th>Kategori</th>
          <th>Lokasi</th>
          <th>Featured</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($destinations as $item) : ?>
          <tr>
            <td><?php echo e($item['name']); ?></td>
            <td><?php echo e($item['category_name']); ?></td>
            <td><?php echo e($item['location']); ?></td>
            <td><?php echo $item['is_featured'] ? 'Ya' : 'Tidak'; ?></td>
            <td class="d-flex gap-2">
              <a class="btn btn-sm btn-outline-dark" href="<?php echo e(base_url('admin/destinations/edit.php?id=' . $item['id'])); ?>">Edit</a>
              <form method="post" action="<?php echo e(base_url('admin/destinations/delete.php')); ?>" onsubmit="return confirm('Hapus destinasi ini?');">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($item['id']); ?>">
                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>

<?php include __DIR__ . '/../../app/footer.php'; ?>
