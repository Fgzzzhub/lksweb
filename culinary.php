<?php
require_once __DIR__ . '/app/config.php';
require_once __DIR__ . '/app/db.php';
require_once __DIR__ . '/app/helpers.php';

$pageTitle = 'Kuliner Khas - Portal Tegal';

$q = trim($_GET['q'] ?? '');
$sort = $_GET['sort'] ?? 'created_at';
$orderBy = $sort === 'name' ? 'd.name' : 'd.created_at';
$orderDir = $sort === 'name' ? 'ASC' : 'DESC';

$categoryStmt = $pdo->prepare('SELECT id, name FROM categories WHERE slug = ? LIMIT 1');
$categoryStmt->execute(['kuliner']);
$category = $categoryStmt->fetch();

$items = [];

if ($category) {
    $params = [':category_id' => $category['id']];
    $where = 'WHERE d.category_id = :category_id';

    if ($q !== '') {
        $where .= ' AND (d.name LIKE :q OR d.short_desc LIKE :q)';
        $params[':q'] = '%' . $q . '%';
    }

    $stmt = $pdo->prepare('SELECT d.* FROM destinations d ' . $where . ' ORDER BY ' . $orderBy . ' ' . $orderDir);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    $items = $stmt->fetchAll();
}
?>
<?php include __DIR__ . '/app/header.php'; ?>
<?php include __DIR__ . '/app/navbar.php'; ?>

<main class="container my-5">
  <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
    <div>
      <h1 class="section-title">Kuliner Khas Tegal</h1>
      <p class="section-subtitle">Rasakan cita rasa legendaris seperti Teh Poci, Kupat Glabed, dan lainnya.</p>
    </div>
  </div>

  <form class="card filter-card p-4 mb-4" method="get" data-auto-submit>
    <div class="row g-3 align-items-end">
      <div class="col-md-6">
        <label class="form-label">Cari Kuliner</label>
        <input type="text" name="q" class="form-control" placeholder="Cari nama kuliner" value="<?php echo e($q); ?>">
      </div>
      <div class="col-md-3">
        <label class="form-label">Sorting</label>
        <select name="sort" class="form-select">
          <option value="created_at" <?php echo $sort === 'created_at' ? 'selected' : ''; ?>>Terbaru</option>
          <option value="name" <?php echo $sort === 'name' ? 'selected' : ''; ?>>Nama</option>
        </select>
      </div>
      <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-cta flex-fill">Terapkan</button>
        <a href="<?php echo e(base_url('culinary.php')); ?>" class="btn btn-outline-secondary">Reset</a>
      </div>
    </div>
  </form>

  <div class="row g-4">
    <?php if (!$items) : ?>
      <div class="col-12">
        <div class="alert alert-warning">Data kuliner belum tersedia.</div>
      </div>
    <?php endif; ?>
    <?php foreach ($items as $item) : ?>
      <div class="col-md-6 col-lg-4">
        <div class="card destination-card">
          <img src="<?php echo e(image_url($item['thumbnail'])); ?>" alt="<?php echo e($item['name']); ?>">
          <div class="card-body">
            <span class="badge-category">Kuliner</span>
            <h5 class="card-title mt-2"><?php echo e($item['name']); ?></h5>
            <p class="card-text text-muted"><?php echo e($item['short_desc']); ?></p>
            <a class="btn btn-sm btn-outline-dark" href="<?php echo e(base_url('destination_detail.php?slug=' . $item['slug'])); ?>">Detail</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</main>

<?php include __DIR__ . '/app/footer.php'; ?>
