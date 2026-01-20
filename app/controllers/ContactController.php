<?php

class ContactController extends BaseController
{
    public function index()
    {
        $pageTitle = 'Kontak - Portal Tegal';

        $errors = [];
        $success = false;
        $name = '';
        $email = '';
        $subject = '';
        $message = '';

        if (is_post()) {
            if (!validate_csrf($_POST['csrf_token'] ?? '')) {
                $errors[] = 'Token tidak valid. Silakan coba lagi.';
            }

            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $subject = trim($_POST['subject'] ?? '');
            $message = trim($_POST['message'] ?? '');

            if ($name === '' || strlen($name) < 3) {
                $errors[] = 'Nama minimal 3 karakter.';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email tidak valid.';
            }

            if ($subject === '') {
                $errors[] = 'Subjek harus diisi.';
            }

            if ($message === '' || strlen($message) < 10) {
                $errors[] = 'Pesan minimal 10 karakter.';
            }

            if (!$errors) {
                $messageModel = new MessageModel($this->pdo);
                $messageModel->create($name, $email, $subject, $message);
                $success = true;
                $name = $email = $subject = $message = '';
            }
        }

        $this->render('contact/index', compact('pageTitle', 'errors', 'success', 'name', 'email', 'subject', 'message'));
    }
}
