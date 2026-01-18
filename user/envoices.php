<?php require_once("config.php");?>
<?php require_once("views/helper.php");?>
<?php require_once("views/login_check.php");?>
<?php require_once("views/init.php");?>

<link href="assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="assets/css/elements/alert.css">
<link href="assets/css/elements/breadcrumb.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
<link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
<link href="assets/css/apps/invoice.css" rel="stylesheet" type="text/css" />


<body class="sidebar-noneoverflow">
    
    <?php require_once("views/navbar.php");?>



    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <?php require_once("views/sidebar.php");?>


        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <?php if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="modern"; ?>

                <?php
                if ($action=="modern")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $sql = "SELECT * FROM envoice WHERE customer_id=".$user_id." ORDER BY created_date DESC LIMIT 30";
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="envoices">Нэхэмжлэх</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Бүх нэхэмжлэх</a></li>
                        </ol>
                    </nav>

                    <div class="row invoice layout-top-spacing">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="app-hamburger-container">
                                <div class="hamburger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu chat-menu d-xl-none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></div>
                            </div>
                            <div class="doc-container">
                                <div class="tab-title open-inv-sidebar">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-12">
                                            <div class="search">
                                                <input type="text" class="form-control" placeholder="Search">
                                            </div>
                                            <ul class="nav nav-pills inv-list-container d-block" id="pills-tab" role="tablist">
                                                <?php
                                                $sql = "SELECT * FROM envoice WHERE customer_id='".mysqli_real_escape_string($conn, $user_id)."' ORDER BY created_date DESC";
                                                $result = mysqli_query($conn,$sql);
                                                if ($result) {
                                                    while ($data = mysqli_fetch_array($result))
                                                    {
                                                        $envoice_id = isset($data["envoice_id"]) ? intval($data["envoice_id"]) : 0;
                                                        $status = isset($data["status"]) ? htmlspecialchars($data["status"]) : '';
                                                        $orders = isset($data["orders"]) ? htmlspecialchars($data["orders"]) : '';
                                                        $amount = isset($data["amount"]) ? intval($data["amount"]) : 0;
                                                        $qpay_paid = isset($data["qpay_paid"]) ? htmlspecialchars($data["qpay_paid"]) : '';
                                                        $created_date = isset($data["created_date"]) ? htmlspecialchars($data["created_date"]) : '';
                                                        ?>
                                                         <li class="nav-item ">
                                                            <div class="nav-link list-actions <?php echo ($status=='paid')?'paid':''; ?>" id="invoice-<?php echo htmlspecialchars($envoice_id); ?>" data-invoice-id="<?php echo sprintf("%05d", $envoice_id); ?>">
                                                                <div class="f-m-body">
                                                                    <div class="f-head">
                                                                        <?php
                                                                        if ($status=='paid')
                                                                        echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>';
                                                                        else 
                                                                        echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>';
                                                                        ?>

                                                                    </div>
                                                                    <div class="f-body">
                                                                        <p class="invoice-number">Invoice #<?php echo sprintf("%05d", $envoice_id); ?></p>
                                                                        <p class="invoice-customer-name"><span>Ачааны тоо:</span> <?php echo substr_count($orders, ',') + 1; ?></p>
                                                                        <p class="invoice-customer-amount"><?php echo number_format($amount + 5000); ?>₮</p>
                                                                        <?php
                                                                        if ($status=='paid')
                                                                            {
                                                                                ?>
                                                                                <p class="invoice-generated-date">Төлөгдсөн: <?php echo !empty($qpay_paid) ? htmlspecialchars(substr($qpay_paid, 0, 10)) : ''; ?></p>
                                                                                <?php
                                                                            }
                                                                        else 
                                                                            {
                                                                                ?>
                                                                                <p class="invoice-generated-date">Үүсгэсэн: <?php echo !empty($created_date) ? htmlspecialchars(substr($created_date, 0, 10)) : ''; ?></p>
                                                                                <?php
                                                                            }
                                                                        
                                                                        ?>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="invoice-container">
                                    <div class="invoice-inbox">

                                        <div class="inv-not-selected">
                                            <p>Үүсгэсэн нэхэмжлэхээ <- сонгоно уу</p>
                                        </div>

                                        <div class="invoice-header-section">
                                            <h4 class="inv-number"></h4>
                                            <div class="invoice-action">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer action-print" data-toggle="tooltip" data-placement="top" data-original-title="Print"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                                            </div>
                                        </div>
                                        
                                        <div id="ct" class="">
                                            <?php
                                                $sql = "SELECT * FROM envoice WHERE customer_id='".mysqli_real_escape_string($conn, $user_id)."' ORDER BY created_date DESC";
                                                
                                                $result = mysqli_query($conn,$sql);
                                                if ($result) {
                                                    while ($data = mysqli_fetch_array($result))
                                                    {
                                                        $created_date = isset($data["created_date"]) ? htmlspecialchars($data["created_date"]) : '';
                                                        $orders_str = isset($data["orders"]) ? htmlspecialchars($data["orders"]) : '';
                                                        $orders = explode(",", $orders_str);
                                                        $amount = isset($data["amount"]) ? intval($data["amount"]) : 0;
                                                        $envoice_id = isset($data["envoice_id"]) ? intval($data["envoice_id"]) : 0;
                                                        $envoice_status = isset($data["status"]) ? htmlspecialchars($data["status"]) : '';
                                                   ?>
                                                    <div class="invoice-<?php echo htmlspecialchars($envoice_id ?? 0); ?>">
                                                        <div class="content-section  animated animatedFadeInUp fadeInUp">

                                                            <div class="row inv--head-section">

                                                                <div class="col-sm-6 col-12 mb-3 mt-1">
                                                                    <h3 class="in-heading">Нэхэмжлэх №<?php echo sprintf("%05d", $envoice_id ?? 0); ?></h3>
                                                                    <?php
                                                                        if ($envoice_status=='paid')
                                                                        echo '<span class="badge badge-pills badge-success">Төлөгдсөн</span>';
                                                                        else 
                                                                        {
                                                                            echo '<span class="badge badge-pills badge-danger">Төлөгдөөгүй</span>';
                                                                            echo '<a href="envoices?action=paying&id='.htmlspecialchars($envoice_id).'"><span class="badge badge-pills badge-primary">Төлөх</span></a>';
                                                                        }
                                                                    ?>
                                                                </div>
                                                               
                                                                <div class="col-sm-6 col-12 align-self-center text-sm-right">
                                                                    <div class="company-info">
                                                                        <img src="assets/images/logo.png">
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>

                                                            <div class="row inv--detail-section">

                                                                <div class="col-sm-7 align-self-center">
                                                                    <p class="inv-to">Хүлээн авагч</p>
                                                                </div>
                                                                <div class="col-sm-5 align-self-center  text-sm-right order-sm-0 order-1">
                                                                    <p class="inv-detail-title">Нэхэмжлэгч : SHUURKHAI INC CORP</p>
                                                                </div>
                                                                
                                                                <div class="col-sm-7 align-self-center">
                                                                    <p class="inv-customer-name"><?=customer($user_id,"full_name");?></p>
                                                                    <p class="inv-street-tel"><?=customer($user_id,"tel");?></p>
                                                                    <p class="inv-street-addr"><?=customer($user_id,"address");?></p>
                                                                    <p class="inv-email-address"><?=customer($user_id,"email");?></p>
                                                                </div>
                                                                <div class="col-sm-5 align-self-center  text-sm-right order-2">
                                                                    <p class="inv-list-number"><span class="inv-title">Нэхэмжлэх № : </span> <span class="inv-number">[invoice number]</span></p>
                                                                    <p class="inv-created-date"><span class="inv-title">Нэхэмжилсэн : </span> <span class="inv-date"><?=substr($created_date,0,10);?></span></p>
                                                                    <p class="inv-due-date"><span class="inv-title">Төлбөр төлөх : </span> <span class="inv-date"><?=substr($created_date,0,10);?></span></p>
                                                                </div>
                                                            </div>

                                                            <div class="row inv--product-table-section">
                                                                <div class="col-12">
                                                                    <div class="table-responsive">
                                                                        <table class="table">
                                                                            <thead class="">
                                                                                <tr>
                                                                                    <th scope="col">№</th>
                                                                                    <th scope="col">Barcode</th>
                                                                                    <th scope="col">Тайлбар</th>
                                                                                    <th class="text-right" scope="col">Жин /кг/</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php                                                                                 
                                                                                $N = count($orders);
                                                                                if ($N>0 || $orders!="")
                                                                                {	
                                                                                $total_weight=0;
                                                                                $count=1;
                                                                                for($i=0; $i < $N; $i++)
                                                                                {
                                                                                $order_id=$orders[$i];
                                                                                
                                                                                $sql_items = "SELECT * FROM orders WHERE receiver=".$user_id." AND order_id='".$order_id."'";
                                                                                
                                                                                $result_items  = mysqli_query($conn,$sql_items);
                                                                                
                                                                                if (mysqli_num_rows($result_items) ==1)
                                                                                {
                                                                                    $data_items = mysqli_fetch_array($result_items);
                                                                                    //$order_id=$data["order_id;
                                                                                    $weight=$data_items["weight"];
                                                                                    $barcode=$data_items["barcode"];
                                                                                    $package=$data_items["package"];
                                                                                   
                                                                                    
                                                                                    $package_array=explode("##",$package);
                                                                                    $package1_name = $package_array[0];
                                                                                    $package1_num = $package_array[1];
                                                                                    $package1_value = $package_array[2];
                                                                                    $package2_name = $package_array[3];
                                                                                    $package2_num = $package_array[4];
                                                                                    $package2_value = $package_array[5];
                                                                                    $package3_name = $package_array[6];
                                                                                    $package3_num = $package_array[7];
                                                                                    $package3_value = $package_array[8];
                                                                                    $package4_name = $package_array[9];
                                                                                    $package4_num = $package_array[10];
                                                                                    $package4_value = $package_array[11];
                                                                                        
                                                                                    
                                                                                    echo "<tr>";
                                                                                    echo "<td>".$count++."</td>";
                                                                                    echo "<td>".$barcode."</td>";
                                                                                    echo "<td>";
                                                                                    //if ($third_party!="")
                                                                                    //echo "<a href='".track($third_party)."' target='_blank' title='Хаана явна'>$third_party<span class='glyphicon glyphicon-globe'></span></a>";
                                                                                    if ($package1_name!="")
                                                                                    echo "$package1_name ($package1_num)";
                                                                                    if ($package2_name!="")
                                                                                    echo ",$package2_name ($package2_num)";
                                                                                    if ($package3_name!="")
                                                                                    echo ",$package3_name ($package3_num)";
                                                                                    if ($package4_name!="")
                                                                                    echo ",$package4_name ($package4_num)";
                                                                                    echo "</td>";
                                                                                    
                                                                                    echo "<td class='text-right'>".$weight."</td>";	
                                                                                    $total_weight+=$weight;
                                                                                    //echo "<td>";
                                                                                    //echo anchor("customer/orders_detail/".$order_id,"Дэлгэрэнгүй",array("class"=>"btn btn-xs btn-success"));
                                                                                
                                                                                    //if ($status=="weight_missing") echo anchor("customer/orders_deleting/".$online_id,"Устгах",array("class"=>"btn btn-xs btn-danger"));
                                                                                    //echo "</td>";
                                                                                    echo "</tr>";	
                                                                                    }
                                                                                }
                                                                                }
                                                                                ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-4">
                                                                <div class="col-sm-5 col-12 order-sm-0 order-1">
                                                                    <div class="inv--payment-info">
                                                                        <div class="row">
                                                                            <?php
                                                                                if ($envoice_status!='paid')
                                                                                {
                                                                                    ?>
                                                                                    <a href="envoices?action=paying&id=<?php echo htmlspecialchars($envoice_id ?? 0); ?>" class="btn btn-primary">Төлбөр төлөх</a>
                                                                                    <!-- <div class="col-sm-12 col-12">
                                                                                        <h6 class=" inv-title">Төлбөр төлөх:</h6>
                                                                                    </div>
                                                                                    <div class="col-sm-4 col-12">
                                                                                        <p class=" inv-subtitle">Банк: </p>
                                                                                    </div>
                                                                                    <div class="col-sm-8 col-12">
                                                                                        <p class="">Хаан банк</p>
                                                                                    </div>
                                                                                    <div class="col-sm-4 col-12">
                                                                                        <p class=" inv-subtitle">Данс дугаар : </p>
                                                                                    </div>
                                                                                    <div class="col-sm-8 col-12">
                                                                                        <p class="">5111104306</p>
                                                                                    </div>
                                                                                    <div class="col-sm-4 col-12">
                                                                                        <p class=" inv-subtitle">Данс нэр : </p>
                                                                                    </div>
                                                                                    <div class="col-sm-8 col-12">
                                                                                        <p class="">Хашбал /₮/</p>
                                                                                    </div> -->
                                                                                    <?php
                                                                                }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-7 col-12 order-sm-1 order-0">
                                                                    <div class="inv--total-amounts text-sm-right">
                                                                        <div class="row">
                                                                            <div class="col-sm-8 col-7">
                                                                                <p class="">Нийт жин (Кг): </p>
                                                                            </div>
                                                                            <div class="col-sm-4 col-5">
                                                                                <p class=""><?=$total_weight;?></p>
                                                                            </div>
                                                                            <div class="col-sm-8 col-7">
                                                                                <p class="">НӨАТ: </p>
                                                                            </div>
                                                                            <div class="col-sm-4 col-5">
                                                                                <p class="">0</p>
                                                                            </div>

                                                                         
                                                                            <div class="col-sm-8 col-7">
                                                                                <p class=" discount-rate">Тээвэр(₮):</p>
                                                                            </div>
                                                                            <div class="col-sm-4 col-5">
                                                                                <p class=""><?=number_format($amount);?>₮</p>
                                                                            </div>
                                                                           
                                                                            <div class="col-sm-8 col-7 grand-total-title">
                                                                                <h4 class="">Нийт төлбөр(₮) үүсгэсэн өдрийн ханшаар</h4>
                                                                            </div>
                                                                            <div class="col-sm-4 col-5 grand-total-amount">
                                                                                <h4 class=""><?=number_format($amount);?>₮</h4>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div> 
                                                     

                                                    <?php
                                                    }
                                                }
                                                ?>
                                        </div>


                                    </div>

                                    <div class="inv--thankYou">
                                        <div class="row">
                                            <div class="col-sm-12 col-12">
                                                <p class="">Хамтран ажилллагч харилцагч та бүхэнд баярлалаа.</p>
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
                if ($action=="unpaid")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $sql = "SELECT * FROM envoice WHERE customer_id=".$user_id." ORDER BY created_date DESC";
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="envoices">Нэхэмжлэх</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Хүлээгдэж буй</a></li>
                        </ol>
                    </nav>
                    
                    <?
                    require_once("views/envoices.php");?>                        
                    <?php
                }
                ?>

                <?php
                if ($action=="paid")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                    $sql = "SELECT * FROM envoice WHERE customer_id='".$user_id_escaped."' AND status='paid' ORDER BY created_date DESC";
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="envoices">Нэхэмжлэх</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Төлөгдсөн</a></li>
                        </ol>
                    </nav>
                    
                    <?php
                    require_once("views/envoices.php");?>                        
                    <?php
                }
                ?>

                <?php
                if ($action=="history")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $sql = "SELECT * FROM orders WHERE receiver=".$user_id." AND status IN ('delivered','custom') AND created_date>'2015-09-01' ORDER BY created_date DESC";
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="envoices">Нэхэмжлэх</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Түүх</a></li>
                        </ol>
                    </nav>
                    
                    <?
                    require_once("views/tracks.php");?>                        
                    <?php
                }
                ?>

                <?php
                if ($action=="create")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="envoices">Нэхэмжлэх</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Ачааг сонгож үүсгэх</a></li>
                        </ol>
                    </nav>
                    


                    <div class="row layout-spacing">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Нэхэмжлэх үүсгэх</h5>

                                    <?php
                                    $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                                    $result = mysqli_query($conn,"SELECT * FROM orders WHERE receiver=".$user_id_escaped." AND status IN('warehouse','custom')");
                    
                                    if ($result && mysqli_num_rows($result) >0)
                                    {
                                        ?>
                                        <form action="envoices?action=creating" method="post">
                                        <p>Нэхэмжлэх үүсгэх ачаагаа сонгон 
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                                        тэмдэглэнэ үү.</p>
                                        <span class="text-danger">DELAWARE <span class="badge outline-badge-dark">DE</span>-руу захиалсан ачааны нэхэмжлэхийг тусд нь гаргаж авна уу.</span>
                                        <!-- <input type="submit" value="Хэвлэх" class="btn btn-warning  btn-sm" style="float:right;margin-bottom:10px"> -->
                                        <div class="table-responsive">
                                            <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th><input type="checkbox" name="select_all" id="select_all" title="Select all orders" checked="checked"></th>
                                                            <th>№</th>
                                                            <th>Огноо</th>
                                                            <th>Төлөв</th>
                                                            <th>Трак</th>
                                                            <th>Жин</th>
                                                            <th>Баркод</th>
                                                        </tr>                                
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        
                                                        $i = $result ? mysqli_num_rows($result) : 0;
                                                        if ($result) {
                                                            while ($data = mysqli_fetch_array($result))
                                                        {  
                                                            $order_id = isset($data["order_id"]) ? intval($data["order_id"]) : 0;
                                                            $weight = isset($data["weight"]) ? htmlspecialchars($data["weight"]) : '';
                                                            $price = isset($data["price"]) ? htmlspecialchars($data["price"]) : '';
                                                            
                                                            $created_date = isset($data["created_date"]) ? htmlspecialchars($data["created_date"]) : '';
                                                            // $onair_date=$data["onair_date"];
                                                            // $warehouse_date=$data["warehouse_date"];
                                                            // $delivered_date=$data["delivered_date"];
                                                            
                                                            $barcode = isset($data["barcode"]) ? htmlspecialchars($data["barcode"]) : '';
                                                            $package = isset($data["package"]) ? htmlspecialchars($data["package"]) : '';
                                                            $status = isset($data["status"]) ? htmlspecialchars($data["status"]) : '';
                                                            $third_party = isset($data["third_party"]) ? htmlspecialchars($data["third_party"]) : '';
                                                            $is_branch = isset($data["is_branch"]) ? intval($data["is_branch"]) : 0;
                                                            
                                                            $package1_name = '';
                                                            $package1_num = '';
                                                            $package2_name = '';
                                                            $package2_num = '';
                                                            $package3_name = '';
                                                            $package3_num = '';
                                                            $package4_name = '';
                                                            $package4_num = '';
                                                            
                                                            if (!empty($package)) {
                                                                $package_array = explode("##", $package);
                                                                if (count($package_array) > 11) {
                                                                    $package1_name = isset($package_array[0]) ? htmlspecialchars($package_array[0]) : '';
                                                                    $package1_num = isset($package_array[1]) ? htmlspecialchars($package_array[1]) : '';
                                                                    $package1_value = isset($package_array[2]) ? htmlspecialchars($package_array[2]) : '';
                                                                    $package2_name = isset($package_array[3]) ? htmlspecialchars($package_array[3]) : '';
                                                                    $package2_num = isset($package_array[4]) ? htmlspecialchars($package_array[4]) : '';
                                                                    $package2_value = isset($package_array[5]) ? htmlspecialchars($package_array[5]) : '';
                                                                    $package3_name = isset($package_array[6]) ? htmlspecialchars($package_array[6]) : '';
                                                                    $package3_num = isset($package_array[7]) ? htmlspecialchars($package_array[7]) : '';
                                                                    $package3_value = isset($package_array[8]) ? htmlspecialchars($package_array[8]) : '';
                                                                    $package4_name = isset($package_array[9]) ? htmlspecialchars($package_array[9]) : '';
                                                                    $package4_num = isset($package_array[10]) ? htmlspecialchars($package_array[10]) : '';
                                                                    $package4_value = isset($package_array[11]) ? htmlspecialchars($package_array[11]) : '';
                                                                }
                                                            }
                                                                
                                                            ?>

                                                            <tr>
                                                                <td>
                                                                    <input type="checkbox" name="orders[]" value="<?php echo htmlspecialchars($order_id ?? 0); ?>" checked="checked">
                                                                    <?php                                                                
                                                                    if ($is_branch) 
                                                                    {
                                                                        
                                                                        ?>
                                                                        <span class="badge outline-badge-dark">DE</span>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td><?php echo htmlspecialchars($i-- ?? 0); ?></td>
                                                                <td><?php echo !empty($created_date) ? htmlspecialchars(substr($created_date, 0, 10)) : ''; ?></td>
                                                                <td><span class="badge badge-info badge-pills"><?php echo htmlspecialchars($status ?? ''); ?></span></td>
                                                                <td>
                                                                <a href="<?php echo htmlspecialchars(track($third_party ?? '') ?? ''); ?>" target="_blank" title="Хаана явна"><?php echo htmlspecialchars($third_party ?? ''); ?></a>
                                                                <?php
                                                                if (!empty($package1_name))
                                                                echo "<br>" . htmlspecialchars($package1_name) . " (" . htmlspecialchars($package1_num) . ")";
                                                                if (!empty($package2_name))
                                                                echo "<br>" . htmlspecialchars($package2_name) . " (" . htmlspecialchars($package2_num) . ")";
                                                                if (!empty($package3_name))
                                                                echo "<br>" . htmlspecialchars($package3_name) . " (" . htmlspecialchars($package3_num) . ")";
                                                                if (!empty($package4_name))
                                                                echo "<br>" . htmlspecialchars($package4_name) . " (" . htmlspecialchars($package4_num) . ")";
                                                                ?>
                                                                </td>
                                                                <td><h5><?php echo htmlspecialchars($weight ?? ''); ?></h5></td>
                                                                <td><?php echo htmlspecialchars($barcode ?? ''); ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        }
                                                        ?>
                                                    </tbody>
                                            </table>
                                        </div>
                                        <input type="submit" value="Үүсгэх" class="btn btn-success mt-3"> 
                                        <?php

                                    }
                                    else //$query->num_rows() ==0
                                    {
                                    echo '<div class="alert alert-danger" role="alert">Захиалга олдсонгүй.</div>';
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
                if ($action=="creating")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="envoices">Нэхэмжлэх</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Үүссэн нэхэмжлэх</a></li>
                        </ol>
                    </nav>
                    


                    <div class="row layout-spacing">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Нэхэмжлэх үүсгэх</h5>
                                    <?php
                                        if (isset($_POST["orders"]))
                                        {
                                            $orders = isset($_POST['orders']) ? $_POST['orders'] : array();
                                            $N = count($orders);
                                            $orders_string = '';
                                            if (is_array($orders) && $N > 0) {
                                                $orders_escaped = array();
                                                foreach ($orders as $order) {
                                                    $orders_escaped[] = mysqli_real_escape_string($conn, $order);
                                                }
                                                $orders_string = implode(",", $orders_escaped);
                                            }
                                            
                                            $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                                            $sql = "SELECT * FROM envoice WHERE orders = '".$orders_string."'";
                                            $result = mysqli_query($conn,$sql);
                                            if ($result && mysqli_num_rows($result)==0)
                                            {
                                                $sql = "INSERT INTO envoice (customer_id,orders) VALUES('".$user_id_escaped."','".$orders_string."')";
                                                if (mysqli_query($conn,$sql)) {
                                                    $envoice_id = mysqli_insert_id($conn);
                                                } else {
                                                    $envoice_id = 0;
                                                }
                                            }
                                            else 
                                            {
                                                if ($result) {
                                                    $data = mysqli_fetch_array($result);
                                                    $envoice_id = isset($data["envoice_id"]) ? intval($data["envoice_id"]) : 0;
                                                } else {
                                                    $envoice_id = 0;
                                                }
                                            }
                                            
                                            if ($N>0 && !empty($orders_string))
                                            {	
                                                $total_weight=0;
                                                $total_weight_branch=0;
                                                $total_amount = 0;
                                                $count=1;
                                                for($i=0; $i < $N; $i++)
                                                {
                                                    $order_id = isset($orders[$i]) ? mysqli_real_escape_string($conn, $orders[$i]) : '';
                                                    if (!empty($order_id)) {
                                                        $sql = "SELECT * FROM orders WHERE receiver=".$user_id_escaped." AND order_id='".$order_id."'";
                                                        
                                                        $result = mysqli_query($conn,$sql);
                                                        
                                                        if ($result && mysqli_num_rows($result) ==1)
                                                        {
                                                            $data = mysqli_fetch_array($result);
                                                            $weight = isset($data["weight"]) ? floatval($data["weight"]) : 0;
                                                            $is_branch = isset($data["is_branch"]) ? intval($data["is_branch"]) : 0;
                                                            if ($is_branch) {
                                                                $total_weight_branch += $weight;
                                                            } else {
                                                                $total_weight += $weight;
                                                            }
                                                        }
                                                    }
                                                }

                                                
                                                $amount = cfg_price($total_weight) * settings("rate");
                                                $amount += cfg_price_branch($total_weight_branch) * settings("rate");
                                                $total_weight += $total_weight_branch;
                                                $envoice_id_escaped = mysqli_real_escape_string($conn, $envoice_id);
                                                $sql = "UPDATE envoice SET weight='".$total_weight."',amount='".$amount."' WHERE envoice_id='".$envoice_id_escaped."'";
                                                
                                                if (mysqli_query($conn,$sql))
                                                {
                                                    ?>
                                                    <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                        Амжилттай үүсгэлээ 
                                                        
                                                    </div>
                                                    <a href="envoices?action=detail&id=<?php echo htmlspecialchars($envoice_id ?? 0); ?>" target="_blank" class="btn btn-secondary">хэвлэх</a>
                                                    <a href="envoices?action=paying&id=<?php echo htmlspecialchars($envoice_id ?? 0); ?>" target="_blank" class="btn btn-success">Төлбөр төлөх</a>
                                                    <?php
                                                }
                                                else 
                                                {
                                                    ?>
                                                    <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                        <b><?php echo htmlspecialchars($error ?? ''); ?></b> Алдаа гарлаа: <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error'; ?>
                                                    </div>
                                                    <?php
                                                }

                                            }
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
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $envoice_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
                    
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="envoices">Нэхэмжлэх</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Дэлгэрэнгүй</a></li>
                        </ol>
                    </nav>

                    <div class="row layout-spacing">
                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 layout-top-spacing">
                            <div class="card">
                                <div class="card-body" id="ct">
                                
                                    <?php
                                    $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                                    $envoice_id_escaped = mysqli_real_escape_string($conn, $envoice_id);
                                    $sql = "SELECT * FROM envoice WHERE customer_id=".$user_id_escaped." AND envoice_id='".$envoice_id_escaped."' LIMIT 1";
                                    $result = mysqli_query($conn,$sql);
                                    if ($result && mysqli_num_rows($result)==1)
                                    {
                                        $data = mysqli_fetch_array($result);
                                        $orders = isset($data["orders"]) ? explode(",", $data["orders"]) : array();
                                        $amount = isset($data["amount"]) ? intval($data["amount"]) : 0;
                                        $created_date = isset($data["created_date"]) ? htmlspecialchars($data["created_date"]) : '';
                                        $envoice_status = isset($data["status"]) ? htmlspecialchars($data["status"]) : '';
                                        ?>
                                        <div class="invoice-<?php echo htmlspecialchars($envoice_id ?? 0); ?>">
                                            <div class="content-section  animated animatedFadeInUp fadeInUp">

                                                <div class="row inv--head-section">

                                                    <div class="col-sm-6 col-12">
                                                        <h3 class="in-heading">Нэхэмжлэх №<?php echo sprintf("%05d", $envoice_id ?? 0); ?></h3>
                                                        <?php
                                                            if ($envoice_status=='paid')
                                                            echo '<span class="badge badge-pills badge-success">Төлөгдсөн</span>';
                                                            else 
                                                            {
                                                                echo '<span class="badge badge-pills badge-danger">Төлөгдөөгүй</span>';
                                                                echo '<a href="envoices?action=paying&id='.htmlspecialchars($envoice_id).'"><span class="badge badge-pills badge-primary">Төлөх</span></a>';

                                                            }
                                                        ?>
                                                    </div>

                                                    <div class="col-sm-6 col-12 align-self-center text-sm-right">
                                                        <div class="company-info">
                                                            <img src="assets/images/logo.png">
                                                        </div>
                                                    </div>
                                                    
                                                </div>

                                                <div class="row inv--detail-section">

                                                    <div class="col-sm-7 align-self-center">
                                                        <p class="inv-to">Хүлээн авагч</p>
                                                    </div>
                                                    <div class="col-sm-5 align-self-center  text-sm-right order-sm-0 order-1">
                                                        <p class="inv-detail-title">Нэхэмжлэгч : SHUURKHAI INC CORP</p>
                                                    </div>
                                                    
                                                    <div class="col-sm-7 align-self-center">
                                                        <p class="inv-customer-name"><?=customer($user_id,"full_name");?></p>
                                                        <p class="inv-street-tel"><?=customer($user_id,"tel");?></p>
                                                        <p class="inv-street-addr"><?=customer($user_id,"address");?></p>
                                                        <p class="inv-email-address"><?=customer($user_id,"email");?></p>
                                                    </div>
                                                    <div class="col-sm-5 align-self-center  text-sm-right order-2">
                                                        <p class="inv-list-number"><span class="inv-title">Нэхэмжлэх № : </span> <span class="inv-number"><?=sprintf("%05d", $envoice_id);?></span></p>
                                                        <p class="inv-created-date"><span class="inv-title">Нэхэмжилсэн : </span> <span class="inv-date"><?=substr($created_date,0,10);?></span></p>
                                                        <p class="inv-due-date"><span class="inv-title">Төлбөр төлөх : </span> <span class="inv-date"><?=substr($created_date,0,10);?></span></p>
                                                    </div>
                                                </div>

                                                <div class="row inv--product-table-section">
                                                    <div class="col-12">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead class="">
                                                                    <tr>
                                                                        <th scope="col">№</th>
                                                                        <th scope="col">Barcode</th>
                                                                        <th scope="col">Тайлбар</th>
                                                                        <th class="text-right" scope="col">Жин /кг/</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php                                                                                 
                                                                    $N = count($orders);
                                                                    if ($N>0 || $orders!="")
                                                                    {	
                                                                    $total_weight=0;
                                                                    $count=1;
                                                                    for($i=0; $i < $N; $i++)
                                                                    {
                                                                    $order_id = isset($orders[$i]) ? htmlspecialchars($orders[$i]) : '';
                                                                    if (!empty($order_id)) {
                                                                        $order_id_escaped = mysqli_real_escape_string($conn, $order_id);
                                                                        $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                                                                        $sql_items = "SELECT * FROM orders WHERE receiver=".$user_id_escaped." AND order_id='".$order_id_escaped."'";
                                                                        
                                                                        $result_items = mysqli_query($conn,$sql_items);
                                                                        
                                                                        if ($result_items && mysqli_num_rows($result_items) ==1)
                                                                        {
                                                                            $data_items = mysqli_fetch_array($result_items);
                                                                            $weight = isset($data_items["weight"]) ? htmlspecialchars($data_items["weight"]) : '';
                                                                            $barcode = isset($data_items["barcode"]) ? htmlspecialchars($data_items["barcode"]) : '';
                                                                            $package = isset($data_items["package"]) ? htmlspecialchars($data_items["package"]) : '';
                                                                            
                                                                            $package1_name = '';
                                                                            $package1_num = '';
                                                                            $package2_name = '';
                                                                            $package2_num = '';
                                                                            $package3_name = '';
                                                                            $package3_num = '';
                                                                            $package4_name = '';
                                                                            $package4_num = '';
                                                                            
                                                                            if (!empty($package)) {
                                                                                $package_array = explode("##", $package);
                                                                                if (count($package_array) > 11) {
                                                                                    $package1_name = isset($package_array[0]) ? htmlspecialchars($package_array[0]) : '';
                                                                                    $package1_num = isset($package_array[1]) ? htmlspecialchars($package_array[1]) : '';
                                                                                    $package1_value = isset($package_array[2]) ? htmlspecialchars($package_array[2]) : '';
                                                                                    $package2_name = isset($package_array[3]) ? htmlspecialchars($package_array[3]) : '';
                                                                                    $package2_num = isset($package_array[4]) ? htmlspecialchars($package_array[4]) : '';
                                                                                    $package2_value = isset($package_array[5]) ? htmlspecialchars($package_array[5]) : '';
                                                                                    $package3_name = isset($package_array[6]) ? htmlspecialchars($package_array[6]) : '';
                                                                                    $package3_num = isset($package_array[7]) ? htmlspecialchars($package_array[7]) : '';
                                                                                    $package3_value = isset($package_array[8]) ? htmlspecialchars($package_array[8]) : '';
                                                                                    $package4_name = isset($package_array[9]) ? htmlspecialchars($package_array[9]) : '';
                                                                                    $package4_num = isset($package_array[10]) ? htmlspecialchars($package_array[10]) : '';
                                                                                    $package4_value = isset($package_array[11]) ? htmlspecialchars($package_array[11]) : '';
                                                                                }
                                                                            }
                                                                                
                                                                            echo "<tr>";
                                                                            echo "<td>".$count++."</td>";
                                                                            echo "<td>".htmlspecialchars($barcode)."</td>";
                                                                            echo "<td>";
                                                                            //if ($third_party!="")
                                                                            //echo "<a href='".track($third_party)."' target='_blank' title='Хаана явна'>$third_party<span class='glyphicon glyphicon-globe'></span></a>";
                                                                            if (!empty($package1_name))
                                                                            echo htmlspecialchars($package1_name) . " (" . htmlspecialchars($package1_num) . ")";
                                                                            if (!empty($package2_name))
                                                                            echo "," . htmlspecialchars($package2_name) . " (" . htmlspecialchars($package2_num) . ")";
                                                                            if (!empty($package3_name))
                                                                            echo "," . htmlspecialchars($package3_name) . " (" . htmlspecialchars($package3_num) . ")";
                                                                            if (!empty($package4_name))
                                                                            echo "," . htmlspecialchars($package4_name) . " (" . htmlspecialchars($package4_num) . ")";
                                                                            echo "</td>";
                                                                            
                                                                            echo "<td class='text-right'>".htmlspecialchars($weight)."</td>";	
                                                                            if (!empty($weight)) {
                                                                                $total_weight += floatval($weight);
                                                                            }
                                                                            //echo "<td>";
                                                                            //echo anchor("customer/orders_detail/".$order_id,"Дэлгэрэнгүй",array("class"=>"btn btn-xs btn-success"));
                                                                        
                                                                            //if ($status=="weight_missing") echo anchor("customer/orders_deleting/".$online_id,"Устгах",array("class"=>"btn btn-xs btn-danger"));
                                                                            //echo "</td>";
                                                                            echo "</tr>";	
                                                                        }
                                                                    }
                                                                    }
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-sm-5 col-12 order-sm-0 order-1">
                                                        <div class="inv--payment-info">
                                                            <div class="row">
                                                                <?php
                                                                    if ($envoice_status!='paid')
                                                                    {
                                                                        ?>
                                                                        <div class="col-sm-12 col-12">
                                                                            <h6 class=" inv-title">Төлбөр төлөх:</h6>
                                                                        </div>
                                                                        <div class="col-sm-4 col-12">
                                                                            <p class=" inv-subtitle">Банк: </p>
                                                                        </div>
                                                                        <div class="col-sm-8 col-12">
                                                                            <p class="">Хаан банк</p>
                                                                        </div>
                                                                        <div class="col-sm-4 col-12">
                                                                            <p class=" inv-subtitle">Дансны дугаар : </p>
                                                                        </div>
                                                                        <div class="col-sm-8 col-12">
                                                                            <p class="">5111104306</p>
                                                                        </div>
                                                                        <div class="col-sm-4 col-12">
                                                                            <p class=" inv-subtitle">Дансны нэр : </p>
                                                                        </div>
                                                                        <div class="col-sm-8 col-12">
                                                                            <p class="">Хашбал /₮/</p>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                ?>
                                                                
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-7 col-12 order-sm-1 order-0">
                                                        <div class="inv--total-amounts text-sm-right">
                                                            <div class="row">
                                                                <div class="col-sm-8 col-7">
                                                                    <p class="">Нийт жин (Кг): </p>
                                                                </div>
                                                                <div class="col-sm-4 col-5">
                                                                    <p class=""><?=$total_weight;?></p>
                                                                </div>
                                                                <div class="col-sm-8 col-7">
                                                                    <p class="">НӨАТ: </p>
                                                                </div>
                                                                <div class="col-sm-4 col-5">
                                                                    <p class="">0</p>
                                                                </div>

                                                             
                                                                <div class="col-sm-8 col-7">
                                                                    <p class=" discount-rate">Тээвэр(₮):</p>
                                                                </div>
                                                                <div class="col-sm-4 col-5">
                                                                    <p class=""><?=number_format($amount);?>₮</p>
                                                                </div>
                                                               
                                                                <div class="col-sm-8 col-7">
                                                                    <h6 class="inv-title">Нийт төлбөр(₮) үүсгэсэн өдрийн ханшаар</h6>
                                                                </div>
                                                                <div class="col-sm-4 col-5 ">
                                                                    <h6 class="inv-title"><?=number_format($amount);?>₮</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        
                                          <!-- <a class="btn btn-lg btn-warning" class="action-print">Хэвлэх</a> -->
                                          <!-- <a onClick="window.close()" class="btn btn-lg btn-danger">Гарах</a> -->
                                          <?php
                                            
                                        
                                
                                    }
                                    else 
                                    {
                                        ?>
                                         <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                            Нэхэмжлэх олдсонгүй
                                        </div>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>

                            <a class="action-print" style="cursor:pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer action-print" data-toggle="tooltip" data-placement="top" data-original-title="Print"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                                <b>Хэвлэх</b>
                            </a>

                        </div>
                       
                    </div>

                    

                    <?php
                }
                ?>


                <?php
                if ($action=="paying")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $envoice_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
                    
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="envoices">Нэхэмжлэх</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Дэлгэрэнгүй</a></li>
                        </ol>
                    </nav>

                    <div class="row layout-spacing">
                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 layout-top-spacing">
                            <div class="card">
                                <div class="card-body" id="ct">
                                
                                    <?php
                                    $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                                    $envoice_id_escaped = mysqli_real_escape_string($conn, $envoice_id);
                                    $sql = "SELECT * FROM envoice WHERE customer_id=".$user_id_escaped." AND envoice_id='".$envoice_id_escaped."' LIMIT 1";
                                    $result = mysqli_query($conn,$sql);
                                    if ($result && mysqli_num_rows($result)==1)
                                    {
                                        $data = mysqli_fetch_array($result);
                                        $orders = isset($data["orders"]) ? explode(",", $data["orders"]) : array();
                                        $amount = isset($data["amount"]) ? intval($data["amount"])+5000 : 0;
                                        $created_date = isset($data["created_date"]) ? htmlspecialchars($data["created_date"]) : '';
                                        $envoice_status = isset($data["status"]) ? htmlspecialchars($data["status"]) : '';
                                        if ($envoice_status<>'paid')
                                        {
                                            $local_invoice_id = $envoice_id;

                                            $host = "https://merchant-sandbox.qpay.mn"; //test
                                            $host = "https://merchant.qpay.mn"; //production
                                            
                                            $url = $host."/v2/auth/token";

                                            //test
                                            $username = "TEST_MERCHANT";
                                            $password = "123456";

                                            //production
                                            $username = "SHUURKHAI";
                                            $password = "eBor20wN";

                                            $ch = curl_init();

                                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                            curl_setopt($ch, CURLOPT_URL,$url);
                                            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
                                            curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
                                            curl_setopt($ch, CURLOPT_POST, 1);
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                                            $result = curl_exec($ch);
                                            $result_decode = json_decode($result);


                                            curl_close($ch);  
                                            $access_token = $result_decode->access_token;

                                            $url = $host."/v2/invoice";
                                            $authorization = "Authorization: Bearer $access_token";
                                            
                                            $post_data['invoice_code'] = "TEST_INVOICE"; //TEST
                                            $post_data['invoice_code'] = "SHUURKHAI_INVOICE"; //PRODUCTION

                                            $post_data['sender_invoice_no'] = strval($local_invoice_id);
                                            $post_data['invoice_receiver_code'] = "terminal";
                                            $post_data['invoice_description'] = "Shuurkhai.com нэхэмжлэх дугаар:$local_invoice_id төлөх";
                                            $post_data['amount'] = $amount;
                                            $post_data['callback_url'] = "https://www.shuurkhai.com/qpay?user_id=$user_id&payment_id=".$local_invoice_id;

                                            $ch = curl_init();
                                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
                                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                            curl_setopt($ch, CURLOPT_URL,$url);
                                            curl_setopt($ch, CURLOPT_POST, 1);
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));

                                            $result = curl_exec($ch);
                                            $result_decode = json_decode($result);
                                            curl_close($ch); 
                                            
                                            $qpay_invoice_id =  $result_decode->invoice_id; 
                                            $qr_text =  $result_decode->qr_text; 
                                            $qr_image =  $result_decode->qr_image; 
                                            $qPay_shortUrl =  $result_decode->qPay_shortUrl; 
                                            $urls =  $result_decode->urls; 
                                            $sql = "UPDATE envoice SET qpay_id='$qpay_invoice_id',qpay_created='".date("Y-m-d H:i:s")."' WHERE customer_id='$user_id' AND envoice_id='$local_invoice_id'";
                                            mysqli_query($conn,$sql);
                                            //echo $result;
                                            ?>
                                            <h4>QPay-р төлбөр төлөх</h4>
                                            <h5><?=number_format($amount);?>₮</h5>
                                            <img src='data:image/png;base64, <?=$qr_image;?>' class='d-block'>
                                            <!-- <a href="<?//$qPay_shortUrl;?>" class="btn btn-success" target="new">Банкны апп дуудах</a><br> -->
                                            <span id="timer"></span>
                                            <hr>
                                            <h4>Банкны апп-р төлөх</h4>
                                            <ul class="banks">
                                                <?php
                                                $count = 0;
                                                if (isset($urls) && is_array($urls)) {
                                                    foreach ($urls as $url)
                                                    {
                                                        $count++;
                                                        if ($count<6)
                                                        {
                                                            $bank = (array) $url;
                                                            ?>
                                                            <li>
                                                                <a href="<?php echo htmlspecialchars($bank["link"] ?? ''); ?>" target="new">
                                                                    <img src="<?php echo htmlspecialchars($bank["logo"] ?? ''); ?>">
                                                                </a>
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </ul>
                                            
                                            <script>
                                                function checklength(i) {
                                                    'use strict';
                                                    if (i < 10) {
                                                        i = "0" + i;
                                                    }
                                                    return i;
                                                }

                                                var minutes, seconds, count, counter, timer;
                                                count = 61; //seconds
                                                counter = setInterval(timer, 1000);

                                                function timer() {
                                                    'use strict';
                                                    count = count - 1;
                                                    minutes = checklength(Math.floor(count / 60));
                                                    seconds = checklength(count - minutes * 60);
                                                    if (count < 0) {
                                                        clearInterval(counter);
                                                        return;
                                                    }
                                                    document.getElementById("timer").innerHTML = 'Хуудас ахин ачаалах ' + minutes + ':' + seconds + ' ';
                                                    if (count === 0) {
                                                        location.reload();
                                                    }
                                                }
                                            </script>

                                            <!-- <h4>Банкны дансаар төлбөр төлөх</h4>
                                            <div class="col-sm-4 col-12">
                                                <p class=" inv-subtitle">Дансны дугаар : </p>
                                            </div>
                                            <div class="col-sm-8 col-12">
                                                <p class="">5111104306</p>
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <p class=" inv-subtitle">Дансны нэр : </p>
                                            </div>
                                            <div class="col-sm-8 col-12">
                                                <p class="">Хашбал /₮/</p>
                                            </div> -->
                                            <?php
                                        }
                                        else 
                                        {
                                            ?>
                                            <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                Нэхэмжлэх төлөгдсөн
                                            </div>
                                            <?php
                                        }
                                        

                                    }
                                    else 
                                    {
                                        ?>
                                        
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
    <script src="assets/js/app.js"></script>

    <script>
        $(document).ready(function() {
            App.init();
            //alert("asdsad");
            //$("#district").chained("#city");
            $('input[name="select_all"]').change(function(e) {
               if(this.checked) { 
                    $('input[name="orders[]"]').each(function() {
                        this.checked = true;            
                    });
                }else{
                    $('input[name="orders[]"]').each(function() {
                        this.checked = false; 
                    });        
                }
            });
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

    <script src="assets/js/apps/invoice.js"></script>
</body>
</html>