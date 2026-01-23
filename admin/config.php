<?php
ob_start();
@date_default_timezone_set("Asia/Ulaanbaatar");

// Include root config.php for database connection
// This ensures we use the same database configuration with environment variable support
require_once(__DIR__ . "/../config.php");

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
