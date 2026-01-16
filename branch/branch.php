<? require_once("views/login_check.php");?>
<? require_once("config.php");?>
<? require_once("views/helper.php");?>
<? require_once("views/init.php");?>
<body>
    <?
    $branch_my_id = $_SESSION['branch_logged_id'];
    $branch_my_name = $_SESSION['branch_logged_name'];
    $branch_my_tel = $_SESSION['branch_logged_tel'];
    $branch_my_email = $_SESSION['branch_logged_email'];
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
      <? require_once("views/header.php");?>
      <!-- Page Body Start-->
      <div class="page-body-wrapper sidebar-icon">
        <? require_once("views/sidemenu.php");?>
        <div class="page-body dashboard-2-main">
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">               
              
                <div class="col-sm-6 col-xl-4 col-lg-6">
                  <div class="card o-hidden border-0">
                    <a href="#">
                      <div class="bg-secondary b-r-4 card-body">
                        <div class="media static-top-widget">
                          <div class="align-self-center text-center"><i data-feather="box"></i></div>
                          <div class="media-body"><span class="m-0">Inventory</span>
                            <?
                              $sql = "SELECT id
                              FROM branch_inventories 
                              WHERE branch_inventories.branch='$g_logged_id' AND status='new'";
                              $result = mysqli_query($conn,$sql);
                              $products = mysqli_num_rows($result);
                            ?>
                            <h4 class="mb-0 counter"><?=$products;?></h4><i class="icon-bg" data-feather="box"></i>
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
                            <?
                            $sql = "SELECT id
                            FROM branch_inventories 
                            WHERE branch_inventories.branch='$g_logged_id' AND status='prepare'";
                            $result = mysqli_query($conn,$sql);
                            $customers = mysqli_num_rows($result);
                            ?>
                            <h4 class="mb-0 counter"><?=$customers;?></h4><i class="icon-bg" data-feather="archive"></i>
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
                            <?
                             $sql = "SELECT id
                             FROM branch_transport ORDER BY id DESC LIMIT 1";
                              $result = mysqli_query($conn,$sql);
                              $data = mysqli_fetch_array($result);
                              $transport_id= $data["id"];
                              $sql = "SELECT id
                              FROM branch_inventories 
                              WHERE branch_inventories.branch='$g_logged_id' AND status='transport' AND transport='$transport_id'";
                              // echo $sql;
                              $result = mysqli_query($conn,$sql);
                              $total = mysqli_num_rows($result);
                            ?>
                            <h4 class="mb-0 counter"><?=number_format($total);?></h4><i class="icon-bg" data-feather="truck"></i>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
            </div>            
          </div>
          <!-- Container-fluid Ends-->
        </div>
        <? require_once("views/footer.php");?>
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
                            var image = $('<img>').attr('src', '<?=settings("base_url");?>' + url);
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