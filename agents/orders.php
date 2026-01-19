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
                <style>
                tr.red { 
                    background-color: #ffcdd2 !important; 
                    border-left: 4px solid #f44336 !important;
                }
                tr.red:hover { 
                    background-color: #ef9a9a !important; 
                }
                tr.red td {
                    font-weight: 500;
                }
                </style>
                <?php
                if ($action=="all")
                {                    
                    $sql="SELECT count(*) COUNT_T,sum(weight) SUM_T FROM orders WHERE status='new' AND agents='$g_agent_logged_id' AND is_online='0' GROUP BY status";
                    $result = mysqli_query($conn,$sql);
                    while ($data = mysqli_fetch_array($result))
                        {  
                            $count_total=$data["COUNT_T"];
                            $sum_total=$data["SUM_T"];
                        }

                        $sql="SELECT count(*) COUNT_T,sum(weight) SUM_T FROM orders WHERE status='new' AND agents='$g_agent_logged_id' AND is_online='0' AND advance=1 GROUP BY status";
                        $result = mysqli_query($conn,$sql);
                        while ($data = mysqli_fetch_array($result))
                            {  
                                $count_total2=$data["COUNT_T"];
                                $sum_total2=$data["SUM_T"];
                            }

                        $TOTAL_DIFF = $count_total-$count_total2;
                        $SUM_DIFF = $sum_total-$sum_total2;
                    // echo $sql;



                    // require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');
                    if(isset($_POST["search"])) 
                        {
                        $search_term=str_replace(" ","%",$_POST["search"]);
                        if ($search_term!="") echo "Xайлт:".$search_term."<br>";
                        }
                        else $search_term="";
                    if (isset($_POST["status"])) $search_status=$_POST["status"]; else $search_status='all';

                    if (isset($_POST["status_type"])) $statuts_type=$_POST["status_type"]; else $statuts_type='all';
                    //echo "Хайх:".$search_term."<br>";
                    //echo "search:".$_POST["search"];
                    //echo "<h3>Идэвхитэй захиалгууд</h3>";
                    $sql="SELECT orders.*,senders.name AS s_name,senders.surname AS s_surname,senders.tel AS s_contact,senders.address AS s_address,receivers.surname AS r_surname,receivers.name AS r_name,receivers.tel AS r_contact,receivers.address AS r_address 
                    FROM orders 
                    JOIN customer AS senders ON orders.sender=senders.customer_id 
                    LEFT JOIN customer AS receivers ON orders.receiver=receivers.customer_id";

                    if ($search_status=="all") 
                    $sql.=" WHERE orders.status NOT IN('completed','delivered','warehouse','custom')";
                    if ($search_status=='db')
                    $sql.=" WHERE orders.status IN ('completed','delivered','warehouse','custom','onair','new','order','weight_missing','item_missing','filled')";
                    if ($search_status!="all" && $search_status!='db')
                    $sql.=" WHERE orders.status ='$search_status'";

                    if ($statuts_type=="advance")
                    $sql.=" AND orders.advance=1";

                    //if(isset($_POST["search"])) 
                    $sql.=" AND LOWER(CONVERT(CONCAT_WS(barcode,package,senders.name,senders.tel,receivers.name,receivers.tel,created_date)USING utf8)) LIKE '%".($search_term)."%'";
                    $sql.= " AND agents='$g_agent_logged_id'";
                    $sql.= " AND is_online='0'";
                    $sql.=" ORDER BY created_date DESC";

                    //echo $sql;


                    //echo $sql;
                    echo '<div class="panel panel-primary">';
                    echo '<div class="panel-heading">New-'.$count_total.' ('.number_format($sum_total,2).'Kg) &nbsp;&nbsp;&nbsp;   Монголд төлөх-'.$count_total2.' ('.number_format($sum_total2,2).'Kg) &nbsp;&nbsp;&nbsp; US Paid-'.$TOTAL_DIFF.' ('.number_format($SUM_DIFF,2).'Kg)</div>';
                    echo '<div class="panel-body">';

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
                        echo "<th>Илгээгч</th>"; 
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
                            $sender_id=$data["sender"];
                            $sender=$data["s_name"];
                            $sender_surname=$data["s_surname"];
                            $sender_contact=$data["s_contact"];
                            $sender_address=$data["s_address"];
                            $receiver=$data["r_name"];
                            $receiver_id=$data["receiver"];
                            $receiver_surname=$data["r_surname"];
                            $receiver_contact=$data["r_contact"];
                            $receiver_address=$data["r_address"];
                            $barcode=$data["barcode"];
                            $package=$data["package"];
                            $description=$data["package"];
                            $Package_advance = $data["advance"];
                            $Package_advance_value = $data["advance_value"];
                            $extra=$data["extra"];
                            $status=$data["status"];
                            $total_weight+=intval($weight);
                            //$total_price+=$Package_advance_value;
                            $tr=0;
                            $days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;		
                            
                            if ($Package_advance==1&&!$tr)
                            {echo "<tr class='red' title='Үлдэгдэл:".$Package_advance_value."$'>"; $tr=1;}
                            
                            if($status=="warehouse"&&$extra!="") $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status; 
                            if (!$tr) echo "<tr>";else $tr=0;
                            
                        //echo "<td>".form_checkbox("orders[]",$order_id)."</td>"; 
                        echo "<td>".$count++."</td>"; 
                        echo "<td>".$created_date."</td>"; 
                        echo "<td><a href='customers?action=detail&id=".$sender_id."'>".substr($sender_surname,0,2).".".$sender."</a></td>";
                        echo "<td><a href='customers?action=detail&id=".$receiver_id."'>".substr($receiver_surname,0,2).".".$receiver."</a></td>";
                        echo "<td>".$receiver_contact."</td>"; 
                        echo "<td>".$barcode."</td>"; 
                        echo "<td>".$days."</td>"; 
                        echo "<td>".$temp_status."</td>";
                        echo "<td>".$weight."</td>"; 
                        echo "<td>".$Package_advance_value."</td>"; 
                        // echo "<td>".$Package_advance_value."</td>"; 
                            
                        echo "<td><a href='?action=detail&id=".$order_id."'><i class='ti ti-edit'></i></a></td>"; 

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

                if ($action=="insert")
                {
                    ?>
                    <div class="panel panel-primary">
                    <div class="panel-heading">Илгээмж оруулах</div>
                    <div class="panel-body">
                    <form action="?action=creating" method="post">

                <?php 
                        echo "<table class='table table-hover'>";


                        echo "<tr>";
                        echo "<td>Хүргэлт</td>";
                        echo "<td>";
                        echo '<div class="input-group">';
                        echo '<span class="input-group-addon" id="basic-addon1">Хүргэлттэй</span>';
                        echo '<span class="input-group-addon"><input type="checkbox" name="transport" value="1"></span>';
                        echo ' ';
                        echo "</td>";
                        echo "</tr>";


                        echo "<tr><th colspan='2'><h4>Илгээгч</h4></th></tr>";
                        echo "<tr><td>Утас:(*)</td><td><input type='text' name='sender_contact' class='form-control' required></td></tr>";
                        echo "<tr><td colspan='2'><span id='sender_result' class='alert alert-danger small' role='alert'></span></td></tr>";
                        echo "<tr><td>Нэр(*)</td><td><input type='text' name='sender_name' class='form-control'></td></tr>";
                        echo "<tr><td>Овог</td><td><input type='text' name='sender_surname' class='form-control'></td></tr>";
                        echo "<tr><td>И-мейл(*)</td><td><input type='text' name='sender_email' class='form-control'></td></tr>";
                        echo "<tr><td>Хаяг(*)</td><td><input type='text' name='sender_address' class='form-control'></td></tr>";

                        echo "<tr><th colspan='2'><h4>Хүлээн авагч</h4></th></tr>";
                        echo "<tr><td>Утас:(*)</td><td><input type='text' name='receiver_contact' class='form-control' required>";
                        echo "<span id='receiver_result' class='alert alert-danger' role='alert'></span></td></tr>";
                        echo "<tr><td>Нэр(*)</td><td><input type='text' name='receiver_name' class='form-control'></td></tr>";
                        echo "<tr><td>Овог</td><td><input type='text' name='receiver_surname' class='form-control'></td></tr>";
                        echo "<tr><td>И-мейл(*)</td><td><input type='text' name='receiver_email' class='form-control'></td></tr>";
                        echo "<tr><td>Хаяг(*)</td><td><input type='text' name='receiver_address' class='form-control'></td></tr>";




                        echo "<tr><td>Барааны тайлбар</td><td>";
                            echo "<table class='table table-hover'>";
                            echo "<tr>";
                            echo "<td><input type='text' name='package1_name' class='form-control' placeholder='Цамц, Цүнх, Утас г.м' required></td>";
                            echo "<td><input type='text' name='package1_num' class='form-control' placeholder='Тоо ширхэг'></td>";
                            echo "<td><input type='text' name='package1_price' class='form-control' placeholder='Үнэ ($)'></td>";
                            echo "</tr>";
                            
                            echo "<tr>";
                            echo "<td><input type='text' name='package2_name' class='form-control' placeholder='Цамц, Цүнх, Утас г.м'></td>";
                            echo "<td><input type='text' name='package2_num' class='form-control' placeholder='Тоо ширхэг'></td>";
                            echo "<td><input type='text' name='package2_price' class='form-control' placeholder='Үнэ ($)'></td>";
                            echo "</tr>";
                            
                            echo "<tr>";
                            echo "<td><input type='text' name='package3_name' class='form-control' placeholder='Цамц, Цүнх, Утас г.м'></td>";
                            echo "<td><input type='text' name='package3_num' class='form-control' placeholder='Тоо ширхэг'></td>";
                            echo "<td><input type='text' name='package3_price' class='form-control' placeholder='Үнэ ($)'></td>";
                            echo "</tr>";

                            echo "<tr>";
                            echo "<td><input type='text' name='package4_name' class='form-control' placeholder='Цамц, Цүнх, Утас г.м'></td>";
                            echo "<td><input type='text' name='package4_num' class='form-control' placeholder='Тоо ширхэг'></td>";
                            echo "<td><input type='text' name='package4_price' class='form-control' placeholder='Үнэ ($)'></td>";
                            echo "</tr>";

                            echo "</table>";


                        echo "<tr><td>Нийт жин/кг/(*)</td><td><input type='text' name='weight' class='form-control' id='weight' required></td></tr>";


                        echo "<tr>";
                        echo "<td>Төлбөр</td>";
                        echo "<td>";
                        echo 'Үлдэгдэл төлбөртэй: <div class="input-group">';
                        echo '<span class="input-group-addon" id="basic-addon1">Төлбөр</span>';
                        echo '<span class="input-group-addon"><input type="checkbox" name="Package_advance" value="1" checked></span>';
                        echo "<input type='text' name='Package_advance_value' class='form-control' id='Package_advance_value'>" ;
                        echo "</td>";
                        echo "</tr>";

                        /*echo "<div class='more'>";
                        echo "<div class='box'>";
                        echo "<h4 class='legend'>Илгээмж явах хэлбэр</h4>";
                        echo "<span class='formspan'>Агаараар</span>";
                        echo form_radio('way', 'air', TRUE)."<br>";
                        echo "<span class='formspan'>Газраар</span>";
                        echo form_radio('way', 'surface', FALSE)."<br>";
                        echo "<span class='formspan'>Хосолсон</span>";
                        echo form_radio('way', 'sal', FALSE)."<br>";
                        echo "<h4>Хүргэлтийн хэлбэр</h4>";
                        echo "<span class='formspan'>Express</span>";
                        echo form_radio('deliver_time', 'express', TRUE)."";
                        echo "<span class='formspan'>Advice of delivery</span>";
                        echo form_radio('deliver_time', 'advice', FALSE)."<br>";
                        echo "</div>";



                        echo "<div class='box'>";
                        echo "<h4 class='legend'>Илгээмж доторхи зүйл</h4>";
                        echo form_radio('Package_inside', 'gift',  TRUE);
                        echo "Бэлэг<br>";
                        echo form_radio('Package_inside', 'sample', FALSE);
                        echo "Арилжааны шинж чанаргүй загвар<br>";
                        echo form_radio('Package_inside', 'document', FALSE);
                        echo "Арилжааны шинж чанаргүй бичиг баримт<br>";
                        echo "</div>";


                        echo "<div class='box'>";
                        echo "<h4 class='legend'>Даатгал</h4>";
                        echo "<span class='formspan'>Даатгалтай</span>";
                        echo form_checkbox('insurance', '1')."<br>";
                        echo "<span class='formspan'>Даатгалын төлбөр</span>";
                        echo form_input('insurance_value', '');
                        echo "</div>";


                        echo "<div class='box'>";
                        echo "<h4 class='legend'>Хүргэгдээгүй тохиолдолд</h4>";
                        echo form_radio('Package_return_type', 'return_1',  TRUE);
                        echo "Явуулагч талруу яаралтай буцаах<br>";
                        echo form_radio('Package_return_type', 'return_2',  FALSE);
                        echo "Явуулагч талруу __ өдрийн дараа буцаах";
                        echo " Өдөр";
                        echo form_input('Package_return_day', '')."<br>";
                        echo form_radio('Package_return_type', 'return_3',  TRUE);
                        echo "Өөр хаягруу явуулах"."<br>";
                        echo "Өөр хаяг";
                        echo form_textarea ("Package_return_address","")."<br>";
                        echo form_radio('Package_return_type', 'return_4',  FALSE);
                        echo "Тэнд нь устгах<br>";
                        echo "<h4>Буцах хаягруу явуулах</h4>";
                        echo "<span class='formspan'>Агаараар</span>";
                        echo form_radio('Package_return_way', 'air',  TRUE);
                        echo "<span class='formspan'>Газраар</span>";
                        echo form_radio('Package_return_way', 'surface',  FALSE);
                        echo "</div>";

                        echo "</div>";  //MORE DIV CLOSE


                        echo "<span id='more_toggle'>more</span>";*/
                        echo "</table>";
                    ?>
                        <button type="submit" class="btn btn-success">нэмэх</button>                     
                    </form>
                <?php 
                }

                if ($action=="creating")
                {
                    /* SENDER */
                    $sender_contact = $_POST["sender_contact"];
                    $sender_name = $_POST["sender_name"];
                    $sender_surname = $_POST["sender_surname"];
                    $sender_email = $_POST["sender_email"];
                    $sender_address = $_POST["sender_address"];

                    $query_sender = mysqli_query($conn,'SELECT customer_id FROM customer WHERE tel="'.$sender_contact.'"');
                    if (mysqli_num_rows($query_sender)==0&&$sender_contact!="")
                        {	
                        mysqli_query($conn,"INSERT INTO customer (name,surname,tel,email,address,username,password,status) VALUES ('$sender_name','$sender_surname','$sender_contact','$sender_email','$sender_address','$sender_contact','$sender_contact','regular')");                    
                        $sender_id=mysqli_insert_id($conn)  ;
                        }
                    else {
                        $data = mysqli_fetch_array($query_sender);
                        $sender_id = $data["customer_id"];

                        // $row=$query_sender->row();
                        // $sender_id=$data["customer_id;
                        // $data = array(
                        //     'name'=>$sender_name,
                        //     'surname'=>$sender_surname,
                        //     'email'=>$sender_email,
                        //     'address'=>$sender_address,
                        //     );
                        // $this->db->where('customer_id', $sender_id);
                        // $this->db->update('customer', $data);
                        }	
                    //if (!isset($sender_id)) $sender_id =1;
                    /* RECEIVER */
                    $receiver_contact = $_POST["receiver_contact"];
                    $receiver_name = $_POST["receiver_name"];
                    $receiver_surname = $_POST["receiver_surname"];
                    $receiver_email = $_POST["receiver_email"];
                    $receiver_address = $_POST["receiver_address"];
                    $query_receiver = mysqli_query($conn,'SELECT customer_id FROM customer WHERE tel="'.$receiver_contact.'"');
                    
                    if (mysqli_num_rows($query_receiver)==0&&$receiver_contact!="")
                        {	
                            mysqli_query($conn,"INSERT INTO customer (name,surname,tel,email,address,username,password,status) 
                            VALUES ('$receiver_name','$receiver_surname','$receiver_contact','$receiver_email','$receiver_address','$receiver_contact','$receiver_contact','regular')");                    
                            $receiver_id=mysqli_insert_id($conn)  ;
    
                        }
                    else {
                        $data = mysqli_fetch_array($query_receiver);
                        $receiver_id = $data["customer_id"];
                        // $row=$query_receiver->row();
                        // $receiver_id=$data["customer_id;
                        // $data = array(
                        //     'name'=>$receiver_name,
                        //     'surname'=>$receiver_surname,
                        //     'email'=>$receiver_email,
                        //     'address'=>$receiver_address,
                        //     );
                        // $this->db->where('customer_id', $receiver_id);
                        // $this->db->update('customer', $data);
                        }	
                    

                    $created_date = date("Y-m-d H:i:s");
                    /* Package */
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
                    $package2_name, $package2_num,$package2_price,
                    $package3_name, $package3_num,$package3_price,
                    $package4_name, $package4_num,$package4_price
                    );
                    
                    $package =implode("##",$package_array);
                    $package_price = $package1_price + $package2_price + $package3_price + $package4_price;

                    $weight = $_POST["weight"];
                    $weight=str_replace(",",".",$weight);
                    $weight=str_replace("kg","",$weight);
                    $weight=str_replace("Kg","",$weight);
                    $weight=str_replace("KG","",$weight);
                    $weight=str_replace("Кг","",$weight);
                    $weight=str_replace("KГ","",$weight);
                    $weight=str_replace("кг","",$weight);

                    //$price = $_POST["price"];
                    //$third_party = $_POST["third_party"];
                    //$way = $_POST ["way"];
                    //$deliver_time = $_POST ["deliver_time"];

                    /* INSIDE */
                    //$Package_inside = $_POST["Package_inside"];


                    /* INSURANCE */
                    //if (isset($_POST["insurance"]))
                    //$insurance = $_POST["insurance"];
                    //else $insurance=0;

                    //$insurance_value =$_POST["insurance_value"];
                    /* RETURN TYPE */
                    //$Package_return_type = $_POST["Package_return_type"];
                    //$Package_return_address = $_POST["Package_return_address"];
                    //$Package_return_day = $_POST["Package_return_day"];
                    //$Package_return_way = $_POST["Package_return_way"];

                    /* ADVANCE */
                    if(isset($_POST["Package_advance"])) $Package_advance = 1; else $Package_advance = 0;
                    if ($Package_advance) $Package_advance_value = round($_POST["Package_advance_value"],2);
                    else $Package_advance_value="";

                    $barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
                    do {
                    $barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
                    $query = mysqli_query($conn,"SELECT order_id FROM orders WHERE barcode='$barcode'");
                    } while (mysqli_num_rows($query) == 1); 
                    $status="new";
                    if(isset($_POST["transport"])) $transport = 1; else $transport=0;
                    $agent_id=$g_agent_logged_id;
                    if ($receiver_id!=1&&$sender_id!=1&$weight !="")
                    {
                
                        $sql = "INSERT INTO orders (created_date,barcode,package,price,weight,third_party,sender,receiver,advance,advance_value,transport,status,agents) 
                        VALUES ('$created_date','$barcode','$package','$package_price','$weight','','$sender_id','$receiver_id','$Package_advance','$Package_advance_value','$transport','$status','$agent_id')";
                        if (mysqli_query($conn,$sql)) 
                        {
                            $order_id = mysqli_insert_id ($conn);

                            echo '<div class="alert alert-success" role="alert">Илгээмжийг орууллаа</div>';
                            echo "<a href='order_cp72?id=".$order_id."' target='new' class='btn btn-warning'>Илгээмж CP72 хэвлэх</a>";
                        // log_write("Order create id =$order_id ".json_encode($data),"order create");

                        }
                            else echo '<div class="alert alert-danger" role="alert">Error:'.mysqli_error($conn).'</span>';
                    }
                }

                if ($action=="detail")
                {
                    if (isset($_GET["id"])) 
                    {
                        $order_id = intval($_GET["id"]);
                        $sql = "SELECT * FROM orders WHERE order_id=".$order_id."";
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
                                ?>
                                <div class="row">
                                    <div class="col-lg-9">
                                        <div class="card">
                                            <div class="card-body">
                <?php 
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
                                            
                                                echo "<tr><td>Barcode</td><td>".$barcode."</td></tr>" ;
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
                                                ?>
                                                
                                            </div>
                                         </div>
                                    </div> 
                                    <div class="col-lg-3">
                                         <div class="card">
                                            <div class="card-body">
                                                <ul class="list-group">
                                                    <li class="list-group-item"><a href="?action=all">All orders</a></li>
                                                    <li class="list-group-item"><a href="?action=insert">Place order</a></li>                                                    
                                                    <li class="list-group-item"><a href="cp72?id=<?=$order_id;?>" target="new">Print CP72</a></li>                                                    
                                                    <li class="list-group-item"><a href="order_cp72?id=<?=$order_id;?>" target="new">Receipt with CP72</a></li>                                                    
                                                    <li class="list-group-item"><a href="?action=delete&id=<?=$order_id;?>">Delete</a></li>

                                                </ul>
                                            </div>
                                         </div>
                                    </div> 
                                </div>
                <?php                        
                        }
                        else echo "Илгээмж олдсонгүй";
                    }
                    else echo "Илгээмжийн дугаар олдсонгүй";
                }

                if ($action=="delete")
                {
                    if (isset($_GET["id"])) 
                    {
                        $order_id = intval($_GET["id"]);
                        $sql = "SELECT * FROM orders WHERE order_id=".$order_id."";
                        $result = mysqli_query($conn,$sql);

                        if (mysqli_num_rows($result) == 1)
                        {
                                $data = mysqli_fetch_array($result);
                                
                                $status=$data["status"];
                                $created_agent_id=$data["agents"];

                                if ( $created_agent_id==$g_agent_logged_id && $status=='new')
                                    {
                                        $sql = "DELETE FROM orders WHERE order_id='".$order_id."' LIMIT 1";
                                        if (mysqli_query($conn,$sql))
                                            alert_div("Захиалгыг амжилттай устгалаа.","success");
                                            else 
                                            alert_div("Алдаа");
                                    }
                                    else 
                                    alert_div("Устгах эрхгүй");                                    
                                         
                        }
                        else alert_div("Илгээмж олдсонгүй"); 
                    }
                    else alert_div("Илгээмжийн дугаар олдсонгүй");
                }
                ?>
            </div>

                <?php  require_once("views/footer.php");?>

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
                $('body').on('keydown', 'input, select, textarea', function(e) {
                var self = $(this)
                , form = self.parents('form:eq(0)')
                , focusable
                , next
                ;
                if (e.keyCode == 13) {
                    focusable = form.find('input,a,select,button,textarea').filter(':visible');
                    next = focusable.eq(focusable.index(this)+1);
                    if (next.length) {
                        next.focus();
                    } else {
                        form.submit();
                    }
                    return false;
                }
            });
                
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
            // if (weight<=0.5)  $('#Package_advance_value').val(10);
            if (weight<=1) $('#Package_advance_value').val(payment_rate);
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
