<main class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="section-title">Kategori</h1>
    </div>
    <a href="<?php echo e(route_url('admin/categories/create')); ?>" class="btn btn-cta">Tambah Kategori</a>
  </div>

  <?php if ($flash) : ?>
    <div class="alert alert-<?php echo e($flash['type']); ?>"><?php echo e($flash['message']); ?></div>
  <?php endif; ?>

  <div class="table-responsive table-admin">
    <table class="table table-hover mb-0">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Slug</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($categories as $category) : ?>
          <tr>
            <td><?php echo e($category['id']); ?></td>
            <td><?php echo e($category['name']); ?></td>
            <td><?php echo e($category['slug']); ?></td>
            <td class="d-flex gap-2">
              <a class="btn btn-sm btn-outline-dark" href="<?php echo e(route_url('admin/categories/edit', ['id' => $category['id']])); ?>">Edit</a>
              <form method="post" action="<?php echo e(route_url('admin/categories/delete')); ?>" onsubmit="return confirm('Hapus kategori ini?');">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($category['id']); ?>">
                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>
