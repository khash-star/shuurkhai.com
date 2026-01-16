<?
    require_once("config.php");
    require_once("views/helper.php");
    require_once("views/login_check.php");
    require_once("views/init.php");
?>

<link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<body class="sidebar-dark">
	<div class="main-wrapper">
    <?  require_once("views/navbar.php"); ?>
	
		<div class="page-wrapper">
      <?  require_once("views/sidebar.php"); ?>
			

			<div class="page-content">

        <!------------------------------------------------------------------------------------->
        
          <!--label class="section-title">Basic Responsive DataTable</label>
          <p class="mg-b-20 mg-sm-b-40">Searching, ordering and paging goodness will be immediately added to the table, as shown in this example.</p-->
          <?
          if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="dashboard";?>
          <?
          switch ($action)
          {
            case "display": $action_title="Бүх Ачаа";break;
            case "submit": $action_title="Upost илгээх";break;
            case "submitting": $action_title="Upost илгээж байна";break;
            case "history": $action_title="Түүх";break;
            case "box_submit": $action_title="Богц илгээх";break;
            case "box_submitting": $action_title="Богц илгээх";break;          
            case "box_history": $action_title="Богцын түүх";break;
            case "category_new": $action_title="Ангилал нэмэх";break;          
            case "category_adding": $action_title="Ангилал нэмэх";break;          
            case "category_edit": $action_title="Ангилал засах";break;          
            case "category_editing": $action_title="Ангилал засах";break;          
            case "category_delete": $action_title="Ангилал устгах";break;          
            case "categorize": $action_title="Ангилсан Ачаа";break;
            case "register": $action_title="Ачаа бүртгэх";break;
            case "registering": $action_title="Ачаа бүртгэх";break;
            case "detail": $action_title="Ачааийн дэлгэрэнгүй";break;
            case "edit": $action_title="Ачааийн мэдээлэл засах";break;
            case "editing": $action_title="Ачааийн мэдээлэл засах";break;
            case "delete": $action_title="Ачааийн мэдээлэл устгах";break;
            case "dashboard": $action_title="Удирдлага";break;
            case "search": $action_title="Ачаа хайх";break;
            case "proxy_clear": $action_title="Proxy чөлөөлөх";break;
            case "error": $action_title="Мэдээлэл алдаатай";break;

            
          }
          ?>
          <nav class="page-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="customers">Ачаа</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?=$action_title;?></li>
            </ol>
          </nav>

          <?
          if ($action =="dashboard")
          {
            
          }
          ?>

          <?
          if ($action =="submit")
          {
            $sql = "SELECT *FROM orders WHERE status='new' AND upost_pk IS NULL";
            $result = mysqli_query($conn,$sql);
            $total = mysqli_num_rows($result);
            ?>
            <h4 id="default">Upost илгээх</h4>
                <p class="mb-3">Өмнө нь илгээгдээгүй new төлөвтэй ачааг зөвхөн илгээнэ</p>
                <div class="example">
                    <div class="alert alert-primary" role="alert">
                        <b><?=number_format($total);?></b> илгээмжийг илгээхээр хүлээгдэж байна.
                    </div>
                </div>
                <? 
                if ($total>0) 
                    {
                        ?>
                        <a  class="btn btn-success mb-1 mb-md-0" href="upost?action=submitting">Илгээх</a>
                        <?
                    }
          }
          ?>

          <?
          if ($action =="submitting")
          {
            ?>
            <h4 id="default">Upost илгээх</h4>

            <?
                  $host = "https://2018.upost.mn/api/";
                  $url = $host."Login";

                  $input_parameter = [
                      "username" => "Gerelt khurekh orgil\\byua",
                      "password" => "789",
                      "progId"=> "1"
                  ];            

                  $ch = curl_init();

                  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/json'));
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                  curl_setopt($ch, CURLOPT_URL,$url);
                  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input_parameter));           
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                  $output_detail = curl_exec($ch);
                  curl_close($ch);
                  $upost_responce = json_decode($output_detail);
                  //var_dump($result);

                  if ($upost_responce->retType==0) //Aмжилттай нэвтэрлээ.
                  {
                      $access_token = $upost_responce->retDesc;
                      
                      ?>
                      <div class="alert alert-success mt-1" role="alert">
                          Нэвтрэлт амжилттай
                      </div>
                      <?
                      $sql = "SELECT *FROM orders WHERE status='new' AND upost_pk IS NULL";
                      //$sql = "SELECT *FROM orders WHERE barcode='GO211014998MN'";

                      // echo $sql;
                      $result = mysqli_query($conn,$sql);
                      $total = mysqli_num_rows($result);
                      ?>
                          <div class="alert alert-success" role="alert">
                              <b><?=number_format($total);?></b> илгээмжийг илгээж байна.
                          </div>
                      <?

                      $success_count =0;
                      if ($total>0)            
                      while ($data =  mysqli_fetch_array($result))
                      {
                          $order_id =$data["order_id"];
                          $sender_id =$data["sender"];
                          $receiver_id =$data["receiver"];
                          $proxy_id =$data["proxy_id"];
                          $proxy_type =$data["proxy_type"];
                          $barcode = $data["barcode"];
                          $package = $data["package"];
                        // echo $barcode;
                          
                          $sql = "SELECT *FROM customer WHERE customer_id='$sender_id'";
                          $result_sender = mysqli_query($conn,$sql);
                          $sender = mysqli_fetch_array($result_sender);

                          $sql = "SELECT customer.*,city.name city_name,district.name district_name 
                          FROM customer 
                          LEFT JOIN city ON address_city=city.id 
                          LEFT JOIN district ON address_district=district.id 
                          WHERE customer_id='$receiver_id'";

                          $result_receiver = mysqli_query($conn,$sql);
                          $receiver = mysqli_fetch_array($result_receiver);

                          if ($proxy_id!=0)
                          {
                              if ($proxy_type==0) 
                              $sql = "SELECT *FROM proxies WHERE proxy_id=$proxy_id";
                              if ($proxy_type==1)
                              $sql = "SELECT * FROM proxies_public WHERE proxy_id='$proxy_id' LIMIT 1";
                              $result_proxy =mysqli_query($conn,$sql);
                              $proxy = mysqli_fetch_array($result_proxy);
                          }

                          $input_parameter = [
                            "functionID" => "FN6_001",
                            "version" => "1.0",
                            "screenID"=> "MN10008",
                            "progID"=> "MAINWEB"                      
                        ];        

                            $input_parameter["jsonString"]["mData"]["DataRow"]=
                            [
                              "PK"=> -1,
                              "DevideNumber"=> 0,
                              "MailDate"=> $data["created_date"],
                              "MailId"=> $data["barcode"],
                              "PriceBurtgelinUne"=> "0",
                              "PriceIluuJingiin"=> "0",
                              "PriceNemeltUilchilgeeniUne"=> "0",
                              "PriceTax"=> "0",
                              "PriceTotalUne"=> cfg_price($data["weight"]),
                              "PriceUndsenUne"=> cfg_price($data["weight"]),
                              "R_MGLRecieverZone"=> 21,
                              "Undur"=> 0,
                              "Urd"=> 0,
                              "Urgun"=> 0,
                              "Weight"=> $data["weight"],
                              "fkDestinationBranch"=> 603,
                              "fkPostArea"=> 5,
                              "fkPostServiceType"=> 1,
                              "fkPostType"=> 2,
                              "isRecieverWillPay"=> true,
                              "isRedLevel"=> false
                            ];
                            // print_r($input_parameter);

                            if (mysqli_num_rows($result_sender)==1)
                            $input_parameter["jsonString"]["mData"]["DataRow"]["customer"]["sender"] =
                            [
                              "FirstName"=> $sender["name"],
                              "LastName"=> $sender["surname"],
                              "NationalRegisterNumber"=> $sender["rd"],
                              "PhoneNumber"=> $sender["tel"],
                              "fkCity"=> 2,
                              "fkDistrict"=> 2793,
                              "fkKhoroo"=> 2794,
                              "Email"=> $sender["email"],
                              "Address"=> $sender["address"],
                              "ZipCode"=> "",
                              "FullAddress"=> $sender["address"],
                              "isSender"=> 1
                            ];
                            if (mysqli_num_rows($result_sender)==0)                      
                            $input_parameter["jsonString"]["mData"]["DataRow"]["customer"]["sender"] =
                            [
                              "FirstName"=> USA_OFFICE_name,
                              "LastName"=> "",
                              "NationalRegisterNumber"=> "",
                              "PhoneNumber"=>USA_OFFICE_tel,
                              "fkCity"=> 2,
                              "fkDistrict"=> 2793,
                              "fkKhoroo"=> 2794,
                              "Email"=> "",
                              "Address"=> USA_OFFICE_address,
                              "ZipCode"=> USA_OFFICE_zip,
                              "FullAddress"=> USA_OFFICE_address,
                              "isSender"=> 1
                            ];
                            
                            if ($proxy_id!=0)
                            $input_parameter["jsonString"]["mData"]["DataRow"]["customer"]["reciever"] =
                            [
                              "FirstName"=> $proxy["name"],
                              "LastName"=> $proxy["surname"],
                              "NationalRegisterNumber"=> "",
                              "PhoneNumber"=> $proxy["tel"],
                              "fkCity"=> 21,
                              "fkDistrict"=> 26,
                              "fkKhoroo"=> 1079,
                              "Email"=> "",
                              "Address"=> $proxy["address"],
                              "ZipCode"=> "",
                              "FullAddress"=> $proxy["address"],
                              "isSender"=> 0
                            ];

                            if ($proxy_id==0)
                            $input_parameter["jsonString"]["mData"]["DataRow"]["customer"]["reciever"] =
                            [
                              "FirstName"=> $receiver["name"],
                              "LastName"=> $receiver["surname"],
                              "NationalRegisterNumber"=>  $receiver["rd"],
                              "PhoneNumber"=> $receiver["tel"],
                              "fkCity"=> 21,
                              "fkDistrict"=> 26,
                              "fkKhoroo"=> 1079,
                              "Email"=> "",
                              "Address"=>  $receiver["city_name"]." ".$receiver["district_name"]." ".$receiver["address_khoroo"]." ".$receiver["address"],
                              "ZipCode"=> "",
                              "FullAddress"=> $receiver["city_name"]." ".$receiver["district_name"]." ".$receiver["address_khoroo"]." ".$receiver["address"],
                              "isSender"=> 0
                            ];


                        $authorization = "Authorization: Bearer ".$access_token;
                        $url = $host.'DoExec';
                        //$url = $host."Login";
                        // echo json_encode($input_parameter,JSON_UNESCAPED_UNICODE)."<br>";

                        $ch = curl_init ($url);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8' , $authorization));
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_URL,$url);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input_parameter,JSON_UNESCAPED_UNICODE));           
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                        $output_detail = curl_exec ($ch);
                        curl_close($ch);
                        //echo $output_detail;
                        $upost_responce = json_decode($output_detail);
                        

                        
                        if ($upost_responce->retType==0) //Aмжилттай нэвтэрлээ.
                        {
                          $success_count++;
                          $pk_id = $upost_responce->retData->Table[0]->PK;
                          $sql ="UPDATE orders SET upost_pk='".$pk_id."',upost_date='".date("Y-m-d H:i:s")."' WHERE order_id='$order_id'";
                          mysqli_query($conn,$sql);

                          
                          $package_array=explode("##",$package);

                          if (count($package_array)>11)
                          {
                            $package1_name = $package_array[0];
                            $package1_num = $package_array[1];
                            $package1_value = floatval(str_replace('$','',$package_array[2]));
                            $package2_name = $package_array[3];
                            $package2_num = $package_array[4];
                            $package2_value = floatval(str_replace('$','',$package_array[5]));
                            $package3_name = $package_array[6];
                            $package3_num = $package_array[7];
                            $package3_value = floatval(str_replace('$','',$package_array[8]));
                            $package4_name = $package_array[9];
                            $package4_num = $package_array[10];
                            $package4_value = floatval(str_replace('$','',$package_array[11]));
                          }



                          $input_parameter = [
                            "functionID" => "FN6_013",
                            "version" => "1.0",
                            "screenID"=> "MN10008",
                            "progID"=> "MAINWEB"                      
                            ];        

                            if ($package1_name!="")
                            $input_parameter["jsonString"]["mData"]["DataRow"][0] = 
                            [
                              "fkCPCurrencyUnit"=> 319,
                              "SpecificName"=> $package1_name,
                              "Numbers"=> $package1_num,
                              "UnitPrice"=> $package1_value/$package1_num,
                              "TotalPrice"=> $package1_value,
                              "fkpMail"=> $pk_id
                            ];

                            if ($package2_name!="")
                            $input_parameter["jsonString"]["mData"]["DataRow"][1] = 
                            [
                              "fkCPCurrencyUnit"=> 319,
                              "SpecificName"=> $package2_name,
                              "Numbers"=> $package2_num,
                              "UnitPrice"=> $package2_value/$package2_num,
                              "TotalPrice"=> $package2_value,
                              "fkpMail"=> $pk_id
                            ];

                            if ($package3_name!="")
                            $input_parameter["jsonString"]["mData"]["DataRow"][2] = 
                            [
                              "fkCPCurrencyUnit"=> 319,
                              "SpecificName"=> $package3_name,
                              "Numbers"=> $package3_num,
                              "UnitPrice"=> $package3_value/$package3_num,
                              "TotalPrice"=> $package3_value,
                              "fkpMail"=> $pk_id
                            ];


                            if ($package4_name!="")
                            $input_parameter["jsonString"]["mData"]["DataRow"][3] = 
                            [
                              "fkCPCurrencyUnit"=> 319,
                              "SpecificName"=> $package4_name,
                              "Numbers"=> $package4_num,
                              "UnitPrice"=> $$package4_value/$package4_num,
                              "TotalPrice"=> $package4_value,
                              "fkpMail"=> $pk_id
                            ];


                              $ch = curl_init ($url);
                              curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8' , $authorization));
                              curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                              curl_setopt($ch, CURLOPT_URL,$url);
                              curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input_parameter,JSON_UNESCAPED_UNICODE));           
                              curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                              $output_detail = curl_exec ($ch);
                              curl_close($ch);

                              
                  }
                  else 
                  {
                    $error_sending .= $barcode .":". $upost_responce->retDesc."<br>";
                    //  $upost_responce->retDesc;
                
                  }      
                }    

                ?>

                  <div class="alert alert-success mt-1" role="alert">
                      <?=$success_count;?>/<?=$total;?> амжилттай илгээгдлээ.
                  </div>
                <?
              
             }
             else 
             {
                $error = $upost_responce->retDesc;
                ?>
                <div class="alert alert-danger mt-1" role="alert">
                    <?=$error;?>
                </div>
                <?
             }       
             
             if ($error_sending!="")
             {
              ?>              
                <div class="alert alert-danger mt-1" role="alert">
                    <?=$error;?> <br><?=$error_sending;?>
                </div>            
              <?
             }
            
          }
          ?>

          <?
          if ($action =="history")
          {
            if (isset($_POST["date"])) $date= $_POST["date"]; else $date= date("Y-m-d");
            ?>
            <div class="row">
              <div class="col-md-2 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h6 class="card-title">UPost илгээсэн түүх</h6>
                    <form action="upost?action=history" method="post">
                      <div class="input-group date datepicker" id="datePickerExample">
                        <span class="input-group-addon"><i data-feather="calendar"></i></span>
                        <input type="text" class="form-control" value="<?=$date;?>" name="date">
                      </div>
                      <input type="submit" value="Хайх" class="btn btn-success btn-block mt-1">
                    </form>
                    <p class="card-description">Тухайн өдөр илгээсэн илгээмжүүдийг харах боломжтой</p>
                  </div>
                </div>
              </div>
              <div class="col-md-10 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">                                       
                    <div class="table-responsive">
                      <table class="table">
                          <thead>
                            <tr>
                              <th>№</th>
                              <th>Barcode</th>
                              <th>Хүлээн авагч</th>
                              <th>Утас</th>
                              <th>Хаяг</th>
                              <th>Ачаа</th>
                              <th>Огноо</th>
                              <th>Үйлдэл</th>
                            </tr>
                          </thead>
                          <tbody>
                              <?
                              $count =0;
                              $sql = 
                              "SELECT orders.*,R.name receiver_name,R.surname receiver_surname,R.tel receiver_tel,R.address receiver_address  
                                FROM orders LEFT JOIN customer R ON orders.receiver=R.customer_id 
                                WHERE upost_pk IS NOT NULL AND upost_date LIKE '$date%'";

                              $result = mysqli_query($conn,$sql);
                              if (mysqli_num_rows($result)>0)
                              {
                                  while ($orders=mysqli_fetch_array($result))
                                  {
                                      
                                    $package_array=explode("##",$orders["package"]);

                                    if (count($package_array)>11)
                                    {
                                      $package1_name = $package_array[0];
                                      $package1_num = $package_array[1];
                                      $package1_value = $package_array[2];
                                      $package2_name = $package_array[3];
                                      $package2_num = $package_array[4];
                                      $package2_value = $package_array[5];
                                      $package3_name = $package_array[6];
                                      $package3_num = $package_array[7];
                                      $package3_value = $package_array[8];
                                      $package4_name = $package_array[9];
                                      $package4_num = $package_array[10];
                                      $package4_value = $package_array[11];
                                    }

                                    $package = $package1_name;
                                    if ($package2_name!="")
                                    $package .= ','.$package2_name;
                                    if ($package3_name!="")
                                    $package .= ','.$package3_name;
                                    if ($package3_name!="")
                                    $package .= ','.$package4_name;



                                    ?>
                                    <tr>
                                      <td><?=++$count;?></td>
                                      <td><a href="orders?id=<?=$orders["order_id"];?>"><?=$orders["barcode"];?></a></td>
                                      <?
                                      if ($orders["proxy_id"]==0)
                                      {
                                        ?>
                                          <td><a href="customers?action=detail&id=<?=$orders["receiver"];?>"><?=substr($orders["receiver_surname"],0,2).".".$orders["receiver_name"];?></a></td>
                                          <td><?=$orders["receiver_tel"];?></td>
                                          <td><?=$orders["receiver_address"];?></td>
                                        <?
                                      }
                                      else 
                                      {
                                        $proxy_id = $orders["proxy_id"];
                                        $proxy_type = $orders["proxy_type"];
                                        
                                        if ($proxy_type==0) 
                                        $sql = "SELECT *FROM proxies WHERE proxy_id=$proxy_id LIMIT 1";
                                        if ($proxy_type==1)
                                        $sql = "SELECT * FROM proxies_public WHERE proxy_id='$proxy_id' LIMIT 1";

                                        $result_proxy =mysqli_query($conn,$sql);
                                        $proxy = mysqli_fetch_array($result_proxy);
                                        ?>
                                          <td><?=substr($proxy["surname"],0,2).".".$proxy["name"];?></td>
                                          <td><?=$proxy["tel"];?></td>
                                          <td><?=$proxy["address"];?></td>
                                        <?
                                      }
                                      ?>
                                      <td><?=$package;?></td>
                                      <td><?=substr($orders["upost_date"],0,10);?></td>
                                      <td><a href="upost?action=history_delete&pk=<?=$orders["upost_pk"];?>"><i class="text-danger" data-feather="delete"></i></a></td>
                                    </tr>
                                    <?
                                  }
                              }
                              else 
                              {
                                ?>
                                <tr><td colspan="8" class="text-center text-danger">Энэ өдөр илгээгээгүй байна</td></tr>
                                <?
                              }
                              ?>
                          </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?
          }
          ?>

          <?
          if ($action =="history_delete")
          {
            if (isset($_GET["pk"])) $upost_pk= $_GET["pk"]; else header("location:upost?action=history");

              $host = "https://2018.upost.mn/api/";
              $url = $host."Login";

              $input_parameter = [
                  "username" => "Gerelt khurekh orgil\\byua",
                  "password" => "789",
                  "progId"=> "1"
              ];            

              $ch = curl_init();

              curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/json'));
              curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
              curl_setopt($ch, CURLOPT_URL,$url);
              curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input_parameter));           
              curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
              $output_detail = curl_exec($ch);
              curl_close($ch);
              $upost_responce = json_decode($output_detail);
              //var_dump($result);

              if ($upost_responce->retType==0) //Aмжилттай нэвтэрлээ.
              {
                  $access_token = $upost_responce->retDesc;
                  
                  ?>
                  <div class="alert alert-success mt-1" role="alert">
                      Нэвтрэлт амжилттай
                  </div>
                  <?
                  $sql = "SELECT *FROM orders WHERE upost_pk='$upost_pk'";
                  $result = mysqli_query($conn,$sql);
                  $total = mysqli_num_rows($result);                  
                  if ($total==1)            
                  {

                      $input_parameter = [
                        "functionID" => "FN6_012",
                        "version" => "1.0",
                        "screenID"=> "MN10008",
                        "progID"=> "MAINWEB"                      
                    ];        

                        $input_parameter["jsonString"]=
                        [
                          "fkpMail"=> $upost_pk
                        ];

                    $authorization = "Authorization: Bearer ".$access_token;
                    $url = $host.'DoExec';
                    //$url = $host."Login";
                    // echo json_encode($input_parameter,JSON_UNESCAPED_UNICODE)."<br>";

                    $ch = curl_init ($url);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8' , $authorization));
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_URL,$url);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input_parameter,JSON_UNESCAPED_UNICODE));           
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                    $output_detail = curl_exec ($ch);
                    curl_close($ch);
                    //echo $output_detail;
                    $upost_responce = json_decode($output_detail);
                    

                    
                    if ($upost_responce->retType==0) //Aмжилттай нэвтэрлээ.
                    {
                      $success_count++;
                      $packages_number = $upost_responce->Table->TotalRows;


                      for ($i = 0; $i<$packages_number;$i++)
                      {
                          $delete_pk = $upost_responce->Table1[$i]->PK;
                          $input_parameter = [
                            "functionID" => "FN6_015",
                            "version" => "1.0",
                            "screenID"=> "MN10008",
                            "progID"=> "MAINWEB"                      
                            ];        
                            
                            $input_parameter["jsonString"]["mData"]["DataRow"] = 
                            [
                              "PK"=> $delete_pk
                            ];

                            $ch = curl_init ($url);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8' , $authorization));
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_URL,$url);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input_parameter,JSON_UNESCAPED_UNICODE));           
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                            //$output_detail = curl_exec ($ch);
                            curl_close($ch);
                      }
                      $input_parameter = [
                      "functionID" => "FN6_003",
                      "version" => "1.0",
                      "screenID"=> "MN10008",
                      "progID"=> "MAINWEB"                      
                      ];        
                      
                      $input_parameter["jsonString"]["mData"]["DataRow"] = 
                      [
                        "PK"=> $upost_pk
                      ];

                      $ch = curl_init ($url);
                      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8' , $authorization));
                      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                      curl_setopt($ch, CURLOPT_URL,$url);
                      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input_parameter,JSON_UNESCAPED_UNICODE));           
                      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                      $output_detail = curl_exec ($ch);
                      curl_close($ch);

                      
                      $upost_responce = json_decode($output_detail);
              
                      if ($upost_responce->retType==0) //Aмжилттай нэвтэрлээ.
                      {
                        ?>
                        <div class="alert alert-success mt-1" role="alert">
                           Амжилттай устгалаа.
                        </div>
                        <?
                        $sql = "UPDATE orders SET upost_pk = NULL WHERE upost_pk='$upost_pk' LIMIT 1";
                        mysqli_query($conn,$sql);
                      }

                      
                  
              }
              else 
              {
                $error = $upost_responce->retDesc;
            
              }      
            }    

            ?>

              
            <?
          
            }
            else 
            {
                $error = $upost_responce->retDesc;
                ?>
                <div class="alert alert-danger mt-1" role="alert">
                    <?=$error;?>
                </div>
                <?
            }             
            
      
          }
          ?>



          <?
          if ($action =="box_submit")
          {
            $sql = "SELECT *FROM boxes WHERE upost_pk IS NULL AND status='onair' ";
            $result = mysqli_query($conn,$sql);
            $total = mysqli_num_rows($result);
            ?>
            <h4 id="default">Богц илгээх</h4>
                <p class="mb-3">onair төлөвтэй богцийг илгээнэ</p>
                <div class="example">
                    <div class="alert alert-primary" role="alert">
                        <b><?=number_format($total);?></b> илгээмжийг илгээхээр хүлээгдэж байна.
                    </div>
                </div>
                <? 
                if ($total>0) 
                    {
                        ?>
                        <a  class="btn btn-success mb-1 mb-md-0" href="upost?action=box_submitting">Илгээх</a>
                        <?
                    }
          }
          ?>

          <?
          if ($action =="box_submitting")
          {
            ?>
            <h4 id="default">Upost илгээх</h4>

            <?
                  $host = "https://2018.upost.mn/api/";
                  $url = $host."Login";

                  $input_parameter = [
                      "username" => "Gerelt khurekh orgil\\byua",
                      "password" => "789",
                      "progId"=> "1"
                  ];            

                  $ch = curl_init();

                  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/json'));
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                  curl_setopt($ch, CURLOPT_URL,$url);
                  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input_parameter));           
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                  $output_detail = curl_exec($ch);
                  curl_close($ch);
                  $upost_responce = json_decode($output_detail);
                  //var_dump($result);

                  if ($upost_responce->retType==0) //Aмжилттай нэвтэрлээ.
                  {
                      $access_token = $upost_responce->retDesc;
                      
                      ?>
                      <div class="alert alert-success mt-1" role="alert">
                          Нэвтрэлт амжилттай
                      </div>
                      <?
                      $sql = "SELECT *FROM boxes WHERE upost_pk IS NULL AND status='onair'";
                      //$sql = "SELECT *FROM orders WHERE barcode='GO211014998MN'";

                      // echo $sql;
                      $result = mysqli_query($conn,$sql);
                      $total = mysqli_num_rows($result);
                      ?>
                          <div class="alert alert-success" role="alert">
                              <b><?=number_format($total);?></b> богц илгээж байна.
                          </div>
                      <?

                      $success_count =0;
                      if ($total>0)            
                      while ($data =  mysqli_fetch_array($result))
                      {
                          $box_id =$data["box_id"];


                          $input_parameter = [
                            "functionID" => "FN6_026",
                            "version" => "1.0",
                            "screenID"=> "MN10008",
                            "progID"=> "MAINWEB"                      
                            ];        

                            $input_parameter["jsonString"]["mData"]["DataRow"]=
                            [
                              "PK"=> -1,
                              "BagDate" => $data["created_date"],
                              "BagNumber"=> $data["name"],
                              "BagWeight"=> 1,
                              "IsRed"=> false,
                              "fkBagRecieverBranch"=> 603,
                              "fkPostTypeForBag"=> 3
                            ];


                          $authorization = "Authorization: Bearer ".$access_token;
                          $url = $host.'DoExec';
                          //$url = $host."Login";
                          // echo json_encode($input_parameter,JSON_UNESCAPED_UNICODE)."<br>";

                          $ch = curl_init ($url);
                          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8' , $authorization));
                          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                          curl_setopt($ch, CURLOPT_URL,$url);
                          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input_parameter,JSON_UNESCAPED_UNICODE));           
                          curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                          $output_detail = curl_exec ($ch);
                          curl_close($ch);
                          // echo $output_detail;
                          $upost_responce = json_decode($output_detail);

                        
                          if ($upost_responce->retType==0) //Aмжилттай нэвтэрлээ.
                          {
                            $success_count++;

                            $input_parameter = [
                              "functionID" => "FN6_029",
                              "version" => "1.0",
                              "screenID"=> "MN10008",
                              "progID"=> "MAINWEB"                      
                              ];        
  
                              $input_parameter["jsonString"]["Paging"]["DataRow"]=
                              [
                                "start"=> 0,
                                "length"=> 1
                              ];
  
  
                            $authorization = "Authorization: Bearer ".$access_token;
                            $url = $host.'DoExec';
                            //$url = $host."Login";
                            // echo json_encode($input_parameter,JSON_UNESCAPED_UNICODE)."<br>";
  
                            $ch = curl_init ($url);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8' , $authorization));
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_URL,$url);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input_parameter,JSON_UNESCAPED_UNICODE));           
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                            $output_detail = curl_exec ($ch);
                            curl_close($ch);
                            //echo $output_detail;
                            $upost_responce = json_decode($output_detail);


                            $pk_id = $upost_responce->retData->Table1[0]->PK;
                            $pk_name = $upost_responce->retData->Table1[0]->BagNumber;
                            if ($data["name"] == $pk_name)
                            {
                              $sql ="UPDATE boxes SET upost_pk='".$pk_id."',upost_date='".date("Y-m-d H:i:s")."' WHERE box_id='$box_id'";
                              mysqli_query($conn,$sql);

                              $sql = "SELECT *FROM boxes_packages WHERE box_id='$box_id'";
                              
                              $result_box = mysqli_query($conn,$sql);
                              while ($box_package = mysqli_fetch_array($result_box))
                              {
                                  $barcode = $box_package["barcode"];
                                  if ($barcode<>"")
                                  {
                                    $input_parameter = [
                                      "functionID" => "FN6_040",
                                      "version" => "1.0",
                                      "screenID"=> "MN10008",
                                      "progID"=> 1                      
                                      ];        
          
                                      $input_parameter["jsonString"]["mData"]["DataRow"]=
                                      [
                                        "fkpMailBag"=> $pk_id,
                                      ];
                                      $input_parameter["jsonString"]["mData"]["DataRow"]["MailId"]=
                                      [
                                        "MailId"=>$barcode
                                      ];

                                      // echo json_encode($input_parameter,JSON_UNESCAPED_UNICODE);

                                      $ch = curl_init ($url);
                                      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8' , $authorization));
                                      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                      curl_setopt($ch, CURLOPT_URL,$url);
                                      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input_parameter,JSON_UNESCAPED_UNICODE));           
                                      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                                      $output_detail = curl_exec ($ch);
                                      curl_close($ch);

                                      // echo $output_detail;
                                  }
                              }
                            }
                          }
                      }
                  }
                  else 
                  {
                    $error = $upost_responce->retDesc;
                
                  }      
                   
          }
          ?>

        <?
          if ($action =="box_history")
          {
            if (isset($_POST["date"])) $date= $_POST["date"]; else $date= date("Y-m-d");
            ?>
            <div class="row">
              <div class="col-md-2 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h6 class="card-title">UPost богц илгээсэн түүх</h6>
                    <form action="upost?action=box_history" method="post">
                      <div class="input-group date datepicker" id="datePickerExample">
                        <span class="input-group-addon"><i data-feather="calendar"></i></span>
                        <input type="text" class="form-control" value="<?=$date;?>" name="date">
                      </div>
                      <input type="submit" value="Хайх" class="btn btn-success btn-block mt-1">
                    </form>
                    <p class="card-description">Тухайн өдөр илгээсэн богцыг харах боломжтой</p>
                    <p class="text-danger italic">Ахин илгээхэд түүх цэвэрлэхээс гадна төлөвийг шинэ төлөвт шилжүүлэх шаардлагатай</p>
                  </div>
                </div>
              </div>
              <div class="col-md-10 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">                                       
                    <div class="table-responsive">
                      <table class="table">
                          <thead>
                            <tr>
                              <th>№</th>
                              <th>Богц нэр</th>
                              <th>Төлөв</th>
                              <th>Ачаа</th>
                              <th>Үүссэн</th>
                              <th>Үйлдэл</th>
                            </tr>
                          </thead>
                          <tbody>
                              <?
                              $count =0;
                              $sql = 
                              "SELECT * FROM boxes 
                                WHERE upost_pk IS NOT NULL AND upost_date LIKE '$date%'";

                              $result = mysqli_query($conn,$sql);
                              if (mysqli_num_rows($result)>0)
                              {
                                  while ($boxes=mysqli_fetch_array($result))
                                  {

                                    ?>
                                    <tr>
                                      <td><?=++$count;?></td>
                                      <td><a href="orders?id=<?=$boxes["id"];?>"><?=$boxes["name"];?></a></td>
                                     
                                      <td><?=$boxes["status"];?></td>
                                      <td><?=$boxes["packages"];?></td>
                                      <td><?=$boxes["packages"];?></td>
                                      <td><?=substr($boxes["upost_date"],0,10);?></td>
                                      <td><a href="upost?action=box_history_delete&box_id=<?=$boxes["box_id"];?>"><i class="text-danger" data-feather="delete"></i></a></td>
                                    </tr>
                                    <?
                                  }
                              }
                              else 
                              {
                                ?>
                                <tr><td colspan="8" class="text-center text-danger">Энэ өдөр илгээгээгүй байна</td></tr>
                                <?
                              }
                              ?>
                          </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?
          }
          ?>

        <?
          if ($action =="box_history_delete")
          {
            if (isset($_GET["box_id"])) $box_id= $_GET["box_id"]; else header("location:upost?action=box_history");

             $sql = "UPDATE boxes SET  upost_pk=NULL WHERE box_id='$box_id'";


              if (mysqli_query($conn,$sql)) 
              {
                $sql = "UPDATE orders SET upost_pk=NULL WHERE order_id IN (SELECT order_id FROM `boxes_packages` WHERE box_id = '$box_id')";
                mysqli_query($conn,$sql)

                  ?>
                  <div class="alert alert-success mt-1" role="alert">
                      Амжилттай устгалаа
                  </div>
                  <?                                      
              }
              else 
              {
                ?>
                  <div class="alert alert-danger mt-1" role="alert">
                      Алдаа гарлаа
                  </div>
                  <?     
            
              }      
            }               
          ?>


        </div>
      <? require_once("views/footer.php");?>
		
		</div>
	</div>

	<!-- core:js -->
	<script src="assets/vendors/core/core.js"></script>
	<!-- endinject -->
  
	<!-- inject:js -->
	<script src="assets/vendors/feather-icons/feather.min.js"></script>
  <script src="assets/js/template.js"></script>
  <script src="assets/vendors/apexcharts/apexcharts.min.js"></script>

  <script src="assets/vendors/chartjs/Chart.min.js"></script>
  <script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
	<script src="assets/js/datepicker.js"></script>

  <script src="assets/js/data-table.js"></script>
  <script src="assets/js/jquery.chained.min.js"></script>
  <script src="assets/js/dashboard.js"></script>
  <script src="assets/js/apexcharts.js"></script>

  <script>
    $(document).ready(function() {
      $("#district").chained("#city");
    })
  </script>


	<!-- endinject -->

</body>
</html>    