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


<body class="sidebar-noneoverflow">
    
    <?php require_once("views/navbar.php");?>



    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <?php require_once("views/sidebar.php");?>


        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <?php if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="mine"; ?>
                
                <?php
                if ($action=="mine")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                    $sql = "SELECT * FROM online WHERE (customer_id='".$user_id_escaped."' OR receiver='".$user_id_escaped."') AND status NOT IN ('order','later','pending') ORDER BY created_date DESC";			
                   // echo $sql;
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="online">Онлайн захиалга</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Миний захиалууд</a></li>
                        </ol>
                    </nav>
                    
                    <?php
                    require_once("views/online.php");?>                        
                    <?php
                }
                ?>


                <?php
                if ($action=="pending")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                    $sql = "SELECT * FROM online WHERE (customer_id='".$user_id_escaped."' OR receiver='".$user_id_escaped."') AND status ='pending' ORDER BY created_date DESC";			
                   // echo $sql;
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="online">Онлайн захиалга</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Хүлээгдэж буй</a></li>
                        </ol>
                    </nav>
                    
                    <?php
                    require_once("views/online.php");?>                        
                    <?php
                }
                ?>

                <?php
                if ($action=="ordered")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                    $sql = "SELECT * FROM online WHERE (customer_id='".$user_id_escaped."' OR receiver='".$user_id_escaped."') AND status ='order' ORDER BY created_date DESC";
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="online">Онлайн захиалга</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Захиалга хийгдсэн</a></li>
                        </ol>
                    </nav>
                    
                    <?php
                    require_once("views/online.php");?>                        
                    <?php
                }
                ?>


                <?php
                if ($action=="postponed")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                    $sql = "SELECT * FROM online WHERE (customer_id='".$user_id_escaped."' OR receiver='".$user_id_escaped."') AND status ='later' ORDER BY created_date DESC";
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="online">Онлайн захиалга</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Хойшлуулсан</a></li>
                        </ol>
                    </nav>
                    
                    <?php
                    require_once("views/online.php");?>                        
                    <?php
                }
                ?>

                <?php
                if ($action=="history")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                    $sql = "SELECT * FROM online WHERE (customer_id='".$user_id_escaped."' OR receiver='".$user_id_escaped."') AND (status = 'complete' OR status = 'order') ORDER BY created_date DESC";
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="online">Онлайн захиалга</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Хойшлуулсан</a></li>
                        </ol>
                    </nav>
                    
                    <?php
                    require_once("views/online.php");?>                        
                    <?php
                }
                ?>

                <?php
                if ($action=="insert")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="online">Онлайн захиалга</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Шинээр бүртгэх</a></li>
                        </ol>
                    </nav>

                    <div class="row layout-spacing">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Онлайн захиалга оруулах</h5>
                                    <?php
 
                                        if (isset($_POST["url"]) && $_POST["url"]<>"")
                                        {
                                            $no_ssl=0;
                                            $url = isset($_POST["url"]) ? mysqli_real_escape_string($conn, $_POST["url"]) : '';
                                            $size = isset($_POST["size"]) ? mysqli_real_escape_string($conn, $_POST["size"]) : '';
                                            $color = isset($_POST["color"]) ? mysqli_real_escape_string($conn, $_POST["color"]) : '';
                                            $number = isset($_POST["number"]) ? mysqli_real_escape_string($conn, $_POST["number"]) : '';
                                            $description = isset($_POST["description"]) ? mysqli_real_escape_string($conn, $_POST["description"]) : '';
                                            $created_date=date("Y-m-d H:i:s");

                                            if(isset($_POST["transport"])) $transport = 1; else $transport=0;
                                            if (strpos($url,"bestbuy.com")>0 || 
                                                strpos($url,"cabelas.com")>0 ||
                                                strpos($url,"sweetwater.com")>0 ||
                                                strpos($url,"macys.com")>0 ||
                                                strpos($url,"adidas.com")>0 ||
                                                strpos($url,"dsw.com")>0 ||
                                                strpos($url,"nike.com")>0 ||
                                                strpos($url,"michaelkors.com")>0) $no_ssl=1; else $no_ssl=0;

                                            function getSslPage($url) {
                                                $ch = curl_init();
                                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
                                                curl_setopt($ch, CURLOPT_HEADER, false);
                                                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                                                curl_setopt($ch, CURLOPT_URL, $url);
                                                curl_setopt($ch, CURLOPT_REFERER, $url);
                                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                                                $result = curl_exec($ch);
                                                curl_close($ch);
                                                return $result;
                                            }

                                            function get_title($url){
                                            $str = file_get_contents($url);
                                            if(strlen($str)>0){
                                                $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
                                                preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title); // ignore case
                                                return $title[1];
                                            }
                                            }
                                            //echo $url;
                                            if ($no_ssl==0)
                                            {
                                            $html = getSslPage($url);
                                            $title = substr($html,strpos(strtolower($html),"<title>")+7, strpos(strtolower($html),"</title>")-strpos(strtolower($html),"<title>")-7);
                                            }

                                            if ($title=="") $title=$url;
                                            if (strpos($title,": Amazon")>0) $title = substr($title,0,strpos($title,": Amazon"));
                                            if (strpos($title,"| eBay")>0) $title = substr($title,0,strpos($title,"| eBay"));
                                            $title = mysqli_real_escape_string($conn, $title);
                                            $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                                            $sql = "INSERT INTO online (url,size,color,`number`,created_date,customer_id,receiver,title,transport,context,status) 
                                            VALUES('".$url."','".$size."','".$color."','".$number."','".$created_date."','".$user_id_escaped."','".$user_id_escaped."','".$title."','".$transport."','".$description."','online')";
                                            
                                                                                    
                                            if (mysqli_query($conn,$sql))
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
                                                    <b><?php echo htmlspecialchars($error ?? ''); ?></b> Алдаа гарлаа: <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error'; ?>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    <form action="online?action=insert"method="post" enctype="multipart/form-data">

                                            
                                        <div class="form-group">
                                            <label for="url">Барааны url хаяг</label>
                                            <input type="text" class="form-control" id="url" placeholder="Барааны url хаяг" name="url" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="number">Барааны тоо ширхэг</label>
                                            <input type="text" class="form-control" id="number" placeholder="Барааны тоо ширхэг" name="number" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="size">Барааны хэмжээ</label>
                                            <input type="text" class="form-control" id="size" placeholder="Барааны хэмжээ" name="size" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="color">Барааны өнгө</label>
                                            <input type="text" class="form-control" id="color" placeholder="Барааны өнгө" name="color" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Нэлэмт тайлбар</label>
                                            <input type="text" class="form-control" id="description" placeholder="Нэлэмт тайлбар" name="description" value="">
                                        </div>
                                        
                                        <input type="submit" class="btn btn-primary" value="Хадгалах">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <?php
                if ($action=="makelater")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $online_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="online">Онлайн захиалга</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Хойшлуулах</a></li>
                        </ol>
                    </nav>

                    <div class="row layout-spacing">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Онлайн захиалга Хойшлуулах</h5>
                                    <?php
                                            $online_id_escaped = intval($online_id);
                                            $sql = "SELECT * FROM online WHERE online_id=".$online_id_escaped;
                                            $result = mysqli_query($conn,$sql);

                                            if ($result && mysqli_num_rows($result) == 1)
                                            {
                                                
                                                $data = mysqli_fetch_array($result);
                                                if (isset($data["customer_id"]) && $data["customer_id"]==$user_id)
                                                {
                                                    if (mysqli_query($conn,"UPDATE online SET status='later' WHERE online_id=".$online_id_escaped))
                                                    {
                                                        ?>
                                                        <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                            Амжилттай хойшлууллаа
                                                        </div>
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
                                                else 
                                                {
                                                    ?>
                                                     <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                        Таны оруулсан захиалга биш байна
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            else //if ($query->num_rows() == 1)
                                            {
                                                ?>
                                            
                                                     <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                        Захиалга олдсонгүй
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
                if ($action=="makeactive")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $online_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="online">Онлайн захиалга</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Идэвхижүүлэх</a></li>
                        </ol>
                    </nav>

                    <div class="row layout-spacing">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Онлайн захиалга Хойшлуулах</h5>
                                    <?php
                                            $online_id_escaped = intval($online_id);
                                            $sql = "SELECT * FROM online WHERE online_id=".$online_id_escaped;
                                            $result = mysqli_query($conn,$sql);

                                            if ($result && mysqli_num_rows($result) == 1)
                                            {
                                                
                                                $data = mysqli_fetch_array($result);
                                                if (isset($data["customer_id"]) && $data["customer_id"]==$user_id)
                                                {
                                                    if (mysqli_query($conn,"UPDATE online SET status='online' WHERE online_id=".$online_id_escaped))
                                                    {
                                                        ?>
                                                        <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                            Амжилттай идэвхижүүллээ
                                                        </div>
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
                                                else 
                                                {
                                                    ?>
                                                     <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                        Таны оруулсан захиалга биш байна
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            else //if ($query->num_rows() == 1)
                                            {
                                                ?>
                                            
                                                     <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                        Захиалга олдсонгүй
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
                if ($action=="delete")
                {
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $online_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="online">Онлайн захиалга</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Устгах</a></li>
                        </ol>
                    </nav>

                    <div class="row layout-spacing">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Онлайн захиалга Хойшлуулах</h5>
                                    <?php
                                            $online_id_escaped = intval($online_id);
                                            $sql = "SELECT * FROM online WHERE online_id=".$online_id_escaped;
                                            $result = mysqli_query($conn,$sql);

                                            if ($result && mysqli_num_rows($result) == 1)
                                            {
                                                
                                                $data = mysqli_fetch_array($result);
                                                if (isset($data["customer_id"]) && $data["customer_id"]==$user_id)
                                                {
                                                    if (mysqli_query($conn,"DELETE FROM online WHERE online_id=".$online_id_escaped))
                                                    {
                                                        ?>
                                                        <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                            Амжилттай устгалаа
                                                        </div>
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
                                                else 
                                                {
                                                    ?>
                                                     <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                        Таны оруулсан захиалга биш байна
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            else //if ($query->num_rows() == 1)
                                            {
                                                ?>
                                            
                                                     <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                        Захиалга олдсонгүй
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
                if ($action == "payment")
                {
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="online">Онлайн захиалга</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Төлбөр төлөх</a></li>
                        </ol>
                    </nav>

                    <div class="row layout-spacing">
                            <!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 layout-top-spacing">
                                <div class="card component-card_9">
                                    <img src="assets/images/tdb.jpg" class="card-img-top" alt="widget-card-2">
                                    <div class="card-body">
                                        <p class="meta-date"><img src="assets/images/tdb-logo.png" class="mr-1"><b>Худалдаа Хөгжлийн банк</b></p>
                                        <h5 class="card-title">457049152 - $ - Гэрэл</h5>
                                    </div>
                                </div>
                            </div> -->

                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 layout-top-spacing">
                                <div class="card component-card_9">
                                    <img src="assets/images/khanbank.jpg" class="card-img-top" alt="widget-card-2">
                                    <div class="card-body">
                                        <p class="meta-date"><img src="assets/images/khanbank-logo.png" class="mr-1"><b>Хаан банк</b></p>
                                        <h5 class="card-title">MN830005005003883871 - ₮ - Гэрэл 
                                            <span class="btn btn-warning" onclick="navigator.clipboard.writeText('830005005003883871')">Хуулах! <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></span>
</h5>
                                        <h5 class="card-title">Гүйлгээний утга: Утасны дугаар</h5>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 layout-top-spacing">
                                <div class="card component-card_9">
                                    <img src="assets/images/golomt.jpg" class="card-img-top" alt="widget-card-2">
                                    <div class="card-body">
                                        <p class="meta-date"><img src="assets/images/golomt-logo.png" class="mr-1"><b>Голомт банк</b></p>
                                        <h5 class="card-title">1161002923  - $ - Гэрэл</h5>
                                    </div>
                                </div>
                            </div> -->
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