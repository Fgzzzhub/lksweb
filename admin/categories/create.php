<?php
require_once __DIR__ . '/../../app/config.php';
require_once __DIR__ . '/../../app/db.php';
require_once __DIR__ . '/../../app/helpers.php';

require_login();

$pageTitle = 'Tambah Kategori - Portal Tegal';
$errors = [];
$name = '';

if (is_post()) {
    if (!validate_csrf($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Token tidak valid.';
    }

    $name = trim($_POST['name'] ?? '');

    if ($name === '') {
        $errors[] = 'Nama kategori wajib diisi.';
    }

    if (!$errors) {
        $baseSlug = slugify($name);
        $slug = $baseSlug;
        $counter = 2;

        while (true) {
            $checkStmt = $pdo->prepare('SELECT COUNT(*) FROM categories WHERE slug = ?');
            $checkStmt->execute([$slug]);
            if ((int) $checkStmt->fetchColumn() === 0) {
                break;
            }
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $stmt = $pdo->prepare('INSERT INTO categories (name, slug) VALUES (?, ?)');
        $stmt->execute([$name, $slug]);
        set_flash('category', 'Kategori berhasil ditambahkan.');
        redirect(base_url('admin/categories/index.php'));
    }
}
?>
<?php include __DIR__ . '/../../app/header.php'; ?>
<?php include __DIR__ . '/../../app/admin_navbar.php'; ?>

<main class="container my-5" style="max-width: 640px;">
  <h1 class="section-title">Tambah Kategori</h1>
  <p class="section-subtitle">Buat kategori baru untuk destinasi.</p>

  <?php if ($errors) : ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach ($errors as $error) : ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" class="card filter-card p-4">
    <?php echo csrf_field(); ?>
    <div class="mb-3">
      <label class="form-label">Nama Kategori</label>
      <input type="text" name="name" class="form-control" value="<?php echo e($name); ?>" required>
    </div>
    <div class="d-flex gap-2">
      <button type="submit" class="btn btn-cta">Simpan</button>
      <a href="<?php echo e(base_url('admin/categories/index.php')); ?>" class="btn btn-outline-secondary">Batal</a>
    </div>
  </form>
</main>

<?php include __DIR__ . '/../../app/footer.php'; ?>
