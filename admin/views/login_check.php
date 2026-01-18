<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$is_logged_in = isset($_SESSION['logged']) && $_SESSION['logged'] === true;
$has_name = isset($_SESSION['name']) && $_SESSION['name'] !== "";
$has_timestamp = isset($_SESSION['timestamp']) && $_SESSION['timestamp'] !== "";

if (!$is_logged_in || !$has_name || !$has_timestamp) {
    // Prevent redirect loop - check if we're already on login page
    $current_page = basename($_SERVER['PHP_SELF']);
    if ($current_page !== 'login.php') {
        header('Location: login');
        exit;
    }
}
?>
