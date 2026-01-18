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

	<!-- endinject -->

</body>
</html>    