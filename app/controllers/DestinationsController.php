<?php

class DestinationsController extends BaseController
{
    public function index()
    {
        $pageTitle = 'Daftar Destinasi - Portal Tegal';

        $filters = [
            'q' => trim($_GET['q'] ?? ''),
            'category_id' => (int) ($_GET['category_id'] ?? 0),
            'location' => trim($_GET['location'] ?? ''),
            'tag' => trim($_GET['tag'] ?? ''),
            'sort' => $_GET['sort'] ?? 'created_at',
            'order' => $_GET['order'] ?? 'desc',
        ];

        $limit = 9;
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $offset = ($page - 1) * $limit;

        $destinationModel = new DestinationModel($this->pdo);
        $categoryModel = new CategoryModel($this->pdo);

        $result = $destinationModel->search($filters, $limit, $offset);
        $destinations = $result['items'];
        $total = $result['total'];

        $categories = $categoryModel->all('name');
        $locations = $destinationModel->getLocations();

        $q = $filters['q'];
        $categoryId = $filters['category_id'];
        $location = $filters['location'];
        $tag = $filters['tag'];
        $sort = $filters['sort'];
        $order = strtolower($filters['order']) === 'asc' ? 'ASC' : 'DESC';

        $this->render('destinations/index', compact(
            'pageTitle',
            'destinations',
            'total',
            'page',
            'limit',
            'categories',
            'locations',
            'q',
            'categoryId',
            'location',
            'tag',
            'sort',
            'order'
        ));
    }

    public function show()
    {
        $slug = trim($_GET['slug'] ?? '');
        if ($slug === '') {
            redirect(route_url('destinations'));
        }

        $destinationModel = new DestinationModel($this->pdo);

        $destination = $destinationModel->findBySlug($slug);

        if (!$destination) {
            $pageTitle = 'Destinasi Tidak Ditemukan';
            $this->render('destinations/not_found', compact('pageTitle'));
            return;
        }

        $destinationModel->incrementViews($destination['id']);

        $gallery = $destinationModel->getGallery($destination['id']);
        if (!$gallery) {
            $gallery = ['guci-hot-spring.jpg', 'waduk-cacaban.jpg', 'praban-lintang.jpg'];
        }

        $related = $destinationModel->related($destination['category_id'], $destination['id'], 3);
        $pageTitle = $destination['name'] . ' - Portal Tegal';

        $this->render('destinations/detail', compact('pageTitle', 'destination', 'gallery', 'related'));
    }
}
