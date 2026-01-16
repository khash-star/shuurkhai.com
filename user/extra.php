<? require_once("config.php");?>
<? require_once("views/helper.php");?>
<? require_once("views/login_check.php");?>
<? require_once("views/init.php");?>

<link href="assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="assets/css/elements/alert.css">
<link href="assets/css/elements/breadcrumb.css" rel="stylesheet" type="text/css" />
<link href="assets/css/components/tabs-accordian/custom-accordions.css" rel="stylesheet" type="text/css" />
<link href="assets/css/pages/contact_us.css" rel="stylesheet" type="text/css" />



<body class="sidebar-noneoverflow">
    
    <? require_once("views/navbar.php");?>



    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <? require_once("views/sidebar.php");?>


        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <? if (isset($_GET["action"])) $action=$_GET["action"]; else $action="contact"; ?>

                <?
                if ($action=="contact")
                {
                    
                    if (isset($_POST["title"]))
                    {
                        $user_id = $_SESSION["c_user_id"];
                        $name = customer($user_id,"full_name");
                        $tel = customer($user_id,"tel");
                        $email = customer($user_id,"email");
                        $title =mysqli_escape_string($conn,protect($_POST["title"]));
                        $content = mysqli_escape_string($conn,protect($_POST["content"]));
                        $sql = "INSERT INTO feedback (title,content,name,contact,email) VALUE ('$title','$content','$name','$tel','$email')";
                        if (mysqli_query($conn,$sql))
                            {
                                ?>
                                <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                    Амжилттай илгээлээ
                                </div>
                                <?
                            }
                            else 
                            {
                                ?>
                                <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                    Алдаа гарлаа: <?=mysqli_error($conn);?>
                                </div>
                                <?
                            }
                    }
                    ?>
                    <div class="contact-us">
                        <div class="cu-contact-section">                           
                            <div class="contact-form">
                                <form action="extra?action=contact" method="post">
                                    <h4>Send us a Message</h4>
                                    <div class="row">
                                        <div class="col-sm-12 col-12 input-fields mb-4 mb-sm-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            <input type="text" class="form-control" placeholder="Гарчиг" name="title" required>
                                        </div>
                                    </div>
                                    

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group input-fields">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="6" placeholder="Зурвас" name="content" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-sm-left text-center">
                                            <input type="submit" class="btn btn-primary btn-block text-center" value="Илгээх">
                                        </div>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                   <?
                }
                ?>

                <?
                if ($action=="faqs")
                {
                    $user_id = $_SESSION["c_user_id"];
                    
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="extra">Нэмэлт</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Түгээмэл асуулт</a></li>
                        </ol>
                    </nav>

                    <div class="row layout-spacing">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                            <div id="toggleAccordion">
                                <?
                                    $sql = "SELECT *FROM faqs ORDER BY dd";
                                    $result =mysqli_query($conn,$sql);
                                    while ($data = mysqli_fetch_array($result))
                                    {
                                        ?> 
                                        <div class="card">
                                            <div class="card-header">
                                                <section class="mb-0 mt-0">
                                                    <div role="menu" class="collapsed" data-toggle="collapse" data-target="#faqs_<?=$data["faqs_id"];?>" aria-expanded="true" aria-controls="faqs_<?=$data["faqs_id"];?>">
                                                        <?=$data["question"];?>
                                                    </div>
                                                </section>
                                            </div>

                                            <div id="faqs_<?=$data["faqs_id"];?>" class="collapse" aria-labelledby="..." data-parent="#toggleAccordion">
                                                <div class="card-body">
                                                    <?=$data["answer"];?>
                                                </div>
                                            </div>
                                        </div>

                                        <?
                                    }
                                    ?>
                            </div>   
                        </div>                                
                    </div>
                    <?
                }
                ?>

                <?
                if ($action=="privacy")
                {
                    $user_id = $_SESSION["c_user_id"];
                    
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="extra">Нэмэлт</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Нууцлалын бодлого</a></li>
                        </ol>
                    </nav>

                    <div class="row layout-spacing">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                            <div class="card">
                                <div class="card-body">                                    
                                    <?
                                    $sql = "SELECT *FROM pages WHERE page_id=16";
                                    $result =mysqli_query($conn,$sql);
                                    $data = mysqli_fetch_array($result);
                                    $page_title = $data["title"];
                                    $page_content = $data["content"];
                                    $update_date = $data["update_date"];
                                    ?>
                                    <h5><?=$page_title;?></h5>
                                    <p><?=$page_content;?></p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <?
                }
                ?>


                <?
                if ($action=="report")
                {
                    
                    if (isset($_POST["description"]))
                    {
                        $user_id = $_SESSION["c_user_id"];
                        $description =mysqli_escape_string($conn,protect($_POST["description"]));
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
                                        $image = $target_file;
                                    }
                                }
                        }

                        $sql = "INSERT INTO issues (description,customer_id,image) VALUE ('$description','$user_id','$image')";
                        if (mysqli_query($conn,$sql))
                            {
                                ?>
                                <div class="alert alert-arrow-left alert-icon-left alert-light-success mb-4" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                    Амжилттай илгээлээ
                                </div>
                                <?
                            }
                            else 
                            {
                                ?>
                                <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                    Алдаа гарлаа: <?=mysqli_error($conn);?>
                                </div>
                                <?
                            }
                    }
                    ?>
                    <div class="contact-us">
                        <div class="cu-contact-section">                           
                            <div class="contact-form">
                                <form action="extra?action=report" method="post" enctype="multipart/form-data">
                                    <h4>Алдааг мэдээлэх</h4>
                                    
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group input-fields">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                                <input type="file" name="image" class="form-control" accept="image/*">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group input-fields">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="6" placeholder="Алдаа хэрхэн гарсан талаар" name="description" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-sm-left text-center">
                                            <input type="submit" class="btn btn-primary btn-block text-center" value="Илгээх">
                                        </div>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                   <?
                }
                ?>

                <?
                if ($action=="collaboration")
                {
                    $user_id = $_SESSION["c_user_id"];
                    
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="extra">Нэмэлт</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Нууцлалын бодлого</a></li>
                        </ol>
                    </nav>

                    <div class="row layout-spacing">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                            <div class="card">
                                <div class="card-body">                                    
                                    <?
                                    $sql = "SELECT *FROM pages WHERE page_id=17";
                                    $result =mysqli_query($conn,$sql);
                                    $data = mysqli_fetch_array($result);
                                    $page_title = $data["title"];
                                    $page_content = $data["content"];
                                    $update_date = $data["update_date"];
                                    ?>
                                    <h5><?=$page_title;?></h5>
                                    <p><?=$page_content;?></p>
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
    <script src="assets/js/app.js"></script>

    <script>
        $(document).ready(function() {
            App.init();

        });
    </script>
    <script src="plugins/highlight/highlight.pack.js"></script>
    <script src="assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="assets/js/scrollspyNav.js"></script>

    <!-- BEGIN PAGE LEVEL SCRIPTS -->


</body>
</html>