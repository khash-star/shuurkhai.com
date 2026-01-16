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

            
            
            $url= $input["url"];                
            $size= $input["size"];                
            $color= $input["color"];                
            $number= $input["number"];                
            $transport= $input["transport"];                
            $context= $input["description"];       
            
            if (strpos($url,"bestbuy.com")>0 || 
            strpos($url,"cabelas.com")>0 ||
            strpos($url,"sweetwater.com")>0 ||
            strpos($url,"macys.com")>0 ||
            strpos($url,"adidas.com")>0 ||
            strpos($url,"dsw.com")>0 ||
            strpos($url,"nike.com")>0 ||
            strpos($url,"michaelkors.com")>0) $no_ssl=1; else $no_ssl=0;

            function getSslPage($url) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_REFERER, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                $result = curl_exec($ch);
                curl_close($ch);
                return $result;
            }

            function get_title($url){
            $str = file_get_contents($url);
            if(strlen($str)>0){
                $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
                preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title); // ignore case
                return $title[1];
            }
            }
            //echo $url;
            if ($no_ssl==0)
            {
            $html = getSslPage($url);
            $title = substr($html,strpos(strtolower($html),"<title>")+7, strpos(strtolower($html),"</title>")-strpos(strtolower($html),"<title>")-7);
            }

            if ($title=="") $title=$url;
            if (strpos($title,": Amazon")>0) $title = substr($title,0,strpos($title,": Amazon"));
            if (strpos($title,"| eBay")>0) $title = substr($title,0,strpos($title,"| eBay"));
            $title = mysqli_escape_string($conn,$title);

            if (isset($input["online_id"]))
            {
                $online_id = $input["online_id"];
                $sql = "UPDATE online SET url='$url',size='$size',color='$color',`number`='$number',title='$title',transport='$transport',context='$context' WHERE online_id='$online_id' AND customer_id='$user_id'";
            }
            else 
            {
                $sql = "INSERT INTO online (url,size,color,`number`,customer_id,receiver,title,transport,context,status) 
                VALUES('".$url."','".$size."','".$color."','".$number."','".$user_id."','".$user_id."','".$title."','".$transport."','".$context."','online')";
            }

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

            if (isset($_GET["select"])) $select = $_GET["select"]; else $select="";
            $onlines = array();
            if ($select=="")
            $sql = "SELECT * FROM online WHERE (customer_id='".$user_id."' OR receiver='".$user_id."') AND status NOT IN ('order','later','pending') ORDER BY online_id DESC";
            if ($select=="pending")
            $sql = "SELECT * FROM online WHERE (customer_id='".$user_id."' OR receiver='".$user_id."') AND status ='pending' ORDER BY online_id DESC";
            if ($select=="postponed")
            $sql = "SELECT * FROM online WHERE (customer_id='".$user_id."' OR receiver='".$user_id."') AND status ='later' ORDER BY online_id DESC";
            if ($select=="order")
            $sql = "SELECT * FROM online WHERE (customer_id='".$user_id."' OR receiver='".$user_id."') AND status ='order' ORDER BY online_id DESC";
            if ($select=="history")
            $sql = "SELECT * FROM online WHERE (customer_id='".$user_id."' OR receiver='".$user_id."') AND (status = 'complete' OR status = 'order') ORDER BY online_id DESC";
            $result= mysqli_query($conn,$sql);

            $i=mysqli_num_rows($result);

            $count=0;
            $sum_price=0;
            $sum_tax=0;
            $sum_shipping=0;


            while ($data = mysqli_fetch_array($result))
            {
                $count++;

                $online = array();
                    
               


                $created_date=$data["created_date"];
                $online_id=$data["online_id"];
                $url=$data["url"]; 
                $size=$data["size"]; 
                $color=$data["color"];
                $number=$data["number"];
                $receiver=$data["receiver"];
                $comment=$data["comment"];
                $status=$data["status"];
                $price=$data["price"];
                $tax=$data["tax"];
                $shipping=$data["shipping"];
                $title=$data["title"];
                $transport = $data["transport"];
                $description = $data["context"];

                if (strlen($title)>50) $title=substr($title,0,50)."...";
                if (strlen($title)==0) $title=substr($url,0,50)."...";


                $online["created_date"] = $created_date;
                $online["online_id"] = intval($online_id);
                $online["url"] = $url;
                $online["size"] = $size;
                $online["color"] = $color;
                $online["number"] = $number;
                $online["receiver"] = $receiver;
                $online["comment"] = $comment;

                $online["status"] = $status;
                // $online["price"] = $price;
                $online["price"] = settings("rate")*($price+$tax+$shipping);
                $online["tax"] = $tax;
                $online["shipping"] = $shipping;
                $online["title"] = $title;
                $online["transport"] = $transport;
                $online["description"] = $description;

                if ($status=="online" && ($price+$tax+$shipping)>0) $status ="төлөх";
                $online["status"] = $status;
                
                $sum_price+=$price;
                $sum_tax+=$tax;
                $sum_shipping+=$shipping;

                array_push($onlines,$online);
                unset($online);
            }

            $response["online"] = $onlines;
        
            $response["sum_price"] = $sum_price;
            $response["sum_tax"] = $sum_tax;
            $response["sum_shipping"] = $sum_shipping;
            $response["sum_count"] = $count;

            $response["gt_usd"]=number_format($sum_price+$sum_tax+$sum_shipping);
            $response["gt_mnt"]=number_format(settings("rate")*($sum_price+$sum_tax+$sum_shipping));

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
    $response['response']=0;
    $response['error_msg'] ="";

    $sql = "SELECT customer_id FROM customer WHERE token = '$token' LIMIT 1";
    $result=mysqli_query($conn,$sql);

    if (mysqli_num_rows($result) == 1) 
        {
            $online_id= intval($input["online_id"]);                

            $data = mysqli_fetch_array($result);
            $user_id = $data["customer_id"];
        
            
            $sql = "SELECT *FROM online WHERE online_id='$online_id' AND customer_id='$user_id' LIMIT 1";
            $result = mysqli_query($conn,$sql);
            if (mysqli_num_rows($result)==1)
            {
                $data_order = mysqlI_fetch_array($result);
                
                $sql = "DELETE FROM online WHERE online_id='$online_id' AND customer_id='$user_id' LIMIT 1";
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
                $response['error_msg'] ="Онлайн захиалга олдсонгүй";
            
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


mslog("online",json_encode($input),json_encode($response),$_SERVER['REQUEST_METHOD']);

echo json_encode($response);
?>