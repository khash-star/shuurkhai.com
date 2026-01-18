<?php
ob_start();
@date_default_timezone_set("Asia/Ulaanbaatar");


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
$g_title="Шуурхай админ";
$g_icon="assets/images/favicon.png";

define ("USA_OFFICE_name","www.SHuurkhai.com");
define ("USA_OFFICE_id","0");
define ("USA_OFFICE_tel","773-621-6807");
define ("USA_OFFICE_address","1888 S Elmhurst rd, Mount prospect, IL, 60056");
define ("MNG_OFFICE_address","БЗД 14-р хороо, 13-р хороолол");
define ("USA_OFFICE_zip","60026");
?>
