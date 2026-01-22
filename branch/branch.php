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
    
    // Handle RECEIVED action - Move to Prepared
    if (isset($_GET['action']) && $_GET['action'] == 'received') {
        $track = isset($_GET['track']) ? trim($_GET['track']) : '';
        $otp_code = isset($_GET['otp']) ? trim($_GET['otp']) : '';
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        
        if (!empty($track) && !empty($otp_code)) {
            $g_logged_id_escaped = mysqli_real_escape_string($conn, $g_logged_id);
            $track_escaped = mysqli_real_escape_string($conn, $track);
            $otp_escaped = mysqli_real_escape_string($conn, $otp_code);
            
            // Create green colored OTP code for comment
            $comment_with_otp = '<span style="color: green; font-weight: bold;">' . htmlspecialchars($otp_code) . '</span>';
            $comment_escaped = mysqli_real_escape_string($conn, $comment_with_otp);
            
            // Check if branch_inventory already exists for this track - Prepared Statements
            $g_logged_id_int = intval($g_logged_id);
            $stmt_check = mysqli_prepare($conn, "SELECT id FROM branch_inventories WHERE track = ? AND branch = ? LIMIT 1");
            if ($stmt_check) {
                mysqli_stmt_bind_param($stmt_check, "si", $track_escaped, $g_logged_id_int);
                mysqli_stmt_execute($stmt_check);
                $result_check = mysqli_stmt_get_result($stmt_check);
                mysqli_stmt_close($stmt_check);
            } else {
                // Fallback
                $result_check = @mysqli_query($conn, "SELECT id FROM branch_inventories WHERE track='$track_escaped' AND branch='$g_logged_id_escaped' LIMIT 1");
            }
            
            if ($result_check && mysqli_num_rows($result_check) > 0) {
                // Update existing record - Prepared Statements
                $stmt_update = mysqli_prepare($conn, "UPDATE branch_inventories SET track = ?, comment = ?, status = 'prepare' WHERE track = ? AND branch = ?");
                if ($stmt_update) {
                    mysqli_stmt_bind_param($stmt_update, "sssi", $track_escaped, $comment_escaped, $track_escaped, $g_logged_id_int);
                    $result_update = mysqli_stmt_execute($stmt_update);
                    mysqli_stmt_close($stmt_update);
                } else {
                    // Fallback
                    $result_update = @mysqli_query($conn, "UPDATE branch_inventories SET track='$track_escaped', comment='$comment_escaped', status='prepare' WHERE track='$track_escaped' AND branch='$g_logged_id_escaped'");
                }
                
                if ($result_update) {
                    $_SESSION['success_message'] = 'Item successfully moved to Prepared.';
                } else {
                    $_SESSION['error_message'] = 'Error: ' . mysqli_error($conn);
                }
            } else {
                // Insert new record - Prepared Statements
                $stmt_insert = mysqli_prepare($conn, "INSERT INTO branch_inventories (track, comment, status, branch, created_date) VALUES (?, ?, 'prepare', ?, NOW())");
                if ($stmt_insert) {
                    mysqli_stmt_bind_param($stmt_insert, "ssi", $track_escaped, $comment_escaped, $g_logged_id_int);
                    $result_insert = mysqli_stmt_execute($stmt_insert);
                    mysqli_stmt_close($stmt_insert);
                } else {
                    // Fallback
                    $result_insert = @mysqli_query($conn, "INSERT INTO branch_inventories (track, comment, status, branch, created_date) VALUES ('$track_escaped', '$comment_escaped', 'prepare', '$g_logged_id_escaped', NOW())");
                }
                
                if ($result_insert) {
                    $_SESSION['success_message'] = 'Item successfully added to Prepared.';
                } else {
                    $_SESSION['error_message'] = 'Error: ' . mysqli_error($conn);
                }
            }
        } else {
            $_SESSION['error_message'] = 'Track code or OTP code not found.';
        }
        
        // Redirect back to dashboard
        header('Location: branch.php');
        exit;
    }
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
            // Display success/error messages
            if (isset($_SESSION['success_message'])) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                echo htmlspecialchars($_SESSION['success_message']);
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';
                unset($_SESSION['success_message']);
            }
            if (isset($_SESSION['error_message'])) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo htmlspecialchars($_SESSION['error_message']);
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';
                unset($_SESSION['error_message']);
            }
            ?>
            <div class="row">               
              
                <div class="col-sm-6 col-xl-4 col-lg-6">
                  <div class="card o-hidden border-0">
                    <a href="#">
                      <div class="bg-secondary b-r-4 card-body">
                        <div class="media static-top-widget">
                          <div class="align-self-center text-center"><i data-feather="box"></i></div>
                          <div class="media-body"><span class="m-0">Inventory</span>
                            <?php
                              $sql = "SELECT id
                              FROM branch_inventories 
                              WHERE branch_inventories.branch='$g_logged_id' AND status='new'";
                              $result = mysqli_query($conn,$sql);
                              $products = mysqli_num_rows($result);
                            ?>
                            <h4 class="mb-0 counter"><?php echo $products;?></h4><i class="icon-bg" data-feather="box"></i>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
                
                <div class="col-sm-6 col-xl-4 col-lg-6">
                  <div class="card o-hidden border-0">
                    <a href="#">
                      <div class="bg-primary b-r-4 card-body">
                        <div class="media static-top-widget">
                          <div class="align-self-center text-center"><i data-feather="archive"></i></div>
                          <div class="media-body"><span class="m-0">Prepared</span>
                            <?php
                            $sql = "SELECT id
                            FROM branch_inventories 
                            WHERE branch_inventories.branch='$g_logged_id' AND status='prepare'";
                            $result = mysqli_query($conn,$sql);
                            $customers = mysqli_num_rows($result);
                            ?>
                            <h4 class="mb-0 counter"><?php echo $customers;?></h4><i class="icon-bg" data-feather="archive"></i>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>


                <div class="col-sm-6 col-xl-4 col-lg-6">
                  <div class="card o-hidden border-0">
                    <a href="#">
                      <div class="bg-danger b-r-4 card-body">
                        <div class="media static-top-widget">
                          <div class="align-self-center text-center"><i data-feather="truck"></i></div>
                          <div class="media-body"><span class="m-0">Last transported</span>
                            <?php
                             $sql = "SELECT id
                             FROM branch_transport ORDER BY id DESC LIMIT 1";
                              $result = mysqli_query($conn,$sql);
                              $data = mysqli_fetch_array($result);
                              $transport_id = ($data && isset($data["id"])) ? $data["id"] : 0;
                              $sql = "SELECT id
                              FROM branch_inventories 
                              WHERE branch_inventories.branch='$g_logged_id' AND status='transport' AND transport='$transport_id'";
                              // echo $sql;
                              $result = mysqli_query($conn,$sql);
                              $total = mysqli_num_rows($result);
                            ?>
                            <h4 class="mb-0 counter"><?php echo number_format($total);?></h4><i class="icon-bg" data-feather="truck"></i>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>

            </div>
            
            <!-- Truck Information Table -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Truck Information (Items with OTP Code)</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Track Code</th>
                                            <th>OTP Code</th>
                                            <th>DE</th>
                                            <th>Customer</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $g_logged_id_escaped = mysqli_real_escape_string($conn, $g_logged_id);
                                        
                                        // Get all DE checked items with OTP codes that are NOT yet in Prepared status
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
                                        LEFT JOIN branch_inventories bi ON bi.track = o.third_party AND bi.branch='$g_logged_id_escaped' AND bi.status='prepare'
                                        WHERE o.otp_code IS NOT NULL 
                                        AND o.otp_code != ''
                                        AND o.de_checkbox = 1
                                        AND bi.id IS NULL
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
                                                if (empty($status) || $status == '-') {
                                                    $status = isset($data["inventory_date"]) ? 'new' : '-';
                                                }
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
                                                        <span class="badge text-white" style="background-color: #22c55e; font-size: 16px; padding: 6px 12px; font-weight: normal;"><?php echo $otp_code; ?></span>
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
                                                        <?php if ($status != '-'): ?>
                                                            <span class="badge bg-info text-white"><?php echo $status; ?></span>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo $created_date; ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm received-btn" style="background-color: #22c55e; border-color: #22c55e; color: white; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#16a34a'; this.style.borderColor='#16a34a';" onmouseout="this.style.backgroundColor='#22c55e'; this.style.borderColor='#22c55e';" data-track="<?php echo htmlspecialchars($track); ?>" data-otp="<?php echo htmlspecialchars($otp_code); ?>" data-order-id="<?php echo $order_id; ?>">RECEIVED</a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        
                                        if ($truck_count == 0) {
                                            ?>
                                            <tr>
                                                <td colspan="8" class="text-center text-muted">No information found</td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php if ($truck_count > 0): ?>
                                    <div class="mt-3 text-end">
                                        <strong>Total: <?php echo $truck_count; ?> items</strong>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Custom Confirm Modal -->
            <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
                        <div class="modal-header" style="border-bottom: 1px solid #e9ecef; padding: 20px 24px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px 12px 0 0;">
                            <h5 class="modal-title" id="confirmModalLabel" style="color: white; font-weight: 600; font-size: 18px;">MR. STEVEN</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="padding: 30px 24px; text-align: center;">
                            <div style="margin-bottom: 20px;">
                                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin: 0 auto;">
                                    <circle cx="12" cy="12" r="10" stroke="#22c55e" stroke-width="2" fill="none"/>
                                    <path d="M8 12l2 2 4-4" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <p style="font-size: 16px; color: #495057; margin: 0; line-height: 1.6;">Move this item to Prepared?</p>
                        </div>
                        <div class="modal-footer" style="border-top: 1px solid #e9ecef; padding: 20px 24px; justify-content: center; gap: 12px;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="min-width: 100px; padding: 10px 20px; border-radius: 8px; font-weight: 500;">Cancel</button>
                            <button type="button" class="btn" id="confirmYesBtn" style="background-color: #22c55e; border-color: #22c55e; color: white; min-width: 100px; padding: 10px 20px; border-radius: 8px; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#16a34a'; this.style.borderColor='#16a34a';" onmouseout="this.style.backgroundColor='#22c55e'; this.style.borderColor='#22c55e';">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 6px; vertical-align: middle;">
                                    <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Confirm
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
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
    <link href="assets/js/summernote/summernote.min.css" rel="stylesheet">
    <script src="assets/js/summernote/summernote.min.js"></script>

    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="assets/js/script.js"></script>
    <!-- login js-->
    <script>
          // Custom confirm dialog for RECEIVED button
          $(document).ready(function() {
              var confirmUrl = '';
              
              $('.received-btn').on('click', function(e) {
                  e.preventDefault();
                  var track = $(this).data('track');
                  var otp = $(this).data('otp');
                  var orderId = $(this).data('order-id');
                  
                  confirmUrl = '?action=received&track=' + encodeURIComponent(track) + '&otp=' + encodeURIComponent(otp) + '&order_id=' + orderId;
                  
                  $('#confirmModal').modal('show');
              });
              
              $('#confirmYesBtn').on('click', function() {
                  if (confirmUrl) {
                      window.location.href = confirmUrl;
                  }
              });
              
              // Auto refresh function - only between 9:00 AM - 17:00 PM (DE/USA timezone), every 30 minutes
              function shouldAutoRefresh() {
                  // Get current time in DE/USA timezone (UTC+1 for DE, UTC-5 to UTC-8 for USA)
                  // Using UTC+1 (Central European Time) as default
                  var now = new Date();
                  var utcTime = now.getTime() + (now.getTimezoneOffset() * 60000);
                  var deTime = new Date(utcTime + (1 * 3600000)); // UTC+1 for DE
                  
                  var hours = deTime.getHours();
                  var minutes = deTime.getMinutes();
                  
                  // Check if time is between 9:00 AM (9:00) and 17:00 PM (17:00)
                  if (hours >= 9 && hours < 17) {
                      return true;
                  }
                  return false;
              }
              
              function startAutoRefresh() {
                  // Clear any existing interval
                  if (window.autoRefreshInterval) {
                      clearInterval(window.autoRefreshInterval);
                  }
                  
                  // Check if we should refresh now
                  if (shouldAutoRefresh()) {
                      // Refresh every 30 minutes (1800000 milliseconds)
                      window.autoRefreshInterval = setInterval(function() {
                          // Only refresh if modal is not open and time is still in range
                          if (!$('#confirmModal').hasClass('show') && shouldAutoRefresh()) {
                              location.reload();
                          } else if (!shouldAutoRefresh()) {
                              // Stop refreshing if outside time range
                              clearInterval(window.autoRefreshInterval);
                          }
                      }, 1800000); // 30 minutes
                  }
              }
              
              // Start auto refresh on page load
              startAutoRefresh();
              
              // Check every minute if we should start/stop auto refresh
              setInterval(function() {
                  if (shouldAutoRefresh() && !window.autoRefreshInterval) {
                      startAutoRefresh();
                  } else if (!shouldAutoRefresh() && window.autoRefreshInterval) {
                      clearInterval(window.autoRefreshInterval);
                      window.autoRefreshInterval = null;
                  }
              }, 60000); // Check every minute
              
              // Clear interval when page is hidden (tab switched)
              document.addEventListener('visibilitychange', function() {
                  if (document.hidden) {
                      if (window.autoRefreshInterval) {
                          clearInterval(window.autoRefreshInterval);
                          window.autoRefreshInterval = null;
                      }
                  } else {
                      // Restart interval when page becomes visible
                      startAutoRefresh();
                  }
              });
          });
          
          $(function() {
                $('#summernote').summernote({
                    height: ($(window).height() - 300),
                    callbacks: {
                        onImageUpload: function(image) {
                            uploadImage(image[0]);
                        }
                    }
                });

                function uploadImage(image) {
                    var data = new FormData();
                    data.append("image", image);
                    $.ajax({
                        url: 'views/uploader.php',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: data,
                        type: "post",
                        success: function(url) {
                            var image = $('<img>').attr('src', '<?php echo settings("base_url");?>' + url);
                            $('#summernote').summernote("insertNode", image[0]);
                        },
                        error: function(data) {
                            //alert("adsada");
                            //console.log(data);
                        }
                    });
                };

            });
     
          
            
    </script>
    <!-- Plugin used-->
  </body>
</html>