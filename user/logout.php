<?php
	ob_start();
	session_start();
	unset($_SESSION['c_logged']);	
	unset($_SESSION['c_name']);
	unset($_SESSION['c_tel']);
	unset($_SESSION['c_user_id']);
	unset($_SESSION['c_timestamp']);
	unset($_SESSION['c_avatar']);
	header('Location: login');
?>