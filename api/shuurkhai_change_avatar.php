<?php
header('Content-Type: application/json');
require_once 'config.php';
require_once 'helper.php';


$response = array();
$response['response']=0;
$response['error_msg'] ="";

// $token = getBearerToken();

// $input= json_decode( file_get_contents( 'php://input' ), true );    


if($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'POST')
{
    $token = getBearerToken();
    echo $token;
    
    $sql = "SELECT id,eop_id FROM users WHERE token = '$token' LIMIT 1";
    $result=mysqli_query($conn,$sql);

    if (mysqli_num_rows($result) == 1) 
        {
            $data= mysqli_fetch_array($result);
            $user_id = $data["id"]; 
            $eop_id = $data["eop_id"]; 

            $sql = "SELECT avatar FROM employees WHERE id = '$eop_id' LIMIT 1";
            $result=mysqli_query($conn,$sql);
            $data= mysqli_fetch_array($result);

            
            $avatar = $data["avatar"];      

            if (isset($_FILES["avatar"]))
            {
                @$folder = date("Ym");
                if(!file_exists('../uploads/'.$folder))
                mkdir ( '../uploads/'.$folder);
                $target_dir = '../uploads/'.$folder;
                $target_file = $target_dir."/".@date("his").rand(0,1000). basename($_FILES["avatar"]["name"]);
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file))
                {
                    $target_file= substr($target_file,3);
                    $sql = "UPDATE employees SET avatar='$target_file' WHERE id='$user_id'";
                    mysqli_query($conn,$sql);
                    if ($avatar<>'' && file_exists('../'.$avatar)) unlink('../'.$avatar);
                    $response['response'] = 200;
                    $response['error_msg'] = "";                
                }
                else 
                {
                    $response['response'] = 466;
                    $response['error_msg'] = "Файл хуулахад алдаа гарлаа";                
                }
            }
            else 
            {
                $response['response'] = 455;
                $response['error_msg'] = "Файл илгээгдээгүй";                                    
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