<main class="container my-5">
  <h1 class="section-title">Dashboard</h1>

  <div class="row g-4 mt-3">
    <div class="col-md-6">
      <div class="card destination-card p-4">
        <h5>Total Destinasi</h5>
        <div class="display-6 fw-semibold"><?php echo e($destCount); ?></div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card destination-card p-4">
        <h5>Total Kategori</h5>
        <div class="display-6 fw-semibold"><?php echo e($catCount); ?></div>
      </div>
    </div>
  </div>
</main>
