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
<link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
<link href="plugins/animate/animate.css" rel="stylesheet" type="text/css" />
<script src="plugins/sweetalerts/promise-polyfill.js"></script>
<link href="plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<link href="plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
<link href="assets/css/components/custom-sweetalert.css" rel="stylesheet" type="text/css" />



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
                    $sql = "SELECT * FROM orders WHERE receiver=".$user_id." AND (status = 'weight_missing' OR status='received') AND created_date>'".date("Y-m-d",strtotime('-35 days'))."'";
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
                            <li class="breadcrumb-item active"><a href="tracks">Трак</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Бүртгэлтэй трак</a></li>
                        </ol>
                    </nav>
                    
                    <?
                    require_once("views/tracks.php");?>                        
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
                            <li class="breadcrumb-item active"><a href="tracks">Трак</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Түүх</a></li>
                        </ol>
                    </nav>
                    
                    <?
                    require_once("views/tracks.php");?>                        
                    <?
                }
                ?>

                <?
                if ($action=="insert")
                {
                    $user_id = $_SESSION["c_user_id"];
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
                                        <?
    
                                        if (isset($_POST["track"]) && $_POST["track"]<>"")
                                        {
                                            $track=$_POST["track"];
                                            $track = str_replace(" ","",$track);
                                            $track = str_replace("script","***",$track);
                                            $track = str_replace("php","***",$track);
                                            $track = str_replace("<?","***",$track);
                                            $track = string_clean($track);
                                            $track = trim($track);
                                            $track = strtoupper($track);
                                            $proxy_id=0;
                                            if (isset($_POST["proxy_trigger"]))
                                            {
                                                if (intval($_POST["proxies"])>0)
                                                {
                                                    $proxy_id=$_POST["proxies"];
                                                }

                                                if (intval($_POST["proxies"])==0)
                                                {
                                                    $proxy_name = $_POST["proxy_name"];
                                                    $proxy_surname = $_POST["proxy_surname"];
                                                    $proxy_tel = $_POST["proxy_tel"];
                                                    $proxy_address = mysqli_escape_string($conn,$_POST["address"]);
                                                    
                                                    $query_proxies =  mysqli_query($conn,'SELECT * FROM proxies WHERE customer_id="'.$user_id.'" AND tel="'.$proxy_tel.'"');
                                                    if (mysqli_num_rows($query_proxies)==1)
                                                        {
                                                        $row_proxy = mysqli_fetch_array($query_proxies);
                                                        $proxy_id = $row_proxy["proxy_id"];					
                                                        }
                                                    if (mysqli_num_rows($query_proxies)==0)	
                                                        {
                                                        mysqli_query($conn,'INSERT INTO proxies (customer_id,name,surname,tel,address,single) VALUES("'.$user_id.'","'.$proxy_name.'","'.$proxy_surname.'","'.$proxy_tel.'","'.$proxy_address.'",1)');
                                                        $proxy_id= mysqli_insert_id($conn); 	
                                                        }
                                                }
                                                
                                            }

                                            if (!isset($_POST["container_trigger"]))
                                            {

                                                $sql = "SELECT * FROM customer WHERE customer_id ='$user_id'";
                                                $result = mysqli_query($conn,$sql);
                                                $data_customer = mysqli_fetch_array($result);

                                                if (substr($track,0,2)=='22' || substr($track,0,2)=='23' || substr($track,0,2)=='ES')
                                                    $sql = "SELECT * FROM orders WHERE third_party= '$track' OR extratracks LIKE '%$track%' LIMIT 1";	
                                                else 
                                                    {
                                                        $track_eliminated = substr($track,-8,8);
                                                        $sql = "SELECT * FROM orders WHERE SUBSTRING(third_party,-8,8) = '$track_eliminated' OR extratracks LIKE '%$track%'  LIMIT 1";	
                                                    }

                                                $result = mysqli_query($conn,$sql);
                                                if (mysqli_num_rows($result) == 1)
                                                {
                                                    $data = mysqli_fetch_array($result);
                                                    $order_id = $data["order_id"];
                                                    $receiver = $data["receiver"];
                                                    $status = $data["status"];
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
                                                            <a href='track?action=insert' class='btn btn-primary btn-xs'>Ахин оруулах</a>

                                                            <?
                                                        }
                                                        if ($status=="order")
                                                        {
                                                            $receiver=$user_id;
                                                        
                                                            $package1_name=mysqli_escape_string($conn,$_POST["package1_name"]);
                                                            $package1_num =$_POST["package1_num"];
                                                            $package1_price =$_POST["package1_price"];
                                                            $package2_name=mysqli_escape_string($conn,$_POST["package2_name"]);
                                                            $package2_num =$_POST["package2_num"];
                                                            $package2_price =$_POST["package2_price"];
                                                            $package3_name=mysqli_escape_string($conn,$_POST["package3_name"]);
                                                            $package3_num =$_POST["package3_num"];
                                                            $package3_price =$_POST["package3_price"];
                                                            $package4_name=mysqli_escape_string($conn,$_POST["package4_name"]);
                                                            $package4_num =$_POST["package4_num"];
                                                            $package4_price =$_POST["package4_price"];
                                                            
                                                            $package_array = array(
                                                            $package1_name, $package1_num, $package1_price,
                                                            $package2_name, $package2_num, $package2_price,
                                                            $package3_name, $package3_num, $package3_price,
                                                            $package4_name, $package4_num, $package4_price
                                                            );
                                                            
                                                            $package =implode("##",$package_array);
                                                            $package_price = $package1_price + $package2_price + $package3_price + $package4_price;
                                                        
                                                            $sql_update = "UPDATE orders SET (price='$package_price',receiver ='$receiver',package='$package',status='filled',transport='$transport',proxy_id='$proxy_id',proxy_type='$proxy_type') WHERE order_id='$order_id'";
                                                            if (mysqli_query($conn,$sql_update)) 
                                                            {
                                                                ?>
                                                                <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                                    Захиалга амжилттай бүртгэгдлээ
                                                                </div>
                                                                <?
                                                            }
                                                            else 
                                                            {
                                                                ?>
                                                                <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                                    Алдаа. <?=mysqli_error($conn);?>
                                                                </div>
                                                                <?
                                                            }
                                                        }
                                                    }
                                                    
                                                    if ($receiver==$user_id)
                                                    {
                                                        if ($status=="item_missing")
                                                        {
                                                            $receiver=$user_id;
                                                        
                                                            $package1_name=mysqli_escape_string($conn,$_POST["package1_name"]);
                                                            $package1_num =$_POST["package1_num"];
                                                            $package1_price =$_POST["package1_price"];
                                                            $package2_name=mysqli_escape_string($conn,$_POST["package2_name"]);
                                                            $package2_num =$_POST["package2_num"];
                                                            $package2_price =$_POST["package2_price"];
                                                            $package3_name=mysqli_escape_string($conn,$_POST["package3_name"]);
                                                            $package3_num =$_POST["package3_num"];
                                                            $package3_price =$_POST["package3_price"];
                                                            $package4_name=mysqli_escape_string($conn,$_POST["package4_name"]);
                                                            $package4_num =$_POST["package4_num"];
                                                            $package4_price =$_POST["package4_price"];
                                                            
                                                            $package_array = array(
                                                            $package1_name, $package1_num, $package1_price,
                                                            $package2_name, $package2_num, $package2_price,
                                                            $package3_name, $package3_num, $package3_price,
                                                            $package4_name, $package4_num, $package4_price
                                                            );
                                                            
                                                            $package =implode("##",$package_array);
                                                            $package_price = $package1_price + $package2_price + $package3_price + $package4_price;
                                                        
                                                            $sql_update = "UPDATE orders SET (price='$package_price',receiver ='$receiver',package='$package',status='filled',transport='$transport',proxy_id='$proxy_id',proxy_type='$proxy_type') WHERE order_id='$order_id'";

                                                            if (mysqli_query($conn,$sql_update)) 
                                                                {
                                                                    ?>
                                                                    <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                                        Захиалга амжилттай бүртгэгдлээ
                                                                    </div>
                                                                    <?
                                                                    proxy_available($proxy_id,$proxy_id,1);
                                                                }
                                                                else 
                                                                {
                                                                    ?>
                                                                    <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                                        Алдаа:'<?=mysqli_error($conn);?>
                                                                    </div>
                                                                    <?
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

                                                            <?
                                                        }
                                                        
                                                    }
                                            
                                                }

                                                if (mysqli_num_rows($result) == 0)  //Бүтргэлгүй
                                                {
                                                    $sender=0;
                                                    $receiver=$user_id;
                                                    
                                                    $package1_name=mysqli_escape_string($conn,$_POST["package1_name"]);
                                                    $package1_num =$_POST["package1_num"];
                                                    $package1_price =$_POST["package1_price"];
                                                    $package2_name=mysqli_escape_string($conn,$_POST["package2_name"]);
                                                    $package2_num =$_POST["package2_num"];
                                                    $package2_price =$_POST["package2_price"];
                                                    $package3_name=mysqli_escape_string($conn,$_POST["package3_name"]);
                                                    $package3_num =$_POST["package3_num"];
                                                    $package3_price =$_POST["package3_price"];
                                                    $package4_name=mysqli_escape_string($conn,$_POST["package4_name"]);
                                                    $package4_num =$_POST["package4_num"];
                                                    $package4_price =$_POST["package4_price"];
                                            
                                                    $package_array = array(
                                                    $package1_name, $package1_num, $package1_price,
                                                    $package2_name, $package2_num, $package2_price,
                                                    $package3_name, $package3_num, $package3_price,
                                                    $package4_name, $package4_num, $package4_price
                                                    );
                                                    
                                                    $package =implode("##",$package_array);
                                                    $package_price = intval($package1_price) + intval($package2_price) + intval($package3_price) + intval($package4_price);
                                                    
                                                    $sql = "SELECT *FROM branch_inventories WHERE track='$track'";
                                                    if (mysqli_num_rows(mysqli_query($conn,$sql))>0)                                                    
                                                    $status = 'received'; else $status= 'weight_missing';
                                                    $barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
                                                    do {
                                                        $barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
                                                        $query = mysqli_query($conn,"SELECT order_id FROM orders WHERE barcode='$barcode'");
                                                        } 
                                                        while (mysqli_num_rows($query) == 1); 
                                                        
                                                    $sql_insert ="INSERT INTO orders (created_date,barcode,third_party,package,price,sender,receiver,status,proxy_id,owner,is_online) 
                                                        VALUES('".date("Y-m-d H:i:s")."','$barcode','$track','$package','$package_price','$sender','$receiver','$status','$proxy_id',1,1)";
                                                    //echo $sql_insert;
                                                        if (mysqli_query($conn,$sql_insert))
                                                        {
                                                            proxy_available($proxy_id,0,1);
                                                            //mysqli_query($conn,"UPDATE customer SET cent=cent+1 WHERE customer_id='$user_id'");

                                                            ?>
                                                            <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                                Амжилттай үүсгэлээ
                                                            </div>
                                                            <?
                                                        }
                                                        else 
                                                        {
                                                            ?>
                                                            <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                                <b><?=$error;?></b> Алдаа гарлаа: <?=mysqli_error($conn);?>
                                                            </div>
                                                            <?
                                                        }
                                                }
                                            }

                                            if (isset($_POST["container_trigger"]))
                                            {
                                                $track_eliminated = substr($track,-8,8);
                                                $sql = "SELECT * FROM container_item WHERE SUBSTRING(track,-8,8) = '$track_eliminated'";
                                                $result = mysqli_query($conn,$sql);
                                                if (mysqli_num_rows($result) > 1) 
                                                    echo "1-с олон track олдлоо. Та хайлтын утгаа ихэсгэж ахин оролдоно уу? <br>".anchor("welcome/track_search","Ахин оролдох",array("class"=>"btn btn-xs btn-primary"));
                                                if (mysqli_num_rows($result)  == 1)
                                                {
                                                    $data = mysqli_fetch_array($result);
                                                    $status = $data["status"];
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

                                                    if (mysqli_num_rows($result) == 0)  //Бүтргэлгүй
                                                        {
                                                            // $sql2 = "SELECT customer_id,password,name FROM customer WHERE tel='$contact' LIMIT 1";
                                                            
                                                            
                                                            $sender=0;
                                                            $receiver=$user_id;
                                                            
                                                            $package1_name=$_POST["package1_name"];
                                                            $package1_num =$_POST["package1_num"];
                                                            $package1_price =$_POST["package1_price"];
                                                            $package2_name=$_POST["package2_name"];
                                                            $package2_num =$_POST["package2_num"];
                                                            $package2_price =$_POST["package2_price"];
                                                            $package3_name=$_POST["package3_name"];
                                                            $package3_num =$_POST["package3_num"];
                                                            $package3_price =$_POST["package3_price"];
                                                            $package4_name=$_POST["package4_name"];
                                                            $package4_num =$_POST["package4_num"];
                                                            $package4_price =$_POST["package4_price"];
                                                            
                                                            $package_array = array(
                                                            $package1_name, $package1_num, $package1_price,
                                                            $package2_name, $package2_num, $package2_price,
                                                            $package3_name, $package3_num, $package3_price,
                                                            $package4_name, $package4_num, $package4_price
                                                            );
                                                            
                                                            $package =implode("##",$package_array);
                                                            $package_price = floatval($package1_price) + floatval($package2_price) + floatval($package3_price) + floatval($package4_price);
                                                            $transport = 0;
                                                            
                                                            $barcode='CO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
                                                            do {
                                                                    $barcode='CO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
                                                                    $query = mysqli_query($conn,"SELECT id FROM container_item WHERE barcode='$barcode'");
                                                                } 
                                                            while (mysqli_num_rows($query)== 1); 	
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
                                                                    '".$barcode."',
                                                                    '".$track."',
                                                                    '".$package."',
                                                                    '".$sender."',
                                                                    '".$receiver."',
                                                                    'weight_missing',
                                                                    1,
                                                                    1)";
                                                            if (mysqli_query($conn,$sql_insert))
                                                            {
                                                                ?>
                                                                <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                                    Амжилттай үүсгэлээ
                                                                </div>
                                                                <?
                                                            }
                                                            else 
                                                            {
                                                                ?>
                                                                <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                                    <b><?=$error;?></b> Алдаа гарлаа: <?=mysqli_error($conn);?>
                                                                </div>
                                                                <?
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
                                                    <?
                                                    $sql ="SELECT * from proxies WHERE customer_id='$user_id' AND status=0";
                                                    $result = mysqli_query($conn,$sql);
                                                    while ($data = mysqli_fetch_array($result))
                                                        {
                                                            ?>
                                                            <option value="<?=$data["proxy_id"];?>"> <?=$data["name"];?> - <?=$data["tel"];?></option>
                                                            <?
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
                        <?
                    }
                    else 
                    header("location:login");
                }
                ?>

                <?
                if ($action=="edit")
                {
                    $user_id = $_SESSION["c_user_id"];
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
                                    <?
                                    if (isset($_GET["id"]))
                                    {
                                        $order_id = $_GET["id"];
                                        $sql = "SELECT *FROM orders WHERE order_id='$order_id'";
                                        $result = mysqli_query($conn,$sql);
                                        if (mysqli_num_rows($result)==1)
                                        {
                                            $data = mysqli_fetch_array($result);
                                            $receiver = $data["receiver"];
                                            $third_party = $data["third_party"];
                                            $proxy_id_old = $data["proxy_id"];
                                            $proxy_id = $data["proxy_id"];
                                            $proxy_type = $data["proxy_type"];
                                            $package = $data["package"];
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
                                            if ($user_id==$receiver)
                                            {
                                                if (isset($_POST["order_id"]) && $_POST["order_id"]<>"")
                                                {
                                                    if (isset($_POST["proxy_trigger"]))
                                                    {
                                                        if (intval($_POST["proxies"])>0)
                                                        {
                                                            $proxy_id=$_POST["proxies"];
                                                        }
            
                                                        if (intval($_POST["proxies"])==0)
                                                        {
                                                            $proxy_name = $_POST["proxy_name"];
                                                            $proxy_surname = $_POST["proxy_surname"];
                                                            $proxy_tel = $_POST["proxy_tel"];
                                                            $proxy_address = mysqli_escape_string($conn,$_POST["address"]);
                                                            
                                                            $query_proxies =  mysqli_query($conn,'SELECT * FROM proxies WHERE customer_id="'.$user_id.'" AND tel="'.$proxy_tel.'"');
                                                            if (mysqli_num_rows($query_proxies)==1)
                                                                {
                                                                $row_proxy = mysqli_fetch_array($query_proxies);
                                                                $proxy_id = $row_proxy["proxy_id"];					
                                                                }
                                                            if (mysqli_num_rows($query_proxies)==0)	
                                                                {
                                                                mysqli_query($conn,'INSERT INTO proxies (customer_id,name,surname,tel,address,single) VALUES("'.$user_id.'","'.$proxy_name.'","'.$proxy_surname.'","'.$proxy_tel.'","'.$proxy_address.'",1)');
                                                                $proxy_id= mysqli_insert_id($conn); 	
                                                                }
                                                        }
                                                        
                                                    }
            
                                                
                                                       
                                                    $package1_name=mysqli_escape_string($conn,$_POST["package1_name"]);
                                                    $package1_num =$_POST["package1_num"];
                                                    $package1_price =$_POST["package1_price"];
                                                    $package2_name=mysqli_escape_string($conn,$_POST["package2_name"]);
                                                    $package2_num =$_POST["package2_num"];
                                                    $package2_price =$_POST["package2_price"];
                                                    $package3_name=mysqli_escape_string($conn,$_POST["package3_name"]);
                                                    $package3_num =$_POST["package3_num"];
                                                    $package3_price =$_POST["package3_price"];
                                                    $package4_name=mysqli_escape_string($conn,$_POST["package4_name"]);
                                                    $package4_num =$_POST["package4_num"];
                                                    $package4_price =$_POST["package4_price"];
                                                    
                                                    $package_array = array(
                                                    $package1_name, $package1_num, $package1_price,
                                                    $package2_name, $package2_num, $package2_price,
                                                    $package3_name, $package3_num, $package3_price,
                                                    $package4_name, $package4_num, $package4_price
                                                    );
                                                    
                                                    $package =implode("##",$package_array);
                                                    $package_price = floatval($package1_price) + floatval($package2_price) + floatval($package3_price) + floatval($package4_price);
                                                
                                                    $sql_update = "UPDATE orders SET price='$package_price',package='$package',proxy_id='$proxy_id',proxy_type='$proxy_type' WHERE order_id='$order_id'";
                                                    if (mysqli_query($conn,$sql_update)) 
                                                    {
                                                        if ($proxy_id_old<>$proxy_id)
                                                        {
                                                            proxy_available($proxy_id_old,$proxy_type,0);
                                                            proxy_available($proxy_id,$proxy_type,1);
                                                        }
                                                        ?>
                                                        <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                            Захиалга амжилттай засагдлаа
                                                        </div>
                                                        <?
                                                    }
                                                    else 
                                                    {
                                                        ?>
                                                        <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                            Алдаа. <?=mysqli_error($conn);?>
                                                        </div>
                                                        <?
                                                    }
                                                                
                                                                
            
                                                       
                                                    
                                                }
                                                
                                                ?>
                                                <form action="tracks?action=edit&id=<?=$order_id;?>"method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="order_id" value="<?=$order_id;?>">
                                                    <div class="form-group">
                                                        <label for="track">Трак</label>
                                                        <input type="text" class="form-control" value="<?=$third_party;?>" readonly>
                                                    </div>
                                                    <h5 class="card-title">Барааны тайлбар</h5>
                                                    <table class="table table-hover">
                                                        <tr>	
                                                            <td><input type="text" name="package1_name" value="<?=$package1_name;?>" class="form-control" placeholder="Цамц, Цүнх, Утас г.м" required></td>
                                                            <td><input type="text" name="package1_num" value="<?=$package1_num;?>" class="form-control" placeholder="Тоо ширхэг" required></td>
                                                            <td><input type="text" name="package1_price" value="<?=$package1_price;?>" class="form-control" placeholder="Үнэ ($)" required></td>
                                                        </tr>


                                                        <tr>	
                                                            <td><input type="text" name="package2_name" value="<?=$package2_name;?>" class="form-control" placeholder="Цамц, Цүнх, Утас г.м"></td>
                                                            <td><input type="text" name="package2_num" value="<?=$package2_num;?>" class="form-control" placeholder="Тоо ширхэг"></td>
                                                            <td><input type="text" name="package2_price" value="<?=$package2_price;?>" class="form-control" placeholder="Үнэ ($)"></td>
                                                        </tr>

                                                        <tr>	
                                                            <td><input type="text" name="package3_name" value="<?=$package3_name;?>" class="form-control" placeholder="Цамц, Цүнх, Утас г.м"></td>
                                                            <td><input type="text" name="package3_num" value="<?=$package3_num;?>" class="form-control" placeholder="Тоо ширхэг"></td>
                                                            <td><input type="text" name="package3_price" value="<?=$package3_price;?>" class="form-control" placeholder="Үнэ ($)"></td>
                                                        </tr>
                                                        
                                                        <tr>	
                                                            <td><input type="text" name="package4_name" value="<?=$package4_name;?>" class="form-control" placeholder="Цамц, Цүнх, Утас г.м"></td>
                                                            <td><input type="text" name="package4_num" value="<?=$package4_num;?>" class="form-control" placeholder="Тоо ширхэг"></td>
                                                            <td><input type="text" name="package4_price" value="<?=$package4_price;?>" class="form-control" placeholder="Үнэ ($)"></td>
                                                        </tr>
                                                    </table>
                                                    <!-- <div class="input-group">
                                                        <label for="container_trigger" class="mr-3"><b>Газраар /чингэлэг/ ирэх эсэх</b></label>
                                                        <label class="switch s-icons s-outline s-outline-primary">
                                                            <input type="checkbox" name="container_trigger" value="container" id="container_trigger">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div> -->

                                                    <div class="input-group">
                                                        <label for="proxy_trigger" class="mr-3"><b>Өөр хүн авах</b></label>
                                                        <label class="switch s-icons s-outline s-outline-primary">
                                                            <input type="checkbox" name="proxy_trigger" value="container" id="proxy_trigger" <?=($proxy_id>0)?'checked':'';?>>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <select name="proxies" id="proxies" class="form-control">
                                                        <?
                                                        $sql ="SELECT * from proxies WHERE customer_id='$user_id' AND (status=0 OR proxy_id='$proxy_id')";
                                                        $result = mysqli_query($conn,$sql);
                                                        while ($data = mysqli_fetch_array($result))
                                                            {
                                                                ?>
                                                                <option value="<?=$data["proxy_id"];?>" <?=($proxy_id==$data["proxy_id"])?'SELECTED="SELECTED"':'';?>> <?=$data["name"];?> - <?=$data["tel"];?></option>
                                                                <?
                                                            }
                                                            ?>
                                                        <option value="-1">Шинэ хүн оруулах</option>
                                                    </select>

                                                    <table class="table" id="proxy">
                                                        <tr></tr><td>Нэр(*)</td><td><input type="text" name="proxy_name" placeholder="Нэр" class="form-control"></td></tr>
                                                        <tr><td>Овог(*)</td><td><input type="text" name="proxy_surname" placeholder="Овог" class="form-control"></td></tr>
                                                        <tr><td>Утасны дугаар(*)</td><td><input type="text" name="proxy_tel" placeholder="Утасны дугаар" class="form-control"></td></tr>
                                                        <tr><td>Хаяг</td><td><textarea name="proxy_address" placeholder="Гэрийн хаяг" class="form-control"></textarea></td></tr>
                                                    </table>
                                                    
                                                    <input type="submit" class="btn btn-primary" value="Хадгалах">
                                                </form>
                                                <?
                                            }
                                            else 
                                            {
                                                ?>
                                                 <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                    Уучлаарай, таны ачаа биш байна.
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
                                                Ачааны дугаар олдсонгүй
                                            </div>
                                            <?
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <li class="breadcrumb-item active"><a href="tracks">Трак</a></li>
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
                                        $proxy=$data_order["proxy_id"];
                                        $proxy_type=$data_order["proxy_type"];
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
                                                <?=$barcode;?>
                                                <? 
                                                if ($proxy!=0) 
                                                {
                                                    ?>
                                                    <br>
                                                    <span class="badge outline-badge-success">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>                                   
                                                        <?=proxy($proxy,"name");?> 
                                                    </span>
                                                    <?
                                                }
                                                else 
                                                {
                                                    ?>
                                                    <br>
                                                    <span class="badge outline-badge-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>                                   
                                                        <?=customer($user_id,"name");?> 
                                                    </span>
                                                    <?
                                                }
                                                ?>
                                                <span class="badge badge-info badge-pills"> <?=$status;?> </span>
                                                
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
                                            Трак олдсонгүй
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
                                                    <p>Харилцагч авсан</p>
                                                    <p class="t-meta-time">7 өдөр</p>
                                                </div>
                                            </div>

                                            <div class="item-timeline">
                                                <p class="t-time"><?=substr($warehouse_date,0,10);?></p>
                                                <div class="t-dot t-dot-warning">
                                                </div>
                                                <div class="t-text">
                                                    <p>Монголд агуулахад бэлэн болсон</p>
                                                    <p class="t-meta-time">6 өдөр</p>
                                                </div>
                                            </div>

                                            <?
                                            if ($onair_date<>"")
                                            {
                                                ?>
                                                <div class="item-timeline">
                                                    <p class="t-time"><?=substr($onair_date,0,10);?></p>
                                                    <div class="t-dot t-dot-info">
                                                    </div>
                                                    <div class="t-text">
                                                        <p>Америкаас монголруу ниссэн</p>
                                                        <p class="t-meta-time">3 өдөр</p>
                                                    </div>
                                                </div>
                                                <?
                                            }

                                            
                                            if ($weight_date<>"")
                                            {
                                                ?>
                                                <div class="item-timeline">
                                                    <p class="t-time"><?=substr($weight_date,0,10);?></p>
                                                    <div class="t-dot t-dot-dark">
                                                    </div>
                                                    <div class="t-text">
                                                        <p>Нисэхэд бэлэн болсон</p>
                                                    </div>
                                                </div>
                                                <?
                                            }
                                            ?>

                                            <?
                                            if ($received_date<>"")
                                            {
                                                ?>
                                                <div class="item-timeline">
                                                    <p class="t-time"><?=substr($received_date,0,10);?></p>
                                                    <div class="t-dot t-dot-dark">
                                                    </div>
                                                    <div class="t-text">
                                                        <p>DE хүргэгдсэн</p>
                                                    </div>
                                                </div>
                                                <?
                                            }
                                            ?>
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
                if ($action=="delete")
                {
                    $user_id = $_SESSION["c_user_id"];
                    $order_id = $_GET["id"];
                    
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
                                    <?
                                    $sql = "SELECT *FROM orders WHERE order_id='$order_id' LIMIT 1";
                                    $result = mysqli_query($conn,$sql);
                                    if (mysqli_num_rows($result)==1)
                                    {
                                        $data_order = mysqlI_fetch_array($result);
                                        $receiver = $data_order["receiver"];
                                        $track = $data_order["third_party"];
                                        $proxy_id = $data_order["proxy_id"];
                                        $proxy_type = $data_order["proxy_type"];
                                        $status = $data_order["status"];
                                        if ($receiver==$user_id)
                                        {
                                            if ($status=='weight_missing')
                                            {
                                                $sql = "DELETE FROM orders WHERE order_id='$order_id' LIMIT 1";
                                                if (mysqli_query($conn,$sql))
                                                {
                                                    proxy_available($proxy_id,$proxy_type,0);
                                                    ?>
                                                    <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                        Амжилттай устгалаа.
                                                    </div>
                                                    <? 
                                                }
                                                else
                                                {
                                                    ?>
                                                    <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                        Устгахад алдаа гарлаа. <?=mysqli_error($conn);?>
                                                    </div>
                                                    <?
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

                                                <?
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

                                                <?
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
                                        <?
                                    }
                                    ?>

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