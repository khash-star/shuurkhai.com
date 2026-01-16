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

    $base_url = settings("base_url");

    $sql = "SELECT * FROM customer WHERE token='$token' LIMIT 1";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result)==1)
        {
        $data = mysqli_fetch_array($result);
        $user_id = $data["customer_id"];

        $categories = array();
        $sql = "SELECT *FROM shops_category ORDER BY dd";
        $result= mysqli_query($conn,$sql);
        while ($data = mysqli_fetch_array($result))
        {
            $category = array();
            $category["id"] = $category_id = intval($data["id"]);
            $category["name"] = $data["name"];

                $shops = array();
                $sql = "SELECT * FROM shops WHERE category='$category_id' ORDER BY dd";
                $result_shops= mysqli_query($conn,$sql);
                while ($data_shops = mysqli_fetch_array($result_shops))
                {
                    $shop = array();
                    $shop["id"] = intval($data_shops["id"]);
                    $shop["name"] = $data_shops["name"];
                    $shop["image"] = $base_url.$data_shops["image"];
                    $shop["description"] = $data_shops["description"];
            
                    array_push($shops,$shop);
                    unset($shop);
                }
            
            $category["shops"] = $shops;
                
            array_push($categories,$category);
            unset($category);
        }

        $response["shop_categories"] = $categories;


        $response['response'] = 200;

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