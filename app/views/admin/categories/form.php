<main class="container my-5" style="max-width: 640px;">
  <h1 class="section-title"><?php echo e($formTitle); ?></h1>

  <?php if ($errors) : ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach ($errors as $error) : ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" class="card filter-card p-4" action="<?php echo e($formAction); ?>">
    <?php echo csrf_field(); ?>
    <div class="mb-3">
      <label class="form-label">Nama Kategori</label>
      <input type="text" name="name" class="form-control" value="<?php echo e($name); ?>" required>
    </div>
    <div class="d-flex gap-2">
      <button type="submit" class="btn btn-cta"><?php echo e($submitLabel); ?></button>
      <a href="<?php echo e($cancelUrl); ?>" class="btn btn-outline-dark">Batal</a>
    </div>
  </form>
</main>
