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
          <div class="feature-box">
            <h4 class="fw-semibold">Sorotan Hari Ini</h4>
            <p class="mb-0">Rute wisata, budaya, dan kuliner pilihan.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="section-title">Kategori Cepat</h2>
      </div>
    </div>
    <div class="row g-3">
      <?php foreach ($categories as $category) : ?>
        <div class="col-md-6 col-lg-3">
          <div class="category-card">
            <h5 class="mb-2"><?php echo e($category['name']); ?></h5>
            <a href="<?php echo e(route_url('destinations', ['category_id' => $category['id']])); ?>" class="btn btn-outline-light btn-sm btn-rounded">Lihat</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="section-title">Destinasi Populer</h2>
      </div>
      <a class="btn btn-outline-dark btn-sm btn-rounded" href="<?php echo e(route_url('destinations')); ?>">Lihat semua</a>
    </div>
    <div class="row g-4">
      <?php foreach ($featured as $item) : ?>
        <div class="col-md-6 col-lg-4">
          <div class="card destination-card">
            <img src="<?php echo e(image_url($item['thumbnail'])); ?>" alt="<?php echo e($item['name']); ?>">
            <div class="card-body">
              <h5 class="card-title fw-semibold"><?php echo e($item['name']); ?></h5>
              <a class="btn btn-sm btn-outline-dark btn-detail" href="<?php echo e(route_url('destinations/detail', ['slug' => $item['slug']])); ?>">Detail</a>
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
        <p>Motif khas pesisir utara dengan warna hangat, menjadi identitas budaya sekaligus produk unggulan UMKM Tegal.</p>
        <a class="btn btn-cta" href="<?php echo e(route_url('culture')); ?>">Jelajahi Budaya</a>
      </div>
    </div>
  </section>
</main>
