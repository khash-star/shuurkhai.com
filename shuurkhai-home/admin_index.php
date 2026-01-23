<?php
/**
 * Admin directory index.php
 * This file should be placed in: ~/public_html/shuurkhai/admin/index.php
 * 
 * Redirects to the main admin page
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in as admin
$is_admin = false;
if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
    if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] == 0) {
        $is_admin = true;
    } elseif (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
        $is_admin = true;
    }
}

// Redirect based on admin status
if ($is_admin) {
    // Redirect to main admin page
    header('Location: /shuurkhai/admin/online?action=all');
} else {
    // Redirect to login page
    header('Location: /shuurkhai/login');
}
exit;
