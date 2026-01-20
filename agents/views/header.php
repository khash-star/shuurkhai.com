<?php ob_start();?>
<?php
// Get feedback count for notifications
$feedback_count = 0;
$recent_feedbacks = array();

if (isset($conn) && $conn) {
    // Check if role column exists
    $check_role_sql = "SHOW COLUMNS FROM feedback LIKE 'role'";
    $role_exists = false;
    $check_result = mysqli_query($conn, $check_role_sql);
    if ($check_result && mysqli_num_rows($check_result) > 0) {
        $role_exists = true;
    }
    
    // Count active user messages (not admin, not agent)
    if ($role_exists) {
        $count_sql = "SELECT COUNT(*) as count FROM feedback WHERE archive=0 AND (role='user' OR role IS NULL OR role='')";
    } else {
        $count_sql = "SELECT COUNT(*) as count FROM feedback WHERE archive=0";
    }
    
    $count_result = mysqli_query($conn, $count_sql);
    if ($count_result) {
        $count_row = mysqli_fetch_array($count_result);
        if ($count_row && isset($count_row["count"])) {
            $feedback_count = intval($count_row["count"]);
        }
    }
    
    // Get recent feedbacks for notification
    if ($feedback_count > 0) {
        if ($role_exists) {
            $recent_sql = "SELECT id, title, content, name, contact, email, timestamp, `read` AS read_status, COALESCE(role, 'user') AS role 
                          FROM feedback 
                          WHERE archive=0 AND (role='user' OR role IS NULL OR role='') 
                          ORDER BY timestamp DESC LIMIT 8";
        } else {
            $recent_sql = "SELECT id, title, content, name, contact, email, timestamp, `read` AS read_status 
                          FROM feedback 
                          WHERE archive=0 
                          ORDER BY timestamp DESC LIMIT 8";
        }
        
        $recent_result = mysqli_query($conn, $recent_sql);
        if ($recent_result) {
            while ($recent_data = mysqli_fetch_array($recent_result)) {
                $recent_feedbacks[] = $recent_data;
            }
        }
    }
}
?>
<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
          <div class="container-xxl">
            <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
              <a href="index" class="app-brand-link">
                <img src="assets/img/logo-sm.png" title="шуурхай">
                <span class="app-brand-text demo menu-text fw-bold">www.SHUURKHAI.com</span>
              </a>

              <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                <i class="ti ti-x ti-md align-middle"></i>
              </a>
            </div>

            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="ti ti-menu-2 ti-md"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Search -->
                <li class="nav-item navbar-search-wrapper">
                  <a
                    class="nav-link btn btn-text-secondary btn-icon rounded-pill search-toggler"
                    href="javascript:void(0);">
                    <i class="ti ti-search ti-md"></i>
                  </a>
                </li>
                <!-- /Search -->

                <!-- Language -->
                <li class="nav-item dropdown-language dropdown">
                  <a
                    class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <i class="ti ti-language rounded-circle ti-md"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-language="en" data-text-direction="ltr">
                        <span>English</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-language="fr" data-text-direction="ltr">
                        <span>French</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-language="ar" data-text-direction="rtl">
                        <span>Arabic</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-language="de" data-text-direction="ltr">
                        <span>German</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ Language -->

                <!-- Quick links  -->
                <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown">
                  <a
                    class="nav-link btn btn-text-secondary btn-icon rounded-pill btn-icon dropdown-toggle hide-arrow"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    aria-expanded="false">
                    <i class="ti ti-layout-grid-add ti-md"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end p-0">
                    <div class="dropdown-menu-header border-bottom">
                      <div class="dropdown-header d-flex align-items-center py-3">
                        <h6 class="mb-0 me-auto">Shortcuts</h6>
                        <a
                          href="javascript:void(0)"
                          class="btn btn-text-secondary rounded-pill btn-icon dropdown-shortcuts-add"
                          data-bs-toggle="tooltip"
                          data-bs-placement="top"
                          title="Add shortcuts"
                          ><i class="ti ti-plus text-heading"></i
                        ></a>
                      </div>
                    </div>
                    <div class="dropdown-shortcuts-list scrollable-container">
                      <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="ti ti-calendar ti-26px text-heading"></i>
                          </span>
                          <a href="app-calendar" class="stretched-link">Calendar</a>
                          <small>Appointments</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="ti ti-file-dollar ti-26px text-heading"></i>
                          </span>
                          <a href="app-invoice-list" class="stretched-link">Invoice App</a>
                          <small>Manage Accounts</small>
                        </div>
                      </div>
                      <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="ti ti-user ti-26px text-heading"></i>
                          </span>
                          <a href="app-user-list" class="stretched-link">User App</a>
                          <small>Manage Users</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="ti ti-users ti-26px text-heading"></i>
                          </span>
                          <a href="app-access-roles" class="stretched-link">Role Management</a>
                          <small>Permission</small>
                        </div>
                      </div>
                      <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="ti ti-device-desktop-analytics ti-26px text-heading"></i>
                          </span>
                          <a href="index" class="stretched-link">Dashboard</a>
                          <small>User Dashboard</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="ti ti-settings ti-26px text-heading"></i>
                          </span>
                          <a href="pages-account-settings-account" class="stretched-link">Setting</a>
                          <small>Account Settings</small>
                        </div>
                      </div>
                      <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="ti ti-help ti-26px text-heading"></i>
                          </span>
                          <a href="pages-faq" class="stretched-link">FAQs</a>
                          <small>FAQs & Articles</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="ti ti-square ti-26px text-heading"></i>
                          </span>
                          <a href="modal-examples" class="stretched-link">Modals</a>
                          <small>Useful Popups</small>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <!-- Quick links -->

                <!-- Notification -->
                <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                  <a
                    class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow"
                    href="feedback"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    aria-expanded="false">
                    <span class="position-relative">
                      <i class="ti ti-bell ti-md"></i>
                      <?php if ($feedback_count > 0): ?>
                      <span class="badge rounded-pill bg-danger badge-notifications position-absolute top-0 start-100 translate-middle" style="font-size: 10px; min-width: 18px; height: 18px; padding: 0 5px; display: flex; align-items: center; justify-content: center;">
                        <?php echo $feedback_count > 99 ? '99+' : $feedback_count; ?>
                      </span>
                      <?php endif; ?>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end p-0" style="width: 380px;">
                    <li class="dropdown-menu-header border-bottom">
                      <div class="dropdown-header d-flex align-items-center py-3">
                        <h6 class="mb-0 me-auto">Notification</h6>
                        <div class="d-flex align-items-center h6 mb-0">
                          <?php if ($feedback_count > 0): ?>
                          <span class="badge bg-label-primary me-2"><?php echo $feedback_count; ?> New</span>
                          <?php endif; ?>
                        </div>
                      </div>
                    </li>
                    <li class="dropdown-notifications-list scrollable-container" style="max-height: 400px; overflow-y: auto;">
                      <?php if ($feedback_count > 0 && count($recent_feedbacks) > 0): ?>
                      <ul class="list-group list-group-flush">
                        <?php foreach ($recent_feedbacks as $recent_feedback): ?>
                          <?php
                          $feedback_id = isset($recent_feedback["id"]) ? intval($recent_feedback["id"]) : 0;
                          $feedback_title = isset($recent_feedback["title"]) ? htmlspecialchars($recent_feedback["title"]) : '';
                          $feedback_content = isset($recent_feedback["content"]) ? htmlspecialchars($recent_feedback["content"]) : '';
                          $feedback_name = isset($recent_feedback["name"]) ? htmlspecialchars($recent_feedback["name"]) : '';
                          $feedback_contact = isset($recent_feedback["contact"]) ? htmlspecialchars($recent_feedback["contact"]) : '';
                          $feedback_email = isset($recent_feedback["email"]) ? htmlspecialchars($recent_feedback["email"]) : '';
                          $feedback_read = isset($recent_feedback["read_status"]) ? intval($recent_feedback["read_status"]) : (isset($recent_feedback["read"]) ? intval($recent_feedback["read"]) : 0);
                          $feedback_timestamp = isset($recent_feedback["timestamp"]) ? htmlspecialchars($recent_feedback["timestamp"]) : '';
                          $feedback_role = isset($recent_feedback["role"]) && !empty($recent_feedback["role"]) ? htmlspecialchars($recent_feedback["role"]) : "user";
                          
                          // Хугацааны тооцоо
                          $time_ago = '';
                          if ($feedback_timestamp) {
                            $timestamp = strtotime($feedback_timestamp);
                            $diff = time() - $timestamp;
                            if ($diff < 60) {
                              $time_ago = $diff . ' sec ago';
                            } elseif ($diff < 3600) {
                              $time_ago = floor($diff / 60) . ' min ago';
                            } elseif ($diff < 86400) {
                              $time_ago = floor($diff / 3600) . 'h ago';
                            } elseif ($diff < 604800) {
                              $days = floor($diff / 86400);
                              $time_ago = $days . ($days == 1 ? ' day ago' : ' days ago');
                            } else {
                              $time_ago = date('M d', $timestamp);
                            }
                          }
                          
                          // Нэрний эхний үсэг
                          $initials = mb_substr($feedback_name, 0, 1, 'UTF-8');
                          if (empty($initials) && !empty($feedback_email)) {
                            $initials = mb_substr($feedback_email, 0, 1, 'UTF-8');
                          }
                          if (empty($initials)) {
                            $initials = '?';
                          }
                          $initials = mb_strtoupper($initials, 'UTF-8');
                          
                          // Агуулгын богино хувилбар
                          $short_content = mb_substr($feedback_content, 0, 50, 'UTF-8');
                          if (mb_strlen($feedback_content, 'UTF-8') > 50) {
                            $short_content .= '...';
                          }
                          ?>
                          <li class="list-group-item list-group-item-action dropdown-notifications-item" style="padding: 0;">
                            <a href="feedback" class="d-flex align-items-start" style="padding: 12px 16px; text-decoration: none; color: inherit; border-bottom: 1px solid #f0f0f0;">
                              <div class="flex-shrink-0 me-3">
                                <div class="avatar" style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                  <span style="color: white; font-weight: bold; font-size: 16px;"><?php echo $initials; ?></span>
                                </div>
                              </div>
                              <div class="flex-grow-1" style="min-width: 0;">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                  <div style="flex-grow: 1;">
                                    <h6 class="mb-1 small" style="font-size: 14px; font-weight: 500; color: #333; line-height: 1.4; margin: 0;">
                                      <?php echo $feedback_title; ?>
                                    </h6>
                                    <span class="badge badge-primary" style="font-size: 10px; margin-top: 4px;">
                                      <?php echo $feedback_contact ? $feedback_contact : 'USER'; ?>
                                    </span>
                                  </div>
                                  <?php if ($feedback_read == 0): ?>
                                  <span class="badge badge-primary" style="width: 8px; height: 8px; border-radius: 50%; background: #5e72e4; flex-shrink: 0; margin-left: 8px; margin-top: 4px;"></span>
                                  <?php endif; ?>
                                </div>
                                <?php if (!empty($short_content)): ?>
                                <small class="mb-1 d-block text-body" style="font-size: 13px; color: #666; line-height: 1.4;">
                                  <?php echo $short_content; ?>
                                </small>
                                <?php endif; ?>
                                <small class="text-muted" style="font-size: 12px; color: #999;">
                                  <?php echo $feedback_name; ?> · <?php echo $time_ago; ?>
                                </small>
                              </div>
                            </a>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                      <?php else: ?>
                      <div class="text-center" style="padding: 40px 20px;">
                        <i class="ti ti-check-circle" style="width: 48px; height: 48px; color: #ccc; margin-bottom: 12px; font-size: 48px;"></i>
                        <p class="mb-0" style="color: #999; font-size: 14px;">Шинэ зурвас байхгүй</p>
                        <p class="mb-0 mt-1" style="color: #ccc; font-size: 12px;">Бүх зурвас шийдвэрлэгдсэн</p>
                      </div>
                      <?php endif; ?>
                    </li>
                    <?php if ($feedback_count > 0): ?>
                    <li class="border-top">
                      <div class="d-grid p-4">
                        <a class="btn btn-primary btn-sm d-flex" href="feedback">
                          <small class="align-middle">View all notifications</small>
                        </a>
                      </div>
                    </li>
                    <?php endif; ?>
                  </ul>
                </li>
                <!--/ Notification -->

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a
                    class="nav-link dropdown-toggle hide-arrow p-0"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="<?=$g_agent_logged_avatar;?>" alt class="rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item mt-0" href="pages-account-settings-account">
                        <div class="d-flex align-items-center">
                          <div class="flex-shrink-0 me-2">
                            <div class="avatar avatar-online">
                              <img src="<?=$g_agent_logged_avatar;?>" alt class="rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="mb-0"><?=$g_agent_logged_name;?></h6>
                            <small class="text-muted">Agent</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider my-1 mx-n2"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="profile?action=password">
                        <i class="ti ti-lock me-3 ti-md"></i><span class="align-middle">Password change</span>
                      </a>
                    </li>

                     <li>
                      <div class="dropdown-divider my-1 mx-n2"></div>
                    </li>
                  
                    
                    <li>
                      <div class="d-grid px-2 pt-2 pb-1">
                        <a class="btn btn-sm btn-danger d-flex" href="logout">
                          <small class="align-middle">Logout</small>
                          <i class="ti ti-logout ms-2 ti-14px"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>

            <div class="navbar-search-wrapper search-input-wrapper container-xxl d-none">
              <input
                type="text"
                class="form-control search-input border-0"
                placeholder="Хайх..."
                aria-label="Хайх..." />
              <i class="ti ti-x search-toggler cursor-pointer"></i>
            </div>
          </div>
        </nav>