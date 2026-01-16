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
                                    $sql = "SELECT *FROM settings ORDER BY name DESC";
                                    $result = mysqli_query($conn,$sql);
                                    if (mysqli_num_rows($result)>0)
                                    {
                                    while ($data = mysqli_fetch_array($result))
                                    {

                                        ?>
                                        <tr>
                                        <td><?=$count++;?></td>
                                        <td class="text-wrap"><h4><?=$data["name"];?></h4>
                                            <i><?=$data["description"];?></i>
                                        </td>
                                        <td><?
                                        if ($data["type"]=="t") echo $data["value"];
                                        if ($data["type"]=="c") echo $data["value"];
                                        if ($data["type"]=="i" &&  $data["value"]<>"") echo "<img src='../". $data["value"]."' style='max-width:60px; max-height:60px;'>";
                                        if ($data["type"]=="f" &&  $data["value"]<>"") echo "<a href='". $data["value"]."' target='new' class='btn btn-success'>Татах</a>";
                                        if ($data["type"]=="b") 
                                            if ($data["value"]) echo "<span class='tx-14 tx-success'>On</span>"; else echo "<span class='tx-14 tx-danger'>Off</span>";

                                        ?></td>
                                        <td><?=substr($data["update_date"],0,10);?></td>
                                        <td class="tx-18">
                                            <div class="btn-group">
                                            <a href="settings.php?action=edit&id=<?=$data["id"];?>"><i data-feather="edit"></i></a>
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
                    <form action="settings.php?action=editing" method="post" enctype="multipart/form-data">
                    <div class="card card-customer-overview">
                        <div class="card-header">
                        <h6 class="slim-card-title">Тохиргоог засах</h6>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <?
                            if (isset($_GET["id"])) $settings_id=$_GET["id"]; else header("location:settings.php");
                            $sql = "SELECT *FROM settings WHERE id=$settings_id LIMIT 1";
                            $result= mysqli_query($conn,$sql);
                            if (mysqli_num_rows($result)==1)
                            {
                            $data = mysqli_fetch_array($result);
                            ?>
                            <input type="hidden" name="id" value="<?=$data["id"];?>">
                            <input type="hidden" name="type" value="<?=$data["type"];?>">
                            <div class="media-list mg-t-25">
                                <div class="media">
                                <div class="media-body mg-l-15 mg-t-4">
                                    <h6 class="tx-14 tx-gray-700">Нэр</h6>
                                    <input type="text" name="name" value="<?=$data["name"];?>" class="form-control" readonly="readonly">
                                </div><!-- media-body -->
                                </div><!-- media -->
                                <div class="media mg-t-25">
                                <div class="media-body mg-l-15 mg-t-4">
                                    <h6 class="tx-14 tx-gray-700">Тайлбар (*)</h6>
                                    <input type="text" name="description" value="<?=$data["description"];?>" class="form-control" required="required">
                                </div><!-- media-body -->
                                </div><!-- media -->
                                <div class="media mg-t-25">
                                <div class="media-body mg-l-15 mg-t-4">
                                    <h6 class="tx-14 tx-gray-700">Утга (*) </h6>
                                    <?
                                    if ($data["type"]=="t")
                                    {
                                    ?>
                                    <input type="text" name="value" value="<?=$data["value"];?>" class="form-control">
                                    <?
                                    };

                                    if ($data["type"]=="c")
                                    {
                                    ?>
                                        <textarea class="form-control" name="value"><?=$data["value"];?></textarea>
                                    <?
                                    };


                                    if ($data["type"]=="i")
                                    {
                                    if ($data["value"]<>"") 
                                    {
                                        ?>
                                        <img src="../<?=$data["value"];?>" style="max-width:100%;">
                                        <?
                                    };
                                    ?>
                                        <br>
                                    <input type="file" name="value">
                                    <?
                                    };
                                    

                                    if ($data["type"]=="f")
                                    {
                                    if ($data["value"]<>"") 
                                    {
                                        ?>
                                        <a href="../<?=$data["value"];?>" target="new" class="btn btn-warning">Татах</a>
                                        <?
                                    };
                                    ?>
                                        <br>
                                    <input type="file" name="value">
                                    <?
                                    };

                                    if ($data["type"]=="b") 
                                    {
                                        ?>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" <?=$data["value"]?'checked':'';?> class="form-check-input" name="value">
                                                Нээх
                                            </label>
                                        </div>
                                        <?
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
                        if (isset($_POST["id"])) $settings_id=$_POST["id"]; else header("location:settings.php");
                        $type = $_POST["type"];

                        if ($type=="t") $value = $_POST["value"];
                        if ($type=="c") $value = $_POST["value"];
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
                        if ($value=="")
                            $sql = "UPDATE settings SET description='$description' WHERE id=$settings_id LIMIT 1";
                        if ($value<>"")
                            $sql = "UPDATE settings SET value='$value', description='$description' WHERE id=$settings_id LIMIT 1";
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
                            <a href="settings.php?action=edit&id=<?=$settings_id;?>" class="btn btn-success"><i class="icon ion-edit"></i> Засах</a>
                            <a href="settings.php" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бусад тохиргоо</a>
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