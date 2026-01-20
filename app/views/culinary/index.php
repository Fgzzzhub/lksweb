<main class="container my-5">
  <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
    <div>
      <h1 class="section-title">Kuliner Khas Tegal</h1>
      <p class="section-subtitle">Rasakan cita rasa legendaris seperti Teh Poci, Kupat Glabed, dan lainnya.</p>
    </div>
  </div>

  <form class="card filter-card p-4 mb-4" method="get" data-auto-submit>
    <div class="row g-3 align-items-end">
      <div class="col-md-6">
        <label class="form-label">Cari Kuliner</label>
        <input type="text" name="q" class="form-control" placeholder="Cari nama kuliner" value="<?php echo e($q); ?>">
      </div>
      <div class="col-md-3">
        <label class="form-label">Sorting</label>
        <select name="sort" class="form-select">
          <option value="created_at" <?php echo $sort === 'created_at' ? 'selected' : ''; ?>>Terbaru</option>
          <option value="name" <?php echo $sort === 'name' ? 'selected' : ''; ?>>Nama</option>
        </select>
      </div>
      <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-cta flex-fill">Terapkan</button>
        <a href="<?php echo e(route_url('culinary')); ?>" class="btn btn-outline-secondary">Reset</a>
      </div>
    </div>
  </form>

  <div class="row g-4">
    <?php if (!$items) : ?>
      <div class="col-12">
        <div class="alert alert-warning">Data kuliner belum tersedia.</div>
      </div>
    <?php endif; ?>
    <?php foreach ($items as $item) : ?>
      <div class="col-md-6 col-lg-4">
        <div class="card destination-card">
          <img src="<?php echo e(image_url($item['thumbnail'])); ?>" alt="<?php echo e($item['name']); ?>">
          <div class="card-body">
            <span class="badge-category">Kuliner</span>
            <h5 class="card-title mt-2"><?php echo e($item['name']); ?></h5>
            <p class="card-text text-muted"><?php echo e($item['short_desc']); ?></p>
            <a class="btn btn-sm btn-outline-dark" href="<?php echo e(route_url('destinations/detail', ['slug' => $item['slug']])); ?>">Detail</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</main>
