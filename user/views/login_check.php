<?php
ob_start();
session_start();

if (!(isset($_SESSION['c_logged']) && isset($_SESSION['c_name']) && isset($_SESSION['c_user_id']) || isset($_SESSION['c_timestamp'])))
header('Location: login');
?>
