<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (isset($_SESSION['logged_agent']) && isset($_SESSION['logged_agent_id']))
{
    $g_agent_logged = $_SESSION['logged_agent'];
    $g_agent_logged_id = $_SESSION['logged_agent_id'];
    $g_agent_logged_name = $_SESSION['logged_agent_name'];
    $g_agent_logged_avatar = $_SESSION['logged_agent_avatar'];
    $g_agent_logged_timestamp = $_SESSION['logged_agent_timestamp'];    
}
else {
    header('Location: login');
    exit;
}
?>