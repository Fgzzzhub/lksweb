<main class="container my-5" style="max-width: 860px;">
  <h1 class="section-title"><?php echo e($formTitle); ?></h1>
  <p class="section-subtitle"><?php echo e($subtitle); ?></p>

  <?php if ($errors) : ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach ($errors as $error) : ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data" class="card filter-card p-4" action="<?php echo e($formAction); ?>">
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
        <label class="form-label"><?php echo $isEdit ? 'Ganti Thumbnail' : 'Thumbnail'; ?></label>
        <input type="file" name="thumbnail" class="form-control" accept=".jpg,.jpeg,.png,.webp">
        <?php if ($isEdit) : ?>
          <small class="text-muted">Thumbnail saat ini:</small>
          <img src="<?php echo e(image_url($destination['thumbnail'])); ?>" alt="Thumbnail" class="img-fluid mt-2" style="max-height: 160px;">
        <?php endif; ?>
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
        <label class="form-label"><?php echo $isEdit ? 'Tambah Galeri' : 'Galeri (opsional)'; ?></label>
        <input type="file" name="gallery[]" class="form-control" accept=".jpg,.jpeg,.png,.webp" multiple>
        <?php if ($isEdit && $gallery) : ?>
          <div class="d-flex gap-2 flex-wrap mt-2">
            <?php foreach ($gallery as $img) : ?>
              <img src="<?php echo e(image_url($img)); ?>" alt="Galeri" style="width: 90px; height: 60px; object-fit: cover; border-radius: 8px;">
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
      <div class="col-md-6 d-flex align-items-end">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="is_featured" id="isFeatured" <?php echo $isFeatured ? 'checked' : ''; ?>>
          <label class="form-check-label" for="isFeatured">Tandai sebagai featured</label>
        </div>
      </div>
    </div>
    <div class="d-flex gap-2 mt-4">
      <button type="submit" class="btn btn-cta"><?php echo e($submitLabel); ?></button>
      <a href="<?php echo e($cancelUrl); ?>" class="btn btn-outline-secondary">Batal</a>
    </div>
  </form>
</main>
