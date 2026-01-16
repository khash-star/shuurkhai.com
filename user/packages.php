<? require_once("config.php");?>
<? require_once("views/helper.php");?>
<? require_once("views/login_check.php");?>
<? require_once("views/init.php");?>

<link href="assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="assets/css/users/user-profile.css" rel="stylesheet" type="text/css" />
<link href="plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="assets/css/elements/alert.css">
<link href="assets/css/elements/breadcrumb.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
<link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
<link href="assets/css/components/timeline/custom-timeline.css" rel="stylesheet" type="text/css" />



<body class="sidebar-noneoverflow">
    
    <? require_once("views/navbar.php");?>



    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <? require_once("views/sidebar.php");?>


        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <? if (isset($_GET["action"])) $action=$_GET["action"]; else $action="active"; ?>

                <?
                if ($action=="active")
                {
                
                    $user_id = $_SESSION["c_user_id"];
                    $sql = "SELECT * FROM orders WHERE receiver=".$user_id." AND status NOT IN('delivered','completed','custom','weight_missing','received') AND created_date>'2015-09-01' ";                    
                    if (isset($_POST["search"])) 
                        {

                            $search = $_POST["search"];
                            $sql .= " AND (third_party LIKE '%$search%' OR barcode LIKE '%$search%' OR package LIKE '%$search%')";
                        }
                    $sql .=" ORDER BY created_date DESC";
                    //echo $sql;
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="packages">Ачаа</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Хүлээгдэж буй</a></li>
                        </ol>
                    </nav>
                    
                    <?
                    require_once("views/packages.php");?>                        
                    <?
                }
                ?>

                <?
                if ($action=="container")
                {
                
                    $user_id = $_SESSION["c_user_id"];
                    $sql = "SELECT container_item.*,container.name container_name FROM container_item 
                    LEFT JOIN container ON container_item.container=container.container_id
                    WHERE receiver=".$user_id." AND container_item.status NOT IN('delivered','completed','custom') ORDER BY container_item.id DESC";
                    //echo $sql;
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="packages">Ачаа</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Хүлээгдэж буй</a></li>
                        </ol>
                    </nav>
                    
                    <?
                    require_once("views/container.php");?>                        
                    <?
                }
                ?>

                <?
                if ($action=="history")
                {
                    
                    $user_id = $_SESSION["c_user_id"];
                    $sql = "SELECT * FROM orders WHERE receiver=".$user_id." AND status IN ('delivered','custom') AND created_date>'2015-09-01'";
                     if (isset($_POST["search"])) 
                        {
                            $search = $_POST["search"];
                            $sql .= " AND (third_party LIKE '%$search%' OR barcode LIKE '%$search%' OR package LIKE '%$search%')";
                        }
                    $sql .=" ORDER BY created_date DESC";
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="packages">Ачаа</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Түүх</a></li>
                        </ol>
                    </nav>
                    
                    <?
                    require_once("views/packages_history.php");?>                        
                    <?
                }
                ?>               

                <?
                if ($action=="detail")
                {
                    $user_id = $_SESSION["c_user_id"];
                    $order_id = $_GET["id"];
                    
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="packages">Ачаа</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Дэлгэрэнгүй</a></li>
                        </ol>
                    </nav>

                    <div class="row layout-spacing">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">
                            <div class="card">
                                <div class="card-body">
                                    <?
                                    $sql = "SELECT *FROM orders WHERE order_id='$order_id' LIMIT 1";
                                    $result = mysqli_query($conn,$sql);
                                    if (mysqli_num_rows($result)==1)
                                    {
                                        $data_order = mysqlI_fetch_array($result);
                                        $receiver = $data_order["receiver"];
                                        $track = $data_order["third_party"];
                                        $status = $data_order["status"];
                                        if ($receiver==$user_id)
                                        {
                                            $weight=$data_order["weight"];
                                            $barcode=$data_order["barcode"];
                                            $package=$data_order["package"];
                                            $price=$data_order["price"];
                                            $status=$data_order["status"];

                                            $created_date=$data_order["created_date"];
                                            $weight_date=$data_order["weight_date"];
                                            $onair_date=$data_order["onair_date"];
                                            $warehouse_date=$data_order["warehouse_date"];
                                            $delivered_date = $data_order["delivered_date"];
                                            
                                            $package_array=explode("##",$package);
                                            $package1_name = $package_array[0];
                                            $package1_num = $package_array[1];
                                            $package1_price = $package_array[2];
                                            $package2_name = $package_array[3];
                                            $package2_num = $package_array[4];
                                            $package2_price = $package_array[5];
                                            $package3_name = $package_array[6];
                                            $package3_num = $package_array[7];
                                            $package3_price = $package_array[8];
                                            $package4_name = $package_array[9];
                                            $package4_num = $package_array[10];
                                            $package4_price = $package_array[11];			
                                            ?>
                                            <div class="form-group">
                                                <h4><?=$track;?></h4><span class="badge badge-success"> <?=$status;?> </span>
                                                <?=$barcode;?>
                                            </div>
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr><th>Барааны тайлбар</th><th>тоо ширхэг</th><th>Үнэ</th></tr>
                                                </thead>
                                                <tbody>
                                                <?
                                                if ($package1_name!="")
                                                echo "<tr><td>".$package1_name."</td><td>".$package1_num."</td><td>".$package1_price."$</td></tr>";
                                                if ($package2_name!="")
                                                echo "<tr><td>".$package2_name."</td><td>".$package2_num."</td><td>".$package2_price."$</td></tr>";
                                                if ($package3_name!="")
                                                echo "<tr><td>".$package3_name."</td><td>".$package3_num."</td><td>".$package3_price."$</td></tr>";
                                                if ($package4_name!="")
                                                echo "<tr><td>".$package4_name."</td><td>".$package4_num."</td><td>".$package4_price."$</td></tr>";
                                                ?>
                                                </tbody>
                                            </table>
                                            
                                            <?
                                        }
                                        
                                        if ($receiver!=$user_id)
                                            {
                                                ?>
                                                 <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                    Өөр харилцагчийн ачаа
                                                </div>

                                                <?
                                            }
                                            
                                        
                                
                                    }
                                    else 
                                    {
                                        ?>
                                         <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                            Ачаа олдсонгүй
                                        </div>
                                        <?
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Дэлгэрэнгүй өөрчлөлт</h4>
                                    <div class="mt-container mx-auto">
                                        <div class="timeline-line">
                                            
                                            <div class="item-timeline">
                                                <p class="t-time"><?=substr($delivered_date,0,10);?></p>
                                                <div class="t-dot t-dot-primary">
                                                </div>
                                                <div class="t-text">
                                                    <p>Харилцагч хүлээн авсан</p>
                                                    <p class="t-meta-time">8 өдөр</p>
                                                </div>
                                            </div>
                                            <div class="item-timeline">
                                                <p class="t-time"><?=substr($delivered_date,0,10);?></p>
                                                <div class="t-dot t-dot-primary">
                                                </div>
                                                <div class="t-text">
                                                    <p>Хүргэлтээр гарсан</p>
                                                </div>
                                            </div>

                                            <div class="item-timeline">
                                                <p class="t-time"><?=substr($warehouse_date,0,10);?></p>
                                                <div class="t-dot t-dot-warning">
                                                </div>
                                                <div class="t-text">
                                                    <p>Монголд агуулахад бэлэн болсон</p>
                                                </div>
                                            </div>

                                            <div class="item-timeline">
                                                <p class="t-time"><?=substr($onair_date,0,10);?></p>
                                                <div class="t-dot t-dot-info">
                                                </div>
                                                <div class="t-text">
                                                    <p>Америкаас монголруу ниссэн</p>
                                                </div>
                                            </div>

                                            <div class="item-timeline">
                                                <p class="t-time"><?=substr($weight_date,0,10);?></p>
                                                <div class="t-dot t-dot-danger">
                                                </div>
                                                <div class="t-text">
                                                    <p>Америкт хүргэгдэж жин орсон</p>
                                                </div>
                                            </div>

                                            <div class="item-timeline">
                                                <p class="t-time"><?=substr($created_date,0,10);?></p>
                                                <div class="t-dot t-dot-dark">
                                                </div>
                                                <div class="t-text">
                                                    <p>Системд бүртгэгдсэн</p>
                                                </div>
                                            </div>

                                        </div>                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?
                }
                ?>

                <?
                if ($action=="container_detail")
                {
                    $user_id = $_SESSION["c_user_id"];
                    $order_id = $_GET["id"];
                    
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="packages">Ачаа</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Дэлгэрэнгүй</a></li>
                        </ol>
                    </nav>

                    <div class="row layout-spacing">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">
                            <div class="card">
                                <div class="card-body">
                                    <?
                                    $sql = "SELECT *FROM container_item WHERE id='$order_id' LIMIT 1";
                                    $result = mysqli_query($conn,$sql);
                                    if (mysqli_num_rows($result)==1)
                                    {
                                        $data_order = mysqlI_fetch_array($result);
                                        $receiver = $data_order["receiver"];
                                        $track = $data_order["third_party"];
                                        $status = $data_order["status"];
                                        $container_id = $data_order["container"];
                                        if ($receiver==$user_id)
                                        {
                                            $weight=$data_order["weight"];
                                            $barcode=$data_order["barcode"];
                                            $package=$data_order["package"];
                                            $price=$data_order["price"];
                                            $status=$data_order["status"];

                                            $created_date=$data_order["created_date"];
                                            $price_date=$data_order["price_date"];
                                            $onway_date=$data_order["onway_date"];
                                            $warehouse_date=$data_order["warehouse_date"];
                                            $delivered_date = $data_order["delivered_date"];
                                            
                                            $package_array=explode("##",$package);
                                            $package1_name = $package_array[0];
                                            $package1_num = $package_array[1];
                                            $package1_price = $package_array[2];
                                            $package2_name = $package_array[3];
                                            $package2_num = $package_array[4];
                                            $package2_price = $package_array[5];
                                            $package3_name = $package_array[6];
                                            $package3_num = $package_array[7];
                                            $package3_price = $package_array[8];
                                            $package4_name = $package_array[9];
                                            $package4_num = $package_array[10];
                                            $package4_price = $package_array[11];			
                                            ?>
                                            <div class="form-group">
                                                <h4><?=$track;?></h4>
                                                <span class="badge badge-success"> <?=$status;?> </span>
                                                <?=$barcode;?>
                                            </div>
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr><th>Барааны тайлбар</th><th>тоо ширхэг</th><th>Үнэ</th></tr>
                                                </thead>
                                                <tbody>
                                                <?
                                                if ($package1_name!="")
                                                echo "<tr><td>".$package1_name."</td><td>".$package1_num."</td><td>".$package1_price."$</td></tr>";
                                                if ($package2_name!="")
                                                echo "<tr><td>".$package2_name."</td><td>".$package2_num."</td><td>".$package2_price."$</td></tr>";
                                                if ($package3_name!="")
                                                echo "<tr><td>".$package3_name."</td><td>".$package3_num."</td><td>".$package3_price."$</td></tr>";
                                                if ($package4_name!="")
                                                echo "<tr><td>".$package4_name."</td><td>".$package4_num."</td><td>".$package4_price."$</td></tr>";
                                                ?>
                                                </tbody>
                                            </table>
                                            
                                            <?
                                        }
                                        
                                        if ($receiver!=$user_id)
                                            {
                                                ?>
                                                 <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                    Өөр харилцагчийн ачаа
                                                </div>

                                                <?
                                            }
                                            
                                        
                                
                                    }
                                    else 
                                    {
                                        ?>
                                         <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                            Ачаа олдсонгүй
                                        </div>
                                        <?
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Чингэлэгийн хуваарь</h4>
                                    <?
                                    $sql = "SELECT *FROM container WHERE container_id = '$container_id'";
                                    $result= mysqli_query($conn,$sql);
                                    $data_container = mysqli_fetch_array($result);
                                    $container_name =$data_container["name"];
                                    $container_status =$data_container["status"];
                                    ?>
                                    <span class="badge badge-success"> <?=$container_status;?> </span>
                                    Чингэлэг нэр: <?=$container_name;?>
                                    <div class="mt-container mx-auto">
                                        <div class="timeline-line">
                                            
                                            <div class="item-timeline">
                                                <p class="t-time"><?=substr($delivered_date,0,10);?></p>
                                                <div class="t-dot t-dot-primary">
                                                </div>
                                                <div class="t-text">
                                                    <p>Харилцагч авсан</p>
                                                    <p class="t-meta-time">43 өдөр</p>
                                                </div>
                                            </div>

                                            <div class="item-timeline">
                                                <p class="t-time"><?=substr($warehouse_date,0,10);?></p>
                                                <div class="t-dot t-dot-warning">
                                                </div>
                                                <div class="t-text">
                                                    <p>Монголд агуулахад бэлэн болсон</p>
                                                    <p class="t-meta-time">40 өдөр</p>
                                                </div>
                                            </div>
                                            <?
                                            $sql = "SELECT *FROM container_log WHERE container='$container_id' ORDER BY timestamp DESC";
                                            $result = mysqli_query($conn,$sql);
                                            while ($data_container_log = mysqli_fetch_array($result))
                                            {
                                                ?>
                                                <div class="item-timeline">
                                                    <p class="t-time"><?=substr($data_container_log["date"],0,10);?></p>
                                                    <div class="t-dot t-dot-info">
                                                    </div>
                                                    <div class="t-text">
                                                        <p><?=$data_container_log["description"];?></p>
                                                        <p class="t-meta-time">20 өдөр</p>
                                                    </div>
                                                </div>
                                                <?
                                            }
                                            ?>

                                            <div class="item-timeline">
                                                <p class="t-time"><?=substr($onway_date,0,10);?></p>
                                                <div class="t-dot t-dot-info">
                                                </div>
                                                <div class="t-text">
                                                    <p>Америкаас монголруу ниссэн</p>
                                                    <p class="t-meta-time">3 өдөр</p>
                                                </div>
                                            </div>

                                            <div class="item-timeline">
                                                <p class="t-time"><?=substr($price_date,0,10);?></p>
                                                <div class="t-dot t-dot-danger">
                                                </div>
                                                <div class="t-text">
                                                    <p>Америкт хүргэгдсэн</p>
                                                    <p class="t-meta-time">2 өдөр</p>
                                                </div>
                                            </div>

                                            <div class="item-timeline">
                                                <p class="t-time"><?=substr($created_date,0,10);?></p>
                                                <div class="t-dot t-dot-dark">
                                                </div>
                                                <div class="t-text">
                                                    <p>Системд бүртгэгдсэн</p>
                                                    <p class="t-meta-time">0 өдөр</p>
                                                </div>
                                            </div>

                                        </div>                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?
                }
                ?>

                <? 
                if ($action == "payment")
                {
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="packages">Ачаа</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Төлбөр төлөх</a></li>
                        </ol>
                    </nav>

                    <div class="row layout-spacing">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 layout-top-spacing">
                                <div class="card component-card_9">
                                    <img src="assets/images/khanbank.jpg" class="card-img-top" alt="widget-card-2">
                                    <div class="card-body">
                                        <p class="meta-date"><img src="assets/images/khanbank-logo.png" class="mr-1"><b>Хаан банк</b></p>
                                        <h5 class="card-title">5111104306  - ₮ - Хашбал</h5>
                                    </div>
                                </div>
                            </div>
                    </div>
                    

                    
                    <?
                }
                ?>


                </div>
            <? require_once("views/footer.php");?>
        </div>
    </div>

    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="plugins/jquery-chained/jquery.chained.min.js"></script>
    <script src="assets/js/app.js"></script>

    <script>
        $(document).ready(function() {
            App.init();
            $("#district").chained("#city");
        });
    </script>
    <script src="plugins/highlight/highlight.pack.js"></script>
    <script src="assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="assets/js/scrollspyNav.js"></script>

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="plugins/table/datatable/datatables.js"></script>
    <script>
        $('#zero-config').DataTable({
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 7 
        });
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->


</body>
</html>