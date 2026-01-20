<main>
  <section class="container my-5">
    <div class="hero">
      <div class="row align-items-center">
        <div class="col-lg-7">
          <h1 class="display-4 fw-semibold">Portal Destinasi &amp; Kearifan Lokal Tegal</h1>
          <p class="lead mt-3">Temukan keindahan alam Guci, jejak Batik Tegalan, ritual budaya, hingga kuliner legendaris khas Tegal dalam satu portal terkurasi.</p>
          <a href="<?php echo e(route_url('destinations')); ?>" class="btn btn-cta btn-lg mt-3">Jelajahi Destinasi</a>
        </div>
        <div class="col-lg-5 d-none d-lg-block">
          <div class="feature-box text-dark">
            <h4 class="fw-semibold">Sorotan Hari Ini</h4>
            <p class="mb-2">Eksplorasi rute wisata, budaya, dan kuliner terbaik dengan kurasi lokal.</p>
            <div class="d-flex gap-2 flex-wrap">
              <span class="badge bg-light text-dark"><i class="bi bi-mountain"></i> Wisata Alam</span>
              <span class="badge bg-light text-dark"><i class="bi bi-brush"></i> Budaya</span>
              <span class="badge bg-light text-dark"><i class="bi bi-cup-hot"></i> Kuliner</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="section-title">Kategori Cepat</h2>
        <p class="section-subtitle">Pilih jalur eksplorasi sesuai minatmu.</p>
      </div>
    </div>
    <div class="row g-3">
      <?php foreach ($categories as $category) : ?>
        <div class="col-md-6 col-lg-3">
          <div class="category-card">
            <h5 class="mb-2"><?php echo e($category['name']); ?></h5>
            <p class="small mb-3">Jelajahi koleksi <?php echo e(strtolower($category['name'])); ?> terbaik.</p>
            <a href="<?php echo e(route_url('destinations', ['category_id' => $category['id']])); ?>" class="badge">Lihat</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="section-title">Destinasi Populer</h2>
        <p class="section-subtitle">Pilihan destinasi terbaru dan favorit pengunjung.</p>
      </div>
      <a class="btn btn-outline-dark btn-sm" href="<?php echo e(route_url('destinations')); ?>">Lihat semua</a>
    </div>
    <div class="row g-4">
      <?php foreach ($featured as $item) : ?>
        <div class="col-md-6 col-lg-4">
          <div class="card destination-card">
            <img src="<?php echo e(image_url($item['thumbnail'])); ?>" alt="<?php echo e($item['name']); ?>">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge-category"><?php echo e($item['category_name']); ?></span>
                <small class="text-muted"><i class="bi bi-geo-alt"></i> <?php echo e($item['location']); ?></small>
              </div>
              <h5 class="card-title fw-semibold"><?php echo e($item['name']); ?></h5>
              <p class="card-text text-muted"><?php echo e($item['short_desc']); ?></p>
              <a class="btn btn-sm btn-outline-dark" href="<?php echo e(route_url('destinations/detail', ['slug' => $item['slug']])); ?>">Detail</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="container my-5">
    <div class="row g-4 align-items-center">
      <div class="col-lg-6">
        <img src="<?php echo e(base_url('assets/img/batik-2.jpg')); ?>" class="img-fluid detail-hero" alt="Batik Tegalan">
      </div>
      <div class="col-lg-6">
        <h2 class="section-title">Batik Tegalan</h2>
        <p class="section-subtitle">Motif khas pesisir utara dengan warna hangat, menjadi identitas budaya sekaligus produk unggulan UMKM Tegal.</p>
        <ul class="list-unstyled text-muted">
          <li><i class="bi bi-check-circle"></i> Motif flora-fauna pesisir</li>
          <li><i class="bi bi-check-circle"></i> Pewarnaan alami dan kontemporer</li>
          <li><i class="bi bi-check-circle"></i> Dikelola komunitas perajin lokal</li>
        </ul>
        <a class="btn btn-cta" href="<?php echo e(route_url('culture')); ?>">Jelajahi Budaya</a>
      </div>
    </div>
  </section>
</main>
