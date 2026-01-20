<?php

class AdminCategoriesController extends BaseController
{
    public function index()
    {
        require_login();

        $pageTitle = 'Kelola Kategori - Portal Tegal';

        $categoryModel = new CategoryModel($this->pdo);
        $categories = $categoryModel->all('id', 'DESC');
        $flash = get_flash('category');

        $this->render('admin/categories/index', compact('pageTitle', 'categories', 'flash'), 'admin');
    }

    public function create()
    {
        require_login();

        $pageTitle = 'Tambah Kategori - Portal Tegal';
        $errors = [];
        $name = '';

        $categoryModel = new CategoryModel($this->pdo);

        if (is_post()) {
            if (!validate_csrf($_POST['csrf_token'] ?? '')) {
                $errors[] = 'Token tidak valid.';
            }

            $name = trim($_POST['name'] ?? '');

            if ($name === '') {
                $errors[] = 'Nama kategori wajib diisi.';
            }

            if (!$errors) {
                $slug = $categoryModel->makeUniqueSlug(slugify($name));
                $categoryModel->create($name, $slug);

                set_flash('category', 'Kategori berhasil ditambahkan.');
                redirect(route_url('admin/categories'));
            }
        }

        $formTitle = 'Tambah Kategori';
        $subtitle = 'Buat kategori baru untuk destinasi.';
        $formAction = route_url('admin/categories/create');
        $submitLabel = 'Simpan';
        $cancelUrl = route_url('admin/categories');

        $this->render('admin/categories/form', compact(
            'pageTitle',
            'errors',
            'name',
            'formTitle',
            'subtitle',
            'formAction',
            'submitLabel',
            'cancelUrl'
        ), 'admin');
    }

    public function edit()
    {
        require_login();

        $pageTitle = 'Edit Kategori - Portal Tegal';
        $errors = [];
        $id = (int) ($_GET['id'] ?? 0);

        $categoryModel = new CategoryModel($this->pdo);
        $category = $categoryModel->find($id);

        if (!$category) {
            redirect(route_url('admin/categories'));
        }

        $name = $category['name'];

        if (is_post()) {
            if (!validate_csrf($_POST['csrf_token'] ?? '')) {
                $errors[] = 'Token tidak valid.';
            }

            $name = trim($_POST['name'] ?? '');

            if ($name === '') {
                $errors[] = 'Nama kategori wajib diisi.';
            }

            if (!$errors) {
                $slug = $categoryModel->makeUniqueSlug(slugify($name), $id);
                $categoryModel->update($id, $name, $slug);

                set_flash('category', 'Kategori berhasil diperbarui.');
                redirect(route_url('admin/categories'));
            }
        }

        $formTitle = 'Edit Kategori';
        $subtitle = 'Perbarui informasi kategori.';
        $formAction = route_url('admin/categories/edit', ['id' => $id]);
        $submitLabel = 'Simpan';
        $cancelUrl = route_url('admin/categories');

        $this->render('admin/categories/form', compact(
            'pageTitle',
            'errors',
            'name',
            'formTitle',
            'subtitle',
            'formAction',
            'submitLabel',
            'cancelUrl'
        ), 'admin');
    }

    public function delete()
    {
        require_login();

        if (!is_post()) {
            redirect(route_url('admin/categories'));
        }

        if (!validate_csrf($_POST['csrf_token'] ?? '')) {
            set_flash('category', 'Token tidak valid.', 'danger');
            redirect(route_url('admin/categories'));
        }

        $id = (int) ($_POST['id'] ?? 0);
        if ($id <= 0) {
            set_flash('category', 'Kategori tidak ditemukan.', 'danger');
            redirect(route_url('admin/categories'));
        }

        $categoryModel = new CategoryModel($this->pdo);

        if ($categoryModel->isInUse($id)) {
            set_flash('category', 'Kategori tidak bisa dihapus karena masih digunakan.', 'danger');
            redirect(route_url('admin/categories'));
        }

        $categoryModel->delete($id);
        set_flash('category', 'Kategori berhasil dihapus.');
        redirect(route_url('admin/categories'));
    }
}
