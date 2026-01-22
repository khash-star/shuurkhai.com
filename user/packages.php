<?php require_once("config.php");?>
<?php require_once("views/helper.php");?>
<?php require_once("views/login_check.php");?>
<?php require_once("views/init.php");?>

<link href="assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="assets/css/users/user-profile.css" rel="stylesheet" type="text/css" />
<link href="plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="assets/css/elements/alert.css">
<link href="assets/css/elements/breadcrumb.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
<link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
<link href="assets/css/components/timeline/custom-timeline.css" rel="stylesheet" type="text/css" />



<body class="sidebar-noneoverflow">
    
    <?php require_once("views/navbar.php");?>



    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <?php require_once("views/sidebar.php");?>


        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <?php if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="active"; ?>

                <?php
                if ($action=="active")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                    $sql = "SELECT * FROM orders WHERE receiver=".$user_id_escaped." AND status NOT IN('delivered','completed','custom','weight_missing','received') AND created_date>'2015-09-01' ";                    
                    if (isset($_POST["search"])) 
                        {
                            $search = mysqli_real_escape_string($conn, $_POST["search"]);
                            $sql .= " AND (third_party LIKE '%".$search."%' OR barcode LIKE '%".$search."%' OR package LIKE '%".$search."%')";
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
                    
                    <?php
                    require_once("views/packages.php");?>                        
                    <?php
                }
                ?>

                <?php
                if ($action=="container")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                    $sql = "SELECT container_item.*,container.name container_name FROM container_item 
                    LEFT JOIN container ON container_item.container=container.container_id
                    WHERE receiver=".$user_id_escaped." AND container_item.status NOT IN('delivered','completed','custom') ORDER BY container_item.id DESC";
                    //echo $sql;
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="packages">Ачаа</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Хүлээгдэж буй</a></li>
                        </ol>
                    </nav>
                    
                    <?php
                    require_once("views/container.php");?>                        
                    <?php
                }
                ?>

                <?php
                if ($action=="history")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                    $sql = "SELECT * FROM orders WHERE receiver=".$user_id_escaped." AND status IN ('delivered','custom') AND created_date>'2015-09-01'";
                     if (isset($_POST["search"])) 
                        {
                            $search = mysqli_real_escape_string($conn, $_POST["search"]);
                            $sql .= " AND (third_party LIKE '%".$search."%' OR barcode LIKE '%".$search."%' OR package LIKE '%".$search."%')";
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
                    
                    <?php
                    require_once("views/packages_history.php");?>                        
                    <?php
                }
                ?>               

                <?php
                if ($action=="detail")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $order_id = isset($_GET["id"]) ? intval(protect($_GET["id"])) : 0;
                    
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
                                    <?php
                                    $track = '';
                                    $status = '';
                                    $barcode = '';
                                    $delivered_date = '';
                                    $created_date = '';
                                    $weight_date = '';
                                    $onair_date = '';
                                    $warehouse_date = '';
                                    $package1_name = '';
                                    $package1_num = '';
                                    $package1_price = '';
                                    $package2_name = '';
                                    $package2_num = '';
                                    $package2_price = '';
                                    $package3_name = '';
                                    $package3_num = '';
                                    $package3_price = '';
                                    $package4_name = '';
                                    $package4_num = '';
                                    $package4_price = '';
                                    
                                    if (isset($conn) && $conn) {
                                        $order_id_escaped = mysqli_real_escape_string($conn, $order_id);
                                        $sql = "SELECT * FROM orders WHERE order_id='".$order_id_escaped."' LIMIT 1";
                                        $result = mysqli_query($conn, $sql);
                                        if ($result && mysqli_num_rows($result) == 1) {
                                            $data_order = mysqli_fetch_array($result);
                                            $receiver = isset($data_order["receiver"]) ? intval($data_order["receiver"]) : 0;
                                            $track = isset($data_order["third_party"]) ? htmlspecialchars($data_order["third_party"]) : '';
                                            $status = isset($data_order["status"]) ? htmlspecialchars($data_order["status"]) : '';
                                            if ($receiver == $user_id) {
                                                $weight = isset($data_order["weight"]) ? htmlspecialchars($data_order["weight"]) : '';
                                                $barcode = isset($data_order["barcode"]) ? htmlspecialchars($data_order["barcode"]) : '';
                                                $package = isset($data_order["package"]) ? htmlspecialchars($data_order["package"]) : '';
                                                $price = isset($data_order["price"]) ? htmlspecialchars($data_order["price"]) : '';
                                                $status = isset($data_order["status"]) ? htmlspecialchars($data_order["status"]) : '';

                                                $created_date = isset($data_order["created_date"]) ? htmlspecialchars($data_order["created_date"]) : '';
                                                $weight_date = isset($data_order["weight_date"]) ? htmlspecialchars($data_order["weight_date"]) : '';
                                                $onair_date = isset($data_order["onair_date"]) ? htmlspecialchars($data_order["onair_date"]) : '';
                                                $warehouse_date = isset($data_order["warehouse_date"]) ? htmlspecialchars($data_order["warehouse_date"]) : '';
                                                $delivered_date = isset($data_order["delivered_date"]) ? htmlspecialchars($data_order["delivered_date"]) : '';
                                                
                                                if (!empty($package)) {
                                                    $package_array = explode("##", $package);
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
                                                }
                                                ?>
                                                <div class="form-group">
                                                    <h4><?php echo htmlspecialchars($track ?? ''); ?></h4><span class="badge badge-success"> <?php echo htmlspecialchars($status ?? ''); ?> </span>
                                                    <?php echo htmlspecialchars($barcode ?? ''); ?>
                                                </div>
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr><th>Барааны тайлбар</th><th>тоо ширхэг</th><th>Үнэ</th></tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    if (!empty($package1_name)) {
                                                        echo "<tr><td>".htmlspecialchars($package1_name)."</td><td>".htmlspecialchars($package1_num)."</td><td>".htmlspecialchars($package1_price)."$</td></tr>";
                                                    }
                                                    if (!empty($package2_name)) {
                                                        echo "<tr><td>".htmlspecialchars($package2_name)."</td><td>".htmlspecialchars($package2_num)."</td><td>".htmlspecialchars($package2_price)."$</td></tr>";
                                                    }
                                                    if (!empty($package3_name)) {
                                                        echo "<tr><td>".htmlspecialchars($package3_name)."</td><td>".htmlspecialchars($package3_num)."</td><td>".htmlspecialchars($package3_price)."$</td></tr>";
                                                    }
                                                    if (!empty($package4_name)) {
                                                        echo "<tr><td>".htmlspecialchars($package4_name)."</td><td>".htmlspecialchars($package4_num)."</td><td>".htmlspecialchars($package4_price)."$</td></tr>";
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                                
                                                <?php
                                            }
                                            
                                            if ($receiver != $user_id) {
                                                ?>
                                                 <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                    Өөр харилцагчийн ачаа
                                                </div>

                                                <?php
                                            }
                                        } else {
                                            ?>
                                             <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                Ачаа олдсонгүй
                                            </div>
                                            <?php
                                        }
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
                                            
                                            <?php if (!empty($delivered_date)): ?>
                                            <div class="item-timeline">
                                                <p class="t-time"><?php echo htmlspecialchars(substr($delivered_date, 0, 10)); ?></p>
                                                <div class="t-dot t-dot-primary">
                                                </div>
                                                <div class="t-text">
                                                    <p>Харилцагч хүлээн авсан</p>
                                                    <p class="t-meta-time">8 өдөр</p>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <?php if (!empty($warehouse_date)): ?>
                                            <div class="item-timeline">
                                                <p class="t-time"><?php echo htmlspecialchars(substr($warehouse_date, 0, 10)); ?></p>
                                                <div class="t-dot t-dot-warning">
                                                </div>
                                                <div class="t-text">
                                                    <p>Монголд агуулахад бэлэн болсон</p>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <?php if (!empty($onair_date)): ?>
                                            <div class="item-timeline">
                                                <p class="t-time"><?php echo htmlspecialchars(substr($onair_date, 0, 10)); ?></p>
                                                <div class="t-dot t-dot-info">
                                                </div>
                                                <div class="t-text">
                                                    <p>Америкаас монголруу ниссэн</p>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <?php if (!empty($weight_date)): ?>
                                            <div class="item-timeline">
                                                <p class="t-time"><?php echo htmlspecialchars(substr($weight_date, 0, 10)); ?></p>
                                                <div class="t-dot t-dot-danger">
                                                </div>
                                                <div class="t-text">
                                                    <p>Америкт хүргэгдэж жин орсон</p>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <?php if (!empty($created_date)): ?>
                                            <div class="item-timeline">
                                                <p class="t-time"><?php echo htmlspecialchars(substr($created_date, 0, 10)); ?></p>
                                                <div class="t-dot t-dot-dark">
                                                </div>
                                                <div class="t-text">
                                                    <p>Системд бүртгэгдсэн</p>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                        </div>                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <?php
                if ($action=="container_detail")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $order_id = isset($_GET["id"]) ? intval(protect($_GET["id"])) : 0;
                    
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
                                    <?php
                                    $track = '';
                                    $status = '';
                                    $barcode = '';
                                    $delivered_date = '';
                                    $created_date = '';
                                    $price_date = '';
                                    $onway_date = '';
                                    $warehouse_date = '';
                                    $container_id = 0;
                                    $package1_name = '';
                                    $package1_num = '';
                                    $package1_price = '';
                                    $package2_name = '';
                                    $package2_num = '';
                                    $package2_price = '';
                                    $package3_name = '';
                                    $package3_num = '';
                                    $package3_price = '';
                                    $package4_name = '';
                                    $package4_num = '';
                                    $package4_price = '';
                                    
                                    if (isset($conn) && $conn) {
                                        $order_id_escaped = mysqli_real_escape_string($conn, $order_id);
                                        $sql = "SELECT * FROM container_item WHERE id='".$order_id_escaped."' LIMIT 1";
                                        $result = mysqli_query($conn, $sql);
                                        if ($result && mysqli_num_rows($result) == 1) {
                                            $data_order = mysqli_fetch_array($result);
                                            $receiver = isset($data_order["receiver"]) ? intval($data_order["receiver"]) : 0;
                                            $track = isset($data_order["third_party"]) ? htmlspecialchars($data_order["third_party"]) : '';
                                            $status = isset($data_order["status"]) ? htmlspecialchars($data_order["status"]) : '';
                                            $container_id = isset($data_order["container"]) ? intval($data_order["container"]) : 0;
                                            if ($receiver == $user_id) {
                                                $weight = isset($data_order["weight"]) ? htmlspecialchars($data_order["weight"]) : '';
                                                $barcode = isset($data_order["barcode"]) ? htmlspecialchars($data_order["barcode"]) : '';
                                                $package = isset($data_order["package"]) ? htmlspecialchars($data_order["package"]) : '';
                                                $price = isset($data_order["price"]) ? htmlspecialchars($data_order["price"]) : '';
                                                $status = isset($data_order["status"]) ? htmlspecialchars($data_order["status"]) : '';

                                                $created_date = isset($data_order["created_date"]) ? htmlspecialchars($data_order["created_date"]) : '';
                                                $price_date = isset($data_order["price_date"]) ? htmlspecialchars($data_order["price_date"]) : '';
                                                $onway_date = isset($data_order["onway_date"]) ? htmlspecialchars($data_order["onway_date"]) : '';
                                                $warehouse_date = isset($data_order["warehouse_date"]) ? htmlspecialchars($data_order["warehouse_date"]) : '';
                                                $delivered_date = isset($data_order["delivered_date"]) ? htmlspecialchars($data_order["delivered_date"]) : '';
                                                
                                                if (!empty($package)) {
                                                    $package_array = explode("##", $package);
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
                                                }
                                                ?>
                                                <div class="form-group">
                                                    <h4><?php echo htmlspecialchars($track ?? ''); ?></h4>
                                                    <span class="badge badge-success"> <?php echo htmlspecialchars($status ?? ''); ?> </span>
                                                    <?php echo htmlspecialchars($barcode ?? ''); ?>
                                                </div>
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr><th>Барааны тайлбар</th><th>тоо ширхэг</th><th>Үнэ</th></tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    if (!empty($package1_name)) {
                                                        echo "<tr><td>".htmlspecialchars($package1_name)."</td><td>".htmlspecialchars($package1_num)."</td><td>".htmlspecialchars($package1_price)."$</td></tr>";
                                                    }
                                                    if (!empty($package2_name)) {
                                                        echo "<tr><td>".htmlspecialchars($package2_name)."</td><td>".htmlspecialchars($package2_num)."</td><td>".htmlspecialchars($package2_price)."$</td></tr>";
                                                    }
                                                    if (!empty($package3_name)) {
                                                        echo "<tr><td>".htmlspecialchars($package3_name)."</td><td>".htmlspecialchars($package3_num)."</td><td>".htmlspecialchars($package3_price)."$</td></tr>";
                                                    }
                                                    if (!empty($package4_name)) {
                                                        echo "<tr><td>".htmlspecialchars($package4_name)."</td><td>".htmlspecialchars($package4_num)."</td><td>".htmlspecialchars($package4_price)."$</td></tr>";
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                                
                                                <?php
                                            }
                                            
                                            if ($receiver != $user_id) {
                                                ?>
                                                 <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                    Өөр харилцагчийн ачаа
                                                </div>

                                                <?php
                                            }
                                        } else {
                                            ?>
                                             <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                Ачаа олдсонгүй
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Чингэлэгийн хуваарь</h4>
                                    <?php
                                    $container_name = '';
                                    $container_status = '';
                                    if (isset($conn) && $conn && $container_id > 0) {
                                        $container_id_escaped = mysqli_real_escape_string($conn, $container_id);
                                        $sql = "SELECT * FROM container WHERE container_id = '".$container_id_escaped."'";
                                        $result = mysqli_query($conn, $sql);
                                        if ($result && $data_container = mysqli_fetch_array($result)) {
                                            $container_name = isset($data_container["name"]) ? htmlspecialchars($data_container["name"]) : '';
                                            $container_status = isset($data_container["status"]) ? htmlspecialchars($data_container["status"]) : '';
                                        }
                                    }
                                    ?>
                                    <span class="badge badge-success"> <?php echo htmlspecialchars($container_status ?? ''); ?> </span>
                                    Чингэлэг нэр: <?php echo htmlspecialchars($container_name ?? ''); ?>
                                    <div class="mt-container mx-auto">
                                        <div class="timeline-line">
                                            <?php if (!empty($delivered_date)): ?>
                                            <div class="item-timeline">
                                                <p class="t-time"><?php echo htmlspecialchars(substr($delivered_date, 0, 10)); ?></p>
                                                <div class="t-dot t-dot-primary">
                                                </div>
                                                <div class="t-text">
                                                    <p>Харилцагч авсан</p>
                                                    <p class="t-meta-time">43 өдөр</p>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <?php if (!empty($warehouse_date)): ?>
                                            <div class="item-timeline">
                                                <p class="t-time"><?php echo htmlspecialchars(substr($warehouse_date, 0, 10)); ?></p>
                                                <div class="t-dot t-dot-warning">
                                                </div>
                                                <div class="t-text">
                                                    <p>Монголд агуулахад бэлэн болсон</p>
                                                    <p class="t-meta-time">40 өдөр</p>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <?php
                                            if (isset($conn) && $conn && $container_id > 0) {
                                                $container_id_escaped = mysqli_real_escape_string($conn, $container_id);
                                                $sql = "SELECT * FROM container_log WHERE container='".$container_id_escaped."' ORDER BY timestamp DESC";
                                                $result = mysqli_query($conn, $sql);
                                                if ($result) {
                                                    while ($data_container_log = mysqli_fetch_array($result)) {
                                                        $log_date = isset($data_container_log["date"]) ? htmlspecialchars($data_container_log["date"]) : '';
                                                        $log_description = isset($data_container_log["description"]) ? htmlspecialchars($data_container_log["description"]) : '';
                                                        ?>
                                                        <div class="item-timeline">
                                                            <p class="t-time"><?php echo htmlspecialchars(substr($log_date, 0, 10)); ?></p>
                                                            <div class="t-dot t-dot-info">
                                                            </div>
                                                            <div class="t-text">
                                                                <p><?php echo htmlspecialchars($log_description); ?></p>
                                                                <p class="t-meta-time">20 өдөр</p>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>

                                            <?php if (!empty($onway_date)): ?>
                                            <div class="item-timeline">
                                                <p class="t-time"><?php echo htmlspecialchars(substr($onway_date, 0, 10)); ?></p>
                                                <div class="t-dot t-dot-info">
                                                </div>
                                                <div class="t-text">
                                                    <p>Америкаас монголруу ниссэн</p>
                                                    <p class="t-meta-time">3 өдөр</p>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <?php if (!empty($price_date)): ?>
                                            <div class="item-timeline">
                                                <p class="t-time"><?php echo htmlspecialchars(substr($price_date, 0, 10)); ?></p>
                                                <div class="t-dot t-dot-danger">
                                                </div>
                                                <div class="t-text">
                                                    <p>Америкт хүргэгдсэн</p>
                                                    <p class="t-meta-time">2 өдөр</p>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <?php if (!empty($created_date)): ?>
                                            <div class="item-timeline">
                                                <p class="t-time"><?php echo htmlspecialchars(substr($created_date, 0, 10)); ?></p>
                                                <div class="t-dot t-dot-dark">
                                                </div>
                                                <div class="t-text">
                                                    <p>Системд бүртгэгдсэн</p>
                                                    <p class="t-meta-time">0 өдөр</p>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                        </div>                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <?php 
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
                    

                    
                    <?php
                }
                ?>


                </div>
            <?php require_once("views/footer.php");?>
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
        $(document).ready(function() {
            if ($('#zero-config').length > 0) {
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
            }
        });
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->


</body>
</html>