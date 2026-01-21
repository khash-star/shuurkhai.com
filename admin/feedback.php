<?php
    require_once("config.php");
    require_once("views/helper.php");
    require_once("views/login_check.php");
    require_once("views/init.php");
?>

<body class="sidebar-dark">
	<div class="main-wrapper">
		<?php  require_once("views/navbar.php"); ?>
	
		<div class="page-wrapper">
      <?php  require_once("views/sidebar.php"); ?>
			
            
			<div class="page-content">
                <a href="feedback?action=not_list" class="btn btn-danger btn-sm pull-right mg-b-10">Боломжгүй хүсэлтүүд</a>
                <a href="feedback?action=done_list" class="btn btn-success btn-sm pull-right mg-b-10">Шийдвэрлэсэн хүсэлтүүд</a>
                <a href="feedback" class="btn btn-primary btn-sm pull-right mg-b-10">Идэвхитэй санал хүсэлт</a>

            <?php  if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="display";?>
            
            <?php
          // Handle admin reply
          if ($action=="reply" && isset($_POST["message"]) && isset($_POST["feedback_id"]))
          {
            $feedback_id = intval(protect($_POST["feedback_id"]));
            $message = mysqli_real_escape_string($conn, protect(trim($_POST["message"])));
            $admin_name = isset($_SESSION["name"]) ? htmlspecialchars($_SESSION["name"]) : "Admin";
            $admin_email = isset($_SESSION["email"]) ? htmlspecialchars($_SESSION["email"]) : "admin@example.com";
            
            if (!empty($message) && $feedback_id > 0) {
              // Get original feedback for name/contact
              $orig_sql = "SELECT name, contact, email FROM feedback WHERE id=$feedback_id LIMIT 1";
              $orig_result = mysqli_query($conn, $orig_sql);
              $orig_name = $admin_name;
              $orig_contact = "-";
              $orig_email = $admin_email;
              
              if ($orig_result && $orig_data = mysqli_fetch_array($orig_result)) {
                $orig_name = isset($orig_data["name"]) ? $orig_data["name"] : $admin_name;
                $orig_contact = isset($orig_data["contact"]) ? $orig_data["contact"] : "-";
                $orig_email = isset($orig_data["email"]) ? $orig_data["email"] : $admin_email;
              }
              
              // Check if role column exists (backward compatibility)
              $check_role_sql = "SHOW COLUMNS FROM feedback LIKE 'role'";
              $role_exists = false;
              $check_result = mysqli_query($conn, $check_role_sql);
              if ($check_result && mysqli_num_rows($check_result) > 0) {
                $role_exists = true;
              }
              
              // Insert admin reply - use user's email so they can see it in notifications
              $reply_email = $orig_email; // Use original user's email, not admin's email
              if ($role_exists) {
                $reply_sql = "INSERT INTO feedback (title, content, name, contact, email, archive, `read`, role, timestamp) 
                             VALUES ('Re: Admin Reply', '$message', '$admin_name', '$orig_contact', '$reply_email', 0, 0, 'admin', NOW())";
              } else {
                $reply_sql = "INSERT INTO feedback (title, content, name, contact, email, archive, `read`, timestamp) 
                             VALUES ('Re: Admin Reply', '$message', '$admin_name', '$orig_contact', '$reply_email', 0, 0, NOW())";
              }
              
              if (mysqli_query($conn, $reply_sql)) {
                ?>
                <div class="alert alert-success mg-b-10" role="alert">
                  Амжилттай илгээлээ.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <?php
              }
            }
            header("location:feedback?action=chat");
            exit;
          }
          
          // Cleanup old feedback - keep only latest 5, delete all others (one-time cleanup)
          if ($action=="display" || $action=="chat")
          {
            // One-time cleanup: keep latest 5 messages, delete all others
            $cleanup_sql = "SELECT id FROM feedback WHERE archive=0 ORDER BY timestamp DESC LIMIT 5";
            $cleanup_result = mysqli_query($conn, $cleanup_sql);
            $keep_ids = array();
            
            if ($cleanup_result && mysqli_num_rows($cleanup_result) > 0) {
              while ($row = mysqli_fetch_array($cleanup_result)) {
                $keep_ids[] = intval($row["id"]);
              }
            }
            
            if (count($keep_ids) > 0) {
              $keep_ids_str = implode(',', array_map('intval', $keep_ids));
              $delete_old_sql = "DELETE FROM feedback WHERE archive=0 AND id NOT IN ($keep_ids_str)";
              mysqli_query($conn, $delete_old_sql);
            }
            
            // Get filter (all, user, admin)
            $role_filter = isset($_GET["role"]) ? protect($_GET["role"]) : "all";
            if (!in_array($role_filter, ["all", "user", "admin"])) {
              $role_filter = "all";
            }
            
            // Check if role column exists (backward compatibility)
            $check_role_sql = "SHOW COLUMNS FROM feedback LIKE 'role'";
            $role_exists = false;
            $check_result = mysqli_query($conn, $check_role_sql);
            if ($check_result && mysqli_num_rows($check_result) > 0) {
              $role_exists = true;
            }
            
            // Build query with role filter - backward compatibility: treat NULL/empty as 'user'
            $where_clause = "archive=0";
            if ($role_exists) {
              if ($role_filter == "user") {
                $where_clause .= " AND (role='user' OR role IS NULL OR role='')";
              } elseif ($role_filter == "admin") {
                $where_clause .= " AND role='admin'";
              }
            } else {
              // If role column doesn't exist, all messages are treated as 'user'
              if ($role_filter == "admin") {
                $where_clause .= " AND 1=0"; // No admin messages if column doesn't exist
              }
              // For 'all' or 'user', show all messages
            }
            
            // Default: order by timestamp ASC (oldest first, like a chat)
            $sql = "SELECT * FROM feedback WHERE $where_clause ORDER BY timestamp DESC";
            $result = mysqli_query($conn,$sql);
            ?>
            
            <!-- Chat Filters -->
            <div class="row mb-4">
              <div class="col-12">
                <div class="btn-group" role="group" aria-label="Role filter">
                  <a href="feedback?action=chat&role=all" class="btn btn-<?php echo $role_filter == 'all' ? 'primary' : 'secondary'; ?>">All</a>
                  <a href="feedback?action=chat&role=user" class="btn btn-<?php echo $role_filter == 'user' ? 'primary' : 'secondary'; ?>">User Only</a>
                  <a href="feedback?action=chat&role=admin" class="btn btn-<?php echo $role_filter == 'admin' ? 'primary' : 'secondary'; ?>">Admin Only</a>
                </div>
              </div>
            </div>
            
            <!-- Chat Container -->
            <div class="row">
              <div class="col-12">
                <div class="card" style="min-height: 500px;">
                  <div class="card-body">
                    <div class="chat-messages" id="chatMessagesContainer" style="padding: 20px; background: #fafafa; border-radius: 8px;">
                      <?php
                      if ($result && mysqli_num_rows($result) > 0)
                      {
                        while ($data = mysqli_fetch_array($result))
                        {
                          if (!$data) continue;
                          $id = isset($data["id"]) ? intval($data["id"]) : 0;
                          $title = isset($data["title"]) ? htmlspecialchars($data["title"]) : '';
                          $content = isset($data["content"]) ? htmlspecialchars($data["content"]) : '';
                          $read = isset($data["read"]) ? intval($data["read"]) : 0;
                          $name = isset($data["name"]) ? htmlspecialchars($data["name"]) : '';
                          $contact = isset($data["contact"]) ? htmlspecialchars($data["contact"]) : '';
                          $email = isset($data["email"]) ? htmlspecialchars($data["email"]) : '';
                          $timestamp = isset($data["timestamp"]) ? htmlspecialchars($data["timestamp"]) : '';
                          // Backward compatibility: treat NULL/empty as 'user'
                          $role = "user"; // Default
                          if ($role_exists && isset($data["role"]) && !empty($data["role"])) {
                            $role = htmlspecialchars($data["role"]);
                          }
                          
                          // Determine alignment and styling based on role
                          $is_admin = ($role == "admin");
                          $align_class = $is_admin ? "text-right" : "text-left";
                          $badge_class = $is_admin ? "badge-danger" : "badge-primary";
                          // For user messages, show phone number instead of "USER"
                          $badge_text = $is_admin ? "ADMIN" : ($contact ? $contact : "USER");
                          
                          // Better styling with shadows and transitions
                          if ($is_admin) {
                            $bg_color = "background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border-left: 4px solid #2196F3; margin-left: 20%; box-shadow: 0 2px 8px rgba(33, 150, 243, 0.2);";
                          } else {
                            $bg_color = "background: linear-gradient(135deg, #f5f5f5 0%, #e8f5e9 100%); border-left: 4px solid #4CAF50; margin-right: 20%; box-shadow: 0 2px 8px rgba(76, 175, 80, 0.2);";
                          }
                          
                          // Add unread indicator
                          $unread_indicator = ($read == 0 && !$is_admin) ? "border-top: 3px solid #ff9800;" : "";
                          
                          // Display name - for user messages show phone number, for admin messages show "Admin"
                          $display_name = $is_admin ? "Admin" : ($contact ? $contact : $name);
                          
                          ?>
                          <div class="message-item mb-3 message-<?php echo $is_admin ? 'admin' : 'user'; ?>" style="<?php echo $bg_color; ?> <?php echo $unread_indicator; ?> padding: 15px; border-radius: 12px; margin-bottom: 15px; transition: all 0.3s ease; position: relative;">
                            <div class="<?php echo $align_class; ?>">
                              <span class="badge <?php echo $badge_class; ?> mb-2"><?php echo $badge_text; ?></span>
                              <div class="message-header" style="margin-bottom: 8px;">
                                <strong><?php echo $display_name; ?></strong>
                                <small class="text-muted ml-2"><?php echo date("M d, Y H:i", strtotime($timestamp)); ?></small>
                              </div>
                              <?php if (!empty($title) && $title != "Re: Admin Reply"): ?>
                              <div class="message-title" style="font-weight: 600; margin-bottom: 5px; color: #333;">
                                <?php echo $title; ?>
                              </div>
                              <?php endif; ?>
                              <div class="message-content" style="color: #555; line-height: 1.5;">
                                <?php echo nl2br($content); ?>
                              </div>
                              <?php if (!$is_admin): ?>
                              <div class="message-actions mt-2">
                                <button class="btn btn-sm btn-success reply-btn" data-id="<?php echo $id; ?>" data-name="<?php echo $name; ?>">
                                  <i class="icon ion-reply"></i> Reply
                                </button>
                                <a href="feedback?action=done&id=<?php echo $id; ?>" class="btn btn-sm btn-primary">
                                  <i class="icon ion-checkmark"></i> Done
                                </a>
                                <a href="feedback?action=delete&id=<?php echo $id; ?>" class="btn btn-sm btn-danger">
                                  <i class="icon ion-ios-trash"></i> Delete
                                </a>
                              </div>
                              <?php endif; ?>
                            </div>
                          </div>
                          
                          <?php
                        }
                      }
                      else 
                      {
                        ?>
                        <div class="alert alert-info" role="alert">
                          <?php echo $role_filter == "all" ? "No messages found." : "No " . ucfirst($role_filter) . " messages found."; ?>
                        </div>
                        <?php
                      }
                      ?>
                    </div>
                    
                    <!-- Reply Form (Hidden by default, shown when Reply button clicked) -->
                    <div id="reply-form-container" style="display: none; padding: 20px; border-top: 2px solid #eee; margin-top: 20px;">
                      <h5>Reply as Admin</h5>
                      <form action="feedback?action=reply" method="POST" id="reply-form">
                        <input type="hidden" name="feedback_id" id="reply-feedback-id" value="">
                        <div class="form-group">
                          <label>To: <span id="reply-to-name"></span></label>
                        </div>
                        <div class="form-group">
                          <textarea name="message" class="form-control" rows="4" placeholder="Type your reply..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Reply</button>
                        <button type="button" class="btn btn-secondary" onclick="document.getElementById('reply-form-container').style.display='none';">Cancel</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <script>
            // Show reply form when Reply button is clicked
            document.querySelectorAll('.reply-btn').forEach(btn => {
              btn.addEventListener('click', function() {
                const feedbackId = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                document.getElementById('reply-feedback-id').value = feedbackId;
                document.getElementById('reply-to-name').textContent = name;
                document.getElementById('reply-form-container').style.display = 'block';
                document.getElementById('reply-form-container').scrollIntoView({ behavior: 'smooth' });
              });
            });
            
            // Enhanced chat interface
            const chatContainer = document.getElementById('chatMessagesContainer');
            if (chatContainer) {
              // Auto-scroll to top on load (newest messages at top)
              setTimeout(() => {
                chatContainer.scrollTop = 0;
              }, 100);
              
              // Add hover effects to messages
              const messages = document.querySelectorAll('.message-item');
              messages.forEach(msg => {
                msg.addEventListener('mouseenter', function() {
                  this.style.transform = 'translateX(5px)';
                  this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
                });
                msg.addEventListener('mouseleave', function() {
                  this.style.transform = 'translateX(0)';
                  this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
                });
              });
              
              // Auto-refresh chat every 30 seconds (only if on chat page)
              if (window.location.href.indexOf('action=chat') > -1 || window.location.href.indexOf('action=display') > -1 || !window.location.href.includes('action=')) {
                let autoRefreshInterval = setInterval(function() {
                  // Only refresh if user hasn't scrolled up significantly
                  const scrollFromBottom = chatContainer.scrollHeight - chatContainer.scrollTop - chatContainer.clientHeight;
                  if (scrollFromBottom < 200) {
                    // Show loading indicator
                    const loadingDiv = document.createElement('div');
                    loadingDiv.className = 'text-center p-2';
                    loadingDiv.innerHTML = '<small class="text-muted">Шинэчлэж байна...</small>';
                    chatContainer.appendChild(loadingDiv);
                    
                    // Reload page to get new messages
                    setTimeout(() => {
                      window.location.reload();
                    }, 500);
                  }
                }, 30000); // Refresh every 30 seconds
                
                // Clear interval when page is about to unload
                window.addEventListener('beforeunload', function() {
                  clearInterval(autoRefreshInterval);
                });
              }
              
              // Keep scroll at top when new messages arrive (newest at top, no need to scroll)
              // MutationObserver removed - new messages appear at top, so no auto-scroll needed
            }
            </script>
            
            <style>
            .chat-messages::-webkit-scrollbar {
              width: 8px;
            }
            .chat-messages::-webkit-scrollbar-track {
              background: #f1f1f1;
              border-radius: 10px;
            }
            .chat-messages::-webkit-scrollbar-thumb {
              background: #888;
              border-radius: 10px;
            }
            .chat-messages::-webkit-scrollbar-thumb:hover {
              background: #555;
            }
            .message-item:hover {
              transform: translateX(5px) !important;
            }
            .message-user:hover {
              border-left-color: #66bb6a !important;
            }
            .message-admin:hover {
              border-left-color: #42a5f5 !important;
            }
            </style>
            <?php
          }
          ?>



          <?php
          if ($action=="done_list")
          {
            ?>
            <div class="row">
              <?php
              $sql = "SELECT * FROM feedback WHERE archive=1 ORDER BY timestamp DESC";
              $result = mysqli_query($conn,$sql);
              $count = 0;
              if ($result && mysqli_num_rows($result) > 0)
              {
                while ($data = mysqli_fetch_array($result))
                {
                  if (!$data) continue;
                  $id = isset($data["id"]) ? intval($data["id"]) : 0;
                  $title = isset($data["title"]) ? htmlspecialchars($data["title"]) : '';
                  $content = isset($data["content"]) ? htmlspecialchars($data["content"]) : '';
                  $read = isset($data["read"]) ? intval($data["read"]) : 0;
                  $name = isset($data["name"]) ? htmlspecialchars($data["name"]) : '';
                  $contact = isset($data["contact"]) ? htmlspecialchars($data["contact"]) : '';
                  $email = isset($data["email"]) ? htmlspecialchars($data["email"]) : '';
                  $timestamp = isset($data["timestamp"]) ? htmlspecialchars($data["timestamp"]) : '';
                  ?>
                  <div class="col-md-6 mg-md-t-10">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title tx-medium mg-b-10"><?php echo $title;?></h5>
                        Бичсэн 
                            <?php echo $name;?>  - <?php echo $email;?> (<?php echo $contact;?>)                          
                       
                        <p class="card-subtitle tx-normal mg-b-15"><?php echo substr($timestamp,0,10);?></p>



                        <p class="card-text"><?php echo $content;?></p>
                        <a href="feedback?action=not_done&id=<?php echo htmlspecialchars($id);?>" class="card-link tx-white" title="Санал хүсэлтийг шийдвэрлэх боломжгүй"><i class="icon ion-close"></i> Боломжгүй</a>
                        <a href="feedback?action=delete&id=<?php echo htmlspecialchars($id);?>" class="card-link tx-white" title="Санал хүсэлтийг устгах"><i class="icon ion-ios-trash"></i> Устгах</a>
                      </div>
                    </div><!-- card -->
                  </div><!-- col -->
                  <?php
                  $count++;
                }
              }
              else 
              {
                ?>
                <div class="alert alert-danger mg-b-10 col-lg-12" role="alert">
                  Шийдвэрлэгдсэн санал хүсэлт байхгүй.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div><!-- alert --> 
                <?php
              }
              ?>              
            </div><!-- row -->
            <?php
            if ($count>4)
            {
              ?>
              <a href="feedback?action=done_list" class="btn btn-danger btn-sm pull-right mg-b-10">Боломжгүй хүсэлтүүд</a>
              <a href="feedback?action=done_list" class="btn btn-primary btn-sm pull-right mg-b-10">Идэвхитэй хүсэлтүүд</a>
              <?php
            }
          }
          ?>

          <?php
          if ($action=="not_list")
          {
            ?>
            <div class="row">
              <?php
              $sql = "SELECT * FROM feedback WHERE archive=2 ORDER BY timestamp DESC";
              $result = mysqli_query($conn,$sql);
              $count = 0;
              if ($result && mysqli_num_rows($result) > 0)
              {
                while ($data = mysqli_fetch_array($result))
                {
                  if (!$data) continue;
                  $id = isset($data["id"]) ? intval($data["id"]) : 0;
                  $title = isset($data["title"]) ? htmlspecialchars($data["title"]) : '';
                  $content = isset($data["content"]) ? htmlspecialchars($data["content"]) : '';
                  $read = isset($data["read"]) ? intval($data["read"]) : 0;
                  $name = isset($data["name"]) ? htmlspecialchars($data["name"]) : '';
                  $contact = isset($data["contact"]) ? htmlspecialchars($data["contact"]) : '';
                  $email = isset($data["email"]) ? htmlspecialchars($data["email"]) : '';
                  $timestamp = isset($data["timestamp"]) ? htmlspecialchars($data["timestamp"]) : '';
                  ?>
                  <div class="col-md-6 mg-md-t-10">
                    <div class="card">
                      <div class="card-body bg-purple tx-white">
                        <h5 class="card-title tx-dark tx-medium mg-b-10"><?php echo $title;?></h5>
                        Бичсэн 
                            <?php echo $name;?>  - <?php echo $email;?> (<?php echo $contact;?>)                          
                       
                        <p class="card-subtitle tx-normal mg-b-15"><?php echo substr($timestamp,0,10);?></p>

                        <p class="card-text"><?php echo $content;?></p>
                        <a href="feedback?action=done&id=<?php echo htmlspecialchars($id);?>" class="card-link" title="Санал хүсэлтийг шийдвэрлэсэн болгох"><i class="icon ion-checkmark"></i> Шийдвэрлэсэн</a>
                        <a href="feedback?action=delete&id=<?php echo htmlspecialchars($id);?>" class="card-link tx-white" title="Санал хүсэлтийг устгах"><i class="icon ion-ios-trash"></i> Устгах</a>
                      </div>
                    </div><!-- card -->
                  </div><!-- col -->
                  <?php
                  $count++;
                }
              }
              else 
              {
                ?>
                <div class="alert alert-danger mg-b-10 col-lg-12" role="alert">
                  Архивлагдсан санал хүсэлт байхгүй.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div><!-- alert --> 
                <?php
              }
              ?>              
            </div><!-- row -->
            <?php
            if ($count>4)
            {
              ?>
              <a href="feedback?action=done_list" class="btn btn-success btn-sm pull-right mg-b-10">Шийдвэрлэгдсэн хүсэлтүүд</a>
              <a href="feedback" class="btn btn-primary btn-sm pull-right mg-b-10">Идэвхитэй хүсэлтүүд</a>
              <?php
            }
          }
          ?>

          <?php
          if ($action=="done")
          {
            if (isset($_GET["id"])) {
              $feedback_id = intval(protect($_GET["id"]));
            } else {
              header("location:feedback");
              exit;
            }
            ?>
                  <?php
                  $feedback_id_escaped = mysqli_real_escape_string($conn, $feedback_id);
                  $sql = "SELECT * FROM feedback WHERE id=" . $feedback_id_escaped . " LIMIT 1";
                  $result = mysqli_query($conn,$sql);
                  if ($result && mysqli_num_rows($result) == 1)
                  {
                    $update_sql = "UPDATE feedback SET archive=1 WHERE id=" . $feedback_id_escaped;
                    if (mysqli_query($conn, $update_sql)) 
                      {
                        ?>
                        <div class="alert alert-success mg-b-10" role="alert">
                          Шийдвэрлэв.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div><!-- alert --> 
                        <?php
                      }
                      else 
                      {
                        ?>
                        <div class="alert alert-danger mg-b-10" role="alert">
                          Алдаа гарлаа. <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error';?>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div><!-- alert --> 
                        <?php
                      }                   
                  }
                  ?>
            
            <?php
          }
          ?>

          <?php
          if ($action=="not_done")
          {
            if (isset($_GET["id"])) {
              $feedback_id = intval(protect($_GET["id"]));
            } else {
              header("location:feedback");
              exit;
            }
            ?>
                  <?php
                  $feedback_id_escaped = mysqli_real_escape_string($conn, $feedback_id);
                  $sql = "SELECT * FROM feedback WHERE id=" . $feedback_id_escaped . " LIMIT 1";
                  $result = mysqli_query($conn,$sql);
                  if ($result && mysqli_num_rows($result) == 1)
                  {
                    $update_sql = "UPDATE feedback SET archive=2 WHERE id=" . $feedback_id_escaped;
                    if (mysqli_query($conn, $update_sql)) 
                      {
                        ?>
                        <div class="alert alert-success mg-b-10" role="alert">
                          Боломжгүй болгов.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div><!-- alert --> 
                        <?php
                      }
                      else 
                      {
                        ?>
                        <div class="alert alert-danger mg-b-10" role="alert">
                          Алдаа гарлаа. <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error';?>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div><!-- alert --> 
                        <?php
                      }                   
                  }
                  ?>
            
            <?php
          }
          ?>


          <?php
          if ($action=="delete")
          {
            if (isset($_GET["id"])) {
              $feedback_id = intval(protect($_GET["id"]));
            } else {
              header("location:feedback");
              exit;
            }
            ?>
            <div class="clearfix"></div>
                  <?php
                  $feedback_id_escaped = mysqli_real_escape_string($conn, $feedback_id);
                  $sql = "SELECT * FROM feedback WHERE id=" . $feedback_id_escaped . " LIMIT 1";
                  $result = mysqli_query($conn,$sql);
                  if ($result && mysqli_num_rows($result) == 1)
                  {
                    $delete_sql = "DELETE FROM feedback WHERE id=" . $feedback_id_escaped;
                    if (mysqli_query($conn, $delete_sql)) 
                      {
                        ?>
                        <div class="alert alert-success mg-b-10" role="alert">
                          Устгагдлаа.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div><!-- alert --> 
                        <?php
                      }
                      else 
                      {
                        ?>
                        <div class="alert alert-danger mg-b-10" role="alert">
                          Алдаа гарлаа. <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error';?>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div><!-- alert --> 
                        <?php
                      }                   
                  }
                  ?>
            
            <?php
          }
          ?>

      </div>
      <?php require_once("views/footer.php");?>
		
		</div>
	</div>

	<!-- core:js -->
	<script src="assets/vendors/core/core.js"></script>
	<!-- endinject -->
  
	<!-- inject:js -->
	<script src="assets/vendors/feather-icons/feather.min.js"></script>
  <script src="assets/js/template.js"></script>

  <script src="assets/js/dashboard.js"></script>
  <script src="assets/js/apexcharts.js"></script>

  <script>
  // Scroll to top when page loads
  (function() {
    function scrollToTop() {
      window.scrollTo(0, 0);
      document.documentElement.scrollTop = 0;
      document.body.scrollTop = 0;
    }
    
    // Scroll on load
    window.addEventListener('load', function() {
      scrollToTop();
    });
    
    // Scroll on DOM ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', function() {
        setTimeout(scrollToTop, 100);
      });
    } else {
      setTimeout(scrollToTop, 100);
    }
    
    // Scroll after delays to ensure page is fully rendered
    setTimeout(scrollToTop, 300);
    setTimeout(scrollToTop, 500);
  })();
  </script>

	<!-- endinject -->

</body>
</html>    