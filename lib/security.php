<?php
/**
 * Security Functions
 * Production-ready security utilities
 */

if (!function_exists('generate_csrf_token')) {
    /**
     * CSRF token үүсгэх
     */
    function generate_csrf_token() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('verify_csrf_token')) {
    /**
     * CSRF token шалгах
     */
    function verify_csrf_token($token) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}

if (!function_exists('sanitize_input')) {
    /**
     * Input sanitization (хуучин protect() функцийн сайжруулсан хувилбар)
     */
    function sanitize_input($input, $type = 'string') {
        if (is_array($input)) {
            return array_map(function($item) use ($type) {
                return sanitize_input($item, $type);
            }, $input);
        }
        
        // HTML tags устгах
        $input = strip_tags($input);
        
        // Type-аас хамаарч sanitize хийх
        switch ($type) {
            case 'email':
                $input = filter_var($input, FILTER_SANITIZE_EMAIL);
                break;
            case 'int':
                $input = filter_var($input, FILTER_SANITIZE_NUMBER_INT);
                break;
            case 'float':
                $input = filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                break;
            case 'url':
                $input = filter_var($input, FILTER_SANITIZE_URL);
                break;
            default:
                // FILTER_SANITIZE_STRING is deprecated in PHP 8.1+, use htmlspecialchars instead
                $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        }
        
        return trim($input);
    }
}

if (!function_exists('validate_input')) {
    /**
     * Input validation
     */
    function validate_input($input, $type, $required = true) {
        if ($required && empty($input)) {
            return false;
        }
        
        if (empty($input) && !$required) {
            return true;
        }
        
        switch ($type) {
            case 'email':
                return filter_var($input, FILTER_VALIDATE_EMAIL) !== false;
            case 'int':
                return filter_var($input, FILTER_VALIDATE_INT) !== false;
            case 'float':
                return filter_var($input, FILTER_VALIDATE_FLOAT) !== false;
            case 'url':
                return filter_var($input, FILTER_VALIDATE_URL) !== false;
            case 'phone':
                // Монгол утасны дугаар шалгах
                return preg_match('/^[0-9]{8,10}$/', $input);
            case 'track':
                // Track code шалгах
                return preg_match('/^[A-Z0-9]{6,20}$/', strtoupper($input));
            default:
                return !empty($input);
        }
    }
}

if (!function_exists('hash_password')) {
    /**
     * Password hash хийх (password_hash wrapper)
     */
    function hash_password($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
}

if (!function_exists('verify_password')) {
    /**
     * Password verify хийх
     */
    function verify_password($password, $hash) {
        return password_verify($password, $hash);
    }
}

if (!function_exists('secure_redirect')) {
    /**
     * Secure redirect (XSS-ээс хамгаалах)
     */
    function secure_redirect($url, $status_code = 302) {
        // URL-ийг validate хийх
        $url = filter_var($url, FILTER_SANITIZE_URL);
        
        // Зөвхөн дотоод URL-ууд руу redirect хийх
        if (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0) {
            // External URL - зөвхөн whitelist-д байгаа домэйн рүү л зөвшөөрөх
            $allowed_domains = ['shuurkhai.com', 'www.shuurkhai.com'];
            $parsed = parse_url($url);
            if (!in_array($parsed['host'] ?? '', $allowed_domains)) {
                $url = '/'; // Default хуудас руу redirect
            }
        }
        
        header("Location: " . $url, true, $status_code);
        exit;
    }
}

if (!function_exists('rate_limit_check')) {
    /**
     * Rate limiting (brute force attack-ээс хамгаалах)
     */
    function rate_limit_check($key, $max_attempts = 5, $time_window = 300) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $rate_limit_key = 'rate_limit_' . $key;
        $now = time();
        
        if (!isset($_SESSION[$rate_limit_key])) {
            $_SESSION[$rate_limit_key] = [
                'attempts' => 0,
                'reset_time' => $now + $time_window
            ];
        }
        
        $rate_limit = $_SESSION[$rate_limit_key];
        
        // Reset time хэтэрсэн бол дахин эхлүүлэх
        if ($now > $rate_limit['reset_time']) {
            $_SESSION[$rate_limit_key] = [
                'attempts' => 0,
                'reset_time' => $now + $time_window
            ];
            return true;
        }
        
        // Attempts хэтэрсэн бол хорих
        if ($rate_limit['attempts'] >= $max_attempts) {
            return false;
        }
        
        // Attempt нэмэх
        $_SESSION[$rate_limit_key]['attempts']++;
        return true;
    }
}
