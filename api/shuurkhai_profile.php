<?php
header('Content-Type: application/json');
require_once 'config.php';
require_once 'helper.php';


$response = array();

$token=getBearerToken();
if ($token=="") $token="+";
if($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'POST')
{
    $input= json_decode( file_get_contents( 'php://input' ), true );

    $response['response']=0;
    $response['error_msg'] ="";

    $sql = "SELECT * FROM customer WHERE token = '$token' LIMIT 1";
    $result=mysqli_query($conn,$sql);

    if (mysqli_num_rows($result) == 1) 
        {
            $data = mysqli_fetch_array($result);
            $user_id = $data["customer_id"];
            $surname= $input["surname"];                
            $rd= $input["rd"];                
            $email= $input["email"];                
            $facebook= $input["facebook"];                


            $sql = "UPDATE customer SET surname='$surname',rd='$rd',email='$email',facebook='$facebook' WHERE customer_id='$user_id' LIMIT 1";
            if (mysqli_query($conn,$sql))
                $response['response'] = 200;
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
        $profile = array();

        $profile["id"] = $user_id = $data["customer_id"];
        $profile["rd"] = $data["rd"];
        $profile["name"] = $data["name"];
        $profile["surname"] = $data["surname"];
        $profile["address"] = $data["address"];
        $profile["address_city"] = $data["address_city"];
        $profile["address_district"] = $data["address_district"];
        $profile["address_khoroo"] = $data["address_khoroo"];
        $profile["address_build"] = $data["address_build"];
        $profile["address_extra"] = $data["address_extra"];
        $profile["tel"] = $data["tel"];
        $profile["email"] = $data["email"];
        $profile["country"] = $data["country"];
        $profile["avatar"] = settings("base_url").$data["avatar"];
        $profile["last_log"] = $data["last_log"];
        $profile["news_read"] = $data["news_read"];
        $profile["no_proxy"] = $data["no_proxy"];
        $profile["registered_date"] = $data["registered_date"];
        $profile["modified_date"] = $data["modified_date"];
        $profile["last_order_id"] = $data["last_order_id"];
        $profile["last_order_date"] = $data["last_order_date"];
        $profile["status"] = $data["status"];
        $profile["category"] = $data["category"];
        $profile["facebook"] = $data["facebook"];
        $profile["recover_count"] = $data["recover_count"];
        $profile["recover_date"] = $data["recover_date"];
        $profile["cent"] = $data["cent"];


        $response['profile'] = $profile;

        $response['response'] = 200;

        }                   
    else 
        {
            $response['response'] = 404;
            $response['error_msg'] = "Token not found";
        }
}


if($_SERVER['REQUEST_METHOD'] != 'PUT' && $_SERVER['REQUEST_METHOD'] != 'POST' && $_SERVER['REQUEST_METHOD'] != 'GET')  
{
    $response['response'] = 600;
    $response['error_msg'] = "METHOD NOT ACCEPTABLE";        
}


echo json_encode($response);
?>