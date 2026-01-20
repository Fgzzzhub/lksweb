<?php

class CulinaryController extends BaseController
{
    public function index()
    {
        $pageTitle = 'Kuliner Khas - Portal Tegal';

        $q = trim($_GET['q'] ?? '');
        $sort = $_GET['sort'] ?? 'created_at';
        $order = $_GET['order'] ?? 'desc';

        $categoryModel = new CategoryModel($this->pdo);
        $destinationModel = new DestinationModel($this->pdo);

        $category = $categoryModel->findBySlug('kuliner');
        $items = [];

        if ($category) {
            $items = $destinationModel->listByCategory($category['id'], $q, $sort, $order);
        }

        $this->render('culinary/index', compact('pageTitle', 'q', 'sort', 'items'));
    }
}
