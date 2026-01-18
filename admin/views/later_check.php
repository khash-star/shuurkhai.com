<?php 

ob_start();
session_start();
require_once("../config.php"); 
require_once("helper.php");
$final_balance = 0;
if (isset($_POST["tel"])) {
    $tel = protect($_POST["tel"]);
    $tel_escaped = mysqli_real_escape_string($conn, $tel);
    $result = mysqli_query($conn,"SELECT * FROM customer WHERE tel='$tel_escaped' LIMIT 1");
    if ($result && mysqli_num_rows($result) == 1)
    {
        $row_customer = mysqli_fetch_array($result);
        if ($row_customer && isset($row_customer["customer_id"])) {
            $customer_id = intval($row_customer["customer_id"]);
            $query_later= mysqli_query($conn,"SELECT * FROM later_payment WHERE d_customer='$customer_id' ORDER BY id DESC LIMIT 1");
            if ($query_later && mysqli_num_rows($query_later) == 1)
            {
                $row_later = mysqli_fetch_array($query_later);
                if ($row_later && isset($row_later["final_balance"])) {
                    $final_balance = floatval($row_later["final_balance"]);
                }
            }
            if ($query_later && mysqli_num_rows($query_later) == 0)
            {
                $query_orders= mysqli_query($conn, "SELECT * FROM orders WHERE deliver=$customer_id AND (status='delivered' OR status='custom') AND method ='later'");
                if ($query_orders) {
                    $final_balance =0;$weight=0;$admin=0;$admin_value=0;$advance_value=0;$advance=0;$weight_noooo=0;
                    while ($row_orders = mysqli_fetch_array($query_orders))
                    {  
                        if ($row_orders && isset($row_orders["is_online"]) && $row_orders["is_online"] == 0)
                        {
                            $advance+=floatval($row_orders["advance_value"] ?? 0);
                            $weight_noooo +=floatval($row_orders["weight"] ?? 0);
                        }
                        if ($row_orders && isset($row_orders["is_online"]) && $row_orders["is_online"] == 1)
                        {
                            $admin+=floatval($row_orders["admin_value"] ?? 0);
                            $weight+=floatval($row_orders["weight"] ?? 0);
                        }
                        $final_balance += $advance+$admin+cfg_price($weight);
                    }
                }
            }
        }
    }
}
echo number_format($final_balance, 2);
?>