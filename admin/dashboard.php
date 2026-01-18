<?php
    require_once("config.php");
    require_once("views/helper.php");
    require_once("views/login_check.php");
    require_once("views/init.php");
?>
<body class="sidebar-dark">
	<div class="main-wrapper">
		<?php require_once("views/navbar.php"); ?>
	
		<div class="page-wrapper">
      <?php require_once("views/sidebar.php"); ?>
			

			<div class="page-content">
				<div class="row">
					<div class="col-12 col-xl-12 stretch-card">
						<div class="row flex-grow">
							<div class="col-md-4 grid-margin stretch-card">
								<div class="card">
									<div class="card-body">
										<div class="d-flex justify-content-between align-items-baseline">
											<h6 class="card-title mb-0">Тээврийн зардал</h6>
											<div class="dropdown mb-2">
												<button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
												</button>
												<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<a class="dropdown-item d-flex align-items-center" href="settings.php?action=edit&id=53"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Тээврийн зардал</span></a>
												<a class="dropdown-item d-flex align-items-center" href="settings.php?action=edit&id=52"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Бага зардал</span></a>
												</div>
											</div>
										</div>
										<div class="row">
										<div class="col-4 col-md-12 col-xl-6">
											<?php
											$paymentrate = 0;
											$paymentrate_temp = settings("paymentrate");
											if (!empty($paymentrate_temp) && $paymentrate_temp !== '') {
												$paymentrate = $paymentrate_temp;
											}
											?>
											<h3 class="mb-2"><?php echo number_format($paymentrate);?>$</h3>
											<?php
											$paymentrate_min = 0;
											$paymentrate_min_temp = settings("paymentrate_min");
											if (!empty($paymentrate_min_temp) && $paymentrate_min_temp !== '') {
												$paymentrate_min = $paymentrate_min_temp;
											}
											?>
											<div class="d-flex align-items-baseline">
											<p class="text-primary">
												<span>Хамгийн бага зардал:<?php echo $paymentrate_min;?>$</span>
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
											<h6 class="card-title mb-0">Ханш</h6>
											<div class="dropdown mb-2">
												<button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
												</button>
												<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<!-- <a class="dropdown-item d-flex align-items-center" href="rates?action=statistics"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a> -->
												<a class="dropdown-item d-flex align-items-center" href="settings.php?action=edit&id=51"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
												</div>
											</div>
										</div>
										<div class="row">
										<div class="col-4 col-md-12 col-xl-6">
											<?php
											$current = 0;
											$current_temp = settings("rate");
											if (!empty($current_temp) && $current_temp !== '') {
												$current = $current_temp;
											}
											?>
											<h3 class="mb-2"><?php echo number_format($current);?></h3>
											<?php
											$last = 0;
											$sql = "SELECT * FROM rates ORDER by timestamp DESC LIMIT 1,1";
											$result = mysqli_query($conn,$sql);
											if ($result && mysqli_num_rows($result) > 0) {
												$data = mysqli_fetch_array($result);
												$last = isset($data["rate"]) ? $data["rate"] : 0;
											}
											?>
											<div class="d-flex align-items-baseline">
											<p class="<?php echo ($current>$last)?'text-success':'text-danger';?>">
												<span>
													<?php
													if ($last > 0) {
														echo ($current>$last)?'+':'-';
														echo round(((abs($current-$last)*100)/$last),2);
													} else {
														echo '0';
													}
													?>%
												</span>
												<i data-feather="<?php echo ($current>$last)?'arrow-up':'arrow-down';?>" class="icon-sm mb-1"></i>
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
						</div>
					</div>
					</div> <!-- row -->
        
        <!-- Feedback Preview Section -->
        <div class="row mt-4">
          <div class="col-12 col-xl-12 stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-3">
                  <h6 class="card-title mb-0">Шинэ зурваснууд</h6>
                  <a href="feedback" class="btn btn-sm btn-primary">Бүгдийг харах</a>
                </div>
                <div class="table-responsive">
                  <?php
                  // Get recent feedback messages
                  $feedback_preview_count = 0;
                  $recent_feedbacks_preview = array();
                  
                  if (isset($conn) && $conn) {
                    // Check if role column exists
                    $check_role_sql = "SHOW COLUMNS FROM feedback LIKE 'role'";
                    $role_exists = false;
                    $check_result = mysqli_query($conn, $check_role_sql);
                    if ($check_result && mysqli_num_rows($check_result) > 0) {
                      $role_exists = true;
                    }
                    
                    // Get recent user feedbacks (not admin replies)
                    if ($role_exists) {
                      $preview_sql = "SELECT id, title, content, name, email, timestamp, `read`, COALESCE(role, 'user') AS role 
                                    FROM feedback 
                                    WHERE archive=0 AND (role='user' OR role IS NULL OR role='') 
                                    ORDER BY timestamp DESC LIMIT 5";
                    } else {
                      $preview_sql = "SELECT id, title, content, name, email, timestamp, `read` 
                                    FROM feedback 
                                    WHERE archive=0 
                                    ORDER BY timestamp DESC LIMIT 5";
                    }
                    
                    $preview_result = mysqli_query($conn, $preview_sql);
                    if ($preview_result && mysqli_num_rows($preview_result) > 0) {
                      while ($preview_data = mysqli_fetch_array($preview_result)) {
                        $recent_feedbacks_preview[] = $preview_data;
                        $feedback_preview_count++;
                      }
                    }
                  }
                  
                  if ($feedback_preview_count > 0): ?>
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Гарчиг</th>
                        <th>Илгээсэн</th>
                        <th>Харилцагч</th>
                        <th>Цаг</th>
                        <th>Үйлдэл</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($recent_feedbacks_preview as $preview_feedback): ?>
                        <?php
                        $preview_id = isset($preview_feedback["id"]) ? intval($preview_feedback["id"]) : 0;
                        $preview_title = isset($preview_feedback["title"]) ? htmlspecialchars($preview_feedback["title"]) : '';
                        $preview_content = isset($preview_feedback["content"]) ? htmlspecialchars($preview_feedback["content"]) : '';
                        $preview_name = isset($preview_feedback["name"]) ? htmlspecialchars($preview_feedback["name"]) : '';
                        $preview_email = isset($preview_feedback["email"]) ? htmlspecialchars($preview_feedback["email"]) : '';
                        $preview_timestamp = isset($preview_feedback["timestamp"]) ? htmlspecialchars($preview_feedback["timestamp"]) : '';
                        $preview_read = isset($preview_feedback["read"]) ? intval($preview_feedback["read"]) : 0;
                        
                        // Format content preview
                        $content_preview = mb_substr($preview_content, 0, 80, 'UTF-8');
                        if (mb_strlen($preview_content, 'UTF-8') > 80) {
                          $content_preview .= '...';
                        }
                        
                        // Format time
                        $time_display = '';
                        if ($preview_timestamp) {
                          $timestamp = strtotime($preview_timestamp);
                          $diff = time() - $timestamp;
                          if ($diff < 3600) {
                            $time_display = floor($diff / 60) . ' мин';
                          } elseif ($diff < 86400) {
                            $time_display = floor($diff / 3600) . ' цаг';
                          } else {
                            $time_display = date('Y-m-d H:i', $timestamp);
                          }
                        }
                        ?>
                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <?php if ($preview_read == 0): ?>
                              <span class="badge badge-danger mr-2">Шинэ</span>
                              <?php endif; ?>
                              <strong><?php echo $preview_title; ?></strong>
                            </div>
                            <small class="text-muted"><?php echo $content_preview; ?></small>
                          </td>
                          <td><?php echo $preview_name; ?></td>
                          <td><?php echo $preview_email; ?></td>
                          <td><?php echo $time_display; ?></td>
                          <td>
                            <a href="feedback?action=chat&id=<?php echo $preview_id; ?>" class="btn btn-sm btn-primary">Харах</a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                  <?php else: ?>
                  <div class="alert alert-info mb-0" role="alert">
                    <i data-feather="check-circle" class="mr-2"></i>
                    Шинэ зурвас байхгүй. Бүх зурвас шийдвэрлэгдсэн.
                  </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>

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
	
	<!-- Notification Auto-Refresh -->
	<script>
	(function() {
		// Update notification badge and count every 30 seconds
		function updateNotificationBadge() {
			fetch('api/feedback_count.php')
				.then(response => response.json())
				.then(data => {
					const count = data.count || 0;
					const notificationLink = document.querySelector('.nav-notifications .nav-link');
					const notificationBadge = document.querySelector('#notificationDropdown .badge');
					const notificationHeader = document.querySelector('#notificationDropdown .dropdown-header .badge');
					const sidebarBadge = document.querySelector('a[href="feedback"] .badge');
					
					// Update navbar notification indicator
					if (notificationLink) {
						let indicator = notificationLink.querySelector('.indicator');
						if (count > 0) {
							if (!indicator) {
								indicator = document.createElement('div');
								indicator.className = 'indicator';
								indicator.innerHTML = '<div class="circle"></div>';
								notificationLink.appendChild(indicator);
							}
						} else {
							if (indicator) {
								indicator.remove();
							}
						}
					}
					
					// Update notification badge in dropdown header
					if (notificationHeader) {
						if (count > 0) {
							notificationHeader.textContent = count + ' New';
							notificationHeader.style.display = 'inline-block';
						} else {
							notificationHeader.style.display = 'none';
						}
					}
					
					// Update sidebar badge
					if (sidebarBadge) {
						if (count > 0) {
							sidebarBadge.textContent = count;
							sidebarBadge.style.display = 'inline-block';
						} else {
							sidebarBadge.style.display = 'none';
						}
					} else if (count > 0) {
						// Add badge if it doesn't exist
						const feedbackLink = document.querySelector('a[href="feedback"]');
						if (feedbackLink) {
							const badge = document.createElement('span');
							badge.className = 'badge badge-danger ml-auto';
							badge.textContent = count;
							feedbackLink.appendChild(badge);
						}
					}
				})
				.catch(error => {
					console.error('Error updating notifications:', error);
				});
		}
		
		// Update immediately and then every 30 seconds
		updateNotificationBadge();
		setInterval(updateNotificationBadge, 30000);
	})();
	</script>

	<!-- endinject -->

</body>
</html>    