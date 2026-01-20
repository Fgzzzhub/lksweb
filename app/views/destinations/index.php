<main class="container my-5">
  <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
    <div>
      <h1 class="section-title">Daftar Destinasi</h1>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-lg-4">
      <form class="card filter-card p-4" method="get" action="<?php echo e(route_url('destinations')); ?>" data-auto-submit>
        <input type="hidden" name="route" value="destinations">
        <h5 class="mb-3">Filter Pencarian</h5>
        <div class="mb-3">
          <label class="form-label">Kata kunci</label>
          <input type="text" name="q" class="form-control" placeholder="Cari destinasi" value="<?php echo e($q); ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Kategori</label>
          <select name="category_id" class="form-select">
            <option value="">Semua kategori</option>
            <?php foreach ($categories as $category) : ?>
              <option value="<?php echo e($category['id']); ?>" <?php echo $categoryId === (int) $category['id'] ? 'selected' : ''; ?>><?php echo e($category['name']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Lokasi</label>
          <select name="location" class="form-select">
            <option value="">Semua lokasi</option>
            <?php foreach ($locations as $loc) : ?>
              <option value="<?php echo e($loc); ?>" <?php echo $location === $loc ? 'selected' : ''; ?>><?php echo e($loc); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Tag</label>
          <input type="text" name="tag" class="form-control" placeholder="Contoh: heritage" value="<?php echo e($tag); ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Sorting</label>
          <select name="sort" class="form-select">
            <option value="created_at" <?php echo $sort === 'created_at' ? 'selected' : ''; ?>>Terbaru</option>
            <option value="name" <?php echo $sort === 'name' ? 'selected' : ''; ?>>Nama</option>
            <option value="views" <?php echo $sort === 'views' ? 'selected' : ''; ?>>Terpopuler</option>
          </select>
        </div>
        <div class="mb-4">
          <label class="form-label">Urutan</label>
          <select name="order" class="form-select">
            <option value="desc" <?php echo $order === 'DESC' ? 'selected' : ''; ?>>Menurun</option>
            <option value="asc" <?php echo $order === 'ASC' ? 'selected' : ''; ?>>Menaik</option>
          </select>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-cta flex-fill">Terapkan</button>
          <a href="<?php echo e(route_url('destinations')); ?>" class="btn btn-outline-dark">Reset</a>
        </div>
      </form>
    </div>

    <div class="col-lg-8">
      <div class="row g-4">
        <?php if (!$destinations) : ?>
          <div class="col-12">
            <div class="alert alert-warning">Tidak ada destinasi ditemukan. Coba ubah filter pencarian.</div>
          </div>
        <?php endif; ?>
        <?php foreach ($destinations as $item) : ?>
          <div class="col-md-6">
            <div class="card destination-card">
              <img src="<?php echo e(image_url($item['thumbnail'])); ?>" alt="<?php echo e($item['name']); ?>">
              <div class="card-body">
                <h5 class="card-title fw-semibold mb-2"><?php echo e($item['name']); ?></h5>
                <div class="d-flex justify-content-between align-items-center">
                  <a class="btn btn-sm btn-outline-dark btn-detail" href="<?php echo e(route_url('destinations/detail', ['slug' => $item['slug']])); ?>">Detail</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="mt-4">
        <?php echo paginate_links($total, $page, $limit, base_url('index.php')); ?>
      </div>
    </div>
  </div>
</main>
