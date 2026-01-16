<? $current_page = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);?>
<? 
	$logged_name = $_SESSION["name"];
	$logged_avatar = $_SESSION["avatar"];
	$logged_rights = $_SESSION["rights"];
?>
<nav class="navbar">
	<a href="#" class="sidebar-toggler">
		<i data-feather="menu"></i>
	</a>
	<div class="navbar-content">
		<? if ($current_page=="products") require_once("views/product_nav.php");?> 
		<? if (in_array($current_page, ["news","news_category"])) require_once("views/news_nav.php");?> 
		<? if ($current_page=="customers") require_once("views/customer_nav.php");?> 
		<? if ($current_page=="online") require_once("views/online_nav.php");?> 
		<? if ($current_page=="envoices") require_once("views/envoices_nav.php");?> 
		<? if ($current_page=="orders") require_once("views/orders_nav.php");?> 
		<? if ($current_page=="barcodes") require_once("views/barcodes_nav.php");?> 
		<? if ($current_page=="boxes") require_once("views/boxes_nav.php");?> 
		<? if ($current_page=="gaali") require_once("views/gaali_nav.php");?> 
		<? if ($current_page=="upost") require_once("views/upost_nav.php");?> 
		<? if ($current_page=="agents") require_once("views/agents_nav.php");?> 
		<? if ($current_page=="tracks") require_once("views/tracks_nav.php");?> 
		<? if ($current_page=="deliver") require_once("views/deliver_nav.php");?> 
		<? if ($current_page=="container") require_once("views/container_nav.php");?> 

		

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
			<li class="nav-item dropdown nav-notifications">
				<a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i data-feather="bell"></i>
					<div class="indicator">
						<div class="circle"></div>
					</div>
				</a>
				<div class="dropdown-menu" aria-labelledby="notificationDropdown">
					<div class="dropdown-header d-flex align-items-center justify-content-between">
						<p class="mb-0 font-weight-medium">6 New Notifications</p>
						<a href="javascript:;" class="text-muted">Clear all</a>
					</div>
					<div class="dropdown-body">
						<a href="javascript:;" class="dropdown-item">
							<div class="icon">
								<i data-feather="user-plus"></i>
							</div>
							<div class="content">
								<p>New customer registered</p>
								<p class="sub-text text-muted">2 sec ago</p>
							</div>
						</a>
						<a href="javascript:;" class="dropdown-item">
							<div class="icon">
								<i data-feather="gift"></i>
							</div>
							<div class="content">
								<p>New Order Recieved</p>
								<p class="sub-text text-muted">30 min ago</p>
							</div>
						</a>
						<a href="javascript:;" class="dropdown-item">
							<div class="icon">
								<i data-feather="alert-circle"></i>
							</div>
							<div class="content">
								<p>Server Limit Reached!</p>
								<p class="sub-text text-muted">1 hrs ago</p>
							</div>
						</a>
						<a href="javascript:;" class="dropdown-item">
							<div class="icon">
								<i data-feather="layers"></i>
							</div>
							<div class="content">
								<p>Apps are ready for update</p>
								<p class="sub-text text-muted">5 hrs ago</p>
							</div>
						</a>
						<a href="javascript:;" class="dropdown-item">
							<div class="icon">
								<i data-feather="download"></i>
							</div>
							<div class="content">
								<p>Download completed</p>
								<p class="sub-text text-muted">6 hrs ago</p>
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
					<img src="../<?=$logged_avatar;?>" alt="<?=$logged_name;?>">
				</a>
				<div class="dropdown-menu" aria-labelledby="profileDropdown">
					<div class="dropdown-header d-flex flex-column align-items-center">
						<div class="figure mb-3">
							<img src="../<?=$logged_avatar;?>" alt="">
						</div>
						<div class="info text-center">
							<p class="name font-weight-bold mb-0"><?=$logged_name;?></p>
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