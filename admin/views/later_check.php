<? 

ob_start();
session_start();
require_once("../config.php"); 
require_once("helper.php");
$final_balance = 0;
if (isset($_POST["tel"])) $tel=$_POST["tel"];
$result = mysqli_query($conn,"SELECT * FROM customer WHERE tel='".$tel."' LIMIT 1");
if (mysqli_num_rows($result) == 1)
{
	$row_customer = mysqli_fetch_array($result);
	$customer_id = $row_customer["customer_id"];
	$query_later= mysqli_query($conn,"SELECT * FROM later_payment WHERE d_customer='".$customer_id."' ORDER BY id DESC LIMIT 1");
	if (mysqli_num_rows($query_later) == 1)
		{
		$row_later = mysqli_fetch_array($query_later);
		$final_balance =$row_later["final_balance"];
		}
    if (mysqli_num_rows($query_later) == 0)
		{
			$query_orders= mysqli_query($conn, "SELECT * FROM orders WHERE deliver=$customer_id AND (status='delivered' OR status='custom') AND method ='later'");
			$final_balance =0;$weight=0;$admin=0;$admin_value=0;$advance_value=0;$advance=0;$weight_noooo=0;
			while ($row_orders = mysqli_fetch_array($query_orders))
				{  
				if ($row_orders["is_online"] == 0)
					{
					$advance+=$row_orders["advance_value"];
					$weight_noooo +=floatval($row_orders["weight"]);
					}
				if ($row_orders["is_online"] == 1)
					{
					$admin+=floatval($row_orders["admin_value"]);
					$weight+=floatval($row_orders["weight"]);
					}
					$final_balance += $advance+$admin+cfg_price($weight);
				}
		}
}
echo $final_balance;
?>