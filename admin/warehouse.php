<?php
    require_once("config.php");
    require_once("views/helper.php");
    require_once("views/login_check.php");
    require_once("views/init.php");
    
    // Initialize variables
    $action_title = "АГУУЛАХ";
    $search = isset($_GET["search"]) ? protect($_GET["search"]) : "";
    $type = isset($_GET["type"]) ? protect($_GET["type"]) : "orders"; // orders, tracks, containers
    $search_date = isset($_GET["search_date"]) ? protect($_GET["search_date"]) : "warehouse";
    $start_date = isset($_GET["start_date"]) ? protect($_GET["start_date"]) : "";
    $finish_date = isset($_GET["finish_date"]) ? protect($_GET["finish_date"]) : "";
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
        
          <?php
          $type_titles = array(
            "orders" => "Илгээмж",
            "tracks" => "Track",
            "containers" => "Чингэлэг"
          );
          $action_title = "АГУУЛАХ - " . (isset($type_titles[$type]) ? $type_titles[$type] : "Илгээмж");
          ?>
          <nav class="page-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="warehouse">АГУУЛАХ</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?php echo $action_title;?></li>
            </ol>
          </nav>

          <?php
          // Search term - төрөл хамаарахгүй бүх хэлбэрээр хайх
          $search_term = "";
          if ($search != "") {
            $search_term = str_replace(" ", "%", $search);
          }
          ?>

          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <div class="mb-3 text-right">
                    <button type="button" class="btn btn-success" id="exportExcelBtn">
                      <i data-feather="download" class="icon-sm mr-2"></i> Excel татах
                    </button>
                  </div>
                  <form action="" method="get">
                    <input type="hidden" name="type" value="<?php echo htmlspecialchars($type); ?>">
                    <div class="row mb-3">
                      <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Хайх..." value="<?php echo htmlspecialchars($search); ?>" autofocus>
                      </div>
                      <div class="col-md-2">
                        <select name="type" class="form-control">
                          <option value="orders" <?php echo ($type=="orders")?'SELECTED':'';?>>Илгээмж</option>
                          <option value="tracks" <?php echo ($type=="tracks")?'SELECTED':'';?>>Track</option>
                          <option value="containers" <?php echo ($type=="containers")?'SELECTED':'';?>>Чингэлэг</option>
                        </select>
                      </div>
                      <div class="col-md-2">
                        <select name="search_date" class="form-control">
                          <option value="warehouse" <?php echo ($search_date=="warehouse")?'SELECTED':'';?>>warehouse</option>
                          <option value="created" <?php echo ($search_date=="created")?'SELECTED':'';?>>created</option>
                        </select>
                      </div>
                      <div class="col-md-2">
                        <input type="date" name="start_date" class="form-control" value="<?php echo htmlspecialchars($start_date); ?>" placeholder="Эхлэх огноо">
                      </div>
                      <div class="col-md-2">
                        <input type="date" name="finish_date" class="form-control" value="<?php echo htmlspecialchars($finish_date); ?>" placeholder="Дуусах огноо">
                      </div>
                      <div class="col-md-1">
                        <button type="submit" class="btn btn-primary">Хайх</button>
                      </div>
                    </div>
                  </form>

                  <?php
                  // Warehouse-д байгаа зүйлсийг хайх - төрөл хамаарахгүй бүх хэлбэрээр
                  $all_results = array();
                  $count = 1;
                  
                  // Search term байвал бүх төрлөөс хайх (төрөл хамаарахгүй)
                  // Илгээмж хайх
                  if ($type == "orders" || $search_term != "") {
                    $sql_orders = "SELECT orders.*, 
                            receiver_customer.name AS r_name, receiver_customer.surname AS r_surname, 
                            receiver_customer.tel AS r_tel, receiver_customer.address AS r_address,
                            sender_customer.name AS s_name, sender_customer.surname AS s_surname, 
                            sender_customer.tel AS s_tel, sender_customer.address AS s_address,
                            'orders' AS item_type
                            FROM orders 
                            LEFT JOIN customer AS receiver_customer ON orders.receiver=receiver_customer.customer_id 
                            LEFT JOIN customer AS sender_customer ON orders.sender=sender_customer.customer_id
                            WHERE orders.status='warehouse'";
                    
                    // Search - төрөл хамаарахгүй бүх хэлбэрээр хайх
                    if ($search_term != "") {
                      $sql_orders .= " AND CONCAT_WS(' ', receiver_customer.name, receiver_customer.surname, receiver_customer.tel, 
                                sender_customer.name, sender_customer.surname, sender_customer.tel, 
                                orders.barcode, orders.third_party, orders.extra) LIKE '%".mysqli_real_escape_string($conn, $search_term)."%'";
                    }
                    
                    // Date filter
                    $date_column = ($search_date == "warehouse") ? "warehouse_date" : "created_date";
                    if ($start_date != "") {
                      $sql_orders .= " AND ".$date_column.">='".mysqli_real_escape_string($conn, $start_date)."'";
                    }
                    if ($finish_date != "") {
                      $sql_orders .= " AND ".$date_column."<='".mysqli_real_escape_string($conn, $finish_date)."'";
                    }
                    
                    $sql_orders .= " ORDER BY order_id DESC";
                    
                    $result_orders = mysqli_query($conn, $sql_orders);
                    if ($result_orders) {
                      while ($row = mysqli_fetch_array($result_orders)) {
                        $row['item_type'] = 'orders';
                        $all_results[] = $row;
                      }
                    }
                  }
                  
                  // Track хайх
                  if ($type == "tracks" || $search_term != "") {
                    $sql_tracks = "SELECT orders.*, 
                            receiver_customer.name AS r_name, receiver_customer.surname AS r_surname, 
                            receiver_customer.tel AS r_tel, receiver_customer.address AS r_address,
                            sender_customer.name AS s_name, sender_customer.surname AS s_surname, 
                            sender_customer.tel AS s_tel, sender_customer.address AS s_address,
                            'tracks' AS item_type
                            FROM orders 
                            LEFT JOIN customer AS receiver_customer ON orders.receiver=receiver_customer.customer_id 
                            LEFT JOIN customer AS sender_customer ON orders.sender=sender_customer.customer_id
                            WHERE orders.status='warehouse' AND orders.third_party != ''";
                    
                    // Search - төрөл хамаарахгүй бүх хэлбэрээр хайх
                    if ($search_term != "") {
                      $sql_tracks .= " AND CONCAT_WS(' ', receiver_customer.name, receiver_customer.surname, receiver_customer.tel, 
                                sender_customer.name, sender_customer.surname, sender_customer.tel, 
                                orders.barcode, orders.third_party, orders.extra) LIKE '%".mysqli_real_escape_string($conn, $search_term)."%'";
                    }
                    
                    // Date filter
                    $date_column = ($search_date == "warehouse") ? "warehouse_date" : "created_date";
                    if ($start_date != "") {
                      $sql_tracks .= " AND ".$date_column.">='".mysqli_real_escape_string($conn, $start_date)."'";
                    }
                    if ($finish_date != "") {
                      $sql_tracks .= " AND ".$date_column."<='".mysqli_real_escape_string($conn, $finish_date)."'";
                    }
                    
                    $sql_tracks .= " ORDER BY order_id DESC";
                    
                    $result_tracks = mysqli_query($conn, $sql_tracks);
                    if ($result_tracks) {
                      while ($row = mysqli_fetch_array($result_tracks)) {
                        $row['item_type'] = 'tracks';
                        $all_results[] = $row;
                      }
                    }
                  }
                  
                  // Чингэлэг хайх
                  if ($type == "containers" || $search_term != "") {
                    $sql_containers = "SELECT container.*,
                            'containers' AS item_type
                            FROM container 
                            WHERE container.status='warehouse'";
                    
                    // Search - төрөл хамаарахгүй бүх хэлбэрээр хайх
                    if ($search_term != "") {
                      $sql_containers .= " AND CONCAT_WS(' ', 
                                container.barcode, container.name, container.description) LIKE '%".mysqli_real_escape_string($conn, $search_term)."%'";
                    }
                    
                    // Date filter
                    $date_column = ($search_date == "warehouse") ? "warehouse_date" : "created_date";
                    if ($start_date != "") {
                      $sql_containers .= " AND ".$date_column.">='".mysqli_real_escape_string($conn, $start_date)."'";
                    }
                    if ($finish_date != "") {
                      $sql_containers .= " AND ".$date_column."<='".mysqli_real_escape_string($conn, $finish_date)."'";
                    }
                    
                    $sql_containers .= " ORDER BY container_id DESC";
                    
                    $result_containers = mysqli_query($conn, $sql_containers);
                    if ($result_containers) {
                      while ($row = mysqli_fetch_array($result_containers)) {
                        $row['item_type'] = 'containers';
                        $all_results[] = $row;
                      }
                    }
                  }
                  
                  // Search байвал бүх төрлөөс хайсан үр дүнг харуулах
                  $display_results = array();
                  if ($search_term != "") {
                    // Search байвал бүх төрлөөс хайсан үр дүнг харуулах (төрөл хамаарахгүй)
                    $display_results = $all_results;
                  } else {
                    // Зөвхөн сонгосон төрлөөс хайсан үр дүнг харуулах
                    foreach ($all_results as $item) {
                      if (isset($item['item_type']) && $item['item_type'] == $type) {
                        $display_results[] = $item;
                      }
                    }
                  }
                  ?>
                  
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>№</th>
                          <?php if ($search_term != ""): ?>
                            <th>Төрөл</th>
                          <?php endif; ?>
                          <?php if ($type == "orders" || $type == "tracks" || $search_term != ""): ?>
                            <th>Илгээгч</th>
                            <th>Хүлээн авагч</th>
                            <th>Утас</th>
                            <th>Barcode</th>
                            <th>Track</th>
                            <th>Жин</th>
                            <th>Төлөв</th>
                            <th>Агуулах болсон огноо</th>
                            <th>Огноо</th>
                            <th></th>
                          <?php endif; ?>
                          <?php if ($type == "containers" && $search_term == ""): ?>
                            <th>Илгээгч</th>
                            <th>Хүлээн авагч</th>
                            <th>Утас</th>
                            <th>Barcode</th>
                            <th>Track</th>
                            <th>Жин</th>
                            <th>Төлөв</th>
                            <th>Агуулах болсон огноо</th>
                            <th>Огноо</th>
                            <th></th>
                          <?php endif; ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (count($display_results) > 0) {
                          foreach ($display_results as $data) {
                            $item_type = isset($data['item_type']) ? $data['item_type'] : $type;
                            
                            if ($item_type == "orders" || $item_type == "tracks") {
                              $order_id = $data["order_id"];
                              $barcode = $data["barcode"];
                              $track = $data["third_party"];
                              $weight = $data["weight"];
                              $status = $data["status"];
                              $extra = $data["extra"];
                              $warehouse_date = $data["warehouse_date"];
                              $created_date = $data["created_date"];
                              $r_name = $data["r_name"];
                              $r_surname = $data["r_surname"];
                              $r_tel = $data["r_tel"];
                              $s_name = $data["s_name"];
                              $s_surname = $data["s_surname"];
                              
                              $temp_status = $status;
                              if ($status == "warehouse" && $extra != "") {
                                $temp_status = $status." ".$extra."-р тавиур";
                              }
                              
                              $display_date = ($search_date == "warehouse" && $warehouse_date) ? $warehouse_date : $created_date;
                              ?>
                              <tr>
                                <td><?php echo $count++; ?></td>
                                <?php if ($search_term != ""): ?>
                                  <td>
                                    <?php 
                                    $type_labels = array("orders" => "Илгээмж", "tracks" => "Track", "containers" => "Чингэлэг");
                                    echo htmlspecialchars(isset($type_labels[$item_type]) ? $type_labels[$item_type] : $item_type); 
                                    ?>
                                  </td>
                                <?php endif; ?>
                                <td>
                                  <?php if ($s_name || $s_surname): ?>
                                    <a href="customers?action=detail&id=<?php echo $data["sender"]; ?>">
                                      <?php echo htmlspecialchars(substr($s_surname, 0, 2).".".$s_name); ?>
                                    </a>
                                  <?php else: ?>
                                    -
                                  <?php endif; ?>
                                </td>
                                <td>
                                  <?php if ($r_name || $r_surname): ?>
                                    <a href="customers?action=detail&id=<?php echo $data["receiver"]; ?>">
                                      <?php echo htmlspecialchars(substr($r_surname, 0, 2).".".$r_name); ?>
                                    </a>
                                  <?php else: ?>
                                    -
                                  <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($r_tel ? $r_tel : "-"); ?></td>
                                <td><?php echo htmlspecialchars($barcode ? $barcode : "-"); ?></td>
                                <td><?php echo htmlspecialchars($track ? $track : "-"); ?></td>
                                <td><?php echo htmlspecialchars($weight ? $weight : "-"); ?></td>
                                <td><?php echo htmlspecialchars($temp_status ? $temp_status : "-"); ?></td>
                                <td><?php echo htmlspecialchars($warehouse_date ? $warehouse_date : "-"); ?></td>
                                <td><?php echo htmlspecialchars($display_date ? $display_date : "-"); ?></td>
                                <td>
                                  <a href="tracks?action=detail&id=<?php echo $order_id; ?>">
                                    <span class="glyphicon glyphicon-edit"></span>
                                  </a>
                                </td>
                              </tr>
                              <?php
                            } elseif ($item_type == "containers") {
                              $container_id = $data["container_id"];
                              $barcode = isset($data["barcode"]) ? $data["barcode"] : "";
                              $name = isset($data["name"]) ? $data["name"] : "";
                              $description = isset($data["description"]) ? $data["description"] : "";
                              $status = isset($data["status"]) ? $data["status"] : "";
                              $warehouse_date = isset($data["warehouse_date"]) ? $data["warehouse_date"] : "";
                              $created_date = isset($data["created"]) ? $data["created"] : (isset($data["created_date"]) ? $data["created_date"] : "");
                              
                              $display_date = ($search_date == "warehouse" && $warehouse_date) ? $warehouse_date : $created_date;
                              ?>
                              <tr>
                                <td><?php echo $count++; ?></td>
                                <?php if ($search_term != ""): ?>
                                  <td>Чингэлэг</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td><?php echo htmlspecialchars($barcode); ?></td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td><?php echo htmlspecialchars($status ? $status : "-"); ?></td>
                                  <td><?php echo htmlspecialchars($warehouse_date ? $warehouse_date : "-"); ?></td>
                                  <td><?php echo htmlspecialchars($display_date ? $display_date : "-"); ?></td>
                                <?php else: ?>
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td><?php echo htmlspecialchars($barcode ? $barcode : "-"); ?></td>
                                  <td>-</td>
                                  <td>-</td>
                                  <td><?php echo htmlspecialchars($status ? $status : "-"); ?></td>
                                  <td><?php echo htmlspecialchars($warehouse_date ? $warehouse_date : "-"); ?></td>
                                  <td><?php echo htmlspecialchars($display_date ? $display_date : "-"); ?></td>
                                <?php endif; ?>
                                <td>
                                  <a href="container?action=detail&id=<?php echo $container_id; ?>">
                                    <span class="glyphicon glyphicon-edit"></span>
                                  </a>
                                </td>
                              </tr>
                              <?php
                            }
                          }
                        } else {
                          ?>
                          <tr>
                            <td colspan="8" class="text-center">Агуулахад зүйл олдсонгүй</td>
                          </tr>
                          <?php
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

			</div>
		</div>
	</div>

	<script>
	// Excel экспорт функц
	function exportToExcel() {
		var table = document.querySelector('.table');
		var wb = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
		
		// Файл нэр - төрлөөс хамаарч
		var type = "<?php echo htmlspecialchars($type, ENT_QUOTES); ?>";
		var fileName = "АГУУЛАХ_";
		
		if (type == "orders") {
			fileName += "илгээмж";
		} else if (type == "tracks") {
			fileName += "трак";
		} else if (type == "containers") {
			fileName += "чингелэг";
		} else {
			fileName += "бүгд";
		}
		
		fileName += "_<?php echo date('Y-m-d'); ?>.xlsx";
		
		// Татаж авах
		XLSX.writeFile(wb, fileName);
	}
	
	// Товч дээр click event
	document.addEventListener('DOMContentLoaded', function() {
		var exportBtn = document.getElementById('exportExcelBtn');
		if (exportBtn) {
			exportBtn.addEventListener('click', function() {
				// SheetJS (xlsx) library шалгах
				if (typeof XLSX !== 'undefined') {
					exportToExcel();
				} else {
					// SheetJS байхгүй бол энгийн CSV экспорт
					exportToCSV();
				}
			});
		}
		
		// Feather icons
		if (typeof feather !== 'undefined') {
			feather.replace();
		}
	});
	
	// CSV экспорт (backup)
	function exportToCSV() {
		var table = document.querySelector('.table');
		var csv = [];
		var rows = table.querySelectorAll('tr');
		
		for (var i = 0; i < rows.length; i++) {
			var row = [], cols = rows[i].querySelectorAll('td, th');
			for (var j = 0; j < cols.length; j++) {
				var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, "").replace(/"/g, '""');
				row.push('"' + data + '"');
			}
			csv.push(row.join(','));
		}
		
		var type = "<?php echo htmlspecialchars($type, ENT_QUOTES); ?>";
		var fileName = "АГУУЛАХ_";
		
		if (type == "orders") {
			fileName += "илгээмж";
		} else if (type == "tracks") {
			fileName += "трак";
		} else if (type == "containers") {
			fileName += "чингелэг";
		} else {
			fileName += "бүгд";
		}
		
		var csvFile = new Blob([csv.join('\n')], {type: 'text/csv;charset=utf-8;'});
		var link = document.createElement('a');
		var url = URL.createObjectURL(csvFile);
		link.setAttribute('href', url);
		link.setAttribute('download', fileName + '_<?php echo date('Y-m-d'); ?>.csv');
		link.style.visibility = 'hidden';
		document.body.appendChild(link);
		link.click();
		document.body.removeChild(link);
	}
	</script>
	
	<!-- SheetJS library (optional, для Excel support) -->
	<script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>

	<!-- endinject -->

</body>
</html>
