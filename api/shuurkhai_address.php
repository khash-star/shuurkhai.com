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

    $city_id = intval($input["city_id"]);
    $district_id = intval($input["district_id"]);
    $khoroo = $input["khoroo"];
    $build = $input["build"];
    $extra = $input["extra"];
    
    $response['response']=0;
    $response['error_msg'] ="";

    $sql = "SELECT customer_id FROM customer WHERE token = '$token' LIMIT 1";
    $result=mysqli_query($conn,$sql);

    if (mysqli_num_rows($result) == 1) 
        {
            $data = mysqli_fetch_array($result);
            $user_id = $data["customer_id"];
           
            if (isset($input["address_id"]))
            {
                $address_id = intval($input["address_id"]);
                $sql = "UPDATE customer_address SET city='$city_id',district='$district_id',khoroo='$khoroo',build='$build',extra='$extra' WHERE id='$address_id' AND customer_id='$user_id'";
            }
            else 
            {
                $sql = "INSERT INTO customer_address (city,district,khoroo,build,extra,customer_id) VALUES ('$city_id','$district_id','$khoroo','$build','$extra','$user_id')";
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

        $addresses = array();
        $sql = "SELECT * FROM customer_address WHERE customer_id='$user_id'";
        $result= mysqli_query($conn,$sql);
        while ($data = mysqli_fetch_array($result))
        {
            $address = array();
            $address["id"] = intval($data["id"]);


            $address["city_id"] = intval($data["city"]);

            $sql_city = "SELECT * FROM city WHERE id='".$address["city_id"]."'";
            $result_city= mysqli_query($conn,$sql_city);
            $data_city = mysqli_fetch_array($result_city);
            $address["city_name"] = $data_city["name"];

            $address["district_id"] = intval($data["district"]);

            $sql_district = "SELECT * FROM district WHERE id='".$address["district_id"]."'";
            $result_district= mysqli_query($conn,$sql_district);
            $data_district = mysqli_fetch_array($result_district);
            $address["district_name"] = $data_district["name"];

            $address["khoroo"] = $data["khoroo"];
            $address["build"] = $data["build"];
            $address["extra"] = $data["extra"];
            array_push($addresses,$address);
            unset($address);
        }
        $response["addresses"] = $addresses;
    


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
            $address_id= intval($input["address_id"]);                

            $data = mysqli_fetch_array($result);
            $user_id = $data["customer_id"];
        

            $sql = "DELETE FROM customer_address WHERE id='$address_id' AND  customer_id='$user_id'  LIMIT 1";
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