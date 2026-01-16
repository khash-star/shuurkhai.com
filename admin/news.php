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
            <? if (isset($_GET['action'])) $action=$_GET['action']; else $action="display";?>

            <?
            if ($action=="display")
            {
                $sql = "SELECT *FROM news ORDER BY timestamp DESC LIMIT 50";
                $result = mysqli_query($conn,$sql);
                if (mysqli_num_rows($result)>0)
                {
                  $count =1;
                  while ($data = mysqli_fetch_array($result))
                  {
                    $id = $data["id"];
                    $category = $data["category"];

                      $sql_cat = "SELECT *FROM news_category WHERE id=$category";
                      $result_cat = mysqli_query($conn,$sql_cat);
                      $data_cat = mysqli_fetch_array($result_cat);
                      $category_name=$data_cat["name"];

                    $title = $data["title"];
                    $image = $data["image"];
                    $text = $data["text"];
                    $count = $data["count"];
                    $timestamp = $data["timestamp"];
                    ?>
                    <div class="card mt-3">
                      <div class="row">
                        <div class="col-md-5 col-lg-6 col-xl-5">
                          <figure class="mb-0">
                            <a href="news?action=detail&id=<?=$id;?>">
                                <img src="../<?=$image;?>" class="w-100" alt="<?=$title;?>">
                            </a>
                          </figure>
                        </div><!-- col-4 -->
                        <div class="col-md-7 col-lg-6 col-xl-7">
                          <p class="blog-category tx-danger"><?=$category_name;?></p>
                          <h5 class="blog-title">
                              <a href="news?action=detail&id=<?=$id;?>">
                            <?=$title;?>
                            
                            </a></h5>
                          <p class="blog-text" style="max-height: 250px; overflow-x: hidden; overflow-y: auto;"><?=$text;?></p>
                          <span class="blog-date"><?=substr($timestamp,0,10);?></span>
                          <br>
                          <span class="blog-date">
                            <a href="news?action=edit&id=<?=$id;?>" class="btn btn-warning btn-icon-text btn-sm text-white" title="Мэдээг засах"><i data-feather="edit"></i> Засах</a>
                          </span>
                        </div><!-- col-8 -->
                      </div><!-- row -->
                    </div><!-- card -->
                    <?
                    //$count++;
                  }
                }
                else 
                {
                  ?>
                  <div class="alert alert-danger mg-b-10 col-lg-12" role="alert">
                    Мэдээ байхгүй.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div><!-- alert --> 
                  <?
                }
            }
            ?>


            <?
            if ($action =="detail")
            {
              if (isset($_GET["id"])) $news_id=$_GET["id"]; else header("location:news");
              $sql = "SELECT *FROM news WHERE id=$news_id LIMIT 1";
              $result= mysqli_query($conn,$sql);
              if (mysqli_num_rows($result)==1)
              {
                $data = mysqli_fetch_array($result);
                $id = $data["id"];
                $category = $data["category"];              
                $title = $data["title"];
                $image = $data["image"];
                $content = $data["content"];
                $count = $data["count"];
                $timestamp = $data["timestamp"];
                ?>            
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="card card-customer-overview">
                        <div class="card-body">
                          <div class="media-list mg-t-25">
                            <div class="media">
                              <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">Ангилал (*)</h6>
                                  <?
                                    $sql_cat = "SELECT * FROM news_category WHERE id=$category";
                                    $result_cat =mysqli_query($conn,$sql_cat);
                                    $data_cat = mysqli_fetch_array($result_cat);
                                    echo $data_cat["name"];
                                  ?>
                              </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media mg-t-25">
                              <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">Зураг</h6>
                                <img src="../<?=$image;?>" class="w-100">
                              </div><!-- media-body -->
                            </div><!-- media -->
                          </div><!-- media-list -->
                        </div><!-- card-body -->
                      </div><!-- card -->


                    </div>
                    <div class="col-lg-8">
                      <div class="card card-customer-overview">
                        <div class="card-body">
                          <div class="media-list mg-t-25">
                            <div class="media">
                              <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">Гарчиг (*)</h6>
                                <?=$title;?>
                              </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media mg-t-25">
                              <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">Мэдээ (*)</h6>
                                <?=$content;?>
                                <a href="news?action=edit&id=<?=$news_id;?>" class="btn btn-success btn-icon-text btn-xs" title="Мэдээг засах"><i data-feather="edit"></i> Засах</a>

                              </div><!-- media-body -->
                            </div><!-- media -->
                          </div><!-- media-list -->                                                             
                        </div><!-- card-body -->
                      </div><!-- card -->
                  </div><!-- col-6 -->
                  </div><!-- row -->

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
            if ($action =="new")
            {
              ?>
              <form action="news?action=inserting" method="post" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-lg-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="media-list mg-t-25">
                          <div class="media">
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">Ангилал (*)</h6>
                              <select name="category" class="form-control select2">
                                <?
                                $sql_cat = "SELECT * FROM news_category ORDER BY name";
                                $result_cat =mysqli_query($conn,$sql_cat);
                                while ($data_cat = mysqli_fetch_array($result_cat))
                                {
                                  ?>
                                  <option value="<?=$data_cat["id"];?>"><?=$data_cat["name"];?></option>
                                  <?
                                }
                                ?>
                              </select>
                            </div><!-- media-body -->
                          </div><!-- media -->
                          <div class="media mg-t-25">
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">Зураг</h6>
                              <div class="custom-file">
                                <input type="file" name="image" required="required" class="custom-file-input">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                              </div><!-- custom-file -->
                            </div><!-- media-body -->
                          </div><!-- media -->
                        </div><!-- media-list -->
                      </div><!-- card-body -->
                    </div><!-- card -->
                    <input type="submit" class="btn btn-success btn-lg mg-t-15" value="Мэдээг оруулах">
                  </div>
                  <div class="col-lg-8">
                    <div class="card card-customer-overview">
                      <div class="card-body">
                        <div class="media-list mg-t-25">
                          <div class="media">
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">Гарчиг (*)</h6>
                              <input type="text" name="title" class="form-control" required="required">
                            </div><!-- media-body -->
                          </div><!-- media -->
                          <div class="media mg-t-25">
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">Мэдээ (*)</h6>
                              <textarea name="content" required="required" class="form-control" style="min-height: 400px"></textarea>
                            </div><!-- media-body -->
                          </div><!-- media -->
                        </div><!-- media-list -->                                                             
                      </div><!-- card-body -->
                    </div><!-- card -->
                  </div><!-- col-6 -->
                </div><!-- row -->
              </form>
              <?
            }
            ?>

            <?
            if ($action =="inserting")
            {
              ?>
              <div class="row row-xs mg-t-10">              
                <div class="col-lg-12">
                  
                  <?
                  $title = $_POST["title"];
                  $content = $_POST["content"];
                  if (substr($content,0,4)=="<p>" && substr($content,-5,5)=="</p>")
                    $text = substr($content,5,len($content)-7);
                  $category = $_POST["category"];
                  $target_file =""; $thumb="";
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
                          {
                            $thumb_image_content = resize_image($target_file,300,200);
                            $thumb = substr($target_file,0,-4)."_thumb".substr($target_file,-4,4);
                            imagejpeg($thumb_image_content,$thumb,75);
                            $target_file = substr($target_file,3);
                            $thumb = substr($thumb,3);
                          }
                      }
                  }

                  $sql = "INSERT INTO news (category,image,title,content,thumb) VALUES ('$category','$target_file','$title','$content','$thumb')";                            
                  if (mysqli_query($conn,$sql))
                    {
                      $news_id = mysqli_insert_id($conn);
                      ?>
                      <div class="alert alert-success mg-b-10" role="alert">
                        Амжилттай нэмлээ.
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
                </div><!-- col-6 -->
              </div><!-- row -->
              <div class="btn-group">
                <a href="news?action=edit&id=<?=$news_id;?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
                <a href="news" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бүх мэдээ</a>
              </div>
              <?
            }
            ?>


            <?
            if ($action =="edit")
            {
              if (isset($_GET["id"])) $news_id=$_GET["id"]; else header("location:news");
              $sql = "SELECT *FROM news WHERE id=$news_id LIMIT 1";
              $result= mysqli_query($conn,$sql);
              if (mysqli_num_rows($result)==1)
              {
                $data = mysqli_fetch_array($result);
                $id = $data["id"];
                $category = $data["category"];              
                $title = $data["title"];
                $image = $data["image"];
                $content = $data["content"];
                $count = $data["count"];
                $timestamp = $data["timestamp"];
                ?>            
                <form action="news?action=editing" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="news_id" value="<?=$news_id;?>">
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="card card-customer-overview">
                        <div class="card-body">
                          <div class="media-list mg-t-25">
                            <div class="media">
                              <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">Ангилал (*)</h6>
                                <select name="category" class="form-control select2">
                                  <?
                                    $sql_cat = "SELECT * FROM news_category ORDER BY name";
                                    $result_cat =mysqli_query($conn,$sql_cat);
                                    while ($data_cat = mysqli_fetch_array($result_cat))
                                    {
                                      ?>
                                      <option value="<?=$data_cat["id"];?>" <?=($category==$data_cat["id"])?'selected="selected"':'';?>><?=$data_cat["name"];?></option>
                                      <?
                                    }
                                  ?>
                                </select>
                              </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media mg-t-25">
                              <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">Зураг</h6>
                                <img src="../<?=$image;?>" width="100%">
                                <div class="custom-file">
                                  <input type="file" name="image" class="custom-file-input">
                                  <label class="custom-file-label" for="customFile">Choose file</label>
                                </div><!-- custom-file -->
                              </div><!-- media-body -->
                            </div><!-- media -->
                          </div><!-- media-list -->
                        </div><!-- card-body -->
                      </div><!-- card -->
                      <input type="submit" class="btn btn-success btn-lg mg-t-15" value="Мэдээг засах">
                      <div class="clearfix"></div>
                      <a href="news?action=delete&id=<?=$news_id;?>" class="btn btn-danger btn-sm mg-t-25"><i class="icon ion-ios-trash"></i> Устгах</a>


                    </div>
                    <div class="col-lg-8">
                      <div class="card card-customer-overview">
                        <div class="card-body">
                          <div class="media-list mg-t-25">
                            <div class="media">
                              <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">Гарчиг (*)</h6>
                                <input type="text" name="title" class="form-control" required="required" value="<?=$title;?>">
                              </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media mg-t-25">
                              <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">Мэдээ (*)</h6>
                                <textarea name="content" required="required" class="editable form-control" style="min-height: 400px"><?=$content;?></textarea>
                              </div><!-- media-body -->
                            </div><!-- media -->
                          </div><!-- media-list -->                                                             
                        </div><!-- card-body -->
                      </div><!-- card -->
                  </div><!-- col-6 -->
                  </div><!-- row -->
                </form>
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
            if ($action =="editing")
            {
              $news_id = $_POST["news_id"];
              $title = $_POST["title"];
              $content = $_POST["content"];
              if (substr($text,0,4)=="<p>" && substr($text,-5,5)=="</p>")
                $text = substr($text,5,len($text)-7);

              $category = $_POST["category"];
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
                          {
                            $thumb_image_content = resize_image($target_file,300,200);
                            $thumb = substr($target_file,0,-4)."_thumb".substr($target_file,-4,4);
                            imagejpeg($thumb_image_content,$thumb,75);
                            $target_file = substr($target_file,3);
                            $thumb = substr($thumb,3);
                            mysqli_query($conn,"UPDATE news SET image='$target_file',thumb='$thumb' WHERE id='$news_id'");
                          }
                      }
              }
              

              ?>
              <div class="row row-xs mg-t-10">
                <div class="col-lg-12">
                  <?
                  $sql = "UPDATE news SET category='$category', title='$title', content='$content' WHERE id='$news_id'";
                  if (mysqli_query($conn,$sql))
                  {
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
                  <a href="news?action=new" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
                  <a href="news" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бүх мэдээ</a>
                </div>
              </div><!-- row -->
              <?
            }
            ?>










            
            <?
            if ($action=="delete")
            {
              if (isset($_GET["id"])) $news_id=$_GET["id"]; else header("location:news");
              ?>
              <div class="card">
                <div class="card-body">
                  <?
                  $sql = "SELECT *FROM news WHERE id=$news_id LIMIT 1";
                  $result= mysqli_query($conn,$sql);
                  if (mysqli_num_rows($result)==1)
                  {                  
                    $data = mysqli_fetch_array($result);
                    $image = $data["image"];
                    $thumb = $data["thumb"];
                    if (file_exists("../".$image)) unlink("../".$image);
                    if (file_exists("../".$thumb)) unlink("../".$thumb);

                    if (mysqli_query($conn,"DELETE FRom news WHERE id=$news_id")) 
                      {
                        ?>
                        <div class="alert alert-success mg-b-10" role="alert">
                          Устгагдлаа.
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
                  }
                  ?>
                  <div class="btn-group">
                    <a href="news?action=new" class="btn btn-success"><i data-feather="edit"></i> Шинэ мэдээ</a>
                    <a href="news" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бүх мэдээ</a>
                  </div>
                </div>
              
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