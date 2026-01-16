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
			<?
			if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="init";?>
			<?
			switch ($action)
			{
				case "init": $action_title="Бүх тайлангийн жагсаалт";break;
				case "report1": $action_title="Гардуулалтын тайлан /Бэлэн/";break;
				case "report2": $action_title="Гардуулалтын тайлан /Дараа/";break;
				case "report3": $action_title="Гардуулалтын тайлан Сансар";break;
				case "report4": $action_title="Хашбал тайлан";break;
				case "report5": $action_title="Агуулахын тайлан";break;
				case "report6": $action_title="Хүргэлтийн тайлан";break;
				case "report7": $action_title="Дараа тооцооны тайлан";break;
			}
			?>
			<nav class="page-breadcrumb">
				<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="reports">Тайлан</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$action_title;?></li>
				</ol>
			</nav>


			
			<?
			if ($action =="init")
			{
				?>
				<div class="row">
          <div class="col-12 col-xl-12 stretch-card">
            <div class="card">
              <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th>№</th>
                      <th>Тайлангийн нэр</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr><td>1</td><td><a href="?action=report1">Гардуулалтын тайлан /Бэлэн/</a> </td></tr>
                    <tr><td>2</td><td><a href="?action=report2">Гардуулалтын тайлан /Дараа/</a> </td></tr>
                    <tr><td>3</td><td><a href="?action=report3">Гардуулалтын тайлан /Админ/</a> </td></tr>
                    <tr><td>4</td><td><a href="?action=report4">Хашбал тайлан</a> </td></tr>
                    <tr><td>5</td><td><a href="?action=report5">Агуулахын тайлан</a> </td></tr>
                    <tr><td>6</td><td><a href="?action=report6">Хүргэлтийн тайлан</a> </td></tr>
                    <tr><td>7</td><td><a href="?action=report7">Дараа тооцооны тайлан</a> </td></tr>                  
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>        
				<?
			}
			?>

			<?
			if ($action =="report1")
			{
          $grand_total = 0;
          if (isset($_POST["method_type"])) $method_type=$_POST["method_type"]; else $method_type='all';
          
          if(isset($_POST["start_date"])) 
          $start_date = date("Y-m-d", strtotime($_POST["start_date"]))." 00:00:00";
          else $start_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -3 days'))." 00:00:00";
          
          if(isset($_POST["finish_date"])) 
          $finish_date = date("Y-m-d", strtotime($_POST["finish_date"]))." 23:59:00";
          else $finish_date = date("Y-m-d")." 23:59:00";
          
          
        ?>
        <div class="row">
             
          <div class="col-12 col-xl-12">
            <div class="card">
              <div class="card-body">
                <form action="?action=report1" method="post">
                  <div class="input-group">
                    <input type="date" class="form-control" name="start_date" value="<?=substr($start_date,0,10);?>">
                    <input type="date" class="form-control" name="finish_date" value="<?=substr($finish_date,0,10);?>">
                    <select  name="method_type" class="form-control">
                      <option value="all" <?=($method_type=="all")?'SELECTED':'';?> >Бүгдийг</option>
                      <option value="cash"  <?=($method_type=="cash")?'SELECTED':'';?>>Бэлэн</option>
                      <option value="account" <?=($method_type=="account")?'SELECTED':'';?>>Банкаар</option>
                      <option value="pos" <?=($method_type=="pos")?'SELECTED':'';?>>POS</option>
                      <!-- <option value="later">Дараа тооцоо</option> -->
                      <option value="mix" <?=($method_type=="mix")?'SELECTED':'';?>>Холимог</option>				 
                    </select>
                    <button type="submit" class="btn btn-primary mr-2">Хайх</button>
                  </div>
                </form>
              </div>
            </div>

            <?
            
             
             $sql = "SELECT * FROM orders WHERE (status='delivered' OR status='custom')";
             
             if ($method_type!="all") $sql.=" AND orders.method ='$method_type'";
             if ($start_date!="")  $sql.=" AND delivered_date>'$start_date'";
             if ($finish_date!="")  $sql.=" AND delivered_date<'$finish_date'";
             
             $sql.=" GROUP BY deliver";
          
            ?>

            <div class="card mt-3">
              <div class="card-body">
                <table id="report_table" class="table">
                  <thead>
                    <tr>
                      <th>№</th>
                      <th>Гардагч</th>
                      <th>Утас</th>
                      <th>Barcode</th>
                      <th>Ширхэг</th>
                      <th>Жин</th>
                      <th>Төлбөр /$/</th>
                      <th>Төрөл</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?
                    $result = mysqli_query($conn,$sql);
                    $count=1;$total_weight=0;$total_price=0;$total_payment=0;$method="";
                    while ($data = mysqli_fetch_array($result))
                      {  
                      $deliver = $data["deliver"];
                      $customer_name=customer($deliver,"name");
                      $customer_tel=customer($deliver,"tel");
                      
                      $barcodes_array =array();
                      $weight=0;
                      $weight_noooo=0;
                      $advance=0;
                      $admin=0;
                      $price=0;
                      $total_mix = 0;
                      $total_account = 0;
                      $total_cash= 0;
                      $total_pos= 0;
                      
                      
                      $sql_detail = "SELECT * FROM orders WHERE (status='delivered' OR status='custom') AND deliver='$deliver'";
                      if ($method_type=="all")   $sql_detail.=" AND orders.method <>'later'";
                      if ($method_type!="all") $sql_detail.=" AND orders.method ='$method_type' AND orders.method <>'later'";
                      if ($start_date!="")  $sql_detail.=" AND delivered_date>'$start_date'";
                      if ($finish_date!="")  $sql_detail.=" AND delivered_date<'$finish_date'";
                
                    	// echo "<br>".$sql_detail;
                      $result_detail = mysqli_query($conn,$sql_detail);
                      
                      while ($data_detail = mysqli_fetch_array($result_detail))
                        {  
                        array_push ($barcodes_array, $data_detail["barcode"]);
                        if ($data_detail["is_online"] == 0)
                          {
                          $advance+=floatval($data_detail["advance_value"]);
                          $weight_noooo +=$data_detail["weight"];
                          }
                        if ($data_detail["is_online"] == 1)
                          {
                          $admin+=$data_detail["admin_value"];
                          $weight+=$data_detail["weight"];
                          }
                        $method=$data["method"];
                        }

                      $total_payment = $advance+$admin+cfg_price($weight);
                    if ($method=="mix") $method="хувааж";
                    if ($method=="account") $method="дансаар";
                    //if ($method=="later") $method="дараа";
                    if ($method=="cash") $method="бэлэн";
                    if ($method=="pos") $method="пос";
                    if ($total_payment>0)
                      {
                        echo "<tr>";
                        echo "<td>".$count."</td>"; 
                        echo "<td>".$customer_name."</td>"; 
                        echo "<td>".$customer_tel."</td>"; 
                        echo "<td> ".implode(", <br>",$barcodes_array)."</td>"; 
                        echo "<td>".count($barcodes_array)."</td>"; 
                        echo "<td>";
                        echo $weight_noooo + $weight;
                        echo "</td>";
                        echo "<td>".$total_payment."</td>";
                      echo "<td>".$method."</td>";
                        
                        echo "</tr>";
                        $grand_total +=$total_payment;
                        // array_push($data,array($count,$customer_name,$customer_tel,implode(", ",$barcodes_array),count($barcodes_array),$weight_noooo + $weight,$total_payment,$method));	
                      $count++;
                      }
                    $method="";
                      
                  
                    } 
                    ?>
                  </tbody>
                  <tfoot>
                    <tr><td colspan='6'>Нийт</td><td><?=$grand_total;?></td><td></td></tr>
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
			if ($action =="report2")
			{
        $grand_total = 0;
        
        if(isset($_POST["start_date"])) 
        $start_date = date("Y-m-d", strtotime($_POST["start_date"]))." 00:00:00";
        else $start_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -3 days'))." 00:00:00";
        
        if(isset($_POST["finish_date"])) 
        $finish_date = date("Y-m-d", strtotime($_POST["finish_date"]))." 23:59:00";
        else $finish_date = date("Y-m-d")." 23:59:00";
        
        
        ?>
        <div class="row">
            
          <div class="col-12 col-xl-12">
            <div class="card">
              <div class="card-body">
                <form action="?action=report1" method="post">
                  <div class="input-group">
                    <input type="date" class="form-control" name="start_date" value="<?=substr($start_date,0,10);?>">
                    <input type="date" class="form-control" name="finish_date" value="<?=substr($finish_date,0,10);?>">
                    <button type="submit" class="btn btn-primary mr-2">Хайх</button>
                  </div>
                </form>
              </div>
            </div>

            <?
            
            
            $sql = "SELECT * FROM orders WHERE (status='delivered' OR status='custom')";
            
            $sql.=" AND orders.method ='later'";
            if ($start_date!="")  $sql.=" AND delivered_date>'$start_date'";
            if ($finish_date!="")  $sql.=" AND delivered_date<'$finish_date'";
            
            $sql.=" GROUP BY deliver";
          
            ?>

            <div class="card mt-3">
              <div class="card-body">
                <table id="report_table" class="table">
                  <thead>
                    <tr>
                      <th>№</th>
                      <th>Гардагч</th>
                      <th>Утас</th>
                      <th>Barcode</th>
                      <th>Ширхэг</th>
                      <th>Жин</th>
                      <th>Төлбөр /$/</th>
                      <th>Төрөл</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?
                    $result = mysqli_query($conn,$sql);
                    $count=1;$total_weight=0;$total_price=0;$total_payment=0;$method="";
                    while ($data = mysqli_fetch_array($result))
                      {  
                      $deliver = $data["deliver"];
                      $customer_name=customer($deliver,"name");
                      $customer_tel=customer($deliver,"tel");
                      
                      $barcodes_array =array();
                      $weight=0;
                      $weight_noooo=0;
                      $advance=0;
                      $admin=0;
                      $price=0;
                      $total_mix = 0;
                      $total_account = 0;
                      $total_cash= 0;
                      $total_pos= 0;
                      
                      
                      $sql_detail = "SELECT * FROM orders WHERE (status='delivered' OR status='custom') AND deliver='$deliver'";
                      $sql_detail.=" AND orders.method ='later'";
                      if ($start_date!="")  $sql_detail.=" AND delivered_date>'$start_date'";
                      if ($finish_date!="")  $sql_detail.=" AND delivered_date<'$finish_date'";
                
                      // echo "<br>".$sql_detail;
                      $result_detail = mysqli_query($conn,$sql_detail);
                      
                      while ($data_detail = mysqli_fetch_array($result_detail))
                        {  
                        array_push ($barcodes_array, $data_detail["barcode"]);
                        if ($data_detail["is_online"] == 0)
                          {
                          $advance+=floatval($data_detail["advance_value"]);
                          $weight_noooo +=$data_detail["weight"];
                          }
                        if ($data_detail["is_online"] == 1)
                          {
                          $admin+=$data_detail["admin_value"];
                          $weight+=$data_detail["weight"];
                          }
                        $method=$data["method"];
                        }

                      $total_payment = $advance+$admin+cfg_price($weight);
                    if ($method=="mix") $method="хувааж";
                    if ($method=="account") $method="дансаар";
                    //if ($method=="later") $method="дараа";
                    if ($method=="cash") $method="бэлэн";
                    if ($method=="pos") $method="пос";
                    if ($total_payment>0)
                      {
                        echo "<tr>";
                        echo "<td>".$count."</td>"; 
                        echo "<td>".$customer_name."</td>"; 
                        echo "<td>".$customer_tel."</td>"; 
                        echo "<td> ".implode(", <br>",$barcodes_array)."</td>"; 
                        echo "<td>".count($barcodes_array)."</td>"; 
                        echo "<td>";
                        echo $weight_noooo + $weight;
                        echo "</td>";
                        echo "<td>".$total_payment."</td>";
                      echo "<td>".$method."</td>";
                        
                        echo "</tr>";
                        $grand_total +=$total_payment;
                        // array_push($data,array($count,$customer_name,$customer_tel,implode(", ",$barcodes_array),count($barcodes_array),$weight_noooo + $weight,$total_payment,$method));	
                      $count++;
                      }
                    $method="";
                      
                  
                    } 
                    ?>
                  </tbody>
                  <tfoot>
                    <tr><td colspan='6'>Нийт</td><td><?=$grand_total;?></td><td></td></tr>
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
			if ($action =="report3")
			{
        $grand_total = 0;
        if (isset($_POST["method_type"])) $method_type=$_POST["method_type"]; else $method_type='all';
        
        if(isset($_POST["start_date"])) 
        $start_date = date("Y-m-d", strtotime($_POST["start_date"]))." 00:00:00";
        else $start_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -3 days'))." 00:00:00";
        
        if(isset($_POST["finish_date"])) 
        $finish_date = date("Y-m-d", strtotime($_POST["finish_date"]))." 23:59:00";
        else $finish_date = date("Y-m-d")." 23:59:00";
        
        
        ?>
        <div class="row">
            
          <div class="col-12 col-xl-12">
            <div class="card">
              <div class="card-body">
                <form action="?action=report3" method="post">
                  <div class="input-group">
                    <input type="date" class="form-control" name="start_date" value="<?=substr($start_date,0,10);?>">
                    <input type="date" class="form-control" name="finish_date" value="<?=substr($finish_date,0,10);?>">
                    <select  name="method_type" class="form-control">
                      <option value="all" <?=($method_type=="all")?'SELECTED':'';?> >Бүгдийг</option>
                      <option value="cash"  <?=($method_type=="cash")?'SELECTED':'';?>>Бэлэн</option>
                      <option value="account" <?=($method_type=="account")?'SELECTED':'';?>>Банкаар</option>
                      <option value="pos" <?=($method_type=="pos")?'SELECTED':'';?>>POS</option>
                      <option value="later">Дараа тооцоо</option>
                      <option value="mix" <?=($method_type=="mix")?'SELECTED':'';?>>Холимог</option>				 
                    </select>
                    <button type="submit" class="btn btn-primary mr-2">Хайх</button>
                  </div>
                </form>
              </div>
            </div>

            <?
            
            $sql = "SELECT * FROM bills WHERE timestamp>'$start_date' AND timestamp<'$finish_date'";
            // echo $sql;

            if ($method_type!="all") $sql.=" AND type ='$method_type'";

            $result = mysqli_query($conn,$sql);
            ?>

            <div class="card mt-3">
              <div class="card-body">
                <table id="report_table" class="table">
                  <thead>
                    <tr>
                      <th>№</th>
                      <th>Хугацаа</th>
                      <th>Нэр</th>
                      <th>Barcode</th>
                      <th>Ширхэг</th>
                      <th>Жин</th>	   
                      <th>Бэлэн</th>
                      <th>POS</th>                      
                      <th>Дансаар</th>                      
                      <th>Дараа тооцоо</th>
                      <th>Илгээмж</th>
                      <th>Нийт</th>
                      <th>Тулгалт</th>
                    
                    </tr>
                  </thead>
                  <tbody>
                    <?
                    $count=1;$total_cash=0;$total_pos=0;$total_account=0;$total_later=0;$total_total=0;$total_shirheg=0;$total_weight=0;
                    // $data = array(array('№','Хугацаа','Х/авагч','Утас','Barcode','Ширхэг','Жин','Бэлэн','POS','Дансаар','Дараа тооцоо','Нийт','Тулгалт'));
                   while ($data = mysqli_fetch_array($result))
                      {  
                        $deliver = $data["deliver"];
                        $bill_id = $data["id"];
                        $customer_name=customer ($deliver,"name");
                        $customer_tel=customer ($deliver,"tel");
                        $barcode = $data["barcode"];
                        $barcodes_array =explode(',',$barcode);
                        $weight = $data["weight"];
                        $cash=$data["cash"];
                        $pos=$data["pos"];
                        $account=$data["account"];
                        $later=$data["later"];
                        $total=$data["total"];
                        $advance=$data["advance"];
                        $timestamp=$data["timestamp"];
                        $shirheg = count($barcodes_array);
                        $weight_tulgalt = $weight;
                  
                        if ($weight!=0) $tulgalt = cfg_price($weight_tulgalt)*cfg_rate(); 
                          {
                            foreach($barcodes_array as $barcode_single)
                            {
                              $weight_tulgalt+=floatval(barcode_search($barcode_single,"weight"));
                            }
                            $tulgalt = cfg_price($weight_tulgalt)*cfg_rate(); 
                          }
                  
                          echo "<tr>";
                          echo "<td>".$bill_id."</td>"; 
                          echo "<td>".$timestamp."</td>"; 
                          echo "<td>".$customer_name."</td>"; 
                          echo "<td>".implode(",<br>", $barcodes_array)."</td>"; 
                          
                          echo "<td>".$shirheg."</td>"; 
                          echo "<td>".$weight."</td>"; 
                          echo "<td>".number_format(floatval($cash))."</td>";
                          echo "<td>".number_format(floatval($pos))."</td>";
                          echo "<td>".number_format(floatval($account))."</td>";
                          echo "<td>".number_format(floatval($later))."</td>";
                          echo "<td>".number_format(floatval($advance))."</td>";
                          echo "<td>".number_format(floatval($total))."</td>";
                          echo "<td>".number_format(floatval($tulgalt))."</td>";
                          echo "</tr>";
                          $total_cash+=floatval($cash);$total_pos+=floatval($pos);$total_account+=floatval($account);$total_later+=floatval($later);$total_total+=floatval($total);$total_shirheg+=floatval($shirheg);$total_weight+=floatval($weight);
                          //  array_push($data,array($count,$timestamp,$customer_name,$customer_tel,$barcode,$shirheg,floatval($weight),floatval($cash),floatval($pos),floatval($account),floatval($later),floatval($total),floatval($tulgalt)));	
                          $count++;
                      } 
                    ?>
                  </tbody>
                  <tfoot>
                    <tr><td colspan='4'>Нийт</td><td><?=number_format($total_shirheg);?></td><td><?=number_format($total_weight);?></td><td><?=number_format($total_cash);?></td><td><?=number_format($total_pos);?></td><td><?=number_format($total_account);?></td><td><?=number_format($total_later);?></td><td><?=number_format($total_total);?></td><td></td></tr>                    
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
			if ($action =="report4")
			{
        $grand_total = 0;

        $total_account = 0;
        $total_pos = 0;
        $total_cash = 0;
        $total_later = 0;
        $total_weight = 0;
        $total_advance = 0;
        $total_count=0;

        if (isset($_POST["method_type"])) $method_type=$_POST["method_type"]; else $method_type='all';
        
        if(isset($_POST["start_date"])) 
        $start_date = date("Y-m-d", strtotime($_POST["start_date"]))." 00:00:00";
        else $start_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -3 days'))." 00:00:00";
        
        if(isset($_POST["finish_date"])) 
        $finish_date = date("Y-m-d", strtotime($_POST["finish_date"]))." 23:59:00";
        else $finish_date = date("Y-m-d")." 23:59:00";
        
        
        ?>
        <div class="row">
            
          <div class="col-12 col-xl-12">
            <div class="card">
              <div class="card-body">
                <form action="?action=report4" method="post">
                  <div class="input-group">
                    <input type="date" class="form-control" name="start_date" value="<?=substr($start_date,0,10);?>">
                    <input type="date" class="form-control" name="finish_date" value="<?=substr($finish_date,0,10);?>">
                    <select  name="method_type" class="form-control">
                      <option value="all" <?=($method_type=="all")?'SELECTED':'';?> >Бүгдийг</option>
                      <option value="cash"  <?=($method_type=="cash")?'SELECTED':'';?>>Бэлэн</option>
                      <option value="account" <?=($method_type=="account")?'SELECTED':'';?>>Банкаар</option>
                      <option value="pos" <?=($method_type=="pos")?'SELECTED':'';?>>POS</option>
                      <option value="later">Дараа тооцоо</option>
                      <option value="mix" <?=($method_type=="mix")?'SELECTED':'';?>>Холимог</option>				 
                    </select>
                    <button type="submit" class="btn btn-primary mr-2">Хайх</button>
                  </div>
                </form>
              </div>
            </div>

            <?
            
            $sql = "SELECT * FROM (
            SELECT id,timestamp,deliver,barcode,weight,count,cash,account,pos,later,total FROM `bills` 
            UNION
            SELECT id,timestamp,deliver,barcode,weight,count,cash,account,pos,later,total FROM `bills_container` )  a
            WHERE timestamp>='$start_date' AND timestamp<='$finish_date'";

            $result = mysqli_query($conn,$sql);
            ?>

            <div class="card mt-3">
              <div class="card-body">
                <table id="report_table" class="table">
                  <thead>
                    <tr>
                      <th>№</th>
                      <th>Гардагч</th>
                      <th>Утас</th>
                      <th>Жин</th>
                      <th>Тоо</th>
                      <th>Данс</th>
                      <th>Пос</th>
                      <th>Бэлэн</th>
                      <th>Дараа тооцоо</th>
                      <th>Илгээмж тооцоо</th>
                      <th>Нийт</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?
                    while ($data = mysqli_fetch_array($result))
                    {  
                      $deliver = $data["deliver"];
                      $customer_name=customer ($deliver,"name");
                      $customer_tel=customer ($deliver,"tel");
                      $barcodes_array = $data["barcode"];
                      $barcode = $data["barcode"];
                      $barcodes_array =explode(',',$barcode);
                      $shirheg = count($barcodes_array);

                      $bill_id=$data["id"];
                      $weight=$data["weight"];
                      $count=$data["count"];
                      $account  = floatval($data["account"]);
                      $pos  = floatval($data["pos"]);			
                      $cash  = floatval($data["cash"]);			
                      $later  = floatval($data["later"]);			
                      $advance  = floatval($data["advance"]);		
                      $total  = floatval($data["total"]);		
                      $timestamp  = $data["timestamp"];		


                      echo "<tr>";
                      echo "<td>".$bill_id."</td>"; 
                      echo "<td>".$customer_name."</td>"; 
                      echo "<td>".$customer_tel."</td>"; 
                      //echo "<td>".$barcodes_array."</td>"; 
                      echo "<td>".$weight."</td>"; 
                      echo "<td>".$count."</td>"; 
                      echo "<td align='right'>".number_format($account)."</td>"; 
                      echo "<td align='right'>".number_format($pos)."</td>"; 
                      echo "<td align='right'>".number_format($cash)."</td>"; 
                      echo "<td align='right'>".number_format($later)."</td>"; 
                      echo "<td align='right'>".number_format($advance)."</td>";
                      echo "<td align='right'>".number_format($total)."</td>";
                      echo "</tr>";
                      $grand_total +=$total;
                      $total_count +=$count;
                      $total_account +=$account;
                      $total_pos +=$pos;
                      $total_cash +=$cash;
                      $total_later +=$later;
                      $total_weight +=$weight;
                      $total_advance +=$advance;
                    } 
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan='3'>Нийт</td>
                      <td><?=$total_weight;?></td>
                      <td><?=$total_count;?></td>
                      <td align='right'><?=number_format($total_account);?></td>
                      <td align='right'><?=number_format($total_pos);?></td>
                      <td align='right'><?=number_format($total_cash);?></td>
                      <td align='right'><?=number_format($total_later);?></td>
                      <td align='right'><?=number_format($total_advance);?></td>
                      <td align='right'><?=number_format($grand_total);?></td>
                    </tr>
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
			if ($action =="report5")
			{
        $total_weight = 0;
        $count=1;

        
        
        ?>
          <div class="row">                    
            <?            
            $sql = "SELECT * FROM orders WHERE status='warehouse' ORDER BY deliver";


            $result = mysqli_query($conn,$sql);
            ?>
            <div class="col-lg-12">
              <div class="card mt-3">
                <div class="card-body">
                  <table id="report_table" class="table">
                    <thead>
                      <tr>
                        <th>№</th>
                        <th>Хүлээн авагч</th> 
                        <th>Пайзын нэр</th> 
                        <th>Пайзын Утас</th> 
                        <th>Barcode</th>
                        <th>Тавиур</th>
                        <th>Жин</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?
                      while ($data = mysqli_fetch_array($result))
                      {  
                        $deliver = $data["deliver"];
                        $barcode = $data["barcode"];
                        $proxy_type = $data["proxy_type"];
                        $proxy_id = $data["proxy_id"];
                        $weight = $data["weight"];
                        $warehouse_date = $data["warehouse_date"];
                        $extra = $data["extra"];
                        $customer_name=customer ($deliver,"name");
                        $customer_tel=customer ($deliver,"tel");
                        $proxy_name=proxy2($proxy_id,$proxy_type,"name");
                        $proxy_tel=proxy2($proxy_id,$proxy_type,"tel");
  
  
                        echo "<tr>";
                        echo "<td>".$count++."</td>"; 
                        echo "<td>".$customer_name."</td>"; 
                        echo "<td>".$proxy_name."</td>"; 
                        echo "<td>".$proxy_tel."</td>"; 
                        echo "<td>".$barcode."</td>"; 
                        echo "<td>".$extra."-р тавиур</td>"; 
                        echo "<td>".$weight."</td>"; 
                        echo "</tr>";
  
                        $total_weight +=$weight;
                      } 
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <tr><td colspan='6'>Нийт</td><td><?=$total_weight;?></td></tr>
                      </tr>
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
			if ($action =="report6")
			{

        ?>
        Тун удахгүй
        <?      
      }
			?>

      <?
			if ($action =="report7")
			{
          $total_final = $total_dept=$total_payment=0;

        ?>
        <div class="row">
             
          <div class="col-12 col-xl-12">           
            <?
            
             
             $sql = "SELECT later_payment.* 
              FROM `later_payment`, 
            (SELECT d_customer,MAX(id) max_id FROM `later_payment` GROUP BY d_customer) as `latest` 
              WHERE later_payment.d_customer= latest.d_customer 
                AND later_payment.id= latest.max_id
                AND later_payment.final_balance>0";

            ?>

            <div class="card mt-3">
              <div class="card-body">
                <table id="report_table" class="table">
                  <thead>
                    <tr>
                      <th>Огноо</th>
                      <th>Харилцагч</th>
                      <th>Утас</th>
                      <th>Төлсөн</th>
                      <th>Үлдэгдэл</th>
                      <th>Тайлбар</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?
                  

                    $result = mysqli_query($conn,$sql);
                    while ($data = mysqli_fetch_array($result))
                      {  
                          echo "<tr>";
                          echo "<td>".$data["date"]."</td>"; 
                          echo "<td>".customer($data["d_customer"],"name")."</td>"; 
                          echo "<td>".customer($data["d_customer"],"tel")."</td>"; 
                          echo "<td>".$data["payment"]."</td>"; 
                          echo "<td>".$data["final_balance"]."</td>"; 
                          echo "<td>".str_replace(",",",<br>",$data["description"])."</td>"; 
                          echo "</tr>";

                          $total_final+=$data["final_balance"];					
                      
                    
                      } 
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>						
                        <td colspan='4'>Нийт</td>
                        <td><?=$total_final;?></td>
					   	          <td></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?
       
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
        pageLength: 100,
        lengthMenu: [100, 250, 500, { label: 'Бүгд', value: -1 }],
        layout: {
           topStart: {
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print','pageLength'],                
            }         
        }
    });
  </script>
</body>
</html>    