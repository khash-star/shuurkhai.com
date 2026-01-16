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


if($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'POST')
{

    $sql = "SELECT * FROM customer WHERE token='$token' LIMIT 1";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result)==1)
        {
            $data = mysqli_fetch_array($result);
            $user_id = $data["customer_id"];

            $track=$input["track_no"];
            $track = str_replace(" ","",$track);
            $track = str_replace("script","***",$track);
            $track = str_replace("php","***",$track);
            $track = str_replace("<?","***",$track);
            $track = string_clean($track);
            $track = trim($track);
            $track = strtoupper($track);


            $is_container = $input["is_container"];
            $is_proxy = $input["is_proxy"];
            $proxy_id = $input["proxy_id"];

           
            $package1_name=mysqli_escape_string($conn,$input["package"][0]["package1_name"]);
            $package1_num =$input["package"][0]["package1_num"];
            $package1_price =$input["package"][0]["package1_price"];
            $package2_name=mysqli_escape_string($conn,$input["package"][1]["package2_name"]);
            $package2_num =$input["package"][1]["package2_num"];
            $package2_price =$input["package"][1]["package2_price"];
            $package3_name=mysqli_escape_string($conn,$input["package"][2]["package3_name"]);
            $package3_num =$input["package"][2]["package3_num"];
            $package3_price =$input["package"][2]["package3_price"];
            $package4_name=mysqli_escape_string($conn,$input["package"][3]["package4_name"]);
            $package4_num =$input["package"][3]["package4_num"];
            $package4_price =$input["package"][3]["package4_price"];
            
            $package_array = array(
            $package1_name, $package1_num, $package1_price,
            $package2_name, $package2_num, $package2_price,
            $package3_name, $package3_num, $package3_price,
            $package4_name, $package4_num, $package4_price
            );
            
            $package =implode("##",$package_array);
            $package_price = $package1_price + $package2_price + $package3_price + $package4_price;

            if (!$is_container)
            {

                $sql = "SELECT * FROM customer WHERE customer_id ='$user_id'";
                $result = mysqli_query($conn,$sql);
                $data_customer = mysqli_fetch_array($result);

                if (substr($track,0,2)=='22' || substr($track,0,2)=='23' || substr($track,0,2)=='ES')
                    $sql = "SELECT * FROM orders WHERE third_party= '$track' LIMIT 1";	
                else 
                    {
                        $track_eliminated = substr($track,-8,8);
                        $sql = "SELECT * FROM orders WHERE SUBSTRING(third_party,-8,8) = '$track_eliminated' LIMIT 1";	
                    }

                $result = mysqli_query($conn,$sql);
                if (mysqli_num_rows($result) == 1)
                {
                    $data = mysqli_fetch_array($result);
                    $order_id = $data["order_id"];
                    $receiver = $data["receiver"];
                    $status = $data["status"];
                    if ($receiver!=$user_id)
                    {
                        if ($status!="order")
                        {
                            $response["response"] = 302;
                            $response["error_msg"] = "Таны илгээмж биш байна. Ахин өөрийг оруулна уу";                            
                        }
                        if ($status=="order")
                        {
                            $receiver=$user_id;
                        
                            $package1_name=mysqli_escape_string($conn,$_POST["package1_name"]);
                            $package1_num =$_POST["package1_num"];
                            $package1_price =$_POST["package1_price"];
                            $package2_name=mysqli_escape_string($conn,$_POST["package2_name"]);
                            $package2_num =$_POST["package2_num"];
                            $package2_price =$_POST["package2_price"];
                            $package3_name=mysqli_escape_string($conn,$_POST["package3_name"]);
                            $package3_num =$_POST["package3_num"];
                            $package3_price =$_POST["package3_price"];
                            $package4_name=mysqli_escape_string($conn,$_POST["package4_name"]);
                            $package4_num =$_POST["package4_num"];
                            $package4_price =$_POST["package4_price"];
                            
                            $package_array = array(
                            $package1_name, $package1_num, $package1_price,
                            $package2_name, $package2_num, $package2_price,
                            $package3_name, $package3_num, $package3_price,
                            $package4_name, $package4_num, $package4_price
                            );
                            
                            $package =implode("##",$package_array);
                            $package_price = $package1_price + $package2_price + $package3_price + $package4_price;
                        
                            $sql_update = "UPDATE orders SET (price='$package_price',receiver ='$receiver',package='$package',status='filled',transport='$transport',proxy_id='$proxy_id',proxy_type='$proxy_type') WHERE order_id='$order_id'";
                            if (mysqli_query($conn,$sql_update)) 
                            {
                                $response["response"] = 200;
                                $response["error_msg"] = "";                                
                            }
                            else 
                            {
                                $response["response"] = 500;
                                $response["error_msg"] = "Алдаа.".mysqli_error($conn);                                             
                            }
                        }
                    }
                    
                    if ($receiver==$user_id)
                    {
                        if ($status=="item_missing")
                        {
                            $receiver=$user_id;
                        
                            $package1_name=mysqli_escape_string($conn,$_POST["package1_name"]);
                            $package1_num =$_POST["package1_num"];
                            $package1_price =$_POST["package1_price"];
                            $package2_name=mysqli_escape_string($conn,$_POST["package2_name"]);
                            $package2_num =$_POST["package2_num"];
                            $package2_price =$_POST["package2_price"];
                            $package3_name=mysqli_escape_string($conn,$_POST["package3_name"]);
                            $package3_num =$_POST["package3_num"];
                            $package3_price =$_POST["package3_price"];
                            $package4_name=mysqli_escape_string($conn,$_POST["package4_name"]);
                            $package4_num =$_POST["package4_num"];
                            $package4_price =$_POST["package4_price"];
                            
                            $package_array = array(
                            $package1_name, $package1_num, $package1_price,
                            $package2_name, $package2_num, $package2_price,
                            $package3_name, $package3_num, $package3_price,
                            $package4_name, $package4_num, $package4_price
                            );
                            
                            $package =implode("##",$package_array);
                            $package_price = $package1_price + $package2_price + $package3_price + $package4_price;
                        
                            $sql_update = "UPDATE orders SET (price='$package_price',receiver ='$receiver',package='$package',status='filled',transport='$transport',proxy_id='$proxy_id',proxy_type='$proxy_type') WHERE order_id='$order_id'";

                            if (mysqli_query($conn,$sql_update)) 
                                {
                                    $response["response"] = 200;
                                    $response["error_msg"] = "";   
                                    proxy_available($proxy_id,$proxy_id,1);                             
                                }
                                else 
                                {
                                    $response["response"] = 500;
                                    $response["error_msg"] = "Алдаа.".mysqli_error($conn);                                             
                                }                                                       
                        }
                        
                        if ($status!="item_missing")
                        {
                            $response["response"] = 200;
                            $response["error_msg"] = "";   
                        }
                    }
    
                }

                if (mysqli_num_rows($result) == 0)  //Бүтргэлгүй
                {
                    $sender=0;
                    $receiver=$user_id;
                                        
                    $sql = "SELECT *FROM branch_inventories WHERE track='$track'";
                    if (mysqli_num_rows(mysqli_query($conn,$sql))>0)                                                    
                    $status = 'received'; else $status= 'weight_missing';
                    $barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
                    do {
                        $barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
                        $query = mysqli_query($conn,"SELECT order_id FROM orders WHERE barcode='$barcode'");
                        } 
                        while (mysqli_num_rows($query) == 1); 
                        
                    $sql_insert ="INSERT INTO orders (created_date,barcode,third_party,package,price,sender,receiver,status,proxy_id,owner,is_online) 
                        VALUES('".date("Y-m-d H:i:s")."','$barcode','$track','$package','$package_price','$sender','$receiver','$status','$proxy_id',1,1)";

                        if (mysqli_query($conn,$sql_insert))
                        {
                            $response["response"] = 200;
                            $response["error_msg"] = "";
                            proxy_available($proxy_id,0,1);
                        }
                        else 
                        {
                            $response["response"] = 500;
                            $response["error_msg"] = "Алдаа.".mysqli_error($conn);                                             
                        }
                }
            }
            
                        

            if ($is_container)
            {
                $track_eliminated = substr($track,-8,8);
                $sql = "SELECT * FROM container_item WHERE SUBSTRING(track,-8,8) = '$track_eliminated'";
                $result = mysqli_query($conn,$sql);
                if (mysqli_num_rows($result) > 1) 
                    {
                        $response["response"] = 477;
                        $response["error_msg"] = "1-с олон track олдлоо. Та хайлтын утгаа ихэсгэж ахин оролдоно уу?";                                             
                    }

                if (mysqli_num_rows($result)  == 1)
                {
                    $data = mysqli_fetch_array($result);
                    $status = $data["status"];
                    if ($status=="weight_missing") $msg= "Америкт хүргэгдээгүй байна.";
                    if ($status=="new") $msg= "USА оффис-д байгаа Монголруу далайгаар гарахад бэлэн болсон.";
                    if ($status=="item_missing") $msg= "Задаргаагүй. Илгээмжийн доторх мэдээллийг оруулаагүй байна. Иймд Монголруу гарах боложгүй. Та нэвтэрч орон Track-aa өөр дээрээ бүртгүүлж барааны тайлбараа бөглөнө үү";
                    if ($status=="warehouse") $msg= "Монгол дахь агуулахад ирсэн байна. Та өөрийн биеэр ирж авах боломжтой.";
                    if ($status=="onway") $msg= "Америкаас Монголруу далайгаар ирж яваа.";
                    if ($status=="delivered") $msg= "Илгээмжийг хүлээн авч олгосон.";
                    if ($status=="filled") $msg= "Барааны мэдээллийн бүрэн оруулсан байна. Бид мэдээллийг шалган наашаа гаргахад бэлэн төлөвт оруулах болно.";
                    if ($status=="custom") $msg= "Гаальд саатсан байна.";

                    
                        $response["response"] = 202;
                        $response["error_msg"] = $msg;                                             
                  
                    // echo "<br><br>";
                    // echo "<i>Хэрэв таны ачаа хүргэгдсэн төлөв байгаад манайд бүртгэгдээгүй бол бидэнд яаралтай мэдэгдэнэ үү.</i>";
                }

                    if (mysqli_num_rows($result) == 0)  //Бүтргэлгүй
                        {
                            // $sql2 = "SELECT customer_id,password,name FROM customer WHERE tel='$contact' LIMIT 1";
                            
                            
                            $sender=0;
                            $receiver=$user_id;
                            
                            
                            $transport = 0;
                            
                            $barcode='CO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
                            do {
                                    $barcode='CO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
                                    $query = mysqli_query($conn,"SELECT id FROM container_item WHERE barcode='$barcode'");
                                } 
                            while (mysqli_num_rows($query)== 1); 	
                            $sql_insert = "INSERT INTO container_item (
                                    created_date,
                                    barcode,
                                    track,
                                    package,
                                    sender,
                                    receiver,
                                    status,
                                    owner,
                                    is_online)
                                    VALUES
                                    (
                                    '".date("Y-m-d H:i:s")."',
                                    '".$barcode."',
                                    '".$track."',
                                    '".$package."',
                                    '".$sender."',
                                    '".$receiver."',
                                    'weight_missing',
                                    1,
                                    1)";
                            if (mysqli_query($conn,$sql_insert))
                            {
                                
                                    $response["response"] = 200;
                                    $response["error_msg"] = "";                                             
                                
                            }
                            else 
                            {
                                $response["response"] = 500;
                                $response["error_msg"] = "Алдаа гарлаа";                                             
                            }      
                        }
            }

        } 
    else 
        {
            $response['response'] = 404;
            $response['error_msg'] = "Token not found";
        }
}
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


            $tracks = array();
            $sql = "SELECT * FROM orders WHERE receiver=".$user_id." AND (status = 'weight_missing' OR status='received') AND created_date>'".date("Y-m-d",strtotime('-35 days'))."' ORDER BY order_id DESC";

            $result= mysqli_query($conn,$sql);

            $i=mysqli_num_rows($result);

            $count=0;
            $sum_weight=0;


            while ($data = mysqli_fetch_array($result))
            {
                $track = array();
                    
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

                $track["track_id"] = intval($order_id);
                $track["id"] = intval($order_id);
                $track["weight"] = $weight;
                $track["price"] = $price;
                $track["created_date"] = $created_date;
                $track["onair_date"] = $onair_date;
                $track["warehouse_date"] = $warehouse_date;
                $track["delivered_date"] = $delivered_date;
                $track["barcode"] = $barcode;
                $track["track_no"] = $third_party;

                $track["advance"] = $advance;
                $track["advance_value"] = $advance_value;
                $track["extra"] = $extra;
                $track["status"] = $status;
                $track["is_online"] = $is_online;

                $packages = array();
                    $package_single = array();
                    $package_single["package1_name"]=$package1_name; $package_single["package1_num"]=$package1_num; $package_single["package1_price"]=$package1_price;
                    array_push($packages,$package_single);
                    unset($package_single);
                    $package_single = array();
                    $package_single["package2_name"]=$package2_name; $package_single["package2_num"]=$package2_num; $package_single["package2_price"]=$package2_price;
                    array_push($packages,$package_single);
                    unset($package_single);
                    $package_single = array();
                    $package_single["package3_name"]=$package3_name; $package_single["package3_num"]=$package3_num; $package_single["package3_price"]=$package3_price;
                    array_push($packages,$package_single);
                    unset($package_single);
                    $package_single = array();
                    $package_single["package4_name"]=$package4_name; $package_single["package4_num"]=$package4_num; $package_single["package4_price"]=$package4_price;
                    array_push($packages,$package_single);
                    unset($package_single);

                $track["packages"] = $packages;
                $track["is_container"] = false;
                if ($proxy_id>0) $track["is_proxy"]=true; else $track["is_proxy"]=false;
                $track["proxy_id"] = $proxy_id;
                $track["proxy_name"] = proxy($proxy_id,"name");

                $sum_weight+=floatval($weight);
                $count++;
                array_push($tracks,$track);
                unset($track);
            }

            $response["tracks"] = $tracks;
        
            $response["sum_weight"] = $sum_weight;
            $response["sum_count"] = $count;

            $response['response'] = 200;

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
            $track_id= intval($input["track_id"]);                
            // $order_id= intval($input["order_id"]);                

            $data = mysqli_fetch_array($result);
            $user_id = $data["customer_id"];
        
            
            $sql = "SELECT *FROM orders WHERE receiver=".$user_id." AND order_id='$track_id' LIMIT 1";
            $result = mysqli_query($conn,$sql);
            if (mysqli_num_rows($result)==1)
            {
                $data_order = mysqlI_fetch_array($result);
                $receiver = $data_order["receiver"];
                $track = $data_order["third_party"];
                $proxy_id = $data_order["proxy_id"];
                $proxy_type = $data_order["proxy_type"];
                $status = $data_order["status"];
                if ($receiver==$user_id)
                {
                    if ($status=='weight_missing')
                    {
                        $sql = "DELETE FROM orders WHERE order_id='$track_id' LIMIT 1";
                        if (mysqli_query($conn,$sql))
                        {
                            proxy_available($proxy_id,$proxy_type,0);
                            $response["response"]=200;
                        }
                        else
                        {
                            $response['response'] = 503;
                            $response['error_msg'] ="DB ERROR".mysqli_error($conn);
        
                        }

                    }		
                    if ($status<>'weight_missing')
                    {
                        $response['response']=501;
                        $response['error_msg'] ="Ачааны төлөв устгаж болохгүй төлөвт байна.";                                           
                    }
                }
                
                if ($receiver!=$user_id)
                    {
                        $response['response']=500;
                        $response['error_msg'] ="Уучлаарай. Таны захиалга биш байна";                    
                    }
                    
                
        
            }
            else 
            {
                $response['response']=404;
                $response['error_msg'] ="Трак олдсонгүй";
            
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

mslog("tracks",json_encode($input),json_encode($response),$_SERVER['REQUEST_METHOD']);

echo json_encode($response);
?>