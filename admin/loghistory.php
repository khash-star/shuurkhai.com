<?
    require_once("config.php");
    require_once("views/helper.php");
    require_once("views/login_check.php");
    require_once("views/init.php");
?>

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
          if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="history";?>
          <?
          switch ($action)
          {
            case "history": $action_title="Түүх";break;           
            case "excel": $action_title="Excel файл шинэчлэх";break;
            default: $action_title="Тодорхойгүй";break;            
          }
          ?>
          <div class="d-flex justify-content-between">
            <nav class="page-breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="boxes">Log удирдлага</a></li>
                <li class="breadcrumb-item"><a href="?action=history">Лог</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?=$action_title;?></li>
              </ol>
            </nav>

            <!-- <a href="?action=clearlog" class="btn btn-warning mb-3">Түүх цэвэрлэх</a> -->
          </div>

          <?
          if ($action == "history")
          {
            if (isset($_POST["from_date"])) $from_date=$_POST["from_date"]; else $from_date= date('Y-m-d', strtotime(date('Y-m-d') . ' -1 days'));
            if (isset($_POST["to_date"])) $to_date=$_POST["to_date"]; else $to_date= date('Y-m-d');
            
            ?>
            <form action="?action=history" method="post">
                <div class="input-group">
                  <input type="date" name="from_date" class="form-control" value="<?=$from_date;?>">
                  <input type="date" name="to_date" class="form-control" value="<?=$to_date;?>">
                  <button type="submit" class="btn btn-success">Хайх</button>
                </div>
            </form>
            <div class="panel panel-primary">
              <div class="panel-heading">Түүх</div>
                  <div class="panel-body">
                <? 
                $sql = "SELECT * FROM logs WHERE timestamp >='$from_date 00:00:00' AND  timestamp <='$to_date 23:59:59' ORDER BY id DESC";
                $result = mysqli_query($conn,$sql);                
                
                if (mysqli_num_rows($result) > 0)
                    {
                        echo "<table class='table table-hover'>";
                        echo "<tr>";                                            
                        echo "<th>№</th>"; 
                        echo "<th>Хэзээ</th>"; 
                        echo "<th>Хэнд</th>"; 
                        echo "<th>Юу хийв</th>"; 
                        echo "<th>Төрөл</th>"; 
                        echo "<th>Хэрэглэгч</th>"; 
                        echo "<th>Ачаа</th>"; 
                        echo "<th>IP</th>"; 
                        echo "</tr>";
                        
                        while ($data =  mysqli_fetch_array($result))
                        {                         
                            $id= $data["id"]; 
                            $name= $data["name"]; 
                            $ip= $data["ip"];
                            $logs = $data["logs"];
                            $timestamp = $data["timestamp"];
                            $type = $data["type"];
                            $customer_id = $data["customer_id"];
                            $order_id = $data["order_id"];
                            
                        
                            echo "<tr>";
                            echo "<td>".$id."</td>";
                            echo "<td>".$timestamp."</td>"; 
                            echo "<td>".$name."</td>"; 
                            echo "<td>".htmlspecialchars($logs)."</td>"; 
                            echo "<td>".$type."</td>"; 
                            echo "<td>".$customer_id."</td>"; 
                            echo "<td>".$order_id."</td>"; 
                            echo "<td>".$type."</td>";                             
                            echo "<td>".$ip."</td>";                             
                            echo "</tr>";
                        } 
                        echo "</table>";
                    }
                else alert_div("Энэ хугацаанд түүх бичигдээгүй байна");
                ?>

                </div>
                </div> <!--wrapper-->
            <?
          }
          ?>

          <?
          if ($action == "clearlog")
          {
                                
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

</body>
</html>    