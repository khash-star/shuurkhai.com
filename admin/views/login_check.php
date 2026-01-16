<?php
ob_start();
session_start();

if (!$_SESSION['logged'] || $_SESSION['name']=="" || $_SESSION['timestamp']=="")
header('Location: login');
?>
