<nav class="navbar navbar-expand-lg navbar-dark nav-admin sticky-top">
  <div class="container">
    <a class="navbar-brand fw-semibold" href="<?php echo e(route_url('admin')); ?>">
      <i class="bi bi-grid"></i>
      <span>Admin Portal</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="adminNav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
        <li class="nav-item"><a class="nav-link <?php echo e(active_class('admin')); ?>" href="<?php echo e(route_url('admin')); ?>">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link <?php echo e(active_class('admin/categories*')); ?>" href="<?php echo e(route_url('admin/categories')); ?>">Kategori</a></li>
        <li class="nav-item"><a class="nav-link <?php echo e(active_class('admin/destinations*')); ?>" href="<?php echo e(route_url('admin/destinations')); ?>">Destinasi</a></li>
        <li class="nav-item ms-lg-2"><a class="btn btn-outline-light btn-sm" href="<?php echo e(route_url('admin/logout')); ?>">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
