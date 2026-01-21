<?php
    require_once("config.php");
    require_once("views/helper.php");
    require_once("views/login_check.php");
    require_once("views/init.php");
?>

<link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<body class="sidebar-dark">
	<div class="main-wrapper">
    <?php  require_once("views/navbar.php"); ?>
	
		<div class="page-wrapper">
      <?php  require_once("views/sidebar.php"); ?>
			

			<div class="page-content">

        <!------------------------------------------------------------------------------------->
        
          <!--label class="section-title">Basic Responsive DataTable</label>
          <p class="mg-b-20 mg-sm-b-40">Searching, ordering and paging goodness will be immediately added to the table, as shown in this example.</p-->
          <?php
          if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="initiate";
          $action_title = "";
          switch ($action)
          {
            case "initiate": $action_title="Гардуулалт хийх";break;
            case "select": $action_title="Гардуулалт хийх";break;
            case "delivering": $action_title="Гардуулалт хийх";break;
            case "container": $action_title="Газрын ачаа гардуулалт";break;
            case "select_container": $action_title="Газрын ачаа гардуулалт";break;
            case "delivering_container": $action_title="Газрын ачаа гардуулалт";break;
            case "reverse": $action_title="Буцаалт";break;
            case "reversing": $action_title="Буцаалт";break;
            case "later_pay": $action_title="Дараа тооцоог төлөх";break;
            case "later_paid": $action_title="Дараа тооцоог төлөх";break;
            case "later_transaction": $action_title="Дараа тооцоог тулгах";break;                               
            case "delivered": $action_title="Гардуулсан илгээмж";break;
            default: $action_title="Гардуулалт";break;
          }
          ?>
          <style>
            .page-breadcrumb {
              display: flex;
              justify-content: center;
              align-items: center;
              width: 100%;
            }
            .page-breadcrumb .breadcrumb {
              display: inline-flex;
              margin: 0;
            }
            .page-breadcrumb .breadcrumb-item.active {
              color: #2563eb !important;
              font-weight: bold !important;
              font-size: 16px;
            }
          </style>
          <nav class="page-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">
                <?php 
                if ($action == "initiate" || $action == "select" || $action == "delivering") {
                  echo "ИЛГЭЭМЖ ГАРДУУЛАЛТ";
                } elseif ($action == "tel") {
                  echo "Утсаар хайх";
                } else {
                  echo $action_title;
                }
                ?>
              </li>
            </ol>
          </nav>

          <?php
          if ($action == "initiate")
          {
            ?>
            <div class="card">
              <div class="card-body">
                <div class="card-title">Олголт</div>
                <form action="?action=select" method="POST">
                    <textarea name='deliver' style="min-height:200px;" autofocus='autofocus' required='required' class='form-control mb-3'></textarea>
                    <div id="result"></div>
                    <button type="submit" class="btn btn-success">Олголт</button>
                </form>
              </div>
            </div>

            <?php

          }

          if ($action == "tel")
          {
            ?>
            <div class="card">
              <div class="card-body">
                <div class="card-title">Олголт</div>
                  <div class="alert alert-warning" role="alert">
                  Хүлээн авагчийн утасны дугаар оруулах.
                  </div>
                <form action="?action=select" method="POST">
                  <input type="text" name="tel" class="form-control" placeholder="99123456" autofocus>                
                    <div id="result"></div>
                    <button type="submit" class="btn btn-success">Олголт</button>
                </form>
              </div>
            </div>

            <?php

          }


          if ($action == "container")
          {
            ?>
            <div class="card">
              <div class="card-body">
                <div class="card-title">Чингэлэгийн гардуулалт
                </div>
                  <div class="alert alert-warning" role="alert">
                  Хүлээн авагчийн утасны дугаар оруулах.
                  </div>
                <form action="?action=select_container" method="POST">
                  <input type="text" name="tel" class="form-control" placeholder="99123456" autofocus>                
                    <div id="result"></div>
                    <button type="submit" class="btn btn-success">гардуулалт</button>
                </form>
              </div>
            </div>

            <?php

          }

          if ($action == "select_container")
          {
            ?>
            <div class="panel panel-primary">
              <div class="panel-heading">Чингэлэгийн гардуулалт</div>
              <div class="panel-body">
              <?php 
              $count=0;

              if (isset($_POST["tel"]))
              {
                $tel = $_POST["tel"];
                $result=mysqli_query($conn,"SELECT * FROM customer WHERE tel='$tel' LIMIT 1");
                  if (mysqli_num_rows($result)==1)
                    {
                      $data=mysqli_fetch_array($result);
                      $customer_id = $data["customer_id"];
                      echo "Хүлээн авагч:".customer($customer_id,"name")."<br>";
                      echo "Утас:".customer($customer_id,"tel")."<br>";
                      echo "РД:".customer($customer_id,"rd")."<br>";

                      ?>
                      <form action="?action=delivering_container" method="post">
                            <h3>Хүлээн авагч</h3>
                            <table class='table table-hover'>
                            <tr><td>Утас:(*)</td><td><input type="text" name="contacts" class="form-control"></td></tr>
                            <tr><td colspan='2'><span id='result' class='alert alert-danger alert-small' role='alert'></span></td></tr>
                            <tr><td>Нэр(*)</td><td><input type="text" name="name" class="form-control"></td></tr>
                            <tr><td>Овог</td><td><input type="text" name="surname" class="form-control"></td></tr>
                            <tr><td>РД</td><td><input type="text" name="rd" class="form-control"></td></tr>
                            <tr><td>И-мейл(*)</td><td><input type="text" name="email" class="form-control"></td></tr>
                            <tr><td>Хаяг(*)</td><td><textarea  name="address" class="form-control"></textarea></td></tr>
                            </table>
                            
                            <h3>Төлбөр төлөх дүн</h3>
                            <input type="text" name="count" placeholder="Ачааны тоо ширхэг"  class="form-control"><br>
                            <table>
                              <tr>
                                <td>
                                  <input type="text" name="cash_value" id="cash_value" placeholder="Бэлэн" value="" class="form-control">
                                </td>
                                <td>
                                  <input type="text" name="pos_value" id="pos_value" placeholder="Картаар"  value="" class="form-control">
                                </td>
                                <td>
                                  <input type="text" name="account_value" id="account_value" placeholder="Данс"  value="" class="form-control">     		
                                </td>
                                <td>
                                  <input type="text" name="later_value" id="later_value" placeholder="Дараа"  value="" class="form-control">     		
                                </td>
                              </tr>
                            </table>
                          
                          <br>      
                          <button type="submit" class="btn btn-primary">Гүйцэтгэх</button>
                      </form>
                      <?php                      
                    }
                    else 
					          echo "Хэрэглэгч олдсонгүй.";
              }
              else echo "Утасны дугаар өгөөгүй.";
	
          }

          if ($action == "delivering_container")
          {
            $contacts = $_POST["contacts"];
            $name = $_POST["name"];
            $surname = $_POST["surname"];
            $rd = $_POST["rd"];
            $email = $_POST["email"];
            $address = $_POST["address"];
            $count = $_POST["count"];
            
            
            //$method = $_POST["method"];
            
            $error=TRUE;
            if ($contacts!=""&&$name!="")
              {	
                $query_deliver = mysqli_query($conn,'SELECT * FROM customer WHERE tel="'.$contacts.'"');
                if(mysqli_num_rows($query_deliver)==1)
                  {
                    $data = array(
                       'name'=>$name,
                       'surname'=>$surname,
                       'rd'=>$rd,
                       'email'=>$email,
                       'address'=>$address,
                          );
                    if (mysqli_query($conn,"UPDATE customer SET name='$name',surname='$surname',rd='$rd',email='$email',address='$address' WHERE tel='$contacts'"))
                    {
                      $data = mysqli_fetch_array(mysqli_query($conn,"SELECT customer_id FROM customer WHERE tel='$contacts'"));                      
                      $deliver_id=$data["customer_id"];
                    }
                    else $error=FALSE;
                  }


                else 
                  { 
                    if (mysqli_query($conn,"INSERT INTO customer (name,tel,surname,rd,email,address,username,password,status) VALUES 
                    ('$name','$contacts','$surname','$rd','$email','$address','$contacts','$contacts','regular')")) //RECEIVER NOT FOUND IN RECORD SO INSERT INTO DB                      
                      $deliver_id=mysqli_insert_id ($conn);
                      else  $error=FALSE;
                  }	
          
                $account = $_POST["account_value"];$pos = $_POST["pos_value"];$cash=$_POST["cash_value"];$later=$_POST["later_value"];
                $total = floatval($account)+floatval($pos)+floatval($cash)+floatval($later);
          
                $sql = "INSERT INTO bills_container (`timestamp`,deliver,count,cash,account,pos,later,total) VALUES('".date("Y-m-d H:i:s")."',$deliver_id,'$count','$cash','$account','$pos','$later','$total')";
                mysqli_query($conn,$sql);
                echo "Амжилттай гардууллаа.";
              }
          }

          if ($action == "select")
          {

            if (isset($_POST["deliver"]))
            {
              $deliver = $_POST["deliver"];
              $deliver_array=explode("\r\n",$deliver);
              $deliver_array =array_unique ($deliver_array);
            }

            if (isset($_POST["tel"]))
            {
              $tel = protect($_POST["tel"]);
              $tel = trim($tel);
            }
            ?>

            <form action="?action=delivering" method="post">

              <div class="card">
                <div class="card-body">

                  <table class="table table-hover">
                    <tr>
                      <th><input type="checkbox" name="select_all" title="Select all orders" checked="checked" weight="0" advance="0" admin_value="0"></th>
                      <th>№</th>
                      <th>Илгээгч</th>
                      <th>Х/а утас</th> 
                      <th class='track_td'>Barcode/Track</th> 
                      <th>Хоног</th>
                      <th>Төлөв</th> 
                      <th>Жин</th> 
                      <th>Тооцоо /$/</th> 
                      <th>Админ тооцоо</th>
                      <th>BRANCH</th>
                      <th></th>
                    </tr>

                      <?php

                        


                        $count=1;$total_weight=0;$total_weight_branch=0;$total_advance=0; $grand_total=0; $total_admin_value=0;
                        if (isset($deliver))
                        {
                            foreach($deliver_array as $deliver_barcode)
                            {
                              
                              if ($deliver_barcode!="")
                                {
                                    $sql = "SELECT * FROM box_combine WHERE barcode='$deliver_barcode' LIMIT 1";
                                    $result = mysqli_query($conn,$sql);
                                    if (mysqli_num_rows($result)==0)
                                    //if (substr($deliver_barcode,0,3)=="GO1" || substr($deliver_barcode,0,4)!="GO2") //SINGLE BARCODE
                                    {
                                      $sql="SELECT * FROM orders WHERE (barcode='$deliver_barcode' OR third_party='$deliver_barcode') AND status NOT IN('delivered') LIMIT 1";
                                      $result = mysqli_query($conn,$sql);
                                      if (mysqli_num_rows($result)==1)
                                        {
                                          $data=mysqli_fetch_array($result);
                                          $order_id=$data["order_id"];
                                          $created_date=$data["created_date"];
                                          $sender=$data["sender"];
                                          $receiver=$data["receiver"];
                                          $barcode=$data["barcode"];
                                          $track=$data["third_party"];
                                          $weight=$data["weight"];
                                          $advance=$data["advance"];
                                          $advance_value=floatval($data["advance_value"]);
                                          $extra=$data["extra"];
                                          $status=$data["status"];
                                          $admin_value=$data["admin_value"];
                                          $proxy=$data["proxy_id"];
                                          $proxy_type=$data["proxy_type"];
                                          //$price=$weight*cfg_paymentrate();
                                          $is_online=$data["is_online"];
                                          $is_branch=$data["is_branch"];
                                          $Package_advance = $data["advance"];
                                          $Package_advance_value =$data["advance_value"];
                                          $tr=0;
                                          if($status=="warehouse"&&$extra!="") 
                                          $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status;
                                          if ($Package_advance==1&&$is_online==0)
                                          {echo "<tr class='red' title='Үлдэгдэлтэй илгээмж:".$Package_advance_value."$' alt='order'>"; $tr=1;}
                                          
                                          if ($Package_advance==0&&$is_online==0&&$tr==0)
                                          {echo "<tr class='green' title='Илгээмжийг шууд олго төлбөргүй' alt='order'>"; $tr=1;}
                                        
                                          if (!$tr) echo "<tr>";else $tr=0;
                                          
                                          ?>
                                          
                                          <td><input type="checkbox" name="orders[]" checked="checked" weight="<?php echo $weight;?>" package_advance="<?php echo $Package_advance;?>"  advance="<?php echo $advance_value;?>" admin_value="<?php echo $admin_value;?>" value="<?php echo $order_id;?>" <?php echo ($is_branch==1)?'is_branch="D"':'is_branch=""';?> <?php echo ($is_online==1)?'is_online="1"':'is_online="0"';?>></td>                                                
                                          <td><?php echo $count++;?></td>
                                          <td><a href="customers?action=detail&id=<?php echo $sender;?>"><?php echo substr(customer($sender,"surname"),0,2).".".customer($sender,"name");?></a></td>
                                          <td><a href="customers?action=detail&id=<?php echo $receiver;?>"><?php echo substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name");?></a><br>
                                          <?php echo customer($receiver,"tel");?>
                                          <br><?php echo proxy2($proxy,$proxy_type,"name");?></td>
                                    
                                    
                                          <td class='track_td'>
                                          <?php
                                            barcode_comfort($barcode);
                                            if ($is_branch) echo '<span class="badge badge-success round">DE</span>';
                                            echo "<br>"; 
                                            echo $track;
                                            
                                            ?>
                                          </td>
                                          <td><?php echo intval(days($created_date));?></td>
                                          <td><?php echo $temp_status;?></td>
                                          <td><?php echo $weight;?></td>                            
                                          
                                          <td>
                                            <?php if ($is_online==0) echo $Package_advance_value; ?>
                                          </td> 
                                          
                                          <td>
                                          <?php if ($admin_value!=0) echo $admin_value; ?>
                                          </td>

                                          <td>
                                          <?php if ($is_branch) echo "D"; ?>
                                          </td> 
                                    
                                          <td><a href="tracks?action=detail&id=<?php echo $order_id;?>"><span class="glyphicon glyphicon-edit"></span></a></td>
                                          </tr>

                                          <?php
                                    
                                          if ($is_online==1) 
                                          {
                                            if ($is_branch)
                                            $total_weight_branch+=floatval($weight);
                                            else  
                                            $total_weight+=floatval($weight);
                                          }
                                    
                                          $total_admin_value+=$admin_value;
                                    
                                          if ($is_online==0 && $Package_advance==1)
                                          $total_advance+=floatval($Package_advance_value);
                                          
                                          $grand_total = cfg_price($total_weight) + cfg_price_branch($total_weight_branch);                  

                                          //if ($is_online==1) $grand_total+=cfg_price($weight); else $grand_total+=$Package_advance_value;
                                        
                                        
                                        }
                                    }
                                    else 
                                    //if (substr($deliver_barcode,2,1)=="2") //COMBINE BARCODE
                                    {

                                      $sql="SELECT * FROM box_combine WHERE barcode='$deliver_barcode'  AND `status` NOT IN ('delivered')";
                                      //echo $sql;
                                      $query = mysqli_query($conn,$sql);
                                      if (mysqli_num_rows($result) == 1)
                                      {
                                        $data=mysqli_fetch_array($result);
                                        $barcodes = $data["barcodes"];
                                        foreach(explode(",",$barcodes) as $barcode_single)
                                        {
                                          //echo $barcode_single."<br>";

                                        if ($barcode_single!="")
                                          {
                                            $result_single  = mysqli_query($conn,"SELECT * FROM orders WHERE barcode = '$barcode_single' AND `status` NOT IN ('delivered')");	
                                            //echo "SELECT * FROM orders WHERE barcode = '$barcode_single' AND `status` NOT IN ('delivered')";				
                                            while ($data_single = mysqli_fetch_array($result_single))
                                              {
                                                //echo $data_single["barcode."----<br>";
                                                $order_id=$data_single["order_id"];
                                                $created_date=$data_single["created_date"];
                                                $sender=$data_single["sender"];
                                                $receiver=$data_single["receiver"];
                                                $barcode=$data_single["barcode"];
                                                $track=$data_single["third_party"];
                                                $weight=$data_single["weight"];
                                                $advance=$data_single["advance"];
                                                $advance_value=$data_single["advance_value"];
                                                $extra=$data_single["extra"];
                                                $status=$data_single["status"];
                                                $admin_value=$data_single["admin_value"];
                                                $proxy=$data_single["proxy_id"];
                                                $proxy_type=$data_single["proxy_type"];
                                                //$price=$weight*cfg_paymentrate();
                                                $is_online=$data_single["is_online"];
                                                $Package_advance = $data_single["advance"];
                                                $Package_advance_value =$data_single["advance_value"];
                                                $tr=0;
                                                if($status=="warehouse"&&$extra!="") 
                                                $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status;
                                                if ($Package_advance==1&&$is_online==0)
                                                {echo "<tr class='red' title='Үлдэгдэлтэй илгээмж:".$Package_advance_value."$' alt='order'>"; $tr=1;}
                                                
                                                if ($Package_advance==0&&$is_online==0&&$tr==0)
                                                {echo "<tr class='green' title='Илгээмжийг шууд олго төлбөргүй' alt='order'>"; $tr=1;}
                                              
                                                if (!$tr) echo "<tr>";else $tr=0;
                                            
                                            
                                                ?>
                                                <td><input type="checkbox" name="orders[]" checked="checked" weight="<?php echo $weight;?>" package_advance="<?php echo $Package_advance;?>"  advance="<?php echo $advance_value;?>" admin_value="<?php echo $admin_value;?>" value="<?php echo $order_id;?>" <?php echo ($is_branch==1)?'is_branch="D"':'is_branch=""';?> <?php echo ($is_online==1)?'is_online="1"':'is_online="0"';?>></td>                                                
                                                <td><?php echo $count++;?></td>
                                                <td><a href="customers?action=detail&id=<?php echo $sender;?>"><?php echo substr(customer($sender,"surname"),0,2).".".customer($sender,"name");?></a></td>
                                                <td><a href="customers?action=detail&id=<?php echo $receiver;?>"><?php echo substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name");?></a><br>
                                                <?php echo customer($receiver,"tel");?>
                                                <br><?php echo proxy2($proxy,$proxy_type,"name");?></td>
                                          
                                          
                                                <td class='track_td'>
                                                <?php
                                                  barcode_comfort($barcode);
                                                  if ($is_branch) echo '<span class="badge badge-success">DE</span>';
                                                  echo "<br>"; 
                                                  echo $track;
                                                  
                                                  ?>
                                                </td>
                                                <td><?php echo intval(days($created_date));?></td>
                                                <td><?php echo $temp_status;?></td>
                                                <td><?php echo $weight;?></td>                            
                                                
                                                <td>
                                                  <?php if ($is_online==0) echo $Package_advance_value; ?>
                                                </td> 
                                                
                                                <td>
                                                <?php if ($admin_value!=0) echo $admin_value; ?>
                                                </td>

                                                <td>
                                                <?php if ($is_branch) echo "D"; ?>
                                                </td> 
                                          
                                                <td><a href="tracks?action=detail&id=<?php echo $order_id;?>"><span class="glyphicon glyphicon-edit"></span></a></td>
                                                </tr>

                                                <?php
                                          
                                                if ($is_online==1) $total_weight+=$weight;
                                          
                                                $total_admin_value+=$admin_value;
                                          
                                                if ($is_online==0&&$Package_advance==1)
                                                $total_advance+=floatval($Package_advance_value);
                                          
                                                //if ($is_online==1) $grand_total+=cfg_price($weight); else $grand_total+=$Package_advance_value;
                                          
                                          
                                              }
                                          }
                                          
                                          
                                        }
                                      }
                                    }
                                }
                            }


                            
                            $grand_total = cfg_price($total_weight) + cfg_price_branch($total_weight_branch);                  

                            echo "<tr class='total'><td colspan='5'>Нийт жин (Kg)</td><td colspan='5'>";
                            echo "<input type='text' class='form-control' id='total_weight' value='".number_format($total_weight+$total_weight_branch,2)."' readonly='readonly' name='total_weight'></td></tr>";
                            
                            echo "<tr class='total'><td colspan='5'>Delaware нийт жин (Kg)</td><td colspan='5'>";
                            echo "<input type='text' class='form-control' id='total_weight_branch' value='".number_format($total_weight_branch,2)."' readonly='readonly' name='total_weight_branch'></td></tr>";

                            echo "<tr class='total'><td colspan='5'>Төлбөртэй илгээмж($)</td><td colspan='5'>";
                            echo "<input type='text' class='form-control' id='total_advance' value='".number_format($total_advance,2)."' readonly='readonly' name='total_advance'></td></tr>";
                            
                            echo "<tr class='total'><td colspan='5'>Дараа тооцоо ($) /Хашбал/</td><td colspan='5'>";
                            echo "<input type='text' class='form-control' id='total_admin' value='".number_format($total_admin_value,2)."' readonly='readonly' name='total_advance'></td></tr>";
                            
                            echo "<tr class='total'><td colspan='5'>Нийт төлбөр зохих ($)</td><td colspan='5'>";
                            echo "<input type='text' class='form-control' id='grand_total' value='".number_format($grand_total+$total_advance+$total_admin_value,2)."' readonly='readonly' name='grand_total'></td></tr>";
                            
                            echo "<tr class='total'><td colspan='5'>Нийт төлбөр зохих (₮)</td><td colspan='5'>";
                            echo "<input type='text' class='form-control' id='grand_total_tug' value='".($grand_total+$total_admin_value)*cfg_rate()."₮' readonly='readonly' name='grand_total_tug'></td></tr>";
                        }

                        if (isset($tel) && $tel != "")
                        {
                            $tel_escaped = mysqli_real_escape_string($conn, $tel);
                            $sql="SELECT orders.*,orders.status AS realstatus FROM orders LEFT JOIN customer ON orders.receiver=customer.customer_id WHERE customer.tel='$tel_escaped' AND orders.status NOT IN('delivered','weight_missing') ORDER BY status,extra";
                            // echo $sql;
                            $result = mysqli_query($conn,$sql);
                            
                            while ($data = mysqli_fetch_array($result))
                              {
                                  $order_id=$data["order_id"];
                                  $created_date=$data["created_date"];
                                  $sender=$data["sender"];
                                  $receiver=$data["receiver"];
                                  $barcode=$data["barcode"];
                                  $track=$data["third_party"];
                                  $weight=floatval($data["weight"]);
                                  $advance=$data["advance"];
                                  $advance_value=floatval($data["advance_value"]);
                                  $status=$data["realstatus"];
                                  $extra=$data["extra"];
                                  $proxy=$data["proxy_id"];
                                  $proxy_type=$data["proxy_type"];
                                  //$price=$weight*cfg_paymentrate();
                                  $is_online=$data["is_online"];
                                  $is_branch=$data["is_branch"];
                                  $Package_advance = intval($data["advance"]); // Төлбөртэй эсэхийг тодорхойлох
                                  $Package_advance_value = floatval($data["advance_value"]); // Төлбөрийн дүн
                                  $admin_value = floatval($data["admin_value"]);
                                  $tr=0;
                                  if($status=="warehouse"&&$extra!="") 
                                  $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status;
                                  // Төлбөртэй илгээмжийг ягаан өнгөөр харуулах
                                  if ($Package_advance==1 && $is_online==0 && $tr==0)
                                  {echo "<tr class='red' title='Үлдэгдэлтэй илгээмж:".$Package_advance_value."$'>"; $tr=1;}
                            
                                  // Төлбөргүй илгээмжийг ногоон өнгөөр харуулах
                                  if ($Package_advance==0 && $is_online==0 && $tr==0)
                                  {echo "<tr class='green' title='Илгээмжийг шууд олго төлбөргүй'>"; $tr=1;}
                                  if (!$tr) echo "<tr>";else $tr=0;
                            
                                  
                                    ?>
                                    <td><input type="checkbox" name="orders[]" checked="checked" weight="<?php echo $weight;?>" package_advance="<?php echo $Package_advance;?>"  advance="<?php echo $advance_value;?>" admin_value="<?php echo $admin_value;?>" value="<?php echo $order_id;?>" <?php echo ($is_branch==1)?'is_branch="D"':'is_branch=""';?> <?php echo ($is_online==1)?'is_online="1"':'is_online="0"';?>></td>                                                                                    
                                    <td><?php echo $count++;?></td>
                                    <td><a href="customers?action=detail&id=<?php echo $sender;?>"><?php echo substr(customer($sender,"surname"),0,2).".".customer($sender,"name");?></a></td>
                                    <td><a href="customers?action=detail&id=<?php echo $receiver;?>"><?php echo substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name");?></a><br>
                                    <?php echo customer($receiver,"tel");?>
                                    <br><?php echo proxy2($proxy,$proxy_type,"name");?></td>
                              
                              
                                    <td class='track_td'>
                                    <?php
                                      barcode_comfort($barcode);
                                      if ($is_branch) echo '<span class="badge badge-success">DE</span>';
                                      echo "<br>"; 
                                      echo $track;
                                      
                                      ?>
                                    </td>
                                    <td><?php echo intval(days($created_date));?></td>
                                    <td><?php echo $temp_status;?></td>
                                    <td><?php echo $weight;?></td>                            
                                    
                                    <td>
                                      <?php if ($is_online==0) echo $Package_advance_value; ?>
                                    </td> 
                                    
                                    <td>
                                    <?php if ($admin_value!=0) echo $admin_value; ?>
                                    </td>

                                    <td>
                                    <?php if ($is_branch) echo "D"; ?>
                                    </td> 
                              
                                    <td><a href="tracks?action=detail&id=<?php echo $order_id;?>"><span class="glyphicon glyphicon-edit"></span></a></td>
                                    </tr>
                                    <?php
                              
                              
                              
                                if ($is_online==1) 
                                {
                                    if ($is_branch)
                                    $total_weight_branch+=$weight;
                                    else  
                                    $total_weight+=$weight;
                                }

                                if ($is_online==0&&$Package_advance==1)
                                $total_advance+=floatval($Package_advance_value);
                                $total_admin_value+=$admin_value;
                                //if ($is_online==1) $grand_total+=cfg_price($weight); else $grand_total+=$Package_advance_value;
                              }
                            // if ($total_advance==0) 		
                            $grand_total = cfg_price($total_weight) + cfg_price_branch($total_weight_branch);                  
                            // else $grand_total =$total_advance;


                              echo "<tr class='total'><td colspan='5'>Нийт жин (Kg)</td><td colspan='6'>";
                              echo "<input type='text' class='form-control' id='total_weight' value='".number_format($total_weight+$total_weight_branch,2)."' readonly='readonly' name='total_weight'></td></tr>";
                            
                              echo "<tr class='total'><td colspan='5'>Delaware (Kg)</td><td colspan='6'>";
                              echo "<input type='text' class='form-control' id='total_weight_branch' value='".number_format($total_weight_branch,2)."' readonly='readonly' name='total_weight_branch'></td></tr>";
                            
                              
                              echo "<tr class='total'><td colspan='5'>Төлбөртэй илгээмж($)</td><td colspan='6'>";
                              echo "<input type='text' class='form-control' id='total_advance' value='".number_format($total_advance,2)."' readonly='readonly' name='total_advance'></td></tr>";
                              
                              echo "<tr class='total'><td colspan='5'>Дараа тооцоо ($) /Хашбал/</td><td colspan='6'>";
                              echo "<input type='text' class='form-control' id='total_admin' value='".number_format($total_admin_value,2)."' readonly='readonly' name='total_advance'></td></tr>";
                              
                              echo "<tr class='total'><td colspan='5'>Нийт төлбөр зохих ($)</td><td colspan='6'>";
                              echo "<input type='text' class='form-control' id='grand_total' value='".number_format($grand_total+$total_admin_value+$total_advance,2)."' readonly='readonly' name='grand_total'></td></tr>";
                              echo "<tr class='total'><td colspan='5'>Нийт төлбөр зохих (₮)</td><td colspan='6'>";
                              echo "<input type='text' class='form-control' id='grand_total_tug' value='".($grand_total+$total_admin_value)*cfg_rate()."₮' readonly='readonly' name='grand_total_tug'></td></tr>";

                        }

                      ?>
                  </table>
                </div>
              </div>
              
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="exampleModalLabel">Тооцоо бодох</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                              <label for="recipient-name" class="control-label">Тооцоо /КГ/ </label>
                              <input type="text" class="form-control" id="total_weight_inmodal" readonly="readonly" value="<?php echo $total_weight;?>">
                            </div>
                            
                            <div class="form-group">
                              <label for="recipient-name" class="control-label">Тооцоо /USD/ </label>
                              <input type="text" class="form-control" id="grand_total_inmodal" readonly="readonly"  value="<?php echo $grand_total;?>">
                            </div>
                            
                            <div class="form-group">
                              <label for="recipient-name" class="control-label">Дараа тооцоо /USD/ </label>
                              <input type="text" class="form-control" id="total_admin_inmodal" readonly="readonly"  value="<?php echo $total_advance;?>">
                            </div>
                            
                            
                            <div class="form-group">
                              <label for="recipient-name" class="control-label">Тооцоо /Төг/ </label>
                              <input type="text" class="form-control" id="grand_total_inmodal_tug" readonly="readonly"  value="<?php echo ($grand_total+$total_admin_value)*cfg_rate();?>">
                              <!-- Hidden input to send tugrik amount to form -->
                              <input type="hidden" name="grand_total_tug" id="grand_total_tug_hidden" value="<?php echo ($grand_total+$total_admin_value)*cfg_rate();?>">
                            </div>
                            
                            <div class="form-group">
                              <label for="message-text" class="control-label">Арга</label>
                              
                              <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary active ">
                                  <input type="radio" name="method" id="option1" autocomplete="off" checked value="cash"> Бэлэн 
                                </label>
                                <label class="btn btn-primary ">
                                  <input type="radio" name="method" id="option2" autocomplete="off" value="pos"> POS машинаар
                                </label>
                                <label class="btn btn-primary ">
                                  <input type="radio" name="method" id="option3" autocomplete="off" value="account"> Дансаар
                                </label>
                                <label class="btn btn-primary ">
                                  <input type="radio" name="method" id="option4" autocomplete="off" value="later"> Дараа тооцоо
                                </label>
                                <label class="btn btn-primary ">
                                  <input type="radio" name="method" id="option5" autocomplete="off" value="mix"> Холимог
                                </label>
                              </div>
                            </div>

                            <input type="text" name="cash_value" id="cash_value" placeholder="Бэлэн" value="">
                            <input type="text" name="pos_value" id="pos_value" placeholder="Картаар"  value="">
                            <input type="text" name="account_value" id="account_value" placeholder="Данс"  value="">          
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Гүйцэтгэх</button>
                        </div>


                      </div>
                    </div>
                </div>
                      
                      
                  
                <div class="card mt-3">
                  <div class="card-body">
                    <div class="card-title">Гардаж авж буй хүн</div>
                    <?php
                    if ($count>1) {
                      echo "<table class='table table-hover'>";
                      
                      echo "<tr><td>Утас:(*)</td><td><input type='text' name='contacts' class='form-control' required=''></td></tr>";
                      echo "<tr><td colspan='2'><span id='result' class='alert alert-danger alert-small' role='alert'></span></td></tr>";
                      echo "<tr><td>Нэр(*)</td><td><input type='text' name='name' class='form-control'></td></tr>";
                      echo "<tr><td>Овог</td><td><input type='text' name='surname' class='form-control'></td></tr>";
                      echo "<tr><td>РД</td><td><input type='text' name='rd' class='form-control'></td></tr>";
                      echo "<tr><td>И-мейл(*)</td><td><input type='text' name='email' class='form-control'></td></tr>";
                    echo "<tr><td>Хаяг(*)</td><td><textarea name='address' class='form-control' readonly='readonly'></textarea></td></tr>";

                    echo "<tr><td>Хот, аймаг</td><td>";
                    ?>
                      <select name="city" class="form-control" id="city">
                      <?php
                      $sql =  "SELECT * FROM city";
                      $result_cities = mysqli_query($conn,$sql);
                      while ($data_cities = mysqli_fetch_array($result_cities))
                      {
                        ?>
                        <option value="<?php echo $data_cities["id"];?>"><?php echo $data_cities["name"];?></option>
                        <?php
                      }
                      ?>
                      </select>
                    <?php
                    echo "</td></tr>";
                    echo "<tr><td>Дүүрэг, сум</td><td>";
                    ?>
                      <select name="district" class="form-control" id="district">
                      <?php
                      $sql =  "SELECT * FROM district";
                      $result_districts = mysqli_query($conn,$sql);
                      while ($data_districts = mysqli_fetch_array($result_districts))
                      {
                        ?>
                          <option value="<?php echo $data_districts["id"];?>" data-chained="<?php echo $data_districts["city_id"];?>"><?php echo $data_districts["name"];?></option>
                        <?php
                      }          
                      ?>
                      </select>
                    <?php
                    echo "</td></tr>";

                    echo "<tr><td>Баг, хороо</td><td><input type='text' name='khoroo' class='form-control'></td></tr>";
                    echo "<tr><td>Байр, гудамж</td><td><input type='text' name='build' class='form-control'></td></tr>";



                      echo "</table>";
                    //if(mysqli_num_rows($result)>0) echo form_submit("Олгох","Олгох",array("class"=>"btn btn-success"));

                    
                      echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Тооцоо бодох</button>';
                      ?>
                      </form>
                      <?php
                    }
                    // if ($count==1) header("location:deliver");

                    ?>
                  </div>
                </div>

                          
                         
              <?php
          }

          if ($action == "delivering")
          {
            ?>
            <div class="card">
              <div class="card-body">
                <div class="card-title">Гардуулалт</div>
                  <?php 

                  //DELIVER costumer

                    
                    $contacts = isset($_POST["contacts"]) ? $_POST["contacts"] : "";
                    $name = isset($_POST["name"]) ? $_POST["name"] : "";
                    $surname = isset($_POST["surname"]) ? $_POST["surname"] : "";
                    $rd = isset($_POST["rd"]) ? $_POST["rd"] : "";
                    $email = isset($_POST["email"]) ? $_POST["email"] : "";
                    $address = isset($_POST["address"]) ? $_POST["address"] : "";

                    $city = isset($_POST["city"]) ? $_POST["city"] : "";
                    $district = isset($_POST["district"]) ? $_POST["district"] : "";
                    $khoroo = isset($_POST["khoroo"]) ? $_POST["khoroo"] : "";
                    $build = isset($_POST["build"]) ? $_POST["build"] : "";

                    
                    
                    $method = $_POST["method"];
                    


                    $error=TRUE;
                    $deliver_id =0;

                    $barcodes=array();

                    // var_dump($_POST['orders']);

                    if ($contacts!=""&&$name!="")
                      {	
                        $result_deliver = mysqli_query($conn,'SELECT * FROM customer WHERE tel="'.$contacts.'"');
                        if(mysqli_num_rows($result_deliver)==1)
                          {
                            if (mysqli_query($conn,"UPDATE customer SET name='$name',surname='$surname',rd='$rd',email='$email',address='$address',address_city='$city',address_district='$district',address_khoroo='$khoroo',address_build='$build' WHERE tel='$contacts'"))
                              {
                                $data_deliver = mysqli_fetch_array($result_deliver);
                                $deliver_id=$data_deliver["customer_id"];
                              }
                              else $error=FALSE;
                          }
                          else 
                          {
                            if (mysqli_query($conn,"INSERT INTO customer (name,tel,surname,rd,email,address,address_city,address_district,address_khoroo,address_build,username,password,status) 
                            VALUES ('$name','$contacts','$surname','$rd','$email','$address','$city','$district','$khoroo','$build','$contacts','$contacts','regular')"))                                               
                              $deliver_id=mysqli_insert_id($conn);
                              else  $error=FALSE;
                          }	


                      if(isset($_POST['orders'])) 
                      {
                        $orders=$_POST['orders'];$N = count($orders);
                        $total_advance_for_bill = 0; // Төлбөртэй илгээмжүүдийн дүнг цуглуулах
                        $old_statuses = array(); // Хуучин статусуудыг хадгалах массив (barcode => old_status)
                        $old_locations = array(); // Хуучин байршил/модулийг хадгалах массив (barcode => location/module)
                        
                          for($i=0; $i < $N; $i++)
                          {
                            $order_id=$orders[$i];
                            $sql="SELECT * FROM orders WHERE order_id='$order_id' LIMIT 1";
                            $result = mysqli_query($conn,$sql);
                            if (mysqli_num_rows($result)==1)
                            	{
                                $data=mysqli_fetch_array($result);
                                $proxy_id = $data["proxy_id"];
                                $proxy_type = $data["proxy_type"];
                                $status = $data["status"];
                                $is_online = $data["is_online"];
                                $advance = $data["advance"];
                                $advance_value = floatval($data["advance_value"]);
                                $barcode = $data["barcode"];
                                array_push($barcodes,$barcode);
                                
                                // Хуучин статусыг хадгалах (reverse хийхэд ашиглах)
                                $old_statuses[$barcode] = $status;
                                
                                // Хуучин байршил/модулийг тодорхойлох (статусаар нь ямар модуль/дараалалд байгааг тодорхойлох)
                                // Status нь аль модуль/дараалалд байгааг илэрхийлнэ
                                $location = $status; // Статусыг байршил гэж ашиглах (эсвэл илүү тодорхой модулийн нэр)
                                // Статусаар модулийг тодорхойлох
                                $location_map = array(
                                  'new' => 'shipment_list',
                                  'order' => 'tracking_queue',
                                  'onair' => 'tracking_queue',
                                  'warehouse' => 'warehouse_list',
                                  'filled' => 'tracking_queue',
                                  'weight_missing' => 'tracking_queue',
                                  'item_missing' => 'tracking_queue',
                                  'custom' => 'custom_list'
                                );
                                // Хэрэв статус мап-д байгаа бол түүнийг ашиглах, эсвэл статусыг шууд ашиглах
                                $old_locations[$barcode] = isset($location_map[$status]) ? $location_map[$status] : $status;
                                
                                // Төлбөртэй илгээмж байвал дүнг цуглуулах (update хийхээс өмнө)
                                if ($is_online==0 && $advance==1 && $advance_value > 0)
                                {
                                  $total_advance_for_bill += $advance_value;
                                }

                                if ($status=="custom")
                                $sql = "UPDATE orders SET delivered_date='".date("Y-m-d H:i:s")."' ,method='".$method."',deliver='$deliver_id' WHERE order_id=$order_id LIMIT 1";
                                
                                if ($status!="custom")
                                $sql = "UPDATE orders SET status='delivered',deliver='$deliver_id',delivered_date='".date("Y-m-d H:i:s")."' ,method='".$method."' WHERE order_id=$order_id LIMIT 1" ;
                                
                                if (mysqli_query($conn,$sql)) proxy_available($proxy_id,$proxy_type,0); else $error=FALSE;
                              }
                          }
                          // var_dump($barcodes);
                      }
                      
                      // Төлбөртэй илгээмжийг Хашбал тайланд оруулах
                      if($error&&isset($_POST['orders'])&& $deliver_id>0) 
                      {
                        // Төлбөртэй илгээмжүүдийг олох
                        $payment_orders = array();
                        $payment_barcodes = array();
                        $total_payment_amount = 0;
                        
                        foreach($orders as $order_id)
                        {
                          $sql_payment = "SELECT * FROM orders WHERE order_id='$order_id' AND advance=1 AND advance_value > 0 LIMIT 1";
                          $result_payment = mysqli_query($conn,$sql_payment);
                          if (mysqli_num_rows($result_payment)==1)
                          {
                            $data_payment = mysqli_fetch_array($result_payment);
                            $payment_orders[] = $order_id;
                            $payment_barcodes[] = $data_payment["barcode"];
                            $total_payment_amount += floatval($data_payment["advance_value"]);
                          }
                        }
                        
                        // Төлбөртэй илгээмж байвал Хашбал тайланд нэмэх
                        if (count($payment_orders) > 0 && $total_payment_amount > 0)
                        {
                          // Хүлээн авагчийн үлдэгдлийг олох
                          $query_receiver = mysqli_query($conn,"SELECT receiver FROM orders WHERE order_id IN (".implode(",",$payment_orders).") GROUP BY receiver");
                          while ($data_receiver = mysqli_fetch_array($query_receiver))
                          {
                            $receiver_id = $data_receiver["receiver"];
                            
                            // Эхний үлдэгдлийг олох
                            $init_balance = 0;
                            $query_records = mysqli_query($conn,"SELECT * FROM later_payment WHERE d_customer='".$receiver_id."' ORDER BY id DESC LIMIT 1");
                            if (mysqli_num_rows($query_records) == 1)
                            {
                              $data_records = mysqli_fetch_array($query_records);
                              $init_balance = floatval($data_records["final_balance"]);
                            }
                            
                            // Төлбөрийн дүнг тооцоолох
                            $receiver_payment = 0;
                            $receiver_barcodes = array();
                            $query_orders = mysqli_query($conn,"SELECT * FROM orders WHERE order_id IN (".implode(",",$payment_orders).") AND receiver='$receiver_id'");
                            while ($data_orders = mysqli_fetch_array($query_orders))
                            {
                              $receiver_payment += floatval($data_orders["advance_value"]);
                              $receiver_barcodes[] = $data_orders["barcode"];
                            }
                            
                            $final_balance = $init_balance + $receiver_payment;
                            
                            // Хашбал тайланд нэмэх
                            $sql_hashbal = "INSERT INTO later_payment (`date`,d_customer,dept,init_balance,final_balance,description) VALUES(
                              '".date("Y-m-d")."',$receiver_id,$receiver_payment,$init_balance,$final_balance,'Төлбөртэй илгээмж: ".implode(",",$receiver_barcodes)."')";
                            mysqli_query($conn,$sql_hashbal);
                          }
                        }
                      }
                    }
                    
                    if($error&&isset($_POST['orders'])&& $deliver_id>0) 
                    echo '<div class="alert alert-success" role="alert">Амжилттай өөрчиллөө</div>';
                    else echo '<div class="alert alert-danger" role="alert">Олголтонд алдаа гарлаа. Error:'.mysqli_error($conn).'</div>';
                    
                    if(isset($_POST['orders'])) 
                    {
                      echo "<table class='table table-hover'>";
                      echo "<tr>";
                      echo "<th>№</th>"; 
                      echo "<th>Үүсгэсэн огноо</th>"; 
                          echo "<th>Илгээгч</th>"; 
                      echo "<th>Х/авах</th>"; 
                      echo "<th>Гардсан</th>"; 
                      echo "<th>Barcode/track</th>"; 
                      echo "<th>Хоног</th>"; 
                      echo "<th>Төлөв</th>"; 
                      echo "<th>Жин</th>"; 
                      echo "<th>Төлбөр</th>"; 
                      echo "<th>Үлдэгдэл</th>";
                        echo "<th>Арга</th>";
                      echo "<th></th>"; 
                      echo "</tr>";
                      $count=1;$total_weight=0;$total_price=0;$total_advance=0; $total_weight_branch =0; $total_admin_value=0;

                      $orders=$_POST['orders'];$N = count($orders);

                      for($i=0; $i < $N; $i++)
                      {
                      $sql="SELECT * FROM orders WHERE order_id='".$orders[$i]."' LIMIT 1";
                      $result= mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)==1)
                        {
                        $data=mysqli_fetch_array($result);
                        $order_id=$data["order_id"];
                        $created_date=$data["created_date"];
                        $sender=$data["sender"];
                        $receiver=$data["receiver"];
                        $deliver=$data["deliver"];
                        $barcode=$data["barcode"];
                        $track=$data["third_party"];
                        $weight=$data["weight"];
                        $advance=$data["advance"];
                        $advance_value=floatval($data["advance_value"]);
                        $status=$data["status"];
                        $method=$data["method"];
                        $is_online=$data["is_online"];
                        $is_branch=$data["is_branch"];
                        $admin_value=$data["admin_value"];
                        $Package_advance = $data["advance"];
                        $Package_advance_value =$data["advance_value"];


                        if ($is_online==1) 
                        {
                          if ($is_branch)
                          $total_weight_branch+=$weight;
                          else  
                          $total_weight+=$weight;
                        }

                        $total_admin_value+=$admin_value;

                        $price=cfg_price($weight);
                        if($status=="warehouse"&&$extra!="") 
                        $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status;
                        echo "<tr>";
                          echo "<td>".$count++."</td>"; 
                        echo "<td>".$created_date."</td>"; 
                        echo "<td><a href='customers?action=detail&id=$sender'>".substr(customer($sender,"surname"),0,2).".".customer($sender,"name")."</a></td>";
                        echo "<td><a href='customers?action=detail&id=$receiver'>".substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name")."</a></td>";
                        echo "<td><a href='customers?action=detail&id=$deliver'>".substr(customer($deliver,"surname"),0,2).".".customer($deliver,"name")."</a></td>";
                        echo "<td>".$barcode."<br>"; 
                        echo $track."</td>";
                        echo "<td>".intval(days($created_date))."</td>"; 
                          echo "<td>".$temp_status."</td>"; 
                        echo "<td>".$weight."</td>"; 
                          echo "<td>".cfg_price($weight)."</td>"; 
                          echo "<td>".$advance_value."</td>"; 
                        echo "<td>".$method."</td>"; 
                        echo "<td><a href='orders?action=detail&id=".$data["order_id"]."'>Detail</a></td>";
                        echo "</tr>";
                          //$total_weight+=$weight;
                        $total_price+=$price;
                        
                        // Төлбөртэй илгээмж байвал advance талбарт оруулах (тайланд харагдахын тулд)
                        // Зөвхөн нэг удаа тооцоолох
                        if ($is_online==0 && $Package_advance==1 && $Package_advance_value > 0)
                        {
                          $total_advance += floatval($Package_advance_value);
                        }

                        if ($is_online==1) $total_weight+=$weight;
                    
                          $total_admin_value+=$admin_value;
                        }
                      }
                      echo "<tr class='total'><td colspan='8'>Нийт</td><td id='total_weight'>$total_weight</td><td id='total_price'>$total_price</td><td id='total_advance_display'>$total_advance</td><td></td><td></td></tr>";
                      // Debug: Төлбөртэй илгээмж байгаа эсэхийг шалгах
                      // echo "<!-- Debug: total_advance = $total_advance -->";
                    echo "</table>";
                    }
                    // Нийт дүнг тооцоолох: жингийн тооцоо + төлбөртэй илгээмжүүдийн дүн
                    // $grand_total нь бүх илгээмжүүдийн дүн байх ёстой
                    $grand_total = cfg_price($total_weight) + cfg_price_branch($total_weight_branch) + $total_advance + $total_admin_value;

                    // //echo $grand_total;
                    // $grand_total_tug = ($grand_total+$total_admin_value)*cfg_rate();

                    // // if ($total_advance==0) $grand_total = cfg_price($total_weight);
                    // // else $grand_total =$total_advance;

                    // if ($grand_total_tug == 0)
                    $grand_total_tug_input = isset($_POST["grand_total_tug"]) ? $_POST["grand_total_tug"] : '0';
                    // Төгрөгийн дүнг тооцоолох (₮ тэмдэгт болон бусад тэмдэгтүүдээс цэвэрлэх)
                    $grand_total_tug_clean = str_replace(array('₮', '₮', ' ', ',', chr(194), chr(160)), '', $grand_total_tug_input);
                    $grand_total_tug = floatval($grand_total_tug_clean);

                    if ($method=='cash') {$cash = $grand_total_tug;$pos=0;$account=0;}
                    if ($method=='pos') {$pos = $grand_total_tug;$cash=0;$account=0;}
                    if ($method=='account') {$account = $grand_total_tug;$pos=0;$cash=0;}
                    if ($method=='mix') {$account = $_POST["account_value"];$pos = $_POST["pos_value"];$cash=$_POST["cash_value"];}
                    $later = 0;
                    if ($method=='later') {$account = 0;$pos = 0;$cash=0; $later = $grand_total_tug;}
                    
                    // "Тооцоо бодох" дээр орж ирсэн төгрөгийн дүнг advance талбарт хадгалах
                    // Тайланд "ИЛГЭЭМЖ ТООЦОО" баганад төгрөгийн дүн харагдахын тулд
                    // Зөвхөн тооцоотой (is_online=1) илгээмжүүд байвал тайланд оруулах
                    // Монголд тооцоогүй (is_online=0) илгээмжүүдийг тайланд оруулахгүй
                    $bills_advance = 0;
                    $has_online_orders = false;
                    
                    // Гардуулж байгаа илгээмжүүдэд тооцоотой илгээмж байгаа эсэхийг шалгах
                    if(isset($_POST['orders']) && is_array($_POST['orders'])) 
                    {
                        $orders_check = $_POST['orders'];
                        foreach($orders_check as $order_id_check)
                        {
                            $order_id_check = intval($order_id_check);
                            $sql_check = "SELECT is_online FROM orders WHERE order_id='$order_id_check' LIMIT 1";
                            $result_check = mysqli_query($conn,$sql_check);
                            if (mysqli_num_rows($result_check)==1)
                            {
                                $data_check = mysqli_fetch_array($result_check);
                                if (isset($data_check["is_online"]) && $data_check["is_online"] == 1)
                                {
                                    $has_online_orders = true;
                                    break;
                                }
                            }
                        }
                    }
                    
                    // Зөвхөн тооцоотой илгээмж байвал тайланд оруулах
                    // Монголд тооцоогүй илгээмжүүдийг тайланд оруулахгүй
                    if ($has_online_orders && $grand_total_tug > 0)
                    {
                        $bills_advance = $grand_total_tug;
                    }
                    else
                    {
                        $bills_advance = 0;
                    }
                    
                    // Debug: Төлбөртэй илгээмж байгаа эсэхийг шалгах
                    // echo "<!-- Debug: total_advance_for_bill = ".($total_advance_for_bill ?? 0).", total_advance = ".($total_advance ?? 0).", bills_advance = $bills_advance -->";
                    
                    $sql = "SELECT * FROM bills WHERE deliver='$deliver_id' AND barcode='".implode(',',$barcodes)."'";

                    $result_delivered = mysqli_query($conn,$sql);

                      if(mysqli_num_rows($result_delivered)==0)
                      {
                        // Төлбөртэй илгээмж байвал advance талбарт төлбөрийн дүнг бичих
                        // Тайланд "ИЛГЭЭМЖ ТООЦОО" баганад харагдахын тулд
                        // Хуучин статусыг JSON хэлбэрээр хадгалах (reverse хийхэд ашиглах)
                        $old_status_json = isset($old_statuses) ? json_encode($old_statuses) : '';
                        // Хуучин байршил/модулийг JSON хэлбэрээр хадгалах (reverse хийхэд ашиглах)
                        $old_location_json = isset($old_locations) ? json_encode($old_locations) : '';
                        // old_status талбар байхгүй бол JSON-ийг barcode талбарт хадгалах эсвэл шинэ талбар нэмэх
                        // Эхлээд old_status талбар байгаа эсэхийг шалгахгүйгээр INSERT хийх
                        $sql = "INSERT INTO bills (`timestamp`,deliver,barcode,weight,type,count,cash,account,pos,later,total,advance) VALUES('".date("Y-m-d H:i:s")."',$deliver_id,'".implode(',',$barcodes)."',$total_weight,'$method',$N,'$cash','$account','$pos','$later','$grand_total_tug','$bills_advance')";
                        mysqli_query($conn,$sql);
                        $bill_id = mysqli_insert_id($conn);
                        
                        // Хуучин статусыг хадгалах (old_status талбар байгаа эсэхийг шалгахгүйгээр UPDATE хийх)
                        // Хэрэв талбар байхгүй бол автоматаар нэмэх эсвэл алдааг үл тоомсорлох
                        if (!empty($old_status_json)) {
                          // old_status талбар байгаа эсэхийг шалгах
                          $check_column = mysqli_query($conn, "SHOW COLUMNS FROM bills LIKE 'old_status'");
                          if (mysqli_num_rows($check_column) == 0) {
                            // Талбар байхгүй бол нэмэх
                            mysqli_query($conn, "ALTER TABLE bills ADD COLUMN old_status TEXT NULL");
                          }
                          // Хуучин статусыг хадгалах
                          mysqli_query($conn,"UPDATE bills SET old_status='".mysqli_real_escape_string($conn,$old_status_json)."' WHERE id='$bill_id'");
                        }
                        
                        // Хуучин байршил/модулийг хадгалах (previous_location талбар байгаа эсэхийг шалгахгүйгээр UPDATE хийх)
                        if (!empty($old_location_json)) {
                          // previous_location талбар байгаа эсэхийг шалгах
                          $check_column_location = mysqli_query($conn, "SHOW COLUMNS FROM bills LIKE 'previous_location'");
                          if (mysqli_num_rows($check_column_location) == 0) {
                            // Талбар байхгүй бол нэмэх
                            mysqli_query($conn, "ALTER TABLE bills ADD COLUMN previous_location TEXT NULL");
                          }
                          // Хуучин байршил/модулийг хадгалах
                          mysqli_query($conn,"UPDATE bills SET previous_location='".mysqli_real_escape_string($conn,$old_location_json)."' WHERE id='$bill_id'");
                        }


                        foreach ($barcodes as $i => $value)
                          {
                              unset($barcodes[$i]);
                          }

                        if ($method == 'later')
                        {
                          $query_receiver =mysqli_query($conn,"SELECT receiver FROM orders WHERE order_id IN (".implode(",",$orders).") GROUP BY receiver");
                          while ($data = mysqli_fetch_array($query_receiver))
                            {
                                $receiver = $data["receiver"];
                                $query_orders =mysqli_query($conn,"SELECT * FROM orders WHERE order_id IN (".implode(",",$orders).") AND receiver='$receiver'") ;

                                  
                                $weight=0;
                                  $weight_noooo=0;
                                  $advance=0;
                                  $admin=0;
                                  $price=0;
                                  $grand_weight = 0;
                                  $total_payment = 0;


                                  while ($data_orders = mysqli_fetch_array($query_orders))
                                  {  
                                    array_push ($barcodes, $data_orders["barcode"]);
                                    if ($data_orders["is_online"] == 0)
                                      {
                                      $advance+=$data_orders["advance_value"];
                                      $weight_noooo +=$data_orders["weight"];
                                      }
                                    if ($data_orders["is_online"] == 1)
                                      {
                                      $admin+=$data_orders["admin_value"];
                                      $weight+=$data_orders["weight"];
                                      }
                                  }
                                  $total_payment = $advance+$admin+cfg_price($weight);
                                $init_balance = 0;
                                $query_records = mysqli_query($conn,"SELECT * FROM later_payment WHERE d_customer='".$deliver."' ORDER BY id DESC LIMIT 1");
                                    if (mysqli_num_rows($query_records) ==1)
                                    {
                                      $data_records = mysqli_fetch_array($query_records);
                                      $init_balance = $data_records["final_balance"];
                                    }
                                    else 
                                    {
                                      $query_orders= mysqli_query($conn, "SELECT * FROM orders WHERE deliver=$deliver AND (status='delivered' OR status='custom') AND method ='later'");
                                      $init_balance =0;$weight=0;$admin=0;$admin_value=0;$advance_value=0;$advance=0;$weight_noooo=0;
                                      while ($data_orders = mysqli_fetch_array($query_orders))
                                        {  
                                        if ($data_orders["is_online"] == 0)
                                          {
                                          $advance+=$data_orders["advance_value"];
                                          $weight_noooo +=$data_orders["weight"];
                                          }
                                        if ($data_orders["is_online"] == 1)
                                          {
                                          $admin+=$data_orders["admin_value"];
                                          $weight+=$data_orders["weight"];
                                          }
                                          $init_balance += $advance+$admin+cfg_price($weight);
                                        }
                                    }
                                $final_balance = $init_balance+$total_payment;
                                $sql = "INSERT INTO later_payment (`date`,d_customer,dept,init_balance,final_balance,description,bill) VALUES(
                                '".date("Y-m-d")."',$deliver,$total_payment,$init_balance,$final_balance,'".implode(",",$barcodes)."',$bill_id)";
                                mysqli_query($conn,$sql);
                          
                            }
                        }

                        if (!($total_price==0 && $total_advance==0))
                          {
                            // if(strpos($_SERVER['HTTP_HOST'],'www')===false)
                            // {
                            //   $base_url = 'https://shuurkhai.com/shu/';
                            // }
                            // else
                            // {
                            //   $base_url = 'https://www.shuurkhai.com/shu/';
                            // }

                          ?>
                          <script type="text/javascript" language="Javascript">window.open('bill?deliver_id=<?php echo $deliver_id;?>&orders=<?php echo implode(",",$orders);?>&method=<?php echo $method;?>');</script>
                          
                          <?php
                          }
                        echo "<a href='?action=reverse&bill_id=$bill_id' class='btn btn-danger btn-sm'>Энэ олголтыг хүчингүй болгох!!!!</a>";
                      }
                      else 
                      {
                        echo "Энэ ачаа гардуулагдаж тооцоонд орсон байна. Тооцоог буцаана уу.";
                      }		
                  ?>


              </div>
            </div>
            <?php
          }

          if ($action=='reverse')
          {
            if (isset($_GET["bill_id"])) $bill_id=intval($_GET["bill_id"]); else $bill_id=0;
            if ($bill_id==0) 
            {
              echo '<div class="alert alert-warning" role="alert">';
              echo 'Буцаах баримтын дугаар. Зөвхөн энэ өдөр гардуулсан барааны баримтын дугаар';
              echo '</div>';
            }
            
            if ($bill_id>0) 
            {
              ?>
              <div class="alert alert-danger"><?php echo $bill_id;?> дугаартай баримтын буцаах гэж байна.</div>
              <?php              
            }
            ?>

            <form action="?action=reversing" method="post">
                <input type="text" name="bill_id" value="<?php echo ($bill_id>0)?$bill_id:'';?>" class="form-control" placeholder="12345" autofocus="autofocus">
                <button type="submit" class="btn btn-success">Буцаах</button>
            </form>
            <?php             
          
          }
          
          if ($action=='reversing')
          {
            $bill_id = $_POST["bill_id"];
            $sql = "SELECT * FROM bills WHERE id='$bill_id'";
            $result = mysqli_query($conn,$sql);
            if (mysqli_num_rows($result)==1)            
              {

                $data=mysqli_fetch_array($result);
                $timestamp = $data["timestamp"];
                $deliver_id = $data["deliver"];
                $barcodes = $data["barcode"];
                $barcode_array = explode(",",$barcodes);
                
                // Хуучин статусыг унших (old_status талбар байгаа эсэхийг шалгах)
                $old_statuses = array();
                if (isset($data["old_status"]) && !empty($data["old_status"])) {
                  $old_statuses = json_decode($data["old_status"], true);
                  if (!is_array($old_statuses)) {
                    $old_statuses = array();
                  }
                }
                
                // Хуучин байршил/модулийг унших (previous_location талбар байгаа эсэхийг шалгах)
                $old_locations = array();
                if (isset($data["previous_location"]) && !empty($data["previous_location"])) {
                  $old_locations = json_decode($data["previous_location"], true);
                  if (!is_array($old_locations)) {
                    $old_locations = array();
                  }
                }
                
                //if ($timestamp >= date('Y-m-d 00:00:00') && $timestamp <= date('Y-m-d 23:59:59') )
                if (1==1 )
                {
                  //echo "Устгах боломжтой";
                  mysqli_query($conn,"DELETE FROM bills WHERE id='".$bill_id."'");
                  mysqli_query($conn,"DELETE FROM later_payment WHERE bill='".$bill_id."'");
                  
                  foreach($barcode_array as $barcode_single)
                  {
                    // Хуучин статусыг олох - хуучин статус байхгүй бол 'warehouse' (default)
                    $old_status = isset($old_statuses[$barcode_single]) ? $old_statuses[$barcode_single] : 'warehouse';
                    
                    // Хуучин байршил/модулийг олох
                    $old_location = isset($old_locations[$barcode_single]) ? $old_locations[$barcode_single] : null;
                    
                    // Илгээмжийн статусыг хуучин статус руу буцаах, deliver болон delivered_date талбаруудыг цэвэрлэх
                    // Хуучин статусыг өөрчлөхгүй, яг хуучин статус руу буцаана
                    // Ингэснээр илгээмж эргэж хуучин төлөвт нь буцана болон хуучин модуль/дараалалд ороно
                    mysqli_query($conn,"UPDATE orders SET status='".mysqli_real_escape_string($conn,$old_status)."', deliver=NULL, delivered_date=NULL, method=NULL WHERE barcode='".mysqli_real_escape_string($conn,$barcode_single)."'");
                    
                    // Зөвхөн баркод-ийг харуулах (тайлбаргүй)
                    echo $barcode_single.'<br>';
                  }	
                  echo "Амжилттай буцлаа".'<br>';

                }
                else 
                {
                  echo "Зөвхөн өнөөдөр үүссэн баримтын устгах боложмтой.";
                }
                
              }

            else 
              echo "Баримтын дугаар олдсонгүй";		

          }


          if ($action=='delivered')
          {
           
              // $xls_name = "delivered".date("ymd").rand(0,10000).".xlsx";
              // $xls_name = "delivered.xlsx";
              // require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');





              
              if(isset($_POST["search"])) 
                {
                $search_term=$_POST["search"];
                echo "Xайлт:".$search_term."<br>";
                }
                else $search_term="";
              if (isset($_POST["search_status"])) $search_status=$_POST["search_status"]; else $search_status='all';
              if (isset($_POST["status_type"])) $status_type=$_POST["status_type"]; else $status_type='all';

              if (isset($_POST["method_type"])) $method_type=$_POST["method_type"]; else $method_type='all';

              if(isset($_POST["start_date"])) 
              $start_date = date("Y-m-d", strtotime($_POST["start_date"]))." 00:00:00";
              else $start_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -7 days'))." 00:00:00";

              if(isset($_POST["finish_date"])) 
              $finish_date = date("Y-m-d", strtotime($_POST["finish_date"]))." 23:59:00";
              else $finish_date = date("Y-m-d")." 23:59:00";


              //echo "<h3>Идэвхитэй захиалгууд</h3>";
              $sql="SELECT orders.*,receiver_customer.name AS r_name,receiver_customer.tel AS r_tel,sender_customer.name AS s_name,sender_customer.tel AS s_tel,deliver_customer.name AS d_name, deliver_customer.tel AS d_name, CONCAT_WS(orders.barcode,orders.third_party,sender_customer.name,sender_customer.tel,receiver_customer.name,receiver_customer.tel,deliver_customer.name,deliver_customer.tel) AS search FROM orders LEFT JOIN customer AS receiver_customer ON orders.receiver=receiver_customer.customer_id LEFT JOIN customer AS sender_customer ON orders.sender=sender_customer.customer_id LEFT JOIN customer AS deliver_customer ON orders.deliver=deliver_customer.customer_id";
              $sql.=" WHERE CONCAT_WS(orders.barcode,orders.third_party,sender_customer.name,sender_customer.tel,receiver_customer.name,receiver_customer.tel,deliver_customer.name,deliver_customer.tel) LIKE '%".$search_term."%'";

              $sql.=" AND orders.status IN ('delivered','custom')";
              if ($status_type=="advance") $sql.=" AND orders.advance =1";

              if ($method_type!="all") $sql.=" AND orders.method ='$method_type'";


              if ($start_date!="")  $sql.=" AND delivered_date>'$start_date'";
              if ($finish_date!="")  $sql.=" AND delivered_date<'$finish_date'";

              // echo $sql;

              /*if(isset($_POST["search"])) 
              $sql.=" AND CONCAT_WS(barcode,package,sender_customer.name,sender_customer.tel,receiver_customer.name,receiver_customer.tel) LIKE '%".$_POST["search"]."%'";*/

              //$sql.=" ORDER BY receiver_customer.name";
              $sql.=" ORDER BY delivered_date DESC";

              // echo $sql;

              $result = mysqli_query($conn,$sql);

              // echo $sql;

              ?>
               <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                      <form action="?action=delivered" method="post">
                        <div class="input-group">
                          <input type="text" class="form-control" name="search" placeholder="Хайх..." value="<?php echo $search_term;?>">
            

                          <select  name="status" class="form-control">
                            <option value="all" <?php echo ($search_status=="all")?'SELECTED':'';?> >Бүx идэвхитэй</option>
                            <option value="new"  <?php echo ($search_status=="new")?'SELECTED':'';?>>Нисэхэд бэлэн</option>
                            <option value="order" <?php echo ($search_status=="order")?'SELECTED':'';?>>Хүлээн авагчгүй</option>
                            <option value="filled" <?php echo ($search_status=="filled")?'SELECTED':'';?>>Х/авагч бөглөсөн</option>
                            <option value="weight_missing" <?php echo ($search_status=="weight_missing")?'SELECTED':'';?>>Жин нь бөглөгдөөгүй</option>				 
                            <option value="onair" <?php echo ($search_status=="onair")?'SELECTED':'';?>>Онгоцоор ирж байгаа</option>				 
                            <option value="warehouse" <?php echo ($search_status=="warehouse")?'SELECTED':'';?>>Агуулахад байгаа</option>				 
                            <option value="delivered" <?php echo ($search_status=="delivered")?'SELECTED':'';?>>Хүргэгдсэн</option>				 
                            <option value="custom" <?php echo ($search_status=="custom")?'SELECTED':'';?>>Гаальд саатсан</option>				 
                            <option value="transport" <?php echo ($search_status=="transport")?'SELECTED':'';?>>Хүргэлттэй</option>				 
                            <option value="db" <?php echo ($search_status=="db")?'SELECTED':'';?>>Баазаас</option>				 
                          </select>

                          <select  name="status_type" class="form-control">
                            <option value="advance" <?php echo ($status_type=="advance")?'SELECTED':'';?> >Төлбөртэйг</option>
                            <option value="all"  <?php echo ($status_type=="all")?'SELECTED':'';?>>Бүгдийг</option>
                          </select>           
                          
                          <select  name="method_type" class="form-control">
                            <option value="all" <?php echo ($method_type=="all")?'SELECTED':'';?> >Бүгдийг</option>
                            <option value="cash"  <?php echo ($method_type=="cash")?'SELECTED':'';?>>Бэлэн</option>
                            <option value="account" <?php echo ($method_type=="account")?'SELECTED':'';?>>Банкаар</option>
                            <option value="pos" <?php echo ($method_type=="pos")?'SELECTED':'';?>>POS</option>
                          </select>
                          
                          <input type="date" class="form-control" name="start_date" value="<?php echo substr($start_date,0,10);?>">
                          <input type="date" class="form-control" name="finish_date" value="<?php echo substr($finish_date,0,10);?>">
                        
                          <button type="submit" class="btn btn-primary mr-2">Хайх</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <div class="col-lg-12">

                  <?php

                  //
                  //$sql.=" ORDER BY created_date DESC";
                  //echo $sql;
                  $result = mysqli_query($conn,$sql);

                  //$query = $this->db->like("barcode","CP87");
                  if (mysqli_num_rows($result)>0)
                  {
                    echo "<table class='table table-hover table-bordered' id='delivered_table'>";
                    echo '<thead>';
                      echo "<tr>";
                      echo "<th>№</th>"; 
                      //echo "<th>Үүсгэсэн огноо</th>"; 
                        //	echo "<th>Илгээгч</th>"; 
                      echo "<th>Х/авагч</th>"; 
                      echo "<th>Гардсан</th>"; 
                      echo "<th>Олгосон огноо/Barcode/track</th>"; 
                      //echo "<th>Хоног</th>"; 
                      echo "<th>Жин</th>"; 
                      //echo "<th>Төлбөр</th>"; 
                      echo "<th>Үлдэгдэл</th>";
                        echo "<th>Арга</th>";
                      echo "<th>Үйлдэл</th>"; 
                      echo "</tr>";
                      echo '</thead>';
                      $count=1;$total_weight=0;$total_price=0;$total_advance=0;$total_weight_branch=0;$total_admin_value=0;

                    echo '<tbody>';

                    // $data = array(
                    //   array('№','Илгээгч','Х/авагч','Х/а утас','Гардагч','Гардсан утас','Олгосон огноо','Barcode','Track№','Жин','Үлдэгдэл','Арга'));
                    
                    
                      while ($data = mysqli_fetch_array($result))
                        {
                        //$row=$query->row();
                        $order_id=$data["order_id"];
                        $created_date=$data["created_date"];
                        $delivered_date=$data["delivered_date"];
                        $sender=$data["sender"];
                        //$sender_name=$data["sender_customer.name;
                        //$sender_surname=$data["sender_customer.name;
                        $receiver=$data["receiver"];
                        //$receiver_name=$data["receiver_customer.name;
                        //$receiver_surname=$data["receiver_customer.surname;
                        $admin_value=$data["admin_value"];

                        $deliver=$data["deliver"];
                        $barcode=$data["barcode"];
                        $track=$data["third_party"];
                        $weight=floatval($data["weight"]);
                        $advance=$data["advance"];
                        $advance_value=floatval($data["advance_value"]);
                        $status=$data["status"];
                        $method=$data["method"];
                        $Package_advance = $data["advance"];
                        $Package_advance_value =$data["advance_value"];

                        $is_online=$data["is_online"];
                        $is_branch=$data["is_branch"];
                        if ($is_online)
                        $price=$weight*cfg_paymentrate(); else $price=0;
                        if($status=="warehouse"&&$extra!="") 
                        $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status;

                        if ($is_online==1) 
                        {
                          if ($is_branch)
                          $total_weight_branch+=floatval($weight);
                          else  
                          $total_weight+=floatval($weight);
                        }
                          
                        $total_admin_value+=$admin_value;

                        if ($is_online==0 && $Package_advance==1)
                        $total_advance+=floatval($Package_advance_value);



                        $tr=0;
                        if ($advance==1&&$is_online==0)
                          {echo "<tr class='red' title='Үлдэгдэлтэй илгээмж:".$advance_value."$' alt='order'>"; $tr=1;}
                          
                          if ($advance==0&&$is_online==0&&$tr==0)
                          {echo "<tr class='green' title='Илгээмжийг шууд олгосон төлбөргүй' alt='order'>"; $tr=1;}
                        
                          if (!$tr) echo "<tr>";else $tr=0;
                        
                        
                          echo "<td>".$count."</td>"; 
                        echo "<td>";
                        echo "<a href='customers?action=detail&id=$receiver'>".substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name")."</a><br>".customer($receiver,"tel")."</td>";

                        echo "<td>";
                        echo "<a href='customers?action=detail&id=$deliver'>".substr(customer($deliver,"surname"),0,2).".".customer($deliver,"name")."</a><br>".customer($deliver,"tel")."</td>";

                        echo "<td>".$delivered_date."<br>"; 
                        echo barcode_comfort($barcode)."<br>"; 
                        if ($track!="")
                        echo "<a href='".track($track)."' target='new' title='Хаана явна'>$track<span class='glyphicon glyphicon-globe'></span></a>";
                        if ($is_branch) echo '<span class="badge badge-success">DE</span>';
                          echo "</td>";
                        //echo "<td>".days($created_date)."</td>"; 
                          //echo "<td>".$temp_status."</td>"; 
                        echo "<td>".$weight."</td>"; 
                          //echo "<td>".$weight*cfg_paymentrate()."</td>"; 
                          echo "<td>".$advance_value."</td>"; 
                        echo "<td>";
                        if ($status=="custom") echo $status."<br>";
                        echo $method."</td>"; 
                        echo "<td>";
                        if ($is_online)
                        echo "<a href='tracks?id=".$data["order_id"]."'>edit</a></td>";
                        else 
                        echo "<a href='orders?id=".$data["order_id"]."'>edit</a></td>";
                        
                        echo "</tr>";
                        echo '</tbody>';
                        // $total_weight+=$weight;
                        // $total_price+=$price;
                        // $total_advance+=intval($advance_value);
                        
                        
                        
                        // array_push($data,array(
                        // $count,
                        // substr(customer($sender,"surname"),0,2).".".customer($sender,"name"),
                        // substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name"),
                        // customer($receiver,"tel"),
                        // substr(customer($deliver,"surname"),0,2).".".customer($deliver,"name"),
                        // customer($deliver,"tel"),
                        // $delivered_date,
                        // $barcode,
                        // "  ".strval($track),
                        // $weight, 
                        //   $advance_value, 
                        // $method));

                        $count++;
                      }
                      // $grand_total = cfg_price($total_weight);

                      if ($total_advance==0) 
                      $grand_total = cfg_price($total_weight) + cfg_price_branch($total_weight_branch);
                      else $grand_total =$total_advance;

                      $gt_weight  = $total_weight  +  $total_weight_branch;                
                      
                      
                    // array_push($data,array('','Нийт','','','','','','','',floatval($gt_weight),floatval($grand_total)));
                    // $writer = new XLSXWriter();
                    // $writer->writeSheet($data);
                    // $writer->writeToFile('assets/'.$xls_name);
                    
                    
                    echo "</table>";

                    echo "<span class='text-danger'>Нийт:( $gt_weight Кг ) $grand_total $</span>";

                  }
                  else echo '<div class="alert alert-danger" role="alert">Илгээмж олдсонгүй</div>';
                  ?>
                </div>
               </div>
               <?php

          
          }

          if ($action=='later_pay')
          {
              ?>
              <div class="panel panel-primary">
                <div class="panel-heading">Дараа тооцоо төлөх</div>
                  <div class="panel-body">
                    <form action="?action=later_paid" method="post">
                         
                        <div class="alert alert-warning" role="alert">
                          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                          Хүлээн авагчийн утасны дугаар оруулах.
                        </div>
                        <span>Утас:</span>
                        <input type="text" name="contacts" class="form-control" placeholder="99123456" autofocus><br>
                        <span>Нэр:</span>
                        <input type="text" name="name" class="form-control" readonly><br>
                        <span>Үлдэгдэл:</span>
                        <input type="text" name="balance" class="form-control" readonly><br>                       
                        <span>Төлбөр:</span>
                        <input type="text" name="payment" class="form-control"><br>
                        <span>Огноо:</span>
                        <input type="date" name="date"  value="<?php echo date("Y-m-d");?>" class="form-control"><br>
                        <span>Тайлбар:</span>
                        <input type="text" name="description"  placeholder="Тайлбар"  class="form-control"><br>
                        <button type="submit" class="btn btn-success">Төлбөр төлсөн</button>
                        
                    </form>

                  </div>
                </div>
                <?php
          }

          if ($action== "later_paid")
          {
            $contacts = $_POST["contacts"];
            $result = mysqli_query($conn,"SELECT * FROM customer WHERE tel='".$contacts."' LIMIT 1");
            if (mysqli_num_rows($result) == 1)
            {
              $data = mysqli_fetch_array($result);
              $customer_id = $data["customer_id"];
              $init_balance = $_POST["balance"];
              $payment = $_POST["payment"];
              $date = $_POST["date"];
              $description = $_POST["description"];
              $final_balance = $init_balance-$payment;
          
              $sql = "INSERT INTO later_payment (d_customer,init_balance,payment,date,description,final_balance)
               VALUES ('$customer_id','$init_balance','$payment','$date','$description','$final_balance')";
           
                  if (mysqli_query($conn,$sql))
                    {
                      echo "<table class='table table-hover'>";
                      echo "<tr>";
                      echo "<th>Огноо</th>"; 
                          echo "<th>Төлсөн</th>"; 
                         echo "<th>Эхний үлдэгдэл</th>"; 
                         echo "<th>Төлбөр</th>"; 
                         echo "<th>Үлдэгдэл</th>"; 
                         echo "<th>Төлөв</th>"; 
                         echo "</tr>";
          
                         echo "<tr>";
                         echo "<td>$date</td>"; 
                          echo "<td>".customer($customer_id,"name")."</td>"; 
                         echo "<td>$init_balance</td>"; 
                         echo "<td>$payment</td>"; 
                         echo "<td>$final_balance</td>"; 
                         echo "<td>Төлсөн</td>"; 
                         echo "</tr>";
                         echo "</table>";
                     }
                     else echo "Бичиглэл оруулахад алдаа гарлаа";
          
            }
            else echo "Хэрэглэгчийн мэдээлэл олдсонгүй";		
          }

          if ($action=="later_transaction")
          {

            ?>
            <form action ="?action=later_transaction" method="POST">
              <h5>Утас</h5>
              <div class="form-group">
                <input type="text" placeholder="12345678" class="form-control" name="tel"  value="<?php echo (isset($_POST["tel"]))?$_POST["tel"]:'';?>" required autofocus>
                <button class="btn btn-success" type="submit">Хайх</button>
              </div>
            </form>
            <?php
                
            if (isset($_POST["tel"]))
            {
              $contacts = $_POST["tel"];
              $sql ="SELECT * FROM customer WHERE tel='".$contacts."' LIMIT 1";
              $result = mysqli_query($conn,$sql);

              if (mysqli_num_rows($result) == 1)
              {

                $data = mysqli_fetch_array($result);
                $customer_id = $data["customer_id"];
                $init_balance=0;
                echo "<h4>".customer($customer_id,"full_name")."</h4>";
                // echo "<p>(".$start_date." - ".$finish_date.")</p>";

                $query_records = mysqli_query($conn,"SELECT * FROM later_payment WHERE d_customer='".$customer_id."' LIMIT 1");
                if (mysqli_num_rows($query_records) ==1)
                {
                  $row = mysqli_fetch_array($query_records);
                  $init_balance = $row["init_balance"];
                  echo "<span class='pull-right'> Эхний үлдэгдэл ".$init_balance."</span>";
                }

                $query_records = mysqli_query($conn,"SELECT * FROM later_payment WHERE d_customer='".$customer_id."'");
                if (mysqli_num_rows($query_records) >1)
                  {
                    echo "<table class='table table-hover table-bordered'>";
                      echo "<tr>";
                      echo "<th width='30%'>Огноо</th>"; 
                      echo "<th width='10%'>Кр</th>"; 
                        echo "<th width='10%'>Дп</th>"; 
                        echo "<th width='20%'>Үлдэгдэл</th>"; 
                        echo "<th width='50%'>Тайлбар</th>"; 
                        echo "</tr>";
                        $total_dept=$total_payment=0;
                        while ($data = mysqli_fetch_array($query_records))
                        {
                            echo "<tr>";
                            echo "<td>".$data["date"]."</td>"; 
                            echo "<td>".customer($data["d_customer"],"name")."</td>"; 
                            echo "<td>".$data["dept"]."</td>"; 
                            echo "<td>".$data["payment"]."</td>"; 
                            echo "<td>".$data["final_balance"]."</td>"; 
                            echo "<td>".$data["description"]."</td>"; 
                            echo "</tr>";

                            $total_dept+=$data["dept"]; $total_payment+=$data["payment"];
                          
                        }

                      echo "<tr>";
                        echo "<td>Нийт</td>"; 
                        echo "<td>".customer($customer_id,"name")."</td>";
                        echo "<td>".$total_dept."</td>"; 
                        echo "<td>".$total_payment."</td>"; 
                        echo "<td></td>"; 
                        echo "<td></td>"; 
                      echo "</tr>";
                    echo "</table>";
                  }
                    else echo "Бичиглэл олдсонгүй<br>";
              }
              else echo "Хэрэглэгчийн мэдээлэл олдсонгүй";	

            }
          }



          ?>
          




        </div>
      <?php require_once("views/footer.php");?>
		
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
  <script src="assets/js/data-table.js"></script>
  <script src="assets/js/jquery.chained.min.js"></script>

  <link href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.css" rel="stylesheet">
  <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.bootstrap5.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>

  <script>
      $('#delivered_table').DataTable({
        pageLength: 100,
        lengthMenu: [100, 250, 500, { label: 'Бүгд', value: -1 }],
        layout: {
           topStart: {
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print','pageLength'],                
            }         
        }
    });
  </script>

    <script>
    $(document).ready(function() 
    {
        $("#district").chained("#city");
        $(".alert").hide();

        $('input[name="select_all"]').click(function(event) {
            var isChecked = $(this).prop('checked');
            // Зөвхөн orders[] чекбоксуудыг сонгох (select_all-ийг оролцуулахгүй)
            $('input[type="checkbox"][name="orders[]"]').prop('checked', isChecked);
            // Change event-ийг trigger хийх тооцоолол хийхийн тулд
            $('input[type="checkbox"][name="orders[]"]').trigger('change');
        });

        $('body').on('keydown', 'input, select', function(e) {
          var self = $(this)
            , form = self.parents('form:eq(0)')
            , focusable
            , next
            ;
          if (e.keyCode == 13) {
            focusable = form.find('input,a,select,button').filter(':visible');
            next = focusable.eq(focusable.index(this)+1);
            if (next.length) {
              next.focus();
            } else {
              form.submit();
            }
            return false;
          }
        });

          $("#cash_value").hide();
          $("#pos_value").hide();
          $("#account_value").hide();



          // Тооцоолол хийх функц (checkbox-уудын төлөв өөрчлөгдөх эсвэл хуудас ачаалагдсан үед)
          function calculateTotals() {
            var weight=0;
            var sum=0;
            var count=0;
            var total_price = 0;
            var total_price_branch = 0;
            var sum_weight=0; // Онлайн төлбөртэй илгээмжүүдийн жин (тооцоо бодох)
            var sum_weight_branch=0; // DE онлайн төлбөртэй илгээмжүүдийн жин (тооцоо бодох)
            var paid_weight=0; // Төлбөртэй илгээмжүүдийн жин (зөвхөн төлбөртэй, DE биш)
            var total_weight_all=0; // Бүх checked илгээмжүүдийн нийт жин (харагдах зориулалттай)
            var total_advance=0;
            var grand_total=0;
            var total_admin_value=0;
            var is_branch = "";
            var package_advance = 0;
            // Зөвхөн orders[] checkbox-уудыг тооцоололд оруулах
            $('input[type="checkbox"][name="orders[]"]').each(function() 
              {
                if (this.checked == true) 
                { 
                  weight = parseFloat($(this).attr('weight')) || 0;
                  is_branch =$(this).attr('is_branch');
                  is_online =$(this).attr('is_online');
                  package_advance =$(this).attr('package_advance');
                  advance = parseFloat($(this).attr('advance')) || 0;
                  admin_value =parseFloat($(this).attr('admin_value')) || 0;
                  total_admin_value +=parseFloat(admin_value);

                  // Бүх checked илгээмжүүдийн жингийг нийт жинд нэмэх (харагдах зориулалттай)
                  total_weight_all += parseFloat(weight);

                  // is_online==1 үед тооцоо бодох жинд нэмэх
                  if (is_online=="1")
                  {
                    // Онлайн төлбөртэй илгээмж - жингийн тооцоо бодох
                    if (is_branch=="D")
                    sum_weight_branch+=parseFloat(weight);
                    else 
                    sum_weight+=parseFloat(weight);
                  }

                    // Төлбөртэй илгээмж: is_online==0 && package_advance==1
                  // package_advance нь string байж магадгүй тул харьцуулахад ==="1" эсвэл parseInt() ашиглах
                  if (is_online=="0" && (package_advance=="1" || parseInt(package_advance)==1))
                  {
                    // Төлбөртэй илгээмжүүдийн advance дүнг хадгалах (зөвхөн харагдах зориулалттай)
                    total_advance+=parseFloat(advance) || 0;
                    // Төлбөртэй илгээмжүүдийн жинг бас тооцоололд нэмэх (тариф ижил тул жинг нэмээд тариф-аар үржүүлнэ)
                    // DE биш бол sum_weight болон paid_weight-д нэмэх (is_branch нь "D" биш бол, эсвэл хоосон "")
                    if (is_branch!="D") {
                      sum_weight+=parseFloat(weight);
                      paid_weight+=parseFloat(weight); // Төлбөртэй илгээмжүүдийн жингийг тусад нь тоолох
                    }
                  }
                }
            
              }
            );
            var gt_weight = total_weight_all; // Бүх checked илгээмжүүдийн нийт жин

            // cfg_price() логик: чагталсан илгээмжүүдийн жинг нэмээд нийлбэр > 1 кг бол жингийн тариф, <= 1 кг бол 1 кг-ын тариф
            var paymentrate = <?php echo cfg_paymentrate();?>;
            // sum_weight нь NON-DE илгээмжүүдийн нийлбэр жин (is_online==1 && is_branch!="D" ба төлбөртэй илгээмжүүд)
            if (sum_weight > 1) {
              // Нийлбэр > 1 кг бол жингийн тариф
              total_price = sum_weight * paymentrate;
            } else if (sum_weight > 0 && sum_weight <= 1) {
              // Нийлбэр <= 1 кг бол 1 кг-ын тариф
              total_price = paymentrate;
            } else {
              // Жин байхгүй бол 0
              total_price = 0;
            }

            // cfg_price_branch() логик: жин >= 1 үед жин * тариф, жин < 1 үед зөвхөн тариф
            var paymentrate_branch = <?php echo cfg_paymentrate_branch();?>;
            if (sum_weight_branch >= 1) {
              total_price_branch = sum_weight_branch * paymentrate_branch;
            } else if (sum_weight_branch > 0) {
              total_price_branch = paymentrate_branch;
            } else {
              total_price_branch = 0;
            }
            
            total_weight = sum_weight+sum_weight_branch;
            // Төлбөртэй илгээмжүүдийн жинг тариф-аар тооцсон бол total_advance-ийг нэмэх хэрэггүй
            // Учир нь жингийн тариф-аар тооцоолсон байна
            var grand_total = total_price+total_price_branch;
            var grand_total_tug = grand_total*<?php echo cfg_rate();?>;

            
            $('#total_weight').val(gt_weight.toFixed(2));
            $('#total_weight_branch').val(sum_weight_branch.toFixed(2));
            
            // "Төлбөртэй илгээмж ($)" талбарт жингийн тариф-аар тооцоолсон дүнг харуулах
            // Төлбөртэй илгээмжүүдийн жингийн нийлбэрийг тариф-аар үржүүлнэ (1кг зарчмыг хангаж)
            // paid_weight нь зөвхөн төлбөртэй илгээмжүүдийн жин (is_online==0 && package_advance==1 && is_branch!="D")
            // Төлбөртэй илгээмжүүдийн тооцоолол: paid_weight > 1 бол paid_weight * paymentrate, эсвэл paymentrate
            var paid_shipment_price = 0;
            if (paid_weight > 1) {
              paid_shipment_price = paid_weight * paymentrate;
            } else if (paid_weight > 0) {
              paid_shipment_price = paymentrate;
            }
            // "Төлбөртэй илгээмж ($)" талбарт жингийн тариф-аар тооцоолсон дүнг харуулах
            $('#total_advance').val(paid_shipment_price.toFixed(2));
            $('#total_admin').val(total_admin_value.toFixed(2));
            // grand_total нь total_price + total_price_branch (total_advance-гүй, учир нь жингийн тариф-аар тооцоолсон)
            $('#grand_total').val(grand_total.toFixed(2));
            $('#grand_total_tug').val(grand_total_tug.toFixed(2));
            //$('#grand_total').hide(100);
            
            $('#total_weight_inmodal').val(total_weight.toFixed(2));
            $('#grand_total_inmodal').val(grand_total.toFixed(2));
            
            // Хүснэгтийн хөл хэсгийн "Төлбөртэй илгээмж ($)" талбарын утгыг модал цонхны "Дараа тооцоо /USD/" талбарт оруулах
            var total_advance_from_table = parseFloat($('#total_advance').val()) || 0;
            $('#total_admin_inmodal').val(total_advance_from_table.toFixed(2));
            
            $('#grand_total_inmodal_tug').val(grand_total_tug.toFixed(2));
            // Hidden input-д төгрөгийн дүнг оруулах
            $('#grand_total_tug_hidden').val(grand_total_tug.toFixed(2));
            // Form-ийн grand_total_tug field-д ч оруулах
            $('#grand_total_tug').val(grand_total_tug.toFixed(2));
          }
          
          // Checkbox change event - бүх checkbox-уудын төлөв өөрчлөгдөхөд тооцоолол хийх
          $(document).on('change', 'input[type="checkbox"]', function(event) {
            calculateTotals();
          });
          
          // Хуудас ачаалагдсан үед checked checkbox-уудын тооцоолол хийх
          calculateTotals();
        
        // Модал цонх нээгдэхэд хүснэгтийн талбаруудын утгыг модал цонхны талбарт оруулах
        $(document).on('shown.bs.modal', '#exampleModal', function (event) {
            var total_advance_from_table = parseFloat($('#total_advance').val()) || 0;
            var total_admin_from_table = parseFloat($('#total_admin').val()) || 0;
            var total_weight_from_table = parseFloat($('#total_weight').val()) || 0;
            var grand_total_from_table = parseFloat($('#grand_total').val()) || 0;
            
            if (total_advance_from_table > 0 || total_admin_from_table > 0 || total_weight_from_table > 0) {
                var rate = <?php echo cfg_rate(); ?>;
                var grand_total_tug_value = (grand_total_from_table * rate).toFixed(2);
                
                $('#total_weight_inmodal').val(total_weight_from_table.toFixed(2));
                $('#total_admin_inmodal').val(total_advance_from_table.toFixed(2));
                $('#grand_total_inmodal').val(grand_total_from_table.toFixed(2));
                $('#grand_total_inmodal_tug').val(grand_total_tug_value + '₮');
                // Hidden input-д төгрөгийн дүнг оруулах
                $('#grand_total_tug_hidden').val(grand_total_tug_value);
                // Form-ийн grand_total_tug field-д ч оруулах
                $('#grand_total_tug').val(grand_total_tug_value);
            }
        });
        
        // Modal-ийн төгрөгийн дүн өөрчлөгдөхөд hidden input болон form field-д оруулах
        $(document).on('input change', '#grand_total_inmodal_tug', function() {
            var tugValue = $(this).val().toString().replace(/[₮\s,]/g, '');
            $('#grand_total_tug_hidden').val(tugValue);
            $('#grand_total_tug').val(tugValue);
        });

      $('input[type="radio"]').change(function(){
        if ($('input[type="radio"]:checked').val()=="mix")
          {
          $("#cash_value").show();
          $("#pos_value").show();
          $("#account_value").show();
          }
        })
      $('input[name="contacts"]').change(function()
      {
        $('#result').append('<img src="assets/images/ajaxloader.gif" id="loading">');
        var tel= $('input[name="contacts"]').val();
        $.ajax ({
            url: 'customers_check2',
            type:'POST',
            data:'tel='+tel,
            success: function(responce){
              //alert("LOADING...");
                  
                  //alert(responce_json.name);
                //	alert(responce);
                  if (responce!="")
                  {
                    var responce_json = JSON.parse(responce);
                    $('input[name="rd"]').val(responce_json.rd);
                    $('input[name="surname"]').val(responce_json.surname);
                    $('input[name="name"]').val(responce_json.name);
                    $('input[name="email"]').val(responce_json.email);
                    $('textarea[name="address"]').val(responce_json.address);
                    $('select[name="city"]').val(responce_json.address_city);
                    $('select[name="district"]').val(responce_json.address_district);
                    $('input[name="khoroo"]').val(responce_json.address_khoroo);
                    $('input[name="build"]').val(responce_json.address_build);
                  }
                  else 
                  {	
                    $('input[name="rd"]').val("");
                    $('input[name="surname"]').val("");
                    $('input[name="name"]').val("");
                    $('input[name="email"]').val("");
                    $('textarea[name="address"]').val("");
                    alert("Хэрэглэгч олдсонгүй");
                  }
                }
              });	
      });			    


      $('input[name="contacts"]').change(function(){
          var tel= $('input[name="contacts"]').val();
        
          $.ajax ({
            url: 'later_check',
            type:'POST',
            data:'tel='+tel,
            success: function(responce){
                  if (responce!="")
                  {
                    //var responce_json = JSON.parse(responce);
                    $('input[name="balance"]').val(responce);
                    //alert("Хэрэглэгчийн мэдээлэл олдлоо");
                  }
                  else 
                  {	
                    $('input[name="balance"]').val(0);
                    //alert("Хэрэглэгч олдсонгүй!");
                  }
                }
              });	
      });		    
    });		
    </script>


</body>
</html>    