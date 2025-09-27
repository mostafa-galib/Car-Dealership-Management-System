<?php
require_once __DIR__ . "/../models/Customer.php";

class CustomerAuthController {
    private $m;
    public function __construct($conn){ $this->m = new Customer($conn); }

    public function showLogin() {
        $error = $_GET['error'] ?? '';
        include __DIR__ . "/../views/customer/login.php";
    }

    public function showRegister() {
        $error = $_GET['error'] ?? '';
        include __DIR__ . "/../views/customer/register.php";
    }

    public function login() {
        if (!csrf_verify($_POST['_csrf'] ?? '')) {
            header("Location: index.php?route=customer/login&error=csrf"); exit;
        }
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember = !empty($_POST['remember']);

        $u = $this->m->findByEmail($email);
        if (!$u || !isset($u['password']) || $u['password'] !== $password) {
        header("Location: index.php?route=customer/login&error=invalid"); exit;
        }
        Auth::login('customer', $u, $remember);
        Auth::redirectAfterLogin('cars');
    }

    public function register() {
        if (!csrf_verify($_POST['_csrf'] ?? '')) {
            header("Location: index.php?route=customer/register&error=csrf"); exit;
        }
        $name = trim($_POST['name'] ?? '');
        $email= trim($_POST['email'] ?? '');
        $phone= trim($_POST['phone'] ?? '');
        $pass = $_POST['password'] ?? '';

        if ($name === '' || $email === '' || $pass === '') {
            header("Location: index.php?route=customer/register&error=missing"); exit;
        }
        // unique email check
        if ($this->m->findByEmail($email)) {
            header("Location: index.php?route=customer/register&error=exists"); exit;
        }
        $this->m->create($name, $email, $phone, $pass);
        // auto-login
        $u = $this->m->findByEmail($email);
        Auth::login('customer', $u, false);
        Auth::redirectAfterLogin('cars');
    }

    public function logout() {
        Auth::logout('customer');
        header("Location: index.php");
    }
}
