<?php

class AdminMessagesController extends BaseController
{
    public function index()
    {
        require_login();

        $pageTitle = 'Pesan Masuk - Portal Tegal';
        $flash = get_flash('message');

        $messageModel = new MessageModel($this->pdo);
        $messages = $messageModel->all();

        $this->render('admin/messages/index', compact('pageTitle', 'flash', 'messages'), 'admin');
    }

    public function show()
    {
        require_login();

        $id = (int) ($_GET['id'] ?? 0);
        $messageModel = new MessageModel($this->pdo);
        $message = $messageModel->find($id);

        if (!$message) {
            redirect(route_url('admin/messages'));
        }

        $pageTitle = 'Detail Pesan - Portal Tegal';
        $this->render('admin/messages/show', compact('pageTitle', 'message'), 'admin');
    }

    public function delete()
    {
        require_login();

        if (!is_post()) {
            redirect(route_url('admin/messages'));
        }

        if (!validate_csrf($_POST['csrf_token'] ?? '')) {
            set_flash('message', 'Token tidak valid.', 'danger');
            redirect(route_url('admin/messages'));
        }

        $id = (int) ($_POST['id'] ?? 0);
        if ($id <= 0) {
            set_flash('message', 'Pesan tidak ditemukan.', 'danger');
            redirect(route_url('admin/messages'));
        }

        $messageModel = new MessageModel($this->pdo);
        $messageModel->delete($id);

        set_flash('message', 'Pesan berhasil dihapus.');
        redirect(route_url('admin/messages'));
    }
}
