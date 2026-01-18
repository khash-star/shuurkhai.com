<?php require_once("config.php");?>
<?php require_once("views/helper.php");?>
<?php require_once("views/login_check.php");?>
<?php require_once("views/init.php");?>
    
    <link rel="stylesheet" href="assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="assets/vendor/libs/select2/select2.css" />

<?php
    if (isset($_GET["action"])) $action=$_GET["action"]; else $action="list";
    ?>

    
    <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <?php require_once("views/sidebar.php");?>

        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          
          <?php require_once("views/header.php");?>


          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="d-flex justify-content-between">
                    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Settings/</span> panel</h4>

                    <div class="mt-3">
                        <div class="btn-group">
                            <button
                            type="button"
                            class="btn btn-primary dropdown-toggle"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Menu
                            </button>
                            <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?action=list">All settings</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <?php 
                if ($action=="list")
                {
                    ?><!-- Basic table -->
                    <section id="basic-datatable">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <table class="datatables-basic table">
                                    <thead>
                                        <tr>
                                        <th class="wd-5p">№</th>
                                        <th class="wd-30p">Name</th>
                                        <th class="wd-40p">Value</th>
                                        <th class="wd-10p">Updated</th>
                                        <th class="wd-5p">-</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                    <?php 
                                        $count =1;
                                        $sql = "SELECT * FROM settings ORDER BY name DESC";
                                        $result = mysqli_query($conn,$sql);
                                        if (mysqli_num_rows($result)>0)
                                        {
                                        while ($data = mysqli_fetch_array($result))
                                        {

                                            ?>
                                            <tr>
                                            <td><?php echo $count++;?></td>
                                            <td><h4><?php echo htmlspecialchars($data["name"] ?? '');?></h4>
                                                <i><?php echo htmlspecialchars($data["description"] ?? '');?></i>
                                            </td>
                                            <td><?php
                                            if ($data["type"]=="t") echo htmlspecialchars($data["value"] ?? '');
                                            if ($data["type"]=="c") echo htmlspecialchars($data["value"] ?? '');
                                            if ($data["type"]=="i" &&  ($data["value"] ?? '')<>"") echo "<img src='../". htmlspecialchars($data["value"])."' style='max-width:60px; max-height:60px;'>";
                                            if ($data["type"]=="f" &&  ($data["value"] ?? '')<>"") echo "<a href='". htmlspecialchars($data["value"])."' target='new' class='btn btn-success'>Татах</a>";
                                            if ($data["type"]=="b") 
                                                if ($data["value"] ?? '') echo "<span class='tx-14 tx-success'>On</span>"; else echo "<span class='tx-14 tx-danger'>Off</span>";

                                            ?></td>
                                            <td><?php echo htmlspecialchars(substr($data["update_date"] ?? '',0,10));?></td>
                                            <td class="tx-18">
                                                <div class="btn-group">
                                                
                                                    <a href="settings?action=edit&id=<?php echo htmlspecialchars($data["id"] ?? '');?>"  class="btn btn-success btn-icon" title="Edit"><i class="fa-regular fa-pen-to-square"></i></a>
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
                    </section>
                    <!--/ Basic table -->
                    <?php 
                }
                ?>

                <?php 
                if ($action=="edit")
                {
                    $settings_id = $_GET["id"];
                    $sql = "SELECT * FROM settings WHERE id=".intval($settings_id)." LIMIT 1";
                    $result = mysqli_query($conn,$sql);
                    if (mysqli_num_rows($result)==1)
                    {
                        $data = mysqli_fetch_array($result);
                        ?>
                    
                        <section id="input-group-basic">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Edit</h4>
                                        </div>
                                        <div class="card-body">
                                            <form action="settings?action=editing" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($data["id"] ?? '');?>">
                                                <input type="hidden" name="type" value="<?php echo htmlspecialchars($data["type"] ?? '');?>">
                                                <div class="media-list mt-3">
                                                    <div class="media">
                                                    <div class="media-body mg-l-15 mg-t-4">
                                                        <h6 class="tx-14 tx-gray-700">Name  (*)</h6>
                                                        <input type="text" name="name" value="<?php echo htmlspecialchars($data["name"] ?? '');?>" class="form-control" readonly="readonly">
                                                    </div><!-- media-body -->
                                                    </div><!-- media -->
                                                    <div class="media mt-3">
                                                    <div class="media-body mg-l-15 mg-t-4">
                                                        <h6 class="tx-14 tx-gray-700">Meta (*)</h6>
                                                        <input type="text" name="description" value="<?php echo htmlspecialchars($data["description"] ?? '');?>" class="form-control" required="required">
                                                    </div><!-- media-body -->
                                                    </div><!-- media -->
                                                    <div class="media mt-3">
                                                    <div class="media-body mg-l-15 mg-t-4">
                                                        <h6 class="tx-14 tx-gray-700">Value (*) </h6>
                    <?php 
                                                        if ($data["type"]=="t")
                                                        {
                                                        ?>
                                                        <input type="text" name="value" value="<?php echo htmlspecialchars($data["value"] ?? '');?>" class="form-control">
                    <?php 
                                                        };

                                                        if ($data["type"]=="c")
                                                        {
                                                        ?>
                                                            <textarea class="form-control" name="value"><?php echo htmlspecialchars($data["value"] ?? '');?></textarea>
                    <?php 
                                                        };


                                                        if ($data["type"]=="i")
                                                        {
                                                        if ($data["value"]<>"") 
                                                        {
                                                            ?>
                                                            <img src="../<?=$data["value"];?>" style="max-width:100%;">
                    <?php 
                                                        };
                                                        ?>
                                                            <br>
                                                        <input type="file" name="value">
                    <?php 
                                                        };
                                                        

                                                        if ($data["type"]=="f")
                                                        {
                                                        if ($data["value"]<>"") 
                                                        {
                                                            ?>
                                                            <a href="../<?php echo htmlspecialchars($data["value"] ?? '');?>" target="new" class="btn btn-warning">Татах</a>
                    <?php 
                                                        };
                                                        ?>
                                                            <br>
                                                        <input type="file" name="value">
                    <?php 
                                                        };

                                                        if ($data["type"]=="b")
                                                        {
                                                        ?>
                                                            <div class="toggle-wrapper">
                                                            <input type="hidden" name="value" value="<?php echo htmlspecialchars($data["value"] ?? '');?>" id="value">
                                                            <div class="toggle toggle-light success" id="toggle"></div>
                                                            </div>
                    <?php 
                                                        };


                                                        ?>
                                                        

                                                    
                                                    </div><!-- media-body -->
                                                    </div><!-- media -->
                                                    

                                                </div><!-- media-list -->
                                                    
                                                    
                                                <div class="clearfix"></div><br>

                                                <div class="btn-group">
                                                    <button type="submit" class="btn btn-success" value="">Save</button>
                                                    <a href="settings" class="btn btn-primary">Settings</a>
                                                </div>
                                            </form>                                       
                                        </div>
                                    </div>
                                </div>
                            
                            
                            </div>
                        </section>
                    <?php 
                                                    }
                                                }
                                                ?>


                <?php 
                if ($action=="editing")
                {
                    if (isset($_POST["id"])) $settings_id=$_POST["id"]; else header("location:settings");
                    $type = $_POST["type"];

                    if ($type=="t") $value = $_POST["value"];
                    if ($type=="c") $value = $_POST["value"];
                    if ($type=="b") $value = $_POST["value"];
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
                            $thumb_image_content = resize_image($target_file,300,300);
                            $thumb = substr($target_file,0,-4)."_thumb".substr($target_file,-4,4);
                            imagejpeg($thumb_image_content,$thumb,75);
                            //$target_file = substr($target_file,3);
                            //$thumb = substr($thumb,3);
                            $value=$thumb;
                            if (substr($value,0,3)=="../") $value=substr($value,3);

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
                            $value=$target_file;
                            if (substr($value,0,3)=="../") $value=substr($value,3);
                        }
                    } 
                    $description = $_POST["description"];
                    //if ($value=="")
                    //  $sql = "UPDATE settings SET description='$description' WHERE id=$settings_id LIMIT 1";
                    // if ($value<>"")
                    $sql = "UPDATE settings SET value='$value', description='$description' WHERE id=$settings_id LIMIT 1";
                    //  echo $sql;
                    if (mysqli_query($conn,$sql))
                        {
                        ?>
                        <div class="alert alert-success" role="alert">
                                <div class="alert-body">
                                Updated
                                </div>
                            </div>
                    <?php 
                        }
                        else 
                        {
                        ?>
                        <div class="alert alert-danger" role="alert">
                            <div class="alert-body">
                            Error occured. <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error';?>
                            </div>
                        </div>
                    <?php 
                        }

                    ?>                            
                    <div class="btn-group">
                        <a href="settings?action=edit&id=<?php echo htmlspecialchars($settings_id ?? '');?>" class="btn btn-success"><i class="icon ion-edit"></i> Edit</a>
                        <a href="settings" class="btn btn-primary"><i class="icon ion-ios-list"></i> Settings</a>
                    </div>   
                    <?php                                 
                }
                ?>

              </div>
            </div>
            <!-- / Content -->

            <?php require_once("views/footer.php");?>


            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>

      <!-- Drag Target Area To SlideIn Menu On Small Screens -->
      <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/libs/hammer/hammer.js"></script>
    <script src="assets/vendor/libs/i18n/i18n.js"></script>
    <script src="assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="assets/vendor/libs/moment/moment.js"></script>
    <script src="assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="assets/vendor/libs/select2/select2.js"></script>
    <script src="assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
    <script src="assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>
    <script src="assets/vendor/libs/cleavejs/cleave.js"></script>
    <script src="assets/vendor/libs/cleavejs/cleave-phone.js"></script>

    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

    <!-- Page JS -->
    <!-- <script src="assets/js/app-user-list.js"></script> -->
  </body>
</html>
