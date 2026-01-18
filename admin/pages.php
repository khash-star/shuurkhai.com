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
            if (isset($_GET["id"])) $page_id=protect($_GET["id"]); else $page_id = 1;
            if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="display";

            if ($action =="display")
            {
                ?>
                <a href="pages?action=new" class="btn btn-warning mb-3">Шинэ хуудас</a>
                <div class="card">
                <div class="card-body">
                    <table id="datatable1" class="table display responsive nowrap">
                    <thead>
                        <tr>
                        <th class="wd-10p">№</th>
                        <th class="wd-20p">Нэр</th>
                        <th class="wd-20p">Зураг</th>
                        <th class="wd-20p">Шинэчилсэн</th>
                        <th class="wd-10p">Үйлдэл</th>
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
                                    <a href="pages?action=detail&id=<?php echo htmlspecialchars($data["page_id"] ?? '');?>" class="btn btn-success btn-xs btn-icon" title="Харах"><i data-feather="eye"></i></a>
                                    <a href="pages?action=edit&id=<?php echo htmlspecialchars($data["page_id"] ?? '');?>"  class="btn btn-warning btn-xs btn-icon text-white" title="Засах"><i data-feather="edit"></i></a>
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
                <a href="pages?action=new" class="btn btn-warning mt-3">Шинэ хуудас</a>
                <?php
            }
            ?>
            <?php
            if ($action =="detail")
            {
                $page_id_escaped = mysqli_real_escape_string($conn, $page_id);
                $sql = "SELECT * FROM pages WHERE page_id='$page_id_escaped' LIMIT 1";
                $result = mysqli_query($conn,$sql);
                if ($result && mysqli_num_rows($result) == 1)
                {
                    $data = mysqli_fetch_array($result);
                    if ($data) {
                        $image = isset($data["image"]) ? htmlspecialchars($data["image"]) : '';
                        $title = isset($data["title"]) ? htmlspecialchars($data["title"]) : '';
                        $content = isset($data["content"]) ? $data["content"] : '';
                        $update_date = isset($data["update_date"]) ? htmlspecialchars($data["update_date"]) : '';
                    ?>            
                        <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-customer-overview">
                            <div class="card-body">
                                <div class="media-list mg-t-25">
                                <div class="media mg-t-25">
                                    <div class="media-body mg-l-15 mg-t-4">
                                    <h3><?php echo $title;?></h3>
                                    <h4><?php echo $update_date;?></h4>
                                    <?php if ($image<>"") echo '<img src="../'.htmlspecialchars($image).'" style="width: 100%"><br>';?>
                                    <?php echo $content;?>
                                    </div><!-- media-body -->
                                </div><!-- media -->
                                </div><!-- media-list -->      
                            <a href="pages?action=edit&id=<?php echo htmlspecialchars($page_id);?>" class="btn btn-success">Засах</a>                                                       
                            </div><!-- card-body -->
                            </div><!-- card -->
                        </div><!-- col-12 -->
                        </div><!-- row -->
                        <a href="pages" class="btn btn-primary">Бүх хуудсууд</a>
                    <?php
                    }
                }
                else 
                {
                ?>
                <div class="alert alert-danger mg-b-10" role="alert">
                    Мэдээ олдсонгүй.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div><!-- alert --> 
                <?php
                }
            }
            ?>

            <?php
            if ($action =="edit")
            {
                $page_id_escaped = mysqli_real_escape_string($conn, $page_id);
                $sql = "SELECT * FROM pages WHERE page_id='$page_id_escaped' LIMIT 1";
                $result = mysqli_query($conn,$sql);
                if ($result && mysqli_num_rows($result) == 1)
                {
                    $data = mysqli_fetch_array($result);
                    if ($data) {
                        $page_id = intval($data["page_id"] ?? 0);
                        $image = isset($data["image"]) ? htmlspecialchars($data["image"]) : '';
                        $pagename = isset($data["title"]) ? htmlspecialchars($data["title"]) : '';
                        $content = isset($data["content"]) ? $data["content"] : '';
                        $timestamp = isset($data["timestamp"]) ? htmlspecialchars($data["timestamp"]) : '';
                    ?>            
                        <form action="pages?action=editing" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="page_id" value="<?php echo htmlspecialchars($page_id);?>">
                            <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-customer-overview">
                                <div class="card-body">
                                    <div class="media-list mg-t-25">
                                    <h3><?php echo $pagename;?></h3>
                                    <div class="media mg-t-25">
                                        <div class="media-body mg-l-15 mg-t-4">
                                        <input type="text" name="title" value="<?php echo htmlspecialchars($pagename);?>" class="form-control mb-3">
                                        <?php if ($image<>"") echo '<img src="../'.htmlspecialchars($image).'" style="width: 100%"><br>';?>
                                        <input type="file" name="image" class="form-control mb-3">
                                        <textarea name="content" class="form-control mb-3"><?php echo htmlspecialchars($content);?></textarea>
                                        </div><!-- media-body -->
                                    </div><!-- media -->
                                    </div><!-- media-list -->      
                                    <input type="submit" value="Хадгалах" class="btn btn-success">                                                       
                                </div><!-- card-body -->
                                </div><!-- card -->
                            </div><!-- col-6 -->
                            </div><!-- row -->
                        </form>
                        <a href="pages?action=delete&id=<?php echo htmlspecialchars($page_id);?>" class="btn btn-danger btn-xs">Устгах</a>
                        <a href="pages" class="btn btn-primary btn-xs">Бүх хуудсууд</a>
                        <?php
                    }
                }
                else 
                {
                ?>
                <div class="alert alert-danger mg-b-10" role="alert">
                    Хуудас олдсонгүй.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div><!-- alert --> 
                <?php
                }
            }
            ?>


            <?php
            if ($action =="editing")
            {
                $page_id = isset($_POST["page_id"]) ? intval($_POST["page_id"]) : 0;
                $title = isset($_POST["title"]) ? protect($_POST["title"]) : '';
                $content = isset($_POST["content"]) ? protect($_POST["content"]) : '';

                ?>
                <div class="row row-xs mg-t-10">
                <div class="col-lg-12">
                    <?php
                    $title_escaped = mysqli_real_escape_string($conn, $title);
                    $content_escaped = mysqli_real_escape_string($conn, $content);
                    $sql = "UPDATE pages SET content='$content_escaped', title='$title_escaped', `update_date`='".date("Y-m-d H:i:s")."' WHERE page_id='$page_id'";

                    if (mysqli_query($conn,$sql))
                    {
                    $image ="";
                        if(isset($_FILES['image']) && $_FILES['image']['name']!="")
                        {
                            if ($_FILES['image']['name']!="")
                                {                        
                                    @$folder = date("Ym");
                                    if(!file_exists('../uploads/'.$folder))
                                    mkdir ( '../uploads/'.$folder);
                                    $target_dir = '../uploads/'.$folder;
                                    $target_file = $target_dir."/".@date("his").rand(0,1000). basename($_FILES["image"]["name"]);
                                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file))
                                    $image=substr($target_file,3);
                                    //$image =settings("base_url").$image;
                                    //$thumb_image_content = resize_image($image,300,200);
                                    //$thumb = substr($image,0,-4)."_thumb".substr($image,-4,4);
                                    //imagejpeg($thumb_image_content,$thumb,75);
                                }
                        }
                        if ($image!="")
                        {
                        mysqli_query($conn,"UPDATE pages SET image='$image' WHERE page_id='$page_id'");
                        }


                    ?>
                    <div class="alert alert-success mg-b-10" role="alert">
                        Амжилттай заслаа.
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
                </div><!-- col-lg-12 -->
                <div class="btn-group">
                    <a href="pages?action=edit&id=<?php echo htmlspecialchars($page_id);?>" class="btn btn-success">Засах</a>
                    <a href="pages" class="btn btn-primary">Бүх хуудсууд</a>
                </div>
                </div><!-- row -->
                <?php
            }
            ?>


            <?php
            if ($action =="new")
            {
                ?>            
                <form action="pages?action=adding" method="post" enctype="multipart/form-data">
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-customer-overview">
                        <div class="card-body">
                            <div class="media-list mg-t-25">
                            <div class="media mg-t-25">
                                <div class="media-body mg-l-15 mg-t-4">
                                <input type="text" name="title" class="form-control mb-3" placeholder="Хуудсын гарчиг" required="required">

                                <i>Хаяг англиар байх бөгөөд хоосон зай орох боломжгүй</i><br>

                                <input type="file" name="image" class="form-control mb-3"><br>
                                <i>Хуудсын толгой хэсэгт харагдах зураг байна</i><br>
                                <textarea name="content" class="editable form-control mb-3"></textarea>
                                </div><!-- media-body -->
                            </div><!-- media -->
                            </div><!-- media-list -->      
                            <input type="submit" value="Хадгалах" class="btn btn-success">                                                       
                        </div><!-- card-body -->
                        </div><!-- card -->
                    </div><!-- col-6 -->
                    </div><!-- row -->
                </form>
                <?php
            }
            ?>


            <?php
            if ($action =="adding")
            {
                $title = isset($_POST["title"]) ? protect($_POST["title"]) : '';
                $content = isset($_POST["content"]) ? protect($_POST["content"]) : '';

                ?>
                <div class="row row-xs mg-t-10">
                <div class="col-lg-12">
                    <?php
                    $title_escaped = mysqli_real_escape_string($conn, $title);
                    $content_escaped = mysqli_real_escape_string($conn, $content);
                    $sql = "INSERT INTO pages (title,content,update_date) VALUES('$title_escaped','$content_escaped','".date("Y-m-d H:i:s")."')";

                    if (mysqli_query($conn,$sql))
                    {
                    $page_id = mysqli_insert_id($conn);
                    $image ="";
                        if(isset($_FILES['image']) && $_FILES['image']['name']!="")
                        {
                            if ($_FILES['image']['name']!="")
                                {                        
                                    @$folder = date("Ym");
                                    if(!file_exists('../uploads/'.$folder))
                                    mkdir ( '../uploads/'.$folder);
                                    $target_dir = '../uploads/'.$folder;
                                    $target_file = $target_dir."/".@date("his").rand(0,1000). basename($_FILES["image"]["name"]);
                                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file))
                                    $image=substr($target_file,3);
                                    //$image =settings("base_url").$image;
                                    //$thumb_image_content = resize_image($image,300,200);
                                    //$thumb = substr($image,0,-4)."_thumb".substr($image,-4,4);
                                    //imagejpeg($thumb_image_content,$thumb,75);
                                }
                        }
                        if ($image!="")
                        {
                        mysqli_query($conn,"UPDATE pages SET image='$image' WHERE page_id='$page_id'");
                        }


                    ?>
                    <div class="alert alert-success mg-b-10" role="alert">
                        Амжилттай орууллаа.
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
                </div><!-- col-lg-12 -->
                <div class="btn-group">
                    <a href="pages?action=edit&id=<?php echo htmlspecialchars($page_id);?>" class="btn btn-success">Засах</a>
                    <a href="pages" class="btn btn-primary"><i class="icon ion-list"></i> Бүх хуудсууд</a>
                </div>
                </div><!-- row -->
                <?php
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