<?php
// config.php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli("localhost", "root", "", "cds"); 
$conn->set_charset("utf8mb4");

// Session start
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Load helpers
require_once __DIR__ . "/app/core/Csrf.php";
require_once __DIR__ . "/app/core/Auth.php";

// CSRF init
if (empty($_SESSION['_csrf'])) {
    $_SESSION['_csrf'] = bin2hex(random_bytes(32));
}

// Helpers
function csrf_token() { return $_SESSION['_csrf'] ?? ''; }
function csrf_verify($token) { return hash_equals($_SESSION['_csrf'] ?? '', $token ?? ''); }

// Try remember-me cookie autologin (guest only)
Auth::attemptCookieLogin($conn);
