<?php
require_once __DIR__ . '/../../app/config.php';
require_once __DIR__ . '/../../app/db.php';
require_once __DIR__ . '/../../app/helpers.php';

require_login();

$pageTitle = 'Kelola Kategori - Portal Tegal';
$categories = $pdo->query('SELECT * FROM categories ORDER BY id DESC')->fetchAll();
$flash = get_flash('category');
?>
<?php include __DIR__ . '/../../app/header.php'; ?>
<?php include __DIR__ . '/../../app/admin_navbar.php'; ?>

<main class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="section-title">Kategori</h1>
      <p class="section-subtitle">Kelola kategori destinasi.</p>
    </div>
    <a href="<?php echo e(base_url('admin/categories/create.php')); ?>" class="btn btn-cta">Tambah Kategori</a>
  </div>

  <?php if ($flash) : ?>
    <div class="alert alert-<?php echo e($flash['type']); ?>"><?php echo e($flash['message']); ?></div>
  <?php endif; ?>

  <div class="table-responsive table-admin">
    <table class="table table-hover mb-0">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Slug</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($categories as $category) : ?>
          <tr>
            <td><?php echo e($category['id']); ?></td>
            <td><?php echo e($category['name']); ?></td>
            <td><?php echo e($category['slug']); ?></td>
            <td class="d-flex gap-2">
              <a class="btn btn-sm btn-outline-dark" href="<?php echo e(base_url('admin/categories/edit.php?id=' . $category['id'])); ?>">Edit</a>
              <form method="post" action="<?php echo e(base_url('admin/categories/delete.php')); ?>" onsubmit="return confirm('Hapus kategori ini?');">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($category['id']); ?>">
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
