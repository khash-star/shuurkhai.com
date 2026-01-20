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
                if ($action=="active")
                {
                    // Display messages
                    if (isset($_GET["message"])) {
                        if ($_GET["message"] == "deleted") {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                            echo '<strong>Амжилттай!</strong> Хайрцгийг амжилттай устгалаа.';
                            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                            echo '<span aria-hidden="true">&times;</span>';
                            echo '</button>';
                            echo '</div>';
                        }
                        elseif ($_GET["message"] == "delete_error") {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                            echo '<strong>Алдаа!</strong> Зөвхөн хоосон хайрцгийг устгах боломжтой.';
                            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                            echo '<span aria-hidden="true">&times;</span>';
                            echo '</button>';
                            echo '</div>';
                        }
                    }
                    
                    $sql="SELECT * FROM boxes";
                    $sql.= " WHERE agent='$g_agent_logged_id' AND status NOT IN ('delivered','warehouse') ORDER BY created_date DESC";
                    $result = mysqli_query($conn,$sql);
                    $total_weight =0;

                    if (mysqli_num_rows($result) > 0)
                    {
                            ?>
                            <form action="?action=changing" method="POST">
                                <table class='table table-hover table-striped'>
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="select_all" title="Select all orders"></th>
                                            <th>№</th>
                                            <th>Нэр</th>
                                            <th>Үүсгэсэн</th>
                                            <th>Төлөв</th>
                                            <th>Тоо</th> 
                                            <th>Kg</th>
                                            <th>Үйлдэл</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                    <?php                    
                                            $count=1;
                                            $cumulative_weight=0;
                                            $cumulative_packages = 0;
                                            while ($data  = mysqli_fetch_array($result))
                                            { 
                                                $box_id= $data["box_id"];
                                                $name= $data["name"]; 
                                                $packages= $data["packages"];
                                                $created_date = $data["created_date"];
                                                $status = $data["status"];
                                                $weight = $data["weight"];

                                                echo "<tr>";
                                                echo "<td><input type='checkbox' name='boxes[]' value='$box_id'></td>"; 
                                                echo "<td>".$count++."</td>";
                                                echo "<td>".$name."</td>"; 
                                                echo "<td>".$created_date."</td>"; 
                                                echo "<td>".$status."</td>"; 
                                                echo "<td>".$packages."</td>"; 
                                                echo "<td>".$weight."</td>"; 
                                                echo "<td>";
                                                echo "<a href='?action=detail&id=$box_id'><i class='ti ti-edit'></i></a>";
                                                echo " <a href='boxes_preview?id=$box_id' class='btn btn-warning btn-sm' target='new' style='margin-left: 5px; padding: 2px 8px; font-size: 11px;'>Box badge</a>";
                                                // Show delete button only for empty boxes (packages=0 or weight=0)
                                                if ($packages == 0 || $weight == 0) {
                                                    echo " <a href='?action=delete_box&id=$box_id' onclick=\"return confirm('Энэ хайрцгийг устгахдаа итгэлтэй байна уу?');\" title='Устгах'><i class='ti ti-trash text-danger'></i></a>";
                                                }
                                                echo "</td>"; 
                                                echo "</tr>";
                                                $total_weight+=$weight;
                                                $cumulative_packages+=$packages;
                                                $cumulative_weight+=$weight;                                            
                                            }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                    <tr><td></td><td colspan='4'>Нийт</td><td><?=$cumulative_packages;?></td><td><?=$cumulative_weight;?></td><td></td></tr>

                                    </tfoot>
                                </table>
                                <select name="options" class="form-control">
                                    <option value="onair">Онгоцоор нисгэх</option>
                                    <option value="delete">Хайрцагын устгах</option>
                                </select>
                                <div id="more"></div>
                                <button type="submit" class="btn btn-success">өөрчил</button>            
                            </form>
                    <?php                    
                    }
                    else echo '<div class="alert alert-danger" role="alert">No boxes</div>';                            
                }

                if ($action=="changing")
                {
                    
                    $options=$_POST["options"];
                    $agent_id=$g_agent_logged_id;
                    switch ($options)
                    {
                    case "onair":$new_status = "onair";break;
                    case "delete": $new_status = "delete";break;
                    }

                    $boxes = isset($_POST['boxes']) ? $_POST['boxes'] : array();
                    $N = isset($_POST['boxes']) ? count($boxes) : 0;
                    
                    if(isset($_POST['boxes_id'])) {
                        $boxes_id=$_POST['boxes_id'];
                        $N = 1;
                    } else {
                        $boxes_id="";
                    }
                    
                    if ($N!=0 || $boxes_id!="")
                    {
                    $count=1;
                        
                    echo "<table class='table table-hover'>";
                    echo "<tr>";
                    echo "<th>№</th>"; 
                    echo "<th>Нэр</th>"; 
                    echo "<th>Тоо</th>"; 
                    echo "<th>Огноо</th>"; 
                    echo "<th>Төлөв</th>"; 
                    echo "<th>Жин</th>"; 
                    echo "<th></th>"; 
                    echo "</tr>";
                    for($i=0; $i < $N; $i++)
                    {
                        $boxes_id=$boxes[$i];
                        $result = mysqli_query($conn,"SELECT * FROM boxes WHERE box_id='".$boxes_id."' LIMIT 1");
                        $data=mysqli_fetch_array($result);
                        $name=$data["name"];
                        $packages=$data["packages"];
                        $created_date=$data["created_date"];
                        $weight=$data["weight"];

                        if ($new_status=="onair")
                        {
                            $count=1;		
                            $result = mysqli_query($conn,"SELECT * FROM boxes WHERE box_id=$boxes_id LIMIT 1");
                                if (mysqli_num_rows($result)==1)
                                {
                                $data=mysqli_fetch_array($result);
                                $box_id= $data["box_id"]; 
                                $name= $data["name"]; 
                                $packages= box_inside($box_id,"packages");
                                $created_date = $data["created_date"];
                                $weight= box_inside($box_id,"weight");
                                $status = $data["status"];
                                $packages_query = mysqli_query($conn,"SELECT * FROM boxes_packages WHERE box_id=$box_id");
                                if (mysqli_num_rows($packages_query)>0)
                                    {
                                    $inside_item =mysqli_num_rows($packages_query);
                                    $inside_count =0;
                                
                                    // Use same onair_date for all orders in this box
                                    $onair_datetime = date("Y-m-d H:i:s");
                                    
                                    while($package_data=mysqli_fetch_array($packages_query))
                                    {
                                    $barcode=$package_data["barcode"];
                                    $combined=$package_data["combined"];
                                    $order_id=$package_data["order_id"];
                                    $barcodes=$package_data["barcodes"];
                                    $order_id=$package_data["order_id"];
                                    if ($combined!=1) //SINGLE
                                        {
                                        $order_query= mysqli_query($conn,"SELECT * FROM orders WHERE barcode='".mysqli_real_escape_string($conn, $barcode)."'");
                                        if (mysqli_num_rows($order_query)==1)
                                            {
                                                $row_orders = mysqli_fetch_array($order_query);
                                                if(!($row_orders["status"]=="delivered" || $row_orders["status"]=="warehouse" || $row_orders["status"]=="custom")) {
                                                    mysqli_query($conn,"UPDATE orders SET status='onair',onair_date='".mysqli_real_escape_string($conn, $onair_datetime)."' WHERE order_id=".intval($order_id));
                                                }
                                                $inside_count++;
                                            }
                                        } //SINGLE ENDING
                                    if ($combined==1) //COMBINED
                                        {
                                            foreach(explode(",",$barcodes) as $barcode_each)
                                            {
                                            $order_query= mysqli_query($conn,"SELECT * FROM orders WHERE barcode='".mysqli_real_escape_string($conn, $barcode_each)."'");
                                            if (mysqli_num_rows($order_query)==1)
                                                {
                                                $row_orders = mysqli_fetch_array($order_query);
                                                if(!($row_orders["status"]=="delivered" || $row_orders["status"]=="warehouse" || $row_orders["status"]=="custom")) {
                                                    mysqli_query($conn,"UPDATE orders SET status='onair',onair_date='".mysqli_real_escape_string($conn, $onair_datetime)."' WHERE barcode='".mysqli_real_escape_string($conn, $barcode_each)."'");
                                                }
                                                }
                                            }
                                            mysqli_query($conn,"UPDATE box_combine SET status='onair',onair_date='".mysqli_real_escape_string($conn, $onair_datetime)."' WHERE barcode='".mysqli_real_escape_string($conn, $barcode)."'");
                                            $inside_count++;
                                        } //COMBINED ENDING
                                
                                    }
                                    if ($inside_item==$inside_count)
                                    {
                                        mysqli_query($conn,"UPDATE boxes SET status='onair' WHERE box_id=".intval($boxes_id)." LIMIT 1");
                                        
                                        // Create or update report entry when all orders in box are moved to onair
                                        // Get all orders with same onair_date (same second) to create one report per onair_date
                                        $report_check_sql = "SELECT 
                                            DATE_FORMAT(onair_date, '%Y-%m-%d %H:%i:%s') as onair_date_group,
                                            COUNT(order_id) as Count, 
                                            SUM(weight) as total,
                                            SUM(CASE WHEN (advance=1 OR advance_value > 0) THEN weight ELSE 0 END) as paid_weight,
                                            SUM(CASE WHEN (advance=0 OR advance_value = 0 OR advance_value IS NULL) THEN weight ELSE 0 END) as collect_weight
                                        FROM orders  
                                        WHERE status='onair' 
                                        AND onair_date >= DATE_SUB('".mysqli_real_escape_string($conn, $onair_datetime)."', INTERVAL 1 SECOND)
                                        AND onair_date <= DATE_ADD('".mysqli_real_escape_string($conn, $onair_datetime)."', INTERVAL 1 SECOND)
                                        AND onair_date!='0000-00-00 00:00:00' 
                                        AND onair_date IS NOT NULL
                                        GROUP BY DATE_FORMAT(onair_date, '%Y-%m-%d %H:%i:%s')";
                                        
                                        $report_check_result = mysqli_query($conn, $report_check_sql);
                                        if (mysqli_num_rows($report_check_result) > 0) {
                                            while ($report_data = mysqli_fetch_array($report_check_result)) {
                                                $report_onair_date = $report_data["onair_date_group"];
                                                
                                                // Check if report already exists for this onair_date
                                                $check_report_sql = "SELECT * FROM reports WHERE onair_date='".mysqli_real_escape_string($conn, $report_onair_date)."' LIMIT 1";
                                                $check_report_result = mysqli_query($conn, $check_report_sql);
                                                
                                                if (mysqli_num_rows($check_report_result) == 0) {
                                                    // Create new report entry
                                                    $report_weight = floatval($report_data["total"]);
                                                    $report_count = intval($report_data["Count"]);
                                                    $report_paid_weight = floatval($report_data["paid_weight"] ?? 0);
                                                    $report_collect_weight = floatval($report_data["collect_weight"] ?? 0);
                                                    
                                                    // Calculate PAID and COLLECT
                                                    $report_paid = 0;
                                                    if ($report_paid_weight > 0) {
                                                        $selfdrop_rate = floatval(settings("paymentrate_selfdrop") ?? 0);
                                                        $report_paid = $report_paid_weight * $selfdrop_rate;
                                                    }
                                                    
                                                    $report_collect = 0;
                                                    if ($report_collect_weight > 0) {
                                                        if ($report_collect_weight < 0.5) {
                                                            $report_collect = 10;
                                                        } else {
                                                            $report_collect = cfg_price($report_collect_weight);
                                                        }
                                                    }
                                                    
                                                    // Insert report - create table if not exists
                                                    $create_table_sql = "CREATE TABLE IF NOT EXISTS reports (
                                                        id INT AUTO_INCREMENT PRIMARY KEY,
                                                        onair_date DATETIME NOT NULL,
                                                        count_orders INT DEFAULT 0,
                                                        total_weight DECIMAL(10,2) DEFAULT 0,
                                                        paid_weight DECIMAL(10,2) DEFAULT 0,
                                                        collect_weight DECIMAL(10,2) DEFAULT 0,
                                                        paid_amount DECIMAL(10,2) DEFAULT 0,
                                                        collect_amount DECIMAL(10,2) DEFAULT 0,
                                                        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                                                        UNIQUE KEY unique_onair_date (onair_date)
                                                    )";
                                                    mysqli_query($conn, $create_table_sql);
                                                    
                                                    $insert_report_sql = "INSERT INTO reports (onair_date, count_orders, total_weight, paid_weight, collect_weight, paid_amount, collect_amount, created_at) 
                                                        VALUES (
                                                            '".mysqli_real_escape_string($conn, $report_onair_date)."',
                                                            ".intval($report_count).",
                                                            ".floatval($report_weight).",
                                                            ".floatval($report_paid_weight).",
                                                            ".floatval($report_collect_weight).",
                                                            ".floatval($report_paid).",
                                                            ".floatval($report_collect).",
                                                            NOW()
                                                        )";
                                                    mysqli_query($conn, $insert_report_sql);
                                                }
                                            }
                                        }
                                    }
                                    echo "<tr>";
                                    echo "<td>".$count."</td>";
                                    echo "<td><a href='?action=detail&id=".$data["box_id"]."'>$name</a></td>"; 
                                    echo "<td>".$packages."</td>"; 
                                    echo "<td>".substr($created_date,0,10)."</td>"; 
                                    echo "<td>";
                                    if ($inside_item==$inside_count) echo "onair";
                                    echo "</td>"; 
                                    echo "<td>".$weight."</td>"; 
                                    echo "</tr>";
                                    }
                                }
                            }
                        
                        if ($new_status=="delete")  //DELETE BOXES
                            {
                            $count=1;		
                            $query = mysqli_query($conn,"SELECT * FROM boxes WHERE box_id=$boxes_id LIMIT 1");
                            if (mysqli_num_rows($result)==1)
                                {
                                $row= mysqli_fetch_array($result);
                                $box_id= $data["box_id"]; 
                                $name= $data["name"]; 
                                $created_date = $data["created_date"];
                                $status = $data["status"];
                                $agent= $data["agent"]; 
                                if ($status=="new")
                                    if ($agent==$agent_id)
                                        {
                                    $delete_boxes = mysqli_query($conn,"DELETE FROM boxes WHERE box_id='$boxes_id'");
                                    $delete_boxes = mysqli_query($conn,"DELETE FROM boxes_packages WHERE box_id='$boxes_id'");
                                    $delete_status="delete";
                                        }
                                    else  $delete_status="not yours";
                            else $delete_status="Should be only new box";
                                echo "<tr>";
                                echo "<td>".$count."</td>";
                                echo "<td><a href='?action=detail&id=".$data["box_id"]."'>".$name."</a></td>"; 
                                echo "<td>".$packages."</td>"; 
                                echo "<td>".substr($created_date,0,10)."</td>"; 
                                echo "<td>".$delete_status."</td>"; 
                                    echo "<td>".$weight."</td>"; 
                                    echo "</tr>";
                                
                                }
                            }
                        }
                    echo "</table>";
                    }
	
	                else echo "Хайрцаг тэмдэглэгдээгүй байна";

                }

                if ($action=="delete_box")
                {
                    if (isset($_GET["id"])) 
                    {
                        $box_id = intval($_GET["id"]);
                        $result = mysqli_query($conn,"SELECT * FROM boxes WHERE box_id='".$box_id."' LIMIT 1");
                        if (mysqli_num_rows($result)==1)
                        {
                            $data = mysqli_fetch_array($result);
                            $packages = $data["packages"];
                            $weight = $data["weight"];
                            $status = $data["status"];
                            $agent = $data["agent"];
                            
                            // Only allow deletion of empty boxes (packages=0 or weight=0) and status='new'
                            if (($packages == 0 || $weight == 0) && $status == 'new' && $agent == $g_agent_logged_id)
                            {
                                // Delete boxes_packages first (should be empty but just in case)
                                mysqli_query($conn,"DELETE FROM boxes_packages WHERE box_id='".$box_id."'");
                                // Delete the box
                                mysqli_query($conn,"DELETE FROM boxes WHERE box_id='".$box_id."'");
                                header("Location:?action=active&message=deleted");
                                exit;
                            }
                            else
                            {
                                header("Location:?action=active&message=delete_error");
                                exit;
                            }
                        }
                        else
                        {
                            header("Location:?action=active&message=box_not_found");
                            exit;
                        }
                    }
                    else
                    {
                        header("Location:?action=active&message=error");
                        exit;
                    }
                }

                if ($action=="detail")
                {
                    if (isset($_GET["id"])) 
                    {
                        $box_id = intval($_GET["id"]);
                        $total_weight=0;
                        $query = mysqli_query($conn,"SELECT * FROM boxes_packages WHERE box_id=".$box_id);
                        $result_box=mysqli_query($conn,"SELECT * FROM boxes WHERE box_id=".$box_id);
                        if (mysqli_num_rows($result_box)==1)
                        {
                            $row_box = mysqli_fetch_array($result_box);
                            $box_name= 	$row_box["name"];
                            $boxes_packages= $row_box["packages"];
                            $box_weight= $row_box["weight"];
                            $box_created= $row_box["created_date"];
                            $box_status= $row_box["status"];

                            // Display success message if item was removed
                            if (isset($_GET["message"]) && $_GET["message"] == "removed_success") {
                                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
                                echo "<strong>Амжилттай!</strong> BOX-аас ачаа амжилттай гаргалаа.";
                                echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                                echo "<span aria-hidden='true'>&times;</span>";
                                echo "</button>";
                                echo "</div>";
                            }
                            
                            // Display error message if any
                            if (isset($_GET["message"]) && $_GET["message"] == "error") {
                                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
                                echo "<strong>Алдаа!</strong> Ачаа олдсонгүй эсвэл алдаа гарлаа.";
                                echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                                echo "<span aria-hidden='true'>&times;</span>";
                                echo "</button>";
                                echo "</div>";
                            }
                            
                            // Display message if box is not in 'new' status
                            if (isset($_GET["message"]) && $_GET["message"] == "box_not_new") {
                                echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>";
                                echo "<strong>Анхааруулга!</strong> Зөвхөн нисэхэд бэлэн (NEW) төлөвтэй хайрцагнаас ачаа гаргах боломжтой.";
                                echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                                echo "<span aria-hidden='true'>&times;</span>";
                                echo "</button>";
                                echo "</div>";
                            }

                            echo "<b>".$box_name."</b><br>";
                            echo "Үүсгэсэн огноо:".$box_created."<br>";
                            echo "Төлөв:".$box_status."<br>";
                            if ($box_status=="new") 
                            {
                                ?>
                                <a href="?action=fill&id=<?=$box_id;?>" class="btn btn-success btn-sm">Fill box</a>
                    <?php                    
                            }
                            ?>
                    <?php                    
                        }
                        if (mysqli_num_rows($query) > 0)
                        {	 
                                echo "<table class='table table-hover'>";
                                echo "<tr>";
                                echo "<th></th>"; 
                                echo "<th>Barcode</th>"; 
                                echo "<th>Receiver</th>"; 
                                echo "<th>Contact</th>"; 
                                echo "<th>Kg</th>"; 
                                echo "<th>Үйлдэл</th>"; 
                                echo "</tr>";
                                $count=1;
                                while ($data = mysqli_fetch_array($query))
                                    { 
                                        $barcode=$data["barcode"];
                                        $combined=$data["combined"];
                                        $barcodes=$data["barcodes"];
                                        $order_id=$data["order_id"];
                                        $weight=$data["weight"];
                                        $receiver=$data["receiver"];
                                        
                                        echo "<tr>";
                                        echo "<td>".$count++."</td>";
                                        echo "<td>".barcode_comfort($barcode)."</td>";
                                        
                                        if ($combined==0)
                                        {
                                        $result_order = mysqli_query($conn,"SELECT * FROM orders WHERE order_id=".$order_id);
                                        if (mysqli_num_rows($result_order)==1)
                                            {
                                                $row_order=mysqli_fetch_array($result_order);
                                            // $status=$result_order->status;
                                                $receiver = $row_order["receiver"];
                                                $proxy= $row_order["proxy_id"];
                                                $proxy_type= $row_order["proxy_type"];
                                            }
                                            else $proxy="";
                                        }
                                        if ($combined==1)
                                        {
                                        $result_combine = mysqli_query($conn,"SELECT * FROM box_combine WHERE barcode='".$barcode."'");
                                        if (mysqli_num_rows($result_combine)==1)
                                            {
                                                $combine_row=mysqli_fetch_array($result_combine);
                                            // $status=$combine_data["status;
                                                $receiver = $combine_row["receiver"];
                                                $proxy= $combine_row["proxy_id"];
                                                $proxy_type= $combine_row["proxy_type"];
                                            }
                                            else $proxy="";
                                            }
                                        echo "<td>".customer($receiver,"full_name");echo "<br>";
                                        if ($proxy!="") echo proxy2($proxy,"name",$proxy_type);"</td>";
                                        echo "<td>".customer($receiver,"tel")."</td>";
                                        echo "<td>".$weight."</td>";
                                        $total_weight+=$weight;
                                        echo "<td><a href='?action=removing&barcode=$barcode&id=$box_id' class='btn btn-danger btn-xs'>гаргах</a></td>";
                                        echo "</tr>";
                                    }
                            echo "</table>";

                            echo "Нийт ачааны тоо:".$boxes_packages."&nbsp;&nbsp;&nbsp;Нийт жин:".$total_weight." Кg<br>";
                        }
                        else echo "Nothing inside Box<br>";
                    }
                    else echo "Box id not found";
                }

                if ($action=="removing")
                {
                    // Get box_id from URL if available
                    $box_id_from_url = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
                    
                    if (isset($_GET["barcode"])) 
                    {
                        $barcode =$_GET["barcode"];
                        $barcode = mysqli_real_escape_string($conn, $barcode);
                        $weight=0;
                        $success = false;
                        // Check for single barcode: GO2* (but not GO5* which is combine)
                        if ((substr($barcode,0,3)=="GO2" && substr($barcode,0,4)!="GO5")) // SINGLE BARCODE
                            {
                            $result = mysqli_query($conn,"SELECT * FROM orders WHERE barcode='".$barcode."' LIMIT 1");
                            // echo "SELECT * FROM orders WHERE barcode='".$barcode."' LIMIT 1";
                            if (mysqli_num_rows($result)==1)
                                {
                                    $data = mysqli_fetch_array($result);
                                    $order_id = $data["order_id"];
                                    // echo $order_id;
                                    $weight= $data["weight"];
                                    if(substr($weight,-2)=="kg" || substr($weight,-2)=="Kg") $weight = substr($weight,0,strlen($weight)-2);
        
                                    
                                    $result2 = mysqli_query($conn,"SELECT * FROM boxes_packages WHERE order_id='".$order_id."' LIMIT 1");
                                    if (mysqli_num_rows($result2)==1)
                                        {
                                            $data2= mysqli_fetch_array($result2);
                                            $box_id = $data2["box_id"];
                                            
                                            // Check box status - only allow removal from boxes with status='new'
                                            $box_check = mysqli_query($conn,"SELECT status FROM boxes WHERE box_id='".$box_id."' LIMIT 1");
                                            if (mysqli_num_rows($box_check)==1)
                                            {
                                                $box_data = mysqli_fetch_array($box_check);
                                                $box_status = $box_data["status"];
                                                
                                                if ($box_status == 'new')
                                                {
                                                    mysqli_query($conn,"DELETE FROM boxes_packages WHERE order_id='".$order_id."'");
                                                    mysqli_query($conn,"UPDATE boxes SET weight=weight-$weight,packages=packages-1 WHERE box_id='".$box_id."'");
                                                    mysqli_query($conn,"UPDATE orders SET boxed=0 WHERE barcode='".$barcode."'");
                                                    header("Location:?action=detail&id=".$box_id."&message=removed_success");
                                                    exit;
                                                }
                                                else
                                                {
                                                    header("Location:?action=detail&id=".$box_id."&message=box_not_new");
                                                    exit;
                                                }
                                            }
                                            else
                                            {
                                                header("Location:?action=detail&id=".$box_id."&message=box_not_found");
                                                exit;
                                            }
                                        }	
                                    else echo "single not found in boxes_packages";	
                                }
                                else 
                                {
                                    // If not found in barcode field, check third_party field (track number)
                                    $result = mysqli_query($conn,"SELECT * FROM orders WHERE third_party='".mysqli_real_escape_string($conn, $barcode)."' LIMIT 1");
                                    if (mysqli_num_rows($result)==1)
                                        {
                                            $data = mysqli_fetch_array($result);
                                            $order_id = $data["order_id"];
                                            $actual_barcode = $data["barcode"];
                                            $weight= $data["weight"];
                                            if(substr($weight,-2)=="kg" || substr($weight,-2)=="Kg") $weight = substr($weight,0,strlen($weight)-2);
                                            
                                            $result2 = mysqli_query($conn,"SELECT * FROM boxes_packages WHERE order_id='".$order_id."' LIMIT 1");
                                            if (mysqli_num_rows($result2)==1)
                                                {
                                                    $data2= mysqli_fetch_array($result2);
                                                    $box_id = $data2["box_id"];
                                                    
                                                    // Check box status - only allow removal from boxes with status='new'
                                                    $box_check = mysqli_query($conn,"SELECT status FROM boxes WHERE box_id='".$box_id."' LIMIT 1");
                                                    if (mysqli_num_rows($box_check)==1)
                                                    {
                                                        $box_data = mysqli_fetch_array($box_check);
                                                        $box_status = $box_data["status"];
                                                        
                                                        if ($box_status == 'new')
                                                        {
                                                            mysqli_query($conn,"DELETE FROM boxes_packages WHERE order_id='".$order_id."'");
                                                            mysqli_query($conn,"UPDATE boxes SET weight=weight-$weight,packages=packages-1 WHERE box_id='".$box_id."'");
                                                            mysqli_query($conn,"UPDATE orders SET boxed=0 WHERE barcode='".$actual_barcode."'");
                                                            header("Location:?action=detail&id=".$box_id."&message=removed_success");
                                                            exit;
                                                        }
                                                        else
                                                        {
                                                            header("Location:?action=detail&id=".$box_id."&message=box_not_new");
                                                            exit;
                                                        }
                                                    }
                                                    else
                                                    {
                                                        header("Location:?action=detail&id=".$box_id."&message=box_not_found");
                                                        exit;
                                                    }
                                                }
                                        }
                                }
                            }
                            
                        if (substr($barcode,0,3)=="GO5") // COMBINE BARCODE	
                            {
                                $result_combine = mysqli_query($conn,"SELECT * FROM box_combine WHERE barcode='".$barcode."' LIMIT 1");
                                if (mysqli_num_rows($result_combine)==1)
                                    {
                                    $data_combine= mysqli_fetch_array($result_combine);
                                    $barcodes = $data_combine["barcodes"];
                                    $weight = $data_combine["weight"];
                                    $combine_id = $data_combine["combine_id"];
                                    if(substr($weight,-2)=="kg" || substr($weight,-2)=="Kg") $weight = substr($weight,0,strlen($weight)-2);
        
                                    $query2 = mysqli_query($conn,"SELECT * FROM boxes_packages WHERE barcode='".$barcode."' LIMIT 1");
                                    if (mysqli_num_rows($query2)==1)
                                        {
                                            $row2= mysqli_fetch_array($query2);
                                            $box_id = $row2["box_id"];
                                            
                                            // Check box status - only allow removal from boxes with status='new'
                                            $box_check = mysqli_query($conn,"SELECT status FROM boxes WHERE box_id='".$box_id."' LIMIT 1");
                                            if (mysqli_num_rows($box_check)==1)
                                            {
                                                $box_data = mysqli_fetch_array($box_check);
                                                $box_status = $box_data["status"];
                                                
                                                if ($box_status == 'new')
                                                {
                                                    mysqli_query($conn,"DELETE FROM boxes_packages WHERE barcode='".$barcode."'");
                                                    mysqli_query($conn,"UPDATE boxes SET weight=weight-$weight,packages=packages-1 WHERE box_id='".$box_id."'");
                                                    mysqli_query($conn,"UPDATE box_combine SET boxed=0 WHERE barcode='".$barcode."'");
                                                    header("Location:?action=detail&id=".$box_id."&message=removed_success");
                                                    exit;
                                                }
                                                else
                                                {
                                                    header("Location:?action=detail&id=".$box_id."&message=box_not_new");
                                                    exit;
                                                }
                                            }
                                            else
                                            {
                                                header("Location:?action=detail&id=".$box_id."&message=box_not_found");
                                                exit;
                                            }
                                        }
                                    }
                            }
                    }
                    else 
                    {
                        // If barcode not provided, redirect with error
                        if (isset($_GET["id"])) {
                            header("Location:?action=detail&id=".$_GET["id"]."&message=error");
                        } else {
                            header("Location:?action=list&message=error");
                        }
                        exit;
                    }
                }

                if ($action=="create")
                {
                    ?>
                    <form action="?action=creating" method="POST">
                    
                    <table class='table table-hover'>
                        <tr><td> Name:(*)</td><td><input type="text" class="form-control" name ="box_name" placeholder="Жишээ: HDB1500"></td></tr>
                    </table>
                        <button type="submit" class="btn btn-success" type="submit">Add</button>
                    

                    </form>
                    <?php                    
                }
                if ($action=="creating")
                {
                    $name=$_POST["box_name"];
                    if ($name!="")
                    {
                    $result = mysqli_query($conn,"SELECT * FROM boxes WHERE name='$name'");
                    if (mysqli_num_rows($result) == 0)
                        {
                            $sql = "INSERT INTO boxes (name,packages,agent,status) VALUES ('$name',0,'$g_agent_logged_id','new')";
                            if (mysqli_query($conn,$sql))
                                {
                                $box_id= mysqli_insert_id ($conn);
                                echo '<div class="alert alert-success" role="alert">Амжилттай нэмэгдлээ</div>';
                                echo '<a href="?action=fill&id='.$box_id.'" class="btn btn-primary btn-xs">Fill box</a>';
                                }
                        }
                        else echo '<div class="alert alert-danger" role="alert">BOX-н нэр давхацаж байна.</div>';
                    }
                    else echo '<div class="alert alert-danger" role="alert">Хоосон утга байж болохгүй.</div>';
                    ?>
                    <br>
                    <a href="?action=active" class="btn btn-primary mt-3">Boxes</a>
                    <?php                    
                }

                if ($action=="fill")
                {
                    if (isset($_GET["id"]))
                    {
                        $box_id = intval($_GET["id"]);
                        ?>
                        <form action="?action=filling" method="POST">
                            <input type="hidden" name="box_id" value="<?=$box_id;?>">                            
                            <h4 class="legend">Track or Barcode</h4>
                            <?php 
                            $barcode_value = "";
                            if (isset($_GET["message"]) && $_GET["message"]=="barcode_not_found" && isset($_POST["barcode"])) {
                                $barcode_value = htmlspecialchars($_POST["barcode"]);
                            }
                            ?>
                            <input type="text" name="barcode" value="<?=$barcode_value;?>" class="form-control" placeholder="GO15101588MN" autofocus>
                            
                    <?php                    
                            if (isset($_GET["message"]))            
                            {
                                $message = $_GET["message"];
                                $message_text = $message;
                                // Translate common error messages
                                if ($message == "barcode_not_found") $message_text = "Barcode олдсонгүй";
                                elseif ($message == "ok") $message_text = "Амжилттай нэмэгдлээ";
                                elseif ($message == "already") $message_text = "Энэ barcode аль хэдийн хайрцагт байна";
                                elseif ($message == "already_in_box") $message_text = "Энэ barcode аль хэдийн хайрцагт байна";
                                elseif ($message == "box_not_found") $message_text = "Хайрцаг олдсонгүй";
                                elseif ($message == "onair") $message_text = "Хайрцаг аль хэдийн нислэгт явсан";
                                elseif ($message == "no_inputs") $message_text = "Barcode эсвэл хайрцаг оруулаагүй байна";
                                elseif ($message == "db_error") $message_text = "Өгөгдлийн сангийн алдаа";
                                ?>
                                <div class="alert <?=($message=="ok")?'alert-success':'alert-danger';?>"><?=$message_text;?></div>
                    <?php                    
                            }                 
                            ?>

                            <button type="submit" class="btn btn-success">Оруулах</button>
                        </form>
                    <?php                    
                    }
                    else echo '<div class="alert alert-danger" role="alert">Хоосон утга байж болохгүй.</div>';
                }

                if ($action=="filling")
                {
                    if (isset($_POST["box_id"])) $box_id = $_POST["box_id"]; 
                    if (isset($_POST["barcode"]))$barcode = strtoupper($_POST["barcode"]);
                    //if ($this->uri->segment(3)) $box_id =$this->uri->segment(3);
                    //if ($this->uri->segment(4)) $barcode=$this->uri->segment(4);
                    //echo "box:".$box_id;
                    //echo "barcode:".$barcode;
                    //echo "===============";


                    $combined=0;
                    $order_id=0;
                    $weight=0;
                    $error=0;
                    $receiver = 0;
                        if ($box_id!="" && $barcode!="")
                        {
                            // First check barcode field
                            $result = mysqli_query($conn,"SELECT * FROM orders WHERE barcode='".mysqli_real_escape_string($conn, $barcode)."' LIMIT 1");
                            if (mysqli_num_rows($result)==1)
                            {
                                $data = mysqli_fetch_array($result);
                                $order_id = $data["order_id"];
                                $error=0;
                                $weight=$data["weight"];
                                $receiver=$data["receiver"];
                                $combined=0;
                                if ($data["boxed"]==1) 
                                    {
                                        $error=1;
                                        $sql_already = "SELECT name FROM boxes_packages LEFT JOIN boxes ON boxes_packages.box_id = boxes.box_id WHERE  barcode='".mysqli_real_escape_string($conn, $barcode)."' LIMIT 1";
                                        $result_already=mysqli_query($conn,$sql_already);
                                        if (mysqli_num_rows($result_already)==1)
                                        $data_already = mysqli_fetch_array($result_already);                                
                                        header("Location:?action=fill&id=".$box_id."&message=".$data_already["name"]);
                                    }
                                    else 
                                    header("Location:?action=fill&id=".$box_id."&message=already_in_box");

                            }
                            else
                            {
                                // If not found in barcode field, check third_party field (track number)
                                $result = mysqli_query($conn,"SELECT * FROM orders WHERE third_party='".mysqli_real_escape_string($conn, $barcode)."' LIMIT 1");
                                if (mysqli_num_rows($result)==1)
                                {
                                    $data = mysqli_fetch_array($result);
                                    $order_id = $data["order_id"];
                                    $error=0;
                                    $weight=$data["weight"];
                                    $receiver=$data["receiver"];
                                    $combined=0;
                                    // Use the actual barcode from database, not the track number
                                    $barcode = $data["barcode"];
                                    if ($data["boxed"]==1) 
                                        {
                                            $error=1;
                                            $sql_already = "SELECT name FROM boxes_packages LEFT JOIN boxes ON boxes_packages.box_id = boxes.box_id WHERE  order_id='".$order_id."' LIMIT 1";
                                            $result_already=mysqli_query($conn,$sql_already);
                                            if (mysqli_num_rows($result_already)==1)
                                            $data_already = mysqli_fetch_array($result_already);                                
                                            header("Location:?action=fill&id=".$box_id."&message=".$data_already["name"]);
                                            exit;
                                        }
                                    // If boxed==0, continue with normal flow (don't redirect, let it be added to box)
                                }
                            }

                            $result_combine = mysqli_query($conn,"SELECT * FROM box_combine WHERE barcode='".mysqli_real_escape_string($conn, $barcode)."' LIMIT 1");
                            if (mysqli_num_rows($result_combine)==1)
                            {
                                $data_combine = mysqli_fetch_array($result_combine);
                                $combined=1;
                                $barcodes = $data_combine["barcodes"];
                                $error=0;
                                $weight=$data_combine["weight"];
                                $receiver=$data_combine["receiver"];
                                if ($data_combine["boxed"]==1) 
                                    {
                                        $error=1;
                                        $sql_already = "SELECT name FROM boxes_packages LEFT JOIN boxes ON boxes_packages.box_id = boxes.box_id WHERE  barcode='".mysqli_real_escape_string($conn, $barcode)."' LIMIT 1";
                                        $result_already=mysqli_query($conn,$sql_already);
                                        if (mysqli_num_rows($result_already)==1)
                                            $data_already = mysqli_fetch_array($result_already);                            
                                            header("Location:?action=fill&id=".$box_id."&message=already in ".$data_already["name"]);
                                            exit;
                                    }
                            }
                            
                            if(substr($weight,-2)=="kg" || substr($weight,-2)=="Kg") $weight = substr($weight,0,strlen($weight)-2);
                            
                            if ($error==0)
                            {
                                $result2 = mysqli_query($conn,"SELECT * FROM boxes WHERE box_id='".$box_id."' LIMIT 1");
                                if (mysqli_num_rows($result2) == 1 )
                                    {
                                        $data_box=mysqli_fetch_array($result2);
                                        $box_status=$data_box["status"];
                                    
                                        if ($box_status!="onair"&&$box_status!="delivered" && $box_status!="warehouse")
                                        {
                                            // Check if already in box - use order_id for single orders, barcode for combined
                                            if ($combined==1)
                                                $check_sql = "SELECT * FROM boxes_packages WHERE box_id='$box_id' AND barcode='".mysqli_real_escape_string($conn, $barcode)."' LIMIT 1";
                                            else
                                                $check_sql = "SELECT * FROM boxes_packages WHERE box_id='$box_id' AND order_id='$order_id' LIMIT 1";
                                            
                                            $result=mysqli_query($conn,$check_sql);
                                            if (mysqli_num_rows($result)==0)
                                                {
                                                    if ($combined==1)
                                                        $sql = "INSERT INTO boxes_packages (box_id,barcode,barcodes,order_id,combined,weight,receiver) VALUES ('$box_id','".mysqli_real_escape_string($conn, $barcode)."','".mysqli_real_escape_string($conn, $barcodes)."',0,1,'$weight','$receiver')";
                                                        if ($combined==0)
                                                        $sql = "INSERT INTO boxes_packages (box_id,barcode,barcodes,order_id,combined,weight,receiver) VALUES ('$box_id','".mysqli_real_escape_string($conn, $barcode)."','','$order_id',0,'$weight','$receiver')";

                                                        if (mysqli_query($conn,$sql)) 
                                                        {
                                                            echo '<div class="alert alert-success" role="alert">Succesdfully addded</div>';
                                                            mysqli_query($conn,"UPDATE boxes SET packages=packages+1,weight=weight+".$weight." WHERE box_id='$box_id'");								
                                                            
                                                            if ($combined==1)
                                                                {
                                                                    foreach(explode(',',$barcodes) as $each_barcode)
                                                                        {
                                                                            if ($each_barcode!="")
                                                                            mysqli_query($conn,"UPDATE orders SET boxed=1, third_party='' WHERE barcode='$each_barcode'");	
                                                                        }
                                                                    mysqli_query($conn,"UPDATE box_combine SET boxed=1 WHERE barcode='$barcode'");
                                                                }
                                                            if ($combined==0)
                                                            mysqli_query($conn,"UPDATE orders SET boxed=1, third_party='' WHERE barcode='$barcode'");
                                                            header("Location:?action=fill&id=".$box_id."&message=ok");
                                                        }
                                                        else //echo '<div class="alert alert-danger" role="alert">Error:'.$this->db->error().'</div>';
                                                        header("Location:?action=fill&id=".$box_id."&message=db_error");                                                        
                                                }
                                            else //echo '<div class="alert alert-danger" role="alert">Order already inside the box</div>'; 	
                                            header("Location:?action=fill&id=".$box_id."&message=already");
                                        }
                                        else// echo '<div class="alert alert-danger" role="alert">Box status is onair or delivered</div>';
                                        header("Location:?action=fill&id=".$box_id."&message=onair");
                                    }
                                    else //echo '<div class="alert alert-danger" role="alert">Box not found</div>';
                                    header("Location:?action=fill&id=".$box_id."&message=box_not_found");
                                
                            }
                            else//echo '<div class="alert alert-danger" role="alert">Barcode not found</div>';
                            header("Location:?action=fill&id=".$box_id."&message=barcode_not_found");
                        }
                        else //echo '<div class="alert alert-danger" role="alert">Barcode, хайрцаг оруулаагүй байна.</div>';
                        header("Location:?action=fill&id=".$box_id."&message=no_inputs");

                }

                if ($action=="removing")
                {
                    if (isset($_GET["barcode"]))
                    {
                        $barcode = $_GET["barcode"];
                        $weight=0;
                        // Check for single barcode: GO2* (but not GO5* which is combine)
                        if ((substr($barcode,0,3)=="GO2" && substr($barcode,0,4)!="GO5")) // SINGLE BARCODE
                            {
                                $result = mysqli_query($conn,"SELECT * FROM orders WHERE barcode='".$barcode."' LIMIT 1");
                                if (mysqli_num_rows($result)==1)
                                    {
                                        $data = mysqli_fetch_array($result);
                                        $order_id = $data["order_id"];
                                        $weight= $data["weight"];
                                        if(substr($weight,-2)=="kg" || substr($weight,-2)=="Kg") $weight = substr($weight,0,strlen($weight)-2);
            
                                        
                                        $result2 = mysqli_query($conn,"SELECT * FROM boxes_packages WHERE order_id='".$order_id."' LIMIT 1");
                                        if (mysqli_num_rows($result2)==1)
                                            {
                                                $data2= mysqli_fetch_array($result2);
                                                $box_id = $data2["box_id"];
                                                mysqli_query($conn,"DELETE FROM boxes_packages WHERE order_id='".$order_id."'");
                                                mysqli_query($conn,"UPDATE boxes SET weight=weight-$weight,packages=packages-1 WHERE box_id='".$box_id."'");
                                                mysqli_query($conn,"UPDATE orders SET boxed=0 WHERE barcode='".$barcode."'");
                                                header("Location:?action=detail&id=".$box_id."&message=removed_success");
                                                exit;
                                            }	
                                            // else single not found in boxes_packages	
                                    }
                                    else 
                                    {
                                        // If not found in barcode field, check third_party field (track number)
                                        $result = mysqli_query($conn,"SELECT * FROM orders WHERE third_party='".mysqli_real_escape_string($conn, $barcode)."' LIMIT 1");
                                        if (mysqli_num_rows($result)==1)
                                            {
                                                $data = mysqli_fetch_array($result);
                                                $order_id = $data["order_id"];
                                                $actual_barcode = $data["barcode"];
                                                $weight= $data["weight"];
                                                if(substr($weight,-2)=="kg" || substr($weight,-2)=="Kg") $weight = substr($weight,0,strlen($weight)-2);
                                                
                                                $result2 = mysqli_query($conn,"SELECT * FROM boxes_packages WHERE order_id='".$order_id."' LIMIT 1");
                                                if (mysqli_num_rows($result2)==1)
                                                    {
                                                        $data2= mysqli_fetch_array($result2);
                                                        $box_id = $data2["box_id"];
                                                        
                                                        // Check box status - only allow removal from boxes with status='new'
                                                        $box_check = mysqli_query($conn,"SELECT status FROM boxes WHERE box_id='".$box_id."' LIMIT 1");
                                                        if (mysqli_num_rows($box_check)==1)
                                                        {
                                                            $box_data = mysqli_fetch_array($box_check);
                                                            $box_status = $box_data["status"];
                                                            
                                                            if ($box_status == 'new')
                                                            {
                                                                mysqli_query($conn,"DELETE FROM boxes_packages WHERE order_id='".$order_id."'");
                                                                mysqli_query($conn,"UPDATE boxes SET weight=weight-$weight,packages=packages-1 WHERE box_id='".$box_id."'");
                                                                mysqli_query($conn,"UPDATE orders SET boxed=0 WHERE barcode='".$actual_barcode."'");
                                                                header("Location:?action=detail&id=".$box_id."&message=removed_success");
                                                                exit;
                                                            }
                                                            else
                                                            {
                                                                header("Location:?action=detail&id=".$box_id."&message=box_not_new");
                                                                exit;
                                                            }
                                                        }
                                                        else
                                                        {
                                                            header("Location:?action=detail&id=".$box_id."&message=box_not_found");
                                                            exit;
                                                        }
                                                    }
                                            }
                                    }
                            }
                            
                        if (substr($barcode,0,3)=="GO5") // COMBINE BARCODE	
                            {
                                $result_combine = mysqli_query($conn,"SELECT * FROM box_combine WHERE barcode='".$barcode."' LIMIT 1");
                                if (mysqli_num_rows($result_combine)==1)
                                    {
                                    $data_combine= mysqli_fetch_array($result_combine);
                                    $barcodes = $data_combine["barcodes"];
                                    $weight = $data_combine["weight"];
                                    $combine_id = $data_combine["combine_id"];
                                    if(substr($weight,-2)=="kg" || substr($weight,-2)=="Kg") $weight = substr($weight,0,strlen($weight)-2);
        
                                    $result2 = mysqli_query($conn,"SELECT * FROM boxes_packages WHERE barcode='".$barcode."' LIMIT 1");
                                    if (mysqli_num_rows($result2)==1)
                                        {
                                            $data2= mysqli_fetch_array($result2);
                                            $box_id = $data2["box_id"];
                                            
                                            // Check box status - only allow removal from boxes with status='new'
                                            $box_check = mysqli_query($conn,"SELECT status FROM boxes WHERE box_id='".$box_id."' LIMIT 1");
                                            if (mysqli_num_rows($box_check)==1)
                                            {
                                                $box_data = mysqli_fetch_array($box_check);
                                                $box_status = $box_data["status"];
                                                
                                                if ($box_status == 'new')
                                                {
                                                    mysqli_query($conn,"DELETE FROM boxes_packages WHERE barcode='".$barcode."'");
                                                    mysqli_query($conn,"UPDATE boxes SET weight=weight-$weight,packages=packages-1 WHERE box_id='".$box_id."'");
                                                    mysqli_query($conn,"UPDATE box_combine SET boxed=0 WHERE barcode='".$barcode."'");
                                                    header("Location:?action=detail&id=".$box_id."&message=removed_success");
                                                    exit;
                                                }
                                                else
                                                {
                                                    header("Location:?action=detail&id=".$box_id."&message=box_not_new");
                                                    exit;
                                                }
                                            }
                                            else
                                            {
                                                header("Location:?action=detail&id=".$box_id."&message=box_not_found");
                                                exit;
                                            }
                                        }
                                    }
                            }
                            
                        // If we get here, barcode was not found or didn't match any pattern
                        // Try to get box_id from URL parameter or redirect to boxes list
                        if (isset($_GET["id"])) {
                            header("Location:?action=detail&id=".$_GET["id"]."&message=error");
                        } else {
                            header("Location:?action=list&message=error");
                        }
                    }
                    else
                    echo "Ачааны мэдээлэл өгөөгүй байна.";
                }

                if ($action=="search")
                {
                    ?>

                    <div class="panel panel-primary">
                        <div class="panel-heading">Box-с хайх</div>
                        <div class="panel-body">
                            <form action="?action=searching" method="post">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" placeholder="Tel, name, barcode" required autofocus>
                                    <button type="submit" class="btn btn-success">Хайх</button>
                                </div>
                            </form>                               
                        </div>
                    </div>
                    <?php                    
                }

                if ($action=="searching")
                {
                    if (isset($_POST["search"])) $search_term= $_POST["search"]; else  $search_term="";
                    if ($search_term!="") echo "Хайх:".$search_term."<br>";

                    $sql = "SELECT boxes.*,boxes.name AS box_name,boxes.created_date AS box_created FROM boxes_packages LEFT JOIN boxes ON boxes_packages.box_id=boxes.box_id LEFT JOIN customer ON boxes_packages.receiver=customer.customer_id ";
                    $sql.=" WHERE CONCAT_WS(customer.name,customer.tel,boxes_packages.barcode,boxes_packages.barcodes) LIKE '%".$search_term."%' AND boxes.status IN ('new','onair') GROUP BY boxes.box_id";
                    //echo $sql;
                    $result = mysqli_query($conn,$sql);
                    if (mysqli_num_rows($result) > 0)
                    {
                        // echo form_open("agents/boxes_changing");
                        echo "<table class='table table-hover'>";
                        echo "<tr>";
                           echo "<th>№</th>"; 
                           echo "<th>Нэр</th>"; 
                           echo "<th>Тоо</th>"; 
                           echo "<th>Огноо</th>"; 
                           echo "<th>Төлөв</th>"; 
                           echo "<th>Kg</th>"; 
                           echo "<th>Үйлдэл</th>"; 
                           echo "</tr>";
                           $count=1;
                           $cumulative_weight=0;
                           $cumulative_packages = 0;
                            while ($data = mysqli_fetch_array($result))
                                { 
                                    $box_id= $data["box_id"]; 
                                    $name= $data["box_name"]; 
                                    $packages= $data["packages"];
                                    $created_date = $data["box_created"];
                                    $status = $data["status"];
                                    $order_weight = $data["weight"];
                                
                                
                                echo "<tr>";                                
                                echo "<td>".$count++."</td>";
                                echo "<td>".$name."</td>"; 
                                echo "<td>".$packages."</td>"; 
                                echo "<td>".$created_date."</td>"; 
                                echo "<td>".$status."</td>"; 
                                echo "<td>".$order_weight."</td>"; 
                                //Kg calculate
                                
                                echo "<td><a href='?action=detail&id=".$data["box_id"]."'><i class='ti ti-edit'></i></a></td>"; 
                                echo "</tr>";
                                $cumulative_packages+=$packages;
                                $cumulative_weight+=$order_weight;
                                
                                // array_push($data,array($sender_surname,$sender,$sender_contact,$sender_address,$receiver_surname,$receiver,$receiver_contact,$receiver_address,$temp_status,$Package_advance_value,'',$weight,$price,$description,$barcode));
                            
                                } 
                            echo "<tr><td></td><td colspan='2'>Нийт</td><td>$cumulative_packages</td><td></td><td></td><td>$cumulative_weight</td><td></td></tr>";
                            echo "</table>";
                        
                        
                        //$writer = new XLSXWriter();
                        //$writer->writeSheet($data);
                        //$writer->writeToFile('assets/boxes.xlsx');
                        // $options = array(
                        //               //''  => 'Шинэ төлөвийн сонго',
                        //               //'delivered'  => 'Хүргэж өгөх',
                        //               'onair'    => 'Онгоцоор нисгэх',
                        //              //'warehouse'   => 'Агуулахад оруулах',
                        //               //'custom' => 'Гааль',
                        //               'delete' => 'Хайрцагын устгах',
                        //             );
                    
                    
                        // echo form_dropdown('options', $options, '',array("class"=>"form-control"));
                        // echo "<div id=\"more\"></div>";
                        // echo form_submit("submit","өөрчил",array("class"=>"btn btn-success"));
                        // echo form_close();
                    }
                    else echo "No boxes";
                    
                }

                if ($action=="combined")
                {
                        if (isset($_GET["id"])) $combine_id = intval($_GET["id"]); else $combine_id=0;                        

                        if ($combine_id==0)
                        {
                            $sql="SELECT * FROM box_combine WHERE status!='delivered' AND status!='warehouse' ORDER BY created_date DESC";
                            $result = mysqli_query($conn,$sql);
                            if (mysqli_num_rows($result) > 0)
                            {
                                echo "<table class='table table-hover'>";
                                echo "<tr>";
                                echo "<th>№</th>"; 
                                echo "<th>Barcode</th>"; 
                                echo "<th>Х/aвагч</th>"; 
                                echo "<th>Огноо</th>"; 
                                echo "<th>Төлөв</th>"; 
                                echo "<th>Kg</th>"; 
                                echo "<th></th>"; 
                                echo "</tr>";
                                $count=1;
                                $total_weight=0;
                                $cumulative_weight=0;
                                $cumulative_packages = 0;
                                while ($data = mysqli_fetch_array($result))
                                { 
                                    $combine_id= $data["combine_id"]; 
                                    $receiver= $data["receiver"]; 
                                    $weight= $data["weight"];
                                    $created_date = $data["created_date"];
                                    $barcode = $data["barcode"];
                                    $barcodes = $data["barcodes"];
                                    $proxy_id = $data["proxy_id"];
                                    $status = $data["status"];
                                    $total_weight+=$weight;
                                
                                    echo "<tr>";
                                    echo "<td>".$count++."</td>";
                                    echo "<td>".$barcode."</td>";
                                    echo "<td>";
                                            echo customer($receiver,"name");
                                            echo "<br>";
                                            echo customer($receiver,"tel");
                                    echo "</td>"; 
                                    echo "<td>".$created_date."</td>"; 
                                    echo "<td>".$status."</td>"; 
                                    echo "<td>".$weight."</td>"; 
                                
                                    echo "<td>";
                                        if ($status!="warehouse" && $status!="delivered" && $status!="onair")
                                            echo '<a href="?action=combine_delete&id='.$combine_id.'"><i class="ti ti-trash"></i></span>';
                                    echo '<a href="?action=combined&id='.$combine_id.'"><i class="ti ti-edit"></i></span>';                                                                       
                                    echo "</td>"; 
                                    echo "</tr>";
                            
                                } 
                                echo "<tr><td></td><td colspan='2'>Нийт</td><td>$cumulative_packages</td><td></td><td></td><td>$cumulative_weight</td><td></td></tr>";
                            
                                echo "</table>";
                                
                            }
                            else echo '<div class="alert alert-danger" role="alert">No combines</div>';
                        }


                        if ($combine_id>0)
                        {
                            $sql="SELECT * FROM box_combine WHERE combine_id='$combine_id' ORDER BY created_date DESC";
                            $result = mysqli_query($conn,$sql);
                            if (mysqli_num_rows($result) == 1)
                            {                            
                                $data=mysqli_fetch_array($result);
                                $barcode=$data["barcode"];
                                $barcodes = $data["barcodes"];
                                echo "<h6>".$barcode." нэгтгэсэн ачаа</h6>";
                                echo "<a href='combine_preview?combine_id=".$combine_id."' class='btn btn-success btn-sm mb-5' target='new'>Combine preview</a><br>";
                                echo str_replace(",", "<br>", $barcodes);
                            }
                            else echo '<div class="alert alert-danger" role="alert">Combined box not found</div>';
                        }
                }

                if ($action=="combine_delete")
                {
                    if (isset($_GET["id"])) $combine_id = intval($_GET["id"]); else $combine_id=0;       

                    $sql="SELECT * FROM box_combine WHERE combine_id='".$combine_id."'";
                    $result = mysqli_query($conn,$sql);
                    if (mysqli_num_rows($result) ==1)
                    {
                        $data= mysqli_fetch_array($result);
                        $status = $data["status"];
                        if ($status!="warehouse" && $status!="delivered" && $status!="onair")
                        {
                            if (mysqli_query($conn,"DELETE FROM box_combine WHERE combine_id=".$combine_id)) 
                            echo "Амжилттай устгалаа";
                            else "Error:".mysqli_error($conn);
                        }
                        else echo "Устгах боломжгүй";
                    }
                    else echo "Нэгтгэл олдсонгүй";
                }

                if ($action=="combine")
                {
                    ?>
                    <h5>Нэгтгэх ачааны barcode-г оруулна уу.</h5>
                    <form method="post" action="?action=combining">
                        <textarea class="form-control" name="combine_barcodes" placeholder="GO15091855MN" autofocus required style="height:100px"></textarea>
                        <button type="submit" class="btn btn-success mt-3">Нэгтгэх</button>
                    </form>
                    <?php                    
                }

                if ($action=="combining")
                {
                    ?>
                    <h5>Нэгтгэх ачааны barcode-г оруулна уу.</h5>
                    <?php                    
                    if (isset($_POST["combine_barcodes"]))
                    {
                        $combine = $_POST["combine_barcodes"];
                        $combine_array=explode("\r\n",$combine);
                        $first_combine = $combine_array[0];
                        $sql = "SELECT * FROM orders WHERE barcode='$first_combine' LIMIT 1";
                        $result =mysqli_query($conn,$sql);
                        if(mysqli_num_rows($result)==1)
                        {
                            $data=mysqli_fetch_array($result);
                            $receiver = $data["receiver"];
                            $similar = 1;
                        }
                        else $similar = 0;
                    
                        foreach($combine_array as $combine_barcode)
                            {
                                // echo $combine_barcode;
                                if ($combine_barcode!="") 
                                    {
                                        $sql = "SELECT * FROM orders WHERE barcode='$combine_barcode' LIMIT 1";
                                        $result =mysqli_query($conn,$sql);
                                        if (mysqli_num_rows($result)==1)
                                            {
                                                $data=mysqli_fetch_array($result);
                                                if($receiver!= $data["receiver"]) $similar =0;
                                            }
                                        else $similar =0;
                                    }
                            }
                        
                            if ($similar==1)
                            {
                                $barcodes=implode(",",$combine_array);
                                $weight=0;
                                $advance=0;
                                $advance_value=0;
                                $agent_id=$g_agent_logged_id;
                                $status="new";
                                $package="";
                                $proxy_id =0;
                                $proxy_type=0;
                                $current_proxy=0;
                        
                                $sql_customer="SELECT no_proxy FROM customer WHERE customer_id='$receiver' LIMIT 1";
                                $result_customer = mysqli_query($conn,$sql_customer);
                                if (mysqli_num_rows($result_customer) == 1)
                                {
                                    $data_customer=mysqli_fetch_array($result_customer);
                                    $no_proxy=$data_customer["no_proxy"];
                                }
                                else $no_proxy=0;
                            
                                if ($no_proxy==0)
                                {
                            
                                    $result_proxies = mysqli_query($conn,'SELECT * FROM proxies WHERE customer_id="'.$receiver.'" AND status=0 ORDER BY proxy_id DESC');
                                    $proxy_available_id=0;
                                    if (mysqli_num_rows($result_proxies)>1)
                                    {
                                        while($data_proxies = mysqli_fetch_array($result_proxies))
                                        {
                                            $proxy_id = $data_proxies["proxy_id"];
                                            $proxy_type = 1;
                                            break;
                    
                                            //$order_proxy = mysqli_query($conn,'SELECT proxy_id FROM orders WHERE receiver="'.$receiver.'" AND proxy_id="'.$proxy_id_instance.'" AND status NOT IN ("delivered","warehouse","custom","onair")');
                                            
                                            //$combine_proxy = mysqli_query($conn,'SELECT proxy_id FROM box_combine WHERE receiver="'.$receiver.'" AND proxy_id="'.$proxy_id_instance.'" AND status NOT IN ("delivered","warehouse","custom","onair")');
                                            
                                            //if ($order_proxy->num_rows() == 0 && $combine_proxy->num_rows()==0) 
                                            //	{$proxy_available_id= $proxy_id_instance;break;}
                                        }
                                    }
                                    //$proxy_id =$proxy_available_id;
                                    //$proxy_type=0;	
                    
                                    /*
                                    if ($proxy_id==0)
                                    {
                                        $query_proxies = mysqli_query($conn,'SELECT * FROM proxies_public');
                                        $proxy_available_id=0;
                                        if ($query_proxies->num_rows()>0)
                                            {
                                                foreach($query_proxies->result() as $row_proxy)
                                                {
                                                    $proxy_id = $row_proxy -> proxy_id;
                                                    $proxy_type = 1;
                                                    break;
                                                    //$order_proxy = mysqli_query($conn,'SELECT proxy_id FROM orders WHERE status NOT IN ("delivered","warehouse","custom","onair") AND proxy_type=1 AND proxy_id="'.$proxy_each.'"');
                                                    
                                                    //$combine_proxy = mysqli_query($conn,'SELECT proxy_id FROM box_combine WHERE  status NOT IN ("delivered","warehouse","custom","onair") AND proxy_id="'.$proxy_each.'" AND proxy_type=1');
                                                    
                                                    //if ($order_proxy->num_rows() == 0 && $combine_proxy->num_rows()==0) 
                                                    //{ $proxy_available_id= $proxy_each; break;echo $proxy_each;}
                                                }
                                            }
                                        //$proxy_id =$proxy_available_id;
                                        //$proxy_type=1;
                                    }
                                    */
                                    //if ($current_proxy!=0) $proxy_id=$current_proxy;
                                }
                            
                            
                            
                            foreach($combine_array as $combine_barcode)
                                {
                                    if ($combine_barcode!="") 
                                        {
                                        $sql = "SELECT * FROM orders WHERE barcode='$combine_barcode' LIMIT 1";
                                        $result =mysqli_query($conn,$sql);
                                        if (mysqli_num_rows($result)==1)
                                            {
                                            $data=mysqli_fetch_array($result);
                                            $weight+=$data["weight"];
                                            $advance+=$data["advance"];
                                            $advance_value=$data["advance_value"];	
                                            $package_single=$data["package"];
                            
                                            $package_single_array=explode("##",$package_single);
                            
                                            $package1_name = $package_single_array[0];
                                            $package1_num = $package_single_array[1];
                                            $package1_value = $package_single_array[2];
                                            
                                            $package.=$package1_name."##".$package1_num."##".$package1_value."##";
                                            }	
                                        }
                                }
                            
                            echo "PACAKGE:".$package;
                        
                            if ($weight>2.8) {$proxy_id=0;$proxy_type=0;}
                            
                            $package = str_replace("####","",$package);
                            $sql = "INSERT INTO box_combine (created_date,receiver,package,weight,advance,advance_value,barcodes,status,proxy_id,proxy_type,barcode,agent)
                            VALUES ('".date("y-m-d H:i:s")."','$receiver','$package','$weight','$advance','$advance_value','$barcodes','$status','$proxy_id','$proxy_type','".'GO5'.substr(date("ymd"),1).sprintf("%03d",rand(000,999)).'MN'."','$g_agent_logged_id')";
            
                            if (mysqli_query($conn,$sql)) 
                                {
                                    $combine_id= mysqli_insert_id($conn);
                                    proxy_available($proxy_id,$proxy_type,1);
                                    echo '<div class="alert alert-success" role="alert">Амжилттай хайрцаглалаа</div>';
                                    echo '<a href="combine_preview?combine_id='.$combine_id.'" target="new" class="btn btn-warning">CP72 print</a><br>';
                                    echo '<a href="?action=combined&id='.$combine_id.'" class="btn btn-primary">Дэлгэрэнгүй</a><br>';
                                }
                                else echo "Алдаа:".mysqli_error($conn);
                            }
                            else echo "Barcode нэг хүнийх биш barcode байна.";
                    }

                    if (isset($_POST["barcodes"]))
                    {
                        $barcodes = $_POST["barcodes"];

                        $first_combine = $barcodes[0];
                        $sql = "SELECT * FROM orders WHERE barcode='$first_combine' LIMIT 1";
                        $result =mysqli_query($conn,$sql);
                        if(mysqli_num_rows($result)==1)
                        {
                            $data=mysqli_fetch_array($result);
                            $receiver = $data["receiver"];
                            $similar = 1;
                        }
                        else $similar = 0;
                    
                        foreach($barcodes as $combine_barcode)
                            {
                                // echo $combine_barcode;
                                if ($combine_barcode!="") 
                                    {
                                        $sql = "SELECT * FROM orders WHERE barcode='$combine_barcode' LIMIT 1";
                                        $result =mysqli_query($conn,$sql);
                                        if (mysqli_num_rows($result)==1)
                                            {
                                                $data=mysqli_fetch_array($result);
                                                if($receiver!= $data["receiver"]) $similar =0;
                                            }
                                        else $similar =0;
                                    }
                            }
                        
                            if ($similar==1)
                            {
                                $weight=0;
                                $advance=0;
                                $advance_value=0;
                                $agent_id=$g_agent_logged_id;
                                $status="new";
                                $package="";
                                $proxy_id =0;
                                $proxy_type=0;
                                $current_proxy=0;
                        
                                $sql_customer="SELECT no_proxy FROM customer WHERE customer_id='$receiver' LIMIT 1";
                                $result_customer = mysqli_query($conn,$sql_customer);
                                if (mysqli_num_rows($result_customer) == 1)
                                {
                                    $data_customer=mysqli_fetch_array($result_customer);
                                    $no_proxy=$data_customer["no_proxy"];
                                }
                                else $no_proxy=0;
                            
                                if ($no_proxy==0)
                                {
                            
                                    $result_proxies = mysqli_query($conn,'SELECT * FROM proxies WHERE customer_id="'.$receiver.'" AND status=0 ORDER BY proxy_id DESC');
                                    $proxy_available_id=0;
                                    if (mysqli_num_rows($result_proxies)>1)
                                    {
                                        while($data_proxies = mysqli_fetch_array($result_proxies))
                                        {
                                            $proxy_id = $data_proxies["proxy_id"];
                                            $proxy_type = 1;
                                            break;
                    
                                            //$order_proxy = mysqli_query($conn,'SELECT proxy_id FROM orders WHERE receiver="'.$receiver.'" AND proxy_id="'.$proxy_id_instance.'" AND status NOT IN ("delivered","warehouse","custom","onair")');
                                            
                                            //$combine_proxy = mysqli_query($conn,'SELECT proxy_id FROM box_combine WHERE receiver="'.$receiver.'" AND proxy_id="'.$proxy_id_instance.'" AND status NOT IN ("delivered","warehouse","custom","onair")');
                                            
                                            //if ($order_proxy->num_rows() == 0 && $combine_proxy->num_rows()==0) 
                                            //	{$proxy_available_id= $proxy_id_instance;break;}
                                        }
                                    }
                                    //$proxy_id =$proxy_available_id;
                                    //$proxy_type=0;	
                    
                                    /*
                                    if ($proxy_id==0)
                                    {
                                        $query_proxies = mysqli_query($conn,'SELECT * FROM proxies_public');
                                        $proxy_available_id=0;
                                        if ($query_proxies->num_rows()>0)
                                            {
                                                foreach($query_proxies->result() as $row_proxy)
                                                {
                                                    $proxy_id = $row_proxy -> proxy_id;
                                                    $proxy_type = 1;
                                                    break;
                                                    //$order_proxy = mysqli_query($conn,'SELECT proxy_id FROM orders WHERE status NOT IN ("delivered","warehouse","custom","onair") AND proxy_type=1 AND proxy_id="'.$proxy_each.'"');
                                                    
                                                    //$combine_proxy = mysqli_query($conn,'SELECT proxy_id FROM box_combine WHERE  status NOT IN ("delivered","warehouse","custom","onair") AND proxy_id="'.$proxy_each.'" AND proxy_type=1');
                                                    
                                                    //if ($order_proxy->num_rows() == 0 && $combine_proxy->num_rows()==0) 
                                                    //{ $proxy_available_id= $proxy_each; break;echo $proxy_each;}
                                                }
                                            }
                                        //$proxy_id =$proxy_available_id;
                                        //$proxy_type=1;
                                    }
                                    */
                                    //if ($current_proxy!=0) $proxy_id=$current_proxy;
                                }
                            
                            
                            
                            foreach($barcodes as $combine_barcode)
                                {
                                    if ($combine_barcode!="") 
                                        {
                                        $sql = "SELECT * FROM orders WHERE barcode='$combine_barcode' LIMIT 1";
                                        $result =mysqli_query($conn,$sql);
                                        if (mysqli_num_rows($result)==1)
                                            {
                                            $data=mysqli_fetch_array($result);
                                            $weight+=$data["weight"];
                                            $advance+=$data["advance"];
                                            $advance_value=$data["advance_value"];	
                                            $package_single=$data["package"];
                            
                                            $package_single_array=explode("##",$package_single);
                            
                                            $package1_name = $package_single_array[0];
                                            $package1_num = $package_single_array[1];
                                            $package1_value = $package_single_array[2];
                                            
                                            $package.=$package1_name."##".$package1_num."##".$package1_value."##";
                                            }	
                                        }
                                }
                            
                            echo "PACAKGE:".$package;
                        
                            if ($weight>2.8) {$proxy_id=0;$proxy_type=0;}
                            
                            $package = str_replace("####","",$package);
                            $sql = "INSERT INTO box_combine (created_date,receiver,package,weight,advance,advance_value,barcodes,status,proxy_id,proxy_type,barcode,agent)
                            VALUES ('".date("y-m-d H:i:s")."','$receiver','$package','$weight','$advance','$advance_value','".implode(',',$barcodes)."','$status','$proxy_id','$proxy_type','".'GO5'.substr(date("ymd"),1).sprintf("%03d",rand(000,999)).'MN'."','$g_agent_logged_id')";
            
                            if (mysqli_query($conn,$sql)) 
                                {
                                    $combine_id= mysqli_insert_id($conn);
                                    proxy_available($proxy_id,$proxy_type,1);
                                    echo '<div class="alert alert-success" role="alert">Амжилттай хайрцаглалаа</div>';
                                    echo '<a href="combine_preview?combine_id='.$combine_id.'" target="new" class="btn btn-warning">CP72 print</a><br>';
                                    echo '<a href="?action=combined&id='.$combine_id.'" class="btn btn-primary">Дэлгэрэнгүй</a><br>';
                                }
                                else echo "Алдаа:".mysqli_error($conn);
                            }
                            else echo "Barcode нэг хүнийх биш barcode байна.";
                    }


                }

                if ($action=="relative")
                {
                    ?>
                    <h6>Хамааралтай ачааг олох</h6>
                    <form action="?action=relative_search" method="post">
                        <div class="input-group">
                            <input type="text" class="form-control" name="barcode" placeholder="Track, barcode" required autofocus>
                            <button type="submit" class="btn btn-success">Хайх</button>
                        </div>
                    </form>                                           
                    <?php                    
                }

                if ($action=="relative_search")
                {
                    ?>
                    <h6>Хамааралтай ачааг олох</h6>
                    <?php                    
                    if (isset($_POST["barcode"]))
                    {
                        $barcode = $_POST["barcode"];
                        if(substr($barcode,0,2)=="GO")
                        $sql = "SELECT * FROM orders WHERE barcode='$barcode' LIMIT 1";
                        else $sql = "SELECT * FROM orders WHERE third_party='$barcode' LIMIT 1";
                        $result= mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)==1)
                        {
                        $data = mysqli_fetch_array($result);
                        $status = $data["status"];
                        $order_id = $data["order_id"];
                        $receiver= $data["receiver"];
                            echo $receiver_name=customer($receiver,"full_name")."<br>";
                            echo $receiver_contact=customer($receiver,"tel")."<br>";
                            echo $barcode."<br>";
                            if ($status!="delivered" && $status!="warehouse" && $status!="customs")
                            {
                                $sql = "SELECT * FROM orders WHERE receiver='".$receiver."' AND status NOT IN ('delivered','warehouse','customs','onair')";
                                $relatives_result= mysqli_query($conn,$sql);
                                if (mysqli_num_rows($relatives_result)>1)
                                {
                                    ?>
                                    <form action="?action=combining" method="post">
                    <?php                    
                                        echo "<table class='table table-striped'>";
                                        echo "<tr><th><input type='checkbox' name='select_all' title='Select all barcodes' checked></th><th>Barcode</th><th>Track</th><th>Weight</th><th>Status</th></tr>";
                                        while($relatives_data=mysqli_fetch_array($relatives_result))
                                        {
                                            echo "<tr><td><input type='checkbox' name='barcodes[]' value='".$relatives_data["barcode"]."' checked></td>";
                                            echo "<td>".$relatives_data["barcode"]."</td>";
                                            echo "<td><a href='".track($relatives_data["third_party"])."' target='new'>".$relatives_data["third_party"]."</a></td>";
                                            echo "<td>".$relatives_data["weight"]."</td>";
                                            echo "<td>".$relatives_data["status"]."</td>";
                                            echo "</tr>";	 
                                            
                                        }
                                        echo "</table>";
                                        ?>
                                        <button type="submit" class="btn btn-success">Нэгтгэх</button>
                                    </form>
                    <?php                    
                                }

                            }
                            else echo "Barcode-н төлөв.".$status;
                        }
                        else echo "Barcode олдсонгүй.";
                    }
                    else echo "Barcode оруулаагүй.";
                }

                if ($action=="outside")
                {
                    if (isset($_GET["type"])) $type=$_GET["type"]; else $type="order"; 

                    ?>
                    <h5>Box-д ороогүй илгээмжүүд /<?=($type=="order")?'order':'combine';?>/</h5>
                    <div class="btn-group">
                        <a title="Хайрцаглагдаагүй бэлэн ачаа" class="btn btn-warning" href="?action=outside&type=order">(<?=agent_boxed_order();?>) new order</a>
                        <a title="Хайрцаглагдаагүй бэлэн ачаа" class="btn btn-secondary" href="?action=outside&type=combine">(<?=agent_boxed_combine();?>) new combine</a>
                    </div>

                    <?php                    

                    if ( $type=="order")
                    {
                        $sql="SELECT * FROM orders WHERE boxed=0 AND status='new' ORDER BY created_date DESC";                        
                        $result = mysqli_query($conn,$sql);
                        //$query = $this->db->like("barcode","CP87");
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
                                $sender_name=customer($sender_id,"full_name");
                                //$sender_surname=$data["s_surname;
                                $sender_contact=customer($sender_id,"contact");
                                //$sender_address=$data["s_address;
                                //$receiver=$data["r_name;
                                $receiver_id=$data["receiver"];
                                $receiver_name=customer($receiver_id,"full_name");
                                $receiver_contact=customer($receiver_id,"tel");
                        
                                $barcode=$data["barcode"];
                                $package=$data["package"];
                                $description=$data["package"];
                                $Package_advance = $data["advance"];
                                $Package_advance_value = $data["advance_value"];
                                $extra=$data["extra"];
                                $status=$data["status"];
                                $total_weight+=intval($weight);
                                $total_price+=intval($Package_advance_value);
                                $tr=0;
                                $days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;		
                                
                                if ($Package_advance==1&&!$tr)
                                {echo "<tr class='red' title='Үлдэгдэл:".$Package_advance_value."$'>"; $tr=1;}
                                
                                if($status=="warehouse"&&$extra!="") $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status; 
                                if (!$tr) echo "<tr>";else $tr=0;
                            //echo "<td>".form_checkbox("orders[]",$order_id)."</td>"; 
                            echo "<td>".$count++."</td>"; 
                            echo "<td>".$created_date."</td>"; 
                                //echo "<td>".anchor("agents/customers_detail/".$sender_id,$sender_name)."</td>";
                            echo "<td><a href='customers?action=detail&id=".$receiver_id."'>".$receiver_name."</a></td>";
                            echo "<td>".$receiver_contact."</td>"; 
                            echo "<td>".$barcode."</td>"; 
                            echo "<td>".$days."</td>"; 
                            echo "<td>".$temp_status."</td>";
                            echo "<td>".$weight."</td>"; 
                            echo "<td>".(floatval($weight)*floatval(cfg_paymentrate()))."</td>"; 
                            echo "<td>".$Package_advance_value."</td>"; 
                            echo "<td><a href='orders?action=detail&id=".$order_id."'><i class='ti ti-edit'></i></a></td>";
                            echo "</tr>";
                        
                        
                            } 
                            
                            
                            echo "</table>";
                        }
                    }


                    if ( $type=="combine")
                    {
                        $sql="SELECT * FROM box_combine WHERE status='new' AND boxed=0 ORDER BY combine_id DESC";
                        $result = mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result) > 0)
                        {
                            echo "<table class='table table-hover'>";
                            echo "<tr>";
                            echo "<th>№</th>"; 
                            echo "<th>Barcode</th>"; 
                            echo "<th>Х/aвагч</th>"; 
                            echo "<th>Огноо</th>"; 
                            echo "<th>Төлөв</th>"; 
                            echo "<th>Kg</th>"; 
                            echo "<th></th>"; 
                            echo "</tr>";
                            $count=1;
                            $total_weight=0;
                            $cumulative_weight=0;
                            $cumulative_packages = 0;
                            while ($data = mysqli_fetch_array($result))
                            { 
                                $combine_id= $data["combine_id"]; 
                                $receiver= $data["receiver"]; 
                                $weight= $data["weight"];
                                $created_date = $data["created_date"];
                                $barcode = $data["barcode"];
                                $barcodes = $data["barcodes"];
                                $proxy_id = $data["proxy_id"];
                                $status = $data["status"];
                                $total_weight+=$weight;
                            
                            echo "<tr>";
                            echo "<td>".$count++."</td>";
                                echo "<td>".$barcode."</td>";
                            echo "<td>".customer($receiver,"name");
                            echo customer($receiver,"tel");
                            echo "</td>"; 
                            echo "<td>".$created_date."</td>"; 
                            echo "<td>".$status."</td>"; 
                            echo "<td>".$weight."</td>"; 
                        
                            echo "<td>";
                            if ($status!="warehouse" && $status!="delivered" && $status!="onair")
                            echo '<a href="?action=combine_delete&id='.$combine_id.'"><i class="ti ti-trash"></i></span>';
                            echo '<a href="?action=combined&id='.$combine_id.'"><i class="ti ti-edit"></i></span>';             

                            echo "</td>"; 
                            echo "</tr>";
                        
                            } 
                            //echo "<tr><td></td><td colspan='2'>Нийт</td><td>$cumulative_packages</td><td></td><td></td><td>$cumulative_weight</td><td></td></tr>";
                        
                            echo "</table>";
                            
                        }
                        else echo '<div class="alert alert-danger" role="alert">No combines</div>';
                    }





                    

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
        $(document).ready(function() {
            $('input[name="select_all"]').click(function(event) {
                var isChecked = this.checked;
                // Select/deselect all checkboxes with name="boxes[]" but not the select_all checkbox itself
                $('input[name="boxes[]"]').each(function() {
                    this.checked = isChecked;
                });
            });
            
            // Update select_all checkbox when individual checkboxes are clicked
            $('input[name="boxes[]"]').click(function() {
                var totalCheckboxes = $('input[name="boxes[]"]').length;
                var checkedCheckboxes = $('input[name="boxes[]"]:checked').length;
                $('input[name="select_all"]').prop('checked', totalCheckboxes === checkedCheckboxes);
            });
        })            
    </script>
  </body>
</html>
