<main class="container my-5">
  <div class="row g-4">
    <div class="col-lg-7">
      <div class="detail-hero">
        <img src="<?php echo e(image_url($destination['thumbnail'])); ?>" class="img-fluid" alt="<?php echo e($destination['name']); ?>">
      </div>
    </div>
    <div class="col-lg-5">
      <span class="badge-category mb-2 d-inline-block"><?php echo e($destination['category_name']); ?></span>
      <h1 class="section-title mb-3"><?php echo e($destination['name']); ?></h1>
      <p class="text-muted"><i class="bi bi-geo-alt"></i> <?php echo e($destination['location']); ?></p>
      <p><?php echo nl2br(e($destination['content'])); ?></p>
      <div class="d-flex flex-wrap gap-3 text-muted small">
        <span><i class="bi bi-clock"></i> Jam buka: 08.00 - 18.00</span>
        <span><i class="bi bi-ticket"></i> Tiket: Rp 10.000</span>
      </div>
      <div class="mt-4 d-flex gap-2">
        <a href="<?php echo e(route_url('destinations')); ?>" class="btn btn-outline-dark">Kembali</a>
        <a href="#related" class="btn btn-cta">Destinasi Terkait</a>
      </div>
    </div>
  </div>

  <section class="mt-5">
    <h3 class="section-title">Galeri</h3>
    <div class="row g-3 gallery-grid">
      <?php foreach ($gallery as $image) : ?>
        <div class="col-md-4">
          <img src="<?php echo e(image_url($image)); ?>" alt="Galeri <?php echo e($destination['name']); ?>">
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section id="related" class="mt-5">
    <h3 class="section-title">Destinasi Terkait</h3>
    <div class="row g-4">
      <?php if (!$related) : ?>
        <div class="col-12">
          <div class="alert alert-info">Belum ada destinasi terkait lainnya.</div>
        </div>
      <?php endif; ?>
      <?php foreach ($related as $item) : ?>
        <div class="col-md-4">
          <div class="card destination-card">
            <img src="<?php echo e(image_url($item['thumbnail'])); ?>" alt="<?php echo e($item['name']); ?>">
            <div class="card-body">
              <span class="badge-category"><?php echo e($item['category_name']); ?></span>
              <h5 class="card-title mt-2"><?php echo e($item['name']); ?></h5>
              <a class="btn btn-sm btn-outline-dark" href="<?php echo e(route_url('destinations/detail', ['slug' => $item['slug']])); ?>">Detail</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
</main>
