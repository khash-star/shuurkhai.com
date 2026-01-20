<?php require_once("config.php");?>
<?php require_once("views/helper.php");?>
<?php require_once("views/login_check.php");?>
<?php require_once("views/init.php");?>
  <body>
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
      <div class="layout-container">
        <?php require_once("views/header.php");?>

        <?php if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="dashboard";?>

        <div class="layout-page">          
          <div class="content-wrapper">
            <?php require_once("views/topmenu.php");?>

            <div class="container-xxl flex-grow-1 container-p-y">
                <?php
                if ($action=="all")
                {          
                    
                    
                    if(isset($_POST["search"])) 
                    {
                    $search_term=str_replace(" ","%",$_POST["search"]);
                    if ($search_term!="") echo "Xайлт:".$search_term."<br>";
                    }
                    else $search_term="";
                    if (isset($_POST["status"])) $search_status=$_POST["status"]; else $search_status='all';
                    if (isset($_POST["status_type"])) $statuts_type=$_POST["status_type"]; else $statuts_type='all';
                
                    
                    $start_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 month'))." 00:00:00";

                    $finish_date = date("Y-m-d")." 23:59:00";

                    $sql="SELECT * FROM orders";

                    $sql.=" WHERE created_date>'$start_date'";

                    if ($search_status=="all") 
                    $sql.=" AND orders.status NOT IN('completed','delivered','warehouse','custom','onair')";
                    if ($search_status=='db')
                    $sql.=" AND orders.status IN ('completed','delivered','warehouse','custom','onair','new','order','weight_missing','item_missing','filled')";

                    if ($search_status!="all" && $search_status!='db')
                    $sql.=" AND orders.status ='$search_status'";

                    if ($statuts_type=="advance")
                    $sql.=" AND orders.advance=1";

                    if(isset($_POST["search"])) 
                    $sql.=" AND LOWER(CONVERT(CONCAT_WS(barcode,package,third_party,created_date)USING utf8)) LIKE '%".$search_term."%'";
                    $sql.=" AND is_online='1'";
                    $sql.=" AND (boxed=0 OR boxed IS NULL)";

                    $sql.=" ORDER BY order_id DESC";


                    // echo $sql;

                    $result = mysqli_query($conn,$sql);
                    //$result = $this->db->like("barcode","CP87");
                    if (mysqli_num_rows($result) > 0)
                    {
                        //echo form_open("agents/changing");
                        echo "<table class='table table-hover small'>";
                        echo "<tr>";
                        //echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders'))."</th>";
                        echo "<th>№</th>"; 
                        echo "<th>Үүсгэсэн огноо</th>"; 
                        echo "<th>Хүлээн авагч</th>"; 
                        echo "<th>Хүлээн авагчын утас</th>"; 
                        echo "<th>Barcode</th>"; 
                        echo "<th>Хоног</th>"; 
                        echo "<th>Төлөв</th>"; 
                        echo "<th>Жин</th>"; 
                        echo "<th>Төлбөр</th>";
                        echo "<th>Үлдэгдэл</th>";                        
                        echo "</tr>";
                        $count=1;$total_weight=0;$total_price=0;

                        while ($data = mysqli_fetch_array($result))
                        {  
                            $created_date=$data["created_date"];
                            $order_id=$data["order_id"];
                            $weight=$data["weight"];
                            $price=$data["price"];
                            
                            $receiver_id=$data["receiver"];
                            $proxy=$data["proxy_id"];
                            $proxy_type=$data["proxy_type"];

                            $receiver=customer($receiver_id,"||");

                            $receiver_info = explode("||", $receiver);
                            if (array_key_exists(2, $receiver_info)) $surname  = $receiver_info[2]; else $surname="";
                            //echo $count.$receiver."[".count($receiver_info)."]<br>";
                            $barcode=$data["barcode"];
                            $description=$data["package"];
                            $Package_advance = $data["advance"];
                            $Package_advance_value = $data["advance_value"];
                            $third_party = $data["third_party"];
                            $extra=$data["extra"];
                            $print=$data["print"];
                            $status=$data["status"];
                            $is_branch = $data["is_branch"];
                            $total_weight+=floatval($weight);
                            $total_price+=floatval($Package_advance_value);
                            $tr=0;
                            $days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;

                            if ($receiver_id!="" &&$status=='order'&&!$tr)
                            {echo "<tr class='blue' title='Хүлээн авагч тодорхойгүй'>"; $tr=1; $class="blue";}
                            
                            if ($receiver_id!=1&&$status=='filled'&&!$tr)
                            {echo "<tr class='green' title='Хүлээн авагч бөглөсөн'>"; $tr=1;$class="green";}
                            
                            
                              if ($Package_advance==1&&!$tr)
                            {echo "<tr class='red' title='Үлдэгдэл:".$Package_advance_value."$'>"; $tr=1; $class="red";}
                            
                            if ($status=='weight_missing'&&!$tr)
                            {echo "<tr class='yellow' title='Жин бөглөгдөөгүй байна:'>"; $tr=1; $class="yellow";}
                    
                            if ($status=='received'&&!$tr)
                            {echo "<tr class='yellow' title='Жин бөглөгдөөгүй байна:'>"; $tr=1; $class="maroon";}
                            
                            if($status=="warehouse"&&$extra!="") $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status; 
                            if (!$tr) echo "<tr>";else $tr=0;
                           echo "<td class='$class'><span class='$class'></span>".$count++."</td>"; 
                           echo "<td  class='$class'>".substr($created_date,0,10)."</td>"; 
                            echo "<td>";
                            echo "<a href='customers?action=detail&id=".$receiver_id."'>".$receiver_info[0]."</a>";
                            if ($proxy<>0) echo "<br>";
                            if ($proxy_type==1) echo "<span style='color:#F00' title='Public proxy'>";
                                echo proxy2($proxy,$proxy_type,"name");
                            if ($proxy_type==1) echo "</span>";
                            echo "</td>";
                            echo "<td>".customer($receiver_id,"tel")."</td>"; 
                            echo "<td>";
                            echo $barcode;
                            echo "<br>";

                            if ($third_party!="")
                                echo $third_party;
                            if ($is_branch) echo '<span class="badge bg-secondary">DE</span>';

                            echo "</td>"; 
                            echo "<td  class='$class'>".$days."</td>"; 
                            echo "<td  class='$class'>".$temp_status."</td>";
                            echo "<td  class='$class'>"; echo $weight; if($weight>0) "Kg";echo "</td>"; 
                            echo "<td  class='$class'>";
                            if ($is_branch)  echo number_format(cfg_price_branch($weight),2); else echo number_format(cfg_price($weight),2);
                            echo "$</td>"; 
                            ?>
                            <td class="<?=$class;?>" >
                                <div class="btn-group">
                                    <a href="?action=detail&id=<?=$order_id;?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    <a href="cp72?id=<?=$order_id;?>" title="CP72 хэвлэх" target="_blank" class="btn btn-warning btn-sm"><i class="fa fa-print"></i></a><br>
                                </div>
                            </td>
                    <?php                    
                            
                        echo "</tr>";

                        } 
                        echo "<tr><td colspan='8'>Нийт</td><td>$total_weight</td><td>".cfg_price($total_weight)."</td><td></td></tr>";

                        echo "</table>";
                        
                        /*$options = array(
                                    //''  => 'Шинэ төлөвийн сонго',
                                    //'delivered'  => 'Хүргэж өгөх',
                                    'onair'    => 'Онгоцоор ирж байгаа',
                                    // 'warehouse'   => 'Агуулахад орсон',
                                    //'custom' => 'Гааль',
                                    // 'delete' => 'Barcode устгах',
                                    );


                        echo form_dropdown('options', $options, '');
                        echo "<div id='more'></div>";
                        echo form_submit("submit","өөрчил");
                        echo form_close();*/
                        
                        echo "</table>";

                    }
                    else echo "Илгээмж олдсонгүй<br>";
                }               

                if ($action=="detail")
                {
                    if (isset($_GET["id"])) 
                    {
                        $order_id = intval($_GET["id"]);
                        $sql = "SELECT * FROM orders WHERE order_id=".$order_id." AND is_online='1'";
                        $result = mysqli_query($conn,$sql);

                        if (mysqli_num_rows($result) == 1)
                        {
                                $data = mysqli_fetch_array($result);
                                $created_date=$data["created_date"];
                                $order_id=$data["order_id"];
                                $sender_id=$data["sender"];
                                $receiver_id=$data["receiver"];
                                $deliver_id=$data["deliver"];
                                $barcode=$data["barcode"];
                                $package=$data["package"];
                                $insurance=$data["insurance"];
                                $insurance_value=$data["insurance_value"];
                                $Package_advance=$data["advance"];
                                $Package_advance_value=$data["advance_value"];
                                $way=$data["way"];
                                $inside=$data["inside"];
                                $deliver_time=$data["deliver_time"];
                                $return_type=$data["return_type"];
                                $return_day=$data["return_day"];
                                $return_way=$data["return_way"];
                                $return_address=$data["return_address"];
                                $transport=$data["transport"];
                                $status=$data["status"];
                                $timestamp=$data["timestamp"];
                                $extra=$data["extra"];
                                $third_party=$data["third_party"];
                                $extratracks=$data["extratracks"];
                        
                                //SENDER 
                               
                                $sender_name=customer($sender_id,"name");
                                $sender_surname=customer($sender_id,"surname");
                                $sender_contact=customer($sender_id,"tel");
                                $sender_address=customer($sender_id,"address");
                                $sender_rd=customer($sender_id,"rd");

                                $reciever_name=customer($receiver_id,"name");
                                $reciever_surname=customer($receiver_id,"surname");
                                $reciever_contact=customer($receiver_id,"tel");
                                $reciever_address=customer($receiver_id,"address");
                                $reciever_rd=customer($receiver_id,"rd");


                                $deliver_name=customer($deliver_id,"name");
                                $deliver_surname=customer($deliver_id,"surname");
                                $deliver_contact=customer($deliver_id,"tel");
                                $deliver_address=customer($deliver_id,"address");
                                $deliver_rd=customer($deliver_id,"rd");

                        
                                $package_array=explode("##",$package);
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
                            
                        
                        
                                echo "<table class='table table-hover'>";
                                echo "<tr><td>Илгээмжийн огноо</td><td>".$created_date."</td></tr>";
                                echo "<tr><td>Хүргэлт</td><td>";if($transport) echo "Хүргэлттэй"; else echo "Хүргэлтгүй"; echo "</td></tr>";

                                echo "<tr><th colspan='2'><h4>Хүлээн авагч</h4></th></tr>";
                                echo "<tr><td>Нэр</td><td>".$reciever_name."</td></tr>" ;
                                echo "<tr><td>Овог</td><td>".$reciever_surname."</td></tr>" ;
                                echo "<tr><td>РД</td><td>".$reciever_rd."</td></tr>" ;
                                echo "<tr><td>Утас</td><td>".$reciever_contact."</td></tr>" ;
                                echo "<tr><td>Хаяг</td><td>".$reciever_address."</td></tr>" ;
                                if ($deliver_id!=0)
                                {
                                echo "<tr><th colspan='2'><h4>Гардан авсан</h4></th></tr>";
                                echo "<tr><td>Нэр</td><td>".$deliver_name."</td></tr>" ;
                                echo "<tr><td>Утас</td><td>".$deliver_contact."</td></tr>" ;
                                }
                            
                                echo "<tr><td>Track</td><td>".$third_party."</td></tr>" ;
                                echo "<tr><td>Barcode</td><td>".$barcode."</td></tr>" ;
                                echo "<tr><td>Extra track</td><td>".$extratracks."</td></tr>" ;
                                echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package1_name ($package1_num)</td></tr>";
                                if ($package2_name!="")
                                echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package2_name ($package2_num)</td></tr>";
                                if ($package3_name!="")
                                echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package3_name ($package3_num)</td></tr>";
                                if ($package3_name!="")
                                echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package4_name ($package4_num)</td></tr>";
                           
                                
                                if ($Package_advance)
                                {
                                //echo "<tr><td>Үлдэгдэл</td><td>Үлдэгдэлтэй</td></tr>" ;
                                echo "<tr><td>Үлдэгдэлийн хэмжээ</td><td>".$Package_advance_value."$</td></tr>" ;		
                                }
                                else echo "<tr><td>Үлдэгдэл</td><td>Үлдэгдэлгүй</td></tr>" ;
                         
                                
                                echo "<tr><td>Статус</td><td>".$status."(".$timestamp.")</td></tr>";
                                if($status=="warehouse") echo "<tr><td>Тавиур</td><td>".$extra."-р тавиур</td></tr>";
                                echo "</table>";                            
                            
                        }
                        else echo "Илгээмж олдсонгүй";
                    }
                    else echo "Илгээмжийн дугаар олдсонгүй";
                }

                if ($action=="search")
                {
                    ?>

                    <div class="panel panel-primary">
                        <div class="panel-heading">Баазаас трак хайх</div>
                        <div class="panel-body">
                            <form action="?action=searching" method="post">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" required autofocus>
                                    <button type="submit" class="btn btn-success">Хайх</button>
                                </div>
                            </form>                               
                        </div>
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading">DELAWARE-c трак хайх</div>
                        <div class="panel-body">

                            <form action="?action=searching_branch" method="post">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" required autofocus>
                                    <button type="submit" class="btn btn-success">Хайх</button>
                                </div>
                            </form>  

                        </div>
                    </div>
                    <?php                    
                }

                if ($action=="searching")
                {
                        $track= mysqli_real_escape_string($conn, $_POST["search"]);

                        $order_id = tracksearch($track);

                        if ($order_id!="")
                        {
                            // Search from entire database without agent or is_online filters
                            $sql = "SELECT * FROM orders WHERE order_id = ".intval($order_id);
                            $result = mysqli_query($conn,$sql);

                            if (mysqli_num_rows($result) > 0)
                            {
                                //echo form_open("agents/changing");
                                echo "<table class='table table-hover small'>";
                                echo "<tr>";
                                //echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders'))."</th>";
                                echo "<th>№</th>"; 
                                echo "<th>Үүсгэсэн огноо</th>"; 
                                echo "<th>Хүлээн авагч</th>"; 
                                echo "<th>Хүлээн авагчын утас</th>"; 
                                echo "<th>Barcode</th>"; 
                                echo "<th>Хоног</th>"; 
                                echo "<th>Төлөв</th>"; 
                                echo "<th>Жин</th>"; 
                                echo "<th>Төлбөр</th>";
                                //echo "<th>Үлдэгдэл</th>";
                                echo "<th></th>"; 
                                echo "</tr>";
                                $count=1;$total_weight=0;$total_price=0;
        
                                while ($data = mysqli_fetch_array($result))
                                {  
                                    $created_date=$data["created_date"];
                                    $order_id=$data["order_id"];
                                    $weight=$data["weight"];
                                    $price=$data["price"];
                                    
                                    $receiver_id=$data["receiver"];
                                    $proxy=$data["proxy_id"];
                                    $proxy_type=$data["proxy_type"];
        
                                    $receiver=customer($receiver_id,"||");
        
                                    $receiver_info = explode("||", $receiver);
                                    if (array_key_exists(2, $receiver_info)) $surname  = $receiver_info[2]; else $surname="";
                                    //echo $count.$receiver."[".count($receiver_info)."]<br>";
                                    $barcode=$data["barcode"];
                                    $description=$data["package"];
                                    $Package_advance = $data["advance"];
                                    $Package_advance_value = $data["advance_value"];
                                    $third_party = $data["third_party"];
                                    $extra=$data["extra"];
                                    $print=$data["print"];
                                    $status=$data["status"];
                                    $is_branch = $data["is_branch"];
                                    $total_weight+=floatval($weight);
                                    $total_price+=floatval($Package_advance_value);
                                    $tr=0;
                                    $days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;
        
                                    if ($receiver_id!="" &&$status=='order'&&!$tr)
                                    {echo "<tr class='blue' title='Хүлээн авагч тодорхойгүй'>"; $tr=1; $class="blue";}
                                    
                                    if ($receiver_id!=1&&$status=='filled'&&!$tr)
                                    {echo "<tr class='green' title='Хүлээн авагч бөглөсөн'>"; $tr=1;$class="green";}
                                    
                                    
                                      if ($Package_advance==1&&!$tr)
                                    {echo "<tr class='red' title='Үлдэгдэл:".$Package_advance_value."$'>"; $tr=1; $class="red";}
                                    
                                    if ($status=='weight_missing'&&!$tr)
                                    {echo "<tr class='yellow' title='Жин бөглөгдөөгүй байна:'>"; $tr=1; $class="yellow";}
                            
                                    if ($status=='received'&&!$tr)
                                    {echo "<tr class='yellow' title='Жин бөглөгдөөгүй байна:'>"; $tr=1; $class="maroon";}
                                    
                                    // Always initialize temp_status from database status
                                    $temp_status = $status;
                                    if($status=="warehouse" && $extra!="") {
                                        $temp_status = $status." ".$extra."-р тавиур";
                                    } 
                                    if (!$tr) echo "<tr>";else $tr=0;
                                   echo "<td class='$class'><span class='$class'></span>".$count++."</td>"; 
                                   echo "<td  class='$class'>".substr($created_date,0,10)."</td>"; 
                                    echo "<td>";
                                    echo "<a href='customers?action=detail&id=".$receiver_id."'>".$receiver_info[0]."</a>";
                                    if ($proxy<>0) echo "<br>";
                                    if ($proxy_type==1) echo "<span style='color:#F00' title='Public proxy'>";
                                        echo proxy2($proxy,$proxy_type,"name");
                                    if ($proxy_type==1) echo "</span>";
                                    echo "</td>";
                                    echo "<td>".customer($receiver_id,"tel")."</td>"; 
                                    echo "<td>";
                                    echo $barcode;
                                    echo "<br>";
        
                                    if ($third_party!="")
                                        echo $third_party;
                                    if ($is_branch) echo '<span class="badge badge-success">DE</span>';
        
                                    echo "</td>"; 
                                    echo "<td  class='$class'>".$days."</td>"; 
                                    echo "<td  class='$class'>".$temp_status."</td>";
                                    echo "<td  class='$class'>"; echo $weight; if($weight>0) "Kg";echo "</td>"; 
                                    echo "<td  class='$class'>";
                                    if ($is_branch)  echo cfg_price_branch($weight); else echo cfg_price($weight);
                                    echo "$</td>"; 
                                    ?>
                                    <td class="<?=$class;?>" >
                                        <a href="?action=detail&id=<?=$order_id;?>">More</a><br>
                                        <a href="cp72?id=<?=$order_id;?>" title="CP72 хэвлэх" target="_blank">Print</a><br>
                                    </td>
                    <?php                    
                                    
                                echo "</tr>";
        
                                } 
                                echo "<tr><td colspan='8'>Нийт</td><td>$total_weight</td><td>".cfg_price($total_weight)."</td><td></td></tr>";
        
                                echo "</table>";
                                
                                /*$options = array(
                                            //''  => 'Шинэ төлөвийн сонго',
                                            //'delivered'  => 'Хүргэж өгөх',
                                            'onair'    => 'Онгоцоор ирж байгаа',
                                            // 'warehouse'   => 'Агуулахад орсон',
                                            //'custom' => 'Гааль',
                                            // 'delete' => 'Barcode устгах',
                                            );
        
        
                                echo form_dropdown('options', $options, '');
                                echo "<div id='more'></div>";
                                echo form_submit("submit","өөрчил");
                                echo form_close();*/
                                
                                echo "</table>";
        
                            }
                            else echo "Илгээмж олдсонгүй<br>";

                        }
                        else 
                        {
                            $track = strtolower($track);
                            $track = mysqli_real_escape_string($conn, $track);

                            $sql="SELECT orders.*,customer.name,customer.tel FROM orders LEFT JOIN customer ON orders.receiver=customer.customer_id WHERE ";

                            // Search all orders from entire database regardless of agent, status, or boxed status
                            $sql.=" LOWER(CONVERT(CONCAT_WS(orders.barcode,orders.package,customer.name,customer.tel,orders.third_party)USING utf8)) LIKE '%".$track."%' ORDER BY orders.created_date DESC"; 
                           
                            $result = mysqli_query($conn,$sql);
                            //$result = $this->db->like("barcode","CP87");
                            if (mysqli_num_rows($result) > 0)
                            {
                                //echo form_open("agents/changing");
                                echo "<table class='table table-hover small'>";
                                echo "<tr>";
                                //echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders'))."</th>";
                                echo "<th>№</th>"; 
                                echo "<th>Үүсгэсэн огноо</th>"; 
                                echo "<th>Хүлээн авагч</th>"; 
                                echo "<th>Хүлээн авагчын утас</th>"; 
                                echo "<th>Barcode</th>"; 
                                echo "<th>Хоног</th>"; 
                                echo "<th>Төлөв</th>"; 
                                echo "<th>Жин</th>"; 
                                echo "<th>Төлбөр</th>";
                                //echo "<th>Үлдэгдэл</th>";
                                echo "<th></th>"; 
                                echo "</tr>";
                                $count=1;$total_weight=0;$total_price=0;
        
                                while ($data = mysqli_fetch_array($result))
                                {  
                                    $created_date=$data["created_date"];
                                    $order_id=$data["order_id"];
                                    $weight=$data["weight"];
                                    $price=$data["price"];
                                    
                                    $receiver_id=$data["receiver"];
                                    $proxy=$data["proxy_id"];
                                    $proxy_type=$data["proxy_type"];
        
                                    $receiver=customer($receiver_id,"||");
        
                                    $receiver_info = explode("||", $receiver);
                                    if (array_key_exists(2, $receiver_info)) $surname  = $receiver_info[2]; else $surname="";
                                    //echo $count.$receiver."[".count($receiver_info)."]<br>";
                                    $barcode=$data["barcode"];
                                    $description=$data["package"];
                                    $Package_advance = $data["advance"];
                                    $Package_advance_value = $data["advance_value"];
                                    $third_party = $data["third_party"];
                                    $extra=$data["extra"];
                                    $print=$data["print"];
                                    $status=$data["status"];
                                    $is_branch = $data["is_branch"];
                                    $total_weight+=floatval($weight);
                                    $total_price+=floatval($Package_advance_value);
                                    $tr=0;
                                    $days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;
        
                                    if ($receiver_id!="" &&$status=='order'&&!$tr)
                                    {echo "<tr class='blue' title='Хүлээн авагч тодорхойгүй'>"; $tr=1; $class="blue";}
                                    
                                    if ($receiver_id!=1&&$status=='filled'&&!$tr)
                                    {echo "<tr class='green' title='Хүлээн авагч бөглөсөн'>"; $tr=1;$class="green";}
                                    
                                    
                                      if ($Package_advance==1&&!$tr)
                                    {echo "<tr class='red' title='Үлдэгдэл:".$Package_advance_value."$'>"; $tr=1; $class="red";}
                                    
                                    if ($status=='weight_missing'&&!$tr)
                                    {echo "<tr class='yellow' title='Жин бөглөгдөөгүй байна:'>"; $tr=1; $class="yellow";}
                            
                                    if ($status=='received'&&!$tr)
                                    {echo "<tr class='yellow' title='Жин бөглөгдөөгүй байна:'>"; $tr=1; $class="maroon";}
                                    
                                    // Always initialize temp_status from database status
                                    $temp_status = $status;
                                    if($status=="warehouse" && $extra!="") {
                                        $temp_status = $status." ".$extra."-р тавиур";
                                    } 
                                    if (!$tr) echo "<tr>";else $tr=0;
                                   echo "<td class='$class'><span class='$class'></span>".$count++."</td>"; 
                                   echo "<td  class='$class'>".substr($created_date,0,10)."</td>"; 
                                    echo "<td>";
                                    echo "<a href='customers?action=detail&id=".$receiver_id."'>".$receiver_info[0]."</a>";
                                    if ($proxy<>0) echo "<br>";
                                    if ($proxy_type==1) echo "<span style='color:#F00' title='Public proxy'>";
                                        echo proxy2($proxy,$proxy_type,"name");
                                    if ($proxy_type==1) echo "</span>";
                                    echo "</td>";
                                    echo "<td>".customer($receiver_id,"tel")."</td>"; 
                                    echo "<td>";
                                    echo $barcode;
                                    echo "<br>";
        
                                    if ($third_party!="")
                                        echo $third_party;
                                    if ($is_branch) echo '<span class="badge badge-success">DE</span>';
        
                                    echo "</td>"; 
                                    echo "<td  class='$class'>".$days."</td>"; 
                                    echo "<td  class='$class'>".$temp_status."</td>";
                                    echo "<td  class='$class'>"; echo $weight; if($weight>0) "Kg";echo "</td>"; 
                                    echo "<td  class='$class'>";
                                    if ($is_branch)  echo cfg_price_branch($weight); else echo cfg_price($weight);
                                    echo "$</td>"; 
                                    ?>
                                    <td class="<?=$class;?>" >
                                        <a href="?action=detail&id=<?=$order_id;?>">More</a><br>
                                        <a href="cp72?id=<?=$order_id;?>" title="CP72 хэвлэх" target="_blank">Print</a><br>
                                    </td>
                    <?php                    
                                    
                                echo "</tr>";
        
                                } 
                                echo "<tr><td colspan='8'>Нийт</td><td>$total_weight</td><td>".cfg_price($total_weight)."</td><td></td></tr>";
        
                                echo "</table>";
                                
                                /*$options = array(
                                            //''  => 'Шинэ төлөвийн сонго',
                                            //'delivered'  => 'Хүргэж өгөх',
                                            'onair'    => 'Онгоцоор ирж байгаа',
                                            // 'warehouse'   => 'Агуулахад орсон',
                                            //'custom' => 'Гааль',
                                            // 'delete' => 'Barcode устгах',
                                            );
        
        
                                echo form_dropdown('options', $options, '');
                                echo "<div id='more'></div>";
                                echo form_submit("submit","өөрчил");
                                echo form_close();*/
                                
                                echo "</table>";
        
                            }
                            else echo "Илгээмж олдсонгүй<br>";
                        }

                }

                if ($action=="searching_branch")
                {
                    ?>
                    <div class="panel panel-success">
                    <div class="panel-heading">Delaware Трак хайлтын үр дүн</div>
                    <div class="panel-body">
                <?php 
                    $track = $_POST["search"];
                    $result = mysqli_query($conn,"SELECT branch_inventories.*,driver,contact FROM branch_inventories LEFT JOIN branch_transport ON branch_inventories.transport=branch_transport.id WHERE track='".$track."'");

                    if (mysqli_num_rows($result) == 1)
                    {
                        $data = mysqli_fetch_array($result);
                        
                        echo "<table class='table table-hover'>";
                        echo "<tr><td>Трак уншуулсан</td><td>".$data["created_date"]."</td></tr>";
                        echo "<tr><td>Трак</td><td>".$track."</td></tr>";
                        echo "<tr><td>Коммент</td><td>".$data["comment"]."</td></tr>";
                        echo "<tr><td>Жолооч</td><td>".$data["driver"]."</td></tr>";
                        echo "<tr><td>Жолоочын утас</td><td>".$data["contact"]."</td></tr>";
                        echo "</table>";

                    }
                    else echo "Delaware-д энэ трак бүртгэлгүй";

                    ?>
                    </div> <!--side_menu-->
                    </div> <!--right_side-->

                    <?php                    
                }

                if ($action=="branch")
                {
                    if (isset($_GET["transport_id"])) $transport_id=intval($_GET["transport_id"]); else $transport_id=0; 

                    if ($transport_id>0)
                    {
                        $count =0;
                        echo '<div class="panel panel-primary">';
                        echo '<div class="panel-heading">Track</div>';
                            echo '<div class="panel-body">';
                                echo "<table class='table table-hover small' id='table'>";
                                echo "<tr>";
                                    echo "<th></th>"; 
                                    echo "<th>Зураг</th>"; 
                                    echo "<th>Бүртгэсэн</th>"; 
                                    echo "<th>Трак</th>"; 
                                    echo "<th>Тайлбар</th>"; 
                                echo "</tr>";
                                $sql ="SELECT * FROM branch_inventories WHERE transport='$transport_id'";
                                $result = mysqli_query($conn,$sql);

                                while ($data = mysqli_fetch_array($result))
                                { 
                                    echo "<tr>";
                                        echo "<td>".++$count."</td>"; 
                                        echo "<td><img src='../".$data["image"]."' class='w-100'></td>";
                                        echo "<td>".$data["created_date"]."</td>";
                                        echo "<td>".$data["track"]."</td>";
                                        echo "<td>".$data["comment"]."</td>";
                                    echo "</tr>";

                                } 
                                echo "</table>";
                            echo '</div>';
                        echo '</div>';
                    }
                    if ($transport_id==0)
                    {
                            $count =1;
                            ?>
                            <div class="panel">
                                <div class="panel-body">
                                    <table class='table table-hover'>
                                        <tr>
                                            <th></th>
                                            <th>Үүсгэсэн</th>
                                            <th>Жолооч</th>
                                            <th>Утас</th>
                                            <th>Тайлбар</th>
                                            <th>Ачааны тоо</th>
                                            <th>Жин</th>
                                            <th></th>
                                        </tr>
                        
                    <?php                    
                        
                                        $count=1;$total_weight=0;$total_price=0;
                                        $sql ="SELECT * FROM branch_transport ORDER BY id DESC";
                                        $result = mysqli_query($conn,$sql);
                                        while ($data = mysqli_fetch_array($result))    
                                            { 
                                                $transport_id=$data["id"];
                                                $driver=$data["driver"];
                                                $contact=$data["contact"];
                                                $comment=$data["comment"];
                                                $items=$data["items"];
                                                $sum_weight=$data["sum_weight"];
                                                $created_date=$data["created_date"];
                                                ?>
                                                <tr>
                                                    <td><?=$count++;?></td> 
                                                    <td><?=$created_date;?></td> 
                                                    <td><?=$driver;?></td> 
                                                    <td><?=$contact;?></td> 
                                                    <td><?=$comment;?></td> 
                                                    <td><?=$items;?></td> 
                                                    <td><?=$sum_weight;?></td> 
                                                    <td><a href="?action=branch&transport_id=<?=$transport_id;?>">дэлгэрэнгүй</a></td> 
                                                </tr>
                <?php            
                                            }
                                        ?>          
                                    </table>
                                </div>
                            </div>
                    <?php                    
                    }

                }

                if ($action=="insert")
                {
                    ?>
                    <form action="?action=checking" method="POST">
                        <input type="text" name="track" class="form-control mb-3" placeholder="Тrack Жишээ:1Z3882748274926...">
                        <button type="submit" class="btn btn-success">Оруулах</button>
                    </form>
                <?php                    
                }

                if ($action=="insert_de")
                {
                    ?>
                    <form action="?action=checking" method="POST">
                        <div class="d-none"><input type="checkbox" name="delaware" value="1" checked> DE</div>
                        <input type="text" name="track" class="form-control border-primary bg-primary-subtle mb-3" placeholder="Delaware track оруулах">
                        <button type="submit" class="btn btn-success">Оруулах</button>
                    </form>
                <?php                    
                }

                if ($action=="checking")
                {
                    if (isset($_POST["track"]))  $track=$_POST["track"];
                    if (isset($_POST["delaware"])) $delaware=1; else $delaware=0;

                    
                    $track = string_clean($track);



                    $order_id = tracksearch($track);
                    // echo "order id:".$order_id;
                    if ($order_id!="")
                    {
                        $result = mysqli_query($conn,"SELECT * FROM orders WHERE order_id = '$order_id'");
                    
                        //TRACK REGISTERED 
                        if (mysqli_num_rows($result) == 1)
                        {
                            $data = mysqli_fetch_array($result);
                            $order_id=intval($data["order_id"]);
                            $track=$data["third_party"];
                            $receiver_id=$data["receiver"];
                            $created_date=$data["created_date"];
                            $status=$data["status"];
                            $weight=$data["weight"];

                            echo '<div class="alert alert-success" role="alert">';
                            echo 'Track бүртгэлтэй байна. <br>';
                            echo $data["third_party"]."<br>";
                            if ($status =="order") echo 'Хүлээн авагч нь тодорхойгүй байна.<br>';
                            if ($status =="filled") echo "Хүлээн авагч бөглөгдсөн байна. <a href='?action=edit&id=".$order_id."' href='btn btn-primary'>шалгах</a><br>";
                            if ($status =="new") echo "Нисэхэд бэлэн. <a href='?action=edit&id=".$order_id."' href='btn btn-primary'>шалгах</a><br><a href='cp72?id=".$order_id."' class='btn btn-warning' target='new'>CP72 хэвлэх</a><br>";
                            if ($status =="item_missing") echo "Ачааны задаргаа оруулаагүй байна. <a href='?action=edit&id=".$order_id."' href='btn-success'>оруулах</a>";
                            if ($status =="onair") echo "Нисэж буй төлөвт байна. ";
                            if ($status =="custom") echo "Гаальд саатсан. ";
                            if ($status =="warehouse") echo "Агуулахад хүрсэн байна. ";
                            if ($status =="delivered") echo "Хүргэгдсэн байна. ";
                            echo '</div>';
                            if ($status=="weight_missing" || $status=="received" ) 
                                {
                                    ?>
                                    <form action="?action=checking2" method="POST">
                                        <input type="hidden" name="track" value="<?=$track;?>">
                                        <input type="hidden" name="delaware" value="<?=$delaware;?>">
                                        <tr><td>Track</td><td><?=$track;?></td></tr>
                                        <tr><td>Weight /KG/</td><td><input type="text" class="form-control <?=($delaware==1)?'border-primary bg-primary-subtle':'';?>" name="weight" placeholder="Eg:5.4" pattern="[0-9]+(\.[0-9]{1,2})?" title="Зөвхөн тоо эсвэл бутархай тоо оруулна уу (жишээ: 5.4, 10.25)" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></td></tr>
                                        </table>
                                        <button type="submit" class="btn btn-success">Add</button>                                       
                                    </form>
                    <?php                    
                                }
                        }
                        
                        
                        
                        //TRACK REGISTERED ENDS HERE
                        
                    }

                    if ($order_id=="")
                    {
                        $container_id = tracksearch_container($track);
                        if ($container_id!="")
                        
                        $container_id=containersearch($track);

                                if ($container_id!="")	
                                {	
                                        header("Location:container?action=detaul=".$container_id);
                                    
                                }
                                else 
                                {

                                    ?>
                                    <div class="alert alert-danger" role="alert">
                                    Track is not registered with in 2 months. Track can register with it\'s weight.
                                    </div>

                                    <form action="?action=checking2" method="POST">
                                        <input type="hidden" name="track" value="<?=$track;?>">
                                        <input type="hidden" name="delaware" value="<?=$delaware;?>">
                                        <tr><td>Track</td><td><?=$track;?></td></tr>
                                        <tr><td>Weight /KG/</td><td><input type="text" class="form-control <?=($delaware==1)?'border-primary bg-primary-subtle':'';?>" name="weight" placeholder="Eg:5.4" pattern="[0-9]+(\.[0-9]{1,2})?" title="Зөвхөн тоо эсвэл бутархай тоо оруулна уу (жишээ: 5.4, 10.25)" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></td></tr>

                                        <tr><td>Extra tracks</td><td><textarea class="form-control <?=($delaware==1)?'border-primary bg-primary-subtle':'';?>" name="extratracks" placeholder="Илгээмжнд буй бусад тракийг оруулна уу."></textarea></td></tr>
                                        </table>
                                        <button type="submit" class="btn btn-success mt-3">Add</button>                                       
                                    </form>

                    <?php                    
                                }

                    }
                    

                }

                if ($action=="checking2")
                {
                    if (isset($_POST["track"])) $track=$_POST["track"]; else $track="";
                    if (isset($_POST["extratracks"])) $extratracks=$_POST["extratracks"]; else $extratracks="";
                    if (isset($_POST["delaware"])) $delaware=$_POST["delaware"]; else $delaware=0;
                    $track = string_clean($track);
                    
                    $track_eliminated = substr($track,-8,8);
                    if (isset($_POST["weight"])) $weight=$_POST["weight"]; else $weight="";
                    
                    $weight=str_replace(",",".",$weight);
                    $weight=str_replace("Kg","",$weight);
                    $weight=str_replace("KG","",$weight);
                    $weight=str_replace("kg","",$weight);
                    $weight=str_replace("Кг","",$weight);
                    $weight=str_replace("КГ","",$weight);
                    $weight=str_replace("кг","",$weight);
                    
                    if ($track!="" && $weight!="")
                    {
                        // echo $weight;
                        $order_id = tracksearch($track);

                        $is_branch = 0;
                        $result=mysqli_query($conn,"SELECT * FROM branch_inventories WHERE track = '$track'");
                        if (mysqli_num_rows($result) >0) { $price=cfg_price_branch($weight) ; $is_branch =1; } else $price = cfg_price($weight);
            
                        if ($delaware==1) $is_branch =1;
                        //$result=mysqli_query($conn,"SELECT * FROM orders WHERE SUBSTRING(third_party,-8,8) = '$track_eliminated' LIMIT 1");
                        
                        //if (mysqli_num_rows($result) == 1)  // тухай barcode-н жин дутуу хэсэг
                        if ($order_id!="")
                        {
                            $result=mysqli_query($conn,"SELECT * FROM orders WHERE order_id = '$order_id'");
                            $data=mysqli_fetch_array($result);
                            //$order_id=$data["order_id"];
                            //$barcode=$data["barcode"];// track № into barcode
                            $third_party=$data["third_party"];
                            $receiver_id=$data["receiver"];
                            $created_date=$data["created_date"];
                            $status=$data["status"];
                            // $agent_id=$this->session->userdata("agent_id");
                                if ($status=="weight_missing" || $status=="received") 
                                {
                                    if ($receiver_id=="") $new_status="order"; else $new_status="new";

                                    $sql = "UPDATE orders SET                                    
                                    created_date='".date("Y-m-d H:i:s")."',
                                    weight_date='".date("Y-m-d H:i:s")."',
                                    advance=1,
                                    advance_value='$price',		
                                    status='$new_status',
                                    weight='$weight',
                                    is_branch='$is_branch' WHERE order_id ='".$order_id."'";                                    
                                    
                                    // log_write("Track inserting $order_id ".json_encode($data),"Track inserting");
                                    mysqli_query($conn,$sql);
                                    $status=$new_status;
                                    if ($new_status=="new")
                                    {
                                        ?>
                                        <a href="cp72?id=<?=$order_id;?>" class="btn btn-warning">CP72 print</a>
                    <?php                    
                                    }
                                    ?>
                                    <a href="tracks_mini?id=<?=$order_id;?>" class="btn btn-primary">Mini print</a>
                    <?php                    
                                }
            
                        }
                            
                    
                        if ($order_id == "")   
                        {
                            $sql = "INSERT INTO orders (created_date,package,sender,weight,advance,advance_value,barcode,third_party,status,is_online,is_branch,agents,owner,price,receiver,extratracks)
                            VALUES ('".date("Y-m-d H:i:s")."','######################','".USA_OFFICE_id."','$weight',1,'$price','".'GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN'."','$track','order',1,'$is_branch','$g_agent_logged_id',2,0,0,'$extratracks')";
                            
                            if (mysqli_query($conn,$sql)) 
                            {
                                echo '<div class="alert alert-success" role="alert">Order created with weight</div>';
                                $status="order";
                            }
                        
                        }
            
                        if ($is_branch==1) // хэрэглэгч тодорхойгүй ч жинг оруулан шинээр хадгалах хэсэг
                        {
                            echo '<div class="alert alert-warning" role="alert">Delaware track</div>';
                        }
            
            
                        if ($status=='order') // хэрэглэгч тодорхойгүй ч жинг оруулан шинээр хадгалах хэсэг
                        {
                            ?>
                            <form action="?action=checking3" method="post">
                                <input type="hidden" name="track" value="<?=$track;?>" >
                                <input type="text" name="contact" class="form-control" placeholder="99123456" autofocus required>
                                <button type="submit" class="btn btn-success">Add</button>
                            </form>
                    <?php                    
                        }
                    }
                    else echo '<div class="alert alert-danger" role="alert">No Weight or Barcode</div>';
                    

                }

                if ($action=="checking3")
                {
                    ?>
                    <h5>Track: тайлбар</h5>
                    
                <?php                                     
                  $track=$_POST["track"];
                  $track = string_clean($track);
                  $track_eliminated = substr($track,-8,8);
                  if (isset($_POST["contact"])) $contact=$_POST["contact"]; else $contact="";
                  $order_id=tracksearch($track);
                  if ($order_id!="")
                          {
                              $result = mysqli_query($conn,"SELECT * FROM orders WHERE order_id = '$order_id'");
                              $data=mysqli_fetch_array($result);
                              $third_party=$data["third_party"];
                              $receiver_id=$data["receiver"];
                              $created_date=$data["created_date"];
                              $weight=$data["weight"];
                              $status=$data["status"];
                              if ($status=="order") 
                              {
                                  if (substr($contact,0,1)=="K" || substr($contact,0,1)=="К")
                                      {
                                          if (substr($contact,0,1)=="К") $contact="K".substr($contact,1);
                                          $customer_id=6616;
                                          $result = mysqli_query($conn,"SELECT * FROM proxies WHERE customer_id =6616 AND  code='$contact'");
                                          $data=mysqli_fetch_array($result);
                                          $proxy_id=$data["proxy_id"];
                                          $new_status='item_missing';
                                          $sql = "UPDATE orders SET receiver='$customer_id',proxy_id='$proxy_id',proxy_type=0,status='$new_status' WHERE order_id='$order_id'";
                                          mysqli_query($conn,$sql);
                                          ?>
                                          <form action="?action=checking4" method="post">
                                            <input type="hidden" name="track" value="<?=$track;?>">
                                            <p>Карго.мн-р захиалсан ачаа байна.</p>
                                            <table class='table table-hover'>
                                              <tr>
                                                <td><input type='text' name='package1_name' class='form-control' placeholder='Цамц, Цүнх, Утас г.м' required></td>
                                                <td><input type='text' name='package1_num' class='form-control' placeholder='Тоо ширхэг'></td>
                                                <td><input type='text' name='package1_price' class='form-control' placeholder='Үнэ ($)' pattern='[0-9]+(\.[0-9]{1,2})?' title='Зөвхөн тоо эсвэл бутархай тоо оруулна уу (жишээ: 5.4, 10.25)' oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\\..*)\\./g, '$1');\"></td>";
                                              </tr>
                                              <tr>
                                                <td><input type='text' name='package2_name' class='form-control' placeholder='Цамц, Цүнх, Утас г.м' required></td>
                                                <td><input type='text' name='package2_num' class='form-control' placeholder='Тоо ширхэг'></td>
                                                <td><input type='text' name='package2_price' class='form-control' placeholder='Үнэ ($)'></td>
                                              </tr>
                                              <tr>
                                                <td><input type='text' name='package3_name' class='form-control' placeholder='Цамц, Цүнх, Утас г.м' required></td>
                                                <td><input type='text' name='package3_num' class='form-control' placeholder='Тоо ширхэг'></td>
                                                <td><input type='text' name='package3_price' class='form-control' placeholder='Үнэ ($)'></td>
                                              </tr>
                                              <tr>
                                                <td><input type='text' name='package4_name' class='form-control' placeholder='Цамц, Цүнх, Утас г.м' required></td>
                                                <td><input type='text' name='package4_num' class='form-control' placeholder='Тоо ширхэг'></td>
                                                <td><input type='text' name='package4_price' class='form-control' placeholder='Үнэ ($)'></td>
                                              </tr>

                                              </table>

                                            <button type="submit" class="btn btn-success">add</button>
                                          </form>
                <?php                
                                      }
                                  else 
                                  {
                                      $result = mysqli_query($conn,'SELECT * FROM customer WHERE tel="'.$contact.'"');
                                      if (mysqli_num_rows($result) == 1)
                                        {
                                              $costumer_row = mysqli_fetch_array($result);
                                              $costumer_id = $costumer_row["customer_id"];
                                              $name=customer($costumer_id,"name");
                                              $surname =customer($costumer_id,"surname");
                                              
                                              $no_proxy = $costumer_row["no_proxy"];
                                              $new_status="item_missing";
                                          
                                              $sql = "UPDATE orders SET receiver='$costumer_id',status='$new_status' WHERE order_id='$order_id'";
                                              mysqli_query($conn,$sql);

                                              
                                              echo '<div class="alert alert-success" role="alert">Хүлээн авагчтай </div>';
                                              echo '<h3>'.$surname.' овогтой '.$name.' <a href="?action=clean&id='.$order_id.'" class="btn btn-warning pull-right">Биш ахин оруулах</a></h3>';
                                              ?>

                                            <form action="?action=checking4" method="post">
                                                <input type="hidden" name="track" value="<?=$track;?>">
                                                <p>Ачааг шалгаж барааны тайлбарыг заавал оруулна</p>
                                                <table class='table table-hover'>
                                                    <tr>
                                                        <td><input type='text' name='package1_name' class='form-control' placeholder='Цамц, Цүнх, Утас г.м' required></td>
                                                        <td><input type='text' name='package1_num' class='form-control' placeholder='Тоо ширхэг'></td>
                                                        <td><input type='text' name='package1_price' class='form-control' placeholder='Үнэ ($)' pattern='[0-9]+(\.[0-9]{1,2})?' title='Зөвхөн тоо эсвэл бутархай тоо оруулна уу (жишээ: 5.4, 10.25)' oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\\..*)\\./g, '$1');\"></td>";
                                                    </tr>
                                                    <tr>
                                                        <td><input type='text' name='package2_name' class='form-control' placeholder='Цамц, Цүнх, Утас г.м'></td>
                                                        <td><input type='text' name='package2_num' class='form-control' placeholder='Тоо ширхэг'></td>
                                                        <td><input type='text' name='package2_price' class='form-control' placeholder='Үнэ ($)'></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type='text' name='package3_name' class='form-control' placeholder='Цамц, Цүнх, Утас г.м'></td>
                                                        <td><input type='text' name='package3_num' class='form-control' placeholder='Тоо ширхэг'></td>
                                                        <td><input type='text' name='package3_price' class='form-control' placeholder='Үнэ ($)'></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type='text' name='package4_name' class='form-control' placeholder='Цамц, Цүнх, Утас г.м'></td>
                                                        <td><input type='text' name='package4_num' class='form-control' placeholder='Тоо ширхэг'></td>
                                                        <td><input type='text' name='package4_price' class='form-control' placeholder='Үнэ ($)'></td>
                                                    </tr>
                                                </table>

                    <?php                    

                                              $options = array(
                                                    'yes' => 'proxy авна',
                                                    'no' => 'үгүй'
                                                  );
                                              if ($weight<3.8)
                                                  {
                                                      if ($no_proxy==0)
                                                      {
                                                        ?>
                                                        <select name="proxy" class="form-control">
                                                            <option value="yes">Proxy авна</option>
                                                            <option value="no">Үгүй</option>
                                                        </select>
                <?php                                                          
                                                      } 
                                                      else echo "Proxy авдаггүй дугаар<br>";
                                                  }
                                              else echo "Их жинтэй proxy авахгүй<br>";
                                              ?>

                                                <button type="submit" class="btn btn-success">add</button>
                                            </form>
                    <?php                    
                                        }  
                                        else 	
                                        {
                                            echo '<div class="alert alert-danger" role="alert">Хэрэглэгийн утасны дугаар бүртгэлгүй байна. Үүнийг хэрэглэгчээс өөрийн болгоно. </div>';
                                        }
                                  }
                                  
                              }
                              if ($status=="item_missing") 
                              echo '<div class="alert alert-danger" role="alert">Барааны дэлгэрэнгүй бичигдээгүй байна. устгаад ахин оруулна уу.</div>';
                  
                              if ($status=="weight_missing") 
                              echo '<div class="alert alert-danger" role="alert">Жин ороогүй төлөвт байна.</div>';
                                
                          }
                      
                    if ($order_id=="")
                    {
                        $container_id = containersearch($track);
                        if ($container_id!="") 
                            {
                                $query_container_item = mysqli_query($conn,"SELECT * FROM container_item WHERE id =$container_id LIMIT 1");
                                $data = mysqli_fetch_array($query_container_item);
                                $created_date=$data["created_date"];
                                $barcode=$data["barcode"];
                                $track=$data["track"];
                                $sender=$data["sender"];
                                $receiver=$data["receiver"];
                                $proxy_id=$data["proxy_id"];
                                $container_description=$data["container_description"];
                    
                                echo "чингэлэгээр ирэх ачаа";
                    
                                echo "Тайлбар: <b>". $container_description."</b><br>";
                    
                                ?>

                                <form action="?action=checking4" method="post">
                                <input type="hidden" name="track" value="<?=$track;?>">
                                <table class='table table-hover'>
                                    <tr>
                                    <td><input type='text' name='package1_name' class='form-control' placeholder='Цамц, Цүнх, Утас г.м' required></td>
                                    <td><input type='text' name='package1_num' class='form-control' placeholder='Тоо ширхэг'></td>
                                    <td><input type='text' name='package1_price' class='form-control' placeholder='Үнэ ($)'></td>
                                    </tr>
                                    <tr>
                                    <td><input type='text' name='package2_name' class='form-control' placeholder='Цамц, Цүнх, Утас г.м'></td>
                                    <td><input type='text' name='package2_num' class='form-control' placeholder='Тоо ширхэг'></td>
                                    <td><input type='text' name='package2_price' class='form-control' placeholder='Үнэ ($)'></td>
                                    </tr>
                                    <tr>
                                    <td><input type='text' name='package3_name' class='form-control' placeholder='Цамц, Цүнх, Утас г.м' ></td>
                                    <td><input type='text' name='package3_num' class='form-control' placeholder='Тоо ширхэг'></td>
                                    <td><input type='text' name='package3_price' class='form-control' placeholder='Үнэ ($)'></td>
                                    </tr>
                                    <tr>
                                    <td><input type='text' name='package4_name' class='form-control' placeholder='Цамц, Цүнх, Утас г.м'></td>
                                    <td><input type='text' name='package4_num' class='form-control' placeholder='Тоо ширхэг'></td>
                                    <td><input type='text' name='package4_price' class='form-control' placeholder='Үнэ ($)'></td>
                                    </tr>

                                    
                    
                    
                                    <tr><td>Нийт жин эсвэл хэмжээ /кг/(*)</td><td><input type='text' name='weight' id='weight' class='form-control' placeholder='' required pattern='[0-9]+(\.[0-9]{1,2})?' title='Зөвхөн тоо эсвэл бутархай тоо оруулна уу (жишээ: 5.4, 10.25)' oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\\..*)\\./g, '$1');\"></td></tr>";
                                    <tr><td>Авсан төлбөр/$/</td><td><input type='text' name='payment' class='form-control'></td></tr>
                                    <tr><td>Монголд авах төлбөр/$/</td><td><input type='text' name='pay_in_mongolia' class='form-control'></td></tr>
                        
                                    </table>

                                <button type="submit" class="btn btn-success">add</button>
                                </form>

                    <?php                    
                                
                    
                            }
                        else echo $track."[ORder:".$order_id."] Ачааны дугаар буруу байна.";
                    }
                  
                  
                }

                if ($action=="checking4")
                {
                    $track=$_POST["track"];
                    $track = string_clean($track);	
                    $track_eliminated = substr($track,-8,8);
                
                    $order_id= tracksearch($track);
                    if ($order_id!="")
                    {
                        $result = mysqli_query($conn,"SELECT * FROM orders WHERE order_id='$order_id'");
                        $data = mysqli_fetch_array($result);
                        $order_id=$data["order_id"];
                        $customer_id=$data["receiver"];
                        $current_proxy=$data["proxy_id"];
                        $current_proxy_type=$data["proxy_type"];
                        $current_status=$data["status"];
                        $weight=$data["weight"];
                        $barcode=$data["barcode"];
                    
                
                        $package1_name=$_POST["package1_name"];
                        $package1_num =$_POST["package1_num"];
                        $package1_price =intval($_POST["package1_price"]);
                        $package2_name=$_POST["package2_name"];
                        $package2_num =$_POST["package2_num"];
                        $package2_price =intval($_POST["package2_price"]);
                        $package3_name=$_POST["package3_name"];
                        $package3_num =$_POST["package3_num"];
                        $package3_price =intval($_POST["package3_price"]);
                        $package4_name=$_POST["package4_name"];
                        $package4_num =$_POST["package4_num"];
                        $package4_price =intval($_POST["package4_price"]);
                        
                        $package_array = array(
                        $package1_name, $package1_num,$package1_price,
                        $package2_name, $package2_num, $package2_price,
                        $package3_name, $package3_num,$package3_price,
                        $package4_name, $package4_num, $package4_price
                        );
                        
                        $package =implode("##",$package_array);
                        $package_price = $package1_price + $package2_price + $package3_price + $package4_price;
                
                        $proxy_id =0;
                        $proxy_type=0;
                        $no_proxy = customer($customer_id,"no_proxy");
                        //$sql_customer="SELECT no_proxy FROM customer WHERE customer_id='$customer_id' LIMIT 1";
                        //$query_customer = mysqli_query($conn,$sql_customer);
                        //if (mysqli_num_rows($result) == 1)
                        //{
                        //	$row_customer=$query_customer->row();
                        //	$no_proxy=$row_customer->no_proxy;
                        //}
                        //else $no_proxy=0;
                        if (isset($_POST["proxy"])) $proxy =$_POST["proxy"]; else $proxy="no";
                
                        if ($no_proxy==0)
                        {
                            if ($current_proxy==0)
                                {
                                    $query_proxies = mysqli_query($conn,'SELECT * FROM proxies WHERE customer_id="'.$customer_id.'" AND status=0 ORDER BY proxy_id DESC LIMIT 1');
                                    if (mysqli_num_rows($query_proxies)>=1)
                                    {
                                        
                                        while($data_proxies=mysqli_fetch_array($query_proxies))
                                        {
                                            $proxy_id = $data_proxies["proxy_id"];
                                            $proxy_type=0;	
                                        }
                                    }
                                    
                                    
                                    if ($weight<3.8)
                                    {
                                        if ($proxy=='yes' && $proxy_id==0)
                                        {						
                                            $query_proxies = mysqli_query($conn,'SELECT * FROM proxies_public WHERE status=0 ORDER BY RAND()');
                                            if (mysqli_num_rows($query_proxies)>0)
                                                {
                                                    while($data_proxies=mysqli_fetch_array($query_proxies))
                                                    {
                                                        $proxy_id = $data_proxies["proxy_id"];
                                                        $proxy_type=1;
                                                        break;
                                                    }
                                                }
                                            
                                        }
                                        //if ($proxy=='no')
                                        //{
                                            //if ($weight<=3.8)
                                            //{
                                        //		$proxy_id=$current_proxy;
                                        //		$proxy_type=0;
                                            //}
                                        //}
                                    }
                
                                    if ($weight>=3.8 && $proxy_type ==1 )
                                    { $proxy_id =0; $proxy_type =0; }
                                }
                
                            if ($current_proxy!=0) { $proxy_id=$current_proxy; $proxy_type=$current_proxy_type;}
                        }
                
                        // TAKE OWN NAME
                        $order_proxy = mysqli_query($conn,'SELECT * FROM orders WHERE receiver="'.$customer_id.'" AND proxy_id=0 AND status IN ("new")');
                        if (mysqli_num_rows($order_proxy) < 2) 
                        {
                            $proxy_id =0;
                            $proxy_type =0;
                        }
                        // TAKE OWN NAME
                
                        // IF KARGO.mn DONT CHANGE PROXY
                        if($customer_id==6616) 
                        {
                            $proxy_id = $current_proxy;
                            $proxy_type = $current_proxy_type;
                        }
                        // IF KARGO.mn DONT CHANGE PROXY

                        //proxy_type  0-own proxy, 1-public proxy

                        $new_status='new';
                        $sql = "UPDATE orders SET                     
                            package='$package',
                            price ='$package_price',
                            status='$new_status',
                            proxy_id='$proxy_id',
                            proxy_type='$proxy_type' WHERE order_id='$order_id'";
                        
                        if (mysqli_query($conn,$sql))
                            {
                                ?>
                                <a href="cp72?id=<?=$order_id;?>" class="btn btn-warning" target="new">CP72 print</a>
                                <a href="mini?id=<?=$order_id;?>" class="btn btn-danger" target="new">Mini print</a>
                    <?php                    
                                proxy_available($proxy_id,$proxy_type,1);
                                // log_write("Track edit id =$order_id.'SQL' =".implode(",",$data),"track edit");

                                // if (settings("message_pro"))
                                // {
                                //     $tel = customer($customer_id,"tel");
                                //     if (strlen($tel)==8)
                                //     {
                                //         $sms= "Танд: $barcode. Achaa americt hurgegdsen tuluvtei bolloo. 90338585";
                                //         $tel_response = smspro($tel,$sms);
                            
                            
                                //         if ($tel_response=='SUCCESS') 
                                //         {
                                //             $operator_find = operator_find($tel);
                                //             mysqli_query($conn,"INSERT INTO sms (tel,sms,operator,created_date) VALUES ('$tel','$sms','$operator_find','".date("Y-m-d H:i:s")."')");
                                //             alert_div("Хүлээн авагчид мессеж илгээлээ.","success");
                                //         }
                                //         else 
                                //         alert_div("Хүлээн авагчид мессеж илгээхэд алдаа гарлаа.");
                                //     }
                                //     else
                                //     alert_div("Хүлээн авагчийн утасны дугаар алдаатай байна. 8 урттай тоо байх ёстой.");
                                // }
                                // else
                                // alert_div("SMS pro үйлчилгээ хаалттай учир мессеж явуулахгүй");


        


                            }
                        else echo '<div class="alert alert-danger" role="alert">Алдаа:'.$this->db->error().'</div>';
                        
                        echo "<br>";
                
                        //proxy_available($proxy_id,$proxy_type,1);
                
                        //$this->db->where('order_id', $order_id);
                        
                        //if ($this->db->update('orders', $data))
                
                        
                
                        $sql="SELECT orders.* FROM orders WHERE receiver='".$customer_id."' AND status NOT IN('completed','delivered','warehouse','custom','weight_missing','onair') AND (boxed=0 OR boxed IS NULL)";
                        $sql.=" ORDER BY created_date DESC";
                
                        $result = mysqli_query($conn,$sql);
                        $payment_rate = cfg_paymentrate();
                        //$query = $this->db->like("barcode","CP87");
                        if (mysqli_num_rows($result) > 0)
                        {
                            // echo form_open("agents/tracks_changing");
                             echo "<table class='table table-striped small' id='table_dd'>";
                             echo "<thead>";
                             echo "<tr>";
                              // echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders'))."</th>";
                               echo "<th>№</th>"; 
                               echo "<th>Үүсгэсэн огноо</th>"; 
                               echo "<th>Хүлээн авагч</th>"; 
                               echo "<th>Утас</th>"; 
                               echo "<th>Barcode / Track</th>"; 
                               echo "<th>Хайрцаг</th>"; 
                               echo "<th>Хоног</th>"; 
                               echo "<th>Төлөв</th>"; 
                               echo "<th>Жин</th>";
                               echo "<th></th>"; 
                               echo "</tr>";
                                echo "</thead>";
                               echo "<tbody>";
                                $count=1;$total_weight=0;$total_price=0;
                                while ($data = mysqli_fetch_array($result))
                                {  
                                    $created_date=$data["created_date"];
                                    $order_id=$data["order_id"];
                                    $receiver=$data["receiver"];
                                    $weight=$data["weight"];
                                    $price=$data["price"];
                                    $proxy=$data["proxy_id"];
                                    $proxy_type=$data["proxy_type"];
                                    $barcode=$data["barcode"];
                                    $description=$data["package"];
                                    $Package_advance = $data["advance"];
                                    $Package_advance_value = $data["advance_value"];
                                    $third_party = $data["third_party"];
                                    $extra=$data["extra"];
                                    $boxed=$data["boxed"];
                                    $print=$data["print"];
                                    $status=$data["status"];
                                    $total_weight+=floatval($weight);
                                    $total_price+=$Package_advance_value;
                                    $tr=0;
                                    $days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;
                                    if ($receiver!="" &&$status=='order'&&!$tr)
                                        {
                                            echo "<tr class='blue' title='Хүлээн авагч тодорхойгүй'>"; $tr=1; $class="blue";
                                        }
                                    
                                    if ($receiver!=1&&$status=='filled'&&!$tr)
                                        {
                                            echo "<tr class='green' title='Хүлээн авагч бөглөсөн'>"; $tr=1;$class="green";
                                        }
                                    
                                    
                                      if ($Package_advance==1&&!$tr)
                                        {
                                            echo "<tr class='red' title='Үлдэгдэл:".$Package_advance_value."$'>"; $tr=1; $class="red";
                                        }
                                    
                                    if ($status=='weight_missing'&&!$tr)
                                        {
                                            echo "<tr class='yellow' title='Жин бөглөгдөөгүй байна:'>"; $tr=1; $class="yellow";
                                        }
                                    
                                    // Always initialize temp_status from database status
                                    $temp_status = $status;
                                    if($status=="warehouse" && $extra!="") {
                                        $temp_status = $status." ".$extra."-р тавиур";
                                    } 
                                    if (!$tr) echo "<tr>";else $tr=0;
                                   echo "<td class='$class'><span class='$class'></span>".$count++."</td>"; 
                                   echo "<td  class='$class'>".$created_date."</td>"; 
                                    echo "<td class='$class'><a href='customers?action=detail&id=".$receiver."'>".customer($receiver,"name").count_new_receiver($receiver)."<br>".proxy2($proxy,$proxy_type,"name")."</a></td>";
                
                                   echo "<td  class='$class'>".customer($receiver,"tel")."</td>"; 
                                   echo "<td  class='$class'>".$barcode."<br>"; 
                                   if ($third_party!="")
                                    echo "<a href='".track($third_party)."' target='_blank' title='Хаана явна'>$third_party<span class='glyphicon glyphicon-globe'></span></a>";
                                   echo "</td>"; 
                
                                   echo "<td  class='$class'>";
                                   if ($boxed==1) 
                                       {
                                           $result = mysqli_query($conn,"SELECT * FROM boxes_packages WHERE order_id=".$order_id);
                                        if (mysqli_num_rows($result)==1)
                                        {
                                            $row_box = mysqli_fetch_array($result);
                                            $box_id= 	$row_box["box_id"];
                                        }
                
                                        if ($box_id=="")
                                        {
                                            $result=mysqli_query($conn,"SELECT * FROM boxes_packages WHERE barcodes LIKE '%".$barcode."%'");
                                            if (mysqli_num_rows($result)==1)
                                            {
                                                $row_box = mysqli_fetch_array($result);
                                                $box_id= 	$row_box["box_id"];
                                            }
                                        }
                
                                        $result = mysqli_query($conn,"SELECT * FROM boxes WHERE box_id=".$box_id);
                                        if (mysqli_num_rows($result)==1)
                                        {
                                            $row_box = mysqli_fetch_array($result);
                                            $box_name= 	$row_box["name"];
                                        }
                                           echo "box:<a href='boxes?action=detail&id=$box_id'>$box_name</a>";
                                       }
                                       else echo "no box";
                                   echo "</td>";
                
                                   echo "<td  class='$class'>".$days."</td>"; 
                                   echo "<td  class='$class'>".$temp_status."</td>";
                
                                   echo "<td  class='$class'>"; echo $weight;if($weight>0) "Kg";echo "</td>"; 
                                  // echo "<td  class='$class'>".cfg_price($weight)."$</td>"; 
                                   //echo "<td>".anchor('agents/tracks_detail/'.$data["order_id,'<img src="'.base_url().'assets/more.png" class="more" title="дэлгэрэнгүй">')."</td>"; 
                                   echo "<td  class='$class' id='$class'>";
                                   if ($print==0&&$status=="new") 
                                   {
                                    ?>
                                    <a href="cp72?id=<?=$order_id;?>" class="btn btn-warning" target="new">CP72 print</a>
                    <?php                    
                                   }
                                   if ($status=="filled") 
                                   {
                                    ?>
                                    <a href="cp72?id=<?=$order_id;?>" class="btn btn-warning" target="new">CP72 print</a>
                    <?php                    
                                   }
                                   ?>
                                    <a href="orders?action=detail?id=<?=$order_id;?>" class="btn btn-primary">Дэлгэрэнгүй</a>

                    <?php                    
                                   echo "</td>"; 
                
                
                                   echo "</tr>";
                                } 
                                echo "</tbody>";
                                echo "</table>";
                        }
                
                    }
                    else echo '<div class="alert alert-danger" role="alert">Track not registered</div>';  
                }

                if ($action=="checking5")
                {
                    $track=$_POST["track"];
                    $track = string_clean($track);	
                    $track_eliminated = substr($track,-8,8);

                    $contact =$_POST["contact"];
                    $name =$_POST["name"];
                    $address =$_POST["address"];
                    
                    $sql = "INSERT INTO customer (name,tel,address,username,password) VALUES ('$name','$contact','$address','$contact','$contact')";
                    mysqli_query($conn,$sql);
                    $receiver=mysqli_insert_id($conn);	
                                                    

                    $package1_name=$_POST["package1_name"];
                    $package1_num =$_POST["package1_num"];
                    $package1_price =intval($_POST["package1_price"]);
                    $package2_name=$_POST["package2_name"];
                    $package2_num =$_POST["package2_num"];
                    $package2_price =intval($_POST["package2_price"]);
                    $package3_name=$_POST["package3_name"];
                    $package3_num =$_POST["package3_num"];
                    $package3_price =intval($_POST["package3_price"]);
                    $package4_name=$_POST["package4_name"];
                    $package4_num =$_POST["package4_num"];
                    $package4_price =intval($_POST["package4_price"]);
                    
                    $package_array = array(
                    $package1_name, $package1_num, $package1_price,
                    $package2_name, $package2_num, $package2_price,
                    $package3_name, $package3_num, $package3_price,
                    $package4_name, $package4_num, $package4_price
                    );
                    
                    $package =implode("##",$package_array);
                    $package_price = $package1_price + $package2_price + $package3_price + $package4_price;
                    
                    $order_id=trachhsearch($track);
                    if ($order_id!="")
                    {
                        $result =mysqli_query($onn,"SELECT * FROM orders WHERE order_id = 'order_id'");

                        $data = mysqli_fetch_array($result);
                        $order_id=$data["order_id"];

                        $new_status='new';
                        $sql = "UPDATE orders SET receiver='$receiver',package='$package',price='$price',status='$new_status' WHERE order_id='$order_id'";
                        if (mysqli_query($conn,$sql))
                        {
                            ?>
                            <a href="cp72?id=<?=$order_id;?>" class="btn btn-warning" target="new">CP72 print</a>                    
                    <?php                    
                        }
                        else echo '<div class="alert alert-danger" role="alert">Алдаа:'.mysqli_error($conn).'</div>';
                        echo "<br>";
                        ?>
                        <a href="mini?id=<?=$order_id;?>" class="btn btn-danger" target="new">Mini print</a>
                    <?php                    
                    }
                    else echo '<div class="alert alert-danger" role="alert">Track not registered</div>';
                }
                ?>
            </div>

                <?php require_once("views/footer.php");?>

            <div class="content-backdrop fade"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="layout-overlay layout-menu-toggle"></div>
    <div class="drag-target"></div>
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/libs/hammer/hammer.js"></script>
    <script src="assets/vendor/libs/i18n/i18n.js"></script>
    <script src="assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="assets/vendor/js/menu.js"></script>
    <script src="assets/vendor/libs/swiper/swiper.js"></script>
    <script src="assets/js/main.js"></script>

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
        $('#report_table').DataTable({
            layout: {
            topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print','pageLength'],                
                }         
            }
        });
    </script>

    
    <script type="application/javascript">
    $(function() {
            //     $('body').on('keydown', 'input, select, textarea', function(e) {
            //     var self = $(this)
            //     , form = self.parents('form:eq(0)')
            //     , focusable
            //     , next
            //     ;
            //     if (e.keyCode == 13) {
            //         focusable = form.find('input,a,select,button,textarea').filter(':visible');
            //         next = focusable.eq(focusable.index(this)+1);
            //         if (next.length) {
            //             next.focus();
            //         } else {
            //             form.submit();
            //         }
            //         return false;
            //     }
            // });
                
        $("#weight").on('change',function(){
            var str = $(this).val();
            var payment_rate = <?=settings("paymentrate_selfdrop");?>;
            var str = str.replace(",", "."); 
            var str = str.replace("Kg", ""); 
            var str = str.replace("kg", ""); 
            var str = str.replace("KG", ""); 
            var str = str.replace("Кг", ""); 
            var str = str.replace("кг", ""); 
            var str = str.replace("КГ", ""); 
            var weight = parseFloat(str);
            $(this).val(weight);
            if (weight<=0.5)  $('#Package_advance_value').val(10);
            if (weight>0.5 && weight<=1) $('#Package_advance_value').val(payment_rate);
            if (weight>1) {var total = $(this).val()*payment_rate; $('#Package_advance_value').val(total.toFixed(2));}
            });
        $("div.more").hide();

        $( "span#more_toggle" ).click(function() {
                $( "div.more" ).toggle( "fast", function() {});
                if ($(this).html()=="more") 
                $(this).html('<span class="glyphicon glyphicon-menu-up"></span>less'); 
                else $(this).html('<span class="glyphicon glyphicon-menu-down"></span>more');
                });


                
	
	
        $('input[name="sender_contact"]').change(function(){
            $('#sender_result').append('<img src="assets/img/ajax-loader.gif" id="loading">');
            var tel= $('input[name="sender_contact"]').val();
        $.ajax ({
            url: 'customers_check2',
            type:'GET',
            data:'tel='+tel,
            success: function(responce){
                    $('#responce').remove();
                    $('#sender_result').append(responce);
                    $('#sender_result').show(500);
                    $('#loading').remove();
                    if (responce=="Found user") 
                    {
                        
                        $.ajax ({
                        url: 'customers_check2',
                        type:'GET',
                        data:'tel='+tel+'&value=surname',
                        success: function(responce1){
                            $('input[name="sender_surname"]').val(responce1);
                                                    }
                                });	
                                
                        $.ajax ({
                        url: 'customers_check2',
                        type:'GET',
                        data:'tel='+tel+'&value=name',
                        success: function(responce2){
                            $('input[name="sender_name"]').val(responce2);
                                                    }
                                });	
                                
                        $.ajax ({
                        url: 'customers_check2',
                        type:'GET',
                        data:'tel='+tel+'&value=email',
                        success: function(responce3){
                            $('input[name="sender_email"]').val(responce3);
                                                    }
                                });	
                                
                        $.ajax ({
                        url: 'customers_check2',
                        type:'GET',
                        data:'tel='+tel+'&value=address',
                        success: function(responce4){
                            $('textarea[name="sender_address"]').text(responce4);
                                                    }
                                });	
                    }
                    }
            });	
        });

        $('input[name="receiver_contact"]').change(function(){
            $('#sender_result').append('<img src="assets/img/ajax-loader.gif" id="loading">');
            var tel= $('input[name="receiver_contact"]').val();
        $.ajax ({
            url: 'customers_check2',
            type:'GET',
            data:'tel='+tel,
            success: function(responce){
                                        $('#receiver_result').html('');
                                        $('#receiver_result').append(responce);
                                        $('#receiver_result').show(500);	
                                        $('#loading').remove();
                                        if (responce=="Found user") 
                                        {												
                                            $.ajax ({
                                            url: 'customers_check2',
                                            type:'GET',
                                            data:'tel='+tel+'&value=surname',
                                            success: function(responce1){
                                                $('input[name="receiver_surname"]').val(responce1);
                                                                        }
                                                    });	
                                                    
                                            $.ajax ({
                                            url: 'customers_check2',
                                            type:'GET',
                                            data:'tel='+tel+'&value=name',
                                            success: function(responce2){
                                                $('input[name="receiver_name"]').val(responce2);
                                                                        }
                                                    });	
                                                    
                                            $.ajax ({
                                            url: 'customers_check2',
                                            type:'GET',
                                            data:'tel='+tel+'&value=email',
                                            success: function(responce3){
                                                $('input[name="receiver_email"]').val(responce3);
                                                                        }
                                                    });	
                                                    
                                            $.ajax ({
                                            url: 'customers_check2',
                                            type:'GET',
                                            data:'tel='+tel+'&value=address',
                                            success: function(responce4){
                                                $('textarea[name="receiver_address"]').text(responce4);
                                                                        }
                                                    });	
                                        }
                                        }
            });	
        });

        })
    </script>
  </body>
</html>
