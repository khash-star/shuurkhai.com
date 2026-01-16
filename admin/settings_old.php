<?
    require_once("config.php");
    require_once("views/helper.php");
    require_once("views/login_check.php");
    require_once("views/init.php");
?>
<body class="sidebar-dark">
	<div class="main-wrapper">
		<?  require_once("views/navbar.php"); ?>
	
		<div class="page-wrapper">
            <?  require_once("views/sidebar.php"); ?>
			
            <?  if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="display";?>

			<div class="page-content">
            <?
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
                                    <?
                                    $count =1;
                                    $sql = "SELECT *FROM settings_old";
                                    $result = mysqli_query($conn,$sql);
                                    if (mysqli_num_rows($result)>0)
                                    {
                                    while ($data = mysqli_fetch_array($result))
                                    {

                                        ?>
                                        <tr>
                                        <td><?=$count++;?></td>
                                        <td class="text-wrap"><h4><?=$data["param_name"];?></h4>
                                        </td>
                                        <td><?=$data["param_value"];?></td>
                                        <td><?=substr($data["timestamp"],0,10);?></td>
                                        <td class="tx-18">
                                            <div class="btn-group">
                                            <a href="settings_old?action=edit&id=<?=$data["settings_id"];?>"><i data-feather="edit"></i></a>
                                            </div>
                                        </td>
                                        </tr>
                                        <?
                                    }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?
            }
            ?>

            <?
            if ($action =="edit")
            {
                ?>
                <div class="row row-xs mg-t-10">
                <div class="col-lg-12">
                    <form action="settings_old?action=editing" method="post" enctype="multipart/form-data">
                    <div class="card card-customer-overview">
                        <div class="card-header">
                        <h6 class="slim-card-title">Тохиргоог засах</h6>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <?
                            if (isset($_GET["id"])) $settings_id=$_GET["id"]; else header("location:settings_old");
                            $sql = "SELECT *FROM settings_old WHERE settings_id=$settings_id LIMIT 1";
                            $result= mysqli_query($conn,$sql);
                            if (mysqli_num_rows($result)==1)
                            {
                            $data = mysqli_fetch_array($result);
                            ?>
                            <input type="hidden" name="settings_id" value="<?=$data["settings_id"];?>">
                            <div class="media-list mg-t-25">
                                <div class="media">
                                <div class="media-body mg-l-15 mg-t-4">
                                    <h6 class="tx-14 tx-gray-700">Нэр</h6>
                                    <input type="text" name="name" value="<?=$data["param_name"];?>" class="form-control" readonly="readonly">
                                </div><!-- media-body -->
                                </div><!-- media -->

                                <div class="media mg-t-25">
                                <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">Утга (*) </h6>
                                <input type="text" name="value" value="<?=$data["param_value"];?>" class="form-control">
                                  
                                </div><!-- media-body -->
                                </div><!-- media -->
                                

                            </div><!-- media-list -->
                                
                                
                            <div class="clearfix"></div><br>

                            <div class="btn-group">
                                <input type="submit" class="btn btn-success" value="Хадгалах">
                                <a href="settings_old" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бусад тохиргоо</a>
                            </div>
                            <?
                            }
                            ?>
                        </div><!-- card-body -->
                    </div><!-- card -->
                    </form>
                </div><!-- col-6 -->
                </div><!-- row -->
                <?
            }
            ?>


            <?
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
                        <?
                        if (isset($_POST["settings_id"])) $settings_id=$_POST["settings_id"]; else header("location:settings_old");

                        $value = $_POST["value"];
                        $sql = "UPDATE settings_old SET param_value='$value' WHERE settings_id=$settings_id LIMIT 1";
                      
                        if (mysqli_query($conn,$sql))
                            {
                            ?>
                            <div class="alert alert-success mg-b-10" role="alert">
                                Амжилттай шинэчиллээ.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div><!-- alert --> 
                            <?
                            }
                            else 
                            {
                            ?>
                            <div class="alert alert-danger mg-b-10" role="alert">
                                Алдаа гарлаа. <?=mysqli_error($conn);?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div><!-- alert --> 
                            <?
                            }

                        ?>                            
                        <div class="btn-group">
                            <a href="settings_old?action=edit&id=<?=$settings_id;?>" class="btn btn-success"><i class="icon ion-edit"></i> Засах</a>
                            <a href="settings_old" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бусад тохиргоо</a>
                        </div>
                        </div>
                    </div>
                    </div><!-- col-12 -->
                </div><!-- row -->
                <?
            }
            ?>
        

			</div>
      <? require_once("views/footer.php");?>
		
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