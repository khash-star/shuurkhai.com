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

                <?php
                if ($action=="contact")
                {
                    
                    if (isset($_POST["content"]) && !empty(trim($_POST["content"])))
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
                            $title_escaped = mysqli_real_escape_string($conn, 'Зурвас'); // Default title
                            $content_escaped = mysqli_real_escape_string($conn, protect(trim($_POST["content"])));
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
                                <?php
                            }
                            else 
                            {
                                ?>
                                <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                    Алдаа гарлаа: <?php echo (isset($conn) && $conn) ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error'; ?>
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
                                Database холболт алдаатай байна.
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="contact-us">
                        <div class="cu-contact-section">                           
                            <div class="contact-form">
                                <form action="extra?action=contact" method="post">
                                    <h4>Send us a Message</h4>
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
                    
                    <!-- Messages History (All Messages) -->
                    <?php
                    // Get user phone number for matching messages
                    $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
                    $user_tel = isset($_SESSION["c_tel"]) ? trim($_SESSION["c_tel"]) : '';
                    
                    if (empty($user_tel) && isset($conn) && $conn && $user_id > 0) {
                        $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                        $tel_sql = "SELECT tel FROM customer WHERE customer_id='".$user_id_escaped."' LIMIT 1";
                        $tel_result = mysqli_query($conn, $tel_sql);
                        if ($tel_result !== false && $tel_data = mysqli_fetch_array($tel_result)) {
                            $user_tel = isset($tel_data["tel"]) && !empty($tel_data["tel"]) ? trim($tel_data["tel"]) : '';
                        }
                    }
                    
                    // Check if role column exists
                    $check_role_sql = "SHOW COLUMNS FROM feedback LIKE 'role'";
                    $role_exists = false;
                    $check_result = mysqli_query($conn, $check_role_sql);
                    if ($check_result && mysqli_num_rows($check_result) > 0) {
                        $role_exists = true;
                    }
                    
                    // Get all messages for this user (by contact/phone number)
                    if (!empty($user_tel) && isset($conn) && $conn) {
                        $user_tel_escaped = mysqli_real_escape_string($conn, $user_tel);
                        
                        if ($role_exists) {
                            // Get all messages (user messages and admin replies) for this contact
                            $messages_sql = "SELECT * FROM feedback WHERE contact='".$user_tel_escaped."' AND archive=0 ORDER BY timestamp ASC";
                        } else {
                            // Fallback: get messages by contact only (role column doesn't exist)
                            $messages_sql = "SELECT * FROM feedback WHERE contact='".$user_tel_escaped."' AND archive=0 ORDER BY timestamp ASC";
                        }
                        
                        $messages_result = mysqli_query($conn, $messages_sql);
                        ?>
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">Бүх мессежүүд</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="chat-messages" style="max-height: 600px; overflow-y: auto; padding: 20px; background: #fafafa; border-radius: 8px;">
                                            <?php
                                            if ($messages_result && mysqli_num_rows($messages_result) > 0) {
                                                while ($msg_data = mysqli_fetch_array($messages_result)) {
                                                    if (!$msg_data) continue;
                                                    
                                                    $msg_id = isset($msg_data["id"]) ? intval($msg_data["id"]) : 0;
                                                    $msg_title = isset($msg_data["title"]) ? htmlspecialchars($msg_data["title"]) : '';
                                                    $msg_content = isset($msg_data["content"]) ? htmlspecialchars($msg_data["content"]) : '';
                                                    $msg_read = isset($msg_data["read"]) ? intval($msg_data["read"]) : 0;
                                                    $msg_name = isset($msg_data["name"]) ? htmlspecialchars($msg_data["name"]) : '';
                                                    $msg_contact = isset($msg_data["contact"]) ? htmlspecialchars($msg_data["contact"]) : '';
                                                    $msg_timestamp = isset($msg_data["timestamp"]) ? htmlspecialchars($msg_data["timestamp"]) : '';
                                                    
                                                    // Determine if this is an admin reply
                                                    $msg_role = "user";
                                                    if ($role_exists && isset($msg_data["role"]) && !empty($msg_data["role"])) {
                                                        $msg_role = htmlspecialchars($msg_data["role"]);
                                                    }
                                                    
                                                    $is_admin_msg = ($msg_role == "admin");
                                                    
                                                    // Fallback: if role column doesn't exist, check by name or title patterns
                                                    if (!$is_admin_msg && (!$role_exists || empty($msg_data["role"]))) {
                                                        // Check if name contains "admin" or title is "Re: Admin Reply"
                                                        $name_lower = strtolower($msg_name);
                                                        $title_lower = strtolower($msg_title);
                                                        if (strpos($name_lower, 'admin') !== false || 
                                                            $title_lower == 're: admin reply' || 
                                                            strpos($title_lower, 'admin reply') !== false) {
                                                            $is_admin_msg = true;
                                                        }
                                                    }
                                                    
                                                    // Styling based on role
                                                    if ($is_admin_msg) {
                                                        $bg_style = "background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border-left: 4px solid #2196F3; margin-left: 20%; box-shadow: 0 2px 8px rgba(33, 150, 243, 0.2);";
                                                    } else {
                                                        $bg_style = "background: linear-gradient(135deg, #f5f5f5 0%, #e8f5e9 100%); border-left: 4px solid #4CAF50; margin-right: 20%; box-shadow: 0 2px 8px rgba(76, 175, 80, 0.2);";
                                                    }
                                                    
                                                    // Unread indicator
                                                    $unread_style = ($msg_read == 0 && $is_admin_msg) ? "border-top: 3px solid #ff9800;" : "";
                                                    ?>
                                                    <div class="message-item mb-3" style="<?php echo $bg_style; ?> <?php echo $unread_style; ?> padding: 15px; border-radius: 12px; margin-bottom: 15px;">
                                                        <div style="<?php echo $is_admin_msg ? 'text-right' : 'text-left'; ?>">
                                                            <span class="badge <?php echo $is_admin_msg ? 'badge-danger' : 'badge-primary'; ?> mb-2">
                                                                <?php echo $is_admin_msg ? 'АДМИН' : ($msg_contact ? $msg_contact : 'ХЭРЭГЛЭГЧ'); ?>
                                                            </span>
                                                            <div style="margin-bottom: 8px;">
                                                                <strong><?php echo $is_admin_msg ? 'Админ' : ($msg_contact ? $msg_contact : $msg_name); ?></strong>
                                                                <small class="text-muted ml-2"><?php echo date("Y-m-d H:i", strtotime($msg_timestamp)); ?></small>
                                                            </div>
                                                            <?php if (!empty($msg_title) && $msg_title != "Re: Admin Reply"): ?>
                                                            <div style="font-weight: 600; margin-bottom: 5px; color: #333;">
                                                                <?php echo $msg_title; ?>
                                                            </div>
                                                            <?php endif; ?>
                                                            <div style="color: #555; line-height: 1.5;">
                                                                <?php echo nl2br($msg_content); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <div class="alert alert-info" role="alert" style="text-align: center;">
                                                    Мессеж байхгүй байна.
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                        // Auto-scroll to bottom on load
                        document.addEventListener('DOMContentLoaded', function() {
                            const chatContainer = document.querySelector('.chat-messages');
                            if (chatContainer) {
                                chatContainer.scrollTop = chatContainer.scrollHeight;
                            }
                        });
                        </script>
                        <?php
                    }
                    ?>
                   <?php
                }
                ?>

                <?php
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
                                <?php
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

                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                    ?>
                            </div>   
                        </div>                                
                    </div>
                    <?php
                }
                ?>

                <?php
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
                    <?php
                }
                ?>


                <?php
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
                                <?php
                            }
                            else 
                            {
                                ?>
                                <div class="alert alert-arrow-left alert-icon-left alert-light-danger mb-4" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                    Алдаа гарлаа: <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error'; ?>
                                </div>
                                <?php
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
                   <?php
                }
                ?>

                <?php
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
            
            // Fix notification dropdown position to show below the bell icon
            $('#notificationDropdown').on('show.bs.dropdown', function() {
                var $dropdown = $(this).next('.dropdown-menu');
                $dropdown.css({
                    'position': 'absolute',
                    'top': '100%',
                    'right': '0',
                    'left': 'auto',
                    'margin-top': '0',
                    'transform': 'none'
                });
            });
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