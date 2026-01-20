<main class="container my-5">
  <div class="row g-4">
    <div class="col-lg-6">
      <h1 class="section-title">Kontak Kami</h1>
      <p class="section-subtitle">Punya pertanyaan atau ingin kolaborasi? Kirim pesan melalui form berikut.</p>

      <?php if ($success) : ?>
        <div class="alert alert-success">Terima kasih! Pesanmu sudah kami terima.</div>
      <?php endif; ?>

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
          <label class="form-label">Nama</label>
          <input type="text" name="name" class="form-control" value="<?php echo e($name); ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="<?php echo e($email); ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Subjek</label>
          <input type="text" name="subject" class="form-control" value="<?php echo e($subject); ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Pesan</label>
          <textarea name="message" rows="4" class="form-control" required><?php echo e($message); ?></textarea>
        </div>
        <button type="submit" class="btn btn-cta">Kirim Pesan</button>
      </form>
    </div>

    <div class="col-lg-6">
      <div class="card filter-card p-4 h-100">
        <h5 class="mb-3">Alamat & Informasi</h5>
        <p class="text-muted mb-2"><i class="bi bi-geo-alt"></i> Alun-Alun Tegal, Jawa Tengah</p>
        <p class="text-muted mb-2"><i class="bi bi-clock"></i> Jam layanan: 09.00 - 17.00</p>
        <p class="text-muted"><i class="bi bi-telephone"></i> (0283) 123 456</p>
        <img src="<?php echo e(base_url('assets/img/praban-lintang.jpg')); ?>" alt="Tegal" class="img-fluid detail-hero mt-3">
      </div>
    </div>
  </div>
</main>
