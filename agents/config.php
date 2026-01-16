<?php
$dbhost = 'localhost';


$dbuser = 'shuurkhai';
$dbpass = 'ppZl6H8{wGUA';
$dbname = 'shuurkhai';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
mysqli_set_charset($conn, 'utf8mb4');
mysqli_select_db($conn, $dbname); // (($dbname,$conn);

//GLOBAL VARIABLES
$g_title = "Агент";
$g_icon = "assets/img/favicon.png";
$g_description = "Шуурхай агент";
$g_keywords = "Шуурхай агент shuurkhai.com shuurkhai cargo agent";

define ("USA_OFFICE_name","www.SHuurkhai.com");
define ("USA_OFFICE_id","0");
define ("USA_OFFICE_tel","773-621-6807");
define ("USA_OFFICE_address","1888 S Elmhurst rd, Mount prospect, IL, 60056");
define ("MNG_OFFICE_address","БЗД 14-р хороо, 13-р хороолол");
define ("USA_OFFICE_zip","60026");
define ('FB_meta','<meta property="og:image" content="https://www.shuurkhai.com/assets/images/fb_meta.jpg"/>');

?>