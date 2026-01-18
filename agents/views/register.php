<?php
    require_once("login_check.php");
    require_once("../config.php");
    require_once("helper.php");
    $plate = $_POST["plate"];
    $tel = $_POST["tel"];
    $email = $_POST["email"];
    $name = $_POST["name"];
    $rand = rand(1000,9999);

    
    
    $sql = "INSERT INTO users (name,tel,email,password,washable) VALUES ('$name','$tel','$email','$rand',0)";
    if (mysqli_query($conn,$sql))
    {
        $user_id = mysqli_insert_id($conn);
    
        if ($plate!="") 
        {
            $url = "https://xyp-api.smartcar.mn/xyp-api/v1/xyp/";
            $api = $url."get-data-public";
            $post_data['serviceCode'] ="WS100401_getVehicleInfo";
            $customFields['plateNumber'] = $plate;
            $post_data['customFields'] = $customFields;                                            
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_URL,$api);
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
            $response2 = curl_exec($ch);
            $response2_decode = json_decode($response2);
            // echo $response;
            curl_close($ch);  
    
    
            if (isset($response2_decode->plateNumber))
            {
                if ($response2_decode->wheelPosition =="Баруун") $is_right=1; else $is_right=0;
    
                $model = mysqli_escape_string($conn,$response2_decode->modelName);
                $mark = mysqli_escape_string($conn,$response2_decode->markName);
                $color = mysqli_escape_string($conn,$response2_decode->colorName);
    
                $mass = intval(mysqli_escape_string($conn,$response2_decode->mass));
                $length = intval(mysqli_escape_string($conn,$response2_decode->length));
                $width = intval(mysqli_escape_string($conn,$response2_decode->width));
                $height = intval(mysqli_escape_string($conn,$response2_decode->height));
                
                $sql = "UPDATE users SET 
                car_plate='$plate',
                car_model='$model',
                car_mark='$mark',
                car_color='$color',
                car_mass='$mass',
                car_length='$length',
                car_width='$width', 
                car_height='$height'
                WHERE id='$user_id'";
                $result=mysqli_query($conn,$sql);
            }   
    
        
        }
    
        header("location:index?message=registered");
    }
    else 
    header("location:index?message=register_occured");

?>