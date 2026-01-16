<?php
header('Content-Type: application/json');
require_once 'config.php';
require_once 'helper.php';

$response = array();
$response['response'] = 0;
$response['error_msg'] = "";


if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isJson(file_get_contents('php://input'))) 
        {
            $input= json_decode(file_get_contents('php://input'), true);
            // $search = protection($input['search']);

            $response['response'] = 200;
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
    $response['error_msg'] = "ONLY ACCEPTS POST";        
}
echo json_encode($response);



?>