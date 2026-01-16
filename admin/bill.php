<?
    require_once("config.php");
    require_once("views/helper.php");
    require_once("views/login_check.php");
    require_once("views/init.php");
?>

<link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<body class="sidebar-dark">
    <div class="main-wrapper">

        <div class="page-wrapper">
            

            <div class="page-content">
                
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <style>
                body{padding: 0px;}
                @media print{ .btn {display:none;} hr {border-bottom:2px #000000 solid;}} 
                hr {border-bottom:2px #000000 solid;}
                </style>

                <? if (isset($_GET["deliver_id"])) $deliver_id=$_GET["deliver_id"]; ?>
                <? if (isset($_GET["orders"])) $orders=$_GET["orders"]; ?>
                <? if (isset($_GET["method"])) $method=$_GET["method"]; ?>

                <img src="assets/images/logo.png" style="max-width:300px; width:80%;margin-top: 0px;">  
                      
                <? 	
                    $result_deliver = mysqli_query($conn,'SELECT * FROM customer WHERE customer_id="'.$deliver_id.'"');
                    if(mysqli_num_rows($result_deliver)==1)
                            {
                            $data=mysqli_fetch_array($result_deliver);
                            $deliver_name=$data["name"];
                            $deliver_tel=$data["tel"];
                            }
                    $result_bill =mysqli_query($conn,'SELECT * FROM bills WHERE deliver="'.$deliver_id.'" ORDER BY id DESC LIMIT 1');
                    if(mysqli_num_rows($result_bill)==1)

                            {
                            $data_bill=mysqli_fetch_array($result_bill);
                            $bill_id=$data_bill["id"];
                            $bill_advance=$data_bill["advance"];
                            //$deliver_tel=$data["tel;
                            }
                     
                    echo "<br>";
                    echo "№".$bill_id;
                    echo "<br>";
                    echo "Гардан авсан: $deliver_name <br>$deliver_tel";
                    echo "<br>";
                    echo date("Y-m-d H:i:s");
                    echo "<br>";
                    if ($method=="cash") echo "Төлбөрийг бэлнээр";
                    if ($method=="pos") echo "Карт уншуулсан";
                    if ($method=="account") echo "Дансаар шилжүүлсэн";
                    if ($method=="later") echo "Дараа тооцоотой";
                    echo "<br>";
                    echo "<br>";
                    
                    $orders_array = explode(',',$orders);
                    $N = count($orders_array);
                    $count=1; $total_weight=0;$total_price=0;$total_advance=0;$total_weight_branch=0;$grand_totat=0;
                        echo '<table>';
                        echo '<tr><td>Ачаа</td><td>Жин</td></tr>';
                        echo '<tr><td colspan="2"><hr></td></tr>';
                        for($i=0; $i < $N; $i++)
                        {
                        $sql="SELECT * FROM orders WHERE order_id='".$orders_array[$i]."' LIMIT 1";
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
                            $weight=floatval($data["weight"]);
                            $advance=$data["advance"];
                            $advance_value=floatval($data["advance_value"]);
                            $status=$data["status"];
                            $method=$data["method"];
                            $is_online  = $data["is_online"];
                            $is_branch=$data["is_branch"];
                            $extra = $data["extra"];
                
                              
                            if($status=="warehouse"&&$extra!="") 
                            $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status;
                            echo "<tr>";
                            echo "<td>".$count++.".".$barcode."<br>".customer($receiver,"name");
                            //echo "<br>"; 
                            //if ($is_online) echo "/collect/"; elseif($advance_value==0) echo "/paid/";
                            
                            echo "</td>";
                            echo "<td>".$weight."Кг</td>";
                               echo "<td>"; if ($is_online) $advance_value."$"; echo "</td>"; 
                               echo "</tr>";
                            // if ($is_online) $total_weight+=$weight; else $total_advance+=$advance_value; 
                            if ($is_online==1) 
                                {
                                    if ($is_branch)
                                    $total_weight_branch+=floatval($weight);
                                    else  
                                    $total_weight+=floatval($weight);
                                }
                                else $total_advance+=$advance_value; 
                
                            }
                            // $total_admin_value+=$admin_value;
                
                        }
                        echo '<tr><td colspan="2"><hr></td></tr>';
                
                        echo "</table>";
                
                        
                        echo '<table class="table">';
                
                        //echo "<tr><td colspan='2'>Нийт жин /Кг/</td><td >$total_weight</td><td></td></tr>";
                        //echo "<tr ><td colspan='2'>Ачааны тооцоо /$/</td><td >".cfg_price($total_weight)."$</td></tr>";
                        //echo "<tr ><td colspan='2'>Дараа тооцоо /$/</td><td >".$total_advance."$</td></tr>";
                        if ($total_advance==0) 
                        $grand_total = cfg_price($total_weight) + cfg_price_branch($total_weight_branch);
                        else $grand_total =$total_advance;
                
                        // $total_price = $total_advance+cfg_price($total_weight);
                        echo "<tr ><td colspan='2'>Илгээмжийн тооцоо /$/ &nbsp;&nbsp;&nbsp;".$bill_advance."$</td></tr>";
                        echo "<tr ><td colspan='2'>Нийт тооцоо /$/ &nbsp;&nbsp;&nbsp;".$grand_total."$</td></tr>";
                        echo "<tr ><td colspan='2'>Нийт төлбөр /₮/&nbsp;&nbsp;&nbsp;".$grand_total*cfg_rate()."₮</td></tr>";
                        echo "</table>";
                    
                        
                    
                        echo "<a onClick='window.print();window.close();' class='btn btn-warning btn-xs'><i class='fa fa-print'></i>Хэвлэх</a>";
                        echo "<P align='center'>Танд баярлалаа</P>...<br>..<br>.";
                            
                ?>
            </div>
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


</body>
</html>    