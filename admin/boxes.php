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
            case "display": $action_title="Бүх box";break;
            case "new": $action_title="Шинэ box";break;
            case "active": $action_title="Идэвхитэй box";break;
            case "changing": $action_title="Төлөв өөрчлөх";break;
            case "incoming": $action_title="Ирж буй ачаатай Ачаа";break;         
            case "dashboard": $action_title="Удирдлага";break;
            case "search": $action_title="Box-s хайх";break;
            case "searching": $action_title="Box-s хайх";break;
            case "combine": $action_title="Нэгтгэсэн ачаа";break;
            case "error": $action_title="Мэдээлэл алдаатай";break;
            case "history": $action_title="Түүх";break;
            case "reverse_history": $action_title="Түүхээс буцааж нисэж буй төлөврүү";break;
            case "detail": $action_title="Дэлгэрэнгүй";break;
            case "combine_display": $action_title="Нэгтгэсэн ачаа дэлгэрэнгүй";break;
            case "combine_delete": $action_title="Нэгтгэсэн ачаа устгах";break;
            case "badge": $action_title="Box гадуур дагавар";break;
            case "excel": $action_title="Excel файл шинэчлэх";break;

            
          }
          ?>
          <div class="d-flex justify-content-between">
            <nav class="page-breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="boxes">Boxes удирдлага</a></li>
                <li class="breadcrumb-item"><a href="?action=active">Идэвхитэй box</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?=$action_title;?></li>
              </ol>
            </nav>

            <a href="files/box_excel.xlsx" class="btn btn-warning mb-3">Excel татах</a>
          </div>


          <?
          if ($action =="dashboard")
          {
            $sql = "SELECT *FROM boxes";
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
                          <h6 class="card-title mb-0">Boxes</h6>
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
                            <h3 class="mb-2"><?=number_format($total);?></h3>
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
                <div class="card">
                    <div class="card-body">
                        <form action="?action=searching" method="post">
                          <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Tel, Name, Barcode" value="">                  
                            <button type="submit" class="btn btn-primary mr-2">Хайх</button>
                          </div>
                        </form>
                    </div>
                </div>
              </div>
            </div>
            <?
          }
          ?>

          <?
          if ($action=="active")
          {
            $sql="SELECT * FROM boxes WHERE status NOT IN ('warehouse','delivered') ORDER BY created_date DESC";
  
            $cumulative_weight=0;
            $cumulative_packages = 0;
          
            $result = mysqli_query($conn,$sql);
            if (mysqli_num_rows($result) > 0)
            {
              ?>
              <form action="?action=changing" method="post">
              

                <table class='table table-hover' id="boxes_table">
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
                            <td><a href="?action=detail&id=<?=$box_id;?>"><?=$name;?></td>
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

                  <select name="options" class="form-control">
                      <option value="onair">Онгоцоор нисгэх</option>
                      <option value="warehouse">Агуулахад оруулах</option>
                      <option value="delete">Хайрцагын устгах</option>
                      <option value="new">Шинэхийн өмнөх төлөвт</option>
                  </select>
                  
                  <button class="btn btn-success" type="submit">өөрчил</button>

              </form>
              <?
            }
            else echo '<div class="alert alert-danger" role="alert">No boxes</div>';
          }
          ?>

          <?
          if ($action =="search")
          {
            ?>         
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="?action=searching" method="post">
                          <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Tel, Name, Barcode" value="" required>                  
                            <button type="submit" class="btn btn-primary mr-2">Хайх</button>
                          </div>
                        </form>
                    </div>
                </div>
              </div>
            </div>
            <?
          }
          ?>

          <?
          if ($action == "searching")
          {
                ?>
                <div class="card">
                    <div class="card-body">
                        <?
                            if (isset($_POST["search"])) $search_term= $_POST["search"]; else  $search_term="";

                            if ($search_term!="") echo "Хайх:".$search_term."<br>";

                            $sql = "SELECT boxes.*,boxes.name AS box_name,boxes.created_date AS box_created FROM boxes_packages LEFT JOIN boxes ON boxes_packages.box_id=boxes.box_id LEFT JOIN customer ON boxes_packages.receiver=customer.customer_id ";
                            $sql.=" WHERE CONCAT_WS(customer.name,customer.tel,boxes_packages.barcode,boxes_packages.barcodes) LIKE '%".$search_term."%' GROUP BY boxes.box_id";
                            $result = mysqli_query($conn,$sql);
                            if (mysqli_num_rows($result) > 0)
                            {
                                ?>
                                <form action="?action=changing" method="POST">
                                    <table class='table table-hover'>
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" name="select_all" title="Select all orders"></th>
                                                <th>№</th>
                                                <th>Нэр</th>
                                                <th>Тоо</th> 
                                                <th>Огноо</th> 
                                                <th>Төлөв</th> 
                                                <th>Kg</th>
                                                <th>Үйлдэл</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?
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
                                                ?>

                                            
                                            
                                                <tr>
                                                    <td><input type="checkbox" name="boxes[]" value=<?=$box_id;?>"></td> 
                                                    <td><?=$count++;?></td>
                                                    <td><?=$name;?></td> 
                                                    <td><?=$packages;?></td>
                                                    <td><?=$created_date;?></td>
                                                    <td><?=$status;?></td>
                                                    <td><?=$order_weight;?></td>                                                
                                                    <td><a href="?action=detail&box_id=<?=$box_id;?>">Edit</a></td>
                                                </tr>
                                                <?
                                                $cumulative_packages+=$packages;
                                                $cumulative_weight+=$order_weight;                                                            
                                            } 
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr><td></td><td colspan='2'>Нийт</td><td><?=$cumulative_packages;?></td><td></td><td></td><td><?=$cumulative_weight;?></td><td></td></tr>
                                        </tfoot>
                                    </table>
                                    <select name="options" class="form-control">
                                      <option value="onair">Онгоцоор нисгэх</option>
                                      <option value="warehouse">Агуулахад оруулах</option>
                                      <option value="delete">Хайрцагын устгах</option>
                                      <option value="new">Шинэхийн өмнөх төлөвт</option>
                                    </select>
                                    <div id="more"></div>
                                    <button type="submit" class="btn btn-success">өөрчил</button>                                       
                                </form>
                                <?
                            }
                            else echo "No boxes";
                        
                        ?>
                    </div>
                </div>
                <?
          }
          ?>

          <?
          if ($action == "changing")
          {
            ?>
                <div class="card">
                    <div class="card-body">
                        <? 
                        $options=$_POST["options"];

                        switch ($options)
                        {
                        case "onair":$new_status = "onair";break;
                        case "warehouse":$new_status = "warehouse";break;
                        case "delete": $new_status = "delete";break;
                        case "new": $new_status = "new";break;
                        }

                        if(isset($_POST['boxes'])) {$boxes=$_POST['boxes'];$N = count($boxes);}
                        if(isset($_POST['boxes_id'])) {$boxes_id=$_POST['boxes_id'];$N = 1;}
                        else {$N = count($boxes); $boxes_id="";}

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
                            if ($new_status=="onair")
                                {
                                    $count=1;		
                                    $result = mysqli_query($conn,"SELECT * FROM boxes WHERE box_id='$boxes_id' LIMIT 1");
                                        if (mysqli_num_rows($result)==1)
                                        {
                                        $data =  mysqli_fetch_array($result);
                                        $box_id= $data["box_id"]; 
                                        $name= $data["name"]; 
                                        $packages= box_inside($box_id,"packages");
                                        $created_date = $data["created_date"];
                                        $weight= box_inside($box_id,"weight");
                                        $status = $data["status"];
                                        $packages_result = mysqli_query($conn,"SELECT * FROM boxes_packages WHERE box_id='$box_id'");
                                        $inside_item =mysqli_num_rows($packages_result);
                                        if ($inside_item>0)
                                            {
                                            $inside_count =0;
                                            while ($package_data = mysqli_fetch_array($packages_result))
                                            {
                                              $barcode=$package_data["barcode"];
                                              $combined=$package_data["combined"];
                                              $order_id=$package_data["order_id"];
                                              $barcodes=$package_data["barcodes"];
                                              $order_id=$package_data["order_id"];
                                              if ($combined!=1) //SINGLE
                                                  {
                                                      $result_single= mysqli_query($conn,"SELECT * FROM orders WHERE barcode='$barcode'");
                                                      if (mysqli_num_rows($result_single)==1)
                                                          {
                                                          $data_single = mysqli_fetch_array($result_single);
                                                          $proxy_id = $data_single["proxy_id"];
                                                          $proxy_type = $data_single["proxy_type"];
                                                          if(!($data_single["status"]=="delivered" || $data_single["status"]=="warehouse" || $data_single["status"]=="custom")) 
                                                          {
                                                            mysqli_query($conn,"UPDATE orders SET status='onair',onair_date='".date("Y-m-d H:i:s")."' WHERE order_id=$order_id");
                                                            proxy_available($proxy_id,$proxy_type,0);
                                                          }
                                                      $inside_count++;
                                                          }
                                                  } //SINGLE ENDING
                                            if ($combined==1) //COMBINED
                                                {
                                                    foreach(explode(",",$barcodes) as $barcode_each)
                                                    {
                                                      $combine_result= mysqli_query($conn,"SELECT * FROM orders WHERE barcode='$barcode_each'");
                                                      if (mysqli_num_rows($combine_result)==1)
                                                          {
                                                            $data_combine = mysqli_fetch_array($combine_result);
                                                            $proxy_id = $data_single["proxy_id"];
                                                            $proxy_type = $data_single["proxy_type"];
                                                            proxy_available($proxy_id,$proxy_type,0);


                                                            if(!($data_single["status"]=="delivered" || $data_single["status"]=="warehouse" || $data_single["status"]=="custom")) 
                                                            mysqli_query($conn,"UPDATE orders SET status='onair',onair_date='".date("Y-m-d H:i:s")."' WHERE barcode='$barcode_each'");
                                                          }
                                                    }
                                                  mysqli_query($conn,"UPDATE box_combine SET status='onair',onair_date='".date("Y-m-d H:i:s")."' WHERE barcode='$barcode'");
                                                  $inside_count++;
                                                } //COMBINED ENDING
                                        
                                            }
                                            if ($inside_item==$inside_count)
                                                mysqli_query($conn,"UPDATE boxes SET status='onair' WHERE box_id='$boxes_id' LIMIT 1");
                                                echo "<tr>";
                                                echo "<td>".$count."</td>";
                                                echo "<td><a href='boxes?action=detail&id=".$data["box_id"]."'>".$name."</a></td>"; 
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

                            if ($new_status=="new")
                                {
                                    $count=1;		
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
                                        $packages_result = mysqli_query($conn,"SELECT * FROM boxes_packages WHERE box_id='$box_id'");
                                        if (mysqli_num_rows($packages_result)>0)
                                            {
                                            $inside_item = mysqli_num_rows($packages_result);
                                            $inside_count =0;
                                        
                                            while ($package_data = mysqli_fetch_array($packages_result))
                                            {
                                            $barcode=$package_data["barcode"];
                                            $combined=$package_data["combined"];
                                            $order_id=$package_data["order_id"];
                                            $barcodes=$package_data["barcodes"];
                                            $order_id=$package_data["order_id"];
                                            if ($combined!=1) //SINGLE
                                                {
                                                  $order_result= mysqli_query($conn,"SELECT * FROM orders WHERE barcode='$barcode'");
                                                  if (mysqli_num_rows($order_result)==1)
                                                      {
                                                        $data_single = mysqli_fetch_array($order_result);
                                                        $proxy_id = $data_single["proxy_id"];
                                                        $proxy_type = $data_single["proxy_type"];
                                                        proxy_available($proxy_id,$proxy_type,1);
                                                        if(!($data_single["status"]=="delivered")) 
                                                        mysqli_query($conn,"UPDATE orders SET status='new' WHERE order_id=$order_id");
                                                        $inside_count++;
                                                      }
                                                } //SINGLE ENDING
                                            if ($combined==1) //COMBINED
                                                {
                                                    foreach(explode(",",$barcodes) as $barcode_each)
                                                    {
                                                      $order_result= mysqli_query($conn,"SELECT * FROM orders WHERE barcode='$barcode_each'");
                                                      if (mysqli_num_rows($order_result)==1)
                                                          {
                                                            $data_single = mysqli_fetch_array($order_result);
                                                            $proxy_id = $data_single["proxy_id"];
                                                            $proxy_type = $data_single["proxy_type"];
                                                            proxy_available($proxy_id,$proxy_type,1);

                                                            if(!($data_single["status"]=="delivered")) 
                                                            mysqli_query($conn,"UPDATE orders SET status='onair',onair_date='".date("Y-m-d H:i:s")."' WHERE barcode='$barcode_each'");
                                                          }
                                                    }
                                                  mysqli_query($conn,"UPDATE box_combine SET status='new' WHERE barcode='$barcode'");
                                                  $inside_count++;
                                                } //COMBINED ENDING
                                        
                                            }
                                            if ($inside_item==$inside_count)
                                                mysqli_query($conn,"UPDATE boxes SET status='new' WHERE box_id='$boxes_id' LIMIT 1");
                                                echo "<tr>";
                                                echo "<td>".$count."</td>";
                                                echo "<td><a href='boxes?action=detail&id=".$data["box_id"]."'>".$name."</a></td>"; 
                                                echo "<td>".$packages."</td>"; 
                                                echo "<td>".substr($created_date,0,10)."</td>"; 
                                                echo "<td>";
                                                if ($inside_item==$inside_count) echo "new";
                                                echo "</td>"; 
                                                echo "<td>".$weight."</td>"; 
                                                echo "</tr>";
                                            }
                                        }
                                }

                            

                            if ($new_status=="warehouse")
                            {
                                $count=1;		
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
                                                $inside_item = mysqli_num_rows($result_packages)>0;
                                                $inside_count =0;
                                            
                                                while($data_inside = mysqli_fetch_array($result_packages))
                                                {
                                                    $barcode=$data_inside["barcode"];
                                                    $combined=$data_inside["combined"];
                                                    $order_id=$data_inside["order_id"];
                                                    $barcodes=$data_inside["barcodes"];
                                                    $order_id=$data_inside["order_id"];
                                                    if ($combined!=1) //SINGLE
                                                        {
                                                        $result_order= mysqli_query($conn,"SELECT * FROM orders WHERE barcode='$barcode'");
                                                        if (mysqli_num_rows($result_order)==1)
                                                            {
                                                            $data_order = mysqli_fetch_array($result_order);
                                                            $proxy_id = $data_order["proxy_id"];
                                                            $proxy_type = $data_order["proxy_type"];
                                                            proxy_available($proxy_id,$proxy_type,0);
                                                            if($data_order["status"]=="warehouse" || $data_order["status"]=="custom" || $data_order["status"]=="delivered" ||$data_order["status"]=="onair") 
                                                            //mysqli_query($conn,"UPDATE orders SET status='warehouse',warehouse_date='".date("Y-m-d H:i:s")."' WHERE order_id=$order_id");
                                                            $inside_count++;  // COUNT WAREHOUSE OR CUSTOM
                                                            }
                                                        } //SINGLE ENDING
                                                    if ($combined==1) //COMBINED
                                                        {                                                            
                                                            $result_box= mysqli_query($conn,"SELECT * FROM box_combine WHERE barcode='$barcode'");
                                                            if (mysqli_num_rows($result_box)==1)
                                                                {
                                                                $data_box = mysqli_fetch_array($result_box);
                                                                $proxy_id = $data_box["proxy_id"];
                                                                $proxy_type = $data_box["proxy_type"];
                                                                proxy_available($proxy_id,$proxy_type,0);
                                                                
                                                                if($data_box["status"]=="warehouse" || $data_box["status"]=="custom" || $data_box["status"]=="delivered" || $data_box["status"]=="onair") 
                                                                //mysqli_query($conn,"UPDATE orders SET status='warehouse',warehouse_date='".date("Y-m-d H:i:s")."' WHERE order_id=$order_id");
                                                                $inside_count++;  // COUNT WAREHOUSE OR CUSTOM
                                                                }
                                                            
                                                            
                                                            //$inside_count++;
                                                        } //COMBINED ENDING
                                                }
                                                //if ($inside_item==$inside_count)
                                                mysqli_query($conn,"UPDATE boxes SET status='warehouse' WHERE box_id='$boxes_id' LIMIT 1");
                                                echo "<tr>";
                                                echo "<td>".$count."</td>";
                                                echo "<td><a href='boxes?action=detail&id=$box_id'>$name</a></td>"; 
                                                echo "<td>".$packages."</td>"; 
                                                echo "<td>".substr($created_date,0,10)."</td>"; 
                                                echo "<td>";
                                                if ($inside_item==$inside_count) echo "warehouse";
                                                echo "</td>";
                                                echo "<td>".$weight."</td>"; 
                                                echo "</tr>";
                                            }
                                    }
                            }

                            
                            
                            
                            
                            
                            if ($new_status=="delete")  //DELETE BOXES
                            {
                                $count=1;		
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
                                    echo "<tr>";
                                    echo "<td>".$count."</td>";
                                    echo "<td><a href='?action=detail&id=$box_id'>$name</a></td>"; 
                                    echo "<td>".$packages."</td>"; 
                                    echo "<td>".substr($created_date,0,10)."</td>"; 
                                    echo "<td>deleting</td>"; 
                                        echo "<td>".$weight."</td>"; 
                                        echo "</tr>";
                                
                                    $delete_boxes = mysqli_query($conn,"DELETE FROM boxes WHERE box_id='$boxes_id'");
                                    $delete_boxes = mysqli_query($conn,"DELETE FROM boxes_packages WHERE box_id='$boxes_id'");
                                }
                            }
                            
                            
                            
                        }
                        echo "</table>";
                        }
                        
                        else echo "Хайрцаг тэмдэглэгдээгүй байна";
                    ?>
                    </div>
                </div>
            <?
          }
          ?>

          <?
          if ($action == "combine")
          {
            if (isset($_GET["combine_id"])) $combine_id = intval($_GET["combine_id"]); else $combine_id=0;
            ?>
            <div class="card">
                <div class="card-body">                    
                    <? 
                    if ($combine_id==0)
                    {
                        $sql="SELECT * FROM box_combine WHERE status!='delivered' ORDER BY combine_id DESC"; 
                        
                        
                        $result = mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result) > 0)
                        {
                            ?>
                            <form action="?action=combine_changing" method="POST">
                                
                                    <table class='table table-hover'>
                                        <thead>
                                            <tr>
                                                <th>№</th> 
                                                <th><input type="checkbox" name="select_all" title="Select all orders"></th>
                                                <th>Barcode</th>
                                                <th>Х/aвагч</th> 
                                                <th>Огноо</th> 
                                                <th>Төлөв</th> 
                                                <th>Kg</th>
                                                <th>Үйлдэл</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?
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
                                                $extra = $data["extra"];
                                                ?>
                                                    <tr>
                                                        <td><?=$count++;?></td>
                                                        <td><input type="checkbox" name="combine_id[]" value="<?=$combine_id;?>"></td>
                                                        <td><?=$barcode;?></td>
                                                        <td><?
                                                            customer($receiver,"name");
                                                            customer($receiver,"tel");
                                                            ?>
                                                        </td>
                                                        <td><?=$created_date;?></td>
                                                        <td><?=$status." ".$extra;?></td>
                                                        <td><?=$weight;?></td>
                                                        <td>
                                                            <a href="?action=combine_delete&combine_id=<?=$combine_id;?>" title='Delete'><i data-feather='delete'></i></a>
                                                            <a href="?action=combine_display&combine_id=<?=$combine_id;?>" title='Edit'><i data-feather='edit'></i></a>
                                                    
                                                        </td>
                                                    </tr>
                                                <?
                                        
                                            } 
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr><td></td><td colspan='2'>Нийт</td><td><?=$cumulative_packages;?></td><td></td><td></td><td><?=$cumulative_weight;?></td><td></td></tr>
                                        </tfoot>
                                        
                                    </table>
                                         
                                    
                                    <select name="options" class="form-control">
                                        <option value="onair">Онгоцоор нисгэх</option>
                                        <option value="warehouse">Агуулахад оруулах</option>
                                    </select>
                                    <button class="btn btn-success" type="submit">өөрчил</button>

                                </form>
                                <?

                                }
                                else echo '<div class="alert alert-danger" role="alert">No combines</div>';
                                
                                
                            
                            }
                            
                            
                            if ($combine_id>0)
                            {
                                $sql="SELECT * FROM box_combine WHERE combine_id='$combine_id'";
                                $query = mysqli_query($conn,$sql);
                                if (mysqli_num_rows($query) == 1)
                                {
                                    $data=mysqli_fetch_array($query);
                                    echo "<h3>".$data["barcode"]."</h3>";
                                    echo "<table class='table'>";
                                    $barcodes = $data["barcodes"];
                                    foreach(explode(",",$barcodes) as $barcode_single)
                                    {
                                        if ($barcode_single!="")
                                        $query_single  = mysqli_query($conn,"SELECT * FROM orders WHERE barcode = '$barcode_single' LIMIT 1");
                                        $data_single = mysqli_fetch_array($query_single);
                                        echo "<tr>";
                                        echo "<td><a href='tracks?action=detail&id=".$data_single["order_id"]."'>".$data_single["barcode"]."</a></td>"; 
                                        echo "<td>".$data_single["status"]."</td>";
                                        echo "</tr>";		
                                    }
                                    echo "</table>";
                                }
                                else echo '<div class="alert alert-danger" role="alert">Combined box not found</div>';
                            }
                            
                            ?>
                </div>
            </div>
            <?
          }
          ?>

          <?
          if ($action == "combine_changing")
          {
            ?>
            <div class="card">
                <div class="card-body">
                    <? 
                    $options=$_POST["options"];

                    switch ($options)
                    {
                    case "onair":$new_status = "onair";break;
                    case "warehouse":$new_status = "warehouse";break;
                    case "delivered":$new_status = "delivered";break;
                    }

                if(isset($_POST['combine_id'])) {$combine_id=$_POST['combine_id'];$N = count($combine_id);}
                if(isset($_POST['boxes_id'])) {$boxes_id=$_POST['boxes_id'];$N = 1;}
                else {$N = count($boxes); $boxes_id="";}

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
                    if ($new_status=="onair")
                        {
                            $count=1;		
                            $query = mysqli_query($conn,"SELECT * FROM boxes WHERE box_id='$boxes_id' LIMIT 1");
                            if (mysqli_num_rows($result)==1)
                            {
                            $row= $query->row();
                            $box_id= $data["box_id"]; 
                            $name= $data["name"]; 
                            $packages= box_inside($box_id,"packages");
                            $created_date = $data["created_date"];
                            $weight= box_inside($box_id,"weight");
                            $status = $data["status"];
                            $packages_result = mysqli_query($conn,"SELECT * FROM boxes_packages WHERE box_id=$box_id");
                            if ($packages_result->num_rows()>0)
                                {
                                $inside_item =$packages_result->num_rows();
                                $inside_count =0;
                            
                                foreach($packages_result->result() as $package_row)
                                {
                                $barcode=$package_data["barcode"];
                                $combined=$package_data["combined"];
                                $order_id=$package_data["order_id"];
                                $barcodes=$package_data["barcodes"];
                                $order_id=$package_data["order_id"];
                                if ($combined!=1) //SINGLE
                                    {
                                    $order_result= mysqli_query($conn,"SELECT * FROM orders WHERE barcode='$barcode'");
                                    if ($order_result->num_rows()==1)
                                        {
                                        $row_orders = $order_result->row();
                                        if(!($data_single["status"]=="delivered" || $data_single["status"]=="warehouse" || $data_single["status"]=="custom")) 
                                        mysqli_query($conn,"UPDATE orders SET status='onair',onair_date='".date("Y-m-d H:i:s")."' WHERE order_id=$order_id");
                                    $inside_count++;
                                        }
                                    } //SINGLE ENDING
                                if ($combined==1) //COMBINED
                                    {
                                        foreach(explode(",",$barcodes) as $barcode_each)
                                        {
                                            if ($barcode_each!="")
                                            {
                                        $order_result= mysqli_query($conn,"SELECT * FROM orders WHERE barcode='$barcode_each'");
                                        if ($order_result->num_rows()==1)
                                            {
                                            $row_orders = $order_result->row();
                                            if(!($data_single["status"]=="delivered" || $data_single["status"]=="warehouse" || $data_single["status"]=="custom")) 
                                            mysqli_query($conn,"UPDATE orders SET status='onair',onair_date='".date("Y-m-d H:i:s")."' WHERE barcode='$barcode_each'");
                                            }
                                            }
                                        }
                                    mysqli_query($conn,"UPDATE box_combine SET status='onair',onair_date='".date("Y-m-d H:i:s")."' WHERE barcode='$barcode'");
                                    $inside_count++;
                                    } //COMBINED ENDING
                            
                                }
                                if ($inside_item==$inside_count)
                                    mysqli_query($conn,"UPDATE boxes SET status='onair' WHERE box_id='$boxes_id' LIMIT 1");
                                echo "<tr>";
                                echo "<td>".$count."</td>";
                                echo "<td><a href='boxes?action=detail&id=".$data["box_id"]."'>".$name."</a></td>"; 
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

                    
                    

                    if ($new_status=="warehouse")
                    {
                        $count=1;		
                        $query = mysqli_query($conn,"SELECT * FROM boxes WHERE box_id=$boxes_id LIMIT 1");
                            if (mysqli_num_rows($result)==1)
                            {
                            $row= $query->row();
                            $box_id= $data["box_id"]; 
                            $name= $data["name"]; 
                            $packages= box_inside($box_id,"packages");
                            $created_date = $data["created_date"];
                            $weight= box_inside($box_id,"weight");
                            $status = $data["status"];
                            $packages_result = mysqli_query($conn,"SELECT * FROM boxes_packages WHERE box_id=$box_id");
                            if ($packages_result->num_rows()>0)
                                {
                                $inside_item =$packages_result->num_rows();
                                $inside_count =0;
                            
                                foreach($packages_result->result() as $package_row)
                                {
                                $barcode=$package_data["barcode"];
                                $combined=$package_data["combined"];
                                $order_id=$package_data["order_id"];
                                $barcodes=$package_data["barcodes"];
                                $order_id=$package_data["order_id"];
                                if ($combined!=1) //SINGLE
                                    {
                                    $order_result= mysqli_query($conn,"SELECT * FROM orders WHERE barcode='$barcode'");
                                    if ($order_result->num_rows()==1)
                                        {
                                        $row_orders = $order_result->row();
                                        if(!($data_single["status"]=="delivered" || $data_single["status"]=="warehouse" || $data_single["status"]=="custom")) 
                                        mysqli_query($conn,"UPDATE orders SET status='warehouse',warehouse_date='".date("Y-m-d H:i:s")."' WHERE order_id=$order_id");
                                    $inside_count++;
                                        }
                                    } //SINGLE ENDING
                                if ($combined==1) //COMBINED
                                    {
                                        foreach(explode(",",$barcodes) as $barcode_each)
                                        {
                                        $order_result= mysqli_query($conn,"SELECT * FROM orders WHERE barcode='$barcode_each'");
                                        if ($order_result->num_rows()==1)
                                            {
                                            $row_orders = $order_result->row();
                                            if(!($data_single["status"]=="delivered" || $data_single["status"]=="warehouse" || $data_single["status"]=="custom")) 
                                            mysqli_query($conn,"UPDATE orders SET status='onair',onair_date='".date("Y-m-d H:i:s")."' WHERE barcode='$barcode_each'");
                                            }
                                        }
                                    mysqli_query($conn,"UPDATE box_combine SET status='warehouse',warehouse_date='".date("Y-m-d H:i:s")."' WHERE barcode='$barcode'");
                                    $inside_count++;
                                    } //COMBINED ENDING
                                }
                                if ($inside_item==$inside_count)
                                    mysqli_query($conn,"UPDATE boxes SET status='warehouse' WHERE box_id='$boxes_id' LIMIT 1");
                                echo "<tr>";
                                echo "<td>".$count."</td>";
                                echo "<td><a href='boxes?action=detail&id=".$data["box_id"]."'>".$name."</a></td>"; 
                                echo "<td>".$packages."</td>"; 
                                echo "<td>".substr($created_date,0,10)."</td>"; 
                                echo "<td>";
                                if ($inside_item==$inside_count) echo "warehouse";
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
                        $row= $query->row();
                        $box_id= $data["box_id"]; 
                        $name= $data["name"]; 
                        $packages= box_inside($box_id,"packages");
                        $created_date = $data["created_date"];
                        $weight= box_inside($box_id,"weight");
                        $status = $data["status"];
                        echo "<tr>";
                        echo "<td>".$count."</td>";
                        echo "<td><a href='boxes?action=detail&id=".$data["box_id"]."'>".$name."</a></td>";                       
                        echo "<td>".$packages."</td>"; 
                        echo "<td>".substr($created_date,0,10)."</td>"; 
                        echo "<td>deleting</td>"; 
                            echo "<td>".$weight."</td>"; 
                            echo "</tr>";
                    
                        $delete_boxes = mysqli_query($conn,"DELETE FROM boxes WHERE box_id='$boxes_id'");
                        $delete_boxes = mysqli_query($conn,"DELETE FROM boxes_packages WHERE box_id='$boxes_id'");
                        }
                    }
                    
                    
                    
                }
                echo "</table>";
                }
                
                else echo "Хайрцаг тэмдэглэгдээгүй байна";
            ?>

                </div>
            </div>
            <?
          }
          ?>

          <?
          if ($action == "history")
          {
            if (isset($_POST["from_date"])) $from_date=$_POST["from_date"]; else $from_date= date('Y-m-d', strtotime(date('Y-m-d') . ' -1 month'));
            if (isset($_POST["to_date"])) $to_date=$_POST["to_date"]; else $to_date= date('Y-m-d');
            
            ?>
            <form action="?action=history" method="post">
                <input type="date" name="from_date" class="form-control" value="<?=$from_date;?>">
                <input type="date" name="to_date" class="form-control" value="<?=$to_date;?>">
            </form>
            <div class="panel panel-primary">
              <div class="panel-heading">Түүх</div>
                  <div class="panel-body">
                <? 
                $result = mysqli_query($conn,"SELECT * FROM boxes WHERE status IN ('warehouse','delivered') AND created_date >='$from_date' AND  created_date <='$to_date' ORDER BY box_id DESC");
                if (mysqli_num_rows($result) > 0)
                    {
                    echo "<table class='table table-hover'>";
                    echo "<tr>";                    
                    echo "<th>№</th>"; 
                    echo "<th>Нэр</th>"; 
                    echo "<th>Тоо</th>"; 
                    echo "<th>Огноо</th>"; 
                    echo "<th>Төлөв</th>"; 
                    echo "<th>Жин /Кг/</th>"; 
                    echo "<th>Үйлдэл</th>"; 
                    echo "</tr>";
                    $count=1;
                    $cumulative_weight=0;
                    $cumulative_packages = 0;
                  while ($data =  mysqli_fetch_array($result))
                  { 
                      $box_id= $data["box_id"]; 
                      $name= $data["name"]; 
                      $packages= $data["packages"];
                      $created_date = $data["created_date"];
                      $status = $data["status"];
                    
                  
                    echo "<tr>";
                    echo "<td>".$count++."</td>";
                    echo "<td>".$name."</td>"; 
                    echo "<td>".$packages."</td>"; 
                    echo "<td>".$created_date."</td>"; 
                    echo "<td>".$status."</td>"; 
                    //Kg calculate
                      $query_kg = mysqli_query($conn,"SELECT * FROM boxes_packages WHERE box_id=".$box_id);
                    $total_weight=0;
                    while ($data_kg = mysqli_fetch_array($query_kg))
                    { 
                      $order_id=$data_kg["order_id"];
                      $weight=floatval(order($order_id,'weight'));
                      $total_weight+=$weight;
                    }
                    //Kg calculate
                    
                    echo "<td>".$total_weight."</td>"; 
                    echo "<td>";
                      echo "<div class='btn-group'>";
                        echo "<a href='boxes?action=reverse_history&id=".$data["box_id"]."' class='btn btn-sm btn-danger'>Нисэж буй төлөвт оруулах</a>";
                        echo "<a href='boxes?action=detail&id=".$data["box_id"]."'  class='btn btn-sm btn-primary'>Detail</a>";                      
                      echo "</div>";
                    echo "</td>";  
                    echo "</tr>";
                    $cumulative_packages+=$packages;
                    $cumulative_weight+=$total_weight;
                    
                    //array_push($data,array($sender_surname,$sender,$sender_contact,$sender_address,$receiver_surname,$receiver,$receiver_contact,$receiver_address,$temp_status,$Package_advance_value,'',$weight,$price,$description,$barcode));

                    } 
                    echo "<tr><td></td><td colspan='2'>Нийт</td><td>$cumulative_packages</td><td></td><td></td><td>$cumulative_weight</td><td></td></tr>";
                    echo "</table>";
                }
                else echo '<div class="alert alert-danger" role="alert">Хуучин хайрцаг олдсонгүй</div>';

                ?>

                </div>
                </div> <!--wrapper-->
            <?
          }
          ?>

          <?
          if ($action == "reverse_history")
          {
              if (isset($_GET["id"])) 
              {
                $box_id =  intval($_GET["id"]); 
                $sql = "SELECT * FROM boxes WHERE box_id=".$box_id;
                $result = mysqli_query($conn,$sql);
                if (mysqli_num_rows($result)==1)
                {
                    $data = mysqli_fetch_array($result);
                    $box_name = $data["name"];
                    $box_packages = $data["packages"];
                    $box_created_date = $data["created_date"];
                    $box_status = $data["status"];
                    $box_upost_date = $data["upost_date"];
                    $box_upost_pk = $data["upost_pk"];

                    if ($box_status == "warehouse")
                    {
                      $count=1;		
                    
                      $packages_result = mysqli_query($conn,"SELECT * FROM boxes_packages WHERE box_id='$box_id'");
                      $inside_item =mysqli_num_rows($packages_result);
                      if ($inside_item>0)
                      {
                            $inside_count =0;
                            while ($package_data = mysqli_fetch_array($packages_result))
                            {
                              $barcode=$package_data["barcode"];
                              $combined=$package_data["combined"];
                              $order_id=$package_data["order_id"];
                              $barcodes=$package_data["barcodes"];
                              $order_id=$package_data["order_id"];
                              if ($combined!=1) //SINGLE
                                  {
                                      $result_single= mysqli_query($conn,"SELECT * FROM orders WHERE barcode='$barcode'");
                                      if (mysqli_num_rows($result_single)==1)
                                          {
                                          $data_single = mysqli_fetch_array($result_single);
                                          $proxy_id = $data_single["proxy_id"];
                                          $proxy_type = $data_single["proxy_type"];
                                          if(!($data_single["status"]=="delivered" || $data_single["status"]=="warehouse" || $data_single["status"]=="custom")) 
                                          {
                                            mysqli_query($conn,"UPDATE orders SET status='onair',onair_date='".date("Y-m-d H:i:s")."' WHERE order_id=$order_id");
                                            proxy_available($proxy_id,$proxy_type,0);
                                          }
                                      $inside_count++;
                                          }
                                  } //SINGLE ENDING
                              if ($combined==1) //COMBINED
                                  {
                                      foreach(explode(",",$barcodes) as $barcode_each)
                                      {
                                        $combine_result= mysqli_query($conn,"SELECT * FROM orders WHERE barcode='$barcode_each'");
                                        if (mysqli_num_rows($combine_result)==1)
                                            {
                                              $data_combine = mysqli_fetch_array($combine_result);
                                              $proxy_id = $data_single["proxy_id"];
                                              $proxy_type = $data_single["proxy_type"];
                                              proxy_available($proxy_id,$proxy_type,0);


                                              if(!($data_single["status"]=="delivered" || $data_single["status"]=="warehouse" || $data_single["status"]=="custom")) 
                                              mysqli_query($conn,"UPDATE orders SET status='onair',onair_date='".date("Y-m-d H:i:s")."' WHERE barcode='$barcode_each'");
                                            }
                                      }
                                    mysqli_query($conn,"UPDATE box_combine SET status='onair',onair_date='".date("Y-m-d H:i:s")."' WHERE barcode='$barcode'");
                                    $inside_count++;
                                  } //COMBINED ENDING
                          
                            }
                            if ($inside_item==$inside_count)
                            {
                              mysqli_query($conn,"UPDATE boxes SET status='onair' WHERE box_id='$box_id' LIMIT 1");

                              alert_div("Хайрцгыг түүхээс буцаалаа.","success");
                            }
                            else 
                            {
                              alert_div("Хайрцгын төлөв өөрчлөгдөхөд алдаа гарлаа.");
                              alert_div("Ачааны тоо:".$inside_count. " өөрчлөлт орсон ачаа:".$inside_item);
                            }
                        
                      }
                      else alert_div("Хайрцагт ачаа байхгүй.");                              
                          
                    }
                    else alert_div("Хайргын төлөв түүхэд байгаа төлөвт биш байна");
                }
                else alert_div("Хайрцагын дугаар олдсонгүй");
              }
              else alert_div("Хайрцагын дугаар байхгүй");

          }
          ?>

          <?
          if ($action == "detail")
          {
              if (isset($_GET["id"])) 
              {
                $box_id =  intval($_GET["id"]); 
                $sql = "SELECT * FROM boxes WHERE box_id=".$box_id;
                $result = mysqli_query($conn,$sql);
                if (mysqli_num_rows($result)==1)
                {
                  $data = mysqli_fetch_array($result);
                  $box_name = $data["name"];
                  $box_packages = $data["packages"];
                  $box_created_date = $data["created_date"];
                  $box_status = $data["status"];
                  $box_upost_date = $data["upost_date"];
                  $box_upost_pk = $data["upost_pk"];


                  $sql = "SELECT * FROM boxes_packages WHERE box_id=".$box_id;
                  $result = mysqli_query($conn,$sql);
                  $total_weight=0;
                  if (mysqli_num_rows($result) > 0)
                  {
                      ?>             
                      <h5><?=$box_name;?></h5>       
                      <h6>Box дэлгэрэнгүй</h6>       
                      <table id="box_detail" class='table table-hover'>
                        <thead>
                          <tr>
                          <th></th>
                          <th>Barcode</th> 
                          <th>Receiver</th> 
                          <th>Contact</th>
                          <th>Kg</th>
                          <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?
                          $count=1;
                          while ($data = mysqli_fetch_array($result))
                          { 
                            $barcode=$data["barcode"];
                            $weight=$data["weight"];
                            $combine=$data["combined"];
                            $order_id=$data["order_id"];
                            if ($order_id!=0)
                            {
                              $result_inside = mysqli_query($conn,"SELECT * FROM orders WHERE order_id=".$order_id);
                              if (mysqli_num_rows($result_inside)==1)
                                {
                                  $data_inside=mysqli_fetch_array($result_inside);
                                  $status=$data_inside["status"];
                                  $receiver = $data_inside["receiver"];
                                  $proxy= $data_inside["proxy_id"];
                                  $proxy_type=$data_inside["proxy_type"];
                                }
                                else $status=$receiver=$proxy="";
                            }
                            else 
                            {
                              $result_combine = mysqli_query($conn,"SELECT * FROM box_combine WHERE barcode='".$barcode."'");
                                if (mysqli_num_rows($result_combine)==1)
                                {
                                  $data_combine=mysqli_fetch_array($result_combine);
                                  $status=$data_combine["status"];
                                  $receiver = $data_combine["receiver"];
                                  $proxy= $data_combine["proxy_id"];
                                  $proxy_type= $data_combine["proxy_type"];
                                }
                              else  $status=$receiver=$proxy="";
                            }
                            
        
                            //$result_order = mysqli_query($conn,"SELECT * FROM customer WHERE customer_id=".$receiver_id);
                            // $receiver_row=$data_order["row();
                            $r_name= customer($receiver,"name");
                            $r_surname= customer($receiver,"surname");
                            $r_tel= customer($receiver,"tel");
                            $r_address= customer($receiver,"address");
                            ?>
                              <tr>
                                <td><?=$count;?></td>
                                <td><?=barcode_comfort($barcode);?></td>
                                <td>
                                  <? 
                                    if($r_name!="") echo '<a href="customers?action=detail&id='.$receiver.'">'.substr($r_surname,0,2).".".$r_name.'</a>';
                                    if ($proxy>0) echo "<br>".$proxy.":".proxy2($proxy,$proxy_type,"name");
                                  ?>
                                </td>
                                <td><?=$r_tel;?></td>
                                <td><?=$weight;?></td>
                                <td><?=$status;?></td>
                              </tr>
                              <?

                                $total_weight+=$weight;
                                $count++;                                                            
                          }
                          ?>
                      </tbody>
                      <tfooter>
                          <tr>
                            <td colspan="4">Нийт</td>
                            <td><?=$total_weight;?></td>
                            <td></td>
                          </tr>                          
                        <tfooter>
                    </table>
                    <?
                  }
                    else echo "Nothing inside Box<br>";
                }
                else echo "Box not found";
              }
              else echo "no box_id";

          }
          ?>

          <?
          if ($action == "combine_display")
          {
            if (isset($_GET["combine_id"]))
            {
              $combine_id = intval($_GET["combine_id"]);
              $sql="SELECT * FROM box_combine WHERE combine_id='$combine_id'";
              $result = mysqli_query($conn,$sql);
              if (mysqli_num_rows($result) == 1)
              {
                $data = mysqli_fetch_array($result);
                echo "<h3>".$data["barcode"]."</h3>";
                echo "<table class='table'>";
                $barcodes = $data["barcodes"];
                foreach(explode(",",$barcodes) as $barcode_single)
                {
                  if ($barcode_single!="")
                  {
                    $query_single  = mysqli_query($conn,"SELECT * FROM orders WHERE barcode = '$barcode_single' LIMIT 1");
                    $data_single = mysqli_fetch_array($query_single);
                    echo "<tr>";
                    echo "<td><a href='tracks?action=detail&id=".$data_single["order_id"]."'>".$data_single["barcode"]."</a></td>";
                    echo "<td>".$data_single["status"]."</td>";
                    echo "</tr>";		
                  }
                }
                echo "</table>";
              }
              else echo '<div class="alert alert-danger" role="alert">Combined box not found</div>';

              
            }
            else echo 'Нэгтгэсэн ачааны дугаар олдсонгүй';
          }
          ?>

          <?
          if ($action == "combine_delete")
          {
            if (isset($_GET["combine_id"]))
            {
              $combine_id = intval($_GET["combine_id"]);
              $sql="SELECT * FROM box_combine WHERE combine_id='$combine_id'";
              $result = mysqli_query($conn,$sql);
              if (mysqli_num_rows($result) == 1)
              {
                $data = mysqli_fetch_array($result);
                if (mysqli_query($conn,"DELETE FROM box_combine WHERE combine_id=".$combine_id)) 
                {
                  ?>
                  <div class="alert alert-success">Амжилттай устгалаа</div>
                  <?
                }
                else 
                {
                  ?>
                  <div class="alert alert-danger">Алдаа гарлаа: <?=mysqli_error($conn);?></div>
                  <?
                }

              }
              else echo '<div class="alert alert-danger" role="alert">Combined box not found</div>';

              
            }
            else echo 'Нэгтгэсэн ачааны дугаар олдсонгүй';
          }
          ?>

          <?
          if ($action == "badge")
          {
            if (isset($_GET["id"]))
            {
              $box_id = intval($_GET["id"]);
              $sql="SELECT * FROM boxes WHERE box_id='$box_id'";
              $result = mysqli_query($conn,$sql);
              if (mysqli_num_rows($result) == 1)
              {
                  $result = mysqli_query($conn,"SELECT * FROM boxes_packages WHERE box_id=".$box_id);
                  echo "<table class='table table-hover'>";
                  echo "<tr>";
                  echo "<th></th>"; 
                    echo "<th  width='200'>Barcode</th>"; 
                  echo "<th>Receiver</th>"; 
                  echo "<th>Contact</th>"; 

                    echo "</tr>";
                  $count=1;
                  while ($data = mysqli_fetch_array($result))
                  { 
                  $order_id=$data["order_id"];
                  $barcode=$data["barcode"];
                  $combined=$data["combined"];
                  
                  if($combined==0)
                  {
                    $result_order = mysqli_query($conn,"SELECT * FROM orders WHERE order_id=".$order_id);
                    $receiver_data= mysqli_fetch_array($result_order);
                    $barcode=$receiver_data["barcode"];
                    $receiver_id=$receiver_data["receiver"];
                    $r_name= customer($receiver_id,"name");
                    $r_surname= customer($receiver_id,"surname");
                    $r_tel= customer($receiver_id,"tel");
                    $proxy= $receiver_data["proxy_id"];
                    $proxy_type= $receiver_data["proxy_type"];
                  }
                  
                  if($combined==1)
                  {
                    $result_order = mysqli_query($conn,"SELECT * FROM box_combine WHERE barcode='".$barcode."'");
                    $receiver_row=mysqli_fetch_array($result_order);
                    $barcode=$receiver_data["barcode"];
                    $receiver_id=$receiver_data["receiver"];
                    $r_name= customer($receiver_id,"name");
                    $r_surname= customer($receiver_id,"surname");
                    $r_tel= customer($receiver_id,"tel");
                    $proxy= $receiver_data["proxy_id"];
                    $proxy_type= $receiver_data["proxy_type"];
                  }
                    //barcode_generate($barcode);

                  echo "<tr>";
                  echo "<td>".$count++."</td>";
                  echo "<td><img src='barcode_gen?=".$barcode."' style='width:100%'></td>";
                  echo "<td>".substr($r_surname,0,2).".".$r_name;
                    if ($proxy!="") echo "<br>".proxy2($proxy,$proxy_type,"name");
                  echo "</td>";
                  echo "<td>".$r_tel;
                  if ($proxy!="") echo "<br>".proxy2($proxy,$proxy_type,"tel");
                  echo "</td>";
                  
                  echo "</tr>";

                  }
                  echo "</table>";
                  echo '<button onClick="window.print()">Print this page</button>';

              }
              else echo '<div class="alert alert-danger" role="alert">Box not found</div>';

              
            }
            else echo 'Box дугаар олдсонгүй';
          }
          ?>

          <?
          if ($action == "excel")
          {
              require_once('assets/vendors/PHP_XLSXWriter/xlsxwriter.class.php');

              $sql="SELECT * FROM boxes WHERE status NOT IN ('warehouse','delivered') ORDER BY created_date DESC";

              $result = mysqli_query($conn,$sql);

                $cumulative_weight=0;
                $cumulative_packages = 0;

              if (mysqli_num_rows($result) > 0)
              {
                $data_excel = array(array('№','Box нэр','Тоо','Овог','Нэр','Хаяг','Утас','Үүсгэсэн','Branch','Овог','Нэр','Хаяг','Утас','Төлөв','Жин','Нэгтгэсэн','Дэлгэрэнгүй','Баталгаажсан','Үнэлгээ'));


                  $count_box=1;
                  while ($data = mysqli_fetch_array($result))
                  {

                  $box_id= $data["box_id"];
                  $name= $data["name"];
                  // 		$surname= $data["surname"];
                  $created_date =$data["created_date"];
                  $status= $data["status"];
                  $weight=$data["weight"];
                    //$packages=box_inside($box_id,"packages");
                  $packages=$data["packages"];

                  //echo "box_id:".$box_id."<br>";
                  
                  $cumulative_packages+=$packages;
                  $cumulative_weight+=$weight;
                  
                  array_push($data_excel,array($count_box,$name,$packages,"","","","",$created_date,"","","","",$status,$weight,"","","",""));
                  $count_box ++;
                  
                    ///inside 
                    
                    $result_packages = mysqli_query($conn,"SELECT * FROM boxes_packages WHERE box_id=".$box_id);
                    $total_weight=0;
                    if (mysqli_num_rows($result_packages) > 0)
                    {
                      $count=1;
                      while ($data_packages = mysqli_fetch_array($result_packages))
                      { 
                        $barcode=$data_packages["barcode"];
                        $weight_sigle=$data_packages["weight"];
                        $combine=$data_packages["combined"];
                        $order_id=$data_packages["order_id"];
                          if ($order_id!=0)
                            {
                            $result_order = mysqli_query($conn,"SELECT * FROM orders WHERE order_id=".$order_id);
                            if (mysqli_num_rows($result_order)==1)
                                {
                                    //echo "single";
                                $data_order=mysqli_fetch_array($result_order);
                                $status=$data_order["status"];
                                $receiver = $data_order["receiver"];
                                $proxy= $data_order["proxy_id"];
                                $proxy_type= $data_order["proxy_type"];
                                $status_single=$data_order["status"];
                                $packages=$data_order["package"];
                                $sender = $data_order["sender"];
                                $date =substr($data_order["created_date"],0,10);
                                  if ($data_order["is_branch"]) $is_branch="DE"; else $is_branch="";
                              }
                              // else echo "deleted";
                          }
                            else 
                              {
                                //	echo "combine";
                              $result_combine = mysqli_query($conn,"SELECT * FROM box_combine WHERE barcode='".$barcode."'");
                              $combine_data=mysqli_fetch_array($result_combine);
                              $status=$combine_data["status"];
                              $receiver = $combine_data["receiver"];
                              $proxy= $combine_data["proxy_id"];
                              $status_single=$combine_data["status"];
                              $packages=$combine_data["package"];
                              $sender = $combine_data["sender"];
                              $date=substr($combine_data["created_date"],0,10);
                            }
                    
                          
                          $r_name= customer($receiver,"name");
                          $r_surname= customer($receiver,"surname");
                          $r_tel= customer($receiver,"tel");
                          $r_address= customer($receiver,"address");
                    
                          $p_name= proxy2($proxy,$proxy_type,"name");
                          $p_surname= proxy2($proxy,$proxy_type,"surname");
                          $p_tel= proxy2($proxy,$proxy_type,"tel");
                          $p_address= proxy2($proxy,$proxy_type,"address");
                          
                          $s_name= customer($sender,"name");
                          $s_surname= customer($sender,"surname");
                          $s_tel= customer($sender,"tel");
                          $s_address= customer($sender,"address");
                          
                          //$packages_array=explode("##",$packages);
                            $packages = str_replace("########","##",$packages);
                          $packages = str_replace("######","##",$packages);
                          $packages_array = explode("##",$packages);
                          $total_price = 0; 
                          
                          $pack_names = "";
                          $items = floor(count($packages_array)/3);
                          for($i=0;$i<$items; $i++)
                          {
                            $pack_names.=$packages_array[$i*3].",";
                            if(substr($packages_array[$i*3+2],-1)=='$') $total_price +=intval(substr($packages_array[$i*3+2],0,strlen($packages_array[$i*3+2])-1));
                            else $total_price +=intval($packages_array[$i*3+2]);
                            
                          }
                          
                          
                          $total_weight+=floatval($weight_sigle);
                          if ($proxy!=0)
                            $data_single = array ("","","",$s_surname,$s_name,$s_address,$s_tel,$barcode,$is_branch,$p_surname,$p_name,$p_address,$p_tel,$status_single,$weight_sigle,$combine,$pack_names,$total_price,$date);
                            else 
                            $data_single = array ("","","",$s_surname,$s_name,$s_address,$s_tel,$barcode,$is_branch,$r_surname,$r_name,$r_address,$r_tel,$status_single,$weight_sigle,$combine,$pack_names,$total_price,$date);
                            
                          array_push($data_excel,$data_single);
                          $count++;
                      }
                    }
                    ///inside
                }
                array_push($data_excel,array("","",$cumulative_packages,"","","","","","","","","","","","",$cumulative_weight,"",""));

              
                $writer = new XLSXWriter();
                $writer->writeSheet($data_excel);
                $writer->writeToFile('files/box_excel.xlsx');
                
                // echo json_encode($data_excel);
                    
              }
              echo "Excel шинэчиллээ";
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

	<!-- endinject -->

</body>
</html>    