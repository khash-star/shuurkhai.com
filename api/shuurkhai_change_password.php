<?php
header('Content-Type: application/json');
require_once 'config.php';
require_once 'helper.php';


$response = array();

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
            $current_password = $data["password"];      
            if (isset($input["old_password"]) && isset($input["new_password"]))
            {
                $old_password= $input["old_password"];                
                $new_password= $input["new_password"];
                $confirm_password= $input["confirm_password"];
                if ($new_password==$confirm_password)
                {
                    if ($old_password==$current_password)
                    {
                        $sql = "UPDATE customer SET password='$new_password' WHERE customer_id='$user_id' LIMIT 1";
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
                        $response['response'] = 202;
                        $response['error_msg'] = "Хуучин нууц үг буруу";
                    }
                }
                else 
                {
                    $response['response'] = 202;
                    $response['error_msg'] = "Шинэ үг давталт зөрүүтэй";
                }
            }
            else 
            {
                $response['response'] = 403;
                $response['error_msg'] = "Нууц үг өгөгдөөгүй";
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



echo json_encode($response);
?>