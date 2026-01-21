<?php $current_page = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);?>
<?php 
	$logged_name = isset($_SESSION["name"]) ? $_SESSION["name"] : "Admin";
	$logged_avatar = isset($_SESSION["avatar"]) ? $_SESSION["avatar"] : "assets/images/logo.png";
	$logged_rights = isset($_SESSION["rights"]) ? $_SESSION["rights"] : "admin";
	
		// Зурвас тоолох - role талбарыг харгалзан
		$feedback_count = 0;
		$recent_feedbacks = array();
		if (isset($conn) && $conn) {
			// Count all active messages (user and admin)
			$feedback_sql = "SELECT COUNT(*) as count FROM feedback WHERE archive=0";
			$feedback_result = mysqli_query($conn, $feedback_sql);
			if ($feedback_result) {
				$feedback_row = mysqli_fetch_array($feedback_result);
				if ($feedback_row && isset($feedback_row["count"])) {
					$feedback_count = intval($feedback_row["count"]);
				}
			}
			
			// Шинэ зурваснуудыг авах - role талбарыг оролцуулах
			if ($feedback_count > 0) {
				// Check if role column exists (backward compatibility)
				$check_role_sql = "SHOW COLUMNS FROM feedback LIKE 'role'";
				$role_exists = false;
				$check_result = mysqli_query($conn, $check_role_sql);
				if ($check_result && mysqli_num_rows($check_result) > 0) {
					$role_exists = true;
				}
				
				// Build query - backward compatible: if role column doesn't exist, don't select it
				if ($role_exists) {
					$recent_feedback_sql = "SELECT id, title, content, name, contact, email, timestamp, `read` AS read_status, COALESCE(role, 'user') AS role FROM feedback WHERE archive=0 ORDER BY timestamp DESC LIMIT 8";
				} else {
					$recent_feedback_sql = "SELECT id, title, content, name, contact, email, timestamp, `read` AS read_status FROM feedback WHERE archive=0 ORDER BY timestamp DESC LIMIT 8";
				}
				$recent_feedback_result = mysqli_query($conn, $recent_feedback_sql);
				if ($recent_feedback_result) {
					$num_rows = mysqli_num_rows($recent_feedback_result);
					if ($num_rows > 0) {
						while ($recent_feedback = mysqli_fetch_array($recent_feedback_result)) {
							if ($recent_feedback && is_array($recent_feedback)) {
								// ID болон read талбарыг баталгаажуулах
								if (!isset($recent_feedback["id"]) || empty($recent_feedback["id"])) {
									$recent_feedback["id"] = 0;
								}
								// read_status гэж alias хийсэн тул read_status гэж хайх
								if (!isset($recent_feedback["read_status"])) {
									$recent_feedback["read_status"] = isset($recent_feedback["read"]) ? $recent_feedback["read"] : 0;
								}
								// read гэсэн key-г нэмэх (display кодонд ашигладаг)
								$recent_feedback["read"] = $recent_feedback["read_status"];
								// role талбарыг баталгаажуулах (backward compatibility)
								if (!isset($recent_feedback["role"]) || empty($recent_feedback["role"])) {
									$recent_feedback["role"] = "user";
								}
								// If role column doesn't exist in DB, default to 'user'
								if (!$role_exists) {
									$recent_feedback["role"] = "user";
								}
								$recent_feedbacks[] = $recent_feedback;
							}
						}
					}
				}
			}
		}
?>
<nav class="navbar" style="display: flex; align-items: center; flex-wrap: nowrap;">
	<a href="#" class="sidebar-toggler">
		<i data-feather="menu"></i>
	</a>
	<!-- Bell Icon - Logo хажууд -->
	<div class="nav-item dropdown nav-notifications" style="display: inline-flex; align-items: center; margin-left: 12px; position: relative; flex-shrink: 0;">
		<a class="nav-link dropdown-toggle" href="feedback" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="position: relative; display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 8px; transition: all 0.2s; color: white !important; padding: 0;">
			<i data-feather="bell" style="width: 20px; height: 20px;"></i>
			<?php if ($feedback_count > 0): ?>
			<div class="indicator" style="position: absolute; top: 6px; right: 6px;">
				<div class="circle" style="width: 8px; height: 8px; background-color: #ef4444; border-radius: 50%; border: 2px solid #1e293b;"></div>
			</div>
			<?php endif; ?>
		</a>
		<div class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="width: 380px;">
			<div class="dropdown-header d-flex align-items-center justify-content-between">
				<div class="d-flex align-items-center">
					<i data-feather="bell" class="me-2"></i>
					<p class="mb-0 font-weight-medium">Notification</p>
				</div>
				<?php if ($feedback_count > 0): ?>
				<span class="badge badge-primary"><?php echo $feedback_count; ?> New</span>
				<?php endif; ?>
			</div>
			<div class="dropdown-body" style="max-height: 400px; overflow-y: auto;">
				<?php if ($feedback_count > 0 && count($recent_feedbacks) > 0): ?>
					<?php foreach ($recent_feedbacks as $recent_feedback): ?>
						<?php
						$feedback_id = isset($recent_feedback["id"]) ? intval($recent_feedback["id"]) : 0;
						$feedback_title = isset($recent_feedback["title"]) ? htmlspecialchars($recent_feedback["title"]) : '';
						$feedback_content = isset($recent_feedback["content"]) ? htmlspecialchars($recent_feedback["content"]) : '';
						$feedback_name = isset($recent_feedback["name"]) ? htmlspecialchars($recent_feedback["name"]) : '';
						$feedback_contact = isset($recent_feedback["contact"]) ? htmlspecialchars($recent_feedback["contact"]) : '';
						$feedback_email = isset($recent_feedback["email"]) ? htmlspecialchars($recent_feedback["email"]) : '';
						$feedback_read = isset($recent_feedback["read"]) ? intval($recent_feedback["read"]) : 0;
						$feedback_timestamp = isset($recent_feedback["timestamp"]) ? htmlspecialchars($recent_feedback["timestamp"]) : '';
						$feedback_role = isset($recent_feedback["role"]) && !empty($recent_feedback["role"]) ? htmlspecialchars($recent_feedback["role"]) : "user";
						$is_admin_notif = ($feedback_role == "admin");
						
						// Хугацааны тооцоо
						$time_ago = '';
						if ($feedback_timestamp) {
							$timestamp = strtotime($feedback_timestamp);
							$diff = time() - $timestamp;
							if ($diff < 60) {
								$time_ago = $diff . ' sec ago';
							} elseif ($diff < 3600) {
								$time_ago = floor($diff / 60) . ' min ago';
							} elseif ($diff < 86400) {
								$time_ago = floor($diff / 3600) . 'h ago';
							} elseif ($diff < 604800) {
								$days = floor($diff / 86400);
								$time_ago = $days . ($days == 1 ? ' day ago' : ' days ago');
							} else {
								$time_ago = date('M d', $timestamp);
							}
						}
						
						// Нэрний эхний үсэг
						$initials = mb_substr($feedback_name, 0, 1, 'UTF-8');
						if (empty($initials) && !empty($feedback_email)) {
							$initials = mb_substr($feedback_email, 0, 1, 'UTF-8');
						}
						if (empty($initials)) {
							$initials = '?';
						}
						$initials = mb_strtoupper($initials, 'UTF-8');
						
						// Агуулгын богино хувилбар
						$short_content = mb_substr($feedback_content, 0, 50, 'UTF-8');
						if (mb_strlen($feedback_content, 'UTF-8') > 50) {
							$short_content .= '...';
						}
						?>
						<a href="feedback" class="dropdown-item d-flex align-items-start" style="padding: 12px 16px; border-bottom: 1px solid #f0f0f0;">
							<div class="figure me-3" style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
								<span style="color: white; font-weight: bold; font-size: 16px;"><?php echo $initials; ?></span>
							</div>
							<div class="content flex-grow-1" style="min-width: 0;">
								<div class="d-flex justify-content-between align-items-start mb-1">
									<div style="flex-grow: 1;">
										<p class="mb-0" style="font-size: 14px; font-weight: 500; color: #333; line-height: 1.4;">
											<?php echo $feedback_title; ?>
										</p>
										<span class="badge badge-<?php echo $is_admin_notif ? 'danger' : 'primary'; ?>" style="font-size: 10px; margin-top: 4px;">
											<?php echo $is_admin_notif ? 'ADMIN' : ($feedback_contact ? $feedback_contact : 'USER'); ?>
										</span>
									</div>
									<?php if ($feedback_read == 0): ?>
									<span class="badge badge-primary" style="width: 8px; height: 8px; border-radius: 50%; background: #5e72e4; flex-shrink: 0; margin-left: 8px; margin-top: 4px;"></span>
									<?php endif; ?>
								</div>
								<?php if (!empty($short_content)): ?>
								<p class="mb-1" style="font-size: 13px; color: #666; line-height: 1.4;">
									<?php echo $short_content; ?>
								</p>
								<?php endif; ?>
								<p class="mb-0" style="font-size: 12px; color: #999;">
									<?php echo $feedback_name; ?> · <?php echo $time_ago; ?>
								</p>
							</div>
						</a>
					<?php endforeach; ?>
				<?php else: ?>
					<div class="dropdown-item text-center" style="padding: 40px 20px;">
						<i data-feather="check-circle" style="width: 48px; height: 48px; color: #ccc; margin-bottom: 12px;"></i>
						<p class="mb-0" style="color: #999; font-size: 14px;">Шинэ зурвас байхгүй</p>
						<p class="mb-0 mt-1" style="color: #ccc; font-size: 12px;">Бүх зурвас шийдвэрлэгдсэн</p>
					</div>
				<?php endif; ?>
			</div>
			<?php if ($feedback_count > 0): ?>
			<div class="dropdown-footer d-flex align-items-center justify-content-center" style="padding: 12px; border-top: 1px solid #f0f0f0;">
				<a href="feedback" style="color: #5e72e4; text-decoration: none; font-weight: 500; font-size: 14px;">View all notifications</a>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="navbar-content">
		<style>
			.olglot-btn {
				display: inline-flex;
				align-items: center;
				justify-content: center;
				gap: 8px;
				padding: 6px 16px;
				background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
				color: #ffffff !important;
				text-decoration: none;
				border-radius: 6px;
				font-weight: 500;
				font-size: 12px;
				letter-spacing: 0.3px;
				border: none;
				box-shadow: 0 2px 4px rgba(99, 102, 241, 0.2);
				transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
				text-transform: none;
				cursor: pointer;
				position: relative;
				vertical-align: middle;
				overflow: hidden;
				white-space: nowrap;
			}
			.olglot-btn::before {
				content: '';
				position: absolute;
				top: 0;
				left: -100%;
				width: 100%;
				height: 100%;
				background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
				transition: left 0.5s;
			}
			.olglot-btn:hover::before {
				left: 100%;
			}
			.olglot-btn:hover {
				transform: translateY(-1px);
				box-shadow: 0 4px 8px rgba(99, 102, 241, 0.3);
				background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
			}
			.olglot-btn:active {
				transform: translateY(0);
				box-shadow: 0 2px 4px rgba(99, 102, 241, 0.2);
			}
			.olglot-btn i {
				width: 16px;
				height: 16px;
				flex-shrink: 0;
			}
			.barcode-btn {
				display: inline-flex;
				align-items: center;
				justify-content: center;
				gap: 8px;
				padding: 6px 16px;
				background: linear-gradient(135deg, #10b981 0%, #059669 100%);
				color: #ffffff !important;
				text-decoration: none;
				border-radius: 6px;
				font-weight: 500;
				font-size: 12px;
				letter-spacing: 0.3px;
				border: none;
				box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
				transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
				text-transform: none;
				cursor: pointer;
				position: absolute;
				left: 180px;
				top: 50%;
				transform: translateY(-50%);
				overflow: hidden;
			}
			.barcode-btn::before {
				content: '';
				position: absolute;
				top: 0;
				left: -100%;
				width: 100%;
				height: 100%;
				background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
				transition: left 0.5s;
			}
			.barcode-btn:hover::before {
				left: 100%;
			}
			.barcode-btn:hover {
				transform: translateY(-50%) translateY(-1px);
				box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
				background: linear-gradient(135deg, #059669 0%, #047857 100%);
			}
			.barcode-btn:active {
				transform: translateY(-50%);
				box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
			}
			.barcode-btn i {
				width: 16px;
				height: 16px;
				flex-shrink: 0;
			}
			.navbar {
				display: flex !important;
				align-items: center !important;
				flex-wrap: nowrap !important;
			}
			.navbar-content {
				position: relative;
				display: flex;
				align-items: center;
				flex-wrap: nowrap;
				flex: 1;
				margin-left: 12px;
			}
			.nav-group {
				display: inline-flex;
				align-items: center;
				gap: 8px;
				flex-wrap: nowrap;
			}
			.navbar-nav {
				display: flex;
				align-items: center;
				gap: 8px;
				margin-left: auto;
			}
			.nav-notifications {
				display: inline-flex !important;
				align-items: center;
				margin-left: 12px;
				position: relative;
				z-index: 10;
			}
			.nav-notifications .nav-link {
				position: relative;
				display: flex !important;
				align-items: center;
				justify-content: center;
				width: 40px;
				height: 40px;
				border-radius: 8px;
				transition: all 0.2s;
				color: white !important;
				padding: 0 !important;
			}
			.nav-notifications .nav-link:hover {
				background-color: rgba(255, 255, 255, 0.1);
			}
			.nav-notifications .nav-link i {
				width: 20px !important;
				height: 20px !important;
			}
			.nav-notifications .indicator {
				position: absolute;
				top: 6px;
				right: 6px;
			}
			.nav-notifications .indicator .circle {
				width: 8px;
				height: 8px;
				background-color: #ef4444;
				border-radius: 50%;
				border: 2px solid #1e293b;
			}
		</style>
		<?php 
		// Determine mode based on current page
		$nav_mode = "DEFAULT";
		if ($current_page == "deliver") {
			$nav_mode = "FULFILLMENT_MODE";
		} elseif ($current_page == "barcodes") {
			$nav_mode = "BARCODE_MODE";
		}
		
		if ($nav_mode == "FULFILLMENT_MODE"): ?>
			<div class="nav-group" data-mode="FULFILLMENT_MODE">
				<?php require_once("views/deliver_nav.php");?>
			</div>
		<?php elseif ($nav_mode == "BARCODE_MODE"): ?>
			<div class="nav-group" data-mode="BARCODE_MODE">
				<?php require_once("views/barcodes_nav.php");?>
			</div>
		<?php else: ?>
			<div class="nav-group" data-mode="DEFAULT">
				<a href="deliver?action=initiate" class="olglot-btn">
					<i data-feather="package"></i>
					ОЛГОЛТ
				</a>
				<a href="barcodes?action=insert" class="barcode-btn">
					<i data-feather="box"></i>
					БАРКОД ОРУУЛАХ
				</a>
			</div>
		<?php endif; ?>
		<?php if ($current_page=="products") require_once("views/product_nav.php");?> 
		<?php if (in_array($current_page, ["news","news_category"])) require_once("views/news_nav.php");?> 
		<?php if ($current_page=="customers") require_once("views/customer_nav.php");?> 
		<?php if ($current_page=="online") require_once("views/online_nav.php");?> 
		<?php if ($current_page=="envoices") require_once("views/envoices_nav.php");?> 
		<?php if ($current_page=="orders") require_once("views/orders_nav.php");?> 
		<?php if ($current_page=="barcodes") require_once("views/barcodes_nav.php");?> 
		<?php if ($current_page=="boxes") require_once("views/boxes_nav.php");?> 
		<?php if ($current_page=="gaali") require_once("views/gaali_nav.php");?> 
		<?php if ($current_page=="upost") require_once("views/upost_nav.php");?> 
		<?php if ($current_page=="agents") require_once("views/agents_nav.php");?> 
		<?php if ($current_page=="tracks") require_once("views/tracks_nav.php");?> 
		<?php if ($current_page=="container") require_once("views/container_nav.php");?> 

		

		<ul class="navbar-nav">
			<li class="nav-item dropdown nav-apps">
				<a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i data-feather="grid"></i>
				</a>
				<div class="dropdown-menu" aria-labelledby="appsDropdown">
					<div class="dropdown-header d-flex align-items-center justify-content-between">
						<p class="mb-0 font-weight-medium">Web Apps</p>
						<a href="javascript:;" class="text-muted">Edit</a>
					</div>
					<div class="dropdown-body">
						<div class="d-flex align-items-center apps">
							<a href="pages/apps/chat.html"><i data-feather="message-square" class="icon-lg"></i><p>Chat</p></a>
							<a href="pages/apps/calendar.html"><i data-feather="calendar" class="icon-lg"></i><p>Calendar</p></a>
							<a href="pages/email/inbox.html"><i data-feather="mail" class="icon-lg"></i><p>Email</p></a>
							<a href="pages/general/profile.html"><i data-feather="instagram" class="icon-lg"></i><p>Profile</p></a>
						</div>
					</div>
					<div class="dropdown-footer d-flex align-items-center justify-content-center">
						<a href="javascript:;">View all</a>
					</div>
				</div>
			</li>
			<li class="nav-item dropdown nav-messages">
				<a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i data-feather="mail"></i>
				</a>
				<div class="dropdown-menu" aria-labelledby="messageDropdown">
					<div class="dropdown-header d-flex align-items-center justify-content-between">
						<p class="mb-0 font-weight-medium">9 New Messages</p>
						<a href="javascript:;" class="text-muted">Clear all</a>
					</div>
					<div class="dropdown-body">
						<a href="javascript:;" class="dropdown-item">
							<div class="figure">
								<img src="https://via.placeholder.com/30x30" alt="userr">
							</div>
							<div class="content">
								<div class="d-flex justify-content-between align-items-center">
									<p>Leonardo Payne</p>
									<p class="sub-text text-muted">2 min ago</p>
								</div>	
								<p class="sub-text text-muted">Project status</p>
							</div>
						</a>
						<a href="javascript:;" class="dropdown-item">
							<div class="figure">
								<img src="https://via.placeholder.com/30x30" alt="userr">
							</div>
							<div class="content">
								<div class="d-flex justify-content-between align-items-center">
									<p>Carl Henson</p>
									<p class="sub-text text-muted">30 min ago</p>
								</div>	
								<p class="sub-text text-muted">Client meeting</p>
							</div>
						</a>
						<a href="javascript:;" class="dropdown-item">
							<div class="figure">
								<img src="https://via.placeholder.com/30x30" alt="userr">
							</div>
							<div class="content">
								<div class="d-flex justify-content-between align-items-center">
									<p>Jensen Combs</p>												
									<p class="sub-text text-muted">1 hrs ago</p>
								</div>	
								<p class="sub-text text-muted">Project updates</p>
							</div>
						</a>
						<a href="javascript:;" class="dropdown-item">
							<div class="figure">
								<img src="https://via.placeholder.com/30x30" alt="userr">
							</div>
							<div class="content">
								<div class="d-flex justify-content-between align-items-center">
									<p>Amiah Burton</p>
									<p class="sub-text text-muted">2 hrs ago</p>
								</div>
								<p class="sub-text text-muted">Project deadline</p>
							</div>
						</a>
						<a href="javascript:;" class="dropdown-item">
							<div class="figure">
								<img src="https://via.placeholder.com/30x30" alt="userr">
							</div>
							<div class="content">
								<div class="d-flex justify-content-between align-items-center">
									<p>Yaretzi Mayo</p>
									<p class="sub-text text-muted">5 hr ago</p>
								</div>
								<p class="sub-text text-muted">New record</p>
							</div>
						</a>
					</div>
					<div class="dropdown-footer d-flex align-items-center justify-content-center">
						<a href="javascript:;">View all</a>
					</div>
				</div>
			</li>
			<li class="nav-item dropdown nav-profile">
				<a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<img src="../<?php echo htmlspecialchars($logged_avatar);?>" alt="<?php echo htmlspecialchars($logged_name);?>">
				</a>
				<div class="dropdown-menu" aria-labelledby="profileDropdown">
					<div class="dropdown-header d-flex flex-column align-items-center">
						<div class="figure mb-3">
							<img src="../<?php echo $logged_avatar;?>" alt="">
						</div>
						<div class="info text-center">
							<p class="name font-weight-bold mb-0"><?php echo $logged_name;?></p>
						</div>
					</div>
					<div class="dropdown-body">
						<ul class="profile-nav p-0 pt-3">
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i data-feather="user"></i>
									<span>Profile</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i data-feather="edit"></i>
									<span>Change Password</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="logout" class="nav-link">
									<i data-feather="log-out"></i>
									<span>Log Out</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</li>
		</ul>
	</div>
</nav>

<!-- Баркод оруулах Modal -->
<div class="modal fade" id="barcodeInputModal" tabindex="-1" role="dialog" aria-labelledby="barcodeInputModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="barcodeInputModalLabel">Баркод оруулах</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="barcodes?action=inserting" method="POST" id="barcodeInputForm">
				<div class="modal-body">
					<div class="form-group">
						<label for="barcodeInput">Баркод:</label>
						<input type="text" class="form-control" id="barcodeInput" name="barcode" placeholder="Баркод оруулна уу..." autofocus required>
						<small class="form-text text-muted">Баркод оруулаад Enter дараарай эсвэл Хадгалах товч дараарай</small>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Хаах</button>
					<button type="submit" class="btn btn-primary">Хадгалах</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
	var barcodeInput = document.getElementById('barcodeInput');
	var barcodeForm = document.getElementById('barcodeInputForm');
	var modal = $('#barcodeInputModal');
	
	// Enter дарахад хадгалах
	if (barcodeInput) {
		barcodeInput.addEventListener('keypress', function(e) {
			if (e.key === 'Enter') {
				e.preventDefault();
				barcodeForm.submit();
			}
		});
	}
	
	// Modal нээгдэхэд input-д focus
	modal.on('shown.bs.modal', function () {
		if (barcodeInput) {
			barcodeInput.focus();
		}
	});
	
	// Modal хаагдах үед input цэвэрлэх
	modal.on('hidden.bs.modal', function () {
		if (barcodeInput) {
			barcodeInput.value = '';
		}
	});
	
	// Mode detection and persistence (for future enhancements)
	var currentMode = document.querySelector('.nav-group[data-mode]');
	if (currentMode) {
		var mode = currentMode.getAttribute('data-mode');
		// Store in sessionStorage for persistence
		sessionStorage.setItem('navbarMode', mode);
	}
	
	// Feather icons
	if (typeof feather !== 'undefined') {
		feather.replace();
	}
});
</script>