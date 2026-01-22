<?php require_once("views/login_check.php");?>
<?php require_once("config.php");?>
<?php require_once("views/helper.php");?>
<?php require_once("views/init.php");?>
<body>
    <?php
    $branch_my_id = $_SESSION['branch_logged_id'];
    $branch_my_name = $_SESSION['branch_logged_name'];
    $branch_my_tel = $_SESSION['branch_logged_tel'];
    $branch_my_email = $_SESSION['branch_logged_email'];
    $g_logged_id = $branch_my_id; // Set for compatibility with other queries
    ?>

    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="theme-loader">    
        <div class="loader-p"></div>
      </div>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <?php require_once("views/header.php");?>
      <!-- Page Body Start-->
      <div class="page-body-wrapper sidebar-icon">
        <?php require_once("views/sidemenu.php");?>
        <div class="page-body dashboard-2-main">
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <?php
            if (isset($_GET["action"])) $action = $_GET["action"]; else $action = "list";

            // List View: Show all truck records with OTP codes
            if ($action=="list")
            {
                ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Truck мэдээлэл (OTP кодтой бараа)</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Track код</th>
                                        <th>OTP код</th>
                                        <th>DE</th>
                                        <th>Харилцагч</th>
                                        <th>Статус</th>
                                        <th>Огноо</th>
                                        <th>Үйлдэл</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $g_logged_id_escaped = mysqli_real_escape_string($conn, $g_logged_id);
                                    
                                    // Get all DE checked items with OTP codes (regardless of branch)
                                    $sql = "SELECT 
                                        o.order_id,
                                        o.third_party,
                                        o.otp_code,
                                        o.de_checkbox,
                                        o.receiver,
                                        o.created_date,
                                        bi.status,
                                        bi.created_date as inventory_date
                                    FROM orders o
                                    LEFT JOIN branch_inventories bi ON bi.track = o.third_party AND bi.branch='$g_logged_id_escaped'
                                    WHERE o.otp_code IS NOT NULL 
                                    AND o.otp_code != ''
                                    AND o.de_checkbox = 1
                                    ORDER BY o.order_id DESC
                                    LIMIT 50";
                                    
                                    $result = @mysqli_query($conn, $sql);
                                    $truck_count = 0;
                                    
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($data = mysqli_fetch_array($result)) {
                                            $truck_count++;
                                            
                                            $order_id = isset($data["order_id"]) ? intval($data["order_id"]) : 0;
                                            $track = isset($data["third_party"]) ? htmlspecialchars(trim($data["third_party"])) : '-';
                                            $otp_code = isset($data["otp_code"]) ? htmlspecialchars($data["otp_code"]) : '-';
                                            $de_checkbox = isset($data["de_checkbox"]) ? intval($data["de_checkbox"]) : 0;
                                            $receiver_id = isset($data["receiver"]) ? intval($data["receiver"]) : 0;
                                            $status = isset($data["status"]) ? htmlspecialchars($data["status"]) : '-';
                                            $created_date = isset($data["created_date"]) ? substr($data["created_date"], 0, 10) : '-';
                                            
                                            // Get customer name from customer table
                                            $customer_name = '-';
                                            if ($receiver_id > 0) {
                                                $receiver_id_escaped = mysqli_real_escape_string($conn, $receiver_id);
                                                $sql_customer = "SELECT name, surname FROM customer WHERE customer_id='$receiver_id_escaped' LIMIT 1";
                                                $result_customer = @mysqli_query($conn, $sql_customer);
                                                if ($result_customer && mysqli_num_rows($result_customer) > 0) {
                                                    $customer_data = mysqli_fetch_array($result_customer);
                                                    $name = isset($customer_data["name"]) ? htmlspecialchars($customer_data["name"]) : '';
                                                    $surname = isset($customer_data["surname"]) ? htmlspecialchars($customer_data["surname"]) : '';
                                                    $customer_name = trim($name . ' ' . $surname);
                                                    if (empty($customer_name)) $customer_name = '-';
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $truck_count; ?></td>
                                                <td><strong><?php echo $track; ?></strong></td>
                                                <td>
                                                    <span class="badge bg-success text-white"><?php echo $otp_code; ?></span>
                                                </td>
                                                <td>
                                                    <?php if ($de_checkbox == 1): ?>
                                                        <span class="badge bg-info text-white">DE</span>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo $customer_name; ?></td>
                                                <td>
                                                    <span class="badge bg-info text-white"><?php echo $status; ?></span>
                                                </td>
                                                <td><?php echo $created_date; ?></td>
                                                <td>
                                                    <a href="truck.php?action=detail&id=<?php echo $order_id; ?>" class="btn btn-primary btn-sm">Дэлгэрэнгүй</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    
                                    // Reset for display
                                    if ($truck_count == 0) {
                                        $result_truck_list = false;
                                    } else {
                                        $result_truck_list = true; // Mark as having results
                                    }
                                    
                                    if (!$result_truck_list) {
                                        ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">Мэдээлэл олдсонгүй</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="7" class="text-end">Нийт:</th>
                                        <th><?php echo $truck_count; ?> бараа</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="mt-3">
                            <a href="branch.php" class="btn btn-secondary">Буцах</a>
                        </div>
                    </div>
                </div>
                <?php
            }

            // Detail View: Show single truck record in read-only mode
            if ($action=="detail")
            {
                if (isset($_GET["id"])) {
                    $order_id = intval($_GET["id"]);
                    $order_id_escaped = mysqli_real_escape_string($conn, $order_id);
                    $g_logged_id_escaped = mysqli_real_escape_string($conn, $g_logged_id);
                    
                    // Get order details with branch inventory - Only DE checked items
                    $sql_detail = "SELECT 
                        o.order_id,
                        o.third_party,
                        o.otp_code,
                        o.de_checkbox,
                        o.receiver,
                        o.package,
                        o.proxy_id,
                        bi.id as inventory_id,
                        bi.status,
                        bi.comment,
                        bi.created_date
                    FROM orders o
                    LEFT JOIN branch_inventories bi ON bi.track = o.third_party AND bi.branch='$g_logged_id_escaped'
                    WHERE o.order_id='$order_id_escaped'
                    AND o.otp_code IS NOT NULL 
                    AND o.otp_code != ''
                    AND o.de_checkbox = 1
                    LIMIT 1";
                    
                    $result_detail = @mysqli_query($conn, $sql_detail);
                    
                    if ($result_detail && mysqli_num_rows($result_detail) > 0) {
                        $truck_data = mysqli_fetch_array($result_detail);
                        
                        $third_party = isset($truck_data["third_party"]) ? htmlspecialchars($truck_data["third_party"]) : '';
                        $otp_code = isset($truck_data["otp_code"]) ? htmlspecialchars($truck_data["otp_code"]) : '';
                        $de_checkbox = isset($truck_data["de_checkbox"]) ? intval($truck_data["de_checkbox"]) : 0;
                        $receiver_id = isset($truck_data["receiver"]) ? intval($truck_data["receiver"]) : 0;
                        $package = isset($truck_data["package"]) ? htmlspecialchars($truck_data["package"]) : '';
                        $status = isset($truck_data["status"]) ? htmlspecialchars($truck_data["status"]) : '';
                        $comment = isset($truck_data["comment"]) ? htmlspecialchars($truck_data["comment"]) : '';
                        $created_date = isset($truck_data["created_date"]) ? htmlspecialchars($truck_data["created_date"]) : '';
                        
                        // Get customer name from customer table
                        $customer_name = '-';
                        if ($receiver_id > 0) {
                            $receiver_id_escaped = mysqli_real_escape_string($conn, $receiver_id);
                            $sql_customer = "SELECT name, surname FROM customer WHERE customer_id='$receiver_id_escaped' LIMIT 1";
                            $result_customer = @mysqli_query($conn, $sql_customer);
                            if ($result_customer && mysqli_num_rows($result_customer) > 0) {
                                $customer_data = mysqli_fetch_array($result_customer);
                                $name = isset($customer_data["name"]) ? htmlspecialchars($customer_data["name"]) : '';
                                $surname = isset($customer_data["surname"]) ? htmlspecialchars($customer_data["surname"]) : '';
                                $customer_name = trim($name . ' ' . $surname);
                                if (empty($customer_name)) $customer_name = '-';
                            }
                        }
                        
                        // Parse package data
                        $package_array = !empty($package) ? explode("##", $package) : array();
                        $package1_name = isset($package_array[0]) ? htmlspecialchars($package_array[0]) : '';
                        $package1_num = isset($package_array[1]) ? htmlspecialchars($package_array[1]) : '';
                        $package1_price = isset($package_array[2]) ? htmlspecialchars($package_array[2]) : '';
                        $package2_name = isset($package_array[3]) ? htmlspecialchars($package_array[3]) : '';
                        $package2_num = isset($package_array[4]) ? htmlspecialchars($package_array[4]) : '';
                        $package2_price = isset($package_array[5]) ? htmlspecialchars($package_array[5]) : '';
                        $package3_name = isset($package_array[6]) ? htmlspecialchars($package_array[6]) : '';
                        $package3_num = isset($package_array[7]) ? htmlspecialchars($package_array[7]) : '';
                        $package3_price = isset($package_array[8]) ? htmlspecialchars($package_array[8]) : '';
                        $package4_name = isset($package_array[9]) ? htmlspecialchars($package_array[9]) : '';
                        $package4_num = isset($package_array[10]) ? htmlspecialchars($package_array[10]) : '';
                        $package4_price = isset($package_array[11]) ? htmlspecialchars($package_array[11]) : '';
                        
                        // Get proxy info if exists
                        $proxy_id = isset($truck_data["proxy_id"]) ? intval($truck_data["proxy_id"]) : 0;
                        $proxy_name = '';
                        $proxy_tel = '';
                        if ($proxy_id > 0) {
                            $proxy_id_escaped = mysqli_real_escape_string($conn, $proxy_id);
                            $sql_proxy = "SELECT name, surname, tel FROM proxies WHERE proxy_id='$proxy_id_escaped' LIMIT 1";
                            $result_proxy = @mysqli_query($conn, $sql_proxy);
                            if ($result_proxy && mysqli_num_rows($result_proxy) > 0) {
                                $proxy_data = mysqli_fetch_array($result_proxy);
                                $proxy_name = isset($proxy_data["name"]) ? htmlspecialchars($proxy_data["name"]) : '';
                                $proxy_surname = isset($proxy_data["surname"]) ? htmlspecialchars($proxy_data["surname"]) : '';
                                $proxy_tel = isset($proxy_data["tel"]) ? htmlspecialchars($proxy_data["tel"]) : '';
                                $proxy_name = trim($proxy_name . ' ' . $proxy_surname);
                            }
                        }
                        ?>
                        <div class="row layout-spacing">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Truck мэдээлэл (Зөвхөн унших)</h5>
                                        
                                        <div class="form-group">
                                            <label for="track"><b>Трак</b></label>
                                            <input type="text" class="form-control" value="<?php echo $third_party; ?>" readonly>
                                        </div>
                                        
                                        <div class="form-group mt-3">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <label for="otp_code"><b>OTP код</b></label>
                                                    <input type="text" class="form-control" value="<?php echo $otp_code; ?>" readonly style="font-size: 18px; letter-spacing: 8px; text-align: center; font-weight: bold; background-color: #d4edda;">
                                                </div>
                                                <div class="col-md-4">
                                                    <label style="display: block; margin-bottom: 5px;"><b>DE</b></label>
                                                    <div class="form-check" style="margin-top: 30px;">
                                                        <input type="checkbox" class="form-check-input" <?php echo ($de_checkbox == 1) ? 'checked' : ''; ?> disabled>
                                                        <label class="form-check-label">
                                                            DE-д хүргэгдэх
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label><b>Харилцагч</b></label>
                                            <input type="text" class="form-control" value="<?php echo $customer_name; ?>" readonly>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label><b>Статус</b></label>
                                            <input type="text" class="form-control" value="<?php echo $status; ?>" readonly>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label><b>Огноо</b></label>
                                            <input type="text" class="form-control" value="<?php echo $created_date; ?>" readonly>
                                        </div>
                                        
                                        <?php if (!empty($comment)): ?>
                                        <div class="form-group">
                                            <label><b>Тайлбар</b></label>
                                            <textarea class="form-control" readonly><?php echo $comment; ?></textarea>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <h5 class="card-title mt-4">Барааны тайлбар</h5>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Нэр</th>
                                                    <th>Тоо ширхэг</th>
                                                    <th>Үнэ ($)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($package1_name)): ?>
                                                <tr>
                                                    <td><input type="text" class="form-control" value="<?php echo $package1_name; ?>" readonly></td>
                                                    <td><input type="text" class="form-control" value="<?php echo $package1_num; ?>" readonly></td>
                                                    <td><input type="text" class="form-control" value="<?php echo $package1_price; ?>" readonly></td>
                                                </tr>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($package2_name)): ?>
                                                <tr>
                                                    <td><input type="text" class="form-control" value="<?php echo $package2_name; ?>" readonly></td>
                                                    <td><input type="text" class="form-control" value="<?php echo $package2_num; ?>" readonly></td>
                                                    <td><input type="text" class="form-control" value="<?php echo $package2_price; ?>" readonly></td>
                                                </tr>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($package3_name)): ?>
                                                <tr>
                                                    <td><input type="text" class="form-control" value="<?php echo $package3_name; ?>" readonly></td>
                                                    <td><input type="text" class="form-control" value="<?php echo $package3_num; ?>" readonly></td>
                                                    <td><input type="text" class="form-control" value="<?php echo $package3_price; ?>" readonly></td>
                                                </tr>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($package4_name)): ?>
                                                <tr>
                                                    <td><input type="text" class="form-control" value="<?php echo $package4_name; ?>" readonly></td>
                                                    <td><input type="text" class="form-control" value="<?php echo $package4_num; ?>" readonly></td>
                                                    <td><input type="text" class="form-control" value="<?php echo $package4_price; ?>" readonly></td>
                                                </tr>
                                                <?php endif; ?>
                                                
                                                <?php if (empty($package1_name) && empty($package2_name) && empty($package3_name) && empty($package4_name)): ?>
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted">Барааны мэдээлэл олдсонгүй</td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                        
                                        <?php if ($proxy_id > 0): ?>
                                        <div class="form-group mt-4">
                                            <label><b>Өөр хүн авах</b></label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" checked disabled>
                                                <label class="form-check-label">Идэвхтэй</label>
                                            </div>
                                            <div class="mt-2">
                                                <input type="text" class="form-control" value="<?php echo $proxy_name . ($proxy_tel ? ' - ' . $proxy_tel : ''); ?>" readonly>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <div class="mt-4">
                                            <a href="truck.php?action=list" class="btn btn-primary">Жагсаалт руу буцах</a>
                                            <a href="branch.php" class="btn btn-secondary">Dashboard руу буцах</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="alert alert-danger">
                            <strong>Алдаа:</strong> Мэдээлэл олдсонгүй.
                        </div>
                        <a href="truck.php?action=list" class="btn btn-primary">Жагсаалт руу буцах</a>
                        <?php
                    }
                } else {
                    ?>
                    <div class="alert alert-danger">
                        <strong>Алдаа:</strong> ID оруулаагүй байна.
                    </div>
                    <a href="truck.php?action=list" class="btn btn-primary">Жагсаалт руу буцах</a>
                    <?php
                }
            }
            ?>
          </div>
          <!-- Container-fluid Ends-->
        </div>
        <?php require_once("views/footer.php");?>
      </div>
    </div>
    <!-- latest jquery-->
    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <!-- feather icon js-->
    <script src="assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="assets/js/icons/feather-icon/feather-icon.js"></script>
    <!-- Sidebar jquery-->
    <script src="assets/js/sidebar-menu.js"></script>
    <script src="assets/js/config.js"></script>
    <!-- Bootstrap js-->
    <script src="assets/js/bootstrap/popper.min.js"></script>
    <script src="assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- Plugins JS start-->
    <script src="assets/js/chart/chartjs/chart.min.js"></script>
    <script src="assets/js/chart/chartist/chartist.js"></script>
    <script src="assets/js/chart/chartist/chartist-plugin-tooltip.js"></script>
    <script src="assets/js/chart/knob/knob.min.js"></script>
    <script src="assets/js/chart/apex-chart/apex-chart.js"></script>
    <script src="assets/js/chart/apex-chart/stock-prices.js"></script>
    <script src="assets/js/prism/prism.min.js"></script>
    <script src="assets/js/clipboard/clipboard.min.js"></script>
    <script src="assets/js/counter/jquery.waypoints.min.js"></script>
    <script src="assets/js/counter/jquery.counterup.min.js"></script>
    <script src="assets/js/counter/counter-custom.js"></script>
    <script src="assets/js/custom-card/custom-card.js"></script>
    <script src="assets/js/owlcarousel/owl.carousel.js"></script>
    <script src="assets/js/owlcarousel/owl-custom.js"></script>
    <script src="assets/js/dashboard/dashboard_2.js"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="assets/js/script.js"></script>
    <script>
        $(function() {
            feather.replace();
        });
    </script>
  </body>
</html>
