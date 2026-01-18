<?php
ob_start();
@date_default_timezone_set("Asia/Ulaanbaatar");


$dbhost = 'localhost';

$dbuser = 'root';
$dbpass = '';
$dbname = 'shuurkhai';


$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
mysqli_set_charset($conn,'utf8');
mysqli_select_db($conn,$dbname);// (($dbname,$conn);

//GLOBAL VARIABLES
$g_title="Шуурхай хэрэглэгч";
$g_icon="assets/images/favicon.png";

?>
