<?php
header('Content-Type: application/json');
require_once 'config.php';
require_once 'helper.php';

    $token = getBearerToken();

    if($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'POST')
{
    $input= json_decode( file_get_contents( 'php://input' ), true );

    $token = getBearerToken();

    $response['response']=0;
    $response['error_msg'] ="";

    $sql = "SELECT customer_id,password FROM customer WHERE token = '$token' LIMIT 1";
    $result=mysqli_query($conn,$sql);

    if (mysqli_num_rows($result) == 1) 
        {
            $data= mysqli_fetch_array($result);
            $user_id = $data["customer_id"]; 

            if (mysqli_query($conn,"UPDATE customer SET token=NULL WHERE customer_id = '$user_id' LIMIT 1"))
            $response['response'] = 200;
            else 
            {
                $response['response'] = 500;
                $response['error_msg'] = "Гарахад алдаа гарлаа";    
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
    
    $response['response'] = 500;
    $response['error_msg'] = "ONLY ACCEPTS PUT OR POST";        
}



    $response = array();   
    
    $response['response'] = 200;
    $response['error_msg'] ="";


    echo json_encode($response);
?>