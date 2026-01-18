<?php
    require_once("config.php");
    require_once("views/helper.php");
    require_once("views/login_check.php");
    require_once("views/init.php");
    
    // Initialize variables
    $action_title = "Ачаа";
    $search = isset($_GET["search"]) ? protect($_GET["search"]) : "";
    $search_status = isset($_GET["status"]) ? protect($_GET["status"]) : "all";
    $status_type = isset($_GET["status_type"]) ? protect($_GET["status_type"]) : "all";
    $search_date = isset($_GET["search_date"]) ? protect($_GET["search_date"]) : "created";
    $Stotal = 0;
?>

<link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<body class="sidebar-dark">
	<div class="main-wrapper">
    <?php require_once("views/navbar.php"); ?>
	
		<div class="page-wrapper">
      <?php require_once("views/sidebar.php"); ?>
			

			<div class="page-content">

        <!------------------------------------------------------------------------------------->
        
          <!--label class="section-title">Basic Responsive DataTable</label>
          <p class="mg-b-20 mg-sm-b-40">Searching, ordering and paging goodness will be immediately added to the table, as shown in this example.</p-->
          <?php
          if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="dashboard";
          ?>
          <?php
          switch ($action)
          {
            case "display": $action_title="Бүх Ачаа";break;
            case "new": $action_title="Шинэ Ачаа";break;
            case "active": $action_title="Идэвхитэй Ачаа";break;
            case "warehouse": $action_title="Агуулахад ачаатай Ачаа";break;
            case "incoming": $action_title="Ирж буй ачаатай Ачаа";break;
            case "category": $action_title="Ачааны ангилал";break;          
            case "category_new": $action_title="Ангилал нэмэх";break;          
            case "category_adding": $action_title="Ангилал нэмэх";break;          
            case "category_edit": $action_title="Ангилал засах";break;          
            case "category_editing": $action_title="Ангилал засах";break;          
            case "category_delete": $action_title="Ангилал устгах";break;          
            case "categorize": $action_title="Ангилсан Ачаа";break;
            case "register": $action_title="Ачаа бүртгэх";break;
            case "registering": $action_title="Ачаа бүртгэх";break;
            case "detail": $action_title="Ачааны дэлгэрэнгүй";break;
            case "edit": $action_title="Ачааны мэдээлэл засах";break;
            case "editing": $action_title="Ачааны мэдээлэл засах";break;
            case "delete": $action_title="Ачааны мэдээлэл устгах";break;
            case "dashboard": $action_title="Удирдлага";break;
            case "search": $action_title="Ачаа хайх";break;
            case "proxy_clear": $action_title="Proxy чөлөөлөх";break;
            case "error": $action_title="Мэдээлэл алдаатай";break;
            default: $action_title="Ачаа";break;
          }
          ?>
          <nav class="page-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="orders">Ачаа</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?php echo $action_title;?></li>
            </ol>
          </nav>

          <?php
          if ($action =="dashboard")
          {
            $sql = "SELECT * FROM orders";
            $result = mysqli_query($conn,$sql);
            $total = mysqli_num_rows($result);
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
            </div> 
            

            <?php
            if (isset($_POST["search"])) {$search =$_POST["search"]; $search_term=str_replace(" ","%",$_POST["search"]);} else { $search=""; $search_term="";}
            if (isset($_POST["status"])) $search_status =$_POST["status"]; else $search_status="all";
            if (isset($_POST["status_type"])) $status_type =$_POST["status_type"]; else $status_type="all";
            if (isset($_POST["search_date"])) $search_date =$_POST["search_date"]; else $search_date="created";
            if (isset($_POST["start_date"])) $start_date =$_POST["start_date"]; 
            else $start_date= date('Y-m-d', strtotime(date('Y-m-d') . ' -1 month'));
            if (isset($_POST["finish_date"])) $finish_date =$_POST["finish_date"]; else $finish_date=date("Y-m-d");

  


            
            $sql="SELECT orders.*, receiver_customer.name AS r_name,receiver_customer.surname AS r_surname,receiver_customer.tel AS r_tel,receiver_customer.address AS r_address,sender_customer.name AS s_name,sender_customer.surname AS s_surname,sender_customer.tel AS s_tel,sender_customer.address AS s_address FROM orders LEFT JOIN customer AS receiver_customer ON orders.receiver=receiver_customer.customer_id 
            LEFT JOIN customer AS sender_customer ON orders.sender=sender_customer.customer_id";
            $sql.=" WHERE CONCAT_WS(receiver_customer.name,receiver_customer.tel,sender_customer.name,orders.barcode,orders.third_party) LIKE '%".$search_term."%'";
  
            if ($search_status=="all") 
            $sql.=" AND orders.status NOT IN('completed','delivered','warehouse','custom')";
            if ($search_status=='db')
            $sql.=" AND orders.status IN ('completed','delivered','warehouse','custom','onair','new','order','weight_missing','item_missing','filled')";
  
            if ($search_status!="all" && $search_status!='db' && $search_status!='transport')
            $sql.=" AND orders.status ='$search_status'";
  
            if ($status_type=="advance")
            $sql.=" AND orders.advance=1";
  
            if ($search_status=="transport")
            $sql.=" AND orders.transport=1";
  
            $sql.=" AND is_online='0'";
  
            $date_column = "created_date"; // default
            switch($search_date)
            {
              case "created": $date_column = "created_date";break;
              case "onair": $date_column = "onair_date";break;
              case "warehouse": $date_column = "warehouse_date";break;
              case "delivered": $date_column = "delivered_date";break;
              
            }
            if ($start_date!="")  $sql.=" AND ".$date_column.">'".$start_date."'";
            if ($finish_date!="")  $sql.=" AND ".$date_column."<'".$finish_date."'";
  
  
  
            $sql.=" ORDER BY order_id DESC";

            $result = mysqli_query($conn,$sql);
            $count=1;$total_weight=0;$total_price=0;
            ?>


            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-body">
                    <form action="?action=search" method="post">
                      <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Хайх..." value="<?php echo $search;?>">
          

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
                        <table id="orders_table" class="table">
                          <thead>
                            <tr>
                              <th>№</th>
                              <th>Үүсгэсэн огноо</th>
                              <th>Утас</th>
                              <th>Х/авагч утас</th>
                              <th>Barcode</th>
                              <th>Хоног</th>
                              <th>Төлөв</th>
                              <th>Жин</th>
                              <th>Үлдэгдэл</th>
                              <th>Үйлдэл</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            while ($data = mysqli_fetch_array($result))
                            {  
                              $created_date=$data["created_date"];
                              $order_id=$data["order_id"];
                              $weight=$data["weight"];
                              //$price=$data["price"];
                              //$description=$data["description"];
                              //$sender_id=$data["s_name"];
                                $sender=$data["s_name"];
                              $sender_surname=$data["s_surname"];
                              $sender_contact=$data["s_tel"];
                              $sender_address=$data["s_address"];
                              $sender_id=$data["sender"];
                                $receiver=$data["r_name"];
                              $receiver_id=$data["receiver"];
                              $receiver_surname=$data["r_surname"];
                              $receiver_contact=$data["r_tel"];
                              $receiver_address=$data["r_address"];
                              $barcode=$data["barcode"];
                              $package=$data["package"];
                              $description=$data["package"];
                              $Package_advance = $data["advance"];
                              $Package_advance_value = $data["advance_value"];
                              $extra=$data["extra"];
                              $third_party=$data["third_party"];
                              $status=$data["status"];
                              $total_weight+=floatval($weight);
                              $total_price+=floatval($Package_advance_value);
                              $transport = $data["transport"];
                              $tr=0;
                              $days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;		
                              
                              if ($receiver_id!="" &&$status=='order'&&!$tr)
                              {echo "<tr class='blue' title='Хүлээн авагч тодорхойгүй'>"; $tr=1;}
                              
                              if ($receiver_id!=1&&$status=='filled'&&!$tr)
                              {echo "<tr class='green' title='Хүлээн авагч бөглөсөн'>"; $tr=1;}
                              
                              
                                if ($Package_advance==1&&!$tr)
                              {echo "<tr class='red' title='Үлдэгдэл:".$Package_advance_value."$'>"; $tr=1;}
                              
                              if ($status=='weight_missing'&&!$tr)
                              {echo "<tr class='yellow' title='Жин бөглөгдөөгүй байна:'>"; $tr=1;}

                              
                              if($status=="warehouse"&&$extra!="") $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status; 
                              if (!$tr) echo "<tr>";else $tr=0;
                              // echo "<td>".form_checkbox("orders[]",$order_id)."</td>"; 
                              echo "<td>".$count++."</td>"; 
                              echo "<td>".$created_date;
                                if ($transport) echo "<br><span class='glyphicon glyphicon-home' title='Улаанбаатарт хүргэлттэй'></span> Хүргэлттэй"; 

                              echo "</td>";                                  
                                  echo "<td>";
                                  echo "<a href='customers?action=detail&id=".$sender_id."'>".substr($sender_surname,0,2).".".$sender."</a>";
                                  echo "-><br>";
                                  echo "<a href='customers?action=detail&id=".$receiver_id."'>".substr($receiver_surname,0,2).".".$receiver."</a>";
                                  echo "</td>";
                                  echo "<td>";
                                  echo $sender_contact."-><br>".$receiver_contact;
                                  echo "</td>"; 
                                  echo "<td>".barcode_comfort($barcode)."</td>"; 
                                  //echo "<td>".$third_party."</td>"; 
                                  echo "<td>".$days."</td>"; 
                                  echo "<td>".$temp_status."</td>";
                                  echo "<td>".$weight."</td>"; 
                                  // echo "<td>".$weight*cfg_paymentrate()."</td>"; 
                                  echo "<td>".$Package_advance_value."</td>"; 
                                  echo "<td><a href='orders?action=detail&id=".$order_id."'><i data-feather='edit'></i></td>"; 
                              echo "</tr>";
                            } 
                            ?>
                          
                          </tbody>
                          <tfoot>
                            <tr><td colspan='7'>Нийт</td><td><?php echo $total_weight;?></td><td><?php echo $total_weight*cfg_paymentrate();?>$<br><b><?php echo $total_price;?>$</b></td><td></td></tr>
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
            if (isset($_POST["search"])) {$search =$_POST["search"]; $search_term=str_replace(" ","%",$_POST["search"]);} else { $search=""; $search_term="";}
            if (isset($_POST["status"])) $search_status =$_POST["status"]; else $search_status="all";
            if (isset($_POST["status_type"])) $status_type =$_POST["status_type"]; else $status_type="all";
            if (isset($_POST["search_date"])) $search_date =$_POST["search_date"]; else $search_date="created";
            if (isset($_POST["start_date"])) $start_date =$_POST["start_date"]; 
            else $start_date= date('Y-m-d', strtotime(date('Y-m-d') . ' -1 month'));
            if (isset($_POST["finish_date"])) $finish_date =$_POST["finish_date"]; else $finish_date=date("Y-m-d");

  


            
            $sql="SELECT orders.*, receiver_customer.name AS r_name,receiver_customer.surname AS r_surname,receiver_customer.tel AS r_tel,receiver_customer.address AS r_address,sender_customer.name AS s_name,sender_customer.surname AS s_surname,sender_customer.tel AS s_tel,sender_customer.address AS s_address FROM orders LEFT JOIN customer AS receiver_customer ON orders.receiver=receiver_customer.customer_id 
            LEFT JOIN customer AS sender_customer ON orders.sender=sender_customer.customer_id";
            $sql.=" WHERE CONCAT_WS(receiver_customer.name,receiver_customer.tel,sender_customer.name,orders.barcode,orders.third_party) LIKE '%".$search_term."%'";
  
            if ($search_status=="all") 
            $sql.=" AND orders.status NOT IN('completed','delivered','warehouse','custom')";
            if ($search_status=='db')
            $sql.=" AND orders.status IN ('completed','delivered','warehouse','custom','onair','new','order','weight_missing','item_missing','filled')";
  
            if ($search_status!="all" && $search_status!='db' && $search_status!='transport')
            $sql.=" AND orders.status ='$search_status'";
  
            if ($status_type=="advance")
            $sql.=" AND orders.advance=1";
  
            if ($search_status=="transport")
            $sql.=" AND orders.transport=1";
  
            $sql.=" AND is_online='0'";
  
            $date_column = "created_date"; // default
            switch($search_date)
            {
              case "created": $date_column = "created_date";break;
              case "onair": $date_column = "onair_date";break;
              case "warehouse": $date_column = "warehouse_date";break;
              case "delivered": $date_column = "delivered_date";break;
              
            }
            if ($start_date!="")  $sql.=" AND ".$date_column.">'".$start_date."'";
            if ($finish_date!="")  $sql.=" AND ".$date_column."<'".$finish_date."'";
  
  
  
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
                        <input type="text" class="form-control" name="search" placeholder="Хайх..." value="<?php echo $search;?>">
          

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
                        <table id="orders_table" class="table">
                          <thead>
                            <tr>
                              <th>№</th>
                              <th>Үүсгэсэн огноо</th>
                              <th>Утас</th>
                              <th>Х/авагч утас</th>
                              <th>Barcode</th>
                              <th>Хоног</th>
                              <th>Төлөв</th>
                              <th>Жин</th>
                              <th>Үлдэгдэл</th>
                              <th>Үйлдэл</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            while ($data = mysqli_fetch_array($result))
                            {  
                              $created_date=$data["created_date"];
                              $order_id=$data["order_id"];
                              $weight=$data["weight"];
                              //$price=$data["price"];
                              //$description=$data["description"];
                              //$sender_id=$data["s_name"];
                                $sender=$data["s_name"];
                              $sender_surname=$data["s_surname"];
                              $sender_contact=$data["s_tel"];
                              $sender_address=$data["s_address"];
                              $sender_id=$data["sender"];
                                $receiver=$data["r_name"];
                              $receiver_id=$data["receiver"];
                              $receiver_surname=$data["r_surname"];
                              $receiver_contact=$data["r_tel"];
                              $receiver_address=$data["r_address"];
                              $barcode=$data["barcode"];
                              $package=$data["package"];
                              $description=$data["package"];
                              $Package_advance = $data["advance"];
                              $Package_advance_value = $data["advance_value"];
                              $extra=$data["extra"];
                              $third_party=$data["third_party"];
                              $status=$data["status"];
                              $total_weight+=$weight;
                              $total_price+=floatval($Package_advance_value);
                              $transport = $data["transport"];
                              $tr=0;
                              $days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;		
                              
                              if ($receiver_id!="" &&$status=='order'&&!$tr)
                              {echo "<tr class='blue' title='Хүлээн авагч тодорхойгүй'>"; $tr=1;}
                              
                              if ($receiver_id!=1&&$status=='filled'&&!$tr)
                              {echo "<tr class='green' title='Хүлээн авагч бөглөсөн'>"; $tr=1;}
                              
                              
                                if ($Package_advance==1&&!$tr)
                              {echo "<tr class='red' title='Үлдэгдэл:".$Package_advance_value."$'>"; $tr=1;}
                              
                              if ($status=='weight_missing'&&!$tr)
                              {echo "<tr class='yellow' title='Жин бөглөгдөөгүй байна:'>"; $tr=1;}

                              
                              if($status=="warehouse"&&$extra!="") $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status; 
                              if (!$tr) echo "<tr>";else $tr=0;
                              // echo "<td>".form_checkbox("orders[]",$order_id)."</td>"; 
                              echo "<td>".$count++."</td>"; 
                              echo "<td>".$created_date;
                                if ($transport) echo "<br><span class='glyphicon glyphicon-home' title='Улаанбаатарт хүргэлттэй'></span> Хүргэлттэй"; 

                              echo "</td>";                                  
                                  echo "<td>";
                                  echo "<a href='customers?action=detail&id=".$sender_id."'>".substr($sender_surname,0,2).".".$sender."</a>";
                                  echo "-><br>";
                                  echo "<a href='customers?action=detail&id=".$receiver_id."'>".substr($receiver_surname,0,2).".".$receiver."</a>";
                                  echo "</td>";
                                  echo "<td>";
                                  echo $sender_contact."-><br>".$receiver_contact;
                                  echo "</td>"; 
                                  echo "<td>".barcode_comfort($barcode)."</td>"; 
                                  //echo "<td>".$third_party."</td>"; 
                                  echo "<td>".$days."</td>"; 
                                  echo "<td>".$temp_status."</td>";
                                  echo "<td>".$weight."</td>"; 
                                  // echo "<td>".$weight*cfg_paymentrate()."</td>"; 
                                  echo "<td>".$Package_advance_value."</td>"; 
                                  echo "<td><a href='orders?action=detail&id=".$order_id."'><i data-feather='edit'></i></td>"; 
                              echo "</tr>";
                            } 
                            ?>
                          
                          </tbody>
                          <tfoot>
                            <tr><td colspan='7'>Нийт</td><td><?php echo $total_weight;?></td><td><?php echo $total_weight*cfg_paymentrate();?>$<br><b><?php echo $total_price;?>$</b></td><td></td></tr>
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
          if ($action=="detail")
          {
            
              if (isset($_GET["id"])) $order_id = intval($_GET["id"]); else $order_id=0;

              $sql = "SELECT * FROM orders WHERE order_id=".$order_id." AND is_online='0'";
              $result = mysqli_query($conn,$sql);              
              if (mysqli_num_rows($result) == 1)
              {
                $data = mysqli_fetch_array($result);
                  $created_date=$data["created_date"];
                  $order_id=$data["order_id"];
                  $sender=$data["sender"];
                  $receiver=$data["receiver"];
                  $deliver=$data["deliver"];
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
                  $status=$data["status"];
                  $timestamp=$data["timestamp"];
                  $extra=$data["extra"];
                
                  //SENDER 
                  if ($sender!="")
                  {
                    $sql_sender = "SELECT * FROM customer WHERE customer_id='$sender' LIMIT 1";
                    $result_sender = mysqli_query($conn,$sql_sender);
                    if (mysqli_num_rows($result_sender)==1)
                    {
                      $data_sender = mysqli_fetch_array($result_sender);
  
                      $sender_name=$data_sender["name"];
                      $sender_surname=$data_sender["surname"];
                      $sender_address=$data_sender["address"];
                      $sender_rd=$data_sender["rd"];
                      $sender_contact=$data_sender["tel"];
                    }
                    else {$sender_name=""; $sender_contact="";}
                  }
                  else {$sender_name=""; $sender_contact="";}

                  //receiver
                  if ($receiver!="")
                  {
                    $sql_receiver = "SELECT * FROM customer WHERE customer_id='$receiver' LIMIT 1";
                    $result_receiver = mysqli_query($conn,$sql_receiver);
                    if (mysqli_num_rows($result_receiver)==1)
                    {
                      $data_receiver = mysqli_fetch_array($result_receiver);
  
                      $receiver_name=$data_receiver["name"];
                      $receiver_surname=$data_receiver["surname"];
                      $receiver_address=$data_receiver["address"];
                      $receiver_rd=$data_receiver["rd"];
                      $receiver_contact=$data_receiver["tel"];
                    }
                    else {$receiver_name=""; $receiver_contact="";}
                  }
                  else {$receiver_name=""; $receiver_contact="";}

                  
                  //DELIVER
                  if ($deliver!="")
                  {
                    $sql_deliver = "SELECT * FROM customer WHERE customer_id='$deliver' LIMIT 1";
                    $result_deliver = mysqli_query($conn,$sql_deliver);
                    if (mysqli_num_rows($result_deliver)==1)
                    {
                      $data_deliver = mysqli_fetch_array($result_deliver);
  
                      $deliver_name=$data_deliver["name"];
                      $deliver_surname=$data_deliver["surname"];
                      $deliver_address=$data_deliver["address"];
                      $deliver_rd=$data_deliver["rd"];
                      $deliver_contact=$data_deliver["tel"];
                    }
                    else {$deliver_name=""; $deliver_contact="";}
                  }
                  else {$deliver_name=""; $deliver_contact="";}


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
                  echo "<tr><th colspan='2'><h4>Хүлээн авагч</h4></th></tr>";
                  echo "<tr><td>Нэр</td><td>".$receiver_name."</td></tr>" ;
                  echo "<tr><td>Овог</td><td>".$receiver_surname."</td></tr>" ;
                  echo "<tr><td>РД</td><td>".$receiver_rd."</td></tr>" ;
                  echo "<tr><td>Утас</td><td>".$receiver_contact."</td></tr>" ;
                  echo "<tr><td>Хаяг</td><td>".$receiver_address."</td></tr>" ;
                  if ($deliver!=0)
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
                  /*if ($insurance)
                  {
                  echo "<tr><td>Даатгал</td><td>Даатгалтай</td></tr>" ;
                  echo "<tr><td>Даатгалын хэмжээ</td><td>".$insurance_value."</td></tr>" ;		
                  }
                  else echo "<tr><td>Даатгал</td><td>Даатгалгүй</td></tr>" ;*/
                  if ($Package_advance)
                  {
                  //echo "<tr><td>Үлдэгдэл</td><td>Үлдэгдэлтэй</td></tr>" ;
                  echo "<tr><td>Үлдэгдэлийн хэмжээ</td><td>".$Package_advance_value."$</td></tr>" ;		
                  }
                  else echo "<tr><td>Үлдэгдэл</td><td>Үлдэгдэлгүй</td></tr>" ;
                  /*if ($third_party)
                  {
                  echo "<tr><td>Бусад track№</td><td>$third_party</td></tr>" ;
                  }*/
                  /*echo "<tr><td>Явах чиглэл</td><td>$way</td></tr>" ;
                  echo "<tr><td>Илгээмж дотор</td><td>$inside</td></tr>" ;
                  echo "<tr><td>Хүргэгдэх үед</td><td>$deliver_time</td></tr>" ;
                  switch($return_type)
                  {
                  case "return_1":echo "<tr><td>Хүргэгдээгүй тохиолдолд</td><td>Явуулагч талруу яаралтай буцаах</td></tr>" ;break;
                  case "return_2":echo "<tr><td>Хүргэгдээгүй тохиолдолд</td><td>Явуулагч талруу $return_day өдрийн дараа буцаах</td></tr>" ;break;
                  case "return_3":echo "<tr><td>Хүргэгдээгүй тохиолдолд</td><td>Өөр хаягруу буцаах:$return_address;</td></tr>" ;break;
                  case "return_4":echo "<tr><td>Хүргэгдээгүй тохиолдолд</td><td>Тэнд нь устгах</td></tr>" ;break;
                  }
                  echo "<tr><td>Буцах зам</td><td>$return_way</td></tr>" ;*/
                  echo "<tr><td>Статус</td><td>".$status."(".$timestamp.")</td></tr>";
                  if($status=="warehouse") echo "<tr><td>Тавиур</td><td>".$extra."-р тавиур</td></tr>";
                  echo "</table>";
                  
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
                <div class="btn-group mt-3">
                  <a href="?action=edit&id=<?php echo $order_id;?>" class="btn btn-success">Засах</a>
                  <a href="?action=delete&id=<?php echo $order_id;?>" class="btn btn-danger">Устгах</a>
                </div>
                <?php
                }
                else echo "Илгээмж олдсонгүй<br>";


          }
          ?>

          <?php
          if ($action=="delete")
          {
            
              if (isset($_GET["id"])) $order_id = intval($_GET["id"]); else $order_id=0;

              $sql = "SELECT * FROM orders WHERE order_id=".$order_id." AND is_online='0'";
              $result = mysqli_query($conn,$sql);              
              if (mysqli_num_rows($result) == 1)
              {
                $data = mysqli_fetch_array($result);
                  $created_date=$data["created_date"];
                  $order_id=$data["order_id"];
                  $sender=$data["sender"];
                  $receiver=$data["receiver"];
                  $deliver=$data["deliver"];
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
                  $status=$data["status"];
                  $timestamp=$data["timestamp"];
                  $extra=$data["extra"];
                  if ($status == "weight_missing") // ONLY WEIGHT MISSING BOL USTGAH BOLOMJTOI
                  {                    
                    if (mysqli_query($conn,"DELETE FROM orders WHERE order_id='$order_id'"))
                    {
                      ?>
                      <div class="alert alert-success">Захиалгыг амжилттай устгалаа.</div>
                      <?php
                      
                    } 
                    else 
                    {
                      ?>
                      <div class="alert alert-danger">Алдаа:<?php echo mysqli_error($conn);?></div>
                      <?php
                    }                    
                  }
                  else 
                  {
                    ?>
                    <div class="alert alert-danger">Алдаа: зөвхөн weight_missing төлөвтэй ачааг устгах боломжтой</div>
                    <?php
                  }
                }
                else 
                {
                  ?>
                  <div class="alert alert-danger">Алдаа: Илгээмж олдсонгүй</div>
                  <?php
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
      $('#orders_table').DataTable({
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