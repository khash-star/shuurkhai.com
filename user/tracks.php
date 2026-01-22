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
<link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
<link href="plugins/animate/animate.css" rel="stylesheet" type="text/css" />
<script src="plugins/sweetalerts/promise-polyfill.js"></script>
<link href="plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<link href="plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
<link href="assets/css/components/custom-sweetalert.css" rel="stylesheet" type="text/css" />



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
                // Display success/error messages
                if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) {
                    ?>
                    <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        <?php echo htmlspecialchars($_SESSION['success_message']); ?>
                    </div>
                    <?php
                    unset($_SESSION['success_message']);
                }
                if (isset($_SESSION['error_message']) && !empty($_SESSION['error_message'])) {
                    ?>
                    <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        <?php echo htmlspecialchars($_SESSION['error_message']); ?>
                    </div>
                    <?php
                    unset($_SESSION['error_message']);
                }
                ?>

                <?php
                if ($action=="active")
                {
                
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                    $sql = "SELECT * FROM orders WHERE receiver=".$user_id_escaped." AND (status = 'weight_missing' OR status='received') AND created_date>'".date("Y-m-d",strtotime('-35 days'))."'";
                    if (isset($_POST["search"])) 
                    {
                        $search = mysqli_real_escape_string($conn, $_POST["search"]);
                        $sql .= " AND (third_party LIKE '%$search%' OR barcode LIKE '%$search%' OR package LIKE '%$search%')";
                    }
                    $sql .=" ORDER BY created_date DESC";

                    
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="tracks">Трак</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Бүртгэлтэй трак</a></li>
                        </ol>
                    </nav>
                    
                    <?php
                    require_once("views/tracks.php");?>                        
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
                        $sql .= " AND (third_party LIKE '%$search%' OR barcode LIKE '%$search%' OR package LIKE '%$search%')";
                    }
                    $sql .=" ORDER BY created_date DESC";
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="tracks">Трак</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Түүх</a></li>
                        </ol>
                    </nav>
                    
                    <?php
                    require_once("views/tracks.php");?>                        
                    <?php
                }
                ?>

                <?php
                if ($action=="insert")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    if ($user_id>0)
                        {
                        ?>
                        <nav class="breadcrumb-two" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                                <li class="breadcrumb-item active"><a href="tracks">Трак</a></li>
                                <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Шинээр бүртгэх</a></li>
                            </ol>
                        </nav>

                        <div class="row layout-spacing">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Трак дугаар оруулах</h5>
                                        <?php
    
                                        if (isset($_POST["track"]) && $_POST["track"]<>"")
                                        {
                                            $track=protect($_POST["track"]);
                                            $track = str_replace(" ","",$track);
                                            $track = str_replace("script","***",$track);
                                            $track = str_replace("php","***",$track);
                                            $track = str_replace("<?","***",$track);
                                            $track = string_clean($track);
                                            $track = trim($track);
                                            $track = strtoupper($track);
                                            $track_escaped = mysqli_real_escape_string($conn, $track);
                                            $proxy_id=0;
                                            if (isset($_POST["proxy_trigger"]))
                                            {
                                                if (intval($_POST["proxies"])>0)
                                                {
                                                    $proxy_id=intval($_POST["proxies"]);
                                                }

                                                if (intval($_POST["proxies"])==0)
                                                {
                                                    $proxy_name = isset($_POST["proxy_name"]) ? mysqli_real_escape_string($conn, $_POST["proxy_name"]) : '';
                                                    $proxy_surname = isset($_POST["proxy_surname"]) ? mysqli_real_escape_string($conn, $_POST["proxy_surname"]) : '';
                                                    $proxy_tel = isset($_POST["proxy_tel"]) ? mysqli_real_escape_string($conn, $_POST["proxy_tel"]) : '';
                                                    $proxy_address = isset($_POST["address"]) ? mysqli_real_escape_string($conn, $_POST["address"]) : '';
                                                    
                                                    $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                                                    $query_proxies =  mysqli_query($conn,"SELECT * FROM proxies WHERE customer_id='".$user_id_escaped."' AND tel='".$proxy_tel."'");
                                                    if ($query_proxies && mysqli_num_rows($query_proxies)==1)
                                                        {
                                                        $row_proxy = mysqli_fetch_array($query_proxies);
                                                        $proxy_id = isset($row_proxy["proxy_id"]) ? intval($row_proxy["proxy_id"]) : 0;					
                                                        }
                                                    if ($query_proxies && mysqli_num_rows($query_proxies)==0)	
                                                        {
                                                        mysqli_query($conn,"INSERT INTO proxies (customer_id,name,surname,tel,address,single) VALUES('".$user_id_escaped."','".$proxy_name."','".$proxy_surname."','".$proxy_tel."','".$proxy_address."',1)");
                                                        $proxy_id= mysqli_insert_id($conn); 	
                                                        }
                                                }
                                                
                                            }

                                            if (!isset($_POST["container_trigger"]))
                                            {
                                                if (isset($conn) && $conn) {
                                                    $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                                                    $sql = "SELECT * FROM customer WHERE customer_id ='".$user_id_escaped."'";
                                                    $result = mysqli_query($conn,$sql);
                                                    if ($result) {
                                                        $data_customer = mysqli_fetch_array($result);
                                                    }

                                                    if (substr($track,0,2)=='22' || substr($track,0,2)=='23' || substr($track,0,2)=='ES')
                                                        $sql = "SELECT * FROM orders WHERE third_party= '".$track_escaped."' OR extratracks LIKE '%".$track_escaped."%' LIMIT 1";	
                                                    else 
                                                        {
                                                            $track_eliminated = substr($track,-8,8);
                                                            $track_eliminated_escaped = mysqli_real_escape_string($conn, $track_eliminated);
                                                            $sql = "SELECT * FROM orders WHERE SUBSTRING(third_party,-8,8) = '".$track_eliminated_escaped."' OR extratracks LIKE '%".$track_escaped."%'  LIMIT 1";	
                                                        }

                                                    $result = mysqli_query($conn,$sql);
                                                    if ($result && mysqli_num_rows($result) == 1)
                                                    {
                                                        $data = mysqli_fetch_array($result);
                                                        $order_id = isset($data["order_id"]) ? intval($data["order_id"]) : 0;
                                                        $receiver = isset($data["receiver"]) ? intval($data["receiver"]) : 0;
                                                        $status = isset($data["status"]) ? htmlspecialchars($data["status"]) : '';
                                                        if ($receiver!=$user_id)
                                                        {
                                                            if ($status!="order")
                                                            {
                                                                ?>
                                                                <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                                    Таны илгээмж биш байна
                                                                </div>
                                                                <a href='tracks?action=insert' class='btn btn-primary btn-xs'>Ахин оруулах</a>

                                                                <?php
                                                            }
                                                            if ($status=="order")
                                                            {
                                                                $receiver=$user_id;
                                                            
                                                                $package1_name=isset($_POST["package1_name"]) ? mysqli_real_escape_string($conn, $_POST["package1_name"]) : '';
                                                                $package1_num =isset($_POST["package1_num"]) ? floatval($_POST["package1_num"]) : 0;
                                                                $package1_price =isset($_POST["package1_price"]) ? floatval($_POST["package1_price"]) : 0;
                                                                $package2_name=isset($_POST["package2_name"]) ? mysqli_real_escape_string($conn, $_POST["package2_name"]) : '';
                                                                $package2_num =isset($_POST["package2_num"]) ? floatval($_POST["package2_num"]) : 0;
                                                                $package2_price =isset($_POST["package2_price"]) ? floatval($_POST["package2_price"]) : 0;
                                                                $package3_name=isset($_POST["package3_name"]) ? mysqli_real_escape_string($conn, $_POST["package3_name"]) : '';
                                                                $package3_num =isset($_POST["package3_num"]) ? floatval($_POST["package3_num"]) : 0;
                                                                $package3_price =isset($_POST["package3_price"]) ? floatval($_POST["package3_price"]) : 0;
                                                                $package4_name=isset($_POST["package4_name"]) ? mysqli_real_escape_string($conn, $_POST["package4_name"]) : '';
                                                                $package4_num =isset($_POST["package4_num"]) ? floatval($_POST["package4_num"]) : 0;
                                                                $package4_price =isset($_POST["package4_price"]) ? floatval($_POST["package4_price"]) : 0;
                                                                
                                                                $package_array = array(
                                                                $package1_name, $package1_num, $package1_price,
                                                                $package2_name, $package2_num, $package2_price,
                                                                $package3_name, $package3_num, $package3_price,
                                                                $package4_name, $package4_num, $package4_price
                                                                );
                                                                
                                                                $package =implode("##",$package_array);
                                                                $package_escaped = mysqli_real_escape_string($conn, $package);
                                                                $package_price = $package1_price + $package2_price + $package3_price + $package4_price;
                                                                $transport = isset($_POST["transport"]) ? intval($_POST["transport"]) : 0;
                                                                $proxy_type = isset($_POST["proxy_type"]) ? intval($_POST["proxy_type"]) : 0;
                                                            
                                                                $order_id_escaped = mysqli_real_escape_string($conn, $order_id);
                                                                $receiver_escaped = mysqli_real_escape_string($conn, $receiver);
                                                                $sql_update = "UPDATE orders SET price='".$package_price."', receiver='".$receiver_escaped."', package='".$package_escaped."', status='filled', transport='".$transport."', proxy_id='".$proxy_id."', proxy_type='".$proxy_type."' WHERE order_id='".$order_id_escaped."'";
                                                                if ($conn && mysqli_query($conn,$sql_update)) 
                                                                {
                                                                    ?>
                                                                    <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                                        Захиалга амжилттай бүртгэгдлээ
                                                                    </div>
                                                                    <?php
                                                                }
                                                                else 
                                                                {
                                                                    ?>
                                                                    <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                                        Алдаа. <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error';?>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        
                                                        if ($receiver==$user_id)
                                                        {
                                                            if ($status=="item_missing")
                                                            {
                                                                $receiver=$user_id;
                                                            
                                                                $package1_name=isset($_POST["package1_name"]) ? mysqli_real_escape_string($conn, $_POST["package1_name"]) : '';
                                                                $package1_num =isset($_POST["package1_num"]) ? floatval($_POST["package1_num"]) : 0;
                                                                $package1_price =isset($_POST["package1_price"]) ? floatval($_POST["package1_price"]) : 0;
                                                                $package2_name=isset($_POST["package2_name"]) ? mysqli_real_escape_string($conn, $_POST["package2_name"]) : '';
                                                                $package2_num =isset($_POST["package2_num"]) ? floatval($_POST["package2_num"]) : 0;
                                                                $package2_price =isset($_POST["package2_price"]) ? floatval($_POST["package2_price"]) : 0;
                                                                $package3_name=isset($_POST["package3_name"]) ? mysqli_real_escape_string($conn, $_POST["package3_name"]) : '';
                                                                $package3_num =isset($_POST["package3_num"]) ? floatval($_POST["package3_num"]) : 0;
                                                                $package3_price =isset($_POST["package3_price"]) ? floatval($_POST["package3_price"]) : 0;
                                                                $package4_name=isset($_POST["package4_name"]) ? mysqli_real_escape_string($conn, $_POST["package4_name"]) : '';
                                                                $package4_num =isset($_POST["package4_num"]) ? floatval($_POST["package4_num"]) : 0;
                                                                $package4_price =isset($_POST["package4_price"]) ? floatval($_POST["package4_price"]) : 0;
                                                                
                                                                $package_array = array(
                                                                $package1_name, $package1_num, $package1_price,
                                                                $package2_name, $package2_num, $package2_price,
                                                                $package3_name, $package3_num, $package3_price,
                                                                $package4_name, $package4_num, $package4_price
                                                                );
                                                                
                                                                $package =implode("##",$package_array);
                                                                $package_escaped = mysqli_real_escape_string($conn, $package);
                                                                $package_price = $package1_price + $package2_price + $package3_price + $package4_price;
                                                                $transport = isset($_POST["transport"]) ? intval($_POST["transport"]) : 0;
                                                                $proxy_type = isset($_POST["proxy_type"]) ? intval($_POST["proxy_type"]) : 0;
                                                            
                                                                $order_id_escaped = mysqli_real_escape_string($conn, $order_id);
                                                                $receiver_escaped = mysqli_real_escape_string($conn, $receiver);
                                                                $sql_update = "UPDATE orders SET price='".$package_price."', receiver='".$receiver_escaped."', package='".$package_escaped."', status='filled', transport='".$transport."', proxy_id='".$proxy_id."', proxy_type='".$proxy_type."' WHERE order_id='".$order_id_escaped."'";

                                                                if ($conn && mysqli_query($conn,$sql_update)) 
                                                                {
                                                                    ?>
                                                                    <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                                        Захиалга амжилттай бүртгэгдлээ
                                                                    </div>
                                                                    <?php
                                                                    proxy_available($proxy_id,$proxy_id,1);
                                                                }
                                                                else 
                                                                {
                                                                    ?>
                                                                    <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                                        Алдаа:'<?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error';?>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                            
                                                            if ($status!="item_missing")
                                                            {
                                                                ?>
                                                                <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                                    Танд бүртгэлтэй Track байна
                                                                </div>
                                                                <a href='tracks' class='btn btn-success btn-xs'>Миний захиалга</a>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                }
                                                
                                                if ($result && mysqli_num_rows($result) == 0)  //Бүтргэлгүй
                                                {
                                                    $sender=0;
                                                    $receiver=$user_id;
                                                    
                                                    $package1_name=isset($_POST["package1_name"]) ? mysqli_real_escape_string($conn, $_POST["package1_name"]) : '';
                                                    $package1_num =isset($_POST["package1_num"]) ? floatval($_POST["package1_num"]) : 0;
                                                    $package1_price =isset($_POST["package1_price"]) ? floatval($_POST["package1_price"]) : 0;
                                                    $package2_name=isset($_POST["package2_name"]) ? mysqli_real_escape_string($conn, $_POST["package2_name"]) : '';
                                                    $package2_num =isset($_POST["package2_num"]) ? floatval($_POST["package2_num"]) : 0;
                                                    $package2_price =isset($_POST["package2_price"]) ? floatval($_POST["package2_price"]) : 0;
                                                    $package3_name=isset($_POST["package3_name"]) ? mysqli_real_escape_string($conn, $_POST["package3_name"]) : '';
                                                    $package3_num =isset($_POST["package3_num"]) ? floatval($_POST["package3_num"]) : 0;
                                                    $package3_price =isset($_POST["package3_price"]) ? floatval($_POST["package3_price"]) : 0;
                                                    $package4_name=isset($_POST["package4_name"]) ? mysqli_real_escape_string($conn, $_POST["package4_name"]) : '';
                                                    $package4_num =isset($_POST["package4_num"]) ? floatval($_POST["package4_num"]) : 0;
                                                    $package4_price =isset($_POST["package4_price"]) ? floatval($_POST["package4_price"]) : 0;
                                            
                                                    $package_array = array(
                                                    $package1_name, $package1_num, $package1_price,
                                                    $package2_name, $package2_num, $package2_price,
                                                    $package3_name, $package3_num, $package3_price,
                                                    $package4_name, $package4_num, $package4_price
                                                    );
                                                    
                                                    $package =implode("##",$package_array);
                                                    $package_escaped = mysqli_real_escape_string($conn, $package);
                                                    $package_price = $package1_price + $package2_price + $package3_price + $package4_price;
                                                    
                                                    $track_escaped2 = mysqli_real_escape_string($conn, $track);
                                                    $sql = "SELECT * FROM branch_inventories WHERE track='".$track_escaped2."'";
                                                    $branch_result = mysqli_query($conn,$sql);
                                                    if ($branch_result && mysqli_num_rows($branch_result)>0)                                                    
                                                        $status = 'received';
                                                    else
                                                        $status = 'weight_missing';
                                                    
                                                    $barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
                                                    do {
                                                        $barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
                                                        $barcode_escaped = mysqli_real_escape_string($conn, $barcode);
                                                        $query = mysqli_query($conn,"SELECT order_id FROM orders WHERE barcode='".$barcode_escaped."'");
                                                        } 
                                                        while ($query && mysqli_num_rows($query) == 1); 
                                                        
                                                    $sender_escaped = mysqli_real_escape_string($conn, $sender);
                                                    $receiver_escaped = mysqli_real_escape_string($conn, $receiver);
                                                    $status_escaped = mysqli_real_escape_string($conn, $status);
                                                    $sql_insert ="INSERT INTO orders (created_date,barcode,third_party,package,price,sender,receiver,status,proxy_id,owner,is_online) 
                                                        VALUES('".date("Y-m-d H:i:s")."','".$barcode_escaped."','".$track_escaped2."','".$package_escaped."','".$package_price."','".$sender_escaped."','".$receiver_escaped."','".$status_escaped."','".$proxy_id."',1,1)";
                                                    //echo $sql_insert;
                                                    if ($conn && mysqli_query($conn,$sql_insert))
                                                    {
                                                        proxy_available($proxy_id,0,1);
                                                        //mysqli_query($conn,"UPDATE customer SET cent=cent+1 WHERE customer_id='$user_id'");

                                                        ?>
                                                        <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                            Амжилттай үүсгэлээ
                                                        </div>
                                                        <?php
                                                    }
                                                    else 
                                                    {
                                                        ?>
                                                        <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                            <b><?php echo htmlspecialchars($error ?? '');?></b> Алдаа гарлаа: <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error';?>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            }
                                            
                                            if (isset($_POST["container_trigger"]))
                                            {
                                                if (isset($conn) && $conn) {
                                                    $track_eliminated = substr($track,-8,8);
                                                    $track_eliminated_escaped = mysqli_real_escape_string($conn, $track_eliminated);
                                                    $sql = "SELECT * FROM container_item WHERE SUBSTRING(track,-8,8) = '".$track_eliminated_escaped."'";
                                                    $result = mysqli_query($conn,$sql);
                                                    if ($result && mysqli_num_rows($result) > 1) 
                                                        echo "1-с олон track олдлоо. Та хайлтын утгаа ихэсгэж ахин оролдоно уу? <br>".anchor("welcome/track_search","Ахин оролдох",array("class"=>"btn btn-xs btn-primary"));
                                                    if ($result && mysqli_num_rows($result)  == 1)
                                                    {
                                                        $data = mysqli_fetch_array($result);
                                                        $status = isset($data["status"]) ? htmlspecialchars($data["status"]) : '';
                                                        if ($status=="weight_missing") echo "Америкт хүргэгдээгүй байна.";
                                                        if ($status=="new") echo "USА оффис-д байгаа Монголруу далайгаар гарахад бэлэн болсон.";
                                                        if ($status=="item_missing") echo "Задаргаагүй. Илгээмжийн доторх мэдээллийг оруулаагүй байна. Иймд Монголруу гарах боложгүй. Та нэвтэрч орон Track-aa өөр дээрээ бүртгүүлж барааны тайлбараа бөглөнө үү";
                                                        if ($status=="warehouse") echo "Монгол дахь агуулахад ирсэн байна. Та өөрийн биеэр ирж авах боломжтой.";
                                                        if ($status=="onway") echo "Америкаас Монголруу далайгаар ирж яваа.";
                                                        if ($status=="delivered") echo "Илгээмжийг хүлээн авч олгосон.";
                                                        if ($status=="filled") echo "Барааны мэдээллийн бүрэн оруулсан байна. Бид мэдээллийг шалган наашаа гаргахад бэлэн төлөвт оруулах болно.";
                                                        if ($status=="custom") echo "Гаальд саатсан байна.";
                                                        echo "<br><br>";
                                                        echo "<i>Хэрэв таны ачаа хүргэгдсэн төлөв байгаад манайд бүртгэгдээгүй бол бидэнд яаралтай мэдэгдэнэ үү.</i>";
                                                    }

                                                    if ($result && mysqli_num_rows($result) == 0)  //Бүтргэлгүй
                                                    {
                                                        // $sql2 = "SELECT customer_id,password,name FROM customer WHERE tel='$contact' LIMIT 1";
                                                        
                                                        
                                                        $sender=0;
                                                        $receiver=$user_id;
                                                        
                                                        $package1_name=isset($_POST["package1_name"]) ? mysqli_real_escape_string($conn, $_POST["package1_name"]) : '';
                                                        $package1_num =isset($_POST["package1_num"]) ? floatval($_POST["package1_num"]) : 0;
                                                        $package1_price =isset($_POST["package1_price"]) ? floatval($_POST["package1_price"]) : 0;
                                                        $package2_name=isset($_POST["package2_name"]) ? mysqli_real_escape_string($conn, $_POST["package2_name"]) : '';
                                                        $package2_num =isset($_POST["package2_num"]) ? floatval($_POST["package2_num"]) : 0;
                                                        $package2_price =isset($_POST["package2_price"]) ? floatval($_POST["package2_price"]) : 0;
                                                        $package3_name=isset($_POST["package3_name"]) ? mysqli_real_escape_string($conn, $_POST["package3_name"]) : '';
                                                        $package3_num =isset($_POST["package3_num"]) ? floatval($_POST["package3_num"]) : 0;
                                                        $package3_price =isset($_POST["package3_price"]) ? floatval($_POST["package3_price"]) : 0;
                                                        $package4_name=isset($_POST["package4_name"]) ? mysqli_real_escape_string($conn, $_POST["package4_name"]) : '';
                                                        $package4_num =isset($_POST["package4_num"]) ? floatval($_POST["package4_num"]) : 0;
                                                        $package4_price =isset($_POST["package4_price"]) ? floatval($_POST["package4_price"]) : 0;
                                                        
                                                        $package_array = array(
                                                        $package1_name, $package1_num, $package1_price,
                                                        $package2_name, $package2_num, $package2_price,
                                                        $package3_name, $package3_num, $package3_price,
                                                        $package4_name, $package4_num, $package4_price
                                                        );
                                                        
                                                        $package =implode("##",$package_array);
                                                        $package_escaped = mysqli_real_escape_string($conn, $package);
                                                        $package_price = $package1_price + $package2_price + $package3_price + $package4_price;
                                                        $transport = 0;
                                                        
                                                        $barcode='CO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
                                                        do {
                                                                $barcode='CO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
                                                                $barcode_escaped = mysqli_real_escape_string($conn, $barcode);
                                                                $query = mysqli_query($conn,"SELECT id FROM container_item WHERE barcode='".$barcode_escaped."'");
                                                            } 
                                                        while ($query && mysqli_num_rows($query)== 1); 	
                                                        
                                                        $track_escaped3 = mysqli_real_escape_string($conn, $track);
                                                        $sender_escaped = mysqli_real_escape_string($conn, $sender);
                                                        $receiver_escaped = mysqli_real_escape_string($conn, $receiver);
                                                        $sql_insert = "INSERT INTO container_item (
                                                                created_date,
                                                                barcode,
                                                                track,
                                                                package,
                                                                sender,
                                                                receiver,
                                                                status,
                                                                owner,
                                                                is_online)
                                                                VALUES
                                                                (
                                                                '".date("Y-m-d H:i:s")."',
                                                                '".$barcode_escaped."',
                                                                '".$track_escaped3."',
                                                                '".$package_escaped."',
                                                                '".$sender_escaped."',
                                                                '".$receiver_escaped."',
                                                                'weight_missing',
                                                                1,
                                                                1)";
                                                        if ($conn && mysqli_query($conn,$sql_insert))
                                                        {
                                                            ?>
                                                            <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                                Амжилттай үүсгэлээ
                                                            </div>
                                                            <?php
                                                        }
                                                        else 
                                                        {
                                                            ?>
                                                            <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                                <b><?php echo htmlspecialchars($error ?? '');?></b> Алдаа гарлаа: <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error';?>
                                                            </div>
                                                            <?php
                                                        }      
                                                    }
                                                }
                                            }
                                        }
                                        ?>

                                        <form action="tracks?action=insert"method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="track">Трак оруулах</label>
                                                <input type="text" class="form-control" id="track" placeholder="Трак дугаар" name="track" value="" required>
                                            </div>
                                            <h5 class="card-title">Барааны тайлбар</h5>
                                            <table class="table table-hover">
                                                <tr>	
                                                    <td><input type="text" name="package1_name" value="" class="form-control" placeholder="Цамц, Цүнх, Утас г.м" required></td>
                                                    <td><input type="text" name="package1_num" value="" class="form-control" placeholder="Тоо ширхэг" required></td>
                                                    <td><input type="text" name="package1_price" value="" class="form-control" placeholder="Үнэ" required></td>
                                                </tr>


                                                <tr>	
                                                    <td><input type="text" name="package2_name" value="" class="form-control" placeholder="Цамц, Цүнх, Утас г.м"></td>
                                                    <td><input type="text" name="package2_num" value="" class="form-control" placeholder="Тоо ширхэг"></td>
                                                    <td><input type="text" name="package2_price" value="" class="form-control" placeholder="Үнэ"></td>
                                                </tr>

                                                <tr>	
                                                    <td><input type="text" name="package3_name" value="" class="form-control" placeholder="Цамц, Цүнх, Утас г.м"></td>
                                                    <td><input type="text" name="package3_num" value="" class="form-control" placeholder="Тоо ширхэг"></td>
                                                    <td><input type="text" name="package3_price" value="" class="form-control" placeholder="Үнэ"></td>
                                                </tr>
                                                
                                                <tr>	
                                                    <td><input type="text" name="package4_name" value="" class="form-control" placeholder="Цамц, Цүнх, Утас г.м"></td>
                                                    <td><input type="text" name="package4_num" value="" class="form-control" placeholder="Тоо ширхэг"></td>
                                                    <td><input type="text" name="package4_price" value="" class="form-control" placeholder="Үнэ"></td>
                                                </tr>
                                            </table>
                                            <div class="input-group">
                                                <label for="container_trigger" class="mr-3"><b>Газраар /чингэлэг/ ирэх эсэх</b></label>
                                                <label class="switch s-icons s-outline s-outline-primary">
                                                    <input type="checkbox" name="container_trigger" value="container" id="container_trigger">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>

                                            <div class="input-group">
                                                <label for="proxy_trigger" class="mr-3"><b>Өөр хүн авах</b></label>
                                                <label class="switch s-icons s-outline s-outline-primary">
                                                    <input type="checkbox" name="proxy_trigger" value="container" id="proxy_trigger">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div class="input-group">
                                                <select name="proxies" id="proxies" class="form-control">
                                                    <?php
                                                    $sql ="SELECT * from proxies WHERE customer_id='$user_id' AND status=0";
                                                    $result = mysqli_query($conn,$sql);
                                                    while ($data = mysqli_fetch_array($result))
                                                        {
                                                            ?>
                                                            <option value="<?php echo htmlspecialchars($data["proxy_id"] ?? '');?>"> <?php echo htmlspecialchars($data["name"] ?? '');?> - <?php echo htmlspecialchars($data["tel"] ?? '');?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    <option value="0">Шинэ хүн оруулах</option>
                                                </select>
                                                <a href="profile?action=proxies" class="btn btn-success" id="proxy_edit_button">Засах</a>
                                            </div>
                                            

                                            <table class="table" id="proxy">
                                                <tr></tr><td>Нэр <span class="text-danger">зөвхөн криллээр бичнэ үү</span> </td><td><input type="text" name="proxy_name" placeholder="Нэр" class="form-control" id="name_crillic"></td></tr>
                                                <tr><td>Овог <span class="text-danger">зөвхөн криллээр бичнэ үү</span>)</td><td><input type="text" name="proxy_surname" placeholder="Овог" class="form-control" id="surname_crillic"></td></tr>
                                                <tr><td>Утасны дугаар</td><td><input type="text" name="proxy_tel" placeholder="Утасны дугаар" class="form-control" id="tel"></td></tr>
                                                <tr><td>Хаяг</td><td><textarea name="proxy_address" placeholder="Гэрийн хаяг" class="form-control"></textarea></td></tr>
                                            </table>
                                            
                                            <input type="submit" class="btn btn-primary" value="Хадгалах">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    else 
                    header("location:login");
                }
                ?>

                <?php
                if ($action=="edit")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    // Initialize variables to prevent undefined variable errors
                    $order_id = 0;
                    $receiver = 0;
                    $third_party = '';
                    $proxy_id_old = 0;
                    $proxy_id = 0;
                    $proxy_type = '';
                    $package = '';
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
                    $status = '';
                    $can_edit = false;
                    $order_found = false;
                    $is_receiver = false;
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="tracks">Трак</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Засах</a></li>
                        </ol>
                    </nav>

                    <div class="row layout-spacing">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Трактай ачааны тайлбар засах</h5>
                                    <?php
                                    if (isset($_GET["id"]) && !empty($_GET["id"]))
                                    {
                                        $order_id = isset($_GET["id"]) ? intval(protect($_GET["id"])) : 0;
                                        if ($order_id > 0) {
                                            $order_id_escaped = mysqli_real_escape_string($conn, $order_id);
                                            $sql = "SELECT * FROM orders WHERE order_id='".$order_id_escaped."'";
                                            $result = mysqli_query($conn,$sql);
                                            if ($result && mysqli_num_rows($result)==1)
                                            {
                                                $order_found = true;
                                                $data = mysqli_fetch_array($result);
                                                $receiver = isset($data["receiver"]) ? intval($data["receiver"]) : 0;
                                                $third_party = isset($data["third_party"]) ? htmlspecialchars($data["third_party"]) : '';
                                                $proxy_id_old = isset($data["proxy_id"]) ? intval($data["proxy_id"]) : 0;
                                                $proxy_id = isset($data["proxy_id"]) ? intval($data["proxy_id"]) : 0;
                                                $proxy_type = isset($data["proxy_type"]) ? htmlspecialchars($data["proxy_type"]) : '';
                                                $package = isset($data["package"]) ? htmlspecialchars($data["package"]) : '';
                                                $package_array = !empty($package) ? explode("##", $package) : array();
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
                                                $status = isset($data["status"]) ? htmlspecialchars($data["status"]) : '';
                                                $is_receiver = ($user_id == $receiver);
                                                $can_edit = ($status == 'weight_missing' || $status == 'received') && $is_receiver;
                                                if ($is_receiver)
                                            {
                                                if (isset($_POST["order_id"]) && $_POST["order_id"]<>"")
                                                {
                                                    // OTP код шалгах
                                                    $otp_code = isset($_POST["otp_code"]) ? trim($_POST["otp_code"]) : '';
                                                    if (empty($otp_code) || !preg_match('/^[0-9]{6}$/', $otp_code)) {
                                                        ?>
                                                        <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                            Зөв OTP код оруулна уу (6 оронтой тоо)
                                                        </div>
                                                        <?php
                                                    } else {
                                                        // OTP код зөв байна, үргэлжлүүлнэ
                                                        if (isset($_POST["proxy_trigger"]))
                                                    {
                                                        if (intval($_POST["proxies"])>0)
                                                        {
                                                            $proxy_id=$_POST["proxies"];
                                                        }
            
                                                        if (intval($_POST["proxies"])==0)
                                                        {
                                                            $proxy_name = isset($_POST["proxy_name"]) ? mysqli_real_escape_string($conn, protect($_POST["proxy_name"])) : '';
                                                            $proxy_surname = isset($_POST["proxy_surname"]) ? mysqli_real_escape_string($conn, protect($_POST["proxy_surname"])) : '';
                                                            $proxy_tel = isset($_POST["proxy_tel"]) ? mysqli_real_escape_string($conn, protect($_POST["proxy_tel"])) : '';
                                                            $proxy_address = isset($_POST["address"]) ? mysqli_real_escape_string($conn, protect($_POST["address"])) : '';
                                                            $proxy_address_alt = isset($_POST["proxy_address"]) ? mysqli_real_escape_string($conn, protect($_POST["proxy_address"])) : '';
                                                            if ($proxy_address == '' && $proxy_address_alt != '') {
                                                                $proxy_address = $proxy_address_alt;
                                                            }
                                                            
                                                            $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                                                            $query_proxies = mysqli_query($conn,"SELECT * FROM proxies WHERE customer_id='".$user_id_escaped."' AND tel='".$proxy_tel."'");
                                                            if ($query_proxies && mysqli_num_rows($query_proxies)==1)
                                                                {
                                                                $row_proxy = mysqli_fetch_array($query_proxies);
                                                                $proxy_id = isset($row_proxy["proxy_id"]) ? intval($row_proxy["proxy_id"]) : 0;					
                                                                }
                                                            if ($query_proxies && mysqli_num_rows($query_proxies)==0)	
                                                                {
                                                                mysqli_query($conn,"INSERT INTO proxies (customer_id,name,surname,tel,address,single) VALUES('".$user_id_escaped."','".$proxy_name."','".$proxy_surname."','".$proxy_tel."','".$proxy_address."',1)");
                                                                $proxy_id = mysqli_insert_id($conn); 	
                                                                }
                                                        }
                                                        
                                                    }
            
                                                
                                                       
                                                    $package1_name = isset($_POST["package1_name"]) ? mysqli_real_escape_string($conn, protect($_POST["package1_name"])) : '';
                                                    $package1_num = isset($_POST["package1_num"]) ? intval($_POST["package1_num"]) : 0;
                                                    $package1_price = isset($_POST["package1_price"]) ? floatval($_POST["package1_price"]) : 0;
                                                    $package2_name = isset($_POST["package2_name"]) ? mysqli_real_escape_string($conn, protect($_POST["package2_name"])) : '';
                                                    $package2_num = isset($_POST["package2_num"]) ? intval($_POST["package2_num"]) : 0;
                                                    $package2_price = isset($_POST["package2_price"]) ? floatval($_POST["package2_price"]) : 0;
                                                    $package3_name = isset($_POST["package3_name"]) ? mysqli_real_escape_string($conn, protect($_POST["package3_name"])) : '';
                                                    $package3_num = isset($_POST["package3_num"]) ? intval($_POST["package3_num"]) : 0;
                                                    $package3_price = isset($_POST["package3_price"]) ? floatval($_POST["package3_price"]) : 0;
                                                    $package4_name = isset($_POST["package4_name"]) ? mysqli_real_escape_string($conn, protect($_POST["package4_name"])) : '';
                                                    $package4_num = isset($_POST["package4_num"]) ? intval($_POST["package4_num"]) : 0;
                                                    $package4_price = isset($_POST["package4_price"]) ? floatval($_POST["package4_price"]) : 0;
                                                    
                                                    $package_array = array(
                                                    $package1_name, $package1_num, $package1_price,
                                                    $package2_name, $package2_num, $package2_price,
                                                    $package3_name, $package3_num, $package3_price,
                                                    $package4_name, $package4_num, $package4_price
                                                    );
                                                    
                                                    $package =implode("##",$package_array);
                                                    $package_price = floatval($package1_price) + floatval($package2_price) + floatval($package3_price) + floatval($package4_price);
                                                
                                                    // OTP код болон DE checkbox-ийг хадгалах
                                                    $otp_code_escaped = mysqli_real_escape_string($conn, $otp_code);
                                                    $de_checkbox = isset($_POST["de_checkbox"]) ? 1 : 0;
                                                    
                                                    $sql_update = "UPDATE orders SET price='$package_price',package='$package',proxy_id='$proxy_id',proxy_type='$proxy_type',otp_code='$otp_code_escaped',de_checkbox='$de_checkbox' WHERE order_id='$order_id'";
                                                    if (mysqli_query($conn,$sql_update)) 
                                                    {
                                                        if ($proxy_id_old<>$proxy_id)
                                                        {
                                                            proxy_available($proxy_id_old,$proxy_type,0);
                                                            proxy_available($proxy_id,$proxy_type,1);
                                                        }
                                                        // Амжилттай хадгалалтын дараа session message set хийж, tracks хуудас руу redirect хийх
                                                        $_SESSION['success_message'] = 'Захиалга амжилттай засагдлаа';
                                                        header('Location: tracks');
                                                        exit;
                                                    }
                                                    else 
                                                    {
                                                        ?>
                                                        <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                            Алдаа. <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error';?>
                                                        </div>
                                                        <?php
                                                    }
                                                                
                                                                
            
                                                       
                                                    
                                                }
                                                
                                                    } // OTP validation else block дуусгах
                                                
                                                // Show the form inside the query block
                                                if (!$is_receiver) {
                                                    ?>
                                                    <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                        Уучлаарай, таны ачаа биш байна.
                                                    </div>
                                                    <?php
                                                }
                                                
                                                // Show the form (it will be disabled if user can't edit)
                                                ?>
                                                <?php if (!$can_edit && $is_receiver): ?>
                                                <div class="alert alert-arrow-left alert-icon-left alert-light-warning mb-4" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                    Зөвхөн "weight_missing" эсвэл "received" статустай захиалгыг засварлах боломжтой.
                                                </div>
                                                <?php endif; ?>
                                                <form action="tracks?action=edit&id=<?php echo htmlspecialchars($order_id); ?>" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
                                                    <div class="form-group">
                                                        <label for="track">Трак</label>
                                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($third_party); ?>" readonly>
                                                    </div>
                                                    
                                                    <div class="form-group mt-3">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <label for="otp_code"><b>OTP код</b> <span class="text-danger">*</span></label>
                                                                <input type="text" name="otp_code" id="otp_code" class="form-control" placeholder="OTP код оруулах" maxlength="6" pattern="[0-9]{6}" required <?php echo $can_edit ? '' : 'disabled'; ?> style="font-size: 18px; letter-spacing: 8px; text-align: center; font-weight: bold;">
                                                                <small class="form-text" style="color: red;">!!! Сайтаас код ирээгүй тохиолдолд дурын код оруулахыг хортглоно</small>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label style="display: block; margin-bottom: 5px;"><b>DE-д хүргэгдэх бол чагтлана уу</b></label>
                                                                <div class="form-check" style="margin-top: 30px;">
                                                                    <input type="checkbox" name="de_checkbox" id="de_checkbox" class="form-check-input" value="1" <?php echo $can_edit ? '' : 'disabled'; ?>>
                                                                    <label class="form-check-label" for="de_checkbox">
                                                                        DE
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <h5 class="card-title">Барааны тайлбар</h5>
                                                    <table class="table table-hover">
                                                        <tr>	
                                                            <td><input type="text" name="package1_name" value="<?php echo htmlspecialchars($package1_name); ?>" class="form-control" placeholder="Цамц, Цүнх, Утас г.м" <?php echo $can_edit ? 'required' : 'disabled'; ?>></td>
                                                            <td><input type="text" name="package1_num" value="<?php echo htmlspecialchars($package1_num); ?>" class="form-control" placeholder="Тоо ширхэг" <?php echo $can_edit ? 'required' : 'disabled'; ?>></td>
                                                            <td><input type="text" name="package1_price" value="<?php echo htmlspecialchars($package1_price); ?>" class="form-control" placeholder="Үнэ ($)" <?php echo $can_edit ? 'required' : 'disabled'; ?>></td>
                                                        </tr>


                                                        <tr>	
                                                            <td><input type="text" name="package2_name" value="<?php echo htmlspecialchars($package2_name); ?>" class="form-control" placeholder="Цамц, Цүнх, Утас г.м" <?php echo $can_edit ? '' : 'disabled'; ?>></td>
                                                            <td><input type="text" name="package2_num" value="<?php echo htmlspecialchars($package2_num); ?>" class="form-control" placeholder="Тоо ширхэг" <?php echo $can_edit ? '' : 'disabled'; ?>></td>
                                                            <td><input type="text" name="package2_price" value="<?php echo htmlspecialchars($package2_price); ?>" class="form-control" placeholder="Үнэ ($)" <?php echo $can_edit ? '' : 'disabled'; ?>></td>
                                                        </tr>

                                                        <tr>	
                                                            <td><input type="text" name="package3_name" value="<?php echo htmlspecialchars($package3_name); ?>" class="form-control" placeholder="Цамц, Цүнх, Утас г.м" <?php echo $can_edit ? '' : 'disabled'; ?>></td>
                                                            <td><input type="text" name="package3_num" value="<?php echo htmlspecialchars($package3_num); ?>" class="form-control" placeholder="Тоо ширхэг" <?php echo $can_edit ? '' : 'disabled'; ?>></td>
                                                            <td><input type="text" name="package3_price" value="<?php echo htmlspecialchars($package3_price); ?>" class="form-control" placeholder="Үнэ ($)" <?php echo $can_edit ? '' : 'disabled'; ?>></td>
                                                        </tr>
                                                        
                                                        <tr>	
                                                            <td><input type="text" name="package4_name" value="<?php echo htmlspecialchars($package4_name); ?>" class="form-control" placeholder="Цамц, Цүнх, Утас г.м" <?php echo $can_edit ? '' : 'disabled'; ?>></td>
                                                            <td><input type="text" name="package4_num" value="<?php echo htmlspecialchars($package4_num); ?>" class="form-control" placeholder="Тоо ширхэг" <?php echo $can_edit ? '' : 'disabled'; ?>></td>
                                                            <td><input type="text" name="package4_price" value="<?php echo htmlspecialchars($package4_price); ?>" class="form-control" placeholder="Үнэ ($)" <?php echo $can_edit ? '' : 'disabled'; ?>></td>
                                                        </tr>
                                                    </table>

                                                    <div class="input-group">
                                                        <label for="proxy_trigger" class="mr-3"><b>Өөр хүн авах</b></label>
                                                        <label class="switch s-icons s-outline s-outline-primary">
                                                            <input type="checkbox" name="proxy_trigger" value="container" id="proxy_trigger" <?php echo (isset($proxy_id) && $proxy_id>0) ? 'checked' : ''; ?> <?php echo $can_edit ? '' : 'disabled'; ?>>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <select name="proxies" id="proxies" class="form-control" <?php echo $can_edit ? '' : 'disabled'; ?>>
                                                        <?php
                                                        $proxy_id_safe = isset($proxy_id) ? intval($proxy_id) : 0;
                                                        $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                                                        $sql = "SELECT * FROM proxies WHERE customer_id='".$user_id_escaped."' AND (status=0 OR proxy_id='".$proxy_id_safe."')";
                                                        $result = mysqli_query($conn,$sql);
                                                        if ($result) {
                                                            while ($data = mysqli_fetch_array($result))
                                                            {
                                                                $proxy_id_val = isset($data["proxy_id"]) ? intval($data["proxy_id"]) : 0;
                                                                $proxy_name_display = isset($data["name"]) ? htmlspecialchars($data["name"]) : '';
                                                                $proxy_tel_display = isset($data["tel"]) ? htmlspecialchars($data["tel"]) : '';
                                                                $selected = ($proxy_id_safe == $proxy_id_val) ? 'SELECTED="SELECTED"' : '';
                                                                ?>
                                                                <option value="<?php echo htmlspecialchars($proxy_id_val); ?>" <?php echo htmlspecialchars($selected); ?>> <?php echo htmlspecialchars($proxy_name_display); ?> - <?php echo htmlspecialchars($proxy_tel_display); ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        <option value="-1">Шинэ хүн оруулах</option>
                                                    </select>

                                                    <table class="table" id="proxy">
                                                        <tr></tr><td>Нэр(*)</td><td><input type="text" name="proxy_name" placeholder="Нэр" class="form-control" <?php echo $can_edit ? '' : 'disabled'; ?>></td></tr>
                                                        <tr><td>Овог(*)</td><td><input type="text" name="proxy_surname" placeholder="Овог" class="form-control" <?php echo $can_edit ? '' : 'disabled'; ?>></td></tr>
                                                        <tr><td>Утасны дугаар(*)</td><td><input type="text" name="proxy_tel" placeholder="Утасны дугаар" class="form-control" <?php echo $can_edit ? '' : 'disabled'; ?>></td></tr>
                                                        <tr><td>Хаяг</td><td><textarea name="proxy_address" placeholder="Гэрийн хаяг" class="form-control" <?php echo $can_edit ? '' : 'disabled'; ?>></textarea></td></tr>
                                                    </table>
                                                    
                                                    <input type="submit" class="btn btn-primary" value="Хадгалах" <?php echo $can_edit ? '' : 'disabled'; ?>>
                                                </form>
                                                <?php
                                            }
                                        }
                                        else 
                                        {
                                            // Order not found in database
                                            $order_found = false;
                                            ?>
                                             <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                Ачааны дугаар олдсонгүй
                                            </div>
                                            <?php
                                        }
                                        }
                                        else 
                                        {
                                            // Invalid order ID
                                            $order_found = false;
                                            ?>
                                            <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                Захиалгын дугаар буруу байна.
                                            </div>
                                            <?php
                                        }
                                    }
                                    else 
                                    {
                                        // No ID provided
                                        $order_found = false;
                                        ?>
                                        <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                            Захиалгын дугаар байхгүй байна.
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>


                <?php
                if ($action=="detail")
                {
                    $user_id = $_SESSION["c_user_id"];
                    $order_id = $_GET["id"];
                    
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="tracks">Трак</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Дэлгэрэнгүй</a></li>
                        </ol>
                    </nav>

                    <div class="row layout-spacing">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    $order_id = isset($_GET["id"]) ? intval(protect($_GET["id"])) : 0;
                                    $order_id_escaped = mysqli_real_escape_string($conn, $order_id);
                                    $sql = "SELECT * FROM orders WHERE order_id='".$order_id_escaped."' LIMIT 1";
                                    $result = mysqli_query($conn,$sql);
                                    if ($result && mysqli_num_rows($result)==1)
                                    {
                                        $data_order = mysqli_fetch_array($result);
                                        $receiver = isset($data_order["receiver"]) ? intval($data_order["receiver"]) : 0;
                                        $track = isset($data_order["third_party"]) ? htmlspecialchars($data_order["third_party"]) : '';
                                        $status = isset($data_order["status"]) ? htmlspecialchars($data_order["status"]) : '';
                                        $proxy = isset($data_order["proxy_id"]) ? intval($data_order["proxy_id"]) : 0;
                                        $proxy_type = isset($data_order["proxy_type"]) ? htmlspecialchars($data_order["proxy_type"]) : '';
                                        $otp_code = isset($data_order["otp_code"]) ? htmlspecialchars($data_order["otp_code"]) : '';
                                        if ($receiver==$user_id)
                                        {
                                            $weight=$data_order["weight"];
                                            $barcode=$data_order["barcode"];
                                            $package=$data_order["package"];
                                            $price=$data_order["price"];
                                            $status=$data_order["status"];

                                            $created_date=$data_order["created_date"];
                                            $received_date=$data_order["received_date"];
                                            $weight_date=$data_order["weight_date"];
                                            $onair_date=$data_order["onair_date"];
                                            $warehouse_date=$data_order["warehouse_date"];
                                            $delivered_date = $data_order["delivered_date"];
                                            
                                            $package_array = !empty($package) ? explode("##", $package) : array();
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
                                            ?>
                                            <div class="form-group">
                                                <h4><?php echo htmlspecialchars($track ?? '');?></h4>
                                                <?php echo htmlspecialchars($barcode ?? '');?>
                                                <?php 
                                                if (isset($proxy) && $proxy!=0) 
                                                {
                                                    ?>
                                                    <br>
                                                    <span class="badge outline-badge-success">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>                                   
                                                        <?php echo htmlspecialchars(proxy($proxy,"name") ?? '');?> 
                                                    </span>
                                                    <?php
                                                }
                                                else 
                                                {
                                                    ?>
                                                    <br>
                                                    <span class="badge outline-badge-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>                                   
                                                        <?php echo htmlspecialchars(customer($user_id,"name") ?? '');?> 
                                                    </span>
                                                    <?php
                                                }
                                                ?>
                                                <span class="badge badge-info badge-pills"> <?php echo htmlspecialchars($status ?? '');?> </span>
                                                
                                            </div>
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr><th>Барааны тайлбар</th><th>тоо ширхэг</th><th>Үнэ</th><th>OTP код</th></tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $otp_display = !empty($otp_code) ? '<span class="badge text-white" style="background-color: #22c55e; font-size: 14px; padding: 4px 10px; font-weight: normal;">' . $otp_code . '</span>' : '-';
                                                if (isset($package1_name) && $package1_name!="")
                                                {
                                                    echo "<tr><td>".htmlspecialchars($package1_name)."</td><td>".htmlspecialchars($package1_num)."</td><td>".htmlspecialchars($package1_price)."$</td><td>".$otp_display."</td></tr>";
                                                }
                                                if (isset($package2_name) && $package2_name!="")
                                                {
                                                    echo "<tr><td>".htmlspecialchars($package2_name)."</td><td>".htmlspecialchars($package2_num)."</td><td>".htmlspecialchars($package2_price)."$</td><td>".$otp_display."</td></tr>";
                                                }
                                                if (isset($package3_name) && $package3_name!="")
                                                {
                                                    echo "<tr><td>".htmlspecialchars($package3_name)."</td><td>".htmlspecialchars($package3_num)."</td><td>".htmlspecialchars($package3_price)."$</td><td>".$otp_display."</td></tr>";
                                                }
                                                if (isset($package4_name) && $package4_name!="")
                                                {
                                                    echo "<tr><td>".htmlspecialchars($package4_name)."</td><td>".htmlspecialchars($package4_num)."</td><td>".htmlspecialchars($package4_price)."$</td><td>".$otp_display."</td></tr>";
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                            <?php
                                        }
                                        
                                        if ($receiver!=$user_id)
                                            {
                                                ?>
                                                 <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                    Өөр харилцагчийн ачаа
                                                </div>

                                                <?php
                                            }
                                            
                                        
                                
                                    }
                                    else 
                                    {
                                        ?>
                                         <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                            Трак олдсонгүй
                                        </div>
                                        <?php
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
                                                <p class="t-time"><?php echo htmlspecialchars(substr($delivered_date ?? '',0,10));?></p>
                                                <div class="t-dot t-dot-primary">
                                                </div>
                                                <div class="t-text">
                                                    <p>Харилцагч авсан</p>
                                                    <p class="t-meta-time">7 өдөр</p>
                                                </div>
                                            </div>

                                            <div class="item-timeline">
                                                <p class="t-time"><?php echo htmlspecialchars(substr($warehouse_date ?? '',0,10));?></p>
                                                <div class="t-dot t-dot-warning">
                                                </div>
                                                <div class="t-text">
                                                    <p>Монголд агуулахад бэлэн болсон</p>
                                                    <p class="t-meta-time">6 өдөр</p>
                                                </div>
                                            </div>

                                            <?php
                                            if (isset($onair_date) && $onair_date<>"")
                                            {
                                                ?>
                                                <div class="item-timeline">
                                                    <p class="t-time"><?php echo htmlspecialchars(substr($onair_date,0,10));?></p>
                                                    <div class="t-dot t-dot-info">
                                                    </div>
                                                    <div class="t-text">
                                                        <p>Америкаас монголруу ниссэн</p>
                                                        <p class="t-meta-time">3 өдөр</p>
                                                    </div>
                                                </div>
                                                <?php
                                            }

                                            
                                            if (isset($weight_date) && $weight_date<>"")
                                            {
                                                ?>
                                                <div class="item-timeline">
                                                    <p class="t-time"><?php echo htmlspecialchars(substr($weight_date,0,10));?></p>
                                                    <div class="t-dot t-dot-dark">
                                                    </div>
                                                    <div class="t-text">
                                                        <p>Нисэхэд бэлэн болсон</p>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                            <?php
                                            if (isset($received_date) && $received_date<>"")
                                            {
                                                ?>
                                                <div class="item-timeline">
                                                    <p class="t-time"><?php echo htmlspecialchars(substr($received_date,0,10));?></p>
                                                    <div class="t-dot t-dot-dark">
                                                    </div>
                                                    <div class="t-text">
                                                        <p>DE хүргэгдсэн</p>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <div class="item-timeline">
                                                <p class="t-time"><?php echo htmlspecialchars(substr($created_date ?? '',0,10));?></p>
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
                    <?php
                }
                ?>

                <?php
                if ($action=="delete")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $order_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
                    
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="tracks">Трак</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Устгах</a></li>
                        </ol>
                    </nav>

                    <div class="row layout-spacing">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    if (isset($conn) && $conn) {
                                        $order_id_escaped = mysqli_real_escape_string($conn, $order_id);
                                        $sql = "SELECT * FROM orders WHERE order_id='".$order_id_escaped."' LIMIT 1";
                                        $result = mysqli_query($conn,$sql);
                                        if ($result && mysqli_num_rows($result)==1)
                                        {
                                            $data_order = mysqli_fetch_array($result);
                                            $receiver = isset($data_order["receiver"]) ? intval($data_order["receiver"]) : 0;
                                            $track = isset($data_order["third_party"]) ? htmlspecialchars($data_order["third_party"]) : '';
                                            $proxy_id = isset($data_order["proxy_id"]) ? intval($data_order["proxy_id"]) : 0;
                                            $proxy_type = isset($data_order["proxy_type"]) ? intval($data_order["proxy_type"]) : 0;
                                            $status = isset($data_order["status"]) ? htmlspecialchars($data_order["status"]) : '';
                                            if ($receiver==$user_id)
                                            {
                                                if ($status=='weight_missing')
                                                {
                                                    $order_id_escaped2 = mysqli_real_escape_string($conn, $order_id);
                                                    $sql = "DELETE FROM orders WHERE order_id='".$order_id_escaped2."' LIMIT 1";
                                                    if (mysqli_query($conn,$sql))
                                                    {
                                                        proxy_available($proxy_id,$proxy_type,0);
                                                        ?>
                                                        <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                            Амжилттай устгалаа.
                                                        </div>
                                                        <?php 
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                            Устгахад алдаа гарлаа. <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error';?>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                
                                                if ($status<>'weight_missing')
                                                {
                                                    ?>
                                                     <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                        Устгах боломжгүй төлөвт байна
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            
                                            if ($receiver!=$user_id)
                                            {
                                                ?>
                                                 <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                    Өөр харилцагчийн ачаа
                                                </div>
                                                <?php
                                            }
                                        }
                                        else 
                                        {
                                            ?>
                                             <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                Трак олдсонгүй
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                         <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                            Database connection error
                                        </div>
                                        <?php
                                    }
                                    ?>

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
            $('#proxies').hide();
            $('#proxy_edit_button').hide();
            $('#proxy').hide();
            $("#district").chained("#city");
            $('#container_trigger').on('click', function () {
            if( $('#container_trigger').is(':checked'))
               {
                    swal({
                    title: 'Чингэлэг сонголоо!',
                    text: "Та ачаагаа чингэлэг-р сонгосоноор таны ачаа 45 хоногын дотор далайгаар ирнэ, Төлбөрийн хувьд уяан хатан нөхцөлтэй.",
                    type: 'success',
                    padding: '2em'
                    })
                }
            })

            $('#proxy_trigger').on('click', function () {
            if( $('#proxy_trigger').is(':checked'))
                {
                    $('#proxies').show();
                    if ($("#proxies option:selected").is(':last-child'))
                    {
                        $('#proxy').show(); 
                        $('#proxy :input').prop('required',true);
                    }
                    $('#proxy_edit_button').show(); 

                }
                else 
                {
                    $('#proxies').hide();
                    $('#proxy').hide();
                    $('#proxy :input').prop('required',false);
                    $('#proxy_edit_button').hide(); 

                }
            })

            $('#proxies').change(function () {
                if ($("#proxies option:selected").is(':last-child'))
                {
                    $('#proxy').show(); 
                    $('#proxy :input').prop('required',true);
                }
                else 
                {
                    $('#proxy').hide();
                    $('#proxy :input').prop('required',false);
                }
            })
            
            
        });
    </script>
    <script src="plugins/highlight/highlight.pack.js"></script>
    <script src="assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="assets/js/scrollspyNav.js"></script>

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="plugins/table/datatable/datatables.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.bundle.min.js"></script>
    <script src="plugins/input-mask/input-mask.js"></script>

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
    <script src="plugins/sweetalerts/sweetalert2.min.js"></script>
    <script src="plugins/sweetalerts/custom-sweetalert.js"></script>


</body>
</html>