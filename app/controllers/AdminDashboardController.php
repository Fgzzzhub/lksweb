<?php

class AdminDashboardController extends BaseController
{
    public function index()
    {
        require_login();

        $pageTitle = 'Dashboard Admin - Portal Tegal';

        $destCount = (int) $this->pdo->query('SELECT COUNT(*) FROM destinations')->fetchColumn();
        $catCount = (int) $this->pdo->query('SELECT COUNT(*) FROM categories')->fetchColumn();
        $msgCount = (int) $this->pdo->query('SELECT COUNT(*) FROM messages')->fetchColumn();

        $this->render('admin/dashboard', compact('pageTitle', 'destCount', 'catCount', 'msgCount'), 'admin');
    }
}
