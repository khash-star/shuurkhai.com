 <?php
 $user_id = isset($_SESSION["c_user_id"]) ? intval($_SESSION["c_user_id"]) : 0;
 $user_name  = isset($_SESSION["c_name"]) ? htmlspecialchars($_SESSION["c_name"]) : '';
 $user_avatar  = isset($_SESSION["c_avatar"]) ? htmlspecialchars($_SESSION["c_avatar"]) : '';
 $user_tel  = isset($_SESSION["c_tel"]) ? htmlspecialchars($_SESSION["c_tel"]) : '';
 
 if ($user_avatar=='') $user_avatar='assets/img/user-male.png';
 
 $current_page = isset($_SERVER['REQUEST_URI']) ? htmlspecialchars($_SERVER['REQUEST_URI']) : '';

 ?>
 <!--  BEGIN NAVBAR  -->
 <div class="header-container fixed-top" style="z-index: 1030;">
        <!-- Google Translate - Top Bar -->
        <div style="background: #fff; padding: 5px 15px; display: flex; justify-content: flex-end; align-items: center; border-bottom: 1px solid #e0e0e0;">
            <div id="google_translate_element" style="display: inline-block; vertical-align: middle; min-width: 100px;"></div>
        </div>
        <header class="header navbar navbar-expand-sm">
            <ul class="navbar-item flex-row">
                <li class="nav-item align-self-center page-heading">
                    <div class="page-header">
                        <div class="page-title">
                            <h3>Шуурхай</h3>
                        </div>
                    </div>
                </li>
            </ul>
            <!-- Mobile Track Menu (visible only on mobile) -->
            <ul class="navbar-item flex-row d-md-none" style="margin-right: 10px;">
                <li class="nav-item dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="mobileTrackDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 8px 12px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                        <span class="d-none d-sm-inline" style="margin-left: 5px;">Track</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right animated fadeInUp" aria-labelledby="mobileTrackDropdown" style="min-width: 200px;">
                        <a class="dropdown-item" href="tracks?action=insert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle" style="margin-right: 8px;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                            Трак оруулах
                        </a>
                        <a class="dropdown-item" href="tracks">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list" style="margin-right: 8px;"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                            Бүртгэлтэй трак
                        </a>
                    </div>
                </li>
            </ul>
            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg></a>

            <ul class="navbar-item flex-row search-ul">
                <li class="nav-item align-self-center search-animated">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <form class="form-inline search-full form-inline search" role="search" method="POST" action="<?php echo htmlspecialchars($current_page);?>">
                        <div class="search-bar">
                            <input type="text" class="form-control search-form-control  ml-lg-auto" placeholder="Трак, баркод" name="search" value="<?php echo htmlspecialchars((isset($_POST["search"]))?$_POST["search"]:'');?>">
                        </div>
                    </form>
                </li>
            </ul>

            <ul class="navbar-item flex-row navbar-dropdown">
                <!-- <li class="nav-item dropdown language-dropdown more-dropdown">
                    <div class="dropdown  custom-dropdown-icon">
                        <a class="dropdown-toggle btn" href="#" role="button" id="customDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="assets/img/ca.png" class="flag-width" alt="flag"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>

                        <div class="dropdown-menu dropdown-menu-right animated fadeInUp" aria-labelledby="customDropdown">
                            <a class="dropdown-item" data-img-value="de" data-value="German" href="javascript:void(0);"><img src="assets/img/de.png" class="flag-width" alt="flag"> German</a>
                            <a class="dropdown-item" data-img-value="jp" data-value="Japanese" href="javascript:void(0);"><img src="assets/img/jp.png" class="flag-width" alt="flag"> Japanese</a>
                            <a class="dropdown-item" data-img-value="fr" data-value="French" href="javascript:void(0);"><img src="assets/img/fr.png" class="flag-width" alt="flag"> French</a>
                            <a class="dropdown-item" data-img-value="ca" data-value="English" href="javascript:void(0);"><img src="assets/img/ca.png" class="flag-width" alt="flag"> English</a>
                        </div>
                    </div>
                </li> -->
                
                <!-- <li class="nav-item dropdown message-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="messageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg><span class="badge badge-primary"></span>
                    </a>
                    <div class="dropdown-menu position-absolute animated fadeInUp" aria-labelledby="messageDropdown">
                        <div class="">
                            <a class="dropdown-item">
                                <div class="">

                                    <div class="media">
                                        <div class="user-img">
                                            <div class="avatar avatar-xl">
                                                <span class="avatar-title rounded-circle">KY</span>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <div class="">
                                                <h5 class="usr-name">Kara Young</h5>
                                                <p class="msg-title">ACCOUNT UPDATE</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </a>
                            <a class="dropdown-item">
                                <div class="">
                                    <div class="media">
                                        <div class="user-img">
                                            <div class="avatar avatar-xl">
                                                <span class="avatar-title rounded-circle">DA</span>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <div class="">
                                                <h5 class="usr-name">Daisy Anderson</h5>
                                                <p class="msg-title">ACCOUNT UPDATE</p>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </a>
                            <a class="dropdown-item">
                                <div class="">

                                    <div class="media">
                                        <div class="user-img">
                                            <div class="avatar avatar-xl">
                                                <span class="avatar-title rounded-circle">OG</span>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <div class="">
                                                <h5 class="usr-name">Oscar Garner</h5>
                                                <p class="msg-title">ACCOUNT UPDATE</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </a>
                        </div>
                    </div>
                </li> -->
                <?php
                $has_alert = 0;
                $recent_feedbacks = array();
                
                if (isset($conn) && $user_id > 0) {
                    $user_id_escaped = mysqli_real_escape_string($conn, $user_id);
                    
                    // Check alerts
                    $sql = "SELECT * FROM alert WHERE customer_id='".$user_id_escaped."' AND `read`=0 ORDER BY alert_id DESC LIMIT 1";
                    $result = mysqli_query($conn,$sql);
                    if ($result) {
                        $has_alert = mysqli_num_rows($result);
                    }
                    
                    // Check for admin replies in feedback (for this user's messages)
                    $check_role_sql = "SHOW COLUMNS FROM feedback LIKE 'role'";
                    $role_exists = false;
                    $check_result = mysqli_query($conn, $check_role_sql);
                    if ($check_result && mysqli_num_rows($check_result) > 0) {
                        $role_exists = true;
                    }
                    
                    // Get user phone number to match feedback (users login with phone number, not email)
                    $user_tel = isset($_SESSION["c_tel"]) ? trim($_SESSION["c_tel"]) : '';
                    if (empty($user_tel) && isset($conn) && $conn && $user_id > 0 && isset($user_id_escaped)) {
                        try {
                            // Try to get tel from customer table (singular, not plural)
                            $tel_sql = "SELECT tel FROM customer WHERE customer_id='".$user_id_escaped."' LIMIT 1";
                            $tel_result = mysqli_query($conn, $tel_sql);
                            if ($tel_result !== false && $tel_data = mysqli_fetch_array($tel_result)) {
                                $user_tel = isset($tel_data["tel"]) && !empty($tel_data["tel"]) ? trim($tel_data["tel"]) : '';
                            }
                        } catch (Exception $e) {
                            // Silently fail if tel query fails
                            $user_tel = '';
                        }
                    }
                    
                    // Count unread admin/agent replies for this user (match by contact/phone number)
                    $admin_replies_count = 0;
                    if (!empty($user_tel)) {
                        $user_tel_escaped = mysqli_real_escape_string($conn, trim($user_tel));
                        
                        // Always try to get recent admin/agent replies first (to populate dropdown)
                        if ($role_exists) {
                            // Get recent admin and agent replies by contact (role='admin' OR role='agent')
                            $recent_sql = "SELECT id, title, content, name, timestamp, `read` FROM feedback WHERE contact='".$user_tel_escaped."' AND (role='admin' OR role='agent') AND archive=0 ORDER BY timestamp DESC LIMIT 5";
                        } else {
                            // Fallback: check by admin name patterns or title patterns
                            $recent_sql = "SELECT id, title, content, name, timestamp, `read` FROM feedback WHERE contact='".$user_tel_escaped."' AND archive=0 AND (name LIKE '%admin%' OR name LIKE '%Admin%' OR title LIKE '%Admin Reply%' OR title LIKE '%Re:%' OR title LIKE '%Agent Reply%') ORDER BY timestamp DESC LIMIT 5";
                        }
                        
                        $recent_result = @mysqli_query($conn, $recent_sql);
                        if ($recent_result) {
                            while ($recent_data = mysqli_fetch_array($recent_result)) {
                                $recent_feedbacks[] = $recent_data;
                                // Count unread replies
                                if (isset($recent_data["read"]) && intval($recent_data["read"]) == 0) {
                                    $admin_replies_count++;
                                }
                            }
                        }
                        
                        // Also get count of unread admin/agent replies
                        if ($role_exists) {
                            $feedback_sql = "SELECT COUNT(*) as count FROM feedback WHERE contact='".$user_tel_escaped."' AND (role='admin' OR role='agent') AND archive=0 AND `read`=0";
                        } else {
                            $feedback_sql = "SELECT COUNT(*) as count FROM feedback WHERE contact='".$user_tel_escaped."' AND archive=0 AND `read`=0 AND (name LIKE '%admin%' OR name LIKE '%Admin%' OR title LIKE '%Admin Reply%' OR title LIKE '%Re:%' OR title LIKE '%Agent Reply%')";
                        }
                        
                        $feedback_result = @mysqli_query($conn, $feedback_sql);
                        if ($feedback_result && $feedback_row = mysqli_fetch_array($feedback_result)) {
                            $admin_replies_count_db = isset($feedback_row["count"]) ? intval($feedback_row["count"]) : 0;
                            // Use the higher count (either from DB or from array)
                            if ($admin_replies_count_db > $admin_replies_count) {
                                $admin_replies_count = $admin_replies_count_db;
                            }
                        }
                        
                        // Update has_alert with admin/agent replies count (only unread messages)
                        // Use the database count directly, not the array count
                        $has_alert = $admin_replies_count;
                    }
                }
                ?>
                <li class="nav-item dropdown notification-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle position-relative" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        <?php if ($has_alert > 0): ?>
                        <span class="badge badge-danger position-absolute top-0 start-100 translate-middle" style="font-size: 10px; min-width: 18px; height: 18px; padding: 0 5px; display: flex; align-items: center; justify-content: center; border-radius: 9px; background-color: #dc3545; color: white; font-weight: bold;">
                            <?php echo $has_alert > 99 ? '99+' : $has_alert; ?>
                        </span>
                        <?php endif; ?>
                    </a>
                    <?php
                    if ($has_alert > 0)
                    {
                        ?>
                        <div class="dropdown-menu dropdown-menu-right animated fadeInUp" aria-labelledby="notificationDropdown" style="width: 350px; max-width: 90vw; z-index: 1050;">
                            <div class="dropdown-header" style="padding: 12px 16px; border-bottom: 1px solid #eee; background: #f8f9fa;">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h6 class="mb-0" style="font-weight: 600; font-size: 14px;">Мэдэгдэл</h6>
                                    <?php if ($has_alert > 0): ?>
                                    <span class="badge badge-primary" style="font-size: 11px;"><?php echo $has_alert; ?> Шинэ</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="notification-scroll" style="max-height: 400px; overflow-y: auto;">
                                
                                <?php if (count($recent_feedbacks) > 0): ?>
                                    <?php foreach ($recent_feedbacks as $feedback): ?>
                                        <?php
                                        $feedback_id = isset($feedback["id"]) ? intval($feedback["id"]) : 0;
                                        $feedback_title = isset($feedback["title"]) ? htmlspecialchars($feedback["title"]) : 'Админ-аас хариу';
                                        $feedback_content = isset($feedback["content"]) ? htmlspecialchars($feedback["content"]) : '';
                                        $feedback_name = isset($feedback["name"]) ? htmlspecialchars($feedback["name"]) : 'Админ';
                                        $feedback_timestamp = isset($feedback["timestamp"]) ? htmlspecialchars($feedback["timestamp"]) : '';
                                        
                                        // Time ago
                                        $time_ago = '';
                                        if ($feedback_timestamp) {
                                            $timestamp = strtotime($feedback_timestamp);
                                            $diff = time() - $timestamp;
                                            if ($diff < 3600) {
                                                $time_ago = floor($diff / 60) . ' мин өмнө';
                                            } elseif ($diff < 86400) {
                                                $time_ago = floor($diff / 3600) . ' цаг өмнө';
                                            } else {
                                                $time_ago = date('Y-m-d H:i', $timestamp);
                                            }
                                        }
                                        
                                        // Short content
                                        $short_content = mb_substr($feedback_content, 0, 60, 'UTF-8');
                                        if (mb_strlen($feedback_content, 'UTF-8') > 60) {
                                            $short_content .= '...';
                                        }
                                        ?>
                                        <a href="extra?action=contact" class="dropdown-item" style="padding: 12px 16px; border-bottom: 1px solid #f0f0f0; display: block; text-decoration: none; color: #333;">
                                            <div class="d-flex align-items-start">
                                                <div class="mr-3" style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                                </div>
                                                <div class="flex-grow-1" style="min-width: 0;">
                                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                                        <strong style="font-size: 13px; color: #333;"><?php echo $feedback_name; ?></strong>
                                                        <small class="text-muted" style="font-size: 11px; white-space: nowrap;"><?php echo $time_ago; ?></small>
                                                    </div>
                                                    <p class="mb-0" style="font-size: 12px; color: #666; line-height: 1.4;">
                                                        <?php echo $short_content; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="dropdown-item text-center" style="padding: 40px 20px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle" style="margin-bottom: 12px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                        <p class="mb-0" style="color: #999; font-size: 14px;">Шинэ мэдэгдэл байхгүй</p>
                                    </div>
                                <?php endif; ?>
                                
                            </div>
                            <?php if ($has_alert > 0 && count($recent_feedbacks) > 0): ?>
                            <div class="dropdown-footer text-center" style="padding: 12px; border-top: 1px solid #eee; background: #f8f9fa;">
                                <a href="extra?action=contact" style="color: #5e72e4; text-decoration: none; font-weight: 500; font-size: 13px;">
                                    Бүх мессежийг харах →
                                </a>
                            </div>
                            <?php endif; ?>

                                <!-- <div class="dropdown-item">
                                    <div class="media server-log">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6" y2="6"></line><line x1="6" y1="18" x2="6" y2="18"></line></svg>
                                        <div class="media-body">
                                            <div class="data-info">
                                                <h6 class="">Server Rebooted</h6>
                                                <p class="">45 min ago</p>
                                            </div>

                                            <div class="icon-status">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="dropdown-item">
                                    <div class="media ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                        <div class="media-body">
                                            <div class="data-info">
                                                <h6 class="">Licence Expiring Soon</h6>
                                                <p class="">8 hrs ago</p>
                                            </div>

                                            <div class="icon-status">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="dropdown-item">
                                    <div class="media file-upload">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                        <div class="media-body">
                                            <div class="data-info">
                                                <h6 class="">Kelly Portfolio.pdf</h6>
                                                <p class="">670 kb</p>
                                            </div>

                                            <div class="icon-status">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    
                </li>

                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1" title="Хувийн тохиргоо">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </a>
                    <div class="dropdown-menu position-absolute animated fadeInUp" aria-labelledby="userProfileDropdown" style="z-index: 1050;">
                        <div class="user-profile-section">
                            <div class="media mx-auto">
                                <img src="<?php echo htmlspecialchars($user_avatar);?>" class="img-fluid mr-2" alt="avatar">
                                <div class="media-body">
                                    <h5><?php echo htmlspecialchars($user_name);?></h5>
                                    <p><?php echo htmlspecialchars($user_tel);?></p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <a href="profile">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> <span>Хувийн тохиргоо</span>
                            </a>
                        </div>
                        <!-- <div class="dropdown-item">
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg> <span>My Inbox</span>
                            </a>
                        </div> -->
                        <div class="dropdown-item">
                            <a href="profile?action=edit&type=password">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg> <span>Нууц үг солих</span>
                            </a>
                        </div>
                        <!-- <div class="dropdown-item">
                            <a href="logout">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> <span>Гарах</span>
                            </a>
                        </div> -->
                    </div>
                </li>

                <li class="nav-item dropdown user-profile-dropdown" title="Гарах" style="margin-left:13px;">
                    <a href="logout" class="nav-link dropdown-toggle user">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    </a>
                </li>
            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->