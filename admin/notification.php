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
        <?php 
            // if (isset($_GET["id"])) $page_id=protect($_GET["id"]); else $page_id = 1;
            if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="new";

            if ($action =="display")
            {
                ?>
                <a href="?action=new" class="btn btn-warning mb-3">Шинэ notification </a>
                <div class="card">
                <div class="card-body">
                    <table id="datatable1" class="table display responsive nowrap">
                    <thead>
                        <tr>
                        <th class="wd-10p">№</th>
                        <th class="wd-20p">Хэнд</th>
                        <th class="wd-20p">Зураг</th>
                        <th class="wd-20p">Огноо</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        $sql = "SELECT * FROM pages ORDER BY update_date DESC";
                        $result = mysqli_query($conn,$sql);
                        if ($result && mysqli_num_rows($result) > 0)
                        {
                            while ($data = mysqli_fetch_array($result))
                            {
                                if (!$data) continue;
                                ?>
                                <tr>
                                <td><?php echo $count++;?></td>
                                <td><?php echo htmlspecialchars($data["title"] ?? '');?></td>
                                <td><?php if (isset($data["image"]) && $data["image"]<>"") echo '<img src="../'.htmlspecialchars($data["image"]).'" width="100%">';?></td>
                                <td><?php echo isset($data["update_date"]) ? htmlspecialchars($data["update_date"]) : '';?></td>
                                <td class="tx-18">
                                    <div class="btn-group">
                                    <a href="?action=detail&id=<?php echo htmlspecialchars($data["page_id"] ?? '');?>" class="btn btn-success btn-xs btn-icon" title="Харах"><i data-feather="eye"></i></a>
                                    <a href="?action=edit&id=<?php echo htmlspecialchars($data["page_id"] ?? '');?>"  class="btn btn-warning btn-xs btn-icon text-white" title="Засах"><i data-feather="edit"></i></a>
                                    </div>
                                </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                    </table>
                </div><!-- table-wrapper -->
                </div><!-- section-wrapper -->
                <a href="?action=new" class="btn btn-warning mt-3">Шинэ хуудас</a>
                <?php
            }
            ?>
            

            <?php
            if ($action =="new")
            {
                ?>            
                <form action="?action=sending" method="post" enctype="multipart/form-data">
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-customer-overview">
                        <div class="card-body">
                            <div class="media-list mg-t-25">
                            <div class="media mg-t-25">
                                <div class="media-body mg-l-15 mg-t-4">
                                <span>Гарчиг</span>
                                <input type="text" name="title" class="form-control mb-3" placeholder="Notification гарчиг" required="required">
                                <span>Мессеж</span>
                                <textarea name="content" class="form-control mb-3" required placeholder="мессеж"></textarea>
                                <span>Хэнд</span>
                                <select name="to_whom" onchange="toggle_visible()" id="to_whom">
                                    <option value="all">Бүгдэд</option>
                                    <option value="single">Тодорхой хүнд</option>
                                </select>
                                <textarea name="tel" class="form-control d-none  mt-3"  placeholder="илгээх дугаараа 99161843,99037509 таслалаар залгана" id="tel"></textarea>

                                </div><!-- media-body -->
                            </div><!-- media -->
                            </div><!-- media-list -->      
                            <input type="submit" value="Илгээх" class="btn btn-success mt-3">                                                       
                        </div><!-- card-body -->
                        </div><!-- card -->
                    </div><!-- col-6 -->
                    </div><!-- row -->
                </form>
                <script>
                    function toggle_visible() {
                        let select = document.getElementById("to_whom");
                        let tel = document.getElementById("tel");

                        if (select.value=="all") 
                        {
                            // tel.hide();
                            // alert("all"); else alert("single");
                            tel.classList.add('d-none');
                        }
                        else 
                        tel.classList.remove('d-none');
                        // alert(select.value);
                        // let value1 = document.getElementById("select1").value;

                    }

                </script>
                <?php
            }
            ?>


            <?php
            if ($action =="sending")
            {
                $title = isset($_POST["title"]) ? protect($_POST["title"]) : '';
                $content = isset($_POST["content"]) ? protect($_POST["content"]) : '';
                $to_whom = isset($_POST["to_whom"]) ? protect($_POST["to_whom"]) : 'all';
                $tel = isset($_POST["tel"]) ? protect($_POST["tel"]) : '';

                require_once 'assets/vendors/fcm/google/vendor/autoload.php';


                $url = 'https://fcm.googleapis.com/v1/projects/shuurkhai-app/messages:send';
    

                try {
                $credentialsFilePath =  'assets/vendors/fcm/shuurkhai-app-firebase-adminsdk-f91yl-231ab5ccaf.json';
                if (!file_exists($credentialsFilePath)) {
                    throw new Exception("Credentials file not found.");
                }

                $client = new Google_Client();
                $client->setAuthConfig($credentialsFilePath);
                $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
                $client->refreshTokenWithAssertion();
                $token = $client->getAccessToken();

                if (!$token) {
                    throw new Exception("Failed to get access token.");
                }
                } catch (Exception $e) {
                    $response['response'] = 500;
                    $response['error_msg'] = "Google Client error: " . $e->getMessage();
                    echo json_encode($response);
                    exit();
                }

                // Obtain the Bearer token
                $apiKey = $token['access_token'];

                // Compile headers for the request
                $headers = [
                    'Authorization: Bearer ' . $apiKey,
                    'Content-Type: application/json'
                ];

                // Prepare notification and data payload
                $notifData = [
                    'title' => $title,
                    'body' => $content,
               ];

                if ($to_whom=="all")
                {
                    // Build the API body based on FCM v1 structure
                    $apiBody = [
                        'message' => [
                            'topic' => 'all',  // Send to 'all' topic
                            'notification' => $notifData,
                            'apns' => [
                                'headers' => [
                                    'apns-priority' => '10',
                                ],
                                'payload' => [
                                    'aps' => [
                                        'sound' => 'default',
                                    ],
                                ],
                            ],
                            'android' => [
                                "priority"=>"high",
                                'notification' => [
                                    'click_action' => "FLUTTER_NOTIFICATION_CLICK",
                                    'sound'=> 'default',
                                ]
                            ],
                        ]
                    ];
    
                    // Initialize curl with the prepared headers and body
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($apiBody));
    
                    // Execute call and save result
                    $result = curl_exec($ch);
                    // echo $result;

                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                    // echo $result;
                    if ($httpCode == 200) {
                        ?>
                        <div class="alert alert-success">Sent!</div>
                        <?php
                        // $response['response'] = 200;
                        // $response['error_msg'] = "Sent!";
                    } 
                    else 
                    {
                        ?>
                        <div class="alert alert-danger">
                        Failed to send notification.
                        </div>
                        <?php
                        // $response['response'] = $httpCode;
                        // $response['error_msg'] = "Failed to send notification.";
                    }

                }

                if ($to_whom=="single")
                {
                    $tels = explode(',',$tel);
                    foreach ($tels as $tel_single)
                    {
                        $tel_single = trim($tel_single);
                        if ($tel_single!="")
                        {
                            $tel_single_escaped = mysqli_real_escape_string($conn, $tel_single);
                            $sql = "SELECT customer_id,fcm_token FROM customer WHERE tel='$tel_single_escaped' LIMIT 1";
                            $result = mysqli_query($conn,$sql);
                            if ($result && mysqli_num_rows($result) == 1)
                            {
                                $data = mysqli_fetch_array($result);
                                if ($data) {
                                    $fcm_token = isset($data["fcm_token"]) ? $data["fcm_token"] : '';
                                    $customer_id = intval($data["customer_id"] ?? 0);
                                    $title_escaped = mysqli_real_escape_string($conn, $title);
                                    $content_escaped = mysqli_real_escape_string($conn, $content);
                                    $sql = "INSERT INTO notifications (receiver,title,content) VALUES ('$customer_id','$title_escaped','$content_escaped')";
                                    mysqli_query($conn,$sql);
                                    if ($fcm_token<>"")
                                    {

                                        $apiBody = [
                                            'message' => [
                                                'token' => $fcm_token,  // This is the FCM token for the device
                                                'notification' => $notifData,
                                                'apns' => [
                                                    'headers' => [
                                                        'apns-priority' => '10',
                                                    ],
                                                    'payload' => [
                                                        'aps' => [
                                                            'sound' => 'default',
                                                        ],
                                                    ],
                                                ],
                                                'android' => [
                                                    "priority"=>"high",
                                                    'notification' => [
                                                        'click_action' => "FLUTTER_NOTIFICATION_CLICK",
                                                        'sound'=> 'default',
                                                    ]
                                                ],
                                            ]
                                        ];
                                    
                                        // Initialize curl with the prepared headers and body
                                        $ch = curl_init();
                                        curl_setopt($ch, CURLOPT_URL, $url);
                                        curl_setopt($ch, CURLOPT_POST, true);
                                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($apiBody));
                                    
                                        // Execute call and save result
                                        $result = curl_exec($ch);
                                        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                        curl_close($ch);
                                        // echo $result;
                                        if ($httpCode == 200) {
                                            alert_div ($tel_single."Sent!","success");
                                        } 
                                        else 
                                        {
                                            alert_div ($tel_single."Failed to send notification");   
                                        }
                                    }
                                    else
                                    {
                                        alert_div ($tel_single.": Апп-р нэвтрээгүй хэрэглэгч байна.");                                        

                                    }
                                }
                            }
                            else
                            {
                                alert_div ($tel_single.": Утасны дугаартай хэрэглэгч одсонгүй.");
                            }
                        }
                        else
                        {
                            alert_div ("Утасны дугаар хоосон байна");                            
                        }                        
                    }
                
                }



            }
            ?>

            <?php
            if ($action =="delete")
            {
                $page_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

                ?>
                <div class="row row-xs mg-t-10">
                <div class="col-lg-12">
                    <?php
                    if ($page_id > 0) {
                        $sql = "DELETE FROM pages WHERE page_id='$page_id' LIMIT 1";

                        if (mysqli_query($conn,$sql))
                        {
                        ?>
                        <div class="alert alert-success mg-b-10" role="alert">
                            Амжилттай устгалаа.
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
                    } else {
                        ?>
                        <div class="alert alert-danger mg-b-10" role="alert">
                        Алдаа: ID олдсонгүй.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div><!-- alert --> 
                        <?php
                    }
                    ?>
                </div><!-- col-lg-12 -->
                <div class="btn-group">
                    <a href="pages" class="btn btn-primary">Бүх хуудсууд</a>
                </div>
                </div><!-- row -->
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




	<!-- endinject -->

</body>
</html>    