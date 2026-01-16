<?php
header('Content-Type: application/json;charset=utf-8');
require_once 'config.php';
require_once 'helper.php';

$response = array();
$response['response'] = 200;
$response['error_msg'] ="";

$token=getBearerToken();
if ($token=="") $token="+";



$notifications = array();

if($_SERVER['REQUEST_METHOD'] == 'GET')
{
        $sql = "SELECT * FROM customer WHERE token='$token' LIMIT 1";            
        $result=mysqli_query($conn,$sql);
        
        if (mysqli_num_rows($result) == 1) 
        {
            $data = mysqli_fetch_array($result);
            $user_id = $data["customer_id"];

            $sql = "SELECT *FROM notifications WHERE receiver='$user_id' ORDER BY id DESC";
        
            $result= mysqli_query($conn,$sql);
            if (mysqli_num_rows($result)>0)
            {
                while ($data = mysqli_fetch_array($result))
                {
                    $notification["notification_id"] = intval($data["id"]);
                    $notification["title"] = $data["title"];
                    $notification["content"] = $data["content"];
                    $notification["created_date"] = $data["created_date"];                    
                    $notification["is_read"] = ($data["is_read"]==1)?TRUE:FALSE;

                    array_push($notifications,$notification);
                    unset($notification);
                }
            }
        }
        else 
        {
            $response['response'] = 404;
            $response['error_msg'] = "Token not found";
        }

        $response["notifications"] =$notifications;

}



if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isJson(file_get_contents( 'php://input' )))
    {
        $input= json_decode( file_get_contents( 'php://input' ), true );
        $notification_id =  intval($input["notification_id"]);
        
        $sql = "SELECT * FROM customer WHERE token='$token' LIMIT 1";            
        $result=mysqli_query($conn,$sql);
        
        if (mysqli_num_rows($result) == 1) 
                {
                    $data = mysqli_fetch_array($result);
                    $user_id = $data["customer_id"];

                    $sql = "UPDATE notifications SET is_read=1 WHERE id='$notification_id' AND receiver = '$user_id'";
                    if (mysqli_query($conn,$sql))                        
                        {
                            $response['response'] = 200;
                            $response['error_msg'] = "";
                        } 
                    else 
                        {
                            $response['response'] = 504;
                            $response['error_msg'] = "DB error";
                        }
    
                } 
            else 
                {
                    $response['response'] = 404;
                    $response['error_msg'] = "Token not found";
                }
    }
    else
    {
        $response['response'] = 501;
        $response['error_msg'] = "Invalid Json format";
    }
                
}


if($_SERVER['REQUEST_METHOD'] != 'GET' AND  $_SERVER['REQUEST_METHOD'] != 'POST' )
{
    $response['response'] = 501;
    $response['error_msg'] = "only accepts GET, POST methods";
}
echo json_encode($response);
?>