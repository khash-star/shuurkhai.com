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
			
            <?php  if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="display";?>

			<div class="page-content">
            <?php
            if ($action =="display")
            {
                ?>
                <div class="card">
                    <div class="card-body">
                        <!-- Quick Edit: Air Cargo Price -->
                        <?php
                        // Find paymentrate setting ID
                        $paymentrate_id = null;
                        $paymentrate_value = '7';
                        $paymentrate_name = 'Агаарын карго үнэ (1кг)';
                        
                        $sql_paymentrate = "SELECT * FROM settings WHERE shortname='paymentrate' LIMIT 1";
                        $result_paymentrate = mysqli_query($conn, $sql_paymentrate);
                        if ($result_paymentrate && mysqli_num_rows($result_paymentrate) > 0) {
                            $paymentrate_data = mysqli_fetch_array($result_paymentrate);
                            if ($paymentrate_data) {
                                $paymentrate_id = isset($paymentrate_data['id']) ? $paymentrate_data['id'] : null;
                                $raw_value = isset($paymentrate_data['value']) ? $paymentrate_data['value'] : '7';
                                // Convert to float and format with 2 decimal places
                                $raw_value = str_replace(',', '.', trim($raw_value));
                                $raw_value = preg_replace('/[^0-9.]/', '', $raw_value);
                                $paymentrate_value = number_format(floatval($raw_value), 2, '.', '');
                                $paymentrate_name = isset($paymentrate_data['name']) ? htmlspecialchars($paymentrate_data['name']) : 'Агаарын карго үнэ (1кг)';
                            }
                        }
                        ?>
                        <?php if ($paymentrate_id): ?>
                        <div class="alert alert-info mb-4">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="mb-1"><strong>✈️ <?php echo $paymentrate_name; ?></strong></h6>
                                    <p class="mb-0 text-muted">Одоогийн үнэ: <strong class="text-primary"><?php echo $paymentrate_value; ?>$</strong> / кг</p>
                                </div>
                                <div class="col-md-4 text-right">
                                    <a href="settings.php?action=edit&id=<?php echo $paymentrate_id; ?>" class="btn btn-success btn-sm">
                                        <i data-feather="edit"></i> Үнэ засах
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Search box for easy finding -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" id="settingsSearch" class="form-control" placeholder="🔍 Тохиргоо хайх (жишээ: paymentrate, үнэ, агаар)...">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" onclick="searchSettings()">
                                            <i data-feather="search"></i> Хайх
                                        </button>
                                        <button class="btn btn-secondary" type="button" onclick="clearSearch()">
                                            <i data-feather="x"></i> Цэвэрлэх
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="settingsTable">
                                <thead>
                                    <tr>
                                    <th class="wd-5p">№</th>
                                    <th class="wd-30p">Нэр</th>
                                    <th class="wd-40p">Утга</th>
                                    <th class="wd-10p">Зассан</th>
                                    <th class="wd-5p">-</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    $data = null;
                                    $sql = "SELECT * FROM settings ORDER BY name DESC";
                                    $result = mysqli_query($conn,$sql);
                                    if ($result && mysqli_num_rows($result)>0)
                                    {
                                    while ($data = mysqli_fetch_array($result))
                                    {
                                        if (!$data) continue;
                                        ?>
                                        <tr>
                                        <td><?php echo $count++;?></td>
                                        <td class="text-wrap"><h4><?php echo isset($data["name"]) ? $data["name"] : '';?></h4>
                                            <i><?php echo isset($data["description"]) ? $data["description"] : '';?></i>
                                        </td>
                                        <td><?php
                                        if (isset($data["type"]) && $data["type"]=="t") echo isset($data["value"]) ? $data["value"] : '';
                                        if (isset($data["type"]) && $data["type"]=="c") echo isset($data["value"]) ? $data["value"] : '';
                                        if (isset($data["type"]) && $data["type"]=="i" && isset($data["value"]) && $data["value"]<>"") echo "<img src='../". $data["value"]."' style='max-width:60px; max-height:60px;'>";
                                        if (isset($data["type"]) && $data["type"]=="f" && isset($data["value"]) && $data["value"]<>"") echo "<a href='". $data["value"]."' target='new' class='btn btn-success'>Татах</a>";
                                        if (isset($data["type"]) && $data["type"]=="b") 
                                            if (isset($data["value"]) && $data["value"]) echo "<span class='tx-14 tx-success'>On</span>"; else echo "<span class='tx-14 tx-danger'>Off</span>";

                                        ?></td>
                                        <td><?php echo isset($data["update_date"]) ? substr($data["update_date"],0,10) : '';?></td>
                                        <td class="tx-18">
                                            <div class="btn-group">
                                            <a href="settings.php?action=edit&id=<?php echo isset($data["id"]) ? $data["id"] : '';?>"><i data-feather="edit"></i></a>
                                            </div>
                                        </td>
                                        </tr>
                                        <?php
                                    }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>

            <?php
            if ($action =="edit")
            {
                ?>
                <div class="row row-xs mg-t-10">
                <div class="col-lg-12">
                    <form action="settings.php?action=editing" method="post" enctype="multipart/form-data">
                    <div class="card card-customer-overview">
                        <div class="card-header">
                        <h6 class="slim-card-title">Тохиргоог засах</h6>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <?php
                            if (isset($_GET["id"])) $settings_id=intval($_GET["id"]); else { header("location:settings.php"); exit; }
                            $data = null;
                            $sql = "SELECT * FROM settings WHERE id=$settings_id LIMIT 1";
                            $result= mysqli_query($conn,$sql);
                            if ($result && mysqli_num_rows($result)==1)
                            {
                            $data = mysqli_fetch_array($result);
                            if (!$data) { echo "Алдаа: Тохиргоо олдсонгүй"; exit; }
                            ?>
                            <input type="hidden" name="id" value="<?php echo isset($data["id"]) ? $data["id"] : '';?>">
                            <input type="hidden" name="type" value="<?php echo isset($data["type"]) ? $data["type"] : '';?>">
                            <div class="media-list mg-t-25">
                                <div class="media">
                                <div class="media-body mg-l-15 mg-t-4">
                                    <h6 class="tx-14 tx-gray-700">Нэр</h6>
                                    <input type="text" name="name" value="<?php echo isset($data["name"]) ? htmlspecialchars($data["name"]) : '';?>" class="form-control" readonly="readonly">
                                </div><!-- media-body -->
                                </div><!-- media -->
                                <div class="media mg-t-25">
                                <div class="media-body mg-l-15 mg-t-4">
                                    <h6 class="tx-14 tx-gray-700">Тайлбар (*)</h6>
                                    <input type="text" name="description" value="<?php echo isset($data["description"]) ? htmlspecialchars($data["description"]) : '';?>" class="form-control" required="required">
                                </div><!-- media-body -->
                                </div><!-- media -->
                                <div class="media mg-t-25">
                                <div class="media-body mg-l-15 mg-t-4">
                                    <h6 class="tx-14 tx-gray-700">Утга (*) </h6>
                                    <?php
                                    if (isset($data["type"]) && $data["type"]=="t")
                                    {
                                    ?>
                                    <input type="text" name="value" value="<?php echo isset($data["value"]) ? htmlspecialchars($data["value"]) : '';?>" class="form-control">
                                    <?php
                                    };

                                    if (isset($data["type"]) && $data["type"]=="c")
                                    {
                                    ?>
                                        <textarea class="form-control" name="value"><?php echo isset($data["value"]) ? htmlspecialchars($data["value"]) : '';?></textarea>
                                    <?php
                                    };


                                    if (isset($data["type"]) && $data["type"]=="i")
                                    {
                                    if (isset($data["value"]) && $data["value"]<>"") 
                                    {
                                        ?>
                                        <img src="../<?php echo htmlspecialchars($data["value"]);?>" style="max-width:100%;">
                                        <?php
                                    };
                                    ?>
                                        <br>
                                    <input type="file" name="value">
                                    <?php
                                    };
                                    

                                    if (isset($data["type"]) && $data["type"]=="f")
                                    {
                                    if (isset($data["value"]) && $data["value"]<>"") 
                                    {
                                        ?>
                                        <a href="../<?php echo htmlspecialchars($data["value"]);?>" target="new" class="btn btn-warning">Татах</a>
                                        <?php
                                    };
                                    ?>
                                        <br>
                                    <input type="file" name="value">
                                    <?php
                                    };

                                    if (isset($data["type"]) && $data["type"]=="b") 
                                    {
                                        ?>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" <?php echo (isset($data["value"]) && $data["value"])?'checked':'';?> class="form-check-input" name="value">
                                                Нээх
                                            </label>
                                        </div>
                                        <?php
                                    }


                                    ?>
                                    

                                
                                </div><!-- media-body -->
                                </div><!-- media -->
                                

                            </div><!-- media-list -->
                                
                                
                            <div class="clearfix"></div><br>

                            <div class="btn-group">
                                <input type="submit" class="btn btn-success" value="Хадгалах">
                                <a href="settings.php" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бусад тохиргоо</a>
                            </div>
                            <?php
                            }
                            else
                            {
                                echo "<div class='alert alert-danger'>Алдаа: Тохиргоо олдсонгүй</div>";
                            }
                            ?>
                        </div><!-- card-body -->
                    </div><!-- card -->
                    </form>
                </div><!-- col-6 -->
                </div><!-- row -->
                <?php
            }
            ?>


            <?php
            if ($action =="editing")
            {  
                ?>
                <div class="row row-xs mg-t-10">
                    <div class="col-lg-12">
                    <div class="card card-customer-overview">
                        <div class="card-header">
                        <h6 class="slim-card-title">Тохиргоог засах</h6>
                        </div><!-- card-header -->
                        <div class="card-body">
                        <?php
                        if (isset($_POST["id"])) $settings_id=intval($_POST["id"]); else { header("location:settings.php"); exit; }
                        $type = isset($_POST["type"]) ? $_POST["type"] : "";
                        $value = "";

                        if ($type=="t") $value = isset($_POST["value"]) ? $_POST["value"] : "";
                        if ($type=="c") $value = isset($_POST["value"]) ? $_POST["value"] : "";
                        if ($type=="b") if (isset($_POST["value"])) $value=1; else $value=0;
                        if ($type=="i")
                        {   
                            $value="";
                            if(isset($_FILES['value']) && $_FILES['value']['name']!="")
                            {
                                @$folder = date("Ym");
                                if(!file_exists('../uploads/'.$folder))
                                mkdir ( '../uploads/'.$folder);
                                $target_dir = '../uploads/'.$folder;
                                $target_file = $target_dir."/".@date("his").rand(0,1000).$settings_id.substr(basename($_FILES["value"]["name"]),-4,4);
                                if (move_uploaded_file($_FILES['value']['tmp_name'], $target_file))
                                {
                                    $thumb_image_content = resize_image($target_file,300,300);
                                    $thumb = substr($target_file,0,-4)."_thumb".substr($target_file,-4,4);
                                    imagejpeg($thumb_image_content,$thumb,75);
                                    //$target_file = substr($target_file,3);
                                    //$thumb = substr($thumb,3);
                                    $value=$thumb;
                                    if (substr($value,0,3)=="../") $value=substr($value,3);
                                }

                            }
                        } 

                        if ($type=="f")
                        {   
                            $value="";
                            if(isset($_FILES['value']) && $_FILES['value']['name']!="")
                            {
                                @$folder = date("Ym");
                                if(!file_exists('../uploads/'.$folder))
                                mkdir ( '../uploads/'.$folder);
                                $target_dir = '../uploads/'.$folder;
                                $target_file = $target_dir."/".@date("his").rand(0,1000).$settings_id.substr(basename($_FILES["value"]["name"]),-4,4);
                                if (move_uploaded_file($_FILES['value']['tmp_name'], $target_file))
                                {
                                    $value=$target_file;
                                    if (substr($value,0,3)=="../") $value=substr($value,3);
                                }
                            }
                        } 
                        $description = isset($_POST["description"]) ? mysqli_real_escape_string($conn, $_POST["description"]) : "";
                        $value_escaped = mysqli_real_escape_string($conn, $value);
                        if ($value=="")
                            $sql = "UPDATE settings SET description='$description' WHERE id=$settings_id LIMIT 1";
                        else
                            $sql = "UPDATE settings SET value='$value_escaped', description='$description' WHERE id=$settings_id LIMIT 1";
                        if (mysqli_query($conn,$sql))
                            {
                            ?>
                            <div class="alert alert-success mg-b-10" role="alert">
                                Амжилттай шинэчиллээ.
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
                                Алдаа гарлаа. <?php echo mysqli_error($conn);?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div><!-- alert --> 
                            <?php
                            }

                        ?>                            
                        <div class="btn-group">
                            <a href="settings.php?action=edit&id=<?php echo $settings_id;?>" class="btn btn-success"><i class="icon ion-edit"></i> Засах</a>
                            <a href="settings.php" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бусад тохиргоо</a>
                        </div>
                        </div>
                    </div>
                    </div><!-- col-12 -->
                </div><!-- row -->
                <?php
            }
            ?>
        
        <script>
        // Settings хайлтын функц
        function searchSettings() {
            const searchTerm = document.getElementById('settingsSearch').value.toLowerCase();
            const table = document.getElementById('settingsTable');
            const rows = table.getElementsByTagName('tr');
            
            let found = false;
            
            // Header row-ийг алгасах (index 0)
            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const text = row.textContent.toLowerCase();
                
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                    found = true;
                } else {
                    row.style.display = 'none';
                }
            }
            
            // Хэрэв олдохгүй бол мэдэгдэл харуулах
            if (!found && searchTerm !== '') {
                // Эсвэл энгийн alert
                // alert('Тохиргоо олдсонгүй: "' + searchTerm + '"');
            }
        }
        
        // Хайлтыг цэвэрлэх
        function clearSearch() {
            document.getElementById('settingsSearch').value = '';
            const table = document.getElementById('settingsTable');
            const rows = table.getElementsByTagName('tr');
            
            for (let i = 1; i < rows.length; i++) {
                rows[i].style.display = '';
            }
        }
        
        // Enter товч дарахад хайх
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('settingsSearch');
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        searchSettings();
                    }
                });
            }
        });
        </script>
        

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
	<!-- endinject -->

</body>
</html>    