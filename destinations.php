<?php
require_once __DIR__ . '/app/config.php';
require_once __DIR__ . '/app/db.php';
require_once __DIR__ . '/app/helpers.php';

$pageTitle = 'Daftar Destinasi - Portal Tegal';

$q = trim($_GET['q'] ?? '');
$categoryId = (int) ($_GET['category_id'] ?? 0);
$location = trim($_GET['location'] ?? '');
$tag = trim($_GET['tag'] ?? '');
$sort = $_GET['sort'] ?? 'created_at';
$order = strtolower($_GET['order'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
$limit = 9;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

$sortMap = [
    'created_at' => 'd.created_at',
    'name' => 'd.name',
    'views' => 'd.views',
];
$orderBy = $sortMap[$sort] ?? 'd.created_at';

$where = [];
$params = [];

if ($q !== '') {
    $where[] = '(d.name LIKE :q OR d.slug LIKE :q OR d.short_desc LIKE :q)';
    $params[':q'] = '%' . $q . '%';
}

if ($categoryId > 0) {
    $where[] = 'd.category_id = :category_id';
    $params[':category_id'] = $categoryId;
}

if ($location !== '') {
    $where[] = 'd.location = :location';
    $params[':location'] = $location;
}

if ($tag !== '') {
    $where[] = '(d.short_desc LIKE :tag OR d.content LIKE :tag)';
    $params[':tag'] = '%' . $tag . '%';
}

$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$totalStmt = $pdo->prepare('SELECT COUNT(*) FROM destinations d ' . $whereSql);
foreach ($params as $key => $value) {
    $totalStmt->bindValue($key, $value);
}
$totalStmt->execute();
$total = (int) $totalStmt->fetchColumn();

$query = 'SELECT d.*, c.name AS category_name, c.slug AS category_slug FROM destinations d JOIN categories c ON c.id = d.category_id ' . $whereSql . ' ORDER BY ' . $orderBy . ' ' . $order . ' LIMIT :limit OFFSET :offset';
$stmt = $pdo->prepare($query);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$destinations = $stmt->fetchAll();

$categories = $pdo->query('SELECT id, name FROM categories ORDER BY name')->fetchAll();
$locations = $pdo->query("SELECT DISTINCT location FROM destinations WHERE location <> '' ORDER BY location")->fetchAll(PDO::FETCH_COLUMN);
?>
<?php include __DIR__ . '/app/header.php'; ?>
<?php include __DIR__ . '/app/navbar.php'; ?>

<main class="container my-5">
  <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
    <div>
      <h1 class="section-title">Daftar Destinasi</h1>
      <p class="section-subtitle">Cari dan filter destinasi terbaik di Tegal sesuai kebutuhanmu.</p>
    </div>
    <div class="text-muted">Total: <?php echo e($total); ?> destinasi</div>
  </div>

  <div class="row g-4">
    <div class="col-lg-4">
      <form class="card filter-card p-4" method="get" data-auto-submit>
        <h5 class="mb-3">Filter Pencarian</h5>
        <div class="mb-3">
          <label class="form-label">Kata kunci</label>
          <input type="text" name="q" class="form-control" placeholder="Cari destinasi" value="<?php echo e($q); ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Kategori</label>
          <select name="category_id" class="form-select">
            <option value="">Semua kategori</option>
            <?php foreach ($categories as $category) : ?>
              <option value="<?php echo e($category['id']); ?>" <?php echo $categoryId === (int) $category['id'] ? 'selected' : ''; ?>><?php echo e($category['name']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Lokasi</label>
          <select name="location" class="form-select">
            <option value="">Semua lokasi</option>
            <?php foreach ($locations as $loc) : ?>
              <option value="<?php echo e($loc); ?>" <?php echo $location === $loc ? 'selected' : ''; ?>><?php echo e($loc); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Tag</label>
          <input type="text" name="tag" class="form-control" placeholder="Contoh: heritage" value="<?php echo e($tag); ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Sorting</label>
          <select name="sort" class="form-select">
            <option value="created_at" <?php echo $sort === 'created_at' ? 'selected' : ''; ?>>Terbaru</option>
            <option value="name" <?php echo $sort === 'name' ? 'selected' : ''; ?>>Nama</option>
            <option value="views" <?php echo $sort === 'views' ? 'selected' : ''; ?>>Terpopuler</option>
          </select>
        </div>
        <div class="mb-4">
          <label class="form-label">Urutan</label>
          <select name="order" class="form-select">
            <option value="desc" <?php echo $order === 'DESC' ? 'selected' : ''; ?>>Menurun</option>
            <option value="asc" <?php echo $order === 'ASC' ? 'selected' : ''; ?>>Menaik</option>
          </select>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-cta flex-fill">Terapkan</button>
          <a href="<?php echo e(base_url('destinations.php')); ?>" class="btn btn-outline-secondary">Reset</a>
        </div>
      </form>
    </div>

    <div class="col-lg-8">
      <div class="row g-4">
        <?php if (!$destinations) : ?>
          <div class="col-12">
            <div class="alert alert-warning">Tidak ada destinasi ditemukan. Coba ubah filter pencarian.</div>
          </div>
        <?php endif; ?>
        <?php foreach ($destinations as $item) : ?>
          <div class="col-md-6">
            <div class="card destination-card">
              <img src="<?php echo e(image_url($item['thumbnail'])); ?>" alt="<?php echo e($item['name']); ?>">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="badge-category"><?php echo e($item['category_name']); ?></span>
                  <small class="text-muted"><i class="bi bi-geo-alt"></i> <?php echo e($item['location']); ?></small>
                </div>
                <h5 class="card-title fw-semibold"><?php echo e($item['name']); ?></h5>
                <p class="card-text text-muted"><?php echo e($item['short_desc']); ?></p>
                <div class="d-flex justify-content-between align-items-center">
                  <a class="btn btn-sm btn-outline-dark" href="<?php echo e(base_url('destination_detail.php?slug=' . $item['slug'])); ?>">Detail</a>
                  <span class="text-muted small"><i class="bi bi-eye"></i> <?php echo e($item['views']); ?></span>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="mt-4">
        <?php echo paginate_links($total, $page, $limit, base_url('destinations.php')); ?>
      </div>
    </div>
  </div>
</main>

<?php include __DIR__ . '/app/footer.php'; ?>
