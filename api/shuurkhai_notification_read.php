<?php
header('Content-Type: application/json');
require_once 'config.php';
require_once 'helper.php';


$response = array();
$response['response']=0;
$response['error_msg'] ="";

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isJson(file_get_contents( 'php://input' )))
    {
            $input= json_decode( file_get_contents( 'php://input' ), true );
            $token =  $input["token"];
           


                $sql = "SELECT id,password FROM users WHERE token = '$token' LIMIT 1";
                $result=mysqli_query($conn,$sql);

                if (mysqli_num_rows($result) == 1) 
                    {
                        $message_id =  intval($input["id"]);

                        $sql = "UPDATE noitifications SET is_read=1 WHERE id = '$message_id' AND reciver='$token'";
                        $result=mysqli_query($conn,$sql);
                        $response['response'] = 200;
                        $response['error_msg'] = "";
                            
        
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