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
          if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="dashboard";
          $action_title = "Удирдлага"; // Default value
          switch ($action)
          {
            case "display": $action_title="Бүх Ачаа";break;
            case "new": $action_title="Шинэ Ачаа";break;
            case "active": $action_title="Идэвхитэй Ачаа";break;
            case "warehouse": $action_title="Агуулахад ачаатай Ачаа";break;
            case "incoming": $action_title="Ирж буй ачаатай Ачаа";break;
            case "category": $action_title="Ачааийн ангилал";break;          
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
            default: $action_title="Удирдлага";break;
          }
          ?>
          <nav class="page-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="tracks">Трак</a></li>
              <li class="breadcrumb-item"><a href="tracks?action=active">Идэвхитэй трак</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?php echo $action_title;?></li>
            </ol>
          </nav>

          <?php
          if ($action =="dashboard")
          {
            $sql = "SELECT * FROM orders";
            $result = mysqli_query($conn,$sql);
            $total = $result ? mysqli_num_rows($result) : 0;
            ?>
            <div class="row">
              <div class="col-12 col-xl-12 stretch-card">
                <div class="row flex-grow">
                  <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                          <h6 class="card-title mb-0">Нийт Ачаа</h6>
                          <div class="dropdown mb-2">
                            <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <a class="dropdown-item d-flex align-items-center" href="customer?action=display"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">Харах</span></a>
                              <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Excel татах</span></a>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-6 col-md-12 col-xl-5">
                            <h3 class="mb-2"><?php echo number_format($total);?></h3>
                            <div class="d-flex align-items-baseline">
                              <p class="text-success">
                                <span>+3.3%</span>
                                <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                              </p>
                            </div>
                          </div>
                          <div class="col-6 col-md-12 col-xl-7">
                            <div id="apexChart1" class="mt-md-3 mt-xl-0"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                          <h6 class="card-title mb-0">Ирж буй Ачаа</h6>
                          <div class="dropdown mb-2">
                            <button class="btn p-0" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <a class="dropdown-item d-flex align-items-center" href="customer?action=active"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">Харах</span></a>
                              <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Excel татах</span></a>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-6 col-md-12 col-xl-5">
                            <h3 class="mb-2">-</h3>
                            <div class="d-flex align-items-baseline">
                              <p class="text-danger">
                                <span>-2.8%</span>
                                <i data-feather="arrow-down" class="icon-sm mb-1"></i>
                              </p>
                            </div>
                          </div>
                          <div class="col-6 col-md-12 col-xl-7">
                            <div id="apexChart2" class="mt-md-3 mt-xl-0"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                          <h6 class="card-title mb-0">Ирж буй ачаатай Ачаа</h6>
                          <div class="dropdown mb-2">
                            <button class="btn p-0" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                            <a class="dropdown-item d-flex align-items-center" href="customer?action=incoming"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">Харах</span></a>
                              <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Excel татах</span></a>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-6 col-md-12 col-xl-5">
                            <h3 class="mb-2">-</h3>
                            <div class="d-flex align-items-baseline">
                              <p class="text-success">
                                <span>+2.8%</span>
                                <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                              </p>
                            </div>
                          </div>
                          <div class="col-6 col-md-12 col-xl-7">
                            <div id="apexChart3" class="mt-md-3 mt-xl-0"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> <!-- row -->
            <div class="row">
              <div class="col-lg-12">
                <form action="?action=active" method="post">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Хайх..." value="">
      

                    <select  name="status" class="form-control">
                      <option value="all">Бүx идэвхитэй</option>
                      <option value="new">Нисэхэд бэлэн</option>
                      <option value="order">Хүлээн авагчгүй</option>
                      <option value="filled">Х/авагч бөглөсөн</option>
                      <option value="weight_missing">Жин нь бөглөгдөөгүй</option>				 
                      <option value="onair">Онгоцоор ирж байгаа</option>				 
                      <option value="warehouse">Агуулахад байгаа</option>				 
                      <option value="delivered">Хүргэгдсэн</option>				 
                      <option value="custom">Гаальд саатсан</option>				 
                      <option value="transport">Хүргэлттэй</option>				 
                      <option value="db">Баазаас</option>				 
                    </select>

                    <select  name="status_type" class="form-control">
                      <option value="advance">Төлбөртэйг</option>
                      <option value="all">Бүгдийг</option>
                    </select>                      

                    <select  name="search_date" class="form-control">
                      <option value="created">created</option>
                      <option value="onair">onair</option>
                      <option value="warehouse">warehouse</option>
                      <option value="delivered">delivered</option>
                    </select>
                    
                    <input type="date" class="form-control" name="start_date">
                    <input type="date" class="form-control" name="finish_date">
                  
                    <button type="submit" class="btn btn-primary mr-2">Хайх</button>
                  </div>
                </form>
              </div>
            </div>
            <?php
          }
          ?>

          <?php
          if ($action=="active")
          {
            // Initialize variables with default values
            $search = "";
            $search_term = "";
            $search_status = "all";
            $status_type = "all";
            $search_date = "created";
            $start_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 month'));
            $finish_date = date("Y-m-d 23:59:59");
            $date_column = "created_date";
            
            if (isset($_POST["search"])) {
                $search = protect($_POST["search"]);
                $search_term = str_replace(" ","%",$search);
            }
            if (isset($_POST["status"])) $search_status = protect($_POST["status"]);
            if (isset($_POST["status_type"])) $status_type = protect($_POST["status_type"]);
            if (isset($_POST["search_date"])) $search_date = protect($_POST["search_date"]);
            if (isset($_POST["start_date"])) $start_date = protect($_POST["start_date"]); 
            if (isset($_POST["finish_date"])) $finish_date = protect($_POST["finish_date"])." 23:59:59";

            
            $sql="SELECT orders.*, receiver_customer.name AS r_name,receiver_customer.surname AS r_surname,receiver_customer.tel AS r_tel,receiver_customer.address AS r_address,sender_customer.name AS sender_name,sender_customer.surname AS sender_surname,sender_customer.tel AS sender_tel,sender_customer.address AS s_address FROM orders LEFT JOIN customer AS receiver_customer ON orders.receiver=receiver_customer.customer_id 
            LEFT JOIN customer AS sender_customer ON orders.sender=sender_customer.customer_id";
            $search_term_escaped = mysqli_real_escape_string($conn, $search_term);
            $sql.=" WHERE CONCAT_WS(receiver_customer.name,receiver_customer.tel,sender_customer.name,orders.barcode,orders.third_party) LIKE '%".$search_term_escaped."%'";
  
            if ($search_status=="all") 
            $sql.=" AND orders.status NOT IN('completed','delivered','warehouse','custom')";
            if ($search_status=='db')
            $sql.=" AND orders.status IN ('completed','delivered','warehouse','custom','onair','new','order','weight_missing','item_missing','filled')";
  
            if ($search_status!="all" && $search_status!='db' && $search_status!='transport')
            {
                $search_status_escaped = mysqli_real_escape_string($conn, $search_status);
                $sql.=" AND orders.status ='$search_status_escaped'";
            }
  
            if ($status_type=="advance")
            $sql.=" AND orders.advance=1";
  
            if ($search_status=="transport")
            $sql.=" AND orders.transport=1";
  
            $sql.=" AND is_online='1'";
  
            switch($search_date)
            {
              case "created": $date_column = "created_date";break;
              case "onair": $date_column = "onair_date";break;
              case "warehouse": $date_column = "warehouse_date";break;
              case "delivered": $date_column = "delivered_date";break;
              default: $date_column = "created_date";break;
            }
            if ($start_date!="") {
                $start_date_escaped = mysqli_real_escape_string($conn, $start_date);
                $sql.=" AND ".$date_column.">'$start_date_escaped'";
            }
            if ($finish_date!="") {
                $finish_date_escaped = mysqli_real_escape_string($conn, $finish_date);
                $sql.=" AND ".$date_column."<'$finish_date_escaped'";
            }
  
  
  
            $sql.=" ORDER BY order_id DESC";

            $result = mysqli_query($conn,$sql);
            $count=1;$total_weight=0;$total_price=0;

            ?>
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-body">
                    <form action="?action=active" method="post">
                      <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Хайх..." value="<?php echo htmlspecialchars($search);?>">
          

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
                          <option value="received" <?php echo ($search_status=="received")?'SELECTED':'';?>>Delaware-д бүртгэгдсэн</option>				 
                          <option value="transport" <?php echo ($search_status=="transport")?'SELECTED':'';?>>Хүргэлттэй</option>				 
                          <option value="db" <?php echo ($search_status=="db")?'SELECTED':'';?>>Баазаас</option>				 
                        </select>

                        <select  name="status_type" class="form-control">
                          <option value="advance" <?php echo ($status_type=="advance")?'SELECTED':'';?> >Төлбөртэйг</option>
                          <option value="all"  <?php echo ($status_type=="all")?'SELECTED':'';?>>Бүгдийг</option>
                        </select>                      

                        <select  name="search_date" class="form-control">
                          <option value="created" <?php echo ($search_date=="created")?'SELECTED':'';?> >created</option>
                          <option value="onair"  <?php echo ($search_date=="onair")?'SELECTED':'';?>>onair</option>
                          <option value="warehouse" <?php echo ($search_date=="warehouse")?'SELECTED':'';?>>warehouse</option>
                          <option value="delivered" <?php echo ($search_date=="delivered")?'SELECTED':'';?>>delivered</option>
                        </select>
                        
                        <input type="date" class="form-control" name="start_date" value="<?php echo substr($start_date,0,10);?>">
                        <input type="date" class="form-control" name="finish_date" value="<?php echo substr($finish_date,0,10);?>">
                      
                        <button type="submit" class="btn btn-primary mr-2">Хайх</button>
                      </div>
                    </form>
                  </div>
                </div>




              </div>

              <div class="col-lg-12 mt-3">
                <div class="card">
                    <div class="card-body">
                      <div class="table-responsive">
                        <table id="tracks_table" class="table">
                          <thead>
                            <tr>
                                <th>№</th>
                                <th>Үүсгэсэн</th>
                                <th>Хүлээн авагч</th>
                                <th>Утас</th>
                                <th width="80">Barcode / Track</th>
                                <th>Хоног</th>
                                <th>Төлөв</th>
                                <th>Жин</th>
                                <th>Үлдэгдэл</th>
                                <th>Үйлдэл</th>                            
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            if ($result) {
                            while ($data = mysqli_fetch_array($result))
                            {
                              if (!$data) continue;
                              $created_date = isset($data["created_date"]) ? htmlspecialchars($data["created_date"]) : '';
                              $order_id = isset($data["order_id"]) ? intval($data["order_id"]) : 0;
                              $weight = isset($data["weight"]) ? floatval($data["weight"]) : 0;
                              $sender = isset($data["sender_name"]) ? htmlspecialchars($data["sender_name"]) : '';
                              $sender_surname = isset($data["sender_surname"]) ? htmlspecialchars($data["sender_surname"]) : '';
                              $sender_tel = isset($data["sender_tel"]) ? htmlspecialchars($data["sender_tel"]) : '';
                              $sender_address = isset($data["s_address"]) ? htmlspecialchars($data["s_address"]) : '';
                              $sender_id = isset($data["sender"]) ? intval($data["sender"]) : 0;
                              $receiver = isset($data["r_name"]) ? htmlspecialchars($data["r_name"]) : '';
                              $receiver_id = isset($data["receiver"]) ? intval($data["receiver"]) : 0;
                              $receiver_surname = isset($data["r_surname"]) ? htmlspecialchars($data["r_surname"]) : '';
                              $receiver_tel = isset($data["r_tel"]) ? htmlspecialchars($data["r_tel"]) : '';
                              $receiver_address = isset($data["r_address"]) ? htmlspecialchars($data["r_address"]) : '';
                              $proxy = isset($data["proxy_id"]) ? intval($data["proxy_id"]) : 0;
                              $proxy_type = isset($data["proxy_type"]) ? htmlspecialchars($data["proxy_type"]) : '';
                              $barcode = isset($data["barcode"]) ? htmlspecialchars($data["barcode"]) : '';
                              $package = isset($data["package"]) ? htmlspecialchars($data["package"]) : '';
                              $description = isset($data["package"]) ? htmlspecialchars($data["package"]) : '';
                              $Package_advance = isset($data["advance"]) ? intval($data["advance"]) : 0;
                              $Package_advance_value = isset($data["advance_value"]) ? floatval($data["advance_value"]) : 0;
                              $extra = isset($data["extra"]) ? htmlspecialchars($data["extra"]) : '';
                              $third_party = isset($data["third_party"]) ? htmlspecialchars($data["third_party"]) : '';
                              $status = isset($data["status"]) ? htmlspecialchars($data["status"]) : '';
                              $is_branch = isset($data["is_branch"]) ? intval($data["is_branch"]) : 0;
                              $owner = isset($data["owner"]) ? intval($data["owner"]) : 0;
                              $total_weight += $weight;
                              $total_price += $Package_advance_value;
                              $transport = isset($data["transport"]) ? intval($data["transport"]) : 0;
                              $tr = 0;
                              $days = 0;
                              if ($created_date) {
                                  $days = (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;
                              }
                              
                              if ($receiver_id!="" && $status=='order' && !$tr)
                              {echo "<tr class='blue' title='Хүлээн авагч тодорхойгүй'>"; $tr=1;}
                              
                              if ($receiver_id!=1 && $status=='filled' && !$tr)
                              {echo "<tr class='green' title='Хүлээн авагч бөглөсөн'>"; $tr=1;}
                              
                              
                                if ($Package_advance==1 && !$tr)
                              {echo "<tr class='red' title='Үлдэгдэл:".htmlspecialchars($Package_advance_value)."$'>"; $tr=1;}
                              
                              if ($status=='weight_missing' && !$tr)
                              {echo "<tr class='yellow' title='Жин бөглөгдөөгүй байна:'>"; $tr=1;}

                              
                              if($status=="warehouse" && $extra!="") $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status; 
                              if (!$tr) echo "<tr>";else $tr=0;
                              echo "<td>".$count++."</td>"; 
                              echo "<td>".substr($created_date,0,10);
                                if ($transport) echo "<br><span class='glyphicon glyphicon-home' title='Улаанбаатарт хүргэлттэй'></span> Хүргэлттэй";                        
                              echo "</td>"; 
                                   if ($proxy && proxy2($proxy,$proxy_type,"name")<>"") 
                                       {
                                           echo "<td>";
                                           echo '<a href="customers?action=detail&id='.htmlspecialchars($receiver_id).'" class="text-danger">'.htmlspecialchars(proxy2($proxy,$proxy_type,"name")).'</a>';
                                           echo "</td>";
                                           echo "<td>";
                                           echo '<a href="customers?action=detail&id='.htmlspecialchars($receiver_id).'" class="text-danger">'.htmlspecialchars(proxy2($proxy,$proxy_type,"tel")).'</a>';                                           
                                           echo "</td>";
                                       }
                                       else
                                       {
                                       echo "<td>";
                                       echo '<a href="customers?action=detail&id='.htmlspecialchars($receiver_id).'">'.htmlspecialchars(substr($receiver_surname,0,2)).".".htmlspecialchars($receiver).'</a>';
                                       echo "</td>";
                                        echo "<td>".htmlspecialchars($receiver_tel)."</td>"; 
                                       }
                                       
                       
                                           
                               
                       
                             
                              echo "<td class='track_td'>".barcode_comfort($barcode)."<br>"; 
                              if ($third_party!="")
                              echo "<a href='".htmlspecialchars(track($third_party))."' target='new' title='Хаана явна'>".htmlspecialchars($third_party)."<span class='glyphicon glyphicon-globe'></span></a>";
                              if ($is_branch) echo '<span class="badge badge-success">DE</span>';
                              if ($owner==2) echo "SH";
                              echo "</td>"; 
                              echo "<td>".htmlspecialchars($days)."</td>"; 
                              echo "<td>".htmlspecialchars($temp_status)."</td>";
                              echo "<td>".htmlspecialchars($weight)."</td>"; 
                              echo "<td>".htmlspecialchars($Package_advance_value)."</td>"; 
                              echo "<td><a href='?action=detail&id=".htmlspecialchars($order_id)."'>Edit</td>"; 
                              echo "</tr>";
                            }
                            }
                            ?>
                          
                          </tbody>
                          <tfoot>
                            <tr><td colspan='6'>Нийт</td><td><?php echo $total_weight;?></td><td><?php echo $total_weight*cfg_paymentrate();?></td><td><?php echo $total_price;?></td><td></td></tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            <?php
          }
          ?>


          <?php
          if ($action=="search")
          {
            $search_term = "";
            if (isset($_POST["search"])) $search_term= $_POST["search"];

            $search_term = str_replace (" ","",$search_term);
            $track_eliminated = substr($search_term,-8,8);
            $search_term_escaped = mysqli_real_escape_string($conn, $search_term);
            $track_eliminated_escaped = mysqli_real_escape_string($conn, $track_eliminated);

            $sql="SELECT orders.*,
            receivers.name AS receiver_name,receivers.tel AS receiver_tel,receivers.address AS receiver_address, receivers.rd AS receiver_rd,receivers.surname AS receiver_surname,
            senders.name AS sender_name,senders.tel AS sender_tel,senders.address AS sender_address, senders.rd AS sender_rd,senders.surname AS sender_surname 
            FROM orders 
            LEFT JOIN customer AS receivers ON orders.receiver=receivers.customer_id
            LEFT JOIN customer AS senders ON orders.sender=senders.customer_id";

            $sql.=" WHERE LOWER(CONVERT(CONCAT_WS(barcode,package,receivers.name,receivers.tel,created_date)USING utf8)) LIKE '%".$search_term_escaped."%' OR  SUBSTRING(third_party,-8,8) = '".$track_eliminated_escaped."'";
            
            $sql.=" ORDER BY created_date DESC LIMIT 50";
            

            $result = mysqli_query($conn,$sql);
            $count=1;$total_weight=0;$total_price=0;

            ?>
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-body">
                    <form action="?action=search" method="post">
                      <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Хайх..." value="<?php echo htmlspecialchars($search_term);?>">      
                        <button type="submit" class="btn btn-primary mr-2">Хайх</button>
                      </div>
                    </form>
                  </div>
                </div>




              </div>
              <?php
              if (isset($_POST["search"]))
              {
                ?>
                <div class="col-lg-12 mt-3">
                  <div class="card">
                      <div class="card-body">
                        <div class="table-responsive">
                          <table id="tracks_table" class="table">
                            <thead>
                              <tr>
                                  <th>№</th>
                                  <th>Үүсгэсэн</th>
                                  <th>Хүлээн авагч</th>
                                  <th>Утас</th>
                                  <th width="80">Barcode / Track</th>
                                  <th>Хоног</th>
                                  <th>Төлөв</th>
                                  <th>Жин</th>
                                  <th>Үлдэгдэл</th>
                                  <th>Үйлдэл</th>                            
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              if ($result) {
                              while ($data = mysqli_fetch_array($result))
                              {
                                if (!$data) continue;
                                $created_date = isset($data["created_date"]) ? htmlspecialchars($data["created_date"]) : '';
                                $order_id = isset($data["order_id"]) ? intval($data["order_id"]) : 0;
                                $weight = isset($data["weight"]) ? floatval($data["weight"]) : 0;
                                $sender = isset($data["sender_name"]) ? htmlspecialchars($data["sender_name"]) : '';
                                $sender_surname = isset($data["sender_surname"]) ? htmlspecialchars($data["sender_surname"]) : '';
                                $sender_tel = isset($data["sender_tel"]) ? htmlspecialchars($data["sender_tel"]) : '';
                                $sender_address = isset($data["sender_address"]) ? htmlspecialchars($data["sender_address"]) : '';
                                $sender_id = isset($data["sender"]) ? intval($data["sender"]) : 0;
                                $receiver = isset($data["receiver_name"]) ? htmlspecialchars($data["receiver_name"]) : '';
                                $receiver_id = isset($data["receiver"]) ? intval($data["receiver"]) : 0;
                                $receiver_surname = isset($data["receiver_surname"]) ? htmlspecialchars($data["receiver_surname"]) : '';
                                $receiver_tel = isset($data["receiver_tel"]) ? htmlspecialchars($data["receiver_tel"]) : '';
                                $receiver_address = isset($data["receiver_address"]) ? htmlspecialchars($data["receiver_address"]) : '';
                                $proxy = isset($data["proxy_id"]) ? intval($data["proxy_id"]) : 0;
                                $proxy_type = isset($data["proxy_type"]) ? htmlspecialchars($data["proxy_type"]) : '';
                                $barcode = isset($data["barcode"]) ? htmlspecialchars($data["barcode"]) : '';
                                $package = isset($data["package"]) ? htmlspecialchars($data["package"]) : '';
                                $description = isset($data["package"]) ? htmlspecialchars($data["package"]) : '';
                                $Package_advance = isset($data["advance"]) ? intval($data["advance"]) : 0;
                                $Package_advance_value = isset($data["advance_value"]) ? floatval($data["advance_value"]) : 0;
                                $extra = isset($data["extra"]) ? htmlspecialchars($data["extra"]) : '';
                                $third_party = isset($data["third_party"]) ? htmlspecialchars($data["third_party"]) : '';
                                $status = isset($data["status"]) ? htmlspecialchars($data["status"]) : '';
                                $is_branch = isset($data["is_branch"]) ? intval($data["is_branch"]) : 0;
                                $owner = isset($data["owner"]) ? intval($data["owner"]) : 0;
                                $total_weight += $weight;
                                $total_price += $Package_advance_value;
                                $transport = isset($data["transport"]) ? intval($data["transport"]) : 0;
                                $tr = 0;
                                $days = 0;
                                if ($created_date) {
                                    $days = (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;
                                }
                                
                                if ($receiver_id!="" && $status=='order' && !$tr)
                                {echo "<tr class='blue' title='Хүлээн авагч тодорхойгүй'>"; $tr=1;}
                                
                                if ($receiver_id!=1 && $status=='filled' && !$tr)
                                {echo "<tr class='green' title='Хүлээн авагч бөглөсөн'>"; $tr=1;}
                                
                                
                                  if ($Package_advance==1 && !$tr)
                                {echo "<tr class='red' title='Үлдэгдэл:".htmlspecialchars($Package_advance_value)."$'>"; $tr=1;}
                                
                                if ($status=='weight_missing' && !$tr)
                                {echo "<tr class='yellow' title='Жин бөглөгдөөгүй байна:'>"; $tr=1;}

                                
                                if($status=="warehouse" && $extra!="") $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status; 
                                if (!$tr) echo "<tr>";else $tr=0;
                                echo "<td>".$count++."</td>"; 
                                echo "<td>".substr($created_date,0,10);
                                  if ($transport) echo "<br><span class='glyphicon glyphicon-home' title='Улаанбаатарт хүргэлттэй'></span> Хүргэлттэй";                        
                                echo "</td>"; 
                                    if ($proxy && proxy2($proxy,$proxy_type,"name")<>"") 
                                        {
                                            echo "<td>";
                                            echo '<a href="customers?action=proxy&id='.htmlspecialchars($receiver_id).'">'.htmlspecialchars(proxy2($proxy,$proxy_type,"name")).'</a>';
                                            echo "</td>";
                                            echo "<td>";
                                            echo '<a href="customers?action=proxy&id='.htmlspecialchars($receiver_id).'">'.htmlspecialchars(proxy2($proxy,$proxy_type,"tel")).'</a>';                                           
                                            echo "</td>";
                                        }
                                        else
                                        {
                                        echo "<td>";
                                        echo '<a href="customers?action=detail&id='.htmlspecialchars($receiver_id).'">'.htmlspecialchars(substr($receiver_surname,0,2)).".".htmlspecialchars($receiver).'</a>';
                                        echo "</td>";
                                          echo "<td>".htmlspecialchars($receiver_tel)."</td>"; 
                                        }
                                          
                        
                                            
                                
                        
                              
                                echo "<td class='track_td'>".barcode_comfort($barcode)."<br>"; 
                                if ($third_party!="")
                                echo "<a href='".htmlspecialchars(track($third_party))."' target='new' title='Хаана явна'>".htmlspecialchars($third_party)."<span class='glyphicon glyphicon-globe'></span></a>";
                                if ($is_branch) echo '<span class="badge badge-success">DE</span>';
                                if ($owner==2) echo "SH";
                                echo "</td>"; 
                                echo "<td>".htmlspecialchars($days)."</td>"; 
                                echo "<td>".htmlspecialchars($temp_status)."</td>";
                                echo "<td>".htmlspecialchars($weight)."</td>"; 
                                echo "<td>".htmlspecialchars($Package_advance_value)."</td>"; 
                                echo "<td><a href='?action=detail&id=".htmlspecialchars($order_id)."'>Edit</td>"; 
                                echo "</tr>";
                              }
                              ?>
                            
                            </tbody>
                            <tfoot>
                              <tr><td colspan='6'>Нийт</td><td><?php echo $total_weight;?></td><td><?php echo $total_weight*cfg_paymentrate();?></td><td><?php echo $total_price;?></td><td></td></tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>
                </div>
                <?php
              }
              }
              ?>
            </div>
            <?php
          }
          ?>

          <?php
          if ($action == "detail")
          {
            ?>
            <div class="panel panel-primary">
              <div class="panel-heading">Track:Detail</div>
              <div class="panel-body">
                <?php
                if (isset($_GET["id"]))
                {
                  $order_id = intval($_GET["id"]);
                  $sql = "SELECT * FROM orders WHERE order_id='$order_id' LIMIT 1";
                  $result = mysqli_query($conn,$sql);
  
                  if ($result && mysqli_num_rows($result) == 1)
                  {
                        $data = mysqli_fetch_array($result);
                        if (!$data) {
                            echo "Трак олдсонгүй<br>";
                        } else {
                            $created_date = isset($data["created_date"]) ? htmlspecialchars($data["created_date"]) : '';
                            $order_id = isset($data["order_id"]) ? intval($data["order_id"]) : 0;
                            $sender = isset($data["sender"]) ? intval($data["sender"]) : 0;
                            $receiver = isset($data["receiver"]) ? intval($data["receiver"]) : 0;
                            $deliver = isset($data["deliver"]) ? intval($data["deliver"]) : 0;
                            $barcode = isset($data["barcode"]) ? htmlspecialchars($data["barcode"]) : '';
                            $package = isset($data["package"]) ? htmlspecialchars($data["package"]) : '';
                            $insurance = isset($data["insurance"]) ? intval($data["insurance"]) : 0;
                            $insurance_value = isset($data["insurance_value"]) ? floatval($data["insurance_value"]) : 0;
                            $Package_advance = isset($data["advance"]) ? intval($data["advance"]) : 0;
                            $Package_advance_value = isset($data["advance_value"]) ? floatval($data["advance_value"]) : 0;
                            $way = isset($data["way"]) ? htmlspecialchars($data["way"]) : '';
                            $inside = isset($data["inside"]) ? htmlspecialchars($data["inside"]) : '';
                            $deliver_time = isset($data["deliver_time"]) ? htmlspecialchars($data["deliver_time"]) : '';
                            $return_type = isset($data["return_type"]) ? htmlspecialchars($data["return_type"]) : '';
                            $return_day = isset($data["return_day"]) ? intval($data["return_day"]) : 0;
                            $return_way = isset($data["return_way"]) ? htmlspecialchars($data["return_way"]) : '';
                            $return_address = isset($data["return_address"]) ? htmlspecialchars($data["return_address"]) : '';
                            $track = isset($data["third_party"]) ? htmlspecialchars($data["third_party"]) : '';
                            $status = isset($data["status"]) ? htmlspecialchars($data["status"]) : '';
                            $timestamp = isset($data["timestamp"]) ? htmlspecialchars($data["timestamp"]) : '';
                            $extra = isset($data["extra"]) ? htmlspecialchars($data["extra"]) : '';
                            $weight = isset($data["weight"]) ? floatval($data["weight"]) : 0;
  
                            //SENDER 
                            $sender_name = "";
                            $sender_surname = "";
                            $sender_contact = "";
                            $sender_address = "";
                            $sender_rd = "";
                            if ($sender > 0)
                            {
                                $sender_escaped = mysqli_real_escape_string($conn, $sender);
                                $query_sender = mysqli_query($conn,"SELECT * FROM customer WHERE customer_id='$sender_escaped' LIMIT 1");
                                if ($query_sender && mysqli_num_rows($query_sender) > 0) {
                                    while ($row_sender = mysqli_fetch_array($query_sender))
                                    {
                                        if (!$row_sender) continue;
                                        $sender_name = isset($row_sender["name"]) ? htmlspecialchars($row_sender["name"]) : '';
                                        $sender_surname = isset($row_sender["surname"]) ? htmlspecialchars($row_sender["surname"]) : '';
                                        $sender_contact = isset($row_sender["tel"]) ? htmlspecialchars($row_sender["tel"]) : '';
                                        $sender_address = isset($row_sender["address"]) ? htmlspecialchars($row_sender["address"]) : '';
                                        $sender_rd = isset($row_sender["rd"]) ? htmlspecialchars($row_sender["rd"]) : '';
                                    }
                                }
                            }
  
                            //RECIEVER
                            $reciever_name = "";
                            $reciever_surname = "";
                            $reciever_address = "";
                            $reciever_rd = "";
                            $reciever_contact = "";
                            if ($receiver > 0)
                            {
                                $receiver_escaped = mysqli_real_escape_string($conn, $receiver);
                                $query_reciever = mysqli_query($conn,"SELECT * FROM customer WHERE customer_id='$receiver_escaped' LIMIT 1");
                                if ($query_reciever && mysqli_num_rows($query_reciever) > 0) {
                                    while ($row_reciever = mysqli_fetch_array($query_reciever))
                                    {
                                        if (!$row_reciever) continue;
                                        $reciever_name = isset($row_reciever["name"]) ? htmlspecialchars($row_reciever["name"]) : '';
                                        $reciever_surname = isset($row_reciever["surname"]) ? htmlspecialchars($row_reciever["surname"]) : '';
                                        $reciever_address = isset($row_reciever["address"]) ? htmlspecialchars($row_reciever["address"]) : '';
                                        $reciever_rd = isset($row_reciever["rd"]) ? htmlspecialchars($row_reciever["rd"]) : '';
                                        $reciever_contact = isset($row_reciever["tel"]) ? htmlspecialchars($row_reciever["tel"]) : '';
                                    }
                                }
                            }
  
                            //DELIVER
                            $deliver_name = "";
                            $deliver_contact = "";
                            $deliver_rd = "";
                            if ($deliver > 0)
                            {
                                $deliver_escaped = mysqli_real_escape_string($conn, $deliver);
                                $sql_deliver = "SELECT * FROM customer WHERE customer_id='$deliver_escaped' LIMIT 1";
                                $query_deliver = mysqli_query($conn,$sql_deliver);
                                if ($query_deliver && mysqli_num_rows($query_deliver) > 0)
                                {
                                    while ($row_deliver = mysqli_fetch_array($query_deliver))
                                    {
                                        if (!$row_deliver) continue;
                                        $deliver_name = isset($row_deliver["name"]) ? htmlspecialchars($row_deliver["name"]) : '';
                                        $deliver_contact = isset($row_deliver["tel"]) ? htmlspecialchars($row_deliver["tel"]) : '';
                                        $deliver_rd = isset($row_deliver["rd"]) ? htmlspecialchars($row_deliver["rd"]) : '';
                                    }
                                }
                            }
  
                            $package_array=explode("##",$package);
                            @$package1_name = $package_array[0];
                            @$package1_num = $package_array[1];
                            @$package1_value = $package_array[2];
                            @$package2_name = $package_array[3];
                            @$package2_num = $package_array[4];
                            @$package2_value = $package_array[5];
                            @$package3_name = $package_array[6];
                            @$package3_num = $package_array[7];
                            @$package3_value = $package_array[8];
                            @$package4_name = $package_array[9];
                            @$package4_num = $package_array[10];
                            @$package4_value = $package_array[11];
  
  
  
                            $package_array = explode("##",$package);
                            $package1_name = isset($package_array[0]) ? htmlspecialchars($package_array[0]) : '';
                            $package1_num = isset($package_array[1]) ? htmlspecialchars($package_array[1]) : '';
                            $package1_value = isset($package_array[2]) ? htmlspecialchars($package_array[2]) : '';
                            $package2_name = isset($package_array[3]) ? htmlspecialchars($package_array[3]) : '';
                            $package2_num = isset($package_array[4]) ? htmlspecialchars($package_array[4]) : '';
                            $package2_value = isset($package_array[5]) ? htmlspecialchars($package_array[5]) : '';
                            $package3_name = isset($package_array[6]) ? htmlspecialchars($package_array[6]) : '';
                            $package3_num = isset($package_array[7]) ? htmlspecialchars($package_array[7]) : '';
                            $package3_value = isset($package_array[8]) ? htmlspecialchars($package_array[8]) : '';
                            $package4_name = isset($package_array[9]) ? htmlspecialchars($package_array[9]) : '';
                            $package4_num = isset($package_array[10]) ? htmlspecialchars($package_array[10]) : '';
                            $package4_value = isset($package_array[11]) ? htmlspecialchars($package_array[11]) : '';

                            echo "<table class='table table-hover'>";
                            echo "<tr><td>Илгээмжийн огноо</td><td>".$created_date."</td></tr>";
                            echo "<tr><th colspan='2'><h4>Хүлээн авагч</h4></th></tr>";
                            echo "<tr><td>Нэр</td><td>".$reciever_name."</td></tr>" ;
                            echo "<tr><td>Овог</td><td>".$reciever_surname."</td></tr>" ;
                            echo "<tr><td>РД</td><td>".$reciever_rd."</td></tr>" ;
                            echo "<tr><td>Утас</td><td>".$reciever_contact."</td></tr>" ;
                            echo "<tr><td>Хаяг</td><td>".$reciever_address."</td></tr>" ;
                            if ($deliver!=0)
                            {
                            echo "<tr><th colspan='2'><h4>Гардан авсан</h4></th></tr>";
                            echo "<tr><td>Нэр</td><td>".$deliver_name."</td></tr>" ;
                            echo "<tr><td>Утас</td><td>".$deliver_contact."</td></tr>" ;
                            echo "<tr><td>РД:</td><td>".$deliver_rd."</td></tr>" ;
                            }
  
                            echo "<tr><td>Barcode</td><td>".$barcode."</td></tr>" ;
                            if ($package1_name!="")
                            echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>".$package1_name." (".$package1_num.") ".$package1_value."$</td></tr>";
                            if ($package2_name!="")
                            echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>".$package2_name." (".$package2_num.") ".$package2_value."$</td></tr>";
                            if ($package3_name!="")
                            echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>".$package3_name." (".$package3_num.") ".$package3_value."$</td></tr>";
                            if ($package4_name!="")
                            echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>".$package4_name." (".$package4_num.") ".$package4_value."$</td></tr>";
                            echo "<tr><td>Жин</td><td>".$weight."(".cfg_price($weight).")</td></tr>" ;	
                            echo "<tr><td>Үлдэгдэлийн хэмжээ</td><td>".$Package_advance_value."$</td></tr>" ;		

                            echo "<tr><td>Бусад track№</td><td>".$track."</td></tr>" ;

                            echo "<tr><td>Статус</td><td>".$status."(".$timestamp.")</td></tr>";
                            if($status=="warehouse") echo "<tr><td>Тавиур</td><td>".$extra."-р тавиур</td></tr>";
                            echo "</table>";
                        }
                  }
                    else echo "Трак олдсонгүй<br>";
                }
                else echo "Трак өгөөгүй<br>";
  
                            /*echo form_open('agents/changing');
                            echo form_hidden('order_id',$order_id);
                            $options = array(
                                  //''  => 'Шинэ төлөвийн сонго',
                                          //'delivered'  => 'Хүргэж өгөх',
                                          'onair'    => 'Онгоцоор ирж байгаа',
                                          // 'warehouse'   => 'Агуулахад орсон',
                                          //'custom' => 'Гааль',
                                  // 'delete' => 'Barcode устгах',
                                        );
  
  
                            echo form_dropdown('options', $options, '',array("class"=>"form-control"));
                            echo "<div id='more'></div>";
                            echo form_submit("submit","өөрчил",array("class"=>"btn btn-success"));
                            echo form_close();
                            */

              ?>

              </div>
              </div>
              <?php

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
      $('#tracks_table').DataTable({
        pageLength: 100,
        lengthMenu: [100, 250, 500, { label: 'Бүгд', value: -1 }],
        layout: {
           topStart: {
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print','pageLength'],                
            }         
        }
    });
  </script>

	<!-- endinject -->

</body>
</html>    