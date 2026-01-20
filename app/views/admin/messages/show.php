<main class="container my-5" style="max-width: 760px;">
  <h1 class="section-title">Detail Pesan</h1>
  <div class="card filter-card p-4">
    <p class="text-muted mb-1"><strong>Nama:</strong> <?php echo e($message['name']); ?></p>
    <p class="text-muted mb-1"><strong>Email:</strong> <?php echo e($message['email']); ?></p>
    <p class="text-muted mb-1"><strong>Subjek:</strong> <?php echo e($message['subject']); ?></p>
    <p class="text-muted mb-3"><strong>Tanggal:</strong> <?php echo e($message['created_at']); ?></p>
    <div class="border rounded p-3 bg-light">
      <?php echo nl2br(e($message['message'])); ?>
    </div>
    <div class="mt-4 d-flex gap-2">
      <a href="<?php echo e(route_url('admin/messages')); ?>" class="btn btn-outline-secondary">Kembali</a>
      <form method="post" action="<?php echo e(route_url('admin/messages/delete')); ?>" onsubmit="return confirm('Hapus pesan ini?');">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="id" value="<?php echo e($message['id']); ?>">
        <button type="submit" class="btn btn-outline-danger">Hapus</button>
      </form>
    </div>
  </div>
</main>
