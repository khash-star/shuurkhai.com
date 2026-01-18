<?php require_once("config.php");?>
<?php require_once("views/helper.php");?>
<?php require_once("views/login_check.php");?>
<?php require_once("views/init.php");?>

<link href="assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="assets/css/elements/alert.css">
<link href="assets/css/elements/breadcrumb.css" rel="stylesheet" type="text/css" />
<link href="assets/css/components/tabs-accordian/custom-accordions.css" rel="stylesheet" type="text/css" />
<link href="assets/css/pages/contact_us.css" rel="stylesheet" type="text/css" />



<body class="sidebar-noneoverflow">
    
    <?php require_once("views/navbar.php");?>



    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <?php require_once("views/sidebar.php");?>


        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <?php if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="contact"; ?>

                <?
                if ($action=="contact")
                {
                    
                    if (isset($_POST["title"]) && isset($_POST["content"]) && !empty(trim($_POST["title"])) && !empty(trim($_POST["content"])))
                    {
                        // Хэрэглэгчийн мэдээлэл авах
                        $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                        $name = '';
                        $tel = '';
                        $email = '';
                        
                        if ($user_id > 0) {
                            $name = customer($user_id, "full_name");
                            $tel = customer($user_id, "tel");
                            $email = customer($user_id, "email");
                        }
                        
                        // Хэрэв мэдээлэл байхгүй бол default утга ашиглах
                        if (empty($name)) {
                            $name = 'Хэрэглэгч';
                        }
                        if (empty($tel)) {
                            $tel = '-';
                        }
                        if (empty($email)) {
                            $email = 'email@example.com';
                        }
                        
                        // SQL injection хамгаалалт
                        if (isset($conn) && $conn) {
                            $title = mysqli_real_escape_string($conn, protect(trim($_POST["title"])));
                            $content = mysqli_real_escape_string($conn, protect(trim($_POST["content"])));
                            $name_escaped = mysqli_real_escape_string($conn, $name);
                            $tel_escaped = mysqli_real_escape_string($conn, $tel);
                            $email_escaped = mysqli_real_escape_string($conn, $email);
                            
                            // Check if role column exists (backward compatibility)
                            $check_role_sql = "SHOW COLUMNS FROM feedback LIKE 'role'";
                            $role_exists = false;
                            $check_result = mysqli_query($conn, $check_role_sql);
                            if ($check_result && mysqli_num_rows($check_result) > 0) {
                              $role_exists = true;
                            }
                            
                            // Зурвасыг хадгалах - archive=0 (идэвхитэй), read=0 (уншаагүй), role='user' (if column exists)
                            // read талбар нь MySQL reserved keyword тул backtick ашиглах
                            if ($role_exists) {
                              $sql = "INSERT INTO feedback (title, content, name, contact, email, archive, `read`, role, timestamp) VALUES ('$title_escaped', '$content_escaped', '$name_escaped', '$tel_escaped', '$email_escaped', 0, 0, 'user', NOW())";
                            } else {
                              $sql = "INSERT INTO feedback (title, content, name, contact, email, archive, `read`, timestamp) VALUES ('$title_escaped', '$content_escaped', '$name_escaped', '$tel_escaped', '$email_escaped', 0, 0, NOW())";
                            }
                            
                            if (mysqli_query($conn, $sql))
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
                                    Алдаа гарлаа: <?php echo (isset($conn) && $conn) ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error'; ?>
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
                                Database холболт алдаатай байна.
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
                                    if (isset($conn) && $conn) {
                                        $sql = "SELECT *FROM faqs ORDER BY dd";
                                        $result = mysqli_query($conn,$sql);
                                        if ($result) {
                                            while ($data = mysqli_fetch_array($result))
                                            {
                                                if (is_array($data) && isset($data["question"]) && isset($data["faqs_id"])) {
                                                    // Initialize variables with safe defaults
                                                    $question = '';
                                                    $faqs_id = '0';
                                                    
                                                    if (isset($data["question"]) && $data["question"] !== null) {
                                                        $question = (string)$data["question"];
                                                    }
                                                    if (isset($data["faqs_id"]) && $data["faqs_id"] !== null) {
                                                        $faqs_id = (string)$data["faqs_id"];
                                                    }
                                                    
                                                    // Ensure they are strings (redundant but safe)
                                                    $question = is_string($question) ? $question : (string)$question;
                                                    $faqs_id = is_string($faqs_id) ? $faqs_id : (string)$faqs_id;
                                                ?> 
                                                <div class="card">
                                                    <div class="card-header">
                                                        <section class="mb-0 mt-0">
                                                            <?php 
                                                            // Ensure variables are defined and strings before use
                                                            $display_question = isset($question) && is_string($question) ? $question : '';
                                                            $display_faqs_id = isset($faqs_id) && is_string($faqs_id) ? $faqs_id : '0';
                                                            ?>
                                                            <div role="menu" class="collapsed" data-toggle="collapse" data-target="#faqs_<?php echo htmlspecialchars($display_faqs_id, ENT_QUOTES, 'UTF-8'); ?>" aria-expanded="true" aria-controls="faqs_<?php echo htmlspecialchars($display_faqs_id, ENT_QUOTES, 'UTF-8'); ?>">
                                                                <?php echo htmlspecialchars($display_question, ENT_QUOTES, 'UTF-8'); ?>
                                                            </div>
                                                        </section>
                                                    </div>

                                                    <div id="faqs_<?php echo htmlspecialchars($faqs_id, ENT_QUOTES, 'UTF-8'); ?>" class="collapse" aria-labelledby="..." data-parent="#toggleAccordion">
                                                        <div class="card-body">
                                                            <?php echo isset($data["answer"]) && $data["answer"] !== null ? htmlspecialchars((string)$data["answer"], ENT_QUOTES, 'UTF-8') : ''; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                    <?
                                                }
                                            }
                                        }
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
                                    <?php
                                    $page_title = '';
                                    $page_content = '';
                                    if (isset($conn) && $conn) {
                                        $sql = "SELECT *FROM pages WHERE page_id=16";
                                        $result = mysqli_query($conn,$sql);
                                        if ($result) {
                                            $data = mysqli_fetch_array($result);
                                            if (is_array($data)) {
                                                $page_title = isset($data["title"]) ? $data["title"] : '';
                                                $page_content = isset($data["content"]) ? $data["content"] : '';
                                            }
                                        }
                                    }
                                    ?>
                                    <h5><?php echo htmlspecialchars($page_title); ?></h5>
                                    <p><?php echo htmlspecialchars($page_content); ?></p>
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
                                    Алдаа гарлаа: <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error'; ?>
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
                                    <?php
                                    $page_title = '';
                                    $page_content = '';
                                    if (isset($conn) && $conn) {
                                        $sql = "SELECT *FROM pages WHERE page_id=17";
                                        $result = mysqli_query($conn,$sql);
                                        if ($result) {
                                            $data = mysqli_fetch_array($result);
                                            if (is_array($data)) {
                                                $page_title = isset($data["title"]) ? $data["title"] : '';
                                                $page_content = isset($data["content"]) ? $data["content"] : '';
                                            }
                                        }
                                    }
                                    ?>
                                    <h5><?php echo htmlspecialchars($page_title); ?></h5>
                                    <p><?php echo htmlspecialchars($page_content); ?></p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <?
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