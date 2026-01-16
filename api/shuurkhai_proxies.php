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

    $name = $input["name"];
    $surname = $input["surname"];
    $tel = $input["tel"];
    $address = $input["address"];
    
    
    $response['response']=0;
    $response['error_msg'] ="";

    $sql = "SELECT customer_id FROM customer WHERE token = '$token' LIMIT 1";
    $result=mysqli_query($conn,$sql);

    if (mysqli_num_rows($result) == 1) 
        {
            $data = mysqli_fetch_array($result);
            $user_id = $data["customer_id"];
           
            if (isset($input["proxy_id"]))
            {
                $proxy_id = intval($input["proxy_id"]);
                $sql = "UPDATE proxies SET name='$name',surname='$surname',tel='$tel',address='$address' WHERE proxy_id='$proxy_id' AND customer_id='$user_id'";
            }
            else 
            {
                $sql = "INSERT INTO proxies (name,surname,tel,address,customer_id) VALUES ('$name','$surname','$tel','$address','$user_id')";
            }
                    

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
        $user_id = $data["customer_id"];

        $proxies = array();
        $sql = "SELECT *FROM proxies WHERE customer_id='$user_id'";
        $result= mysqli_query($conn,$sql);
        while ($data = mysqli_fetch_array($result))
        {
            $proxy = array();
            $proxy["id"] = intval($data["proxy_id"]);
            $proxy["name"] = $data["name"];
            $proxy["surname"] = $data["surname"];
            $proxy["tel"] = $data["tel"];
            $proxy["address"] = $data["address"];
            array_push($proxies,$proxy);
            unset($proxy);
        }
        $response["proxies"] = $proxies;
    


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
            $proxy_id= intval($input["proxy_id"]);                

            $data = mysqli_fetch_array($result);
            $user_id = $data["customer_id"];
        

            $sql = "DELETE FROM proxies WHERE proxy_id='$proxy_id' AND  customer_id='$user_id'  LIMIT 1";
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

if($_SERVER['REQUEST_METHOD'] != 'PUT' && $_SERVER['REQUEST_METHOD'] != 'POST' && $_SERVER['REQUEST_METHOD'] != 'GET' && $_SERVER['REQUEST_METHOD'] != 'DELETE')  
{
    $response['response'] = 600;
    $response['error_msg'] = "METHOD NOT ACCEPTABLE";        
}


echo json_encode($response);
?>