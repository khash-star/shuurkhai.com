<?php require_once("config.php");?>
<?php require_once("views/helper.php");?>
<?php require_once("views/login_check.php");?>
<?php require_once("views/init.php");?>
  <body>
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
      <div class="layout-container">
        <?php require_once("views/header.php");?>

        <?php  if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="display";?>

        <div class="layout-page">          
          <div class="content-wrapper">
            <?php require_once("views/topmenu.php");?>

            <div class="container-xxl flex-grow-1 container-p-y">
                <button onclick="toggleMessages()" class="btn btn-secondary btn-sm pull-right mg-b-10">МЕССЕЖИЙГ ХААХ</button>

            <?php  if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="display";?>
            
            <?php
          // Handle agent reply
          if ($action=="reply" && isset($_POST["message"]) && isset($_POST["feedback_id"]))
          {
            $feedback_id = intval(protect($_POST["feedback_id"]));
            $message = mysqli_real_escape_string($conn, protect(trim($_POST["message"])));
            $agent_name = isset($g_agent_logged_name) ? htmlspecialchars($g_agent_logged_name) : "Agent";
            $agent_id = isset($g_agent_logged_id) ? intval($g_agent_logged_id) : 0;
            
            if (!empty($message) && $feedback_id > 0) {
              // Get original feedback for name/contact
              $orig_sql = "SELECT name, contact, email FROM feedback WHERE id=$feedback_id LIMIT 1";
              $orig_result = mysqli_query($conn, $orig_sql);
              $orig_name = $agent_name;
              $orig_contact = "-";
              $orig_email = "-";
              
              if ($orig_result && $orig_data = mysqli_fetch_array($orig_result)) {
                $orig_name = isset($orig_data["name"]) ? $orig_data["name"] : $agent_name;
                $orig_contact = isset($orig_data["contact"]) ? $orig_data["contact"] : "-";
                $orig_email = isset($orig_data["email"]) ? $orig_data["email"] : "-";
              }
              
              // Check if role column exists (backward compatibility)
              $check_role_sql = "SHOW COLUMNS FROM feedback LIKE 'role'";
              $role_exists = false;
              $check_result = mysqli_query($conn, $check_role_sql);
              if ($check_result && mysqli_num_rows($check_result) > 0) {
                $role_exists = true;
              } else {
                // Create role column if it doesn't exist
                $create_role_sql = "ALTER TABLE feedback ADD COLUMN role VARCHAR(20) DEFAULT NULL";
                mysqli_query($conn, $create_role_sql);
                $role_exists = true;
              }
              
              // Check if agent_id column exists, if not create it
              $check_agent_sql = "SHOW COLUMNS FROM feedback LIKE 'agent_id'";
              $agent_id_exists = false;
              $check_agent_result = mysqli_query($conn, $check_agent_sql);
              if ($check_agent_result && mysqli_num_rows($check_agent_result) > 0) {
                $agent_id_exists = true;
              } else {
                // Create agent_id column if it doesn't exist
                if ($role_exists) {
                  $create_agent_id_sql = "ALTER TABLE feedback ADD COLUMN agent_id INT(11) DEFAULT NULL AFTER role";
                } else {
                  $create_agent_id_sql = "ALTER TABLE feedback ADD COLUMN agent_id INT(11) DEFAULT NULL";
                }
                mysqli_query($conn, $create_agent_id_sql);
                $agent_id_exists = true; // Assume it was created successfully
              }
              
              // Insert agent reply - use user's email so they can see it in notifications
              $reply_email = $orig_email; // Use original user's email, not agent's email
              if ($role_exists && $agent_id_exists) {
                $reply_sql = "INSERT INTO feedback (title, content, name, contact, email, archive, `read`, role, agent_id, timestamp) 
                             VALUES ('Re: Agent Reply', '$message', '$agent_name', '$orig_contact', '$reply_email', 0, 0, 'agent', $agent_id, NOW())";
              } elseif ($role_exists) {
                $reply_sql = "INSERT INTO feedback (title, content, name, contact, email, archive, `read`, role, timestamp) 
                             VALUES ('Re: Agent Reply', '$message', '$agent_name', '$orig_contact', '$reply_email', 0, 0, 'agent', NOW())";
              } else {
                $reply_sql = "INSERT INTO feedback (title, content, name, contact, email, archive, `read`, timestamp) 
                             VALUES ('Re: Agent Reply', '$message', '$agent_name', '$orig_contact', '$reply_email', 0, 0, NOW())";
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
          
          if ($action=="display" || $action=="chat")
          {
            // Get filter (all, user, admin, agent)
            $role_filter = isset($_GET["role"]) ? protect($_GET["role"]) : "all";
            if (!in_array($role_filter, ["all", "user", "admin", "agent"])) {
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
              } elseif ($role_filter == "agent") {
                $where_clause .= " AND role='agent'";
              }
            } else {
              // If role column doesn't exist, all messages are treated as 'user'
              if ($role_filter == "admin" || $role_filter == "agent") {
                $where_clause .= " AND 1=0"; // No admin/agent messages if column doesn't exist
              }
              // For 'all' or 'user', show all messages
            }
            
            // Default: order by timestamp ASC (oldest first, like a chat)
            $sql = "SELECT * FROM feedback WHERE $where_clause ORDER BY timestamp ASC";
            $result = mysqli_query($conn,$sql);
            ?>
            
            <!-- Chat Filters -->
            <div class="row mb-4">
              <div class="col-12">
                <div class="btn-group" role="group" aria-label="Role filter">
                  <a href="feedback?action=chat&role=all" class="btn btn-<?php echo $role_filter == 'all' ? 'primary' : 'secondary'; ?>">All</a>
                  <a href="feedback?action=chat&role=user" class="btn btn-<?php echo $role_filter == 'user' ? 'primary' : 'secondary'; ?>">User Only</a>
                  <a href="feedback?action=chat&role=admin" class="btn btn-<?php echo $role_filter == 'admin' ? 'primary' : 'secondary'; ?>">Admin Only</a>
                  <a href="feedback?action=chat&role=agent" class="btn btn-<?php echo $role_filter == 'agent' ? 'primary' : 'secondary'; ?>">Agent Only</a>
                </div>
              </div>
            </div>
            
            <!-- Chat Container -->
            <div class="row" id="messagesContainer">
              <div class="col-12">
                <div class="card" id="messagesCard" style="min-height: 500px;">
                  <div class="card-body">
                    <div class="chat-messages" id="chatMessagesContainer" style="max-height: 600px; overflow-y: auto; padding: 20px; background: #fafafa; border-radius: 8px;">
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
                          $is_agent = ($role == "agent");
                          $is_user = (!$is_admin && !$is_agent);
                          
                          // For agent messages, check if it's from current agent
                          $current_agent_id = isset($g_agent_logged_id) ? intval($g_agent_logged_id) : 0;
                          $message_agent_id = isset($data["agent_id"]) ? intval($data["agent_id"]) : 0;
                          $is_my_message = ($is_agent && $message_agent_id == $current_agent_id);
                          
                          $align_class = ($is_admin || $is_agent) ? "text-right" : "text-left";
                          $badge_class = $is_admin ? "badge-danger" : ($is_agent ? "badge-info" : "badge-primary");
                          // For user messages, show phone number instead of "USER"
                          $badge_text = $is_admin ? "ADMIN" : ($is_agent ? "AGENT" : ($contact ? $contact : "USER"));
                          
                          // Better styling with shadows and transitions
                          if ($is_admin) {
                            $bg_color = "background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border-left: 4px solid #2196F3; margin-left: 20%; box-shadow: 0 2px 8px rgba(33, 150, 243, 0.2);";
                          } elseif ($is_agent) {
                            $bg_color = "background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); border-left: 4px solid #FF9800; margin-left: 20%; box-shadow: 0 2px 8px rgba(255, 152, 0, 0.2);";
                          } else {
                            $bg_color = "background: linear-gradient(135deg, #f5f5f5 0%, #e8f5e9 100%); border-left: 4px solid #4CAF50; margin-right: 20%; box-shadow: 0 2px 8px rgba(76, 175, 80, 0.2);";
                          }
                          
                          // Add unread indicator
                          $unread_indicator = ($read == 0 && $is_user) ? "border-top: 3px solid #ff9800;" : "";
                          
                          // Display name - for user messages show phone number, for admin/agent messages show name
                          $display_name = $is_admin ? "Admin" : ($is_agent ? $name : ($contact ? $contact : $name));
                          
                          ?>
                          <div class="message-item mb-3 message-<?php echo $is_admin ? 'admin' : ($is_agent ? 'agent' : 'user'); ?>" style="<?php echo $bg_color; ?> <?php echo $unread_indicator; ?> padding: 15px; border-radius: 12px; margin-bottom: 15px; transition: all 0.3s ease; position: relative;">
                            <div class="<?php echo $align_class; ?>">
                              <span class="badge <?php echo $badge_class; ?> mb-2"><?php echo $badge_text; ?></span>
                              <div class="message-header" style="margin-bottom: 8px;">
                                <strong><?php echo $display_name; ?></strong>
                                <small class="text-muted ml-2"><?php echo date("M d, Y H:i", strtotime($timestamp)); ?></small>
                              </div>
                              <?php if (!empty($title) && $title != "Re: Admin Reply" && $title != "Re: Agent Reply"): ?>
                              <div class="message-title" style="font-weight: 600; margin-bottom: 5px; color: #333;">
                                <?php echo $title; ?>
                              </div>
                              <?php endif; ?>
                              <div class="message-content" style="color: #555; line-height: 1.5;">
                                <?php echo nl2br($content); ?>
                              </div>
                              <?php if ($is_user): ?>
                              <div class="message-actions mt-2">
                                <button class="btn btn-sm btn-success reply-btn" data-id="<?php echo $id; ?>" data-name="<?php echo $name; ?>">
                                  <i class="icon ion-reply"></i> Reply
                                </button>
                                <a href="feedback?action=done&id=<?php echo $id; ?>" class="btn btn-sm btn-primary">
                                  <i class="icon ion-checkmark"></i> Done
                                </a>
                              </div>
                              <?php endif; ?>
                              <?php if ($is_agent && $is_my_message): ?>
                              <div class="message-actions mt-2" style="text-align: right;">
                                <a href="feedback?action=delete&id=<?php echo $id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Та энэ зурвасыг устгахдаа итгэлтэй байна уу?');" title="Зурвас устгах">
                                  <i class="icon ion-close"></i> Хаах
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
                      <h5>Reply as Agent</h5>
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
              // Auto-scroll to bottom on load
              setTimeout(() => {
                chatContainer.scrollTop = chatContainer.scrollHeight;
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
              
              // Smooth scroll to bottom when new messages arrive
              const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                  if (mutation.addedNodes.length) {
                    // Check if user is near bottom
                    const scrollFromBottom = chatContainer.scrollHeight - chatContainer.scrollTop - chatContainer.clientHeight;
                    if (scrollFromBottom < 300) {
                      setTimeout(() => {
                        chatContainer.scrollTo({
                          top: chatContainer.scrollHeight,
                          behavior: 'smooth'
                        });
                      }, 100);
                    }
                  }
                });
              });
              
              observer.observe(chatContainer, { childList: true, subtree: true });
            }
            // Toggle messages visibility
            function toggleMessages() {
              const messagesContainer = document.getElementById('messagesContainer');
              const filtersRow = document.querySelector('.row.mb-4');
              const toggleBtn = document.querySelector('button[onclick="toggleMessages()"]');
              
              if (messagesContainer) {
                if (messagesContainer.style.display === 'none') {
                  // Show messages
                  messagesContainer.style.display = 'block';
                  if (filtersRow) filtersRow.style.display = 'flex';
                  if (toggleBtn) toggleBtn.textContent = 'МЕССЕЖИЙГ ХААХ';
                } else {
                  // Hide messages
                  messagesContainer.style.display = 'none';
                  if (filtersRow) filtersRow.style.display = 'none';
                  if (toggleBtn) toggleBtn.textContent = 'МЕССЕЖИЙГ НЭЭХ';
                }
              }
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
            .message-agent:hover {
              border-left-color: #ff9800 !important;
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
          </div>
        </div>
      </div>
    </div>
    <?php require_once("views/footer.php");?>
  </body>
</html>

