<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'shuurkhai';


$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn,'utf8');
mysqli_select_db($conn,$dbname);// (($dbname,$conn);

//GLOBAL VARIABLES
$g_title="Shuurkhai-Branches";
$g_author="MaGnatE @ MindSymbol";
$g_icon = "assets/images/favicon.png";
?>