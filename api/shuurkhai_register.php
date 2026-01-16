<?php
header('Content-Type: application/json');
require_once 'config.php';
require_once 'helper.php';


$response = array();

if($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'POST')
{       

    $input= json_decode( file_get_contents( 'php://input' ), true );    

    $response['response']=0;
    $response['error_msg'] ="";


    if (isset($input["name"]) && isset($input["username"]) && isset($input["email"]) && isset($input["password"]) && isset($input["tel"]))
        {
            $username=protection($input["username"]);
            $tel=protection($input["tel"]);
            $name=protection($input["name"]);
            $surname=protection($input["surname"]);
            $password=protection($input["password"]);
            $email=protection($input["email"]);

            
            $sql = "SELECT *FROM customer WHERE username='$username' OR tel='$tel'";
            $result = mysqli_query($conn,$sql);
            if (mysqli_num_rows($result)>0)
            {
                $response['response'] = 230;
                $response['error_msg'] = "Нэвтрэх нэр, утас бүртгэлтэй байна. Та нууц үгээ сэргээх авах боломжтой";
            }
            else 
           {
                $sql = "INSERT INTO customer (name,surname,tel,email,username,password,registered_date,status) 
                VALUES('".$name."','".$surname."','".$tel."','".$email."','".$username."','".$password."','".date("Y-m-d H:i:s")."','pending')";
                
                                                        
                if (mysqli_query($conn,$sql))
                {
                    $response['response'] = 200;                    
                }
                else 
                {
                    $response['response'] = 505;
                    $response['error_msg'] = "DB error:".mysqli_error($conn);

                }
           }


        }
    else 
    {
        $response['response'] = 400;
        $response['error_msg'] = "Мэдээлэл дутуу байна";

    }
}
else
{
    
    $response['response'] = 500;
    $response['error_msg'] = "Хүсэлт буруу илгээсэн байна";        
}

echo json_encode($response);
?>
