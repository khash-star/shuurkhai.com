<?php
	ob_start();
	session_start();

	unset($_SESSION['logged_agent']);	
	unset($_SESSION['logged_agent_id']);
	unset($_SESSION['logged_agent_name']);
	unset($_SESSION['logged_agent_avatar']);
	unset($_SESSION['logged_agent_timestamp']);

	header('Location: login');
?>