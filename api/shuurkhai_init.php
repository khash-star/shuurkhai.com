<?php
header('Content-Type: application/json');
require_once 'config.php';
require_once 'helper.php';

    $base_url = settings("base_url");
    $response = array();
    $response['response']=200;
    $response['error_msg'] ="";
    $response['app_name']=settings("general");

    $response['facebook']=settings("facebook");
    $response['twitter']=settings("twitter");
    $response['instagram']=settings("instagram");
    $response['address']=settings("address");
    $response['email']=settings("email");
    $response['contact']=settings("tel");
    $response["messenger"] = "https://m.me/shuurkhai.from.us";
    // $response["fb_chat_url"] = "https://m.me/Poppy-112141425017577";
    $response["online_shop_url"] = "https://buysmart.mn/";
    $response["home_banner_img"] = "https://shuurkhai.com/uploads/202409/070603229shuurkhaibanner.png";

    $home_widget["icon"] = "https://shuurkhai.com/user/assets/images/logo.png";
    $home_widget["title"] = appsettings("homewidget_title");
    $home_widget["description"] = appsettings("homewidget_description");

    $response["home_widget"] = $home_widget;
    // $my_id=0;
    // if (isJson(file_get_contents( 'php://input' )))
    // {
    //         $input= json_decode( file_get_contents( 'php://input' ), true );
    //         $token = protection($input['token']);
    //         $sql = "SELECT id FROM users WHERE token = '$token' LIMIT 1";
    //         $result=mysqli_query($conn,$sql);

    //         if (mysqli_num_rows($result) == 1) 
    //             {
    //                 $data = mysqli_fetch_array($result);
    //                 $my_id =$data["id"];
    //             }
    // }



    $faqs = array();
    $sql = "SELECT * FROM faqs ORDER BY dd";
    $result= mysqli_query($conn,$sql);
    while ($data = mysqli_fetch_array($result))
    {
        $faq = array();
        $faq["id"] = intval($data["faqs_id"]);
        $faq["question"] = $data["question"];
        $faq["answer"] = $data["answer"];
        array_push($faqs,$faq);
        unset($faq);
    }
    $response["faqs"] = $faqs;

    

    $address_city = array();
    $sql = "SELECT * FROM city";
    $result= mysqli_query($conn,$sql);
    while ($data = mysqli_fetch_array($result))
    {
        $city = array();
        $city["id"] = $city_id = intval($data["id"]);
        $city["name"] = $data["name"];

            $address_district = array();
            $sql = "SELECT * FROM district WHERE city_id='$city_id'";
            $result_dist= mysqli_query($conn,$sql);
            while ($data_dist = mysqli_fetch_array($result_dist))
            {
                $district = array();
                $district["id"] = intval($data_dist["id"]);
                $district["name"] = $data_dist["name"];
        
                array_push($address_district,$district);
                unset($district);
            }
        
        $city["district"] = $address_district;
            
        array_push($address_city,$city);
        unset($city);
    }
    $response["address"] = $address_city;

    
    


    $sliders = array();
    $sql = "SELECT * FROM sliders ORDER BY dd";
    $result= mysqli_query($conn,$sql);
    while ($data = mysqli_fetch_array($result))
    {
        $slider = array();
        $slider["id"] = intval($data["id"]);
        $slider["image"] = $base_url.$data["image"];
        $slider["title"] = $data["text1"];
        $slider["description"] = $data["text2"];
        $slider["url"] = $data["url"];
        array_push($sliders,$slider);
        unset($slider);
    }
    $response["sliders"] = $sliders;

    $popup = array();
    $sql = "SELECT * FROM slides ORDER BY rand() LIMIT 1";
    $result= mysqli_query($conn,$sql);
    while ($data = mysqli_fetch_array($result))
    {
        $popup["id"] = 1;
        $popup["image"] = $base_url."uploads/202410/popup.webp";
        $popup["text"] = "Аппликейшнд тавтай морилно уу";        
    }
    // $response["popup"] = $popup;


    
    $popup = array();
    $sql = "SELECT * FROM slides ORDER BY rand() LIMIT 1";
    $result= mysqli_query($conn,$sql);
    while ($data = mysqli_fetch_array($result))
    {
        // $popup["id"] = 1;
        $home_img["image"] = $base_url."assets/img/home-img.webp";
        $home_img["text"] = "Shuurkhai.com тавтай морилно уу";        
        $home_img["url"] = "https://shuurkhai.com/";        
    }
    $response["home_img"] = $home_img;



    $pages = array();

    $sql = "SELECT * FROM pages";
    $result= mysqli_query($conn,$sql);
    while ($data = mysqli_fetch_array($result))
    {
        $page = array();
        $page["id"] = intval($data["page_id"]);
        $page["image"] = $base_url.$data["image"];
        $page["title"] = $data["title"];
        $page["content"] = $data["content"];
        array_push($pages,$page);
        unset($page);
    }
    $response["pages"] = $pages;

    $bank_accounts = array();
        {
            $bank_account = array();
            $bank_account["id"] = 2;
            $bank_account["logo"] = $base_url."assets/images/khanbank-logo.png";
            $bank_account["bank"] = "Хаан банк";
            $bank_account["account_no"] = "5111104306";
            $bank_account["account_name"] = "Хашбал";
            $bank_account["currency"] = "₮";
            $bank_account["purpose"] = "logistic";
            array_push($bank_accounts,$bank_account);
            unset($bank_account);


            $bank_account = array();
            $bank_account["id"] = 1;
            $bank_account["logo"] = $base_url."assets/images/khanbank-logo.png";
            $bank_account["bank"] = "Хаан банк";
            $bank_account["account_no"] = "5003883871";
            $bank_account["account_name"] = "Гэрэл";
            $bank_account["currency"] = "₮";
            $bank_account["purpose"] = "online";
            array_push($bank_accounts,$bank_account);
            unset($bank_account);
    
            // $bank_account = array();
            // $bank_account["id"] = 2;
            // $bank_account["logo"] = $base_url."assets/images/golomt-logo.png";
            // $bank_account["bank"] = "Голомт банк";
            // $bank_account["account_no"] = "1161002923";
            // $bank_account["account_name"] = "Гэрэл";
            // $bank_account["currency"] = "$";
            // $bank_account["purpose"] = "online";
            // array_push($bank_accounts,$bank_account);
            // unset($bank_account);
        }    
    $response["bank_accounts"] = $bank_accounts;


    
    $offices = array();
        {
            // US hayg 1
            $office= array();
            $items= array();
            $item["id"] = 1;
            $item["name"] = "Address Line 1:";            
            $item["value"] = "1888 ELMHURST ROAD";
            array_push($items,$item);            

            $item["id"] = 2;
            $item["name"] = "Address Line 2:";            
            $item["value"] = "Таны утасны дугаар";
            array_push($items,$item);            

            $item["id"] = 3;
            $item["name"] = "City:";            
            $item["value"] = "Mount Prospect";
            array_push($items,$item);            

            $item["id"] = 4;
            $item["name"] = "State/Province:";            
            $item["value"] = "Illinois";
            array_push($items,$item);            

            $item["id"] = 5;
            $item["name"] = "Zip code:";            
            $item["value"] = "60056";
            array_push($items,$item);            

            $item["id"] = 6;
            $item["name"] = "Country:";            
            $item["value"] = "United States";
            array_push($items,$item);            

            $item["id"] = 7;
            $item["name"] = "Phone:";            
            $item["value"] = "7736216807";
            array_push($items,$item);                    
            
            $office["name"] = "Захиалгын хаяг 1";
            $office["items"] = $items;
            array_push($offices,$office);
            unset($office);
            unset($items);


            // US hayg 2

            $items= array();
            $item["id"] = 1;
            $item["name"] = "Address Line 1:";            
            $item["value"] = "24A Trolley Square 186";
            array_push($items,$item);            

            $item["id"] = 2;
            $item["name"] = "Address Line 2:";            
            $item["value"] = "186 Shuurkhai";
            array_push($items,$item);            

            $item["id"] = 3;
            $item["name"] = "City:";            
            $item["value"] = "WILMINGTON";
            array_push($items,$item);            

            $item["id"] = 4;
            $item["name"] = "State/Province:";            
            $item["value"] = "Delaware";
            array_push($items,$item);            

            $item["id"] = 5;
            $item["name"] = "Zip code:";            
            $item["value"] = "19806";
            array_push($items,$item);            

            $item["id"] = 6;
            $item["name"] = "Country:";            
            $item["value"] = "United States";
            array_push($items,$item);            

            $item["id"] = 7;
            $item["name"] = "Phone:";            
            $item["value"] = "7736216807";
            array_push($items,$item);                    
            
            $office["name"] = "Захиалгын хаяг 2";
            $office["items"] = $items;
            array_push($offices,$office);
            unset($office);
            unset($items);

            // Mongol hayg
            $items= array();
            $item["id"] = 1;
            $item["name"] = "Хаяг:";            
            $item["value"] = "13-р хороолол, 3н өндөр Нара Экспо - 13370. Баянзүрх 2-р хороо, Улаанбаатар";
            array_push($items,$item);            

            $item["id"] = 2;
            $item["name"] = "Дүүрэг:";            
            $item["value"] = "Баянзүрх";
            array_push($items,$item);            

            $item["id"] = 3;
            $item["name"] = "Хот:";            
            $item["value"] = "Улаанбаатар";
            array_push($items,$item);                    

            $item["id"] = 5;
            $item["name"] = "Зип код:";            
            $item["value"] = "13370";
            array_push($items,$item);            

            $item["id"] = 6;
            $item["name"] = "Country:";            
            $item["value"] = "Монгол улс";
            array_push($items,$item);            

            $item["id"] = 7;
            $item["name"] = "Утас 1:";            
            $item["value"] = "90338585";
            array_push($items,$item);                    

            $item["id"] = 8;
            $item["name"] = "Утас 2:";            
            $item["value"] = "77177509";
            array_push($items,$item);                    

            $item["id"] = 9;
            $item["name"] = "Имэйл:";            
            $item["value"] = "info@shuurkhai.com";
            array_push($items,$item);                    
            
            $office["name"] = "Монгол хаяг";
            $office["items"] = $items;
            array_push($offices,$office);
            unset($office);
            unset($items);


        }    
    $response["offices"] = $offices;

    echo json_encode($response);
?>