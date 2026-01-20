<?php

class HomeController extends BaseController
{
    public function index()
    {
        $pageTitle = 'Portal Destinasi & Kearifan Lokal Tegal';

        $categoryModel = new CategoryModel($this->pdo);
        $destinationModel = new DestinationModel($this->pdo);

        $categories = $categoryModel->all();
        $featured = $destinationModel->featured(6);

        if (!$featured) {
            $featured = $destinationModel->latest(6);
        }

        $this->render('home/index', compact('pageTitle', 'categories', 'featured'));
    }
}
