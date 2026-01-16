<?php
header('Content-Type: application/json');
require_once '../config.php';
require_once '../views/helper.php';


$response = array();
$response['response'] = 0;
$response['error_msg'] = "";

// $token=getBearerToken();
// if ($token=="") $token="+";

// $input= json_decode( file_get_contents( 'php://input' ), true );
if (isset($_GET["regNum"])) $rd=$_GET["regNum"]; else $rd = "";
if (isset($_GET["airBill"])) $airbill=$_GET["airBill"]; else $airbill = "";

// $airbill=$_GET["airbill"];

if ($rd == "5514134")
{    
    $sql= "SELECT *FROM gaali WHERE airbill='$airbill' LIMIT 1";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result)==1)
    {
        $data =mysqli_fetch_array($result);
        $airbill_id = $data["id"];
        $is_active = $data["is_active"];
        
        $response['response']=0;
        $response['error_msg'] ="";
        $orders = array();
        $count=0;
        $sum_weight=0;

        if ($is_active==1)
        {

            $sql = "SELECT * FROM gaali_items WHERE airbill_id=$airbill_id ORDER BY cust_name";
    
            $result= mysqli_query($conn,$sql);
    
    
            while ($data = mysqli_fetch_array($result))
            {
                $count++;
                $order = array();
    
                $order_id=$data["order_id"];
                $weight=$data["weight"];
                $price=$data["price"];
                $fee=number_format($data["fee"],2);
                
                
                $created_date=$data["created_date"];
                $airbilled_date=$data["airbilled_date"];
                // $onair_date=$data["onair_date"];
                // $warehouse_date=$data["warehouse_date"];
                // $delivered_date=$data["delivered_date"];
                
                
                $barcode=$data["barcode"];
                $package_name=$data["package_name"];
                
                $sender_name=$data["sender_name"];
                if ($sender_name=="") $sender_name = "SHUURKHAI.COM";
                $sender_name=$data["sender_name"];
                if ($sender_name=="") $sender_name = "SHUURKHAI.COM";
                $sender_address=$data["sender_address"];
                if ($sender_address=="") $sender_address = "1888 ELMHURST ROAD, MOUNT PROSPECT";
                $cust_id=$data["cust_id"];
                $cust_name=$data["cust_name"];
                $cust_address=$data["cust_address"];
                $cust_tel=$data["cust_tel"];
                $numb=$data["numb"];
                if ($numb<1) $numb=1;
                if ($data["is_flag"]) $is_flag='1'; else $is_flag = '0';
             
                $package1_name = $package2_name = $package3_name = $package4_name = "";

                
                $sql = "SELECT * FROM orders WHERE order_id='".$order_id."'";
                $result_pack = mysqli_query($conn,$sql);              
                if (mysqli_num_rows($result_pack) == 1)
                {
                    $data_pack = mysqli_fetch_array($result_pack);
                    $package=$data_pack["package"];
                    
                    $package_array=explode("##",$package);
                    $package1_name = $package_array[0];
                    $package1_num = $package_array[1];
                    $package1_value = strval(intval($package_array[2]));
                    // $package1_value = intval($package_array[2]) % 100;
                    $package2_name = $package_array[3];
                    $package2_num = strval(intval($package_array[4]));
                    // $package2_value = intval($package_array[5]) % 100;
                    $package2_value = intval($package_array[5]);
                    $package3_name = $package_array[6];
                    $package3_num = $package_array[7];
                    // $package3_value =intval($package_array[8]) % 100;
                    $package3_value =strval(intval($package_array[8]));
                    $package4_name = $package_array[9];
                    $package4_num = $package_array[10];
                    // $package4_value = intval($package_array[11]) % 100;
                    $package4_value = strval(intval($package_array[11]));

                    // if ($package1_value==0) $package1_value=10;
                    // if ($package2_value==0) $package2_value=10;
                    // if ($package3_value==0) $package3_value=10;
                    // if ($package4_value==0) $package4_value=10;
                }

                
                  
                // $order["packages"] = $packages;
                // if ($proxy_id>0) $order["is_proxy"]=true; else $order["is_proxy"]=false;
                // $order["proxy_id"] = $proxy_id;
                // $order["proxy_name"] = proxy($proxy_id,"name");
    
    
                
                // "HOUSE_SEQ":"002", 
                // "MAIL_ID":"55AA8C", 
                // "MAIL_BAG_NUMBER":"B2HDB6BA2", 
                // "BL_NO":"999-00583170", 
                // "REPORT_TYPE":"", 
                // "RISK_TYPE":"0", 
                // "NET_WGT":"12.9",
                // "WGT":"0.09", 
                // "WGT_UNIT":"KG", 
                // "QTY":"1", 
                // "QTY_UNIT":"U", 
                // "DANG_GOODS_CODE":"", 
                // "TRANS_FARE":"193.5", 
                // "TRANS_FARE_CURR":"USD", 
                // "PRICE1":"500", 
                // "PRICE_CURR1":"USD", 
                // "PRICE2":"500", 
                // "PRICE_CURR2":"USD", 
                // "PRICE3":"500", 
                // "PRICE_CURR3":"USD", 
                // "PRICE4":"500", 
                // "PRICE_CURR4":"USD", 
                // "PRICE5":"500", 
                // "PRICE_CURR5":"USD", 
                // "TRANSPORT_TYPE":"40", 
                // "IS_DIPLOMAT":"N", 
                // "HSCODE":"", 
                // "GOODS_NM":"Зөөврийн Компьютер", 
                // "SHIPPER_CNTRY_CD":"SFO", 
                // "SHIPPER_CNTRY_NM":"San Francisco", 
                // "SHIPPER_NATINALITY":"UBN", 
                // "SHIPPER_NM":"Suvd-erdene Amgalanbaatar", 
                // "SHIPPER_REG":"", 
                // "SHIPPER_ADDR":"901 sunrise ave, a2, roseville, CA, 95661", 
                // "SHIPPER_TEL":"+1 (510) 520-3836", 
                // "CONSIGNEE_CNTRY_CD":"", 
                // "CONSIGNEE_CNTRY_NM":"MN", 
                // "CONSIGNEE_NATINALITY":"MN", 
                // "CONSIGNEE_NM":"даваа Лхамдондог", 
                // "CONSIGNEE_REG":"", 
                // "CONSIGNEE_ADDR":"Улаанбаатар хот, Хан-Уул, буянухаа, 1хороолол 702 байр 29 тоот", 
                // "CONSIGNEE_TEL":"+976 89126534", 
                // "COMP_NAME":"ОРЧС ХХК", 
                // "COMP_REGISTER":"5795095", 
                // "COMP_ADDR":"ЧД 19 хороо дээд салхит 12-278 тоот", 
                // "COMP_TEL":"99188195 95022299",
                // "REG_DATE":"2022-12-17 07:02:23", 
                // "MAIL_DATE":"2022-12-17 07:02:23", 
                // "ECOMMERCE_TYPE":"N", 
                // "ECOMMERCE_LINK":"LINK"
    
                // "PRICE1":"500", 
                // "PRICE_CURR1":"USD", 
                $order["PRICE1"] =strval($price);
                $order["PRICE_CURR1"] ="USD";
                $order["HOUSE_SEQ"] =strval(sprintf('%03d',$count));
                $order["MAIL_ID"] =strval($barcode);
                $order["MAIL_BAG_NUMBER"] =strval($barcode);
                $order["BL_NO"] =strval($airbill);
                $order["REPORT_TYPE"] ="CP72";
                $order["RISK_TYPE"] =strval($is_flag);
                $order["NET_WGT"] =strval($weight);
                $order["WGT"] =strval($weight);
                $order["WGT_UNIT"] ="KG";
                $order["QTY"] =strval($numb);
                $order["QTY_UNIT"] ="U";
                $order["DANG_GOODS_CODE"] ="";
                $order["TRANS_FARE"] =strval($fee);
                $order["TRANS_FARE_CURR"] ="USD";

                // if ($package1_name<>"" && $package1_value<>"")
                // {
                //     $order["PRICE1"] =strval($package1_value);
                //     $order["PRICE_CURR1"] ="USD";
                // }

                // if ($package2_name<>"" && $package2_value<>"")
                // {
                //     $order["PRICE2"] =strval($package2_value);
                //     $order["PRICE_CURR2"] ="USD";
                // }

                // if ($package3_name<>"" && $package3_value<>"")
                // {
                //     $order["PRICE3"] =strval($package3_value);
                //     $order["PRICE_CURR3"] ="USD";
                // }

                // if ($package4_name<>"" && $package4_value<>"")
                // {
                //     $order["PRICE4"] =strval($package4_value);
                //     $order["PRICE_CURR4"] ="USD";
                // }

                $order["PRICE1"] =strval($price);
                $order["PRICE_CURR1"] ="USD";

                // "PRICE1":"500", 
                // "PRICE_CURR1":"USD", 
                
                $order["TRANSPORT_TYPE"] ="40";
                $order["IS_DIPLOMAT"] ="N";
                $order["HSCODE"] ="";
                $order["GOODS_NM"] =strval($package_name);
                $order["SHIPPER_CNTRY_CD"] ="US";
                $order["SHIPPER_CNTRY_NM"] ="Chicago";
                $order["SHIPPER_NATINALITY"] ="UBN";
                $order["SHIPPER_NM"] =strval($sender_name);
                $order["SHIPPER_REG"] ="5514134";
                $order["SHIPPER_ADDR"] =strval($sender_address);
                $order["SHIPPER_TEL"] ="";
                $order["CONSIGNEE_CNTRY_CD"] ="MN";
                $order["CONSIGNEE_CNTRY_NM"] ="MN";
                $order["CONSIGNEE_NATINALITY"] ="MN";
                $order["CONSIGNEE_NM"] =strval($cust_name);
                $order["CONSIGNEE_REG"] ="";
                $order["CONSIGNEE_ADDR"] =strval($cust_address);
                $order["CONSIGNEE_TEL"] =strval($cust_tel);
                $order["COMP_NAME"] ="Гэрэлд хүрэх оргил ХХК";
                $order["COMP_REGISTER"] ="5514134";
                $order["COMP_ADDR"] ="БЗД";
                $order["COMP_TEL"] ="90338585";
                $order["REG_DATE"] =$airbilled_date;
                $order["MAIL_DATE"] =$airbilled_date;
                $order["ECOMMERCE_TYPE"] ="N";
                $order["ECOMMERCE_LINK"] ="";
                
                $order["MANIFEST"] =strval(14);

                $sum_weight+=floatval($weight);
    
                // $count++;
                array_push($orders,$order);
                unset($order);
            }
    
            $response["orders"] = $orders;
    
            // $meta["sum_weight"] =strval($sum_weight);
            // $meta["sum_count"] =strval($count);
            
            
            // // $sum_weight+=floatval($weight);
    
            // // $count++;
            // array_push($orders,$meta);
        
            // array_push($orders,$sum_weight);
            // array_push($count,$count);
            // unset($order);
            
            $response["sum_weight"] = $sum_weight;
            $response["sum_count"] = $count;
            $response["MANIFEST"] =strval(14);

            $response['response'] = 200;
        }
        else 
        {
            $response['response'] = 201;
            $response['error_msg'] = "Airbill төлөв идэвхигүй";

        }
    
    

    }
    else 
    {
        $response['response'] = 405;
        $response['error_msg'] = "Тээврийн баримтын дугаар олдсонгүй";
    }
}
else 
{
    $response['response'] = 404;
    $response['error_msg'] = "Байгууллагын регистр буруу байна";

}

// mslog("gaali_api_short.php",$_SERVER['REQUEST_URI'],'','');


echo json_encode($orders);
?>