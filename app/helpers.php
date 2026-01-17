<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function base_url($path = '')
{
    $base = rtrim(BASE_URL, '/');
    if ($base === '') {
        return $path ? '/' . ltrim($path, '/') : '';
    }

    return $base . ($path ? '/' . ltrim($path, '/') : '');
}

function redirect($url)
{
    header('Location: ' . $url);
    exit;
}

function is_post()
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function slugify($text)
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    $text = trim($text, '-');

    return $text !== '' ? $text : 'n-a';
}

function build_query_params($overrides = [], $exclude = [])
{
    $params = $_GET;

    foreach ($exclude as $key) {
        unset($params[$key]);
    }

    foreach ($overrides as $key => $value) {
        if ($value === null || $value === '') {
            unset($params[$key]);
        } else {
            $params[$key] = $value;
        }
    }

    return http_build_query($params);
}

function build_url($baseUrl, $query)
{
    return $query ? $baseUrl . '?' . $query : $baseUrl;
}

function paginate_links($total, $page, $limit, $baseUrl)
{
    $totalPages = (int) ceil($total / $limit);
    if ($totalPages <= 1) {
        return '';
    }

    $page = max(1, min($page, $totalPages));
    $range = 2;
    $start = max(1, $page - $range);
    $end = min($totalPages, $page + $range);

    $html = '<nav aria-label="Pagination"><ul class="pagination justify-content-center">';

    if ($page > 1) {
        $query = build_query_params(['page' => $page - 1]);
        $html .= '<li class="page-item"><a class="page-link" href="' . e(build_url($baseUrl, $query)) . '">&laquo;</a></li>';
    } else {
        $html .= '<li class="page-item disabled"><span class="page-link">&laquo;</span></li>';
    }

    for ($i = $start; $i <= $end; $i++) {
        $query = build_query_params(['page' => $i]);
        $active = $i === $page ? ' active' : '';
        $html .= '<li class="page-item' . $active . '"><a class="page-link" href="' . e(build_url($baseUrl, $query)) . '">' . $i . '</a></li>';
    }

    if ($page < $totalPages) {
        $query = build_query_params(['page' => $page + 1]);
        $html .= '<li class="page-item"><a class="page-link" href="' . e(build_url($baseUrl, $query)) . '">&raquo;</a></li>';
    } else {
        $html .= '<li class="page-item disabled"><span class="page-link">&raquo;</span></li>';
    }

    $html .= '</ul></nav>';

    return $html;
}

function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function validate_csrf($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token ?? '');
}

function set_flash($key, $message, $type = 'success')
{
    $_SESSION['flash'][$key] = [
        'message' => $message,
        'type' => $type,
    ];
}

function get_flash($key)
{
    if (!empty($_SESSION['flash'][$key])) {
        $flash = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $flash;
    }

    return null;
}

function is_logged_in()
{
    return !empty($_SESSION['user']);
}

function require_login()
{
    if (!is_logged_in()) {
        redirect(base_url('admin/login.php'));
    }
}

function active_class($file)
{
    return basename($_SERVER['SCRIPT_NAME']) === $file ? 'active' : '';
}

function image_url($file, $fallback = 'assets/img/placeholder-card.svg')
{
    if (!$file) {
        return base_url($fallback);
    }

    $root = dirname(__DIR__);
    $uploadPath = $root . '/assets/uploads/' . $file;
    if (is_file($uploadPath)) {
        return base_url('assets/uploads/' . $file);
    }

    $localPath = $root . '/assets/img/' . $file;
    if (is_file($localPath)) {
        return base_url('assets/img/' . $file);
    }

    return base_url($fallback);
}
