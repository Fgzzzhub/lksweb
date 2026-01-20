<main class="container my-5">
  <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
    <div>
      <h1 class="section-title">Budaya & Produk Lokal</h1>
      <p class="section-subtitle">Ragam karya budaya, kerajinan, dan UMKM unggulan dari Tegal.</p>
    </div>
  </div>

  <form class="card filter-card p-4 mb-4" method="get" data-auto-submit>
    <div class="row g-3 align-items-end">
      <div class="col-md-5">
        <label class="form-label">Cari Produk</label>
        <input type="text" name="q" class="form-control" placeholder="Cari budaya atau produk" value="<?php echo e($q); ?>">
      </div>
      <div class="col-md-4">
        <label class="form-label">Jenis Produk</label>
        <select name="type" class="form-select">
          <option value="">Semua jenis</option>
          <option value="Batik" <?php echo $type === 'Batik' ? 'selected' : ''; ?>>Batik</option>
          <option value="Kerajinan" <?php echo $type === 'Kerajinan' ? 'selected' : ''; ?>>Kerajinan</option>
          <option value="UMKM" <?php echo $type === 'UMKM' ? 'selected' : ''; ?>>UMKM</option>
        </select>
      </div>
      <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-cta flex-fill">Filter</button>
        <a href="<?php echo e(route_url('culture')); ?>" class="btn btn-outline-secondary">Reset</a>
      </div>
    </div>
  </form>

  <div class="row g-4">
    <?php if (!$filtered) : ?>
      <div class="col-12">
        <div class="alert alert-warning">Tidak ada produk yang cocok. Coba kata kunci lain.</div>
      </div>
    <?php endif; ?>
    <?php foreach ($filtered as $item) : ?>
      <div class="col-md-6 col-lg-4">
        <div class="card culture-card">
          <img src="<?php echo e(image_url($item['image'])); ?>" alt="<?php echo e($item['name']); ?>">
          <div class="card-body">
            <span class="badge-category"><?php echo e($item['type']); ?></span>
            <h5 class="card-title mt-2"><?php echo e($item['name']); ?></h5>
            <p class="card-text text-muted"><?php echo e($item['desc']); ?></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</main>
