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
            $search = protection($input['search']);

            $sql = "SELECT *FROM customer WHERE tel='$search' OR email='$search' OR username='$search' LIMIT 1";
            $result = mysqli_query($conn,$sql);
            if (mysqli_num_rows($result)==0)
            {
                $response['response'] = 404;
                $response['error_msg'] = "Бүртгэл олдсонгүй";
            }
            if (mysqli_num_rows($result)==1)
             
           {
               $data = mysqli_fetch_array($result);
               $usernmae = $data["username"];
               $password = $data["password"];
               $email = $data["email"];
            
                if ($email<>"")
                {
                    $message = '<html><body>';
                    $message .= '<img src="https://shuurkhai.com/user/assets/images/logo.png" alt="Shuurkhai Logo" />';
                    $message .= 'Хэрэглэгч таны системд нэвтрэх мэдээллийг илгээж байна.';
                    $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';                
                    $message .= "<tr><td><strong>Нэвтрэх нэр:</strong> </td><td>" . $usernmae . "</td></tr>";
                    $message .= "<tr><td><strong>Нууц үг:</strong> </td><td>" . $password . "</td></tr>";
                    $message .= "</table>";
                    $message .= "</body></html>";
                    
                    $to = $email;
    
                    $subject = 'Shuurkhai.com login';
                    
                    $headers = "From: no-reply@shuurkhai.com\r\n";
                    //$headers .= "Reply-To: info@shuurkhai.com\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        
                    if (mail($to, $subject, $message, $headers))                       
                        {
                            $response['response'] = 200;
                            $response['error_msg'] = "";
                            
                        }
                        else 
                        {
                            
                            $response['response'] = 500;
                            $response['error_msg'] = "Илгээхэд алдаа гарлаа";                                                           
                        }
                }
                else
                { 
                    
                        $response['response'] = 300;
                        $response['error_msg'] = "Бүртгэл олдсонч имэйл бүртгэгдээгүй байна. Админд хандана уу";                                                            
                }
               
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
    $response['error_msg'] = "ONLY ACCEPTS POST";        
}
echo json_encode($response);



?>