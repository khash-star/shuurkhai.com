<?php
$dbhost = 'localhost';

$dbuser = 'shuurkhai';
$dbpass = 'ppZl6H8{wGUA';
$dbname = 'shuurkhai';



$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
mysqli_set_charset($conn,'utf8');
mysqli_select_db($conn,$dbname);// (($dbname,$conn);

//GLOBAL VARIABLES
$g_title="Шуурхай Америк Карго";
$g_favicon="assets/images/favicon.png";
$g_author="MaGnatE @ Mindsymbol";
$g_description="Welcome to Shuurkhai.com, your premier choice for fast and reliable cargo shipping solutions. We are dedicated to providing top-notch services that ensure your goods reach their destination safely from United States and on time.";
$g_keywords="Shuurkhai, Cargo, delivery, online track, from US, deliver in Mongolia, shuurkhai.com, website, shipping, track";

?>