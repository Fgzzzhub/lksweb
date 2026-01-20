<?php

class AdminAuthController extends BaseController
{
    public function login()
    {
        if (is_logged_in()) {
            redirect(route_url('admin'));
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
                $stmt = $this->pdo->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
                $stmt->execute([$username]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password_hash'])) {
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'role' => $user['role'],
                    ];
                    redirect(route_url('admin'));
                }

                $errors[] = 'Username atau password salah.';
            }
        }

        $this->render('admin/login', compact('pageTitle', 'errors', 'username'), 'plain');
    }

    public function logout()
    {
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }

        redirect(route_url('admin/login'));
    }
}
