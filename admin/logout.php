<?php
	ob_start();
	session_start();
	unset($_SESSION['username']);	
	unset($_SESSION['timestamp']);
	unset($_SESSION['rights']);
	unset($_SESSION['avatar']);
	unset($_SESSION['logged']);
	header('Location: login');
?>