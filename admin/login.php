<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/db.php';
require_once __DIR__ . '/../app/helpers.php';

if (is_logged_in()) {
    redirect(base_url('admin/index.php'));
}

$pageTitle = 'Login Admin - Portal Tegal';
$errors = [];
$username = '';

if (is_post()) {
    if (!validate_csrf($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Token tidak valid.';
    }

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $errors[] = 'Username dan password wajib diisi.';
    }

    if (!$errors) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
            ];
            redirect(base_url('admin/index.php'));
        } else {
            $errors[] = 'Username atau password salah.';
        }
    }
}
?>
<?php include __DIR__ . '/../app/header.php'; ?>

<main class="container my-5" style="max-width: 520px;">
  <div class="text-center mb-4">
    <h1 class="section-title">Login Admin</h1>
    <p class="section-subtitle">Masuk untuk mengelola konten portal.</p>
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

  <form method="post" class="card filter-card p-4">
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
    <a href="<?php echo e(base_url('index.php')); ?>" class="btn btn-link w-100 mt-2">Kembali ke Portal</a>
  </form>
</main>

<?php include __DIR__ . '/../app/footer.php'; ?>
