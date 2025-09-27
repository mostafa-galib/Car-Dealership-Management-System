<?php
class Csrf {
    public static function token() {
        return $_SESSION['_csrf'] ?? '';
    }
    public static function verify($token) {
        return hash_equals($_SESSION['_csrf'] ?? '', $token ?? '');
    }
}
