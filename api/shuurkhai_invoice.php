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
            if (isset($_GET["select"])) $select = $_GET["select"]; else $select="list";

            if ($select =="list")
            {
                $sql = "SELECT * FROM envoice WHERE customer_id=".$user_id." ORDER BY created_date DESC LIMIT 30";
    
                $result= mysqli_query($conn,$sql);
    
                $i=mysqli_num_rows($result);
    
                $count=0;
                $sum_weight=0;
                $invoices = array();
    
    
                while ($data = mysqli_fetch_array($result))
                {
                    $invoice = array();
                    
                    $invoice_id =$data["envoice_id"];
                    $invoice_no ="№".sprintf("%05d", $data["envoice_id"]);
                    $created_date=$data["created_date"];

                    $orders_string=$data["orders"];
                                
                    $count=0;
                    $sum_weight=0;
                    $orders = array();

                    if ($orders_string<>"")
                    {
                        $sql = "SELECT * FROM orders WHERE order_id IN ($orders_string) AND status NOT IN('delivered','completed','custom') ORDER BY order_id DESC";    
                        // echo $sql;
                        $result_detail= mysqli_query($conn,$sql);
            

            
                        if (mysqli_num_rows($result_detail)>0)
                        {
                            while ($order_detail = mysqli_fetch_array($result_detail))
                            {
                                $order = array();
                                $order_id=$order_detail["order_id"];
                                $weight=$order_detail["weight"];
                                $price=$order_detail["price"];
                                
                                
                                
                                $barcode=$order_detail["barcode"];
                                $package=$order_detail["package"];
                                $price=$order_detail["price"];
                                
                
                                $advance=$order_detail["advance"];
                                $advance_value=$order_detail["advance_value"];
                                $third_party=$order_detail["third_party"];
                                                    
                                $extra=$order_detail["extra"];
                                $transport=$order_detail["transport"];
                                $status=$order_detail["status"];
        
                                $proxy_id=$order_detail["proxy_id"];
                                $proxy_type=$order_detail["proxy_type"];
                                
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
        
                                $order["barcode"] = $barcode;
                                $order["track_no"] = $third_party;
                
                                $order["advance"] = $advance;
                                $order["advance_value"] = $advance_value;
                                $order["extra"] = $extra;
                                $order["status"] = $status;
                
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
                
                                $count++;
                                array_push($orders,$order);
                                unset($order);
                            }
                            $i = mysqli_num_rows($result_detail);
                        }
                        else 
                        $i=0;
                    }
                    $invoice["orders"] = $orders;
                    $order["orders_count"] = $i;




                    $weight=$data["weight"];
                    $amount=$data["amount"];
                    $qpay_id=$data["qpay_id"];
                    $qpay_created=$data["qpay_created"];
                    $qpay_paid=$data["qpay_paid"]?true:false;
                    $status=$data["status"];
                    
                    
                    $invoice["invoice_id"] = intval($invoice_id);
                    $invoice["invoice_no"] = $invoice_no;
                    $invoice["created_date"] = $created_date;
                    $invoice["orders"] = $orders;
                    $invoice["weight"] = $weight;
                    $invoice["amount"] = $amount;
                    $invoice["qpay_id"] = $qpay_id;
                    $invoice["qpay_created"] = $qpay_created;
                    $invoice["qpay_paid"] = $qpay_paid;
                    $invoice["status"] = $status;
    
                    
                    array_push($invoices,$invoice);
                    unset($invoice);
                }
    
                $response["invoices"] = $invoices;
            
    
                $response['response'] = 200;
            }

            if ($select =="create")
            {
                // $sql = "SELECT * FROM orders WHERE receiver=".$user_id." AND status IN('warehouse','custom') ORDER BY order_id DESC";
                $sql = "SELECT * FROM orders WHERE  receiver='$user_id' AND status IN('warehouse','custom') ORDER BY order_id";
    
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
            
            if($select == "payment")
            {
                if (isset($_GET["invoice_id"]))
                {
                    $envoice_id = intval($_GET["invoice_id"]);
                    $sql = "SELECT *FROM envoice WHERE customer_id=".$user_id." AND envoice_id='$envoice_id' LIMIT 1";
                    $result = mysqli_query($conn,$sql);
                    if (mysqli_num_rows($result)==1)
                    {
                        $data = mysqli_fetch_array($result);
                        $orders = explode (",",$data["orders"]);
                        $amount= intval($data["amount"])+5000;
                        $created_date = $data["created_date"];
                        $envoice_status = $data["status"];
                        if ($envoice_status<>'paid')
                        {
                            $local_invoice_id = $envoice_id;
    
                            $host = "https://merchant-sandbox.qpay.mn"; //test
                            $host = "https://merchant.qpay.mn"; //production
                            
                            $url = $host."/v2/auth/token";
    
                            //test
                            $username = "TEST_MERCHANT";
                            $password = "123456";
    
                            //production
                            $username = "SHUURKHAI";
                            $password = "eBor20wN";
    
                            $ch = curl_init();
    
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_URL,$url);
                            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
                            curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                            $result = curl_exec($ch);
                            $result_decode = json_decode($result);
    
    
                            curl_close($ch);  
                            $access_token = $result_decode->access_token;
    
                            $url = $host."/v2/invoice";
                            $authorization = "Authorization: Bearer $access_token";
                            
                            $post_data['invoice_code'] = "TEST_INVOICE"; //TEST
                            $post_data['invoice_code'] = "SHUURKHAI_INVOICE"; //PRODUCTION
    
                            $post_data['sender_invoice_no'] = strval($local_invoice_id);
                            $post_data['invoice_receiver_code'] = "terminal";
                            $post_data['invoice_description'] = "Shuurkhai.com нэхэмжлэх дугаар:$local_invoice_id төлөх";
                            $post_data['amount'] = $amount;
                            $post_data['callback_url'] = "https://www.shuurkhai.com/qpay?user_id=$user_id&payment_id=".$local_invoice_id;
    
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_URL,$url);
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    
                            $result = curl_exec($ch);
                            $result_decode = json_decode($result);
                            curl_close($ch); 
                            
                            $response['response'] = 200;
                            $response['qpay'] = $result_decode;
                    
                        }
                        else 
                        {                            
                                $response['response'] = 303;
                                $response['error_msg'] ="Төлөгдсөн нэхэмжлэх байна";                                
                        }
                        
    
                    }
                    else 
                    {
                        $response['response'] = 404;
                        $response['error_msg'] ="Нэхэмжлэх олдсонгүй";    
                    }
                    
                }              
                else 
                {
                    $response['response'] = 403;
                    $response['error_msg'] ="Нэхэмжлэхийг дугаар өгөгдөөгүй байна";    
                }       
            }
        }                   
    else 
        {
            $response['response'] = 404;
            $response['error_msg'] = "Token not found";
        }
}

if($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'POST')
{

    $sql = "SELECT * FROM customer WHERE token='$token' LIMIT 1";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result)==1)
        {
            $data = mysqli_fetch_array($result);
            $user_id = $data["customer_id"];

            $orders = array();
            $orders_id = $input["orders_id"];
            foreach ($orders_id AS $item)
            {
                array_push($orders,$item["order_id"]);
            }
            $orders_string = implode(",",$orders);
            $sql = "SELECT * FROM envoice WHERE orders = '$orders_string'";
            $result = mysqli_query($conn,$sql);
            if (mysqli_num_rows($result)==0)
            {
            $sql = "INSERT INTO envoice (customer_id,orders) VALUES('$user_id','$orders_string')";
            if (mysqli_query($conn,$sql));
            $envoice_id = mysqli_insert_id($conn);
            }
            else 
            {
                $data = mysqli_fetch_array($result);
                $envoice_id=$data["envoice_id"];
            }
            
            if (count($orders))
            {	
                $total_weight=0;
                $total_weight_branch=0;
                $total_amount = 0;
                $count=1;
                for($i=0; $i < count($orders); $i++)
                {
                    $order_id=$orders[$i];
                    
                    
                    $sql = "SELECT * FROM orders WHERE receiver=".$user_id." AND order_id='".$order_id."'";
                    
                    $result = mysqli_query($conn,$sql);
                    
                    if (mysqli_num_rows($result) ==1)
                    {
                        $data = mysqli_fetch_array($result);
                        $weight=$data["weight"];
                        if ($data["is_branch"]) $total_weight_branch+=$weight;  else $total_weight+=$weight; 
                    }
                }

                
                $amount=cfg_price($total_weight)*settings("rate");
                $amount+=cfg_price_branch($total_weight_branch)*settings("rate");
                $total_weight+=$total_weight_branch;
                $sql = "UPDATE envoice SET weight='$total_weight',amount='$amount' WHERE envoice_id='$envoice_id'";
                
                if (mysqli_query($conn,$sql))
                {
                    $response['response'] = 200;
                }
                else 
                {
                    $response['response'] = 503;
                    $response['error_msg'] ="DB ERROR".mysqli_error($conn);    
                }       
            }       
            else 
            {
                $response['response'] = 404;
                $response['error_msg'] ="Захиалга сонгоогүй байна";    
            }                    
        } 
    else 
        {
            $response['response'] = 404;
            $response['error_msg'] = "Token not found";
        }
}


if($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
    $input= json_decode( file_get_contents( 'php://input' ), true );

    $response['response']=0;
    $response['error_msg'] ="";

    $sql = "SELECT customer_id FROM customer WHERE token = '$token' LIMIT 1";
    $result=mysqli_query($conn,$sql);

    if (mysqli_num_rows($result) == 1) 
        {
            $envoice_id= intval($input["invoice_id"]);                

            $data = mysqli_fetch_array($result);
            $user_id = $data["customer_id"];
        
            
            $sql = "SELECT *FROM envoice WHERE envoice_id='$envoice_id' AND customer_id='$user_id' LIMIT 1";
            $result = mysqli_query($conn,$sql);
            if (mysqli_num_rows($result)==1)
            {
                $data_order = mysqlI_fetch_array($result);
                
                $sql = "DELETE FROM envoice WHERE envoice_id='$envoice_id' AND customer_id='$user_id' LIMIT 1";
                if (mysqli_query($conn,$sql))
                {
                    $response["response"]=200;
                }
                else
                {
                    $response['response'] = 503;
                    $response['error_msg'] ="DB ERROR".mysqli_error($conn);

                }        
            }
            else 
            {
                $response['response']=404;
                $response['error_msg'] ="Нэхэмжлэх олдсонгүй";
            
            }  
        } 
    else 
        {
            $response['response'] = 404;
            $response['error_msg'] = "Token not found";
        }
}



if($_SERVER['REQUEST_METHOD'] != 'PUT' && $_SERVER['REQUEST_METHOD'] != 'POST' && $_SERVER['REQUEST_METHOD'] != 'GET' && $_SERVER['REQUEST_METHOD'] != 'DELETE')  
{
    $response['response'] = 600;
    $response['error_msg'] = "METHOD NOT ACCEPTABLE";        
}

mslog("shuurkhai_invoice",json_encode($input),json_encode($response),$_SERVER['REQUEST_METHOD']);

echo json_encode($response);
?>