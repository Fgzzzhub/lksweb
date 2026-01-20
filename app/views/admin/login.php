<main class="container my-5" style="max-width: 520px;">
  <div class="text-center mb-4">
    <h1 class="section-title">Login Admin</h1>
  </div>

  <?php if ($errors) : ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach ($errors as $error) : ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" class="card filter-card p-4" action="<?php echo e(route_url('admin/login')); ?>">
    <?php echo csrf_field(); ?>
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" value="<?php echo e($username); ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-cta w-100">Login</button>
    <a href="<?php echo e(route_url()); ?>" class="btn btn-outline-dark btn-rounded w-100 mt-2">Kembali ke Portal</a>
  </form>
</main>
