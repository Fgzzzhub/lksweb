<?php

class AdminDestinationsController extends BaseController
{
    public function index()
    {
        require_login();

        $pageTitle = 'Kelola Destinasi - Portal Tegal';
        $flash = get_flash('destination');
        $q = trim($_GET['q'] ?? '');

        $destinationModel = new DestinationModel($this->pdo);
        $destinations = $destinationModel->listAdmin($q);

        $this->render('admin/destinations/index', compact('pageTitle', 'flash', 'q', 'destinations'), 'admin');
    }

    public function create()
    {
        require_login();

        $pageTitle = 'Tambah Destinasi - Portal Tegal';
        $errors = [];

        $name = '';
        $categoryId = 0;
        $location = '';
        $shortDesc = '';
        $content = '';
        $isFeatured = 0;

        $categoryModel = new CategoryModel($this->pdo);
        $destinationModel = new DestinationModel($this->pdo);
        $categories = $categoryModel->all('name');

        if (is_post()) {
            if (!validate_csrf($_POST['csrf_token'] ?? '')) {
                $errors[] = 'Token tidak valid.';
            }

            $name = trim($_POST['name'] ?? '');
            $categoryId = (int) ($_POST['category_id'] ?? 0);
            $location = trim($_POST['location'] ?? '');
            $shortDesc = trim($_POST['short_desc'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $isFeatured = isset($_POST['is_featured']) ? 1 : 0;

            if ($name === '') {
                $errors[] = 'Nama destinasi wajib diisi.';
            }

            if ($categoryId <= 0) {
                $errors[] = 'Kategori wajib dipilih.';
            }

            if ($shortDesc === '') {
                $errors[] = 'Deskripsi singkat wajib diisi.';
            }

            if ($content === '') {
                $errors[] = 'Konten lengkap wajib diisi.';
            }

            $thumbnail = null;
            $galleryFiles = [];

            if (!$errors) {
                $thumbnail = upload_image($_FILES['thumbnail'] ?? [], $errors, 'Thumbnail');

                if (!empty($_FILES['gallery']['name'][0])) {
                    foreach ($_FILES['gallery']['name'] as $index => $nameFile) {
                        $file = [
                            'name' => $_FILES['gallery']['name'][$index],
                            'type' => $_FILES['gallery']['type'][$index],
                            'tmp_name' => $_FILES['gallery']['tmp_name'][$index],
                            'error' => $_FILES['gallery']['error'][$index],
                            'size' => $_FILES['gallery']['size'][$index],
                        ];
                        $uploaded = upload_image($file, $errors, 'Galeri');
                        if ($uploaded) {
                            $galleryFiles[] = $uploaded;
                        }
                    }
                }
            }

            if (!$errors) {
                $slug = $destinationModel->makeUniqueSlug(slugify($name));

                if (!$thumbnail) {
                    $thumbnail = 'praban-lintang.jpg';
                }

                $destinationId = $destinationModel->create([
                    'category_id' => $categoryId,
                    'name' => $name,
                    'slug' => $slug,
                    'location' => $location,
                    'short_desc' => $shortDesc,
                    'content' => $content,
                    'thumbnail' => $thumbnail,
                    'is_featured' => $isFeatured,
                ]);

                if ($galleryFiles) {
                    $destinationModel->addGallery($destinationId, $galleryFiles);
                }

                set_flash('destination', 'Destinasi berhasil ditambahkan.');
                redirect(route_url('admin/destinations'));
            }
        }

        $formTitle = 'Tambah Destinasi';
        $subtitle = 'Lengkapi data destinasi baru.';
        $formAction = route_url('admin/destinations/create');
        $submitLabel = 'Simpan';
        $cancelUrl = route_url('admin/destinations');
        $isEdit = false;
        $gallery = [];

        $this->render('admin/destinations/form', compact(
            'pageTitle',
            'errors',
            'name',
            'categoryId',
            'location',
            'shortDesc',
            'content',
            'isFeatured',
            'categories',
            'formTitle',
            'subtitle',
            'formAction',
            'submitLabel',
            'cancelUrl',
            'isEdit',
            'gallery'
        ), 'admin');
    }

    public function edit()
    {
        require_login();

        $pageTitle = 'Edit Destinasi - Portal Tegal';
        $errors = [];
        $id = (int) ($_GET['id'] ?? 0);

        $categoryModel = new CategoryModel($this->pdo);
        $destinationModel = new DestinationModel($this->pdo);

        $destination = $destinationModel->findById($id);
        if (!$destination) {
            redirect(route_url('admin/destinations'));
        }

        $categories = $categoryModel->all('name');

        $name = $destination['name'];
        $categoryId = (int) $destination['category_id'];
        $location = $destination['location'];
        $shortDesc = $destination['short_desc'];
        $content = $destination['content'];
        $isFeatured = (int) $destination['is_featured'];

        if (is_post()) {
            if (!validate_csrf($_POST['csrf_token'] ?? '')) {
                $errors[] = 'Token tidak valid.';
            }

            $name = trim($_POST['name'] ?? '');
            $categoryId = (int) ($_POST['category_id'] ?? 0);
            $location = trim($_POST['location'] ?? '');
            $shortDesc = trim($_POST['short_desc'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $isFeatured = isset($_POST['is_featured']) ? 1 : 0;

            if ($name === '') {
                $errors[] = 'Nama destinasi wajib diisi.';
            }

            if ($categoryId <= 0) {
                $errors[] = 'Kategori wajib dipilih.';
            }

            if ($shortDesc === '') {
                $errors[] = 'Deskripsi singkat wajib diisi.';
            }

            if ($content === '') {
                $errors[] = 'Konten lengkap wajib diisi.';
            }

            $newThumbnail = null;
            $galleryFiles = [];

            if (!$errors) {
                $newThumbnail = upload_image($_FILES['thumbnail'] ?? [], $errors, 'Thumbnail');

                if (!empty($_FILES['gallery']['name'][0])) {
                    foreach ($_FILES['gallery']['name'] as $index => $nameFile) {
                        $file = [
                            'name' => $_FILES['gallery']['name'][$index],
                            'type' => $_FILES['gallery']['type'][$index],
                            'tmp_name' => $_FILES['gallery']['tmp_name'][$index],
                            'error' => $_FILES['gallery']['error'][$index],
                            'size' => $_FILES['gallery']['size'][$index],
                        ];
                        $uploaded = upload_image($file, $errors, 'Galeri');
                        if ($uploaded) {
                            $galleryFiles[] = $uploaded;
                        }
                    }
                }
            }

            if (!$errors) {
                $slug = $destinationModel->makeUniqueSlug(slugify($name), $id);
                $thumbnail = $destination['thumbnail'];

                if ($newThumbnail) {
                    $oldPath = UPLOAD_DIR . '/' . $thumbnail;
                    if ($thumbnail && is_file($oldPath)) {
                        unlink($oldPath);
                    }
                    $thumbnail = $newThumbnail;
                }

                $destinationModel->update($id, [
                    'category_id' => $categoryId,
                    'name' => $name,
                    'slug' => $slug,
                    'location' => $location,
                    'short_desc' => $shortDesc,
                    'content' => $content,
                    'thumbnail' => $thumbnail,
                    'is_featured' => $isFeatured,
                ]);

                if ($galleryFiles) {
                    $destinationModel->addGallery($id, $galleryFiles);
                }

                set_flash('destination', 'Destinasi berhasil diperbarui.');
                redirect(route_url('admin/destinations'));
            }
        }

        $gallery = $destinationModel->getGallery($id, 'DESC');

        $formTitle = 'Edit Destinasi';
        $subtitle = 'Perbarui data destinasi yang dipilih.';
        $formAction = route_url('admin/destinations/edit', ['id' => $id]);
        $submitLabel = 'Simpan';
        $cancelUrl = route_url('admin/destinations');
        $isEdit = true;

        $this->render('admin/destinations/form', compact(
            'pageTitle',
            'errors',
            'name',
            'categoryId',
            'location',
            'shortDesc',
            'content',
            'isFeatured',
            'categories',
            'formTitle',
            'subtitle',
            'formAction',
            'submitLabel',
            'cancelUrl',
            'isEdit',
            'gallery',
            'destination'
        ), 'admin');
    }

    public function delete()
    {
        require_login();

        if (!is_post()) {
            redirect(route_url('admin/destinations'));
        }

        if (!validate_csrf($_POST['csrf_token'] ?? '')) {
            set_flash('destination', 'Token tidak valid.', 'danger');
            redirect(route_url('admin/destinations'));
        }

        $id = (int) ($_POST['id'] ?? 0);
        if ($id <= 0) {
            set_flash('destination', 'Destinasi tidak ditemukan.', 'danger');
            redirect(route_url('admin/destinations'));
        }

        $destinationModel = new DestinationModel($this->pdo);
        $destination = $destinationModel->findById($id);

        if (!$destination) {
            set_flash('destination', 'Destinasi tidak ditemukan.', 'danger');
            redirect(route_url('admin/destinations'));
        }

        $gallery = $destinationModel->getGallery($id);

        $destinationModel->deleteGallery($id);
        $destinationModel->delete($id);

        $thumbPath = UPLOAD_DIR . '/' . $destination['thumbnail'];
        if ($destination['thumbnail'] && is_file($thumbPath)) {
            unlink($thumbPath);
        }

        foreach ($gallery as $img) {
            $filePath = UPLOAD_DIR . '/' . $img;
            if ($img && is_file($filePath)) {
                unlink($filePath);
            }
        }

        set_flash('destination', 'Destinasi berhasil dihapus.');
        redirect(route_url('admin/destinations'));
    }
}
