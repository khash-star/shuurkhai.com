<?php
// Database configuration - Copy this file to config.php and update with your database credentials
$dbhost = 'localhost';
$dbuser = 'your_database_user';
$dbpass = 'your_database_password';
$dbname = 'shuurkhai';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn,'utf8');
mysqli_select_db($conn,$dbname);

//GLOBAL VARIABLES
$g_title="Шуурхай Америк Карго";
$g_favicon="assets/images/favicon.png";
$g_author="MaGnatE @ Mindsymbol";
$g_description="Welcome to Shuurkhai.com, your premier choice for fast and reliable cargo shipping solutions. We are dedicated to providing top-notch services that ensure your goods reach their destination safely from United States and on time.";
$g_keywords="Shuurkhai, Cargo, delivery, online track, from US, deliver in Mongolia, shuurkhai.com, website, shipping, track";

?>

