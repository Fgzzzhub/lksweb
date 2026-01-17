<nav class="navbar navbar-expand-lg navbar-dark nav-admin sticky-top">
  <div class="container">
    <a class="navbar-brand fw-semibold" href="<?php echo e(base_url('admin/index.php')); ?>">
      <i class="bi bi-grid"></i>
      <span>Admin Portal</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="adminNav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
        <li class="nav-item"><a class="nav-link <?php echo e(active_class('index.php')); ?>" href="<?php echo e(base_url('admin/index.php')); ?>">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo e(base_url('admin/categories/index.php')); ?>">Kategori</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo e(base_url('admin/destinations/index.php')); ?>">Destinasi</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo e(base_url('admin/messages/index.php')); ?>">Pesan</a></li>
        <li class="nav-item ms-lg-2"><a class="btn btn-outline-light btn-sm" href="<?php echo e(base_url('admin/logout.php')); ?>">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
