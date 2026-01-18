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
            <?php  if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="display";?>

            <?php
            if ($action =="display")
            {
                ?>
                <a href="advantages?action=new" class="btn btn-success mg-b-10">Нэмэх</a>
                <div class="card">

                    <div class="card-body">
                    <table class="table display responsive">
                        <thead>
                        <tr>
                            <th class="wd-5p">№</th>
                            <th class="wd-30p">Давуу тал</th>
                            <th class="wd-30p">Тайлбар</th>
                            <th class="wd-5p">Icon</th>
                            <th class="wd-10p">Зассан</th>
                            <th class="wd-5p">-</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $count = 1;
                        $sql = "SELECT * FROM advantages ORDER BY timestamp DESC";
                        $result = mysqli_query($conn,$sql);
                        if ($result && mysqli_num_rows($result) > 0)
                        {
                            while ($data = mysqli_fetch_array($result))
                            {
                                if (!$data) continue;
                                $id = isset($data["id"]) ? intval($data["id"]) : 0;
                                $name = isset($data["name"]) ? htmlspecialchars($data["name"]) : '';
                                $description = isset($data["description"]) ? htmlspecialchars($data["description"]) : '';
                                $icon = isset($data["icon"]) ? htmlspecialchars($data["icon"]) : '';
                                $timestamp = isset($data["timestamp"]) ? htmlspecialchars($data["timestamp"]) : '';

                            ?>
                            <tr>
                                <td><?php echo $count++;?></td>
                                <td><h4><?php echo $name;?></h4>
                                </td>
                                <td class="text-wrap"><?php echo $description;?>
                                </td>
                                <td><?php echo $icon;?></td>
                                <td><?php echo substr($timestamp,0,10);?></td>
                                <td class="tx-18">
                                <div class="btn-group">
                                    <a href="advantages?action=edit&id=<?php echo htmlspecialchars($id);?>"  class="btn btn-warning btn-xs text-white btn-icon" title="Засах"><i data-feather="edit"></i></a>
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
                <?php
            }
            ?>

            <?php
            if ($action =="edit")
            {
                ?>
                <form action="advantages?action=editing" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    if (isset($_GET["id"])) {
                                        $advantage_id = intval(protect($_GET["id"]));
                                    } else {
                                        header("location:advantages");
                                        exit;
                                    }
                                    $advantage_id_escaped = mysqli_real_escape_string($conn, $advantage_id);
                                    $sql = "SELECT * FROM advantages WHERE id=" . $advantage_id_escaped . " LIMIT 1";
                                    $result = mysqli_query($conn,$sql);
                                    if ($result && mysqli_num_rows($result) == 1)
                                    {
                                        $data = mysqli_fetch_array($result);
                                        if (!$data) {
                                            echo "Мэдээлэл олдсонгүй.";
                                        } else {
                                            $data_id = isset($data["id"]) ? intval($data["id"]) : 0;
                                            $data_name = isset($data["name"]) ? htmlspecialchars($data["name"]) : '';
                                            $data_description = isset($data["description"]) ? htmlspecialchars($data["description"]) : '';
                                            $data_icon = isset($data["icon"]) ? htmlspecialchars($data["icon"]) : '';
                                        ?>
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($data_id);?>">
                                        <div class="media-list">
                                            <div class="media">
                                                <div class="media-body mg-l-15 mg-t-4">
                                                <h6 class="tx-14 tx-gray-700">Нэр (*) </h6>
                                                    <input type="text" name="name" value="<?php echo $data_name;?>" class="form-control" required="required">
                                                </div>
                                            </div>

                                            <div class="media">
                                                <div class="media-body mg-l-15 mg-t-4">
                                                <h6 class="tx-14 tx-gray-700">Тайлбар </h6>
                                                    <input type="text" name="description" value="<?php echo $data_description;?>" class="form-control">
                                                </div>
                                            </div>

                                            <div class="media">
                                                <div class="media-body mg-l-15 mg-t-4">
                                                <h6 class="tx-14 tx-gray-700">Icon</h6>
                                                    <input type="text" name="icon" value="<?php echo $data_icon;?>" class="form-control">
                                                </div>
                                            </div>
                                        

                                        </div>
                                        <?php
                                        }
                                    }
                                    ?>
                                    <input type="submit" class="btn btn-success" value="Өөрчлөх">

                                </div>
                            </div>

                            <div class="btn-group">
                                <a href="advantages?action=delete&id=<?php echo htmlspecialchars($advantage_id ?? 0);?>" class="btn btn-danger btn-xs btn-icon-text"><i data-feather="trash"></i> Устгах</a>
                                <a href="advantages" class="btn btn-primary btn-xs btn-icon-text"><i data-feather="list"></i> Давуу талууд</a>
                            </div>
                        </div>
                    
                    </div>
                </form>
                <?php
            }
            ?>


            <?php
            if ($action =="editing")
            {
                ?>
                <div class="row row-xs mg-t-10">
                    <div class="col-lg-12">
                        <div class="card ">
                            <div class="card-body">
                                <?php
                                if (isset($_POST["id"])) {
                                    $advantage_id = intval(protect($_POST["id"]));
                                } else {
                                    header("location:advantages");
                                    exit;
                                }

                                $name = isset($_POST["name"]) ? protect($_POST["name"]) : '';
                                $description = isset($_POST["description"]) ? protect($_POST["description"]) : '';
                                $icon = isset($_POST["icon"]) ? protect($_POST["icon"]) : '';
                                
                                $name_escaped = mysqli_real_escape_string($conn, $name);
                                $description_escaped = mysqli_real_escape_string($conn, $description);
                                $icon_escaped = mysqli_real_escape_string($conn, $icon);
                                $advantage_id_escaped = mysqli_real_escape_string($conn, $advantage_id);
                                
                                $sql = "UPDATE advantages SET name='$name_escaped',`icon`='$icon_escaped', description='$description_escaped' WHERE id=" . $advantage_id_escaped . " LIMIT 1";

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

                                ?>                            
                                <div class="btn-group">
                                <a href="advantages?action=edit&id=<?php echo htmlspecialchars($advantage_id);?>" class="btn btn-warning btn-icon-text text-white btn-xs"><i data-feather="edit"></i> Засах</a>
                                <a href="advantages" class="btn btn-primary btn-icon-text text-white btn-xs"><i data-feather="list"></i> Давуу талууд</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>


            <?php
            if ($action =="new")
            {
                ?>
                <form action="advantages?action=adding" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    
                                    <div class="media-list">
                                        <div class="media">
                                            <div class="media-body mg-l-15 mg-t-4">
                                            <h6 class="tx-14 tx-gray-700">Нэр (*) </h6>
                                                <input type="text" name="name" value="" class="form-control" required="required">
                                            </div>
                                        </div>

                                        <div class="media">
                                            <div class="media-body mg-l-15 mg-t-4">
                                            <h6 class="tx-14 tx-gray-700">Тайлбар </h6>
                                                <input type="text" name="description" value="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="media">
                                            <div class="media-body mg-l-15 mg-t-4">
                                            <h6 class="tx-14 tx-gray-700">Icon</h6>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <a class="btn btn-warning" href="https://lineicons.com/icons/" target="new">Icon?</a>
													</div>
                                                    <input type="text" name="icon" value="" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    

                                    </div>
                                    <input type="submit" class="btn btn-success btn-xs" value="Хадгалах">

                                </div>
                                
                            </div>

                            <div class="btn-group">
                                <a href="advantages" class="btn btn-primary btn-icon-text btn-xs"><i data-feather="list"></i> Давуу талууд</a>
                            </div>
                        </div>
                    </div><!-- row -->
                </form>
                <?php
            }
            ?>


            <?php
            if ($action =="adding")
            {
                ?>
                <div class="row row-xs mg-t-10">
                    <div class="col-lg-12">
                        <div class="card ">
                            <div class="card-body">
                                <?php
                                
                                $name = isset($_POST["name"]) ? protect($_POST["name"]) : '';
                                $description = isset($_POST["description"]) ? protect($_POST["description"]) : '';
                                $icon = isset($_POST["icon"]) ? protect($_POST["icon"]) : '';
                                
                                $name_escaped = mysqli_real_escape_string($conn, $name);
                                $description_escaped = mysqli_real_escape_string($conn, $description);
                                $icon_escaped = mysqli_real_escape_string($conn, $icon);
                                
                                $sql = "INSERT INTO advantages (name,description,icon) VALUES ('$name_escaped','$description_escaped','$icon_escaped')";
                                if (mysqli_query($conn,$sql))
                                {
                                    $advantage_id = mysqli_insert_id($conn);
                                    ?>
                                    <div class="alert alert-success mg-b-10" role="alert">
                                    Амжилттай нэмлээ.
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

                                ?>                            
                                <div class="btn-group">
                                <a href="advantages?action=edit&id=<?php echo htmlspecialchars($advantage_id ?? 0);?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
                                <a href="advantages" class="btn btn-primary"><i data-feather="list"></i> Давуу талууд</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>

            <?php
            if ($action =="delete")
            {
                if (isset($_GET["id"])) {
                    $advantage_id = intval(protect($_GET["id"]));
                } else {
                    header("location:advantages");
                    exit;
                }
                ?>
                <div class="row row-xs mg-t-10">
                <div class="col-lg-12">
                    <div class="card ">
                    <div class="card-header">
                        <h6 class="slim-card-title">Тоон үзүүлэлт устгах</h6>
                    </div><!-- card-header -->
                    <div class="card-body">
                        <?php
                        $advantage_id_escaped = mysqli_real_escape_string($conn, $advantage_id);
                        $sql = "DELETE FROM advantages WHERE id=" . $advantage_id_escaped;
                        if (mysqli_query($conn,$sql))
                        {
                            ?>
                            <div class="alert alert-success mg-b-10" role="alert">
                            Устгалаа.
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

                        ?>                            
                        <div class="btn-group">
                        <a href="advantages" class="btn btn-primary"><i data-feather="list"></i> Давуу талууд</a>
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

  <script src="assets/js/dashboard.js"></script>
  <script src="assets/js/apexcharts.js"></script>




	<!-- endinject -->

</body>
</html>    