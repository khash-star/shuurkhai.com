<?php
header('Content-Type: application/json');
require_once 'config.php';
require_once 'helper.php';


$response = array();
$response['response']=0;
$response['error_msg'] ="";

if($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isJson(file_get_contents( 'php://input' )))
    {
            $input= json_decode( file_get_contents( 'php://input' ), true );
            $token = getBearerToken();
            $password =  $input["password"];


                $sql = "SELECT customer_id,password FROM customer WHERE token = '$token' LIMIT 1";
                $result=mysqli_query($conn,$sql);

                if (mysqli_num_rows($result) == 1) 
                    {
                        $data= mysqli_fetch_array($result);
                        $user_id = $data["customer_id"]; 
                        $current_password = $data["password"];      
                        if (isset($input["password"]))
                        {
                            $password= $input["password"];
                            if ($password==$current_password)
                            {
                                // $sql = "DELETE FROM users WHERE token='$token' LIMIT 1";
                                // mysqli_query($conn,$sql);
                                
                                
                                $response['response'] = 200;
                                $response['error_msg'] ="";
                            }
                            else 
                            {
                                $response['response'] = 202;
                                $response['error_msg'] = "Password incorrect";
                            }
                        }
                        else 
                        {
                            $response['response'] = 403;
                            $response['error_msg'] = "Password not set";
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
else
{
    
    $response['response'] = 500;
    $response['error_msg'] = "ONLY ACCEPTS PUT OR POST";        
}

echo json_encode($response);
?>