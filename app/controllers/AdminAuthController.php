<?php
require_once __DIR__ . "/../models/Admin.php";

class AdminAuthController {
    private $m;
    public function __construct($conn){ $this->m = new Admin($conn); }

    public function showLogin() {
        $error = $_GET['error'] ?? '';
        include __DIR__ . "/../views/admin/login.php";
    }

    public function login() {
        if (!csrf_verify($_POST['_csrf'] ?? '')) {
            header("Location: index.php?route=admin/login&error=csrf"); exit;
        }
        $identity = trim($_POST['identity'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember = !empty($_POST['remember']);

        $u = $this->m->findByIdentity($identity);
        if (!$u || !isset($u['password']) || $u['password'] !== $password) {
        header("Location: index.php?route=admin/login&error=invalid"); exit;
        }
        Auth::login('admin', $u, $remember);
        Auth::redirectAfterLogin('admin/dashboard');
    }

    public function logout() {
        Auth::logout('admin');
        header("Location: index.php?route=admin/login");
    }
}
