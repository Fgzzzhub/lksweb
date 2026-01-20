<main class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="section-title">Pesan Masuk</h1>
      <p class="section-subtitle">Daftar pesan dari pengunjung portal.</p>
    </div>
  </div>

  <?php if ($flash) : ?>
    <div class="alert alert-<?php echo e($flash['type']); ?>"><?php echo e($flash['message']); ?></div>
  <?php endif; ?>

  <div class="table-responsive table-admin">
    <table class="table table-hover mb-0">
      <thead class="table-light">
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>Subjek</th>
          <th>Tanggal</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($messages as $message) : ?>
          <tr>
            <td><?php echo e($message['name']); ?></td>
            <td><?php echo e($message['email']); ?></td>
            <td><?php echo e($message['subject']); ?></td>
            <td><?php echo e($message['created_at']); ?></td>
            <td class="d-flex gap-2">
              <a class="btn btn-sm btn-outline-dark" href="<?php echo e(route_url('admin/messages/show', ['id' => $message['id']])); ?>">Detail</a>
              <form method="post" action="<?php echo e(route_url('admin/messages/delete')); ?>" onsubmit="return confirm('Hapus pesan ini?');">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($message['id']); ?>">
                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>
