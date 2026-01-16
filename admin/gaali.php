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
            case "dashboard": $action_title="Хянах самбар";break;
            case "display": $action_title="Бүх Ачаа";break;
            case "new": $action_title="AirBill үүсгэх";break;
            case "adding": $action_title="AirBill үүсгэх";break;
            case "list": $action_title="Агаарын Airbill жагсаалт";break;
            case "container_list": $action_title="Газрын Airbill жагсаалт";break;
            case "fill": $action_title="АirBill-д ачаа оруулах";break;
            case "filling": $action_title="АirBill-д ачаа оруулах";break;
            case "rename": $action_title="АirBill-н нэр засах";break;
            case "renaming": $action_title="АirBill-н нэр засах";break;
            case "box": $action_title="Box оруулах";break;
            case "boxing": $action_title="Box оруулах";break;
            case "container_import": $action_title="Чингэлэг оруулах";break;
            case "container_importing": $action_title="Чингэлэг оруулах";break;
            case "excel": $action_title="Excel Шинэчлэх";break;
            case "item_edit": $action_title="Засах";break;
            case "item_editing": $action_title="Засах";break;
            case "status_change": $action_title="Төлөв өөрчлөх";break;          
            case "detail": $action_title="Airbill дэлгэрэнгүй";break;
            case "container_detail": $action_title="Airbill дэлгэрэнгүй";break;
            case "clear": $action_title="Ачааг цэвэглэх";break;
            case "container_clear": $action_title="Ачааг цэвэглэх";break;
            case "removing": $action_title="Ачааг гаргах";break;
            case "container_removing": $action_title="Ачааг гаргах";break;
            case "error": $action_title="Мэдээлэл алдаатай";break;
            
          }
          ?>
            <div class="d-flex justify-content-between">

                <nav class="page-breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="gaali">Гаалийн API</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?=$action_title;?></li>
                    </ol>
                </nav>

                <div class="btn-group">
                  <a href="?action=list" class="btn btn-primary mb-3">Агаарын Airbill</a>
                  <a href="?action=new" class="btn btn-success mb-3">Шинэ AirBill</a>
                  <a href="?action=container_list" class="btn btn-warning mb-3">Газрын ачааны Airbill</a>
                  <a href="files/airbill.xlsx" class="btn btn-secondary mb-3">Excel</a>
                </div>

            </div>


            <?
                if ($action =="dashboard")
                {
                    
                }
            
                if ($action=="new")
                {
                    ?>
                    <form action="?action=adding" method="POST">

                        <table class='table table-hover'>
                            <tr><td> Air Bill:(*)</td><td><input type="text" class="form-control" name="airbill" placeholder="Air Bill дугаар" required></td></tr>
                            <tr><td> Төрөл:(*)</td><td>
                                <select name="is_container" class="form_control">
                                    <option value="0">Агаарын ачаа</option>
                                    <option value="1">Газрын ачаа</option>
                                </select>
                                
                            </td></tr>
                        </table>

                        <button type="submit" class="btn btn-success" type="submit">Air Bill үүсгэх</button>
                    

                    </form>
                    <?
                }
            
            
                if ($action=="adding")
                {
                    $airbill=$_POST["airbill"];
                    $is_container=$_POST["is_container"];
                    if ($airbill!="")
                    {
                      $result = mysqli_query($conn,"SELECT * FROM gaali WHERE airbill='$airbill'");
                      if (mysqli_num_rows($result) == 0)
                          {
                            $sql = "INSERT INTO gaali (airbill,is_container) VALUES ('$airbill',$is_container)";
                            if (mysqli_query($conn,$sql))
                                {
                                $gaali_id= mysqli_insert_id ($conn);
                                alert_div("Амжилттай нэмэгдлээ","success");
                                echo '<a href="?action=fill&id='.$gaali_id.'" class="btn btn-primary btn-xs">AirBill-д ачаа оруулах</a>';
                                }
                        }
                        else alert_div("AirBill давхцаж байж байна");
                    }
                    else alert_div("Хоосон утга байж болохгүй"); 
                    ?>
                    <?                    
                }

                if ($action=="rename")
                {
                    if (isset($_GET["id"])) 
                    {
                        $airbill_id = intval($_GET["id"]); 
                        $sql = "SELECT *FROM gaali WHERE id='$airbill_id' LIMIT 1";
                        $result = mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)==1)
                        {
                            $data = mysqli_fetch_array($result);
                            $airbill_name = $data["airbill"];
                            ?>
                            <form action="?action=renaming" method="POST">
                                <input type="hidden" name="airbill_id" value="<?=$airbill_id;?>">
                                <table class='table table-hover'>
                                    <tr><td> Air Bill:(*)</td><td><input type="text" class="form-control" name="airbill" value="<?=$airbill_name;?>" placeholder="Air Bill дугаар" required></td></tr>
                                </table>

                                <button type="submit" class="btn btn-success" type="submit">Air Bill нэр засах</button>
                            

                            </form>
                            <?
                        }
                        else 
                        alert_div("Airbill олдсонгүй");
                    }
                    else 
                    alert_div("Airbill дугаар олдсонгүй");
                }
            
            
                if ($action=="renaming")
                {
                    $airbill_id=intval($_POST["airbill_id"]);
                    $airbill=$_POST["airbill"];

                    
                    if ($airbill!="")
                    {
                        $sql = "SELECT *FROM gaali WHERE id='$airbill_id' LIMIT 1";
                        $result = mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)==1)
                        {
                            $data = mysqli_fetch_array($result);
                            $old_airbill = $data["airbill"];

                            $sql = "UPDATE gaali SET airbill='$airbill' WHERE id='$airbill_id' LIMIT 1";       
                            if (mysqli_query($conn,$sql))                     
                            {
                                $sql = "UPDATE orders SET gaali_airbill='$airbill' WHERE gaali_airbill='$old_airbill'";
                                // echo $sql;
                                mysqli_query($conn,$sql);

                                alert_div("Амжилттай заслаа","success");
                            }
                            else 
                            alert_div("Airbill олдсонгүй");

                        }
                        else 
                        alert_div("Airbill олдсонгүй");
                    }
                    else alert_div("Хоосон утга байж болохгүй"); 
                    ?>
                    <?                    
                }
                 
                if ($action =="list")
                {
                    $sql="SELECT * FROM gaali WHERE is_container=0 ORDER BY id DESC";
                    $result = mysqli_query($conn,$sql);

                    if (mysqli_num_rows($result) > 0)
                    {
                            ?>
                                <table class='table table-hover table-striped'>
                                    <thead>
                                        <tr>
                                            <th>AirBill</th>
                                            <th>Ачааны тоо</th>
                                            <th>Үүсгэсэн</th>                                                                            
                                            <th>Үйлдэл</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                            while ($data  = mysqli_fetch_array($result))
                                            { 
                                                $airbill_id= $data["id"];
                                                $airbill= $data["airbill"]; 
                                                $count= $data["count"];
                                                $created_date = $data["created_date"];
                                                $is_active = $data["is_active"];
                                                // $status = $data["status"];
                                                // $weight = $data["weight"];

                                                echo "<tr>";
                                                // echo "<td><input type='checkairbill' name='airbilles[]' value='$airbill_id'></td>"; 
                                                // echo "<td>".$count++."</td>";
                                                echo "<td>"; echo $is_active?"<span class='text-success'>":"<span class='text-danger'>"; echo $airbill."</span></td>"; 
                                                echo "<td>".$count."</td>"; 
                                                echo "<td>".$created_date."</td>";                                           
                                                echo "<td>";
                                                echo "<div class='btn-group'>";
                                                echo "<a href='?action=box&id=$airbill_id' class='btn btn-warning'>Box оруулах</a>";
                                                echo "<a href='?action=fill&id=$airbill_id' class='btn btn-success'>ачаа оруулах</a>";
                                                echo "<a href='?action=detail&id=$airbill_id' class='btn btn-primary'>дэлгэрэнгүй</a>";
                                                echo "<a href='?action=status_change&id=$airbill_id' class='btn btn-danger'>";
                                                echo $is_active?'Идвэхигүй болгох':'Идэвхитэй болгох';
                                                echo "</a>";
                                                echo "<a href='?action=excel_specific&id=$airbill_id' class='btn btn-secondary'>Excel болгох</a>";
                                                echo "</div>";
                                                echo "</td>"; 
                                                echo "</tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                            <?
                    }
                    else echo '<div class="alert alert-danger" role="alert">No airbilles</div>';    
                }

                
                if ($action=="detail")
                {
                    if (isset($_GET["id"])) 
                    {
                        $airbill_id = intval($_GET["id"]);
                        // $total_weight=0;
                        $query1 = mysqli_query($conn,"SELECT * FROM gaali WHERE id=".$airbill_id);
                        $query2=mysqli_query($conn,"SELECT * FROM gaali_items WHERE airbill_id='".$airbill_id."' ORDER BY cust_name");
                        if (mysqli_num_rows($query1)==1)
                        {
                            $data1 = mysqli_fetch_array($query1);
                            $airbill_name= 	$data1["airbill"];
                            $count= $data1["count"];
                            $created_date= $data1["created_date"];
                            $is_active= $data1["is_active"];
                            
                            echo "<b>".$airbill_name."</b> <a href='?action=rename&id=".$airbill_id."' class='btn btn-warning btn-sm ml-3 '>Нэр засах</a><br>";
                            echo "Үүсгэсэн огноо:".$created_date."<br>";
                            echo "Тоо:".$count."<br>";
                            echo "Төлөв:"; echo $is_active?'Идэвхитэй':'Идэвхигүй'; echo "<br>";
                            echo '<a href="?action=clear&id='.$airbill_id.'" class="btn btn-danger mb-3">Ачааг бүгдийг гаргах</a>';
                         
                            if (mysqli_num_rows($query2) > 0)
                            {	 
                                    echo "<table class='table table-hover table-striped w-100 table-responsive'>";
                                    echo "<tr>";
                                    echo "<th></th>"; 
                                    echo "<th>Barcode</th>"; 
                                    echo "<th width='250'>Хүлээн авагч</th>"; 
                                    echo "<th>Утас</th>"; 
                                    echo "<th>Ачаа</th>"; 
                                    echo "<th>Тоо</th>"; 
                                    echo "<th>Жин</th>"; 
                                    echo "<th>Үнэ</th>"; 
                                    echo "<th>Төлбөр</th>"; 
                                    echo "<th>Үйлдэл</th>"; 
                                    echo "</tr>";
                                    $count=1;
                                    while ($data2 = mysqli_fetch_array($query2))
                                        { 
                                            $barcode=$data2["barcode"];
                                            // $barcodes=$data2["barcodes"];
                                            $order_id=$data2["order_id"];
                                            $weight=$data2["weight"];
                                            $cust_id=$data2["cust_id"];
                                            $cust_name=$data2["cust_name"];
                                            $cust_rd=$data2["cust_rd"];
                                            $cust_tel=$data2["cust_tel"];
                                            $cust_address=$data2["cust_address"];

                                            // $proxy_id=$data2["proxy_id"];
                                            $numb=$data2["numb"];
                                            $package_name=$data2["package_name"];
                                            $price=floatval($data2["price"]);
                                            $fee=floatval($data2["fee"]);
                                            $is_flag=$data2["is_flag"];
                                            
                                            echo "<tr class='";
                                            echo ($is_flag=="1")?'bg-danger':'';
                                            echo "'>";
                                            echo "<td>".$count++."</td>";
                                            echo "<td>".barcode_comfort($barcode)."</td>";
                                            
                                            // if ($combined==0)
                                            // {
                                            // $result_order = mysqli_query($conn,"SELECT * FROM orders WHERE order_id=".$order_id);
                                            // if (mysqli_num_rows($result_order)==1)
                                            //     {
                                            //         $row_order=mysqli_fetch_array($result_order);
                                            //     // $status=$result_order->status;
                                            //         $receiver = $row_order["receiver"];
                                            //         $proxy= $row_order["proxy_id"];
                                            //         $proxy_type= $row_order["proxy_type"];
                                            //     }
                                            //     else $proxy="";
                                            // }
                                            // if ($combined==1)
                                            // {
                                            // $result_combine = mysqli_query($conn,"SELECT * FROM airbill_combine WHERE barcode='".$barcode."'");
                                            // if (mysqli_num_rows($result_combine)==1)
                                            //     {
                                            //         $combine_row=mysqli_fetch_array($result_combine);
                                            //     // $status=$combine_data["status;
                                            //         $receiver = $combine_row["receiver"];
                                            //         $proxy= $combine_row["proxy_id"];
                                            //         $proxy_type= $combine_row["proxy_type"];
                                            //     }
                                            //     else $proxy="";
                                            //     }
                                            echo "<td width='250' class='text-wrap'>".$cust_name."<br><i class='text-primary'>".$cust_rd."</i><br><i class='text-danger'>".$cust_address."</i></td>";
                                            echo "<td>$cust_tel</td>";
                                            echo "<td width='300' class='text-wrap'>".mysqli_escape_string($conn,$package_name)."</td>";
                                            echo "<td>".$numb."</td>";
                                            echo "<td>".$weight."</td>";
                                            echo "<td>".number_format($price,2)."$</td>";
                                            echo "<td>".number_format($fee,2)."$</td>";
                                            echo "<td>";
                                            echo "<div class='btn-group'>";
                                            echo "<a href='?action=item_edit&id=$airbill_id&barcode=$barcode' class='btn btn-success btn-xs'>засах</a>";
                                            echo "<a href='?action=removing&id=$airbill_id&barcode=$barcode' class='btn btn-danger btn-xs'>гаргах</a>";
                                            echo "</div>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                echo "</table>";

                                // echo "Нийт ачааны тоо:".$boxes_packages."&nbsp;&nbsp;&nbsp;Нийт жин:".$total_weight." Кg<br>";
                            }
                            else alert_div("AirBill-д ачаа байхгүй");
                        }
                    }
                    else alert_div("AirBill-id олдсонгүй");
                }



                if ($action =="container_list")
                {
                    $sql="SELECT * FROM gaali WHERE is_container=1 ORDER BY id DESC";
                    $result = mysqli_query($conn,$sql);

                    if (mysqli_num_rows($result) > 0)
                    {
                            ?>
                                <table class='table table-hover table-striped'>
                                    <thead>
                                        <tr>
                                            <th>AirBill</th>
                                            <th>Ачааны тоо</th>
                                            <th>Үүсгэсэн</th>                                                                            
                                            <th>Үйлдэл</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                            while ($data  = mysqli_fetch_array($result))
                                            { 
                                                $airbill_id= $data["id"];
                                                $airbill= $data["airbill"]; 
                                                $count= $data["count"];
                                                $created_date = $data["created_date"];
                                                $is_active = $data["is_active"];
                                                // $status = $data["status"];
                                                // $weight = $data["weight"];

                                                echo "<tr>";
                                                // echo "<td><input type='checkairbill' name='airbilles[]' value='$airbill_id'></td>"; 
                                                // echo "<td>".$count++."</td>";
                                                echo "<td>"; echo $is_active?"<span class='text-success'>":"<span class='text-danger'>"; echo $airbill."</span></td>"; 
                                                echo "<td>".$count."</td>"; 
                                                echo "<td>".$created_date."</td>";                                           
                                                echo "<td>";
                                                echo "<div class='btn-group'>";
                                                echo "<a href='?action=container_import&id=$airbill_id' class='btn btn-warning'>Чингэлэг оруулах</a>";
                                                // echo "<a href='?action=fill&id=$airbill_id' class='btn btn-success'>ачаа оруулах</a>";
                                                echo "<a href='?action=container_detail&id=$airbill_id' class='btn btn-primary'>дэлгэрэнгүй</a>";
                                                echo "<a href='?action=status_change&id=$airbill_id' class='btn btn-danger'>";
                                                echo $is_active?'Идвэхигүй болгох':'Идэвхитэй болгох';
                                                echo "</a>";
                                                echo "<a href='?action=excel_specific&id=$airbill_id' class='btn btn-secondary'>Excel болгох</a>";
                                                echo "</div>";
                                                echo "</td>"; 
                                                echo "</tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                            <?
                    }
                    else alert_div("No ground airbill");
                }

                if ($action=="container_detail")
                {
                    if (isset($_GET["id"])) 
                    {
                        $airbill_id = intval($_GET["id"]);
                        // $total_weight=0;
                        $query1 = mysqli_query($conn,"SELECT * FROM gaali WHERE id=".$airbill_id);
                        $query2=mysqli_query($conn,"SELECT * FROM gaali_items WHERE airbill_id='".$airbill_id."' ORDER BY cust_name");
                        if (mysqli_num_rows($query1)==1)
                        {
                            $data1 = mysqli_fetch_array($query1);
                            $airbill_name= 	$data1["airbill"];
                            $count= $data1["count"];
                            $created_date= $data1["created_date"];
                            $is_active= $data1["is_active"];
                            
                            echo "<b>".$airbill_name."</b> <div class='btn-group'><a href='?action=rename&id=".$airbill_id."' class='btn btn-warning btn-sm ml-3 '>Нэр засах</a>";
                            if ($count==0) echo "<a href='?action=delete&id=".$airbill_id."' class='btn btn-danger btn-sm ml-3 '>Устгах</a>";
                            echo "</div><br>";
                            echo "Үүсгэсэн огноо:".$created_date."<br>";
                            echo "Тоо:".$count."<br>";
                            echo "Төлөв:"; echo $is_active?'Идэвхитэй':'Идэвхигүй'; echo "<br>";
                            echo '<a href="?action=container_clear&id='.$airbill_id.'" class="btn btn-danger mb-3">Ачааг бүгдийг гаргах</a>';
                         
                            if (mysqli_num_rows($query2) > 0)
                            {	 
                                    echo "<table class='table table-hover table-striped w-100 table-responsive'>";
                                    echo "<tr>";
                                    echo "<th></th>"; 
                                    echo "<th>Barcode</th>"; 
                                    echo "<th width='250'>Хүлээн авагч</th>"; 
                                    echo "<th>Утас</th>"; 
                                    echo "<th>Ачаа</th>"; 
                                    echo "<th>Тоо</th>"; 
                                    echo "<th>Жин</th>"; 
                                    echo "<th>Үнэ</th>"; 
                                    echo "<th>Төлбөр</th>"; 
                                    echo "<th>Үйлдэл</th>"; 
                                    echo "</tr>";
                                    $count=1;
                                    while ($data2 = mysqli_fetch_array($query2))
                                        { 
                                            $barcode=$data2["barcode"];
                                            // $barcodes=$data2["barcodes"];
                                            $order_id=$data2["order_id"];
                                            $weight=$data2["weight"];
                                            $cust_id=$data2["cust_id"];
                                            $cust_name=$data2["cust_name"];
                                            $cust_rd=$data2["cust_rd"];
                                            $cust_tel=$data2["cust_tel"];
                                            $cust_address=$data2["cust_address"];

                                            // $proxy_id=$data2["proxy_id"];
                                            $numb=$data2["numb"];
                                            $package_name=$data2["package_name"];
                                            $price=floatval($data2["price"]);
                                            $fee=floatval($data2["fee"]);
                                            $is_flag=$data2["is_flag"];
                                            
                                            echo "<tr class='";
                                            echo ($is_flag=="1")?'bg-danger':'';
                                            echo "'>";
                                            echo "<td>".$count++."</td>";
                                            echo "<td>".$barcode."</td>";
                                            
                                            // if ($combined==0)
                                            // {
                                            // $result_order = mysqli_query($conn,"SELECT * FROM orders WHERE order_id=".$order_id);
                                            // if (mysqli_num_rows($result_order)==1)
                                            //     {
                                            //         $row_order=mysqli_fetch_array($result_order);
                                            //     // $status=$result_order->status;
                                            //         $receiver = $row_order["receiver"];
                                            //         $proxy= $row_order["proxy_id"];
                                            //         $proxy_type= $row_order["proxy_type"];
                                            //     }
                                            //     else $proxy="";
                                            // }
                                            // if ($combined==1)
                                            // {
                                            // $result_combine = mysqli_query($conn,"SELECT * FROM airbill_combine WHERE barcode='".$barcode."'");
                                            // if (mysqli_num_rows($result_combine)==1)
                                            //     {
                                            //         $combine_row=mysqli_fetch_array($result_combine);
                                            //     // $status=$combine_data["status;
                                            //         $receiver = $combine_row["receiver"];
                                            //         $proxy= $combine_row["proxy_id"];
                                            //         $proxy_type= $combine_row["proxy_type"];
                                            //     }
                                            //     else $proxy="";
                                            //     }
                                            echo "<td width='250' class='text-wrap'>".$cust_name."<br><i class='text-primary'>".$cust_rd."</i><br><i class='text-danger'>".$cust_address."</i></td>";
                                            echo "<td>$cust_tel</td>";
                                            echo "<td width='300' class='text-wrap'>".$package_name."</td>";
                                            echo "<td>".$numb."</td>";
                                            echo "<td>".$weight."</td>";
                                            echo "<td>".number_format($price,2)."$</td>";
                                            echo "<td>".number_format($fee,2)."$</td>";
                                            echo "<td>";
                                            echo "<div class='btn-group'>";
                                            echo "<a href='?action=item_edit&id=$airbill_id&barcode=$barcode' class='btn btn-success btn-xs'>засах</a>";
                                            echo "<a href='?action=container_removing&id=$airbill_id&barcode=$barcode' class='btn btn-danger btn-xs'>гаргах</a>";
                                            echo "</div>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                echo "</table>";

                                // echo "Нийт ачааны тоо:".$boxes_packages."&nbsp;&nbsp;&nbsp;Нийт жин:".$total_weight." Кg<br>";
                            }
                            else alert_div("AirBill-д ачаа байхгүй");
                        }
                    }
                    else alert_div("AirBill-id олдсонгүй");
                }


                


                if ($action=="fill")
                {
                    if (isset($_GET["id"]))
                    {
                        $airbill_id = intval($_GET["id"]);
                        ?>
                        <form action="?action=filling" method="POST">
                            <input type="hidden" name="airbill_id" value="<?=$airbill_id;?>">                            
                            <h4 class="legend">Barcode</h4>
                            <input type="text" name="barcode" value="" class="form-control" placeholder="GO15101588MN">
                            
                            <?
                            if (isset($_GET["message"]))            
                            {
                                ?>
                                <div class="alert <?=($_GET["message"]=="ok")?'alert-success':'alert-danger';?>"><?=$_GET["message"];?></div>
                                <?
                            }                 
                            ?>

                            <button type="submit" class="btn btn-success">Оруулах</button>
                        </form>
                        <?
                    }
                    else echo '<div class="alert alert-danger" role="alert">Хоосон утга байж болохгүй.</div>';
                }

                if ($action=="filling")
                {
                    if (isset($_POST["airbill_id"])) $airbill_id = $_POST["airbill_id"];  else $airbill_id=0;
                    if (isset($_POST["barcode"])) $barcode = strtoupper($_POST["barcode"]); else $barcode="";

                    $sql = "SELECT *FROM gaali WHERE id ='$airbill_id' LIMIT 1";
                    $result = mysqli_query($conn,$sql);
                    if (mysqli_num_rows($result)==1)
                    {
                        $data = mysqli_fetch_array($result);
                        $airbill = $data["airbill"];
                        $combined=0;
                        $order_id=0;
                        $weight=0;
                        $error=0;
                        $receiver = 0;
                            
                        $result = mysqli_query($conn,"SELECT * FROM orders WHERE barcode='".$barcode."' LIMIT 1");
                        if (mysqli_num_rows($result)==1)
                        {
                            $data = mysqli_fetch_array($result);
                            $order_id = $data["order_id"];
                            $error=0;
                            $weight=strval($data["weight"]);

                            $sender_id=$data["sender"];
                            $sender_name=customer($sender_id,"full_name");
                            $sender_address=customer($sender_id,"address");


                            $cust_id=$data["receiver"];
                            $cust_name=customer($cust_id,"full_name");
                            $cust_tel=customer($cust_id,"tel");
                            $cust_address=customer($cust_id,"address");
                            $cust_rd=customer($cust_id,"rd");

                            $proxy_id=$data["proxy_id"];
                            $proxy_type=intval($data["proxy_type"]);

                            $proxy_name=proxy2($proxy_id,$proxy_type,"full_name");
                            $proxy_tel=proxy2($proxy_id,$proxy_type,"tel");
                            $proxy_address=proxy2($proxy_id,$proxy_type,"address");
                            

                            if ($proxy_name<>"") 
                            {
                                $cust_name = $proxy_name; $cust_tel=$proxy_tel; $cust_address=$proxy_address; $cust_rd="";
                            }                

                            $fee= strval(cfg_price($weight));
                            $price=strval($data["price"]);
                            $gaali_airbill= $data["gaali_airbill"];
                            $package= $data["package"];
                            $package_single_array=explode("##",$package);
                            $package_name = mysqli_escape_string($conn,$package_single_array[0]);
                            $numb = intval($package_single_array[1]);
                            if ($numb<1) $numb=1;
                            
                            $sql = "SELECT * FROM gaali_items WHERE order_id='$order_id'";
                            if (mysqli_num_rows(mysqli_query($conn,$sql))==0)
                            {
                                if ($gaali_airbill=="") 
                                    {
                                        $sql = "UPDATE orders SET gaali_airbill='$airbill' WHERE order_id='$order_id' LIMIT 1";
                                        mysqli_query($conn,$sql);
    
                                        $sql = "INSERT INTO gaali_items (airbill_id,order_id,sender_name,sender_address,cust_id,proxy_id,proxy_type,cust_name,cust_rd,cust_tel,cust_address,package_name,numb,weight,barcode,price,fee,is_flag) 
                                        VALUES ('$airbill_id','$order_id','$sender_name','$sender_address','$cust_id','$proxy_id','$proxy_type','$cust_name','$cust_rd','$cust_tel','$cust_address','$package_name','$numb','$weight','$barcode','$price','$fee',0)";
                                        // echo $sql;
                                        mysqli_query($conn,$sql);
    
                                        $sql = "UPDATE gaali SET count=count+1 WHERE id='$airbill_id'";
                                        mysqli_query($conn,$sql);
    
                                        alert_div("Ачааг Airbill -д орууллаа","success");
                                    }
                                    else 
                                    alert_div("Ачаа өмнө нь Airbill-д ороогүй боловч Ачаанд Airbill бүртгэлтэй байна");
                            }
                            else 
                            alert_div("Ачаа өмнө нь Airbill-д орсон байсан");

                        }
                        // else alert_div("Ачаа дугаар олдсонгүй");

                       $result_box= mysqli_query($conn,"SELECT * FROM box_combine WHERE barcode='$barcode'");
                        if (mysqli_num_rows($result_box)==1)
                            {
                                $data_box = mysqli_fetch_array($result_box);
                                $barcodes=$data_box["barcodes"];
                                $barcodes_array= explode(",",$barcodes);
                                foreach($barcodes_array as $barcode_single)
                                {
                                    $result= mysqli_query($conn,"SELECT * FROM orders WHERE barcode='$barcode_single'");
                                    if (mysqli_num_rows($result)==1)
                                        {
                                            $data = mysqli_fetch_array($result);

                                            $order_id = $data["order_id"];

                                            $error=0;
                                            $weight=strval($data["weight"]);

                                            $sender_id=$data["sender"];
                                            $sender_name=customer($sender_id,"full_name");
                                            $sender_address=customer($sender_id,"address");


                                            $cust_id=$data["receiver"];
                                            $cust_name=customer($cust_id,"full_name");
                                            $cust_rd=customer($cust_id,"rd");
                                            $cust_tel=customer($cust_id,"tel");
                                            $cust_address=customer($cust_id,"address");

                                            $proxy_id=$data["proxy_id"];
                                            $proxy_type=intval($data["proxy_type"]);

                                            $proxy_name=proxy2($proxy_id,$proxy_type,"full_name");
                                            $proxy_tel=proxy2($proxy_id,$proxy_type,"tel");
                                            $proxy_address=proxy2($proxy_id,$proxy_type,"address");


                                            if ($proxy_name<>"") 
                                            {
                                                $cust_name = $proxy_name; $cust_tel=$proxy_tel; $cust_address=$proxy_address;
                                            }                

                                            $fee= strval(cfg_price($weight));
                                            $price=strval($data["price"]);
                                            $gaali_airbill= $data["gaali_airbill"];
                                            $package= $data["package"];
                                            $package_single_array=explode("##",$package);
                                            $package_name = $package_single_array[0];
                                            $numb = $package_single_array[1];
                
                                            $sql = "SELECT * FROM gaali_items WHERE order_id='$order_id' AND is_container=0";
                                            // echo $sql;
                                            if (mysqli_num_rows(mysqli_query($conn,$sql))==0)
                                            {                                                                                            
                                                $sql = "UPDATE orders SET gaali_airbill='$airbill' WHERE order_id='$order_id' LIMIT 1";
                                                mysqli_query($conn,$sql);
            
                                                // alert_div(mysqli_error($conn));

                                                $sql = "INSERT INTO gaali_items (airbill_id,order_id,sender_name,sender_address,cust_id,proxy_id,proxy_type,cust_name,cust_rd,cust_tel,cust_address,package_name,numb,weight,barcode,price,fee,is_flag) 
                                                VALUES ('$airbill_id','$order_id','$sender_name','$sender_address','$cust_id','$proxy_id','$proxy_type','$cust_name','$cust_rd','$cust_tel','$cust_address','$package_name','$numb','$weight','$barcode','$price','$fee',0)";
                                                mysqli_query($conn,$sql);
            
                                                
                                                // alert_div(mysqli_error($conn));

                                                $sql = "UPDATE gaali SET count=count+1 WHERE id='$airbill_id'";
                                                mysqli_query($conn,$sql);
                    
                    
                                                // alert_div(mysqli_error($conn));

                                                // $count++;  // COUNT WAREHOUSE OR CUSTOM
                                            }
                                        }
                                }
                                
                                alert_div("Ачааг Airbill -д Нэгтгэсэн ачаа орууллаа","success");
                            }
                        
                    }                  
                    else 
                    alert_div("Airbill дугаар олдсонгүй");

                }

                if ($action=="removing")
                {
                    if (isset($_GET["id"])) $airbill_id = $_GET["id"];  else $airbill_id=0;
                    if (isset($_GET["barcode"])) $barcode = strtoupper($_GET["barcode"]); else $barcode="";

                    if ($airbill_id>0)
                    {
                        $barcode = $_GET["barcode"];
                        // echo $barcode;

                        $weight=0;
                        // if (substr($barcode,0,4)=="GO20" || substr($barcode,0,4)=="GO21" || substr($barcode,0,4)=="GO22" || substr($barcode,0,4)=="GO23" || substr($barcode,0,4)=="GO24") // SINGLE BARCODE
                        //     {
                        $result = mysqli_query($conn,"SELECT * FROM orders WHERE barcode='".$barcode."' LIMIT 1");
                        if (mysqli_num_rows($result)==1)
                            {

                                $data = mysqli_fetch_array($result);
                                $order_id = $data["order_id"];


                                $sql = "UPDATE orders SET gaali_airbill=NULL WHERE order_id='$order_id' LIMIT 1";
                                mysqli_query($conn,$sql);

                                $sql = "DELETE FROM gaali_items WHERE order_id='$order_id'";
                                mysqli_query($conn,$sql);


                                $sql = "UPDATE gaali SET count=count-1 WHERE id='$airbill_id'";
                                mysqli_query($conn,$sql);


                                // $weight= $data["weight"];
                                // if(substr($weight,-2)=="kg" || substr($weight,-2)=="Kg") $weight = substr($weight,0,strlen($weight)-2);
    
                                
                                // $result2 = mysqli_query($conn,"SELECT * FROM boxes_packages WHERE order_id='".$order_id."' LIMIT 1");
                                // if (mysqli_num_rows($result2)==1)
                                //     {
                                //         $data2= mysqli_fetch_array($result2);
                                //         $airbill_id = $data["airbill_id"];
                                //         mysqli_query($conn,"DELETE FROM boxes_packages WHERE order_id='".$order_id."'");
                                //         mysqli_query($conn,"UPDATE boxes SET weight=weight-$weight,packages=packages-1 WHERE airbill_id='".$airbill_id."'");
                                //         mysqli_query($conn,"UPDATE orders SET boxed=0 WHERE barcode='".$barcode."'");
                                //         header("Location:?action=detail&id=".$airbill_id);
                                //     }	
                                    // else single not found in boxes_packages	
                            }
                                    // else single not found	
                            //}
                            
                        // if (substr($barcode,0,3)=="GO5") // COMBINE BARCODE	
                        //     {
                        //         $result_combine = mysqli_query($conn,"SELECT * FROM airbill_combine WHERE barcode='".$barcode."' LIMIT 1");
                        //         if (mysqli_num_rows($result_combine)==1)
                        //             {
                        //             $data_combine= mysqli_fetch_array($result_combine);
                        //             $barcodes = $data_combine["barcodes"];
                        //             $weight = $data_combine["weight"];
                        //             $combine_id = $row_combine->combine_id;
                        //             if(substr($weight,-2)=="kg" || substr($weight,-2)=="Kg") $weight = substr($weight,0,strlen($weight)-2);
        
                        //             $result2 = mysqli_query($conn,"SELECT * FROM boxes_packages WHERE barcode='".$barcode."' LIMIT 1");
                        //             if (mysqli_num_rows($result2)==1)
                        //                     $data2= mysqli_fetch_array($result2);
                        //                     $airbill_id = $data2["airbill_id"];
                        //                     mysqli_query($conn,"DELETE FROM boxes_packages WHERE barcode='".$barcode."'");
                        //                     mysqli_query($conn,"UPDATE boxes SET weight=weight-$weight,packages=packages-1 WHERE airbill_id='".$airbill_id."'");
                        //                     mysqli_query($conn,"UPDATE airbill_combine SET boxed=0 WHERE barcode='".$barcode."'");
                        //                     header("Location:?action=detail&id=".$airbill_id);
        
                        //             }
                        //     }
                            
                        header("Location:?action=detail&id=".$airbill_id);
                    }
                    else
                    alert_div("Airbill дугаар олдсонгүй");
                }

                if ($action=="container_removing")
                {
                    if (isset($_GET["id"])) $airbill_id = $_GET["id"];  else $airbill_id=0;
                    if (isset($_GET["barcode"])) $barcode = strtoupper($_GET["barcode"]); else $barcode="";

                    if ($airbill_id>0)
                    {
                        $barcode = $_GET["barcode"];
                        // echo $barcode;

                        $weight=0;
                        // if (substr($barcode,0,4)=="GO20" || substr($barcode,0,4)=="GO21" || substr($barcode,0,4)=="GO22" || substr($barcode,0,4)=="GO23" || substr($barcode,0,4)=="GO24") // SINGLE BARCODE
                        //     {
                        $result = mysqli_query($conn,"SELECT * FROM container_item WHERE barcode='".$barcode."' LIMIT 1");
                        if (mysqli_num_rows($result)==1)
                            {

                                $data = mysqli_fetch_array($result);
                                $container_item_id = $data["id"];


                                $sql = "UPDATE container_item SET gaali_airbill=NULL WHERE id='$container_item_id' LIMIT 1";
                                echo $sql;
                                mysqli_query($conn,$sql);

                                $sql = "DELETE FROM gaali_items WHERE order_id='$container_item_id'";
                                echo $sql;
                                mysqli_query($conn,$sql);


                                $sql = "UPDATE gaali SET count=count-1 WHERE id='$airbill_id'";
                                echo $sql;
                                mysqli_query($conn,$sql);


                            }
                                
                        header("Location:?action=container_detail&id=".$airbill_id);
                    }
                    else
                    alert_div("Airbill дугаар олдсонгүй");
                }

                if ($action=="box")
                {
                    if (isset($_GET["id"]))
                    {
                        $airbill_id = intval($_GET["id"]);
                        
                        $sql="SELECT * FROM boxes WHERE status NOT IN ('warehouse','delivered') ORDER BY created_date DESC";
            
                        $cumulative_weight=0;
                        $cumulative_packages = 0;
                    
                        $result = mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result) > 0)
                        {
                        ?>
                        <form action="?action=boxing" method="post">
                            <input type="hidden" name="airbill_id" value="<?=$airbill_id;?>">
                            <table class='table table-hover'>
                            <thead>
                                <tr>
                                <th><input type="checkbox" name="select_all" title="Select all boxes"></th> 
                                <th>№</th>
                                <th>Нэр</th>
                                <th>Тоо</th> 
                                <th>Огноо</th> 
                                <th>Төлөв</th> 
                                <th>Kg</th>
                                <th></th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?     
                                $count_box=1;
                                while ($data = mysqli_fetch_array($result))
                                {
                                    $box_id= $data["box_id"];
                                    $name= $data["name"];
                                    $created_date =$data["created_date"];
                                    $status= $data["status"];
                                    $weight=$data["weight"];
                                        //$packages=box_inside($box_id,"packages");
                                    $packages=$data["packages"];
                                
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" name="boxes[]" value="<?=$box_id;?>"></td>
                                        <td><?=$count_box;?></td>
                                        <td><a href="boxes?action=detail&id=<?=$box_id;?>"><?=$name;?></td>
                                        <td><?=$packages;?></td>
                                        <td><?=substr($created_date,0,10);?></td>
                                        <td><?=$status;?></td>
                                        <td><?=$weight;?>Kg</td>
                                        <td><a href="?action=detail&id=<?=$box_id;?>">edit</td>
                                    </tr>
            
                                    <?
                                    $cumulative_packages+=$packages;
                                    $cumulative_weight+=$weight;
                                    
                                    $count_box ++;
                                }
                                ?>
                            </tbody>
                            <tfooter><tr><td></td><td colspan='2'>Нийт</td><td><?=$cumulative_packages;?></td><td></td><td></td><td><?=$cumulative_weight;?></td><td></td></tr></tfooter>
                            </table>
                            
                            <button class="btn btn-warning" type="submit">AirBill-д оруулах</button>
            
                        </form>
                        <?
                        }
                        else echo  alert_div('No boxes');
                    }
                    else alert_div('Хоосон утга байж болохгүй.');


                }

              
                if ($action == "boxing")
                {
                    ?>
                        <div class="card">
                            <div class="card-body">
                                <? 
                                // $options=$_POST["options"];

                                // switch ($options)
                                // {
                                // case "onair":$new_status = "onair";break;
                                // case "warehouse":$new_status = "warehouse";break;
                                // case "delete": $new_status = "delete";break;
                                // case "new": $new_status = "new";break;
                                // }
                                if (isset($_POST["airbill_id"])) $airbill_id = $_POST["airbill_id"];  else $airbill_id=0;
                                if(isset($_POST['boxes'])) {$boxes=$_POST['boxes'];$N = count($boxes);}
                                if(isset($_POST['boxes_id'])) {$boxes_id=$_POST['boxes_id'];$N = 1;}
                                else {$N = count($boxes); $boxes_id="";}

                                $sql = "SELECT *FROM gaali WHERE id ='$airbill_id' LIMIT 1";
                                $result = mysqli_query($conn,$sql);
                                if (mysqli_num_rows($result)==1)
                                {
                                    $data = mysqli_fetch_array($result);
                                    $airbill = $data["airbill"];
                                    $combined=0;
                                    $order_id=0;
                                    $weight=0;
                                    $error=0;
                                    $receiver = 0;
                                    $count=0;		

                                    
                                    if ($N!=0 || $boxes_id!="")
                                    {
                                            
                                        for($i=0; $i < $N; $i++)
                                        {
                                            $boxes_id=$boxes[$i];

                                        
                                                $result = mysqli_query($conn,"SELECT * FROM boxes WHERE box_id='$boxes_id' LIMIT 1");
                                                if (mysqli_num_rows($result)==1)
                                                {
                                                    $data= mysqli_fetch_array($result);
                                                    $box_id= $data["box_id"]; 
                                                    $name= $data["name"]; 
                                                    $packages= box_inside($box_id,"packages");
                                                    $created_date = $data["created_date"];
                                                    $weight= box_inside($box_id,"weight");
                                                    $status = $data["status"];
                                                    $result_packages = mysqli_query($conn,"SELECT * FROM boxes_packages WHERE box_id='$box_id'");
                                                    if (mysqli_num_rows($result_packages)>0)
                                                        {
                                                            
                                                            // $inside_item = mysqli_num_rows($result_packages)>0;
                                                        
                                                            while($data_inside = mysqli_fetch_array($result_packages))
                                                            {
                                                                $barcode=$data_inside["barcode"];
                                                                $combined=$data_inside["combined"];
                                                                $order_id=$data_inside["order_id"];
                                                                $barcodes=$data_inside["barcodes"];
                                                                $order_id=$data_inside["order_id"];
                                                                if ($combined!=1) //SINGLE
                                                                    {
                                                                    $result= mysqli_query($conn,"SELECT * FROM orders WHERE barcode='$barcode'");
                                                                    if (mysqli_num_rows($result)==1)
                                                                        {
                                                                            $data = mysqli_fetch_array($result);

                                                                            $order_id = $data["order_id"];
                                                                            $error=0;
                                                                            $weight=strval($data["weight"]);
                                                
                                                                            $sender_id=$data["sender"];
                                                                            $sender_name=customer($sender_id,"full_name");
                                                                            $sender_address=mysqli_escape_string($conn,customer($sender_id,"address"));
                                                
                                                
                                                                            $cust_id=$data["receiver"];
                                                                            $cust_name=customer($cust_id,"full_name");
                                                                            $cust_rd=customer($cust_id,"rd");
                                                                            $cust_tel=customer($cust_id,"tel");
                                                                            $cust_address=mysqli_escape_string($conn,customer($cust_id,"address"));
                                                
                                                                            $proxy_id=$data["proxy_id"];
                                                                            $proxy_type=intval($data["proxy_type"]);
                                                
                                                                            $proxy_name=proxy2($proxy_id,$proxy_type,"full_name");
                                                                            $proxy_tel=proxy2($proxy_id,$proxy_type,"tel");
                                                                            $proxy_address=mysqli_escape_string($conn,proxy2($proxy_id,$proxy_type,"address"));
                                                
                                                
                                                                            if ($proxy_name<>"") 
                                                                            {
                                                                                $cust_name = $proxy_name; $cust_tel=$proxy_tel; $cust_address=$proxy_address;$cust_rd="";
                                                                            }                
                                                
                                                                            $fee= strval(cfg_price($weight));
                                                                            $price=strval($data["price"]);
                                                                            $gaali_airbill= $data["gaali_airbill"];
                                                                            $package= $data["package"];
                                                                            $package_single_array=explode("##",$package);
                                                                            $package_name = mysqli_escape_string($conn,$package_single_array[0]);
                                                                            $numb = mysqli_escape_string($conn,$package_single_array[1]);
                                                
                                                                            $sql = "SELECT * FROM gaali_items WHERE order_id='$order_id' AND is_container=0";
                                                                            // echo $sql;

                                                                            if (mysqli_num_rows(mysqli_query($conn,$sql))==0)
                                                                            {

                                                                                $sql = "UPDATE orders SET gaali_airbill='$airbill' WHERE order_id='$order_id' LIMIT 1";
                                                                                mysqli_query($conn,$sql);
                                            
                                                                                // alert_div(mysqli_error($conn));

                                                                                $sql = "INSERT INTO gaali_items (airbill_id,order_id,sender_name,sender_address,cust_id,proxy_id,proxy_type,cust_name,cust_rd,cust_tel,cust_address,package_name,numb,weight,barcode,price,fee,is_flag) 
                                                                                VALUES ('$airbill_id','$order_id','$sender_name','$sender_address','$cust_id','$proxy_id','$proxy_type','$cust_name','$cust_rd','$cust_tel','$cust_address','$package_name','$numb','$weight','$barcode','$price','$fee',0)";
                                                                                mysqli_query($conn,$sql);
                                                                                
                                                                                // alert_div(mysqli_error($conn));
                                                                                
                                                                                $sql = "UPDATE gaali SET count=count+1 WHERE id='$airbill_id'";
                                                                                mysqli_query($conn,$sql);
                                                                                
                                                                                // alert_div(mysqli_error($conn));
                                                    
                                                                                $count++;  // COUNT WAREHOUSE OR CUSTOM
                                                                            }
                                                                        }
                                                                    } //SINGLE ENDING
                                                                if ($combined==1) //COMBINED
                                                                    {                                                            
                                                                        $result_box= mysqli_query($conn,"SELECT * FROM box_combine WHERE barcode='$barcode'");
                                                                        if (mysqli_num_rows($result_box)==1)
                                                                            {
                                                                            $data_box = mysqli_fetch_array($result_box);
                                                                            $barcodes=$data_box["barcodes"];
                                                                            $barcodes_array= explode(",",$barcodes);
                                                                            foreach($barcodes_array as $barcode_single)
                                                                            {
                                                                                $result= mysqli_query($conn,"SELECT * FROM orders WHERE barcode='$barcode_single'");
                                                                                if (mysqli_num_rows($result)==1)
                                                                                    {
                                                                                        $data = mysqli_fetch_array($result);
            
                                                                                        $order_id = $data["order_id"];

                                                                                        $error=0;
                                                                                        $weight=strval($data["weight"]);

                                                                                        $sender_id=$data["sender"];
                                                                                        $sender_name=customer($sender_id,"full_name");
                                                                                        $sender_address=customer($sender_id,"address");


                                                                                        $cust_id=$data["receiver"];
                                                                                        $cust_name=customer($cust_id,"full_name");
                                                                                        $cust_rd=customer($cust_id,"rd");
                                                                                        $cust_tel=customer($cust_id,"tel");
                                                                                        $cust_address=customer($cust_id,"address");

                                                                                        $proxy_id=$data["proxy_id"];
                                                                                        $proxy_type=intval($data["proxy_type"]);

                                                                                        $proxy_name=proxy2($proxy_id,$proxy_type,"full_name");
                                                                                        $proxy_tel=proxy2($proxy_id,$proxy_type,"tel");
                                                                                        $proxy_address=proxy2($proxy_id,$proxy_type,"address");


                                                                                        if ($proxy_name<>"") 
                                                                                        {
                                                                                            $cust_name = $proxy_name; $cust_tel=$proxy_tel; $cust_address=$proxy_address;
                                                                                        }                

                                                                                        $fee= strval(cfg_price($weight));
                                                                                        $price=strval($data["price"]);
                                                                                        $gaali_airbill= $data["gaali_airbill"];
                                                                                        $package= $data["package"];
                                                                                        $package_single_array=explode("##",$package);
                                                                                        $package_name = $package_single_array[0];
                                                                                        $numb = $package_single_array[1];
                                                            
                                                                                        $sql = "SELECT * FROM gaali_items WHERE order_id='$order_id' AND is_container=0";
                                                                                        // echo $sql;
                                                                                        if (mysqli_num_rows(mysqli_query($conn,$sql))==0)
                                                                                        {                                                                                            
                                                                                            $sql = "UPDATE orders SET gaali_airbill='$airbill' WHERE order_id='$order_id' LIMIT 1";
                                                                                            mysqli_query($conn,$sql);
                                                        
                                                                                            // alert_div(mysqli_error($conn));

                                                                                            $sql = "INSERT INTO gaali_items (airbill_id,order_id,sender_name,sender_address,cust_id,proxy_id,proxy_type,cust_name,cust_rd,cust_tel,cust_address,package_name,numb,weight,barcode,price,fee,is_flag) 
                                                                                            VALUES ('$airbill_id','$order_id','$sender_name','$sender_address','$cust_id','$proxy_id','$proxy_type','$cust_name','$cust_rd','$cust_tel','$cust_address','$package_name','$numb','$weight','$barcode','$price','$fee',0)";
                                                                                            mysqli_query($conn,$sql);
                                                        
                                                                                            
                                                                                            // alert_div(mysqli_error($conn));

                                                                                            $sql = "UPDATE gaali SET count=count+1 WHERE id='$airbill_id'";
                                                                                            mysqli_query($conn,$sql);
                                                                
                                                                
                                                                                            // alert_div(mysqli_error($conn));

                                                                                            $count++;  // COUNT WAREHOUSE OR CUSTOM
                                                                                        }
                                                                                    }
                                                                            }
                                                                                
                                                                            }
                                                                        
                                                                        
                                                                    } //COMBINED ENDING
                                                            }                                                          
                                                        }
                                                }
                                                
                                                
                                        }
                                        alert_div($count." ачааг Airbill-д орууллаа","success");

                                    }
                                    
                                    else alert_div("Хайрцаг тэмдэглэгдээгүй байна");
                                }
                                else 
                                alert_div("Airbill дугаар олдсонгүй");
            
                            ?>
                            </div>
                        </div>
                    <?
                }

                
                if ($action=="container_import")
                {
                    if (isset($_GET["id"]))
                    {
                        $airbill_id = intval($_GET["id"]);
                        
                        $sql="SELECT * FROM container WHERE status NOT IN ('delivered') ORDER BY created DESC";
            
                        $cumulative_weight=0;
                        $cumulative_packages = 0;
                    
                        $result = mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result) > 0)
                        {
                        ?>
                        <form action="?action=container_importing" method="post">
                            <input type="hidden" name="airbill_id" value="<?=$airbill_id;?>">
                            <table class='table table-hover' id="boxes_table">
                            <thead>
                                <tr>
                                <th><input type="checkbox" name="select_all" title="Select all boxes"></th> 
                                <th>№</th>
                                <th>Нэр</th>
                                <th>Ачаа</th>
                                <th>Огноо</th> 
                                <th>Төлөв</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?     
                                $count_box=1;
                                while ($data = mysqli_fetch_array($result))
                                {
                                    $container_id= $data["container_id"];
                                    $name= $data["name"];
                                    $created_date =$data["created"];
                                    $status= $data["status"];
                                    // $weight=$data["weight"];
                                    //     //$packages=box_inside($box_id,"packages");
                                    // $packages=$data["packages"];
                                
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" name="containers[]" value="<?=$container_id;?>"></td>
                                        <td><?=$count_box;?></td>
                                        <td><a href="container?action=detail&id=<?=$container_id;?>"><?=$name;?></td>
                                        <td><?=mysqli_num_rows(mysqli_query($conn,"SELECT id FROM container_item WHERE container='$container_id'"));?>ш</td>
                                        <td><?=substr($created_date,0,10);?></td>
                                        <td><?=$status;?></td>
                                    </tr>
            
                                    <?
                                    // $cumulative_packages+=$packages;
                                    // $cumulative_weight+=$weight;
                                    
                                    $count_box ++;
                                }
                                ?>
                            </tbody>
                            </table>
                            
                            <button class="btn btn-warning" type="submit">AirBill-д оруулах</button>
            
                        </form>
                        <?
                        }
                        else echo  alert_div('No boxes');
                    }
                    else alert_div('Хоосон утга байж болохгүй.');


                }

              
                if ($action == "container_importing")
                {
                    ?>
                        <div class="card">
                            <div class="card-body">
                                <? 
                                // $options=$_POST["options"];

                                // switch ($options)
                                // {
                                // case "onair":$new_status = "onair";break;
                                // case "warehouse":$new_status = "warehouse";break;
                                // case "delete": $new_status = "delete";break;
                                // case "new": $new_status = "new";break;
                                // }
                                if (isset($_POST["airbill_id"])) $airbill_id = $_POST["airbill_id"];  else $airbill_id=0;
                                if(isset($_POST['containers'])) {$containers=$_POST['containers'];$N = count($containers);}
                                // if(isset($_GET['container_id'])) {$container_id=$_GET['container_id'];$N = 1;}
                                else {$N = count($containers); $container_id="";}

                                $sql = "SELECT *FROM gaali WHERE id ='$airbill_id' LIMIT 1";
                                $result = mysqli_query($conn,$sql);
                                if (mysqli_num_rows($result)==1)
                                {
                                    $data = mysqli_fetch_array($result);
                                    $airbill = $data["airbill"];
                                    $combined=0;
                                    $order_id=0;
                                    $weight=0;
                                    $error=0;
                                    $receiver = 0;
                                    $count=0;		

                                    
                                    if ($N!=0 || $container_id!="")
                                    {
                                            
                                        for($i=0; $i < $N; $i++)
                                        {
                                            $container_id=$containers[$i];

                                        
                                                $result = mysqli_query($conn,"SELECT * FROM container WHERE container_id='$container_id' LIMIT 1");
                                                if (mysqli_num_rows($result)==1)
                                                {
                                                    $data= mysqli_fetch_array($result);
                                                    $container_id= $data["container_id"]; 
                                                    $name= $data["name"]; 

                                                    $created_date = $data["created"];
                                                    // $weight= box_inside($box_id,"weight");
                                                    $status = $data["status"];
                                                    $result_packages = mysqli_query($conn,"SELECT * FROM container_item WHERE container='$container_id'");
                                                            
                                                    // $inside_item = mysqli_num_rows($result_packages)>0;
                                                
                                                    while($data_container_item = mysqli_fetch_array($result_packages))
                                                    {
                                                        // echo $data_container_item["barcode"];
                                                        $barcode=$data_container_item["barcode"];
                                                        $track=$data_container_item["track"];
                                                        // $combined=$data_inside["combined"];
                                                        $container_item_id=$data_container_item["id"];
                                                        
                                                        $error=0;
                                                        $weight=strval($data_container_item["weight"]);
                            
                                                        $sender_id=$data_container_item["sender"];
                                                        $sender_name=customer($sender_id,"full_name");
                                                        $sender_address=customer($sender_id,"address");
                            
                            
                                                        $cust_id=$data_container_item["receiver"];
                                                        $cust_name=customer($cust_id,"full_name");
                                                        $cust_rd=customer($cust_id,"rd");
                                                        $cust_tel=customer($cust_id,"tel");
                                                        $cust_address=customer($cust_id,"address");
                            
                                                        $proxy_id=$data_container_item["proxy_id"];
                                                        $proxy_type=0;
                            
                                                        $proxy_name=proxy2($proxy_id,$proxy_type,"full_name");
                                                        $proxy_tel=proxy2($proxy_id,$proxy_type,"tel");
                                                        $proxy_address=proxy2($proxy_id,$proxy_type,"address");
                            
                            
                                                        if ($proxy_name<>"") 
                                                        {
                                                            $cust_name = $proxy_name; $cust_tel=$proxy_tel; $cust_address=$proxy_address;$cust_rd="";
                                                        }                
                            
                                                        $fee= strval($data_container_item["payment"]);
                                                        $price=strval($data_container_item["price"]);
                                                        // $gaali_airbill= $data["gaali_airbill"];
                                                        $package= $data_container_item["package"];
                                                        $package_single_array=explode("##",$package);
                                                        $package_name = $package_single_array[0];
                                                        $numb = $package_single_array[1];
                                        
                                                        $sql = "SELECT * FROM gaali_items WHERE order_id='$container_item_id' AND is_container=1";
                                                        // echo $sql;

                                                        if (mysqli_num_rows(mysqli_query($conn,$sql))==0)
                                                        {

                                                            $sql = "UPDATE orders SET gaali_airbill='$airbill' WHERE order_id='$order_id' LIMIT 1";
                                                            mysqli_query($conn,$sql);
                        
                                                            $sql = "INSERT INTO gaali_items (airbill_id,order_id,sender_name,sender_address,cust_id,proxy_id,proxy_type,cust_name,cust_rd,cust_tel,cust_address,package_name,numb,weight,barcode,price,fee,is_flag) 
                                                            VALUES ('$airbill_id','$container_item_id','$sender_name','$sender_address','$cust_id','$proxy_id','$proxy_type','$cust_name','$cust_rd','$cust_tel','$cust_address','$package_name','$numb','$weight','$barcode','$price','$fee',0)";
                                                            mysqli_query($conn,$sql);
                        
                                                            
                                                            $sql = "UPDATE gaali SET count=count+1 WHERE id='$airbill_id'";
                                                            mysqli_query($conn,$sql);
                                
                                
                                                            $count++;  // COUNT WAREHOUSE OR CUSTOM
                                                        }
                                                                
                                                            
                                                    }                                                          
                                                      
                                                }
                                                
                                                
                                        }
                                        alert_div($count." ачааг Airbill-д орууллаа","success");

                                    }
                                    
                                    else alert_div("Хайрцаг тэмдэглэгдээгүй байна");
                                }
                                else 
                                alert_div("Airbill дугаар олдсонгүй");
            
                            ?>
                            </div>
                        </div>
                    <?
                }
                
                
                if ($action == "excel")
                {
                    require_once('assets/vendors/PHP_XLSXWriter/xlsxwriter.class.php');
      

                    $query1 = mysqli_query($conn,"SELECT * FROM gaali ORDER BY id DESC LIMIT 1");
                    if (mysqli_num_rows($query1)==1)
                    {
                        $data1 = mysqli_fetch_array($query1);
                        $airbill_id= 	$data1["id"];
                        $airbill_name= 	$data1["airbill"];                        


                        // $data_excel = array(array('Airbill',$airbill_name));

                        $data_excel = array(array('№','Тээврийн баримтын дугаар','Илгээмжийн дугаар','Илгээгч улсын код','Илгээгчийн нэр','Илгээгчийн хаяг','Хүлээн авагчийн нэр','Хүлээн авагчийн РД','Хүлээн авагчийн Хаяг','Хүлээн авагчийн утасны дугаар','Барааны нэр','Тоо ширхэг','Жин','Нийт үнэ','Валют','Илгээгчийн эрсдлийн төлөв'));
                        $count=0;

                        $query2=mysqli_query($conn,"SELECT * FROM gaali_items WHERE airbill_id='".$airbill_id."' ORDER BY cust_name");
                        while ($data2 = mysqli_fetch_array($query2))
                        {

                            $barcode=$data2["barcode"];
                            // $barcodes=$data2["barcodes"];
                            $order_id=$data2["order_id"];
                            $weight=$data2["weight"];
                            $sender_name=$data2["sender_name"];
                            $sender_address=$data2["sender_address"];
                            $cust_id=$data2["cust_id"];
                            $cust_name=$data2["cust_name"];
                            $cust_rd=$data2["cust_rd"];
                            $cust_address=$data2["cust_address"];
                            $cust_tel=$data2["cust_tel"];
                            $numb=$data2["numb"];
                            $proxy_id=$data2["proxy_id"];
                            $package_name=$data2["package_name"];
                            $price=floatval($data2["price"]);
                            $fee=floatval($data2["fee"]);

                            $is_flag=$data2["is_flag"];
                            if ($is_flag==0) $is_flag="green";
                            if ($is_flag==1) $is_flag="red";
                            
                        
                            // $r_name= customer($cust_id,"name");
                            // $r_surname= customer($cust_id,"surname");
                            // $r_tel= customer($cust_id,"tel");
                            // $r_address= customer($cust_id,"address");

                            // $p_name= proxy2($proxy,$proxy_type,"name");
                            // $p_surname= proxy2($proxy,$proxy_type,"surname");
                            // $p_tel= proxy2($proxy,$proxy_type,"tel");
                            // $p_address= proxy2($proxy,$proxy_type,"address");


                            array_push($data_excel,array(++$count,$airbill_name,$barcode,'US',$sender_name,$sender_address,$cust_name,$cust_rd,$cust_address,$cust_tel,$package_name,$numb,$weight,number_format($price,2)."USD","USD",$is_flag));
                        }

                        
      
                    
                        $writer = new XLSXWriter();
                        $writer->writeSheet($data_excel);
                        $writer->writeToFile('files/airbill.xlsx');
                      
                        alert_div("Excel шинэчиллээ ".$count."-н бичиглэлтэй","success");
                    }
                    else alert_div("Airbill олдсонгүй");
                }

                
                if ($action == "item_edit")
                {
                    if (isset($_GET["id"])) $airbill_id = intval($_GET["id"]); else $airbill_id=0;
                    if (isset($_GET["barcode"])) $barcode = $_GET["barcode"]; else $barcode="";

                    $sql = "SELECT * FROM gaali_items WHERE airbill_id='".$airbill_id."' AND barcode='$barcode'";
                    // echo $sql;
                    $result = mysqli_query($conn,$sql);

                    if (mysqli_num_rows($result) == 1)
                    {
                        $data = mysqli_fetch_array($result);
                        $package_name = $data["package_name"];
                        $order_id=$data["order_id"];
                        $weight=$data["weight"];
                        $sender_name=$data["sender_name"];
                        $sender_address=$data["sender_address"];
                        $cust_id=$data["cust_id"];
                        $cust_name=$data["cust_name"];
                        $cust_rd=$data["cust_rd"];
                        $cust_address=$data["cust_address"];
                        $cust_tel=$data["cust_tel"];
                        $numb=$data["numb"];
                        $proxy_id=$data["proxy_id"];
                        $package_name=$data["package_name"];
                        $price=$data["price"];
                        $fee=$data["fee"];
                        $is_flag=$data["is_flag"];

                        $sql = "SELECT * FROM gaali WHERE id='".$airbill_id."'";
                        $result_gaali = mysqli_query($conn,$sql);
                        $data_gaali = mysqli_fetch_array($result_gaali);
                        $airbill_name= $data_gaali["airbill"];
    
                        
                        ?>
                        <form action="?action=item_editing&id=<?=$airbill_id;?>&barcode=<?=$barcode;?>" method="post">
                            <div class="card">
                            <div class="card-body">
                                <h5>Airbill: <?=$airbill_name;?></h5>

                                <div>Илгээгч нэр</div>
                                <input type="text" name="sender_name" value="<?=$sender_name;?>" class="form-control">

                                <div>Илгээгч хаяг</div>
                                <input type="text" name="sender_address" value="<?=$sender_address;?>" class="form-control">

                                <div>Хүлээн авагч нэр</div>
                                <input type="text" name="cust_name" value="<?=$cust_name;?>" class="form-control">

                                <div>Хүлээн авагч регистрийн дугаар</div>
                                <input type="text" name="cust_rd" value="<?=$cust_rd;?>" class="form-control">

                                <div>Хүлээн авагч утас</div>
                                <input type="text" name="cust_tel" value="<?=$cust_tel;?>" class="form-control">

                                <div>Хүлээн авагч хаяг</div>
                                <input type="text" name="cust_address" value="<?=$cust_address;?>" class="form-control">


                                <div>Ачаа</div>
                                <input type="text" name="package_name" value="<?=$package_name;?>" class="form-control">

                                <div>Тоо ширхэг</div>
                                <input type="text" name="numb" value="<?=$numb;?>" class="form-control">

                                <div>Жин</div>
                                <input type="text" name="weight" value="<?=$weight;?>" class="form-control">
                                
                                <div>Үнэ</div>
                                <input type="text" name="price" value="<?=$price;?>" class="form-control">

                                <div>Fee</div>
                                <input type="text" name="fee" value="<?=$fee;?>" class="form-control">

                                <div>Flag</div>
                                <select name="is_flag" class="form-control">
                                    <option value="0" <?=($is_flag==0)?'SELECTED':'';?>>0-Green</option>
                                    <option value="1" <?=($is_flag==1)?'SELECTED':'';?>>1-Red</option>
                                </select>                                

                                <button type="submit" class="btn btn-success mt-3">Хадгалах</button>
                            </div>
                            </div>
                        </form>
                        <?
                    } 
                    else    
                    {
                        if (mysqli_num_rows($result) > 1)              
                        {

                            while ($data = mysqli_fetch_array($result))
                            {
                                $package_name = $data["package_name"];
                                $order_id=$data["order_id"];
                                $weight=$data["weight"];
                                $sender_name=$data["sender_name"];
                                $sender_address=$data["sender_address"];
                                $cust_id=$data["cust_id"];
                                $cust_name=$data["cust_name"];
                                $cust_rd=$data["cust_rd"];
                                $cust_address=$data["cust_address"];
                                $cust_tel=$data["cust_tel"];
                                $numb=$data["numb"];
                                $proxy_id=$data["proxy_id"];
                                $package_name=$data["package_name"];
                                $price=$data["price"];
                                $fee=$data["fee"];
                                $is_flag=$data["is_flag"];                                
                            }


                            $sql = "SELECT * FROM gaali WHERE id='".$airbill_id."'";
                            $result_gaali = mysqli_query($conn,$sql);
                            $data_gaali = mysqli_fetch_array($result_gaali);
                            $airbill_name= $data_gaali["airbill"];

                            ?>
                            <form action="?action=item_editing&id=<?=$airbill_id;?>&barcode=<?=$barcode;?>" method="post">
                                <div class="card">
                                <div class="card-body">
                                    <h5>Airbill: <?=$airbill_name;?></h5>

                                    <div>Илгээгч нэр</div>
                                    <input type="text" name="sender_name" value="<?=$sender_name;?>" class="form-control">

                                    <div>Илгээгч хаяг</div>
                                    <input type="text" name="sender_address" value="<?=$sender_address;?>" class="form-control">

                                    <div>Хүлээн авагч нэр</div>
                                    <input type="text" name="cust_name" value="" class="form-control">

                                    <div>Хүлээн авагч регистрийн дугаар</div>
                                    <input type="text" name="cust_rd" value="<?=$cust_rd;?>" class="form-control">

                                    <div>Хүлээн авагч утас</div>
                                    <input type="text" name="cust_tel" value="<?=$cust_tel;?>" class="form-control">

                                    <div>Хүлээн авагч хаяг</div>
                                    <input type="text" name="cust_address" value="<?=$cust_address;?>" class="form-control">


                                    <div>Ачаа</div>
                                    <input type="text" name="package_name" value="<?=$package_name;?>" class="form-control">

                                    <div>Тоо ширхэг</div>
                                    <input type="text" name="numb" value="<?=$numb;?>" class="form-control">

                                    <div>Жин</div>
                                    <input type="text" name="weight" value="<?=$weight;?>" class="form-control">
                                    
                                    <div>Үнэ</div>
                                    <input type="text" name="price" value="<?=$price;?>" class="form-control">

                                    <div>Fee</div>
                                    <input type="text" name="fee" value="<?=$fee;?>" class="form-control">

                                    <div>Flag</div>
                                    <select name="is_flag" class="form-control">
                                        <option value="0" <?=($is_flag==0)?'SELECTED':'';?>>0-Green</option>
                                        <option value="1" <?=($is_flag==1)?'SELECTED':'';?>>1-Red</option>
                                    </select>                                

                                    <button type="submit" class="btn btn-success mt-3">Хадгалах</button>
                                </div>
                                </div>
                            </form>
                            <?
    
                        }
                        else 
                        {
                            alert_div("Airbill ачаа олдсонгүй");
                        }
                    }   

                }


                if ($action == "item_editing")
                { 
                    if (isset($_GET["id"])) $airbill_id = intval($_GET["id"]); else $airbill_id=0;
                    if (isset($_GET["barcode"])) $barcode = $_GET["barcode"]; else $barcode="";

                    $sql = "SELECT * FROM gaali_items WHERE airbill_id='".$airbill_id."' AND barcode='$barcode'";
                    $result = mysqli_query($conn,$sql);
                    

                    if (mysqli_num_rows($result) == 1)
                    {
                        $sender_name = $_POST["sender_name"];
                        $sender_address = $_POST["sender_address"];
                        $cust_name = $_POST["cust_name"];
                        $cust_rd = $_POST["cust_rd"];
                        $cust_tel = $_POST["cust_tel"];
                        $cust_address = $_POST["cust_address"];


                        $package_name = mysqli_escape_string($conn,$_POST["package_name"]);
                        $weight = $_POST["weight"];
                        $price = $_POST["price"];
                        $fee = $_POST["fee"];
                        $numb = $_POST["numb"];
                        $is_flag = $_POST["is_flag"];

                        if (mysqli_query($conn,"UPDATE gaali_items 
                        SET 
                        sender_name ='$sender_name',
                        sender_address ='$sender_address',
                        cust_name ='$cust_name',
                        cust_rd ='$cust_rd',
                        cust_tel ='$cust_tel',
                        cust_address ='$cust_address',
                        package_name ='$package_name',
                        weight='$weight',
                        numb='$numb',
                        price='$price',
                        fee='$fee', 
                        is_flag='$is_flag' 
                        WHERE airbill_id='".$airbill_id."' AND barcode='$barcode'"))
                        {
                            alert_div("Амжилттай тэмдэглэлээ","success");
                            
                        }
                        else 
                        {
                            alert_div("Алдаа:".mysqli_error($conn));                            
                        }
                    } 
                    else alert_div("Алдаа: Ачаа олдсонгүй");                            

                }

                if ($action=="status_change")
                {
                    if (isset($_GET["id"])) $airbill_id = $_GET["id"];  else $airbill_id=0;                    

                    $sql = "SELECT *FROM gaali WHERE id ='$airbill_id' LIMIT 1";
                    $result = mysqli_query($conn,$sql);
                    if (mysqli_num_rows($result)==1)
                    {
                        $data = mysqli_fetch_array($result);
                        $is_active = $data["is_active"];
                        if ($is_active==0) $is_active=1; else $is_active=0;
                        

                        $sql = "UPDATE gaali SET is_active=$is_active WHERE id='$airbill_id'";
                        mysqli_query($conn,$sql);

                        alert_div("Airbill төлөв өөрчиллөө","success");
                            
                        
                    }                  
                    else 
                    alert_div("Airbill дугаар олдсонгүй");

                }

                if ($action=="clear")
                {
                    if (isset($_GET["id"])) $airbill_id = $_GET["id"];  else $airbill_id=0;                    

                    $sql = "SELECT *FROM gaali WHERE id ='$airbill_id' LIMIT 1";
                    $result = mysqli_query($conn,$sql);
                    if (mysqli_num_rows($result)==1)
                    {
                        $data = mysqli_fetch_array($result);
                        $airbill_name = $data["airbill"];

                        // if ($is_active==0) $is_active=1; else $is_active=0;
                        

                        $sql = "DELETE FROM gaali_items WHERE airbill_id='$airbill_id'";
                        mysqli_query($conn,$sql);

                        $sql = "UPDATE orders SET gaali_airbill=NULL WHERE gaali_airbill='$airbill_name'";
                        mysqli_query($conn,$sql);

                        $sql = "UPDATE gaali SET is_active=0,count=0 WHERE id='$airbill_id'";
                        mysqli_query($conn,$sql);

                        alert_div("Airbill цэвэрлэлээ","success");
                            
                        
                    }                  
                    else 
                    alert_div("Airbill дугаар олдсонгүй");

                }

                if ($action=="container_clear")
                {
                    if (isset($_GET["id"])) $airbill_id = $_GET["id"];  else $airbill_id=0;                    

                    $sql = "SELECT *FROM gaali WHERE id ='$airbill_id' LIMIT 1";
                    $result = mysqli_query($conn,$sql);
                    if (mysqli_num_rows($result)==1)
                    {
                        $data = mysqli_fetch_array($result);
                        $airbill_name = $data["airbill"];

                        // if ($is_active==0) $is_active=1; else $is_active=0;
                        

                        $sql = "DELETE FROM gaali_items WHERE airbill_id='$airbill_id'";
                        mysqli_query($conn,$sql);

                        $sql = "UPDATE container_item SET gaali_airbill=NULL WHERE gaali_airbill='$airbill_name'";
                        mysqli_query($conn,$sql);

                        $sql = "UPDATE gaali SET is_active=0,count=0 WHERE id='$airbill_id'";
                        mysqli_query($conn,$sql);

                        alert_div("Airbill цэвэрлэлээ","success");
                            
                        
                    }                  
                    else 
                    alert_div("Airbill дугаар олдсонгүй");

                }

                
                if ($action=="delete")
                {
                    $airbill_id=intval($_GET["id"]);
                
                    $sql = "SELECT *FROM gaali WHERE id='$airbill_id' LIMIT 1";
                    $result = mysqli_query($conn,$sql);
                    if (mysqli_num_rows($result)==1)
                    {
                        $data = mysqli_fetch_array($result);
                        $count= $data["count"];
                        $airbill = $data["airbill"];

                        if ($count==0)
                        {
                            $sql = "DELETE FROM gaali WHERE id='$airbill_id' LIMIT 1";       
                            if (mysqli_query($conn,$sql))                     
                            {
                                $sql = "UPDATE orders SET gaali_airbill=NULL WHERE gaali_airbill='$airbill'";
                                // echo $sql;
                                mysqli_query($conn,$sql);

                                alert_div("Амжилттай устгалаа","success");
                            }

                        }
                        else alert_div("зөвхөн хоосон Airbill устгах боломжтой");
                    }
                    else 
                    alert_div("Airbill олдсонгүй");
                }

                if ($action == "excel_specific")
                {
                    require_once('assets/vendors/PHP_XLSXWriter/xlsxwriter.class.php');
      
                    $airbill_id = $_GET["id"];
                    
                    $query1 = mysqli_query($conn,"SELECT * FROM gaali WHERE id='$airbill_id'");
                    if (mysqli_num_rows($query1)==1)
                    {
                        $data1 = mysqli_fetch_array($query1);
                        $airbill_id= 	$data1["id"];
                        $airbill_name= 	$data1["airbill"];                        


                        // $data_excel = array(array('Airbill',$airbill_name));

                        $data_excel = array(array('№','Тээврийн баримтын дугаар','Илгээмжийн дугаар','Илгээгч улсын код','Илгээгчийн нэр','Илгээгчийн хаяг','Хүлээн авагчийн нэр','Хүлээн авагчийн РД','Хүлээн авагчийн Хаяг','Хүлээн авагчийн утасны дугаар','Барааны нэр','Тоо ширхэг','Жин','Нийт үнэ','Валют','Илгээгчийн эрсдлийн төлөв'));
                        $count=0;

                        $query2=mysqli_query($conn,"SELECT * FROM gaali_items WHERE airbill_id='".$airbill_id."' ORDER BY cust_name");
                        while ($data2 = mysqli_fetch_array($query2))
                        {

                            $barcode=$data2["barcode"];
                            // $barcodes=$data2["barcodes"];
                            $order_id=$data2["order_id"];
                            $weight=$data2["weight"];
                            $sender_name=$data2["sender_name"];
                            $sender_address=$data2["sender_address"];
                            $cust_id=$data2["cust_id"];
                            $cust_name=$data2["cust_name"];
                            $cust_rd=$data2["cust_rd"];
                            $cust_address=$data2["cust_address"];
                            $cust_tel=$data2["cust_tel"];
                            $numb=$data2["numb"];
                            $proxy_id=$data2["proxy_id"];
                            $package_name=$data2["package_name"];
                            $price=floatval($data2["price"]);
                            $fee=floatval($data2["fee"]);

                            $is_flag=$data2["is_flag"];
                            if ($is_flag==0) $is_flag="green";
                            if ($is_flag==1) $is_flag="red";
                            
                        
                            // $r_name= customer($cust_id,"name");
                            // $r_surname= customer($cust_id,"surname");
                            // $r_tel= customer($cust_id,"tel");
                            // $r_address= customer($cust_id,"address");

                            // $p_name= proxy2($proxy,$proxy_type,"name");
                            // $p_surname= proxy2($proxy,$proxy_type,"surname");
                            // $p_tel= proxy2($proxy,$proxy_type,"tel");
                            // $p_address= proxy2($proxy,$proxy_type,"address");


                            array_push($data_excel,array(++$count,$airbill_name,$barcode,'US',$sender_name,$sender_address,$cust_name,$cust_rd,$cust_address,$cust_tel,$package_name,$numb,$weight,number_format($price,2)."USD","USD",$is_flag));
                        }

                        
      
                    
                        $writer = new XLSXWriter();
                        $writer->writeSheet($data_excel);
                        $writer->writeToFile('files/airbill.xlsx');
                      
                        alert_div("Excel шинэчиллээ ".$count."-н бичиглэлтэй","success");
                    }
                    else alert_div("Airbill олдсонгүй");
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
      $('#boxes_table').DataTable({
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
    $(document).ready(function() {
        $('input[name="select_all"]').click(function(event) {
            if(this.checked) { 
                $('input[type="checkbox"]').each(function() {
                    this.checked = true;            
                });
            }else{
                $('input[type="checkbox"]').each(function() {
                    this.checked = false; 
                });        
            }
        });
    })
    </script>

</body>
</html>    