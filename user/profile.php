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
<link href="assets/css/components/custom-list-group.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
<link href="assets/css/tables/table-basic.css" rel="stylesheet" type="text/css" />
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
                <? if (isset($_GET["action"])) $action=$_GET["action"]; else $action="init"; ?>

                <?
                if ($action=="init")
                {
                
                    $user_id = $_SESSION["c_user_id"];
                    $sql = "SELECT *FROM customer WHERE customer_id ='$user_id'";
                    $result =mysqli_query($conn,$sql);
                    $data = mysqli_fetch_array($result);    
                    $name = $data["name"];
                    $surname = $data["surname"];
                    $avatar = $data["avatar"];
                    if ($avatar=='') $avatar='assets/img/user-male.png';

                    $rd = $data["rd"];      
                    $tel = $data["tel"];   
                    $email = $data["email"];   
                    $facebook = $data["facebook"];   
                    $last_log = $data["last_log"];   
                    $registered_date = $data["registered_date"];   
                    $modified_date = $data["modified_date"];  
                    $status = $data["status"];   
                    $username = $data["username"];   

                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="profile">Хувийн тохиргоо</a></li>
                        </ol>
                    </nav>
                    
                        <div class="row layout-spacing">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">

                                <div class="user-profile layout-spacing">
                                    <div class="widget-content widget-content-area">
                                        <div class="d-flex justify-content-between">
                                            <h3 class="">Хувийн мэдээлэл</h3>
                                            <a href="profile?action=edit" class="mt-2 edit-profile"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a>
                                        </div>
                                        <div class="text-center user-info">
                                            <img src="<?=$avatar;?>" alt="avatar">
                                            <p class=""><?=$name;?></p>
                                        </div>
                                        <div class="user-info-list">

                                            <div class="">
                                                <ul class="contacts-block list-unstyled">
                                                    <li class="contacts-block__item">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> <?=$name;?> <?=$surname;?>
                                                    </li>
                                                    <li class="contacts-block__item">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> <?=$rd;?>
                                                    </li>
                                                    <a href="profile?action=edit&type=address" class="badge badge-primary float-right">Хаяг солих</a>
                                                    <li class="contacts-block__item">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg><?=address($user_id);?> 
                                                    </li>
                                                    
                                                    <li class="contacts-block__item">
                                                        <a href="mailto:<?=$email;?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg><?=$email;?></a>
                                                    </li>
                                                    <li class="contacts-block__item">
                                                        <a href="tel:<?=$tel;?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg> <?=$tel;?>
                                                    </li>
                                                    <li class="contacts-block__item">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <div class="social-icon">
                                                                    <a href="<?=$facebook;?>">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                                                                    </a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>                                    
                                        </div>
                                    </div>
                                </div>

                                <div class="education layout-spacing ">
                                    <div class="widget-content widget-content-area">
                                        <h3 class="">Хэрэглэгчийн түүх</h3>
                                        <div class="timeline-alter">
                                            <div class="item-timeline">
                                                <div class="t-meta-date">
                                                    <p class=""><?=$registered_date;?></p>
                                                </div>
                                                <div class="t-dot">
                                                </div>
                                                <div class="t-text">
                                                    <p>Бүртгүүлсэн</p>
                                                </div>
                                            </div>
                                        
                                            <div class="item-timeline">
                                                <div class="t-meta-date">
                                                    <p class=""><?=$modified_date;?></p>
                                                </div>
                                                <div class="t-dot">
                                                </div>
                                                <div class="t-text">
                                                    <p>Мэдээлэл зассан</p>
                                                </div>
                                            </div>

                                            <div class="item-timeline">
                                                <div class="t-meta-date">
                                                    <p class=""><?=substr($last_log,0,10);?></p>
                                                </div>
                                                <div class="t-dot">
                                                </div>
                                                <div class="t-text">
                                                    <p>нэвтэрсэн</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">

                                <div class="layout-spacing user-profile">
                                    <div class="widget-content widget-content-area">
                                        <div class="d-flex justify-content-between">
                                            <h3 class="">Нэвтрэх мэдээлэл</h3>
                                            <a href="profile?action=edit&type=username" class="mt-2 edit-profile"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a>
                                        </div>
                                        <h6 class="">Нэвтрэх нэр</h6>
                                        <h4><?=$username;?></h4> 

                                        <h6 class="">Нууц үг</h6>
                                        <a href="profile?action=edit&type=address" class="badge badge-primary float-right">Нууц үг солих</a>
                                        <h4>****</h4> 
                                    </div>
                                </div>
                            
                            </div>
                        </div>

                        
                    <?
                }
                ?>

                <?
                if ($action=="edit")
                {
                    $user_id = $_SESSION["c_user_id"];
                    $sql = "SELECT *FROM customer WHERE customer_id ='$user_id'";
                    $result =mysqli_query($conn,$sql);
                    $data = mysqli_fetch_array($result);    
                    $name = $data["name"];
                    $surname = $data["surname"];
                    $avatar = $data["avatar"];
                    if ($avatar=='') $avatar='assets/img/user-male.png';

                    $rd = $data["rd"];      
                    $tel = $data["tel"];   
                    $email = $data["email"];   
                    $facebook = $data["facebook"];   
                    $last_log = $data["last_log"];   
                    $registered_date = $data["registered_date"];   
                    $modified_date = $data["modified_date"];  
                    $status = $data["status"];   
                    $username = $data["username"];   
                    $password = $data["password"];   

                    $city = $data["address_city"];  
                    $district = $data["address_district"];  
                    $khoroo = $data["address_khoroo"];  
                    $build = $data["address_build"];  
                    $extra = $data["address_extra"];  
                    unset($sql);


                    if(isset($_GET["type"])) $type= $_GET["type"]; else $type="general";
                    if(isset($_POST["type"])) $type= $_POST["type"]; 
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="profile">Хувийн тохиргоо</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Засах</a></li>
                        </ol>
                    </nav>
                    <div class="row layout-spacing">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Хувийн мэдээлэл засах</h5>
                                    <?
                                    if (isset($_POST["type"]))
                                    {
                                        if ($_POST["type"]=="general")
                                        {
                                            $new_surname = protect($_POST["surname"]);
                                            $new_email = protect($_POST["email"]);
                                            $new_rd = protect($_POST["rd"]);
                                            $new_facebook =protect($_POST["facebook"]);
                                            $sql = "UPDATE customer SET surname='$new_surname',email='$new_email',rd='$new_rd',facebook='$new_facebook',modified_date=now()  WHERE customer_id='$user_id' LIMIT 1";
                                        }

                                        if ($_POST["type"]=="username")
                                        {
                                            $username = protect($_POST["username"]);
                                            $new_email = protect($_POST["email"]);
                                            $new_rd = protect($_POST["rd"]);
                                            $new_facebook =protect($_POST["facebook"]);
                                            $sql = "UPDATE customer SET username='$new_surname' WHERE customer_id='$user_id' LIMIT 1";
                                        }

                                        if ($_POST["type"]=="password")
                                        {
                                            $old_password = protect($_POST["old_password"]);
                                            $new_password = protect($_POST["new_password"]);
                                            $new_password2 = protect($_POST["new_password2"]);
                                            
                                            if ($new_password==$new_password2 && $old_password==$password)
                                            $sql = "UPDATE customer SET password='$new_password' WHERE customer_id='$user_id' LIMIT 1";
                                            else $error="Хуучин нууц үг буруу байна";
                                        }

                                        if ($_POST["type"]=="address")
                                        {
                                            $new_city = protect($_POST["city"]);
                                            $new_district = protect($_POST["district"]);
                                            $new_khoroo = protect($_POST["khoroo"]);
                                            $new_build =protect($_POST["build"]);
                                            $new_extra =protect($_POST["extra"]);
                                            $sql = "UPDATE customer SET address_city='$new_city',address_district='$new_district',address_khoroo='$new_khoroo',address_build='$new_build',address_extra='$new_extra' WHERE customer_id='$user_id' LIMIT 1";
                                        }

                                        if ($_POST["type"]=="avatar")
                                        {
                                            $image ="";
                                            if(isset($_FILES['image']) && $_FILES['image']['name']!="")
                                            {
                                                if ($_FILES['image']['name']!="")
                                                    {                        
                                                        @$folder = date("Ym");
                                                        if(!file_exists('uploads/'.$folder))
                                                        mkdir ( 'uploads/'.$folder);
                                                        $target_dir = 'uploads/'.$folder;
                                                        $target_file = $target_dir."/".@date("his").rand(0,1000). basename($_FILES["image"]["name"]);
                                                        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file))
                                                        {
                                                            $thumb_image_content = resize_image($target_file,300,200);
                                                            $thumb = substr($target_file,0,-4)."_thumb".substr($target_file,-4,4);
                                                            imagejpeg($thumb_image_content,$thumb,75);
                                                            $target_file = substr($target_file,3);
                                                            $thumb = substr($thumb,3);
                                                            $sql = "UPDATE customer SET avatar='$target_file',thumb='$thumb' WHERE customer_id='$user_id'";
                                                        }
                                                    }
                                            }
                                            $sql = "UPDATE customer SET address_city='$new_city',address_district='$new_district',address_khoroo='$new_khoroo',address_build='$new_build',address_extra='$new_extra' WHERE customer_id='$user_id' LIMIT 1";
                                        }


                                        if ($_POST["type"]<>"" && $sql<>"")
                                        if (mysqli_query($conn,$sql))
                                        {
                                            ?>
                                            <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                Амжилттай заслаа
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
                                        ?>
                                        
                                        <?
                                    }
                                    ?>
                                    <form action="profile?action=edit"method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="type" value="<?=$type;?>">
                                        <?
                                        if ($type=="avatar")
                                        {
                                            ?>
                                            <div class="custom-file-container" data-upload-id="myFirstImage">
                                                <label>Файл оруулах<a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                                <label class="custom-file-container__custom-file" >
                                                    <input type="file" class="custom-file-container__custom-file__custom-file-input" accept="image/*" name="image">
                                                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                                    <span class="custom-file-container__custom-file__custom-file-control"></span>
                                                </label>
                                                <div class="custom-file-container__image-preview"></div>
                                            </div>
                                            <?
                                        }
                                        ?>
                                        <?
                                        if ($type=="general")
                                        {
                                            ?>
                                            <div class="form-group">
                                                <label for="name">Нэр</label>
                                                <input type="text" class="form-control" id="name" placeholder="Нэр" name="name" value="<?=$name;?>" readonly="readonly">
                                            </div>
                                            <div class="form-group">
                                                <label for="surname">Овог</label>
                                                <input type="text" class="form-control" id="surname" placeholder="Овог" name="surname" value="<?=$surname;?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="rd">РД</label>
                                                <input type="text" class="form-control" id="rd" placeholder="Регистрийн дугаар" name="rd" value="<?=$rd;?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="tel">Утас</label>
                                                <input type="text" class="form-control" id="tel" placeholder="Утас" name="tel" value="<?=$tel;?>" readonly="readonly">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Имэйл</label>
                                                <input type="text" class="form-control" id="email" placeholder="Имэйл" name="email" value="<?=$email;?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="facebook">Facebook</label>
                                                <input type="text" class="form-control" id="facebook" placeholder="Facebook" name="facebook" value="<?=$facebook;?>">
                                            </div>
                                            <?
                                        }
                                        ?>

                                        <?
                                        if ($type=="username")
                                        {
                                            ?>
                                            <div class="form-group">
                                                <label for="username">Нэвтрэх нэр</label>
                                                <input type="text" class="form-control" id="username" placeholder="Нэвтрэх нэр" name="username" value="<?=$username;?>">
                                            </div>
                                            <?
                                        }
                                        ?>

                                        <?
                                        if ($type=="password")
                                        {
                                            ?>
                                            <div class="form-group">
                                                <label for="old_password">Хуучин нууц үг (*)</label>
                                                <input type="password" class="form-control" id="old_password" placeholder="Хуучин нууц үг" name="old_password" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="new_password">Шинэ нууц үг (*)</label>
                                                <input type="password" class="form-control" id="new_password" placeholder="Шинэ нууц үг" name="new_password" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="new_password2">Шинэ нууц үг (*)</label>
                                                <input type="password" class="form-control" id="new_password2" placeholder="Шинэ нууц үг давтах" name="new_password2" required>
                                            </div>
                                            <?
                                        }
                                        ?>


                                        <?
                                        if ($type=="address")
                                        {
                                            ?>
                                            <div class="form-group">
                                                <label for="city">Хот</label>
                                                <select name="city" class="form-control" id="city">
                                                    <?
                                                    $sql =  "SELECT *FROM city";
                                                    $result = mysqli_query($conn,$sql);
                                                    while ($data = mysqli_fetch_array($result))
                                                    {
                                                        ?>
                                                        <option value="<?=$data["id"];?>" <?=($data["id"]==$city)?'SELECTED="SELECTED"':'';?>><?=$data["name"];?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="surname">Дүүрэг</label>
                                                    <select name="district" class="form-control" id="district">
                                                        <?
                                                        $sql =  "SELECT *FROM district";
                                                        $result = mysqli_query($conn,$sql);					
                                                        while ($data = mysqli_fetch_array($result))
                                                        {
                                                            ?>
                                                            <option value="<?=$data["id"];?>" data-chained="<?=$data["city_id"];?>" <?=($data["id"]==$district)?'SELECTED="SELECTED"':'';?>><?=$data["name"];?></option>
                                                            <?
                                                        }
                                                        ?>
                                                    </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="khoroo">Баг, хороо</label>
                                                <input type="text" class="form-control" id="khoroo" placeholder="Баг, хороо" name="khoroo" value="<?=$khoroo;?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="build">Байр, гудамж</label>
                                                <input type="text" class="form-control" id="build" placeholder="Байр, гудамж" name="build" value="<?=$build;?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="extra">Нэмэлт мэдээлэл</label>
                                                <input type="text" class="form-control" id="extra" placeholder="Хаягны нэмэлт мэдээлэл" name="extra" value="<?=$extra;?>">
                                            </div>
                                            <?
                                        }
                                        ?>
                                        <input type="submit" class="btn btn-primary" value="Хадгалах">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?
                }
                ?>

                <?
                if ($action=="logged_history")
                {
                
                    $user_id = $_SESSION["c_user_id"];
                    $count=0;
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="profile">Хувийн тохиргоо</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Нэвтэрсэн түүх</a></li>
                        </ol>
                    </nav>
                    
                        <div class="row layout-spacing">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="zero-config" class="table table-hover" >
                                                <thead>
                                                    <tr>
                                                        <th>№</th>
                                                        <th>Хэзээ</th>
                                                        <th>Хаанаас</th>
                                                        <th>Хэрхэн</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?
                                                    $sql = "SELECT *FROM customer_logging WHERE customer_id='$user_id' ORDER BY timestamp DESC";
                                                    $result = mysqli_query($conn,$sql);
                                                    while ($data =mysqli_fetch_array($result))
                                                    {
                                                        ?>
                                                        <tr>
                                                            <td><?=++$count;?></td>
                                                            <td><?=$data["timestamp"];?></td>
                                                            <td><?=$data["ip"];?></td>
                                                            <td><?=$data["browser"];?></td>
                                                        </tr>
                                                        <?
                                                    }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th><?=$count;?></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        
                    <?
                }
                ?>
                

                <?
                 if ($action=="addresses")
                 {
                    $user_id = $_SESSION["c_user_id"];
                    $count=0;
                     ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="#">Хүргэлтийн хаягууд</a></li>
                        </ol>
                    </nav>

                    <div class="row layout-spacing">
                        <div id="listGroupIcons" class="col-lg-12 layout-top-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area">
                                    <ul class="list-group list-group-icons-meta">
                                        <?
                                        $sql = "SELECT customer_address.*,city.name city_name, district.name district_name FROM customer_address 
                                        LEFT JOIN city ON customer_address.city=city.id
                                        LEFT JOIN district ON customer_address.district=district.id
                                        WHERE customer_id='$user_id' ORDER BY timestamp DESC";
                                        $result = mysqli_query($conn,$sql);
                                        while ($data = mysqli_fetch_array($result))
                                        {
                                            ?>
                                            <li class="list-group-item list-group-item-action <?=($data["status"])?'active':'';?>">
                                                <div class="media">
                                                    <div class="d-flex mr-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="tx-inverse"><?=address_deliver($data["id"]);?></h6>
                                                        <div class="btn-group " role="group" aria-label="Basic example">
                                                            <a href="profile?action=address_edit&id=<?=$data["id"];?>"class="bs-popover mb-2 rounded text-white" data-placement="top" data-trigger="hover" data-content="Дэлгэрэнгүй">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                            </a>
                                                            <?
                                                            if (!$data["status"])
                                                            {
                                                                ?>
                                                                <a href="profile?action=address_make_primary&id=<?=$data["id"];?>" class="bs-popover mb-2 rounded" data-placement="top" data-trigger="hover" data-content="Үндсэн хаяг болгох">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>                                                                
                                                                </a>
                                                               
                                                                <?
                                                            }
                                                            ?>
                                                            <a href="profile?action=address_delete&id=<?=$data["id"];?>" class="btn-xs btn-xs bs-popover mb-2 rounded" data-placement="top" data-trigger="hover" data-content="Устгах">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <?
                                        }
                                        ?>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                    <a href="profile?action=address_add" class="btn btn-success">Хаяг нэмэх</a>
                    <?
                 }
                ?>

                <?
                if ($action=="address_add")
                {
                    $user_id = $_SESSION["c_user_id"];
                   ?>

                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="profile?action=addresses">Хүргэлтийн хаяг</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Нэмэх</a></li>
                        </ol>
                    </nav>

                    
                    <div class="row layout-spacing">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">
                        
                            <?
                            if (isset($_GET["msg"]))
                            {
                                ?>
                                <div class="alert alert-arrow-left alert-icon-left alert-light-primary mb-4" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                <?=($_GET["msg"]=='no_address')?"Үндсэн хаяг хүргэлтийн хаяг тохируулаагүй тул хүргэлтийн хаяг бүртгэн хадгална уу. Баярлалаа":"";?>
                                </div>
                                <?
                            }
                            ?>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Хувийн мэдээлэл засах</h5>
                                    <?
                                     if (isset($_POST["city"]))
                                     {
                                         $new_city = intval(protect($_POST["city"]));
                                         $new_district = intval(protect($_POST["district"]));
                                         $new_khoroo = protect($_POST["khoroo"]);
                                         $new_build =protect($_POST["build"]);
                                         $new_extra =protect($_POST["extra"]);
                                         if (isset($_POST["primary"])) $primary=1; else $primary=0;
                                         $sql = "INSERT INTO customer_address (customer_id,city,district,khoroo,build,extra,status) VALUES ('$user_id','$new_city','$new_district','$new_khoroo','$new_build','$new_extra','$primary')";
                                         if (mysqli_query($conn,$sql))
                                         {
                                             $address_id = mysqli_insert_id($conn);
                                             if ($primary)
                                             {
                                                 mysqli_query($conn,"UPDATE customer_address SET status=0 WHERE customer_id='$user_id' AND id<>'$address_id'");
                                                 mysqli_query($conn,"UPDATE customer 
                                                 SET
                                                     address_city = '$new_city',
                                                     address_district = '$new_district',
                                                     address_khoroo = '$new_khoroo',
                                                     address_build = '$new_build',
                                                     address_extra = '$new_extra'                                                   
                                                      WHERE customer_id='$user_id'");
                                             }
                                             ?>
                                             <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                 Амжилттай нэмлээ
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
                                     ?>
                                    <form action="profile?action=address_add" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="city">Хот</label>
                                            <select name="city" class="form-control" id="city">
                                                <?
                                                $sql =  "SELECT *FROM city";
                                                $result = mysqli_query($conn,$sql);
                                                while ($data = mysqli_fetch_array($result))
                                                {
                                                    ?>
                                                    <option value="<?=$data["id"];?>" <?=($data["id"]==$city)?'SELECTED="SELECTED"':'';?>><?=$data["name"];?></option>
                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="surname">Дүүрэг</label>
                                                <select name="district" class="form-control" id="district">
                                                    <?
                                                    $sql =  "SELECT *FROM district";
                                                    $result = mysqli_query($conn,$sql);					
                                                    while ($data = mysqli_fetch_array($result))
                                                    {
                                                        ?>
                                                        <option value="<?=$data["id"];?>" data-chained="<?=$data["city_id"];?>" <?=($data["id"]==$district)?'SELECTED="SELECTED"':'';?>><?=$data["name"];?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="khoroo">Баг, хороо</label>
                                            <input type="text" class="form-control" id="khoroo" placeholder="Баг, хороо" name="khoroo" value="<?=$khoroo;?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="build">Байр, гудамж</label>
                                            <input type="text" class="form-control" id="build" placeholder="Байр, гудамж" name="build" value="<?=$build;?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="extra">Нэмэлт мэдээлэл</label>
                                            <input type="text" class="form-control" id="extra" placeholder="Хаягны нэмэлт мэдээлэл" name="extra" value="<?=$extra;?>">
                                        </div>

                                        <div class="d-sm-flex justify-content-between">
                                            <div class="field-wrapper">
                                                <p class="d-inline-block pt-0">Үндсэн хүргэлтийн хаяг</p>
                                                <label class="switch s-primary mb-0">
                                                    <input type="checkbox" class="d-none" checked name="primary">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <input type="submit" class="btn btn-primary" value="Хадгалах">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?
                }
                ?>

                <?
                if ($action=="address_edit")
                {
                    $user_id = $_SESSION["c_user_id"];
                    if (isset($_GET["id"]))
                    {
                        $address_id = $_GET["id"];
                        $sql = "SELECT *FROM customer_address WHERE id='$address_id' AND customer_id='$user_id' LIMIT 1";
                        $result = mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)==1)
                        {
                            $data = mysqli_fetch_array($result);
                            $city = $data["city"];
                            $district = $data["district"];
                            $khoroo = $data["khoroo"];
                            $build =$data["build"];
                            $extra =$data["extra"];
                            $status = $data["status"];
                            ?>
                            <nav class="breadcrumb-two" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                                    <li class="breadcrumb-item active"><a href="profile?action=addresses">Хүргэлтийн хаяг</a></li>
                                    <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Засах</a></li>
                                </ol>
                            </nav>
                        
                            <div class="row layout-spacing">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Хувийн мэдээлэл засах</h5>
                                            <?
                                            if (isset($_POST["id"]))
                                            {
                                                $new_city = protect($_POST["city"]);
                                                $new_district = protect($_POST["district"]);
                                                $new_khoroo = protect($_POST["khoroo"]);
                                                $new_build =protect($_POST["build"]);
                                                $new_extra =protect($_POST["extra"]);
                                                if (isset($_POST["primary"])) $primary=1; else $primary=0;
                                                $sql = "UPDATE customer_address SET city='$new_city',district='$new_district',khoroo='$new_khoroo',build='$new_build',extra='$new_extra',status='$primary' WHERE customer_id='$user_id' AND id='$address_id'";
                                                if (mysqli_query($conn,$sql))
                                                {
                                                    $city = $new_city;
                                                    $district = $new_district;
                                                    $khoroo = $new_khoroo;
                                                    $build =$new_build;
                                                    $extra =$new_extra;

                                                    $address_id = mysqli_insert_id($conn);
                                                    if ($primary)
                                                    {
                                                        mysqli_query($conn,"UPDATE customer_address SET status=0 WHERE customer_id='$user_id' AND id<>'$address_id'");
                                                        mysqli_query($conn,"UPDATE customer 
                                                        SET
                                                            address_city = '$new_city',
                                                            address_district = '$new_district',
                                                            address_khoroo = '$new_khoroo',
                                                            address_build = '$new_build',
                                                            address_extra = '$new_extra'                                                   
                                                             WHERE customer_id='$user_id'");
                                                    }
                                                    ?>
                                                    <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                        Амжилттай заслаа
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
                                            ?>
                                            <form action="profile?action=address_edit&id=<?=$address_id;?>" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id" value="<?=$address_id;?>">
                                                <div class="form-group">
                                                    <label for="city">Хот</label>
                                                    <select name="city" class="form-control" id="city">
                                                        <?
                                                        $sql =  "SELECT *FROM city";
                                                        $result = mysqli_query($conn,$sql);
                                                        while ($data = mysqli_fetch_array($result))
                                                        {
                                                            ?>
                                                            <option value="<?=$data["id"];?>" <?=($data["id"]==$city)?'SELECTED="SELECTED"':'';?>><?=$data["name"];?></option>
                                                            <?
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="surname">Дүүрэг</label>
                                                        <select name="district" class="form-control" id="district">
                                                            <?
                                                            $sql =  "SELECT *FROM district";
                                                            $result = mysqli_query($conn,$sql);					
                                                            while ($data = mysqli_fetch_array($result))
                                                            {
                                                                ?>
                                                                <option value="<?=$data["id"];?>" data-chained="<?=$data["city_id"];?>" <?=($data["id"]==$district)?'SELECTED="SELECTED"':'';?>><?=$data["name"];?></option>
                                                                <?
                                                            }
                                                            ?>
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="khoroo">Баг, хороо</label>
                                                    <input type="text" class="form-control" id="khoroo" placeholder="Баг, хороо" name="khoroo" value="<?=$khoroo;?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="build">Байр, гудамж</label>
                                                    <input type="text" class="form-control" id="build" placeholder="Байр, гудамж" name="build" value="<?=$build;?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="extra">Нэмэлт мэдээлэл</label>
                                                    <input type="text" class="form-control" id="extra" placeholder="Хаягны нэмэлт мэдээлэл" name="extra" value="<?=$extra;?>">
                                                </div>

                                                <div class="d-sm-flex justify-content-between">
                                                    <div class="field-wrapper">
                                                        <p class="d-inline-block pt-0">Үндсэн хүргэлтийн хаяг</p>
                                                        <label class="switch s-primary mb-0">
                                                            <input type="checkbox" class="d-none" <?=($status)?'checked':'';?> name="primary">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <input type="submit" class="btn btn-primary" value="Хадгалах">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?
                        }
                        else 
                        echo "asdasd";
                        //header("location:profile?action=addresses");
                    }
                    else
                    echo "asdasdasd"; 
                    ///header("location:profile?action=addresses");
                }
                ?>

                <?
                if ($action=="address_make_primary")
                {
                    $user_id = $_SESSION["c_user_id"];
                    $address_id = protect($_GET["id"]);
                    $sql = "UPDATE customer_address SET status=0 WHERE customer_id='$user_id'";
                    mysqli_query($conn,$sql);

                    $sql = "UPDATE customer_address SET status=1 WHERE customer_id='$user_id' AND id='$address_id'";
                    mysqli_query($conn,$sql);
                    header("location:profile?action=addresses");

                }
                ?>

              
                <?
                if ($action=="address_delete")
                {
                    $user_id = $_SESSION["c_user_id"];
                    $address_id = protect($_GET["id"]);
                    $sql = "SELECT *FROM customer_address WHERE customer_id='$user_id' AND id='$address_id'";
                    $result = mysqli_query($conn,$sql);
                    $data = mysqli_fetch_array($result);
                    if ($data["status"]==0)
                        {
                            $sql = "DELETE FROM customer_address WHERE customer_id='$user_id' AND id='$address_id' LIMIT 1";
                            mysqli_query($conn,$sql);        
                        }
                    if ($data["status"]==0)
                        {
                            $sql = "DELETE FROM customer_address WHERE customer_id='$user_id' AND id='$address_id' LIMIT 1";
                            mysqli_query($conn,$sql);  

                            $sql = "UPDATE customer_address SET status=1 WHERE customer_id='$user_id' AND id='$address_id' LIMIT 1";
                            mysqli_query($conn,$sql);        
                        }
                    header("location:profile?action=addresses");

                }
                ?>



                <?
                 if ($action=="proxies")
                 {
                    $user_id = $_SESSION["c_user_id"];
                    $count=0;
                     ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="#">Захиалагч</a></li>
                        </ol>
                    </nav>
                    

                    <div class="row mt-1">
                        <div class="col-12">
                            <div class="widget-content widget-content-area">
                                <?php
                                if (isset($_GET["alert"]))
                                {
                                    $alert = $_GET["alert"];
                                    switch ($alert)
                                    {
                                        case "proxy_in_use" : $alert="Ачаа ирж буй захиалагчийг устгах боломжгүй";break;
                                        default :$alert="";
                                    }
                                       
                                    if ($alert<>"")
                                    {
                                        ?>
                                        <div class="alert alert-arrow-right alert-icon-right alert-light-danger mb-4" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                                            <strong>Анхаар!</strong> <?=$alert;?>
                                        </div>
                                        <?
                                    }
                                }
                                ?>
                                

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped mb-4">
                                        <thead>
                                            <tr>
                                                <th class="">№</th>
                                                <th class="">Овог</th>
                                                <th class="">Нэр</th>
                                                <th class="">Утас</th>
                                                <th class="">Хаяг</th>
                                                <th class="text-center">Үйлдэл</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?
                                                $count=0;
                                                $sql = "SELECT *FROM proxies WHERE customer_id='$user_id'";
                                                $result = mysqli_query($conn,$sql);
                                                while ($data = mysqli_fetch_array($result))
                                                {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?=++$count;?>
                                                        </td>
                                                        <td>
                                                            <?=$data["surname"];?>
                                                        </td>
                                                        <td>
                                                            <?=$data["name"];?>
                                                        </td>
                                                        <td>
                                                            <?=$data["tel"];?>
                                                        </td>
                                                        <td>
                                                            <?=$data["address"];?>
                                                        </td>
                                                       
                                                        <td class="text-center">
                                                            <?
                                                            if ($data["status"]==0)
                                                            {
                                                                ?>
                                                                <ul class="table-controls">
                                                                    <li><a href="profile?action=proxy_edit&id=<?=$data["proxy_id"];?>" data-toggle="tooltip" data-placement="top" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a></li>
                                                                    <li><a class="confirm" href="#" data-toggle="tooltip" data-placement="top" title="Устгах" alt="<?=$data["proxy_id"];?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a></li>
                                                                </ul>
                                                                <?
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?
                                                }
                                                ?>
                                        </tbody>
                                    </table>
                                </div>
                                <a href="profile?action=proxy_add" class="btn btn-success">Захиалагч нэмэх</a>

                            </div>
                        </div>
                    </div>
                    <?
                 }
                ?>


                <?
                if ($action=="proxy_edit")
                {
                    ?>
                     <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="profile?action=proxies">Захиалагч</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Засах</a></li>
                        </ol>
                    </nav>

                    <?
                    $user_id = $_SESSION["c_user_id"];
                    if (isset($_GET["id"]))
                    {
                        $proxy_id = $_GET["id"];
                        $sql = "SELECT *FROM proxies WHERE proxy_id='$proxy_id' AND customer_id='$user_id' LIMIT 1";
                        $result = mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)==1)
                        {
                            $data = mysqli_fetch_array($result);
                            $name = $data["name"];
                            $surname = $data["surname"];
                            $tel = $data["tel"];

                            $city = $data["city"];
                            $district = $data["district"];
                            $khoroo = $data["khoroo"];
                            $build =$data["build"];
                            $address =$data["address"];
                            $status = $data["status"];
                            if ($status==0)
                            {
                                $sql_order_check = "SELECT order_id FROM orders WHERE receiver='$user_id' AND proxy_id='$proxy_id' AND proxy_type=0 AND status NOT IN ('delivered')";
                               // echo $sql_order_check;
                                $result_order_check = mysqli_query($conn,$sql_order_check);
                                if (mysqli_num_rows($result_order_check)==0)
                                {
                                    ?>
                                    <div class="row layout-spacing">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Захиалагч мэдээлэл засах</h5>
                                                        <?
                                                            if (isset($_POST["id"]))
                                                            {
                                                                $new_name = protect($_POST["name"]);
                                                                $new_surname = protect($_POST["surname"]);
                                                                $new_tel = protect($_POST["tel"]);
                                                                $new_city = protect($_POST["city"]);
                                                                $new_district = protect($_POST["district"]);
                                                                $new_khoroo = protect($_POST["khoroo"]);
                                                                $new_build =protect($_POST["build"]);
                                                                $new_address =protect($_POST["address"]);
                                                                $sql = "UPDATE proxies SET name='$new_name',surname='$new_surname',tel='$new_tel',city='$new_city',district='$new_district',khoroo='$new_khoroo',build='$new_build',address='$new_address' WHERE customer_id='$user_id' AND proxy_id='$proxy_id' LIMIT 1";
                                                                if (mysqli_query($conn,$sql))
                                                                {
                                                                    ?>
                                                                    <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                                        Амжилттай заслаа
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
                                                            ?>  
                                                            <?
                                                            $sql = "SELECT *FROM proxies WHERE proxy_id='$proxy_id' AND customer_id='$user_id' LIMIT 1";
                                                            $result = mysqli_query($conn,$sql);
                                                            $data = mysqli_fetch_array($result);
                                                            $name = $data["name"];
                                                            $surname = $data["surname"];
                                                            $tel = $data["tel"];                            
                                                            $city = $data["city"];
                                                            $district = $data["district"];
                                                            $khoroo = $data["khoroo"];
                                                            $build =$data["build"];
                                                            $address =$data["address"];
                                                            $status = $data["status"];
    
                                                            ?>
                                                            <form action="profile?action=proxy_edit&id=<?=$proxy_id;?>" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="id" value="<?=$proxy_id;?>">
                                                                <div class="form-group">
                                                                    <label for="surname">Овог</label>
                                                                    <input type="text" class="form-control" id="surname" placeholder="Овог" name="surname" value="<?=$surname;?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="name">Нэр</label>
                                                                    <input type="text" class="form-control" id="name" placeholder="Нэр" name="name" value="<?=$name;?>">
                                                                </div>
    
                                                                <div class="form-group">
                                                                    <label for="name">Утас</label>
                                                                    <input type="text" class="form-control" id="tel" placeholder="Утас" name="tel" value="<?=$tel;?>">
                                                                </div>
    
                                                                <div class="form-group">
                                                                    <label for="city">Хот</label>
                                                                    <select name="city" class="form-control" id="city">
                                                                        <?
                                                                        $sql =  "SELECT *FROM city";
                                                                        $result = mysqli_query($conn,$sql);
                                                                        while ($data = mysqli_fetch_array($result))
                                                                        {
                                                                            ?>
                                                                            <option value="<?=$data["id"];?>" <?=($data["id"]==$city)?'SELECTED="SELECTED"':'';?>><?=$data["name"];?></option>
                                                                            <?
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="surname">Дүүрэг</label>
                                                                        <select name="district" class="form-control" id="district">
                                                                            <?
                                                                            $sql =  "SELECT *FROM district";
                                                                            $result = mysqli_query($conn,$sql);					
                                                                            while ($data = mysqli_fetch_array($result))
                                                                            {
                                                                                ?>
                                                                                <option value="<?=$data["id"];?>" data-chained="<?=$data["city_id"];?>" <?=($data["id"]==$district)?'SELECTED="SELECTED"':'';?>><?=$data["name"];?></option>
                                                                                <?
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="khoroo">Баг, хороо</label>
                                                                    <input type="text" class="form-control" id="khoroo" placeholder="Баг, хороо" name="khoroo" value="<?=$khoroo;?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="build">Байр, гудамж</label>
                                                                    <input type="text" class="form-control" id="build" placeholder="Байр, гудамж" name="build" value="<?=$build;?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="address">Хаяг</label>
                                                                    <input type="text" class="form-control" id="address" placeholder="Хаягны нэмэлт мэдээлэл" name="address" value="<?=$address;?>">
                                                                </div>
    
                                                                <input type="submit" class="btn btn-primary" value="Хадгалах">
                                                            </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                }
                                else header("location:profile?action=proxies&alert=proxy_id_use2");
                                
                            }
                            else header("location:profile?action=proxies&alert=proxy_id_use");
                            
                        }
                        else 
                        header("location:profile?action=proxies");
                    }
                    else
                    header("location:profile?action=proxies");
                }
                ?>

                <?
                if ($action=="proxy_add")
                {
                    $user_id = $_SESSION["c_user_id"];
                   ?>

                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="profile?action=proxies">Захиалагч</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Нэмэх</a></li>
                        </ol>
                    </nav>

                    
                    <div class="row layout-spacing">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 layout-top-spacing">
                        
                            <?
                            if (isset($_GET["msg"]))
                            {
                                ?>
                                <div class="alert alert-arrow-left alert-icon-left alert-light-primary mb-4" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                <?=($_GET["msg"]=='no_address')?"Үндсэн хаяг хүргэлтийн хаяг тохируулаагүй тул хүргэлтийн хаяг бүртгэн хадгална уу. Баярлалаа":"";?>
                                </div>
                                <?
                            }
                            ?>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Хувийн мэдээлэл засах</h5>
                                    <?
                                     if (isset($_POST["city"]))
                                     {
                                        $new_name = protect($_POST["name"]);
                                        $new_surname = protect($_POST["surname"]);
                                        $new_tel = protect($_POST["tel"]);
                                        $new_city = protect($_POST["city"]);
                                        $new_district = protect($_POST["district"]);
                                        $new_khoroo = protect($_POST["khoroo"]);
                                        $new_build =protect($_POST["build"]);
                                        $new_address =protect($_POST["address"]);
                                        $sql = "INSERT INTO proxies (customer_id,name,surname,tel,city,district,khoroo,build,address) 
                                        VALUES ('$user_id','$new_name','$new_surname','$new_tel','$new_city','$new_district','$new_khoroo','$new_build','$new_address')";
                                         if (mysqli_query($conn,$sql))
                                         {
                                             $proxy_id = mysqli_insert_id($conn);
                                            
                                             ?>
                                             <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                 Амжилттай нэмлээ
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
                                     ?>
                                    <form action="profile?action=proxy_add" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="surname">Овог</label>
                                            <input type="text" class="form-control" id="surname" placeholder="Овог" name="surname" value="<?=$surname;?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Нэр</label>
                                            <input type="text" class="form-control" id="name" placeholder="Нэр" name="name" value="<?=$name;?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Утас</label>
                                            <input type="text" class="form-control" id="tel" placeholder="Утас" name="tel" value="<?=$tel;?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="city">Хот</label>
                                            <select name="city" class="form-control" id="city">
                                                <?
                                                $sql =  "SELECT *FROM city";
                                                $result = mysqli_query($conn,$sql);
                                                while ($data = mysqli_fetch_array($result))
                                                {
                                                    ?>
                                                    <option value="<?=$data["id"];?>" <?=($data["id"]==$city)?'SELECTED="SELECTED"':'';?>><?=$data["name"];?></option>
                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="surname">Дүүрэг</label>
                                                <select name="district" class="form-control" id="district">
                                                    <?
                                                    $sql =  "SELECT *FROM district";
                                                    $result = mysqli_query($conn,$sql);					
                                                    while ($data = mysqli_fetch_array($result))
                                                    {
                                                        ?>
                                                        <option value="<?=$data["id"];?>" data-chained="<?=$data["city_id"];?>" <?=($data["id"]==$district)?'SELECTED="SELECTED"':'';?>><?=$data["name"];?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="khoroo">Баг, хороо</label>
                                            <input type="text" class="form-control" id="khoroo" placeholder="Баг, хороо" name="khoroo" value="<?=$khoroo;?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="build">Байр, гудамж</label>
                                            <input type="text" class="form-control" id="build" placeholder="Байр, гудамж" name="build" value="<?=$build;?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Хаяг</label>
                                            <input type="text" class="form-control" id="address" placeholder="Хаягны нэмэлт мэдээлэл" name="address" value="<?=$address;?>" required>
                                        </div>

                                        <input type="submit" class="btn btn-primary" value="Хадгалах">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?
                }
                ?>

              
                <?
                if ($action=="proxy_delete")
                {
                    $user_id = $_SESSION["c_user_id"];
                    $proxy_id = protect($_GET["id"]);
                    $sql = "SELECT *FROM proxies WHERE customer_id='$user_id' AND proxy_id='$proxy_id'";
                    $result = mysqli_query($conn,$sql);
                    $data = mysqli_fetch_array($result);
                    if ($data["status"]==0)
                        {
                            $sql_order_check = "SELECT order_id FROM orders WHERE receiver='$user_id' AND proxy_id='$proxy_id' AND proxy_type=0 AND status NOT IN ('delivered')";
                               // echo $sql_order_check;
                                $result_order_check = mysqli_query($conn,$sql_order_check);
                                if (mysqli_num_rows($result_order_check)==0)
                                {
                                    $sql = "DELETE FROM proxies WHERE customer_id='$user_id' AND proxy_id='$proxy_id' LIMIT 1";
                                    mysqli_query($conn,$sql);  
                                    header("location:profile?action=proxies");
                                }
                                else
                                header("location:profile?action=proxies&alert=proxy_in_use2");


                        }
                    if ($data["status"]==1)
                        {
                            header("location:profile?action=proxies&alert=proxy_in_use");
                        }

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
    <script src="plugins/file-upload/file-upload-with-preview.min.js"></script>
    <script src="plugins/table/datatable/datatables.js"></script>
    <script src="plugins/sweetalerts/sweetalert2.min.js"></script>
    <script src="plugins/sweetalerts/custom-sweetalert.js"></script>

    <script>
        //First upload
        var firstUpload = new FileUploadWithPreview('myFirstImage')
    </script>


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
            "lengthMenu": [50,200],
            "pageLength": 50
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.confirm').on('click', function () {
                var id = $(this).attr('alt');
            swal({
                title: 'Таны захиалагчийг устгахад итгэлтэй байна?',
                text: "Таны захиалагчийн нэр дээр ачаа ирж буй үед устгах боломжтойгүйг анхаарна уу!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Устгах',
                padding: '2em'
                }).then(function(result) {
                if (result.value) {
                    window.location.href = "profile?action=proxy_delete&id="+id;
                    }
                })
            })
        });
    </script>
    
    <!-- END PAGE LEVEL SCRIPTS -->
</body>
</html>