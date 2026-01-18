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
                        <div class="table-responsive">
                            <table class="table table-bordered">
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
                                    $sql = "SELECT * FROM appsettings ORDER BY name";
                                    $result = mysqli_query($conn,$sql);
                                    if ($result && mysqli_num_rows($result) > 0)
                                    {
                                        while ($data = mysqli_fetch_array($result))
                                        {
                                            if (!$data) continue;
                                            ?>
                                            <tr>
                                            <td><?php echo $count++;?></td>
                                            <td class="text-wrap"><h4><?php echo htmlspecialchars($data["name"] ?? '');?></h4>
                                            </td>
                                            <td><?php
                                            if (isset($data["type"]) && $data["type"]=="text") {
                                                echo htmlspecialchars($data["value"] ?? '');
                                            }
                                            ?></td>
                                            <td><?php echo isset($data["created_date"]) ? htmlspecialchars(substr($data["created_date"],0,10)) : '';?></td>
                                            <td class="tx-18">
                                                <div class="btn-group">
                                                <a href="?action=edit&id=<?php echo htmlspecialchars($data["id"] ?? '');?>"><i data-feather="edit"></i></a>
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
                    <form action="?action=editing" method="post" enctype="multipart/form-data">
                    <div class="card card-customer-overview">
                        <div class="card-header">
                        <h6 class="slim-card-title">Тохиргоог засах</h6>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <?php
                            if (isset($_GET["id"])) {
                                $settings_id = intval($_GET["id"]);
                            } else {
                                header("location:appsettings");
                                exit;
                            }
                            $sql = "SELECT * FROM appsettings WHERE id=$settings_id LIMIT 1";
                            $result = mysqli_query($conn,$sql);
                            if ($result && mysqli_num_rows($result) == 1)
                            {
                                $data = mysqli_fetch_array($result);
                                if ($data) {
                            ?>
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($data["id"] ?? '');?>">
                            <div class="media-list mg-t-25">
                                <div class="media">
                                    <div class="media-body mg-l-15 mg-t-4">
                                        <h6 class="tx-14 tx-gray-700">Нэр</h6>
                                        <input type="text" name="name" value="<?php echo htmlspecialchars($data["name"] ?? '');?>" class="form-control" readonly="readonly">
                                    </div>
                                </div>
                              
                                
                                <div class="media mg-t-25">
                                    <div class="media-body mg-l-15 mg-t-4">
                                        <h6 class="tx-14 tx-gray-700">Утга (*) </h6>
                                        <?php
                                            if (isset($data["type"]) && $data["type"]=="text")
                                            {
                                            ?>
                                                <input type="text" name="value" value="<?php echo htmlspecialchars($data["value"] ?? '');?>" class="form-control">
                                            <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                                

                            </div><!-- media-list -->
                                
                                
                            <div class="clearfix"></div><br>

                            <div class="btn-group">
                                <input type="submit" class="btn btn-success" value="Хадгалах">
                                <a href="settings.php" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бусад тохиргоо</a>
                            </div>
                            <?php
                                }
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
                        if (isset($_POST["id"])) {
                            $settings_id = intval($_POST["id"]);
                        } else {
                            header("location:appsettings");
                            exit;
                        }
                        
                        $sql = "SELECT * FROM appsettings WHERE id=$settings_id LIMIT 1";
                        $result = mysqli_query($conn,$sql);
                        if ($result && mysqli_num_rows($result) == 1) {
                            $data = mysqli_fetch_array($result);
                            if ($data && isset($data["type"])) {
                                $type = $data["type"];

                                if ($type=="text" && isset($_POST["value"])) {
                                    $value = protect($_POST["value"]);
                                    $value_escaped = mysqli_real_escape_string($conn, $value);
                                    $sql = "UPDATE appsettings SET value='$value_escaped' WHERE id=$settings_id LIMIT 1";                      

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
                                        Алдаа гарлаа. <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error';?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div><!-- alert --> 
                                    <?php
                                    }
                                }
                            }
                        }
                        ?>                            
                        <div class="btn-group">
                            <a href="?action=edit&id=<?php echo htmlspecialchars($settings_id);?>" class="btn btn-success"><i class="icon ion-edit"></i> Засах</a>
                            <a href="appsettings" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бусад тохиргоо</a>
                        </div>
                        </div>
                    </div>
                    </div><!-- col-12 -->
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
	<!-- endinject -->

</body>
</html>    