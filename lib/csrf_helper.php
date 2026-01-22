<?php
/**
 * CSRF Protection Helper
 * Forms дээр CSRF token нэмэхэд тусална
 */

// Security functions-ийг ачаалах
if (file_exists(__DIR__ . '/security.php')) {
    require_once(__DIR__ . '/security.php');
}

if (!function_exists('csrf_field')) {
    /**
     * CSRF token hidden field үүсгэх
     * Form дээр энэ функцийг дуудаж ашиглах
     */
    function csrf_field() {
        if (function_exists('generate_csrf_token')) {
            $token = generate_csrf_token();
        } else {
            // Fallback if security.php not loaded
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (!isset($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
            $token = $_SESSION['csrf_token'];
        }
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
    }
}

if (!function_exists('csrf_token')) {
    /**
     * CSRF token утгыг буцаах (AJAX requests-д ашиглах)
     */
    function csrf_token() {
        if (function_exists('generate_csrf_token')) {
            return generate_csrf_token();
        } else {
            // Fallback
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (!isset($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
            return $_SESSION['csrf_token'];
        }
    }
}

if (!function_exists('verify_csrf_post')) {
    /**
     * POST request-д CSRF token шалгах
     * Form submit хийхэд энэ функцийг дуудаж ашиглах
     */
    function verify_csrf_post() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return true; // GET requests-д CSRF шалгалт хийхгүй
        }
        
        $token = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
        
        if (function_exists('verify_csrf_token')) {
            return verify_csrf_token($token);
        } else {
            // Fallback
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
        }
    }
}
