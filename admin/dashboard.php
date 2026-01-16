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
											<?
											$paymentrate = settings("paymentrate");
											?>
											<h3 class="mb-2"><?=number_format($paymentrate);?>$</h3>
											<?
											$paymentrate_min = settings("paymentrate_min");
											?>
											<div class="d-flex align-items-baseline">
											<p class="text-primary">
												<span>Хамгийн бага зардал:<?=$paymentrate_min;?>$</span>
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
											<?
											$current = settings("rate");
											?>
											<h3 class="mb-2"><?=number_format($current);?></h3>
											<?
											$sql = "SELECT *FROM rates ORDER by timestamp DESC LIMIT 1,1";
											$result = mysqli_query($conn,$sql);
											$data = mysqli_fetch_array($result);
											$last =  $data["rate"];
											?>
											<div class="d-flex align-items-baseline">
											<p class="<?=($current>$last)?'text-success':'text-danger';?>">
												<span><?=($current>$last)?'+':'-';?><?=round(((abs($current-$last)*100)/$last),2);?>%</span>
												<i data-feather="<?=($current>$last)?'arrow-up':'arrow-down';?>" class="icon-sm mb-1"></i>
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
      <? require_once("views/footer.php");?>
		
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