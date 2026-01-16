<?php
header('Content-Type: application/json');
require_once 'config.php';
require_once 'helper.php';
   
   $response = array();   
   if (isJson(file_get_contents( 'php://input' )))
   {
           $input= json_decode( file_get_contents( 'php://input' ), true );
           $username =  protection($input["username"]);
           $password =  protection($input["password"]);
           $fcm_token = protection($input["token"]);
           
           
            $response['response'] = 0;
            $response['error_msg'] ="";

            $sql = "SELECT * FROM customer WHERE username='$username' AND password='$password' LIMIT 1";
            $result = mysqli_query($conn,$sql);
            if (mysqli_num_rows($result)==1)
            {
               $data = mysqli_fetch_array($result);
               $profile = array();
               
               $id = $data["customer_id"];
               
               $sql2 = "UPDATE customer SET fcm_token = '$fcm_token' WHERE customer_id = '$id' LIMIT 1";
               mysqli_query($conn, $sql2);

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


               $token = "SH".md5($username.$user_id.date("Y-m-d H:i:s"));

               $response['token'] = $token;

               $response['profile'] = $profile;


               $sql = "UPDATE customer SET last_log = '".date("Y-m-d H:i:s")."',token='$token' WHERE customer_id='$user_id' LIMIT 1";
               mysqli_query($conn,$sql);

               $sql = "INSERT INTO customer_logging (customer_id,device) VALUES ('$user_id',1)";
               mysqli_query($conn,$sql);

               $response['response'] = 200;

            }
            else
            {
                $response['response'] = 401;
                $response['error_msg'] = "Нэвтрэх нэр эсвэл нууц үг буруу байна";
            }     
    }
else 
    {
            $response['response'] = 501; 
            $response['error_msg'] = "Invalid json format";
    }


echo json_encode($response);
?>