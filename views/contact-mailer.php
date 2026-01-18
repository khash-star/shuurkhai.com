<?php 
require_once(__DIR__ . "/../config.php");
require_once(__DIR__ . "/helper.php");

// Start session and check if user is logged in
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$is_logged_in = isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0;

if (!$is_logged_in) {
    $warning_msg = '<div class="alert-warning" style="padding:15px; margin-bottom:20px; border:1px solid #ffc107; background-color:#fff3cd; color:#856404; border-radius:5px;">' .
                   '<strong>Анхааруулга:</strong> Та нэвтэрсэний дараа зурвас илгээнэ үү. Нэвтрэх хуудас руу шилжүүлж байна...' .
                   '</div>';
    echo $warning_msg;
    exit;
}

if ($_POST && isset($conn) && $conn) {
    $name = mysqli_real_escape_string($conn, protect($_POST["name"] ?? ''));
    $tel = mysqli_real_escape_string($conn, protect($_POST["tel"] ?? ''));
    $email = mysqli_real_escape_string($conn, protect($_POST["email"] ?? ''));
    $subject = mysqli_real_escape_string($conn, protect($_POST["subject"] ?? ''));
    $content = mysqli_real_escape_string($conn, protect($_POST["content"] ?? ''));
    
    if (!empty($name) && !empty($tel) && !empty($email) && !empty($subject) && !empty($content)) {
        // Check if role and archive columns exist
        $check_role_sql = "SHOW COLUMNS FROM feedback LIKE 'role'";
        $role_exists = false;
        $check_result = mysqli_query($conn, $check_role_sql);
        if ($check_result && mysqli_num_rows($check_result) > 0) {
            $role_exists = true;
        }
        
        $check_archive_sql = "SHOW COLUMNS FROM feedback LIKE 'archive'";
        $archive_exists = false;
        $check_archive_result = mysqli_query($conn, $check_archive_sql);
        if ($check_archive_result && mysqli_num_rows($check_archive_result) > 0) {
            $archive_exists = true;
        }
        
        // Build INSERT query with optional columns
        if ($role_exists && $archive_exists) {
            $sql = "INSERT INTO feedback (name, contact, email, title, content, role, archive, `read`, timestamp) VALUES ('$name', '$tel', '$email', '$subject', '$content', 'user', 0, 0, NOW())";
        } elseif ($role_exists) {
            $sql = "INSERT INTO feedback (name, contact, email, title, content, role, timestamp) VALUES ('$name', '$tel', '$email', '$subject', '$content', 'user', NOW())";
        } elseif ($archive_exists) {
            $sql = "INSERT INTO feedback (name, contact, email, title, content, archive, `read`, timestamp) VALUES ('$name', '$tel', '$email', '$subject', '$content', 0, 0, NOW())";
        } else {
            $sql = "INSERT INTO feedback (name, contact, email, title, content, timestamp) VALUES ('$name', '$tel', '$email', '$subject', '$content', NOW())";
        }
        
        if (mysqli_query($conn, $sql)) {
            echo "Амжилттай илгээгдлээ. Баярлала.";
        } else {
            echo "Алдаа гарлаа. Дахин оролдоно уу.";
        }
    } else {
        echo "Бүх талбарыг бөглөнө үү.";
    }
} else {
    echo "Алдаа гарлаа. Дахин оролдоно уу.";
}
?>