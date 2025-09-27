<?php
require_once __DIR__ . "/../models/SalesExecutive.php";

class SalesAuthController {
    private $m;
    public function __construct($conn){ $this->m = new SalesExecutive($conn); }

    public function showLogin() {
        $error = $_GET['error'] ?? '';
        include __DIR__ . "/../views/sales/login.php";
    }

    public function login() {
        if (!csrf_verify($_POST['_csrf'] ?? '')) {
            header("Location: index.php?route=sales/login&error=csrf"); exit;
        }
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember = !empty($_POST['remember']);

        $u = $this->m->findByEmail($email);
        if (!$u || !isset($u['password']) || $u['password'] !== $password) {
        header("Location: index.php?route=sales/login&error=invalid"); exit;
        }
        Auth::login('sales', $u, $remember);
        Auth::redirectAfterLogin('sales/dashboard');
    }

    public function logout() {
        Auth::logout('sales');
        header("Location: index.php?route=sales/login");
    }
}
