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
			

		<div class="page-content">
        <? 
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
                        <?
                        $sql = "SELECT *FROM pages ORDER BY update_date DESC";
                        $result = mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)>0)
                        {
                        $count=1;
                        while ($data = mysqli_fetch_array($result))
                        {

                            ?>
                            <tr>
                            <td><?=$count++;?></td>
                            <td><?=$data["title"];?></td>
                            <td><? if ($data["image"]<>"") echo '<img src="../'.$data["image"].'" width="100%">';?></td>
                            <td><?=$data["update_date"];?></td>
                            <td class="tx-18">
                                <div class="btn-group">
                                <a href="pages?action=detail&id=<?=$data["page_id"];?>" class="btn btn-success btn-xs btn-icon" title="Харах"><i data-feather="eye"></i></a>
                                <a href="pages?action=edit&id=<?=$data["page_id"];?>"  class="btn btn-warning btn-xs btn-icon text-white" title="Засах"><i data-feather="edit"></i></a>
                                </div>
                            </td>
                            </tr>
                            <?
                        }
                        }
                        ?>
                    </tbody>
                    </table>
                </div><!-- table-wrapper -->
                </div><!-- section-wrapper -->
                <a href="pages?action=new" class="btn btn-warning mt-3">Шинэ хуудас</a>
                <?
            }
            ?>
            <?
            if ($action =="detail")
            {
                //if (isset($_GET["id"])) $news_id=$_GET["id"]; else header("location:news.php");
                $sql = "SELECT *FROM pages WHERE page_id='".$page_id."' LIMIT 1";
                $result= mysqli_query($conn,$sql);
                if (mysqli_num_rows($result)==1)
                {
                $data = mysqli_fetch_array($result);
                $image = $data["image"];              
                $title = $data["title"];
                $image = $data["image"];
                $content = $data["content"];
                //$count = $data["count"];
                $update_date = $data["update_date"];
                ?>            
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-customer-overview">
                        <div class="card-body">
                            <div class="media-list mg-t-25">
                            <div class="media mg-t-25">
                                <div class="media-body mg-l-15 mg-t-4">
                                <h3><?=$title;?></h3>
                                <h4><?=$update_date;?></h4>
                                <? if ($image<>"") echo '<img src="../'.$image.'" style="width: 100%"><br>';?>
                                <?=$content;?>
                                </div><!-- media-body -->
                            </div><!-- media -->
                            </div><!-- media-list -->      
                        <a href="pages?action=edit&id=<?=$page_id;?>" class="btn btn-success">Засах</a>                                                       
                        </div><!-- card-body -->
                        </div><!-- card -->
                    </div><!-- col-12 -->
                    </div><!-- row -->
                    <a href="pages" class="btn btn-primary">Бүх хуудсууд</a>
                <?
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
                <?
                }
            }
            ?>

            <?
            if ($action =="edit")
            {                
                $sql = "SELECT *FROM pages WHERE page_id='".$page_id."' LIMIT 1";
                $result= mysqli_query($conn,$sql);
                if (mysqli_num_rows($result)==1)
                {
                    $data = mysqli_fetch_array($result);
                    $page_id = $data["page_id"];
                    $image = $data["image"];              
                    $pagename = $data["title"];
                    $content = $data["content"];
                    $timestamp = $data["timestamp"];
                    ?>            
                    <form action="pages?action=editing" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="page_id" value="<?=$page_id;?>">
                        <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-customer-overview">
                            <div class="card-body">
                                <div class="media-list mg-t-25">
                                <h3><?=$pagename;?></h3>
                                <div class="media mg-t-25">
                                    <div class="media-body mg-l-15 mg-t-4">
                                    <input type="text" name="title" value="<?=$pagename;?>" class="form-control mb-3">
                                    <?($image<>"")?'<img src="../<?=$image;?>" style="width: 100%"><br>':'';?>
                                    <input type="file" name="image" class="form-control mb-3">
                                    <textarea name="content" class="form-control mb-3"><?=$content;?></textarea>
                                    </div><!-- media-body -->
                                </div><!-- media -->
                                </div><!-- media-list -->      
                                <input type="submit" value="Хадгалах" class="btn btn-success">                                                       
                            </div><!-- card-body -->
                            </div><!-- card -->
                        </div><!-- col-6 -->
                        </div><!-- row -->
                    </form>
                    <a href="pages?action=delete&id=<?=$page_id;?>" class="btn btn-danger btn-xs">Устгах</a>
                    <a href="pages" class="btn btn-primary btn-xs">Бүх хуудсууд</a>
                    <?
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
                <?
                }
            }
            ?>


            <?
            if ($action =="editing")
            {
                $page_id = $_POST["page_id"];
                $name = $_POST["name"];
                $content = $_POST["content"];
                // $content = substr($content,3,-4);

                $title = $_POST["title"];


                ?>
                <div class="row row-xs mg-t-10">
                <div class="col-lg-12">
                    <?
                    $sql = "UPDATE pages SET content='$content', title='$title', `update_date`='".date("Y-m-d H:i:s")."' WHERE page_id='$page_id'";
                    //echo $sql;

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
                    <?
                    }
                    else 
                    {
                    ?>
                    <div class="alert alert-danger mg-b-10" role="alert">
                    Алдаа гарлаа. <?=mysqli_query($conn,$sql);?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div><!-- alert --> 
                    <?
                    }
                    ?>
                </div><!-- col-lg-12 -->
                <div class="btn-group">
                    <a href="pages?pagename=<?=$pagename;?>" class="btn btn-success">Засах</a>
                    <a href="pages" class="btn btn-primary">Бүх хуудсууд</a>
                </div>
                </div><!-- row -->
                <?
            }
            ?>


            <?
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
                <?
            }
            ?>


            <?
            if ($action =="adding")
            {
                $title = $_POST["title"];
                $content = $_POST["content"];
                // $content = substr($content,3,-4);



                ?>
                <div class="row row-xs mg-t-10">
                <div class="col-lg-12">
                    <?
                    $sql = "INSERT INTO pages (title,content,update_date) VALUES('$title','$content','".date("Y-m-d H:i:s")."')";

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
                </div><!-- col-lg-12 -->
                <div class="btn-group">
                    <a href="pages?action=edit&id=<?=$page_id;?>" class="btn btn-success">Засах</a>
                    <a href="pages" class="btn btn-primary"><i class="icon ion-list"></i> Бүх хуудсууд</a>
                </div>
                </div><!-- row -->
                <?
            }
            ?>

            <?
            if ($action =="delete")
            {
                $page_id = $_GET["id"];

                ?>
                <div class="row row-xs mg-t-10">
                <div class="col-lg-12">
                    <?
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
                    <?
                    }
                    else 
                    {
                    ?>
                    <div class="alert alert-danger mg-b-10" role="alert">
                    Алдаа гарлаа. <?=mysqli_query($conn,$sql);?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div><!-- alert --> 
                    <?
                    }
                    ?>
                </div><!-- col-lg-12 -->
                <div class="btn-group">
                    <a href="pages" class="btn btn-primary">Бүх хуудсууд</a>
                </div>
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

  <script src="assets/js/dashboard.js"></script>
  <script src="assets/js/apexcharts.js"></script>




	<!-- endinject -->

</body>
</html>    