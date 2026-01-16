<?php
header('Content-Type: application/json');
require_once 'config.php';
require_once 'helper.php';


$response = array();

$token=getBearerToken();
if ($token=="") $token="+";

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

        $logs = array();
        $sql = "SELECT *FROM customer_logging WHERE customer_id='$user_id' ORDER BY id DESC";
        $result = mysqli_query($conn,$sql);
        while ($data =mysqli_fetch_array($result))
        {
            $log = array();
            $log["id"] = intval($data["id"]);
            $log["ip"] = $data["ip"];
            $log["browser"] = $data["browser"];
            $log["device"] = $data["device"]?'Аппликейшн':'Веб';
            $log["timestamp"] = $data["timestamp"];

            array_push($logs,$log);
            unset($log);
        }


        $response['response'] = 200;
        $response['logs'] = $logs;

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


echo json_encode($response);
?>