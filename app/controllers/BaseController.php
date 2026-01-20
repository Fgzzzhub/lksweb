<?php

class BaseController
{
    protected $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    protected function render($view, array $data = [], $layout = 'public')
    {
        view('layouts/header', $data);

        if ($layout === 'admin') {
            view('layouts/admin_navbar', $data);
        } elseif ($layout === 'public') {
            view('layouts/navbar', $data);
        }

        view($view, $data);
        view('layouts/footer', $data);
    }
}
