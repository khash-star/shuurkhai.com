<?php
header('Content-Type: application/json');
require_once 'config.php';
require_once 'helper.php';


$response = array();
$response['response'] = 0;
$response['error_msg'] = "";

$token=getBearerToken();
if ($token=="") $token="+";

$input= json_decode( file_get_contents( 'php://input' ), true );


if($_SERVER['REQUEST_METHOD'] == 'GET')
{

    $response['response']=0;
    $response['error_msg'] ="";


    $sql = "SELECT * FROM customer WHERE token='$token' LIMIT 1";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result)==1)
        {
            $data = mysqli_fetch_array($result);
            $user_id = $data["customer_id"];
            if (isset($_GET["select"])) $select = $_GET["select"]; else $select="";

            if ($select =="")
            {
                $sql = "SELECT * FROM orders WHERE receiver=".$user_id." AND status NOT IN('delivered','completed','custom','weight_missing','received') ORDER BY order_id DESC";
    
                $result= mysqli_query($conn,$sql);
    
                $i=mysqli_num_rows($result);
    
                $count=0;
                $sum_weight=0;
                $orders = array();
    
    
                while ($data = mysqli_fetch_array($result))
                {
                    $order = array();
                    $order_id=$data["order_id"];
                    $weight=$data["weight"];
                    $price=$data["price"];
                    
                    
                    $created_date=$data["created_date"];
                    $onair_date=$data["onair_date"];
                    $warehouse_date=$data["warehouse_date"];
                    $delivered_date=$data["delivered_date"];
                    
                    
                    $barcode=$data["barcode"];
                    $package=$data["package"];
                    $price=$data["price"];
                    
                    $sender=$data["sender"];
                    $receiver=$data["receiver"];
                    $deliver=$data["deliver"];
                    
    
                    $advance=$data["advance"];
                    $advance_value=$data["advance_value"];
                    $third_party=$data["third_party"];
                                        
                    $extra=$data["extra"];
                    $timestamp=$data["timestamp"];
                    $transport=$data["transport"];
                    $status=$data["status"];
                    $agents=$data["agents"];
                    $is_online=$data["is_online"];
                    $proxy_id=$data["proxy_id"];
                    $proxy_type=$data["proxy_type"];
                    
                    if ($status=="warehouse" && $extra=='999') $status="handover";
    
                    $package_array=explode("##",$package);
    
                    if (count($package_array)>11)
                    {
                    $package1_name = $package_array[0];
                    $package1_num = $package_array[1];
                    $package1_price = $package_array[2];
                    $package2_name = $package_array[3];
                    $package2_num = $package_array[4];
                    $package2_price = $package_array[5];
                    $package3_name = $package_array[6];
                    $package3_num = $package_array[7];
                    $package3_price = $package_array[8];
                    $package4_name = $package_array[9];
                    $package4_num = $package_array[10];
                    $package4_price = $package_array[11];
                    }
    
                    $order["order_id"] = intval($order_id);
                    $order["weight"] = $weight;
                    $order["price"] = $price;
                    $order["created_date"] = $created_date;
                    $order["onair_date"] = $onair_date;
                    $order["warehouse_date"] = $warehouse_date;
                    $order["delivered_date"] = $delivered_date;
                    $order["barcode"] = $barcode;
                    $order["track_no"] = $third_party;
    
                    $order["advance"] = $advance;
                    $order["advance_value"] = $advance_value;
                    $order["extra"] = $extra;
                    $order["status"] = $status;
                    $order["is_online"] = $is_online;
    
                    $packages = array();


                    if ($package1_name<>"")
                    {
                        $package_single = array();
                        $package_single["package1_name"]=$package1_name; $package_single["package1_num"]=$package1_num; $package_single["package1_price"]=$package1_price;
                        array_push($packages,$package_single);
                        unset($package_single);
                    } 

                    if ($package2_name<>"")
                    {
                        $package_single = array();
                        $package_single["package2_name"]=$package2_name; $package_single["package2_num"]=$package2_num; $package_single["package2_price"]=$package2_price;
                        array_push($packages,$package_single);
                        unset($package_single);
                    }

                    if ($package3_name<>"")
                    {
                        $package_single = array();
                        $package_single["package3_name"]=$package3_name; $package_single["package3_num"]=$package3_num; $package_single["package3_price"]=$package3_price;
                        array_push($packages,$package_single);
                        unset($package_single);
                    }
                    if ($package4_name<>"")
                    {
                        $package_single = array();
                        $package_single["package4_name"]=$package4_name; $package_single["package4_num"]=$package4_num; $package_single["package4_price"]=$package4_price;
                        array_push($packages,$package_single);
                        unset($package_single);
                    }
    
                    $order["packages"] = $packages;
                    if ($proxy_id>0) $order["is_proxy"]=true; else $order["is_proxy"]=false;
                    $order["proxy_id"] = $proxy_id;
                    $order["proxy_name"] = proxy($proxy_id,"name");
    
                    $sum_weight+=floatval($weight);
    
                    $count++;
                    array_push($orders,$order);
                    unset($order);
                }
    
                $response["orders"] = $orders;
            
                $response["sum_weight"] = $sum_weight;
                $response["sum_count"] = $count;
    
                $response['response'] = 200;
            }

            if ($select =="container")
            {
                $sql = "SELECT container_item.*,container.name container_name FROM container_item 
                    LEFT JOIN container ON container_item.container=container.container_id
                    WHERE receiver=".$user_id." AND container_item.status NOT IN('delivered','completed','custom') ORDER BY container_item.id DESC";
    
                $result= mysqli_query($conn,$sql);
    
                $i=mysqli_num_rows($result);
    
                $count=0;
                $sum_weight=0;
                $orders = array();
    
    
                while ($data = mysqli_fetch_array($result))
                {
                    $order = array();
                    $id=$data["id"];
                    $weight=$data["weight"];
                    $price=$data["price"];
                    
                    
                    $created_date=$data["created_date"];
                    $price_date=$data["price_date"];
                    $onway_date=$data["onway_date"];
                    $warehouse_date=$data["warehouse_date"];
                    $delivered_date=$data["delivered_date"];
                    
                    
                    $barcode=$data["barcode"];
                    $package=$data["package"];
                    $price=$data["price"];
                    
                    $sender=$data["sender"];
                    $receiver=$data["receiver"];
                    $deliver=$data["deliver"];
                    
    
                    $third_party=$data["track"];
                                        
                    $transport=$data["transport"];
                    $status=$data["status"];
                    $is_online=$data["is_online"];
                    
                    if ($status=="warehouse" && $extra=='999') $status="handover";
    
                    $package_array=explode("##",$package);
    
                    if (count($package_array)>11)
                    {
                    $package1_name = $package_array[0];
                    $package1_num = $package_array[1];
                    $package1_price = $package_array[2];
                    $package2_name = $package_array[3];
                    $package2_num = $package_array[4];
                    $package2_price = $package_array[5];
                    $package3_name = $package_array[6];
                    $package3_num = $package_array[7];
                    $package3_price = $package_array[8];
                    $package4_name = $package_array[9];
                    $package4_num = $package_array[10];
                    $package4_price = $package_array[11];
                    }
    
                    $order["id"] = intval($id);
                    $order["weight"] = $weight;
                    $order["price"] = $price;
                    $order["created_date"] = $created_date;
                    $order["price_date"] = $price_date;
                    $order["onway_date"] = $onway_date;
                    $order["warehouse_date"] = $warehouse_date;
                    $order["delivered_date"] = $delivered_date;
                    $order["barcode"] = $barcode;
                    $order["track_no"] = $third_party;
                    $order["status"] = $status;
                    $order["is_online"] = $is_online;
    
                    $packages = array();
                        if ($package1_name<>"")
                        {
                            $package_single = array();
                            $package_single["package1_name"]=$package1_name; $package_single["package1_num"]=$package1_num; $package_single["package1_price"]=$package1_price;
                            array_push($packages,$package_single);
                            unset($package_single);
                        } 

                        if ($package2_name<>"")
                        {
                            $package_single = array();
                            $package_single["package2_name"]=$package2_name; $package_single["package2_num"]=$package2_num; $package_single["package2_price"]=$package2_price;
                            array_push($packages,$package_single);
                            unset($package_single);
                        }

                        if ($package3_name<>"")
                        {
                            $package_single = array();
                            $package_single["package3_name"]=$package3_name; $package_single["package3_num"]=$package3_num; $package_single["package3_price"]=$package3_price;
                            array_push($packages,$package_single);
                            unset($package_single);
                        }
                        if ($package4_name<>"")
                        {
                            $package_single = array();
                            $package_single["package4_name"]=$package4_name; $package_single["package4_num"]=$package4_num; $package_single["package4_price"]=$package4_price;
                            array_push($packages,$package_single);
                            unset($package_single);
                        }
    
                    $order["packages"] = $packages;
    
                    $sum_weight+=floatval($weight);
    
                    $count++;
                    array_push($orders,$order);
                    unset($order);
                }
    
                $response["orders"] = $orders;
            
                $response["sum_weight"] = $sum_weight;
                $response["sum_count"] = $count;
    
                $response['response'] = 200;
            }

            if ($select =="history")
            {
                if (isset($_GET["page"])) $page = $_GET["page"]; else $page=0;

                $sql = "SELECT * FROM orders WHERE receiver=".$user_id." AND status NOT IN('delivered','custom') ORDER BY order_id DESC";
    
                $result= mysqli_query($conn,$sql);
    
                $i=mysqli_num_rows($result);
    
                $count=0;
                $sum_weight=0;
                $orders = array();
    
    
                while ($data = mysqli_fetch_array($result))
                {
                    $order = array();
                    $order_id=$data["order_id"];
                    $weight=$data["weight"];
                    $price=$data["price"];
                    
                    
                    $created_date=$data["created_date"];
                    $onair_date=$data["onair_date"];
                    $warehouse_date=$data["warehouse_date"];
                    $delivered_date=$data["delivered_date"];
                    
                    
                    $barcode=$data["barcode"];
                    $package=$data["package"];
                    $price=$data["price"];
                    
                    $sender=$data["sender"];
                    $receiver=$data["receiver"];
                    $deliver=$data["deliver"];
                    
    
                    $advance=$data["advance"];
                    $advance_value=$data["advance_value"];
                    $third_party=$data["third_party"];
                                        
                    $extra=$data["extra"];
                    $timestamp=$data["timestamp"];
                    $transport=$data["transport"];
                    $status=$data["status"];
                    $agents=$data["agents"];
                    $is_online=$data["is_online"];
                    $proxy_id=$data["proxy_id"];
                    $proxy_type=$data["proxy_type"];
                    
                    if ($status=="warehouse" && $extra=='999') $status="handover";
    
                    $package_array=explode("##",$package);
    
                    if (count($package_array)>11)
                    {
                    $package1_name = $package_array[0];
                    $package1_num = $package_array[1];
                    $package1_price = $package_array[2];
                    $package2_name = $package_array[3];
                    $package2_num = $package_array[4];
                    $package2_price = $package_array[5];
                    $package3_name = $package_array[6];
                    $package3_num = $package_array[7];
                    $package3_price = $package_array[8];
                    $package4_name = $package_array[9];
                    $package4_num = $package_array[10];
                    $package4_price = $package_array[11];
                    }
    
                    $order["order_id"] = intval($order_id);
                    $order["weight"] = $weight;
                    $order["price"] = $price;
                    $order["created_date"] = $created_date;
                    $order["onair_date"] = $onair_date;
                    $order["warehouse_date"] = $warehouse_date;
                    $order["delivered_date"] = $delivered_date;
                    $order["barcode"] = $barcode;
                    $order["track_no"] = $third_party;
    
                    $order["advance"] = $advance;
                    $order["advance_value"] = $advance_value;
                    $order["extra"] = $extra;
                    $order["status"] = $status;
                    $order["is_online"] = $is_online;
    
                    $packages = array();
                       
                    if ($package1_name<>"")
                    {
                        $package_single = array();
                        $package_single["package1_name"]=$package1_name; $package_single["package1_num"]=$package1_num; $package_single["package1_price"]=$package1_price;
                        array_push($packages,$package_single);
                        unset($package_single);
                    } 

                    if ($package2_name<>"")
                    {
                        $package_single = array();
                        $package_single["package2_name"]=$package2_name; $package_single["package2_num"]=$package2_num; $package_single["package2_price"]=$package2_price;
                        array_push($packages,$package_single);
                        unset($package_single);
                    }

                    if ($package3_name<>"")
                    {
                        $package_single = array();
                        $package_single["package3_name"]=$package3_name; $package_single["package3_num"]=$package3_num; $package_single["package3_price"]=$package3_price;
                        array_push($packages,$package_single);
                        unset($package_single);
                    }
                    if ($package4_name<>"")
                    {
                        $package_single = array();
                        $package_single["package4_name"]=$package4_name; $package_single["package4_num"]=$package4_num; $package_single["package4_price"]=$package4_price;
                        array_push($packages,$package_single);
                        unset($package_single);
                    }
                    
    
                    $order["packages"] = $packages;
                    if ($proxy_id>0) $order["is_proxy"]=true; else $order["is_proxy"]=false;
                    $order["proxy_id"] = $proxy_id;
                    $order["proxy_name"] = proxy($proxy_id,"name");
    
                    $sum_weight+=floatval($weight);
    
                    $count++;
                    array_push($orders,$order);
                    unset($order);
                }
    
                $response["orders"] = $orders;
            
                $response["sum_weight"] = $sum_weight;
                $response["sum_count"] = $count;
    
                $response['response'] = 200;
            }

        }                   
    else 
        {
            $response['response'] = 404;
            $response['error_msg'] = "Token not found";
        }
}

if($_SERVER['REQUEST_METHOD'] != 'GET')  
{
    $response['response'] = 600;
    $response['error_msg'] = "METHOD NOT ACCEPTABLE";        
}

mslog("orders",json_encode($input),json_encode($response),$_SERVER['REQUEST_METHOD']);


echo json_encode($response);
?>