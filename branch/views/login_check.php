<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    //$token = getBearerToken();
    if (!isset($_SESSION['branch_logged']))
    {
        header('Location: login');
    }
    else 
    {
        $g_logged_id = $_SESSION['branch_logged_id'];
        $g_logged_avatar = $_SESSION['branch_logged_avatar'];
        $g_logged_name = $_SESSION['branch_logged_name'];
        $g_logged_tel = $_SESSION['branch_logged_tel'];
        $g_logged_email = $_SESSION['branch_logged_email'];
        $g_logged = $_SESSION['branch_logged'];
    }
?>
