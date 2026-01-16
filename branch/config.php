<?

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$dbuser = 'shuurkhai';
$dbpass = 'ppZl6H8{wGUA';
$dbname = 'shuurkhai';


$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
mysqli_set_charset($conn,'utf8');
mysqli_select_db($conn,$dbname);// (($dbname,$conn);

//GLOBAL VARIABLES
$g_title="Shuurkhai-Branches";
$g_author="MaGnatE @ MindSymbol";
$g_icon = "assets/images/favicon.png";
?>