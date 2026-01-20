<nav class="navbar navbar-expand-lg navbar-dark nav-heritage sticky-top">
  <div class="container">
    <a class="navbar-brand fw-semibold" href="<?php echo e(route_url()); ?>">
      <i class="bi bi-compass"></i>
      <span>Portal Tegal</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
        <li class="nav-item"><a class="nav-link <?php echo e(active_class('')); ?>" href="<?php echo e(route_url()); ?>">Home</a></li>
        <li class="nav-item"><a class="nav-link <?php echo e(active_class('destinations*')); ?>" href="<?php echo e(route_url('destinations')); ?>">Destinasi</a></li>
        <li class="nav-item"><a class="nav-link <?php echo e(active_class('culture')); ?>" href="<?php echo e(route_url('culture')); ?>">Budaya</a></li>
        <li class="nav-item"><a class="nav-link <?php echo e(active_class('culinary')); ?>" href="<?php echo e(route_url('culinary')); ?>">Kuliner</a></li>
        <li class="nav-item ms-lg-2"><a class="btn btn-cta" href="<?php echo e(route_url('admin/login')); ?>">Admin</a></li>
      </ul>
    </div>
  </div>
</nav>
