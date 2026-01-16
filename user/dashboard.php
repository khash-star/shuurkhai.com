<? require_once("config.php");?>
<? require_once("views/helper.php");?>
<? require_once("views/login_check.php");?>
<? require_once("views/init.php");?>

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
	<link href="assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" class="dashboard-analytics" />

    
<body class="dashboard-analytics">

    <!-- BEGIN LOADER -->
    <div id="load_screen"> 
        <div class="loader"> 
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

   <? require_once("views/navbar.php");?>

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <? require_once("views/sidebar.php");?>
        
        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="widgets">
            <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="row widget-statistic">
                            <?
                            $sql = "SELECT *FROM videos ORDER BY rand() LIMIT 1";
                            $result = mysqli_query($conn,$sql);
                            if (mysqli_num_rows($result)==1)
                            {
                                $data  = mysqli_fetch_array($result);
                                
                                $video_name = $data["name"];
                                $video_url = $data["url"];
                                $video_description = $data["description"];
                                ?>
                                <div class="col-8 col-xl-8 col-lg-8 col-md-8 col-sm-6">

                                    <div class="card component-card_2">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe src="https://www.youtube.com/embed/<?=substr($video_url,32,11);?>" allowfullscreen></iframe>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title"><?=$video_name;?></h5>
                                            <p class="card-text"><?=$video_description;?></p>
                                        </div>
                                    </div>

                                </div>

                                <?
                            }
                            ?>
                            

                            <div class="col-4 col-xl-4 col-lg-4 col-md-4 col-sm-6">
                                <?
                                $current = settings("rate");
                                $sql = "SELECT *FROM rates ORDER by timestamp DESC LIMIT 1,1";
                                $result = mysqli_query($conn,$sql);
                                $data = mysqli_fetch_array($result);
                                $last =  $data["rate"];
                                
                                $rates = array();
                                $sql = "SELECT *FROM rates ORDER by timestamp DESC LIMIT 7";
                                $result = mysqli_query($conn,$sql);
                                while ($data = mysqli_fetch_array($result))
                                array_push($rates,$data["rate"]);
                                ?>
                                <div class="widget widget-one_hybrid widget-engagement">
                                    <div class="widget-heading">
                            
                                        <div class="w-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                        </div>
                                        <span><b>Долларын ханш</b></span>
                                        <p class="w-value"><?=number_format($current);?>₮</p>
                                        <h5 class="">
                                            <span><?=($current>$last)?'+':'-';?><?=round(((abs($current-$last)*100)/$last),2);?>%</span>
                                        </h5>
                                    </div>
                                    <div class="widget-content">    
                                        <div class="w-chart">
                                            <div id="hybrid_followers3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <? require_once("views/footer.php");?>
        </div>
        <!--  END CONTENT AREA  -->


    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
   
    <script src="assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="plugins/apex/apexcharts.min.js"></script>
    <script>
      try {
        // Engagement Rate

        var d_1options5 = {
        chart: {
            id: 'sparkline1',
            type: 'area',
            height: 50,
            sparkline: {
            enabled: true
            },
        },
        stroke: {
            curve: 'smooth',
            width: 2,
        },
        fill: {
            opacity: 1,
        },
        series: [{
            name: 'Ханш',
            data: [<?=$rates[0].','.$rates[1].','.$rates[2].','.$rates[3].','.$rates[4].','.$rates[5].','.$rates[6];?>]
        }],
        labels: ['1', '2', '3', '4', '5', '6', '7'],
        yaxis: {
            min: <?=min($rates);?>
        },
        colors: ['#8dbf42'],
        tooltip: {
            x: {
            show: false,
            }
        },
        fill: {
            type:"gradient",
            gradient: {
                type: "vertical",
                shadeIntensity: 1,
                inverseColors: !1,
                opacityFrom: .40,
                opacityTo: .05,
                stops: [45, 100]
            }
        },
        }
        // Engagement Rate

        var d_1C_7 = new ApexCharts(document.querySelector("#hybrid_followers3"), d_1options5);
        d_1C_7.render()

        /*
        =============================================
            Perfect Scrollbar | Notifications
        =============================================
        */
        const ps = new PerfectScrollbar(document.querySelector('.mt-container'));


        } catch(e) {
        // statements
       //console.log(e);
        }


    </script>
    <!-- <script src="assets/js/dashboard/dash_1.js"></script> -->
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

</body>
</html>