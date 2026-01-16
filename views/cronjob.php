<?
$dbhost = 'localhost';

$dbuser = 'shuurkhai_2';
$dbpass = 'sw01b116';
$dbname = 'shuurkhai_2';

// $dbuser = 'root';
// $dbpass = 'sw01b116';
// $dbname = 'shuurkhai';


function settings($id_or_shortname)
	{
		global $conn;
			$sql = "SELECT *FROM settings WHERE shortname='$id_or_shortname' LIMIT 1";

		$result = mysqli_query($conn,$sql);
		
		if (mysqli_num_rows($result)==1)
			{
				$data = mysqli_fetch_array($result);
				return $data["value"];
			}
			else
				return "";
    }
    

$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
mysqli_set_charset($conn,'utf8');
mysqli_select_db($conn,$dbname);// (($dbname,$conn);



$clear_weight_missing_day = settings("clear_weight_missing_day");
if ($clear_weight_missing_day <10) $clear_weight_missing_day=10;

$now = date("Y-m-d H:i:s");
$sql = "UPDATE settings SET value='$now' WHERE shortname='cronjob_executed'";
mysqli_query($conn,$sql);

$sql = "UPDATE settings SET value=value+1 WHERE shortname='cronjob_count'";
mysqli_query($conn,$sql);


$days_before = date("Y-m-d",strtotime('-'.$clear_weight_missing_day.' days'));

//echo $days_before;
$sql = "SELECT *FROM orders WHERE status='weight_missing' AND created_date<='$days_before'";
 //echo $sql;
$result= mysqli_query($conn,$sql);
 while ($data= mysqli_fetch_array($result))
 {
    $order_id = $data["order_id"];
    $created_date = $data["created_date"];
    $barcode = $data["barcode"];
    $package = mysqli_escape_string($conn,$data["package"]);
    $weight = $data["weight"];
    $price = $data["price"];
    $sender = $data["sender"];
    $receiver = $data["receiver"];
    $deliver = $data["deliver"];
    $proxy_id = $data["proxy_id"];
    $proxy_type = $data["proxy_type"];
    $admin_value = $data["admin_value"];
    $third_party = $data["third_party"];
    $extra = $data["extra"];
    $transport = $data["transport"];
    $status = $data["status"];
    $agents = $data["agents"];
    $owner = $data["owner"];
    $is_online = $data["is_online"];
    $sql = "INSERT INTO orders_weight_missing (order_id,created_date,barcode,package,weight,price,sender,receiver,deliver,proxy_id,proxy_type,admin_value,third_party,extra,transport,status,agents,owner,is_online)
    VALUES ('$order_id','$created_date','$barcode','$package','$weight','$price','$sender','$receiver','$deliver','$proxy_id','$proxy_type','$admin_value','$third_party','$extra','$transport','$status','$agents','$owner','$is_online')";
    if (mysqli_query($conn,$sql)) mysqli_query($conn,"DELETE FROM orders WHERE order_id='$order_id'");
 }


?>