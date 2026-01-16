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
          if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="report";          
          if (isset($_POST["month"])) $date=$_POST["month"]; else $date=date("Y-m"); 

          switch ($action)
          {
            case "report": $action_title="Тайлан";break;            
          }
          ?>
          <div class="d-flex justify-content-between">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="sms">SMS</a></li>            
                    <li class="breadcrumb-item active" aria-current="page"><?=$action_title;?></li>
                </ol>
            </nav>
    
            <form action="?action=report" method="POST">
                <div class="input-group">
                    <input type="month"  name="month" class="form-control" value="<?=$date;?>">
                    <button type="submit" class="btn btn-success btn-xs"><i data-feather="filter"></i>  Шүүх</button>                       
                </div>
            </form>

          </div>

                               
          <div class="row mt-3 mb-4">
            <div class="col-sm-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                <?
                $total_numbers = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM sms"));
                ?>
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                    <span>Total</span>
                    <div class="d-flex align-items-center my-2">
                        <h3 class="mb-0 me-2"><?=number_format($total_numbers);?></h3>
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
                        <?
                        $today_numbers = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM sms WHERE created_date LIKE '".$date."%'"));
                        ?>

                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                            <span>This Month</span>
                            <div class="d-flex align-items-center my-2">
                                <h3 class="mb-0 me-2"><?=number_format($today_numbers);?></h3>
                            </div>
                            <p class="mb-0"><?=$date;?></p>
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
                    <?
                    $today_numbers = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM sms WHERE created_date LIKE '".date("Y-m-d")."%'"));
                    ?>                      
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                        <span>Today</span>
                        <div class="d-flex align-items-center my-2">
                            <h3 class="mb-0 me-2"><?=number_format($today_numbers);?></h3>
                            <!-- <p class="text-success mb-0">(+18%)</p> -->
                        </div>
                        <p class="mb-0"><?=date("Y-m-d");?></p>
                        </div>
                        <h1 class="text-success lg">
                            <i data-feather="mail"></i>
                        </h1>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        

        <? 
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
                            <?
                            $count=1;
                            $sql = "SELECT * FROM sms WHERE sms.created_date LIKE '$date%' ORDER BY id DESC";
                            $result = mysqli_query($conn,$sql);
                            while ($data = mysqli_fetch_array($result))
                            {
                                $sms_id = $data["id"];
                                $sms_tel = $data["tel"];
                                $sms_content = $data["sms"];
                                $sms_operator = $data["operator"];
                                $sms_created_date = $data["created_date"];
                                ?>
                                <tr>
                                    <td><?=$count++;?></td>
                                    <td><?=$sms_created_date;?></td>
                                    <td><?=$sms_tel;?></td>
                                    <td><?=$sms_content;?></td>
                                    <td><?=$sms_operator;?></td>
                                </tr>
                                <?
                            }
                            ?>
                        </tbody>
                    </table>
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