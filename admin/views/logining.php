<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start();
session_start();

// ✅ 1) POST биш бол шууд буцаа (хамгийн дээр)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /shuurkhai/admin/login.php");
    exit;
}

// ✅ config/helper шалгалт
require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/helper.php";

// remember me cookie
if (isset($_POST["login_remember"])) {
    setcookie("login_remember", $_POST["username"] ?? "", time() + (10 * 365 * 24 * 60 * 60), '/');
} else {
    setcookie("login_remember", "", time() - 3600, '/');
}

// ✅ empty check
if (!isset($_POST["username"], $_POST["password"])) {
    header("Location: /shuurkhai/admin/login.php?error=empty");
    exit;
}

$username = protect($_POST["username"]);
$password = protect($_POST["password"]);

if ($username == settings(1) && $password == settings(2)) {
    $_SESSION['name'] = "Админ";
    $_SESSION['avatar'] = settings(11);
    $_SESSION['rights'] = "admin";
    $_SESSION['timestamp'] = date("Y-m-d H:i:s");
    $_SESSION['logged'] = true;

    // ✅ амжилттай login → dashboard
    header("Location: /shuurkhai/admin/dashboard.php");
    exit;
}

// ❌ буруу нууц үг
header("Location: /shuurkhai/admin/login.php?error=wrong");
exit;
