<?php
ob_start();
@date_default_timezone_set("Asia/Ulaanbaatar");
$dbhost = 'localhost';

$dbuser = 'shuurkhai';
$dbpass = 'ppZl6H8{wGUA';
$dbname = 'shuurkhai';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
mysqli_set_charset($conn,'utf8mb4');
mysqli_select_db($conn,$dbname);// (($dbname,$conn);
?>