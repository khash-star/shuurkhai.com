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
            case "history": $action_title="Түүх";break;
            case "all": $action_title="Бүх онлайн";break;
            case "pending_track": $action_title="pending_track";break;
            case "all_later": $action_title="Дараа болгосон";break;
            case "delete": $action_title="Ачааийн мэдээлэл устгах";break;
            case "dashboard": $action_title="Удирдлага";break;            
            case "error": $action_title="Мэдээлэл алдаатай";break;
            case "online_later": $action_title="Дараа болгох";break;
            case "unlater": $action_title="Одоо болгох";break;
            case "track_renew": $action_title="Трак олгох";break;
            case "track_renewing": $action_title="Трак олгох";break;
            case "online_pending": $action_title="Дараа болгох";break;
            case "renew": $action_title="Захиалга болгох";break;
            case "renewing": $action_title="Захиалга болгох";break;
            case "comment": $action_title="Тайлбар бичих";break;
            case "commenting": $action_title="Тайлбар бичих";break;
            case "price": $action_title="Үнэ оруулах";break;
            case "pricing": $action_title="Үнэ оруулах";break;
            case "pending_track": $action_title="Pending track";break;
            case "all_later": $action_title="Дараа болгосон";break;

            
          }
          ?>
          <nav class="page-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="online">Онлайн удирдлага</a></li>
              <li class="breadcrumb-item"><a href="online?action=all">Бүх онлайн</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?=$action_title;?></li>
            </ol>
          </nav>

          <?
          if ($action =="dashboard")
          {
            $sql = "SELECT *FROM online";
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
                          <h6 class="card-title mb-0">Нийт онлайн</h6>
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
            <?
          }
          ?>

          <?
          if ($action=="all")
          {
            $sql="SELECT online.customer_id, SUM(price) AS total_price, SUM(tax) AS total_tax, SUM(shipping) AS total_shipping, COUNT(customer_id) AS count, SUM(owe) AS total_owe, SUM(new) AS total_new FROM online";
            $sql.=" WHERE status!='order' AND status!='later' AND status!='pending'";
            $sql.=" GROUP by customer_id ORDER BY update_date DESC, created_date DESC";

            $result = mysqli_query($conn,$sql);
            $count=1;$total_weight=0;$total_price=0;

            ?>
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-body">                      
                      <table id="online_table" class="table">
                            <thead>                          
                              <tr>
                                <th>№</th>
                                <th>Нэр</th>
                                <th>Мейл</th>
                                <th>Утас</th>
                                <th>Үнэ</th>
                                <th>Үйлдэл</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?
                              
                              $j=mysqli_num_rows($result);

                              while ($data = mysqli_fetch_array($result))
                                {  

                                    $receiver=$data["customer_id"];	
                                    ?>
                                    <tr>
                                      <td><?=$j--;?></td>
                                    
                                      <td>
                                      <a href="customers?action=detail&id="<?=$receiver;?>"><?=substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name");?></a>
                                      </td>
                                    

                                      <td>
                                      <?=(customer($receiver,"email")!="")?'<a href="mailto:'.customer($receiver,"email").'">mail</a>':'';?> 
                                      </td>
                                      <td>
                                      <?=customer($receiver,"tel");?>
                                      </td>

                                      <td>
                                        <span style="color:#000; font-weight:bold;">Нийт online: <?=$data["count"];?>ш</span><br>
                                        <span style="color:#0F0; font-weight:bold;">Дүн бодогдоогүй: <?=$data["total_new"];?>ш</span><br>
                                        <span style="color:#F00; font-weight:bold;">Үнэ: <?=number_format($data["total_price"],2);?>$</span><br>
                                        <span style="color:#1079b2; font-weight:bold;">Tax: <?=number_format($data["total_tax"],2);?>$</span><br>
                                        <span style="color:#f0861b; font-weight:bold;">Shipping: <?=number_format($data["total_shipping"],2);?>$</span><br>
                                        <span style="color:#ff0000; font-weight:bold;">Дараа төлбөр: <?=number_format($data["total_owe"],2);?>$</span><br>
                                            <? 
                                            $total = $data["total_price"]+$data["total_tax"]+$data["total_shipping"]+$data["total_owe"];
                                            ?>
                                        <span style="color:#be0fce; font-weight:bold;font-size:14px;">Нийт: <?=number_format($total,2).'$ ('.number_format($total*cfg_rate());?>₮)</span><br>
                                      </td>
                                      
                                      <td>
                                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#online_detail_<?=$receiver;?>">Дэлгэх</button>
                                                          

                                        <div class="modal" tabindex="-1" role="dialog" id="online_detail_<?=$receiver;?>">
                                          <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title">Онлайн</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                <?
                                                    $sql_online="SELECT * FROM online";
                                                    $sql_online.=" WHERE status!='order' AND status!='later' AND status!='pending' AND customer_id='".$receiver."'";
                                                    $sql_online.=" ORDER BY created_date DESC";
                                                    
                                                    $result_single = mysqli_query($conn,$sql_online);
                                                    if (mysqli_num_rows($result_single) > 0)
                                                    {
                                                      ?>
                                                      <table class='table table-striped'>
                                                      
                                                        <tr><th>№</th><th>Үүсгэсэн</th><th>Үнэ</th><th>Коммент</th><th>Тайлбар</th><th>Үйлдэл</th></tr>
                                                        <?

                                                        $i=mysqli_num_rows($result_single);
                                                        while ($data_single = mysqli_fetch_array($result_single))
                                                        {  
                                                            $created_date=$data_single["created_date"];
                                                            $online_id=$data_single["online_id"];
                                                            $url=$data_single["url"]; 
                                                            $size=$data_single["size"]; 
                                                            $color=$data_single["color"];
                                                            $number=$data_single["number"];
                                                            $track=$data_single["track"];
                                                            $comment=$data_single["comment"];
                                                            $price=$data_single["price"];
                                                            $tax=$data_single["tax"];
                                                            $shipping=$data_single["shipping"];
                                                            $owe=$data_single["owe"];
                                                            $status=$data_single["status"];
                                                            $transport= $data_single["transport"];
                                                            $context= $data_single["context"];
                                                            ?>

                                                            
                                                            <tr>
                                                            <td><?=$i--;?></td>
                                                            <td><?=substr($created_date,0,10);?>
                                                            <?
                                                              if ($transport) echo "<br><span class='glyphicon glyphicon-home' title='Улаанбаатарт хүргэлттэй'></span> Хүргэлттэй"; 
                                                            ?>
                                                            </td>
                                                            
                                                            <td>
                                                              <a href='<?=$url;?>' target='_blank'><?=substr($url,0,20);?>".......</a><br>
                                                              <?=$number."/".$size."/".$color."<br>";?>

                                                              <span style="color:#F00; font-weight:bold;">Үнэ: <?=$price;?>$</span><br>
                                                              <span style="color:#1079b2; font-weight:bold;">Tax: <?=$tax;?>$</span><br>
                                                              <span style="color:#f0861b; font-weight:bold;">Shipping: <?=$shipping;?>$</span><br>
                                                              <span style="color:#ff0000; font-weight:bold;">Дараа төлбөр: <?=$owe;?>$</span>
                                                            <td><?=$comment;?></td>	
                                                            <td><?=$context;?></td>
                                                          
                                                              <td>
                                                              <a href="?action=price&id=<?=$online_id;?>" title="<?=$comment;?>" class="btn btn-xs btn-primary btn-shuurkhai w-100">Үнэ</a>
                                                              <br>
                                                              <a href="?action=comment&id=<?=$online_id;?>" title="<?=$comment;?>" class="btn btn-xs btn-primary btn-shuurkhai w-100">Бичих</a>
                                                              <br>
                                                              <a href="?action=renew&id=<?=$online_id;?>" title="Make it order!" class="btn btn-xs btn-success btn-shuurkhai w-100">Захиалга</a>
                                                              <br>
                                                              <a href="?action=online_pending&id=<?=$online_id;?>" title="Track pending!" class="btn btn-xs btn-success btn-shuurkhai w-100">Track pending</a>
                                                              <br>
                                                              <a href="?action=track_renew&id=<?=$online_id;?>" title="Only Give Track!" class="btn btn-xs btn-warning btn-shuurkhai w-100">Track</a>
                                                              <br>
                                                              <a href="?action=online_later&id=<?=$online_id;?>" title="Make later!" class="btn btn-xs btn-warning btn-shuurkhai w-100">Дараа болгох</a>
                                                              <br>
                                                              <a href="?action=delete&id=<?=$online_id;?>" title="Delete!" class="btn btn-xs btn-danger btn-shuurkhai w-100">Устгах</a>                            
                                                              
                                                              </td>
                                                            </tr>	
                                                            <?
                                                        }
                                                        ?>
                                                      </table>
                                                      <?
                                                    }
                                                ?>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>



                                      </td>
                                  
                                    </tr>
                                    <?                                  
                                }
                              
                              ?>
                            
                            </tbody>
                            <tfoot>
                              <tr><td>Нийт</td><td><?=$total_weight;?></td><td><?=$total_weight*cfg_paymentrate();?></td><td><?=$total_price;?></td><td></td></tr>
                            </tfoot>
                        </table>
                    </div>
                  </div>
              </div>
            </div>


            <?
          }
          ?>

          <?
          if ($action=="history")
          {
            ?>
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-body">
                    <?                    
                    /*if(isset($_POST["search"])) 
                      {
                      $search_term=str_replace(" ","%",$_POST["search"]);
                      echo "Xайлт:".$search_term."<br>";
                      } 
                      else $search_term = "";
                    */
                    if (isset($_GET["page"])) $page = intval($_GET["page"]); else $page=0;


                    $sql="SELECT * FROM online WHERE status='order' ";
                    $sql.="ORDER by created_date DESC";
                    $result =mysqli_query($conn,$sql);                    
                    $total_online = mysqli_num_rows($result);
                    $sql.=" LIMIT ".$page*50 .",50";
                    $result =mysqli_query($conn,$sql);                    
                    
                    if (mysqli_num_rows($result) > 0)
                    {
                      echo "<table class='table table-hover'>";
                      echo "<tr><th>№</th><th>Нэр</th><th>URL</th><th>Тоо/Хэмжээ/Өнгө</th><th>Үүсгэсэн/Track</th></tr>";
                      $i=mysqli_num_rows($result);
                      while ($data  = mysqli_fetch_array($result))
                      {  
                        $created_date=$data["created_date"];
                        $online_id=$data["online_id"];
                        $url=$data["url"]; 
                        $size=$data["size"]; 
                        $color=$data["color"];
                        $number=$data["number"];
                        $receiver=$data["receiver"];
                        $track=$data["track"];
                        $comment=$data["comment"];
                        $status=$data["status"];
                        $transport = $data["transport"];
                        $proceed_date = $data["proceed_date"];
                        
                        $price=$data["price"]; 
                        $tax=$data["tax"]; 
                        $shipping=$data["shipping"]; 
                        
                        
                        ?>
                         <tr>
                         <td><?=$i--;?></td>
                         <td>
                          <?=substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name");?><br>
                          <?=customer($receiver,"tel");?>
                          <?

                          if ($transport) echo "<br><span class='glyphicon glyphicon-home' title='Улаанбаатарт хүргэлттэй'></span> Хүргэлттэй"; 
                          ?>
                        </td>
                        
                        <td>
                          <a href="<?=$url;?>" target="_blank"><?=substr($url,0,30);?>.......</a><br>
                          <?=$track;?><br>
                          <span style="color:#F00; font-weight:bold;">Үнэ: <?=number_format($price,2);?>$</span><br>
                          <span style="color:#1079b2; font-weight:bold;">Tax: <?=number_format($tax,2);?>$</span><br>
                          <span style="color:#f0861b; font-weight:bold;">Shipping: <?=number_format($shipping,2);?>$</span>
                        </td>
                        <td><?=$number."/".$size."/".$color;?></td>
                        <td><?=substr($created_date,0,11)."<br>".substr($proceed_date,0,11);?></td>
                      </tr>	
                      <?
                      }
                      ?>
                      </table>
                      <?
                    }
                    else //$query->num_rows() ==0
                      {
                        ?>
                        <div class="alert alert-danger" role="alert">Онлайн түүх олдсонгүй.</div>
                        <?
                      }
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <?
          }
          ?>

          <?
          if ($action =="pending_track")
          {
            $sql="SELECT online.customer_id, SUM(price) AS total_price, SUM(tax) AS total_tax, SUM(shipping) AS total_shipping, COUNT(customer_id) AS count, SUM(owe) AS total_owe, SUM(new) AS total_new FROM online";
            $sql.=" WHERE status='pending'";
            $sql.=" GROUP by customer_id ORDER BY update_date DESC, created_date DESC";

            $result = mysqli_query($conn,$sql);
            $count=1;$total_weight=0;$total_price=0;

            ?>
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-body">                      
                      <table id="online_table" class="table">
                            <thead>                          
                              <tr>
                                <th>№</th>
                                <th>Нэр</th>
                                <th>Мейл</th>
                                <th>Утас</th>
                                <th>Үнэ</th>
                                <th>Үйлдэл</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?
                              
                              $j=mysqli_num_rows($result);

                              while ($data = mysqli_fetch_array($result))
                                {  

                                    $receiver=$data["customer_id"];	
                                    ?>
                                    <tr>
                                      <td><?=$j--;?></td>
                                    
                                      <td>
                                      <a href="customers?action=detail&id="<?=$receiver;?>"><?=substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name");?></a>
                                      </td>
                                    

                                      <td>
                                      <?=(customer($receiver,"email")!="")?'<a href="mailto:'.customer($receiver,"email").'">mail</a>':'';?> 
                                      </td>
                                      <td>
                                      <?=customer($receiver,"tel");?>
                                      </td>

                                      <td>
                                        <span style="color:#000; font-weight:bold;">Нийт online: <?=$data["count"];?>ш</span><br>
                                        <span style="color:#0F0; font-weight:bold;">Дүн бодогдоогүй: <?=$data["total_new"];?>ш</span><br>
                                        <span style="color:#F00; font-weight:bold;">Үнэ: <?=number_format($data["total_price"],2);?>$</span><br>
                                        <span style="color:#1079b2; font-weight:bold;">Tax: <?=number_format($data["total_tax"],2);?>$</span><br>
                                        <span style="color:#f0861b; font-weight:bold;">Shipping: <?=number_format($data["total_shipping"],2);?>$</span><br>
                                        <span style="color:#ff0000; font-weight:bold;">Дараа төлбөр: <?=number_format($data["total_owe"],2);?>$</span><br>
                                            <? 
                                            $total = $data["total_price"]+$data["total_tax"]+$data["total_shipping"]+$data["total_owe"];
                                            ?>
                                        <span style="color:#be0fce; font-weight:bold;font-size:14px;">Нийт: <?=number_format($total,2).'$ ('.number_format($total*cfg_rate());?>₮)</span><br>
                                      </td>
                                      
                                      <td>
                                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#online_detail_<?=$receiver;?>">Дэлгэх</button>
                                                          

                                        <div class="modal" tabindex="-1" role="dialog" id="online_detail_<?=$receiver;?>">
                                          <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title">Онлайн</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                <?
                                                    $sql_online="SELECT * FROM online";
                                                    $sql_online.=" WHERE status!='order' AND status!='later' AND status!='pending' AND customer_id='".$receiver."'";
                                                    $sql_online.=" ORDER BY created_date DESC";
                                                    
                                                    $result_single = mysqli_query($conn,$sql_online);
                                                    if (mysqli_num_rows($result_single) > 0)
                                                    {
                                                      ?>
                                                      <table class='table table-striped'>
                                                      
                                                        <tr><th>№</th><th>Үүсгэсэн</th><th>Үнэ</th><th>Коммент</th><th>Тайлбар</th><th>Үйлдэл</th></tr>
                                                        <?

                                                        $i=mysqli_num_rows($result_single);
                                                        while ($data_single = mysqli_fetch_array($result_single))
                                                        {  
                                                            $created_date=$data_single["created_date"];
                                                            $online_id=$data_single["online_id"];
                                                            $url=$data_single["url"]; 
                                                            $size=$data_single["size"]; 
                                                            $color=$data_single["color"];
                                                            $number=$data_single["number"];
                                                            $track=$data_single["track"];
                                                            $comment=$data_single["comment"];
                                                            $price=$data_single["price"];
                                                            $tax=$data_single["tax"];
                                                            $shipping=$data_single["shipping"];
                                                            $owe=$data_single["owe"];
                                                            $status=$data_single["status"];
                                                            $transport= $data_single["transport"];
                                                            $context= $data_single["context"];
                                                            ?>

                                                            
                                                            <tr>
                                                            <td><?=$i--;?></td>
                                                            <td><?=substr($created_date,0,10);?>
                                                            <?
                                                              if ($transport) echo "<br><span class='glyphicon glyphicon-home' title='Улаанбаатарт хүргэлттэй'></span> Хүргэлттэй"; 
                                                            ?>
                                                            </td>
                                                            
                                                            <td>
                                                              <a href='<?=$url;?>' target='_blank'><?=substr($url,0,20);?>".......</a><br>
                                                              <?=$number."/".$size."/".$color."<br>";?>

                                                              <span style="color:#F00; font-weight:bold;">Үнэ: <?=$price;?>$</span><br>
                                                              <span style="color:#1079b2; font-weight:bold;">Tax: <?=$tax;?>$</span><br>
                                                              <span style="color:#f0861b; font-weight:bold;">Shipping: <?=$shipping;?>$</span><br>
                                                              <span style="color:#ff0000; font-weight:bold;">Дараа төлбөр: <?=$owe;?>$</span>
                                                            <td><?=$comment;?></td>	
                                                            <td><?=$context;?></td>
                                                          
                                                              <td>
                                                              <a href="?action=price&id=<?=$online_id;?>" title="<?=$comment;?>" class="btn btn-xs btn-primary btn-shuurkhai w-100">Үнэ</a>
                                                              <br>
                                                              <a href="?action=comment&id=<?=$online_id;?>" title="<?=$comment;?>" class="btn btn-xs btn-primary btn-shuurkhai w-100">Бичих</a>
                                                              <br>
                                                              <a href="?action=renew&id=<?=$online_id;?>" title="Make it order!" class="btn btn-xs btn-success btn-shuurkhai w-100">Захиалга</a>
                                                              <br>
                                                              <a href="?action=online_pending&id=<?=$online_id;?>" title="Unpending!" class="btn btn-xs btn-success btn-shuurkhai w-100">Unpending</a>
                                                              <br>
                                                              <a href="?action=track_renew&id=<?=$online_id;?>" title="Only Give Track!" class="btn btn-xs btn-warning btn-shuurkhai w-100">Track</a>
                                                              <br>
                                                              <a href="?action=online_later&id=<?=$online_id;?>" title="Make later!" class="btn btn-xs btn-warning btn-shuurkhai w-100">Дараа болгох</a>
                                                              <br>
                                                              <a href="?action=delete&id=<?=$online_id;?>" title="Delete!" class="btn btn-xs btn-danger btn-shuurkhai w-100">Устгах</a>                            
                                                              
                                                              </td>
                                                            </tr>	
                                                            <?
                                                        }
                                                        ?>
                                                      </table>
                                                      <?
                                                    }
                                                ?>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>



                                      </td>
                                  
                                    </tr>
                                    <?                                  
                                }
                              
                              ?>
                            
                            </tbody>
                            <tfoot>
                              <tr><td>Нийт</td><td><?=$total_weight;?></td><td><?=$total_weight*cfg_paymentrate();?></td><td><?=$total_price;?></td><td></td></tr>
                            </tfoot>
                        </table>
                    </div>
                  </div>
              </div>
            </div>


            <?
          }
          ?>

          <?
          if ($action =="all_later")
          {
            
              $sql="SELECT * FROM online";
              $sql.=" WHERE status='later'";
              $sql.=" ORDER by online_id DESC";

              $result = mysqli_query($conn,$sql);

              if (mysqli_num_rows($result) > 0)
              {
                echo "<table class='table table-hover'>";
                echo "<tr><th>№</th><th>Огноо</th><th>Нэр/Утас</th><th>URL/Тоо/Хэмжээ/Өнгө</th><th>Үнэ</th><th>Коммент</th><th width='130'>Үйлдэл</th></tr>";
                $i=mysqli_num_rows($result);
                while ($data = mysqli_fetch_array($result))
                {  
                $created_date=$data["created_date"];
                $online_id=$data["online_id"];
                $url=$data["url"]; 
                $size=$data["size"]; 
                $color=$data["color"];
                $number=$data["number"];
                $receiver=$data["receiver"];
                $track=$data["track"];
                $comment=$data["comment"];
                $status=$data["status"];
                $title=$data["title"];
                $price=$data["price"];
                
                
                echo "<tr>";
                echo "<td>".$i--."</td>";
                echo "<td>".substr($created_date,0,10)."</td>";
                echo "<td>";
                echo '<a href="customer?action=detail&id='.$receiver.'">'.substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name").'</a>';

                if (customer($receiver,"email")!="") 
                echo '<a href="mailto:'.customer($receiver,"email").'">mail</a>';
                echo"<br>";
                echo customer($receiver,"tel")."</td>";	
                echo '<td><a href="'.$url.'" target="new">'.substr($url,0,20).'</a>.......<br>';
                echo $number."/".$size."/".$color."<br>";
                echo '</td>';
                echo '<td><span style="color:#F00; font-weight:bold;">'.$price.'$</span>'."</td>";	
                echo "<td>".$comment."</td>";	
                //echo "<td>".status_comfort($status)."</td>";
                echo "<td>";
                
                echo '<a href="?action=unlater&id='.$online_id.'">unlater</a><br>';
                echo '<a href="?action=delete&id='.$online_id.'">Delete</a>';

                  
                echo "</td>";
                echo "</tr>";	
                }
                echo "</table>";
              }
              else //$query->num_rows() ==0
              {
              echo '<div class="alert alert-danger" role="alert">Захиалга олдсонгүй.</div>';
              }
          }
          ?>

          <?
          if ($action == "online_later")
          {
            if (isset($_GET["id"])) $online_id = intval($_GET["id"]); else $online_id=0;

            $sql = "SELECT * FROM online WHERE online_id=".$online_id;
            $result = mysqli_query($conn,$sql);

            if (mysqli_num_rows($result) == 1)
            {
              if (mysqli_query($conn,"UPDATE online SET status='later' WHERE online_id=".$online_id))
              {
                ?>
                <div class="alert alert-success" role="alert">Online захиалгыг дараа болголоо.</div>
                <?
              }
              else 
              {
                ?>
                <div class="alert alert-success" role="alert">Алдаа:<?=mysqli_error($conn);?></div>
                <?
              }
            } 
            else 
            {
              ?>
              <div class="alert alert-success" role="alert">Алдаа: онлайн захиалга олдсонгүй</div>
              <?
            }             
          }
          ?>

          <?
          if ($action == "unlater")
          {
            if (isset($_GET["id"])) $online_id = intval($_GET["id"]); else $online_id=0;

            $sql = "SELECT * FROM online WHERE online_id=".$online_id;
            $result = mysqli_query($conn,$sql);

            if (mysqli_num_rows($result) == 1)
            {
              if (mysqli_query($conn,"UPDATE online SET status='online' WHERE online_id=".$online_id))
              {
                ?>
                <div class="alert alert-success" role="alert">Online захиалгыг одоо болголоо.</div>
                <?
              }
              else 
              {
                ?>
                <div class="alert alert-success" role="alert">Алдаа:<?=mysqli_error($conn);?></div>
                <?
              }
            } 
            else 
            {
              ?>
              <div class="alert alert-success" role="alert">Алдаа: онлайн захиалга олдсонгүй</div>
              <?
            }             
          }
          ?>


          <?
          if ($action == "delete")
          {
            if (isset($_GET["id"])) $online_id = intval($_GET["id"]); else $online_id=0;

            $sql = "SELECT * FROM online WHERE online_id=".$online_id;
            $result = mysqli_query($conn,$sql);

            if (mysqli_num_rows($result) == 1)
            {
              if (mysqli_query($conn,"DELETE FROM online WHERE online_id=".$online_id))
              {
                ?>
                <div class="alert alert-success" role="alert">Online захиалгыг амжилттай устгалаа.</div>
                <?
              }
              else 
              {
                ?>
                <div class="alert alert-success" role="alert">Алдаа:<?=mysqli_error($conn);?></div>
                <?
              }
            } 
            else 
            {
              ?>
              <div class="alert alert-success" role="alert">Алдаа: онлайн захиалга олдсонгүй</div>
              <?
            }             
          }
          ?>


          <?
          if ($action == "track_renew")
          {
            if (isset($_GET["id"])) $online_id = intval($_GET["id"]); else $online_id=0;

            $sql = "SELECT * FROM online WHERE online_id=".$online_id;

            $result = mysqli_query($conn,$sql);

            if (mysqli_num_rows($result) == 1)
            {
              ?>
              <form action="?action=track_renewing&id=<?=$online_id;?>" method="post">
                <div class="card">
                  <div class="card-body">
                    <h5>Трак олгох</h5>
                    <input type="text" placeholder="трак" name="track" required="required" class="form-control mt-3">
                    <button type="submit" class="btn btn-success mt-3">Трак олгох</button>
                  </div>
                </div>
              </form>
              <?
            } 
            else 
            {
              ?>
              <div class="alert alert-success" role="alert">Алдаа: онлайн захиалга олдсонгүй</div>
              <?
            }             
          }
          ?>

          
          <?
          if ($action == "track_renewing")
          {
            if (isset($_GET["id"])) $online_id = intval($_GET["id"]); else $online_id=0;
            $track = $_POST["track"];
           
            $sql = "SELECT * FROM online WHERE online_id=".$online_id;
            $result = mysqli_query($conn,$sql);

            if (mysqli_num_rows($result) == 1)
            {
              if (mysqli_query($conn,"UPDATE online SET status='later' WHERE online_id=".$online_id))
              {
                ?>
                <div class="alert alert-success" role="alert">Online захиалгыг дараа болголоо.</div>
                <?
              }
              else 
              {
                ?>
                <div class="alert alert-success" role="alert">Алдаа:<?=mysqli_error($conn);?></div>
                <?
              }
            } 
            else 
            {
              ?>
              <div class="alert alert-success" role="alert">Алдаа: онлайн захиалга олдсонгүй</div>
              <?
            }                  
          }
          ?>

          <?
          if ($action == "online_pending")
          {
            if (isset($_GET["id"])) $online_id = intval($_GET["id"]); else $online_id=0;

            $sql = "SELECT * FROM online WHERE online_id=".$online_id;
            $result = mysqli_query($conn,$sql);

            if (mysqli_num_rows($result) == 1)
              {
                $data = mysqli_fetch_array($result);
                if ($data["status"]=="pending")
                $sql = "UPDATE online SET status='regular' WHERE online_id=".$online_id;
                if ($data["status"]=="online" || $data["status"]=="regular")
                $sql = "UPDATE online SET status='pending' WHERE online_id=".$online_id;
                
                if (isset($sql))
                  {
                    if (mysqli_query($conn,$sql))
                    {
                      ?>
                      <div class="alert alert-success" role="alert">Online захиалгыг төлөвт өөрчлөлт орлоо.</div>
                      <?
                    }
                    else 
                    {
                      ?>
                      <div class="alert alert-success" role="alert">Алдаа:<?=mysqli_error($conn);?></div>
                      <?
                    }
                  }    
                  else 
                  {
                    ?>
                    <div class="alert alert-success" role="alert">Алдаа: төлөв буруу байна</div>
                    <?
                  }                  
              }
              else 
                {
                  ?>
                  <div class="alert alert-success" role="alert">Алдаа: онлайн захиалга олдсонгүй</div>
                  <?
                }        
          }
          ?>       

          <?
          if ($action =="renew")
          {
            if (isset($_GET["id"])) $online_id = intval($_GET["id"]); else $online_id=0;
            ?>
                          
              <div class="panel panel-primary">
                <div class="panel-heading">Илгээмж оруулах</div>
                <div class="panel-body">
                  <form action="?action=renewing&id=<?=$online_id;?>" method="post">
                    <? 
                        $sql = "SELECT * FROM online WHERE online_id=".$online_id;
                        $result = mysqli_query($conn,$sql);
            
                        if (mysqli_num_rows($result) == 1)
                          {              
                                $data = mysqli_fetch_array($result);    
                                $online_id=$data["online_id"];
                                $created_date=$data["created_date"];
                                $receiver=$data["receiver"];
                                $url=$data["url"];
                                $size=$data["size"];
                                $color=$data["color"];
                                $number=$data["number"];
                                $comment=$data["comment"];
                                $status=$data["status"];
                                $price=$data["price"];
                                $title=mysqli_escape_string($conn,$data["title"]);
                                ?>
                                <table class="table table-hover table-striped">
                                <tr><td colspan='2'><h4>Хүлээн авагч</h4></td></tr>
                                <tr><td>Нэр</td><td><input type="text" name="name" value="<?=customer($receiver,"name");?>" class="form-control" readonly></td></tr>
                                <tr><td>Овог</td><td><input type="text" name="name" value="<?=customer($receiver,"surname");?>" class="form-control" readonly></td></tr>
                                <tr><td>РД</td><td><input type="text" name="rd" value="<?=customer($receiver,"rd");?>" class="form-control" readonly></td></tr>
                                <tr><td>Утас</td><td><input type="text" name="contacts" value="<?=customer($receiver,"tel");?>" class="form-control" readonly></td></tr>
                                <tr><td>Э-мэйл</td><td><input type="text" name="email" value="<?=customer($receiver,"email");?>" class="form-control" readonly></td></tr>
                                <tr><td>Хаяг</td><td><input type="text" name="address" value="<?=customer($receiver,"address");?>" class="form-control" readonly></td></tr>


                              <tr><td>Барааны тайлбар</td>
                              <td>
                              <table class="table table-hover">
                                  <tr>
                                    <td><input type="text" name="package1_name" value="<?=$title;?>" placeholder="Цамц, Цүнх, Утас г.м" class="form-control"></td>
                                    <td><input type="text" name="package1_num" value="<?=$number;?>" placeholder="Тоо ширхэг" class="form-control"></td>
                                    <td><input type="text" name="package1_price" value="<?=$price;?>" placeholder="Үнэ ($)" class="form-control"></td>
                                  </tr>

                                  <tr>
                                    <td><input type="text" name="package2_name" value="" placeholder="Цамц, Цүнх, Утас г.м" class="form-control"></td>
                                    <td><input type="text" name="package2_num" value="" placeholder="Тоо ширхэг" class="form-control"></td>
                                    <td><input type="text" name="package2_price" value="" placeholder="Үнэ ($)" class="form-control"></td>
                                  </tr>

                                  <tr>
                                    <td><input type="text" name="package3_name" value="" placeholder="Цамц, Цүнх, Утас г.м" class="form-control"></td>
                                    <td><input type="text" name="package3_num" value="" placeholder="Тоо ширхэг" class="form-control"></td>
                                    <td><input type="text" name="package3_price" value="" placeholder="Үнэ ($)" class="form-control"></td>
                                  </tr>

                                  <tr>
                                    <td><input type="text" name="package4_name" value="" placeholder="Цамц, Цүнх, Утас г.м" class="form-control"></td>
                                    <td><input type="text" name="package4_num" value="" placeholder="Тоо ширхэг" class="form-control"></td>
                                    <td><input type="text" name="package4_price" value="" placeholder="Үнэ ($)" class="form-control"></td>
                                  </tr>

                              </table>                             
                              </td>
                              </tr> 
                              <tr><td>TRACK(*)</td><td><input type="text" name="track" class="form-control" required></td></tr>                             
                              </table>

                              <?
                          }
                        ?>
                        <button class="btn btn-success">Оруулах</button>
                  </form>
            <?
          }
          ?>

          <?
          if ($action =="renewing")
          {
            if (isset($_GET["id"])) $online_id = intval($_GET["id"]); else $online_id=0;
             
              $error=TRUE;
              $sql = "SELECT * FROM online WHERE online_id='".$online_id."'";
              $result = mysqli_query($conn,$sql);
  
              if (mysqli_num_rows($result) == 1)
                {          
                    $data=mysqli_fetch_array($result);
                    $online_id=$data["online_id"];
                    $created_date=$data["created_date"];
                    $receiver=$data["receiver"];
                    $url=$data["url"];
                    $size=$data["size"];
                    $color=$data["color"];
                    $number=$data["number"];
                    $comment=$data["comment"];
                    $title=$data["title"];
                    $price=$data["price"];
                    $status=$data["status"];
                    $transport=$data["transport"];

                    // $surname = $_POST["surname"];
                    // $rd = $_POST["rd"];
                    // $email = $_POST["email"];
                    // $address = $_POST["address"];

                    if (isset($_POST["admin_advance"])) $admin_value = $_POST["admin_value"]; else  $admin_value=0;


                    //$admin_advance = $_POST["admin_advance"];
                    // if (isset($_POST["admin_advance"])) $admin_value = $_POST["admin_value"]; else  $admin_value=0;
                    
                    // $sql_customer="UPDATE customer SET rd='$rd',surname='$surname',email='$email',address='$address' WHERE customer_id='$receiver' LIMIT 1";
                    // if (!$this->db->query($sql_customer)) $error=FALSE;

                    $sql_customer="SELECT no_proxy FROM customer WHERE customer_id='$receiver' LIMIT 1";
                    $result_customer = mysqli_query($conn,$sql_customer);
                    if (mysqli_num_rows($result_customer) == 1)
                    {
                      $data_customer=mysqli_fetch_array($result_customer);
                      $no_proxy=$data_customer["no_proxy"];
                    }
                    else $no_proxy=0;

                    
                    $sql_online="UPDATE online SET status='order',proceed_date='".date("Y-m-d H:i:s")."' WHERE online_id='$online_id' LIMIT 1";
                    if (!mysqli_query($conn,$sql_online)) $error=FALSE;
                    
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
                    $track = $_POST["track"];
                    $track = string_clean($track);
                    $track_eliminated = substr($track,-8,8);
                    
                    $proxy_id=0;
                    $proxy_type=0;

                    if ($no_proxy==0)
                    {
                      $sql_proxies = "SELECT * FROM proxies WHERE customer_id='$receiver' AND single=0 AND status=0 ORDER BY proxy_id DESC";
                      $result_proxies = mysqli_query($conn,$sql_proxies);
                      if (mysqli_num_rows($result_proxies)>0)
                        {
                          while ($data_proxies = mysqli_fetch_array($result_proxies))
                          {
                            $proxy_id = $data_proxies["proxy_id"];
                            $proxy_type = 0;
                            break;                            
                          }
                        }
                      // if ($proxy_id==0)
                      // {
                      // 	$query_proxies = $this->db->query('SELECT * FROM proxies_public WHERE status=0');
                      // 	//$proxy_available_id=0;
                      // 	if ($query_proxies->num_rows()>0)
                      // 		{
                      // 			foreach($query_proxies->result() as $row_proxy)
                      // 			{
                      // 				$proxy_id = $row_proxy -> proxy_id;
                      // 				$proxy_type = 0;
                      // 				break;
                      // 				//$order_proxy = $this->db->query('SELECT proxy_id FROM orders WHERE status NOT IN ("delivered","warehouse","custom","onair") AND proxy_type=1 AND proxy_id="'.$proxy_each.'"');
                              
                      // 				//$//combine_proxy = $this->db->query('SELECT proxy_id FROM box_combine WHERE  status NOT IN ("delivered","warehouse","custom","onair") AND proxy_id="'.$proxy_each.'" AND proxy_type=1');
                              
                      // 				//if ($order_proxy->num_rows() == 0 && $combine_proxy->num_rows()==0) 
                      // 				//{ $proxy_available_id= $proxy_each; break;echo $proxy_each;}
                      // 			}
                      // 		}
                      // 	//$proxy_id =$proxy_available_id;
                      // 	//$proxy_type=1;
                      // }
                    }
                    

                          
                          
                    /* ADVANCE */
                    //$Package_advance = $_POST["Package_advance"];
                    /*if (isset($_POST["Package_advance"])) 
                      {
                      $Package_advance=1;
                      $Package_advance_value = round($_POST["Package_advance_value"],2);
                      }
                      else 
                      {
                      $Package_advance=0;
                      $Package_advance_value="";
                      }
                    */
                    $barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
                    do {
                          $barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
                          $result_barcode =mysqli_query($conn,"SELECT order_id FROM orders WHERE barcode='$barcode'");
                        } while (mysqli_num_rows($result_barcode) == 1); 


                    $result_proxy = mysqli_query($conn,"SELECT * FROM orders WHERE receiver='$receiver' AND proxy_id=0 AND status NOT IN ('delivered','warehouse','custom','onair')");
                    if (mysqli_num_rows($result_proxy) == 0) 
                    {
                      $proxy_id =0;
                      $proxy_type =0;
                    }

                    $status="weight_missing";
                    
                    $sql = "INSERT INTO orders (created_date,barcode,package,sender,receiver,price,advance,advance_value,third_party,proxy_id,proxy_type,status,is_online,owner,transport) 
                    VALUES ('$created_date','$barcode','$package','".USA_OFFICE_id."','$receiver','$package_price',1,'$admin_value','$track','$proxy_id','$proxy_type','$status',1,3,'$transport')";
                      if ($error)
                      if (mysqli_query($conn,$sql)) 
                      {
                        $order_id=mysqli_insert_id($conn);	
                        mysqli_query($conn,"UPDATE online SET status='order',track='$track' WHERE online_id='$online_id' LIMIT 1");
                        echo '<div class="alert alert-success" role="alert">Илгээмжийг орууллаа</div>';
                        proxy_available($proxy_id,$proxy_type,1);
                      }
                      else 
                      {
                        echo '<div class="alert alert-danger" role="alert">Error:'.mysqli_error($conn).'</span>';
                        $error=FALSE;
                      }
                }
                else echo '<div class="alert alert-danger" role="alert">Илгээмж олдсонгүй</span>';                
          }
          ?>

          <?
          if ($action == "comment")
          {
            if (isset($_GET["id"])) $online_id = intval($_GET["id"]); else $online_id=0;

            $sql = "SELECT * FROM online WHERE online_id=".$online_id;

            $result = mysqli_query($conn,$sql);

            if (mysqli_num_rows($result) == 1)
            {
              ?>
              <form action="?action=commenting&id=<?=$online_id;?>" method="post">
                <div class="card">
                  <div class="card-body">
                    <h5>Тайлбар бичих</h5>
                    <textarea name="comment" placeholder="тайлбар" required required="required" class="form-control mt-3" style="height:100px"></textarea>
                    <button type="submit" class="btn btn-success mt-3">Бичих</button>
                  </div>
                </div>
              </form>
              <?
            } 
            else 
            {
              ?>
              <div class="alert alert-success" role="alert">Алдаа: онлайн захиалга олдсонгүй</div>
              <?
            }             
          }
          ?>

          
          <?
          if ($action == "commenting")
          {
            if (isset($_GET["id"])) $online_id = intval($_GET["id"]); else $online_id=0;
            $comment = mysqli_escape_string($conn,$_POST["comment"]);
           
            $sql = "SELECT * FROM online WHERE online_id=".$online_id;
            $result = mysqli_query($conn,$sql);

            if (mysqli_num_rows($result) == 1)
            {
              if (mysqli_query($conn,"UPDATE online SET comment ='$comment' WHERE online_id=".$online_id))
              {
                ?>
                <div class="alert alert-success" role="alert">Амжилттай тэмдэглэлээ.</div>
                <?
              }
              else 
              {
                ?>
                <div class="alert alert-success" role="alert">Алдаа:<?=mysqli_error($conn);?></div>
                <?
              }
            } 
            else 
            {
              ?>
              <div class="alert alert-success" role="alert">Алдаа: онлайн захиалга олдсонгүй</div>
              <?
            }                  
          }
          ?>

          <?
          if ($action =="price")
          {
            if (isset($_GET["id"])) $online_id = intval($_GET["id"]); else $online_id=0;

            $sql = "SELECT * FROM online WHERE online_id=".$online_id;

            $result = mysqli_query($conn,$sql);

            if (mysqli_num_rows($result) == 1)
            {
              $data = mysqli_fetch_array($result);
              $comment = $data["comment"];
              $price = $data["price"];
              $tax = $data["tax"];
              $shipping = $data["shipping"];
              $owe = $data["owe"];
              $owe = $data["owe"];
              ?>
              <form action="?action=pricing&id=<?=$online_id;?>" method="post">
                
            
              Бодит үнэ:<input type="text" name="price" class="form-control" value="<?=$price;?>" placeholder="бодит үнэ"><br>
              Тах:<input type="text" name="tax" class="form-control" value="<?=$tax;?>" placeholder="Тах"><br>
              Shipping:<input type="text" name="shipping" class="form-control" value="<?=$shipping;?>" placeholder="Shipping"><br>
              Дараа төлбөр:<input type="text" name="owe" class="form-control" value="<?=$owe;?>" placeholder="Дараа төлбөр"><br>

              <button class="btn btn-success" type="submit">Оруулах</button>
              </form>
              <?
            }            
            else 
            {
              ?>
              <div class="alert alert-success" role="alert">Алдаа: онлайн захиалга олдсонгүй</div>
              <?
            }             

          }
          ?>

          <?
          if ($action == "pricing")
          {
            if (isset($_GET["id"])) $online_id = intval($_GET["id"]); else $online_id=0;

            if ($_POST["tax"]!="")   $tax=$_POST["tax"]; else  $tax="";
            if ($_POST["shipping"]!="") $shipping=$_POST["shipping"]; else  $shipping="";
            if ($_POST["owe"]!="") $owe=$_POST["owe"]; else  $owe="";
            if ($_POST["price"]=="" || $_POST["price"]==0) $new=1; else $new=0;
          
            if ($_POST["price"]!="")   $price=$_POST["price"]; else  $price=0;


            $sql = "SELECT * FROM online WHERE online_id=".$online_id;
            $result = mysqli_query($conn,$sql);

            if (mysqli_num_rows($result) == 1)
            {
              $data = mysqli_fetch_array($result);
              $customer_id = $data["customer_id"];
              $total = $price + $tax+ $shipping;

              if (mysqli_query($conn,"UPDATE online SET price = '$price', tax='$tax', shipping='$shipping',owe='$owe',new='$new' WHERE online_id=$online_id LIMIT 1"))
              {
                ?>
                <div class="alert alert-success" role="alert">Үнийг амжилттай орууллаа.</div>
                <?
                mysqli_query($conn,"INSERT INTO alert (customer_id,context,target) VALUES ('$customer_id','Cагсанд дахь барааны үнэ бодогдож $total $ болсон','online')");                      
              }
              else 
              {
                ?>
                <div class="alert alert-success" role="alert">Алдаа:<?=mysqli_error($conn);?></div>
                <?
              }
            } 
            else 
            {
              ?>
              <div class="alert alert-success" role="alert">Алдаа: онлайн захиалга олдсонгүй</div>
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
  <script src="assets/js/data-table.js"></script>
  <script src="assets/js/jquery.chained.min.js"></script>

	<!-- endinject -->

</body>
</html>    