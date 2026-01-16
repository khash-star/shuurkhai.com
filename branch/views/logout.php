<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    
    unset($_SESSION['branch_logged_id']);
    unset($_SESSION['branch_logged_name']);
    unset($_SESSION['branch_logged_avatar']);
    unset($_SESSION['branch_logged_tel']);
    unset($_SESSION['branch_logged_email']);
    unset($_SESSION['branch_logged']);
   
    header('Location: login');

?>