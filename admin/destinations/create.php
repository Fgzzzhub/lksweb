<?php
require_once __DIR__ . '/../../app/config.php';
require_once __DIR__ . '/../../app/db.php';
require_once __DIR__ . '/../../app/helpers.php';

require_login();

$pageTitle = 'Tambah Destinasi - Portal Tegal';
$errors = [];

$name = '';
$categoryId = 0;
$location = '';
$shortDesc = '';
$content = '';
$isFeatured = 0;

$categories = $pdo->query('SELECT id, name FROM categories ORDER BY name')->fetchAll();

function upload_image($file, &$errors, $label)
{
    if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = $label . ' gagal diupload.';
        return null;
    }

    if ($file['size'] > MAX_UPLOAD_SIZE) {
        $errors[] = $label . ' melebihi ukuran 2MB.';
        return null;
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    if (!in_array($ext, $allowed, true)) {
        $errors[] = $label . ' harus jpg, jpeg, png, atau webp.';
        return null;
    }

    $filename = uniqid('img_', true) . '.' . $ext;
    $destination = UPLOAD_DIR . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        $errors[] = $label . ' gagal disimpan.';
        return null;
    }

    return $filename;
}

if (is_post()) {
    if (!validate_csrf($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Token tidak valid.';
    }

    $name = trim($_POST['name'] ?? '');
    $categoryId = (int) ($_POST['category_id'] ?? 0);
    $location = trim($_POST['location'] ?? '');
    $shortDesc = trim($_POST['short_desc'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $isFeatured = isset($_POST['is_featured']) ? 1 : 0;

    if ($name === '') {
        $errors[] = 'Nama destinasi wajib diisi.';
    }

    if ($categoryId <= 0) {
        $errors[] = 'Kategori wajib dipilih.';
    }

    if ($shortDesc === '') {
        $errors[] = 'Deskripsi singkat wajib diisi.';
    }

    if ($content === '') {
        $errors[] = 'Konten lengkap wajib diisi.';
    }

    $thumbnail = null;
    $galleryFiles = [];

    if (!$errors) {
        $thumbnail = upload_image($_FILES['thumbnail'] ?? [], $errors, 'Thumbnail');

        if (!empty($_FILES['gallery']['name'][0])) {
            foreach ($_FILES['gallery']['name'] as $index => $nameFile) {
                $file = [
                    'name' => $_FILES['gallery']['name'][$index],
                    'type' => $_FILES['gallery']['type'][$index],
                    'tmp_name' => $_FILES['gallery']['tmp_name'][$index],
                    'error' => $_FILES['gallery']['error'][$index],
                    'size' => $_FILES['gallery']['size'][$index],
                ];
                $uploaded = upload_image($file, $errors, 'Galeri');
                if ($uploaded) {
                    $galleryFiles[] = $uploaded;
                }
            }
        }
    }

    if (!$errors) {
        $baseSlug = slugify($name);
        $slug = $baseSlug;
        $counter = 2;

        while (true) {
            $checkStmt = $pdo->prepare('SELECT COUNT(*) FROM destinations WHERE slug = ?');
            $checkStmt->execute([$slug]);
            if ((int) $checkStmt->fetchColumn() === 0) {
                break;
            }
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        if (!$thumbnail) {
            $thumbnail = 'placeholder-card.svg';
        }

        $stmt = $pdo->prepare('INSERT INTO destinations (category_id, name, slug, location, short_desc, content, thumbnail, is_featured, views, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, NOW())');
        $stmt->execute([$categoryId, $name, $slug, $location, $shortDesc, $content, $thumbnail, $isFeatured]);
        $destinationId = (int) $pdo->lastInsertId();

        if ($galleryFiles) {
            $imgStmt = $pdo->prepare('INSERT INTO destination_images (destination_id, file_name, created_at) VALUES (?, ?, NOW())');
            foreach ($galleryFiles as $fileName) {
                $imgStmt->execute([$destinationId, $fileName]);
            }
        }

        set_flash('destination', 'Destinasi berhasil ditambahkan.');
        redirect(base_url('admin/destinations/index.php'));
    }
}
?>
<?php include __DIR__ . '/../../app/header.php'; ?>
<?php include __DIR__ . '/../../app/admin_navbar.php'; ?>

<main class="container my-5" style="max-width: 860px;">
  <h1 class="section-title">Tambah Destinasi</h1>
  <p class="section-subtitle">Lengkapi data destinasi baru.</p>

  <?php if ($errors) : ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach ($errors as $error) : ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data" class="card filter-card p-4">
    <?php echo csrf_field(); ?>
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Nama Destinasi</label>
        <input type="text" name="name" class="form-control" value="<?php echo e($name); ?>" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Kategori</label>
        <select name="category_id" class="form-select" required>
          <option value="">Pilih kategori</option>
          <?php foreach ($categories as $cat) : ?>
            <option value="<?php echo e($cat['id']); ?>" <?php echo $categoryId === (int) $cat['id'] ? 'selected' : ''; ?>><?php echo e($cat['name']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Lokasi</label>
        <input type="text" name="location" class="form-control" value="<?php echo e($location); ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Thumbnail</label>
        <input type="file" name="thumbnail" class="form-control" accept=".jpg,.jpeg,.png,.webp">
      </div>
      <div class="col-12">
        <label class="form-label">Deskripsi Singkat</label>
        <textarea name="short_desc" class="form-control" rows="2" required><?php echo e($shortDesc); ?></textarea>
      </div>
      <div class="col-12">
        <label class="form-label">Konten Lengkap</label>
        <textarea name="content" class="form-control" rows="5" required><?php echo e($content); ?></textarea>
      </div>
      <div class="col-md-6">
        <label class="form-label">Galeri (opsional)</label>
        <input type="file" name="gallery[]" class="form-control" accept=".jpg,.jpeg,.png,.webp" multiple>
      </div>
      <div class="col-md-6 d-flex align-items-end">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="is_featured" id="isFeatured" <?php echo $isFeatured ? 'checked' : ''; ?>>
          <label class="form-check-label" for="isFeatured">Tandai sebagai featured</label>
        </div>
      </div>
    </div>
    <div class="d-flex gap-2 mt-4">
      <button type="submit" class="btn btn-cta">Simpan</button>
      <a href="<?php echo e(base_url('admin/destinations/index.php')); ?>" class="btn btn-outline-secondary">Batal</a>
    </div>
  </form>
</main>

<?php include __DIR__ . '/../../app/footer.php'; ?>
