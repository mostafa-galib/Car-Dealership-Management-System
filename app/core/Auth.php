<?php
class Auth {
    // cookie names
    private static $cookieMap = [
        'admin'   => 'admin_rem',
        'sales'   => 'sales_rem',
        'customer'=> 'cust_rem',
    ];

    // Require login for protected actions
    public static function requireLogin($role) {
        $key = $role . "_id"; // admin_id / sales_id / customer_id
        if (empty($_SESSION[$key])) {
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'] ?? 'index.php';
            header("Location: index.php?route={$role}/login");
            exit;
        }
    }

    // Set login (session + optional remember)
    public static function login($role, $userRow, $remember=false) {
        // SESSION
        $_SESSION[$role . '_id'] = $userRow['id'];
        if ($role === 'admin') {
            $_SESSION['admin_username'] = $userRow['username'];
            $_SESSION['admin_email']    = $userRow['email'];
        } else {
            $_SESSION[$role . '_name']  = $userRow['name'];
            $_SESSION[$role . '_email'] = $userRow['email'];
        }

        // REMEMBER ME cookie -> id|sha256(password_hash)
        if ($remember) {
            $cookieName = self::$cookieMap[$role];
            $token = $userRow['id'] . '|' . hash('sha256', $userRow['password']);
            // 30 days
            setcookie($cookieName, $token, time()+60*60*24*30, "/", "", false, true);
        }
    }

    // Logout
    public static function logout($role) {
        $keys = [$role . '_id', $role . '_name', $role . '_email'];
        foreach ($keys as $k) unset($_SESSION[$k]);
        $cookieName = self::$cookieMap[$role] ?? null;
        if ($cookieName) setcookie($cookieName, '', time()-3600, "/");
    }

    // After login redirect back to intended URL
    public static function redirectAfterLogin($defaultRoute='home') {
        $to = $_SESSION['redirect_after_login'] ?? "index.php?route=$defaultRoute";
        unset($_SESSION['redirect_after_login']);
        header("Location: $to");
        exit;
    }

    // Try autologin via cookie (call early from config.php)
    public static function attemptCookieLogin($conn) {
        // Already logged in? skip
        if (!empty($_SESSION['admin_id']) || !empty($_SESSION['sales_id']) || !empty($_SESSION['customer_id'])) return;

        // helper to check cookie
        $check = function($role, $cookieName) use ($conn) {
            if (empty($_COOKIE[$cookieName])) return false;
            $parts = explode('|', $_COOKIE[$cookieName]);
            if (count($parts) !== 2) return false;
            [$id, $sig] = $parts;
            $id = (int)$id;

            switch ($role) {
                case 'admin':
                    require_once __DIR__ . "/../models/Admin.php";
                    $m = new Admin($conn);
                    $u = $m->findById($id);
                    break;
                case 'sales':
                    require_once __DIR__ . "/../models/SalesExecutive.php";
                    $m = new SalesExecutive($conn);
                    $u = $m->findById($id);
                    break;
                case 'customer':
                    require_once __DIR__ . "/../models/Customer.php";
                    $m = new Customer($conn);
                    $u = $m->findById($id);
                    break;
                default: $u = null;
            }
            if (!$u) return false;

            $expected = hash('sha256', $u['password']);
            if (hash_equals($expected, $sig)) {
                self::login($role, $u, true); // refresh session
                return true;
            }
            return false;
        };

        // try each role
        foreach (self::$cookieMap as $role => $cookieName) {
            if ($check($role, $cookieName)) break;
        }
    }
}
