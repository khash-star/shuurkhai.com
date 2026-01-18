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

          <?php
          if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="report";
          $action_title = "Тайлан"; // Default value
          if (isset($_POST["month"])) {
              $date = protect($_POST["month"]);
          } else {
              $date = date("Y-m");
          }

          switch ($action)
          {
            case "report": $action_title="Тайлан";break;
            default: $action_title="Тайлан";break;
          }
          ?>
          <div class="d-flex justify-content-between">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="sms">SMS</a></li>            
                    <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($action_title);?></li>
                </ol>
            </nav>
    
            <form action="?action=report" method="POST">
                <div class="input-group">
                    <input type="month"  name="month" class="form-control" value="<?php echo htmlspecialchars($date);?>">
                    <button type="submit" class="btn btn-success btn-xs"><i data-feather="filter"></i>  Шүүх</button>                       
                </div>
            </form>

          </div>

                               
          <div class="row mt-3 mb-4">
            <div class="col-sm-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                <?php
                $total_numbers = 0;
                $result_total = mysqli_query($conn,"SELECT id FROM sms");
                if ($result_total) {
                    $total_numbers = mysqli_num_rows($result_total);
                }
                ?>
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                    <span>Total</span>
                    <div class="d-flex align-items-center my-2">
                        <h3 class="mb-0 me-2"><?php echo number_format($total_numbers);?></h3>
                    </div>
                    <p class="mb-0">Total sent</p>
                    </div>
                    <h1 class="text-success lg">
                        <i data-feather="mail"></i>
                    </h1>
                </div>
                </div>
            </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <?php
                        $today_numbers = 0;
                        $date_escaped = mysqli_real_escape_string($conn, $date);
                        $result_month = mysqli_query($conn,"SELECT id FROM sms WHERE created_date LIKE '".$date_escaped."%'");
                        if ($result_month) {
                            $today_numbers = mysqli_num_rows($result_month);
                        }
                        ?>

                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                            <span>This Month</span>
                            <div class="d-flex align-items-center my-2">
                                <h3 class="mb-0 me-2"><?php echo number_format($today_numbers);?></h3>
                            </div>
                            <p class="mb-0"><?php echo htmlspecialchars($date);?></p>
                            </div>
                            <h1 class="text-primary lg">
                                <i data-feather="mail"></i>
                            </h1>
                        </div>
                    </div>
                </div>                    
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                    <?php
                    $today_numbers = 0;
                    $today_date = date("Y-m-d");
                    $today_date_escaped = mysqli_real_escape_string($conn, $today_date);
                    $result_today = mysqli_query($conn,"SELECT id FROM sms WHERE created_date LIKE '".$today_date_escaped."%'");
                    if ($result_today) {
                        $today_numbers = mysqli_num_rows($result_today);
                    }
                    ?>                      
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                        <span>Today</span>
                        <div class="d-flex align-items-center my-2">
                            <h3 class="mb-0 me-2"><?php echo number_format($today_numbers);?></h3>
                            <!-- <p class="text-success mb-0">(+18%)</p> -->
                        </div>
                        <p class="mb-0"><?php echo htmlspecialchars($today_date);?></p>
                        </div>
                        <h1 class="text-success lg">
                            <i data-feather="mail"></i>
                        </h1>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        

        <?php 
        if ($action=="report")
        {
            ?>
            <div class="card">
                <div class="card-header">Меssage</div>
                <div class="card-body">
                    <table class="table table-striped" id="datatables-basic">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Date</th>
                                <th>Tel</th>
                                <th>Message</th>
                                <th>Carrier</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $date_escaped = mysqli_real_escape_string($conn, $date);
                            $sql = "SELECT * FROM sms WHERE sms.created_date LIKE '$date_escaped%' ORDER BY id DESC";
                            $result = mysqli_query($conn,$sql);
                            if ($result) {
                                while ($data = mysqli_fetch_array($result))
                                {
                                    if (!$data) continue;
                                    $sms_id = isset($data["id"]) ? intval($data["id"]) : 0;
                                    $sms_tel = isset($data["tel"]) ? htmlspecialchars($data["tel"]) : '';
                                    $sms_content = isset($data["sms"]) ? htmlspecialchars($data["sms"]) : '';
                                    $sms_operator = isset($data["operator"]) ? htmlspecialchars($data["operator"]) : '';
                                    $sms_created_date = isset($data["created_date"]) ? htmlspecialchars($data["created_date"]) : '';
                                    ?>
                                    <tr>
                                        <td><?php echo $count++;?></td>
                                        <td><?php echo $sms_created_date;?></td>
                                        <td><?php echo $sms_tel;?></td>
                                        <td><?php echo $sms_content;?></td>
                                        <td><?php echo $sms_operator;?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
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