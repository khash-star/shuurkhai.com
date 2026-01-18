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
          if ($action=="display")
          {
            ?>
            <div class="row">
            <a href="slides?action=new" class="btn btn-success"><i class="icon ion-plus"></i> Нэмэх</a>
              <?php

              $sql = "SELECT * FROM slides ORDER BY dd";
              $result = mysqli_query($conn,$sql);
              if ($result && mysqli_num_rows($result) > 0)
              {
                $count = 1;
                while ($data = mysqli_fetch_array($result))
                {
                  if (!$data) continue;
                  $id = isset($data["id"]) ? intval($data["id"]) : 0;
                  $image = isset($data["image"]) ? htmlspecialchars($data["image"]) : '';
                  $name = isset($data["name"]) ? htmlspecialchars($data["name"]) : '';
                  $text = isset($data["text"]) ? htmlspecialchars($data["text"]) : '';
                  $link = isset($data["link"]) ? htmlspecialchars($data["link"]) : '';
                  $dd = isset($data["dd"]) ? htmlspecialchars($data["dd"]) : '';
                  ?>
                  <div class="col-lg-12 mt-3">
                    <div class="card">
                      <div class="card-body">
                        <img src="../<?php echo htmlspecialchars($image);?>" style="width: 100%;">
                        <h5><?php echo htmlspecialchars($name);?></h5>
                        <p><?php echo htmlspecialchars($text);?></p>
                        <p class="card-subtitle tx-normal mg-b-15"><a href="<?php echo htmlspecialchars($link);?>"><?php echo htmlspecialchars($link);?></a></p>

                        <a href="slides?action=edit&id=<?php echo htmlspecialchars($id);?>" class="card-link" title="Зураг засах"><i class="icon ion-edit"></i> Засах</a>
                        <a href="slides?action=delete&id=<?php echo htmlspecialchars($id);?>" class="card-link" title="Зургын устгах"><i class="icon ion-ios-trash"></i> Устгах</a>
                      </div>
                    </div><!-- card -->
                  </div><!-- col -->
                  <?php
                  $count++;
                }
              }
              else 
              {
                ?>
                <div class="alert alert-danger mt-3 col-lg-12" role="alert">
                  зурагыг олдсонгүй.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div><!-- alert --> 
                <?php
              }
              ?>              
              <a href="slides?action=new" class="btn btn-success"><i class="icon ion-plus"></i> Нэмэх</a>

            </div><!-- row -->
            <?php
          }
          ?>



          <?php
          if ($action =="new")
          {
            ?>
          
            <form action="slides?action=inserting" method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="media-list">
                        <div class="media">
                        <div class="media-body mg-l-15 mg-t-4">
                            <h6 class="tx-14 tx-gray-700">Текст (*)</h6>
                            <input type="text" name="name" class="form-control" required="required">
                          </div><!-- media-body -->
                        </div><!-- media -->


                        <div class="media">
                        <div class="media-body mg-l-15 mg-t-4">
                            <h6 class="tx-14 tx-gray-700">Текст 2</h6>
                            <input type="text" name="text" class="form-control">
                          </div><!-- media-body -->
                        </div><!-- media -->

                        <div class="media mg-t-10">
                          <div class="media-body mg-l-15 mg-t-4">
                            <h6 class="tx-14 tx-gray-700">Зураг</h6>
                            <div class="custom-file">
                              <input type="file" name="image" class="form-control">
                            </div><!-- custom-file -->
                          </div><!-- media-body -->
                        </div><!-- media -->

                        <div class="media mg-t-10">
                        <div class="media-body mg-l-15 mg-t-4">
                            <h6 class="tx-14 tx-gray-700">Линк (*)</h6>
                            <input type="text" name="link" class="form-control" required="required">
                          </div><!-- media-body -->
                        </div><!-- media -->

                        <div class="media mg-t-10">
                        <div class="media-body mg-l-15 mg-t-4">
                            <h6 class="tx-14 tx-gray-700">Дэс дугаар (*)</h6>
                            <input type="number" name="dd" class="form-control" required="required" value="0">
                          </div><!-- media-body -->
                        </div><!-- media -->

                      </div><!-- media-list -->
                      <input type="submit" class="btn btn-success" value="Зураг оруулах">
                    </div>
                  </div>
                </div>
              </div><!-- row -->
            </form>
            <?php
          }
          ?>

          <?php
          if ($action =="inserting")
          {
            ?>
            <div class="row row-xs mg-t-10">              
              <div class="col-lg-12">
                
                <?php                
                $name = isset($_POST["name"]) ? protect($_POST["name"]) : '';
                $text = isset($_POST["text"]) ? protect($_POST["text"]) : '';
                $link = isset($_POST["link"]) ? protect($_POST["link"]) : '';
                $dd = isset($_POST["dd"]) ? intval($_POST["dd"]) : 0;
                $image = "";
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
                            $image = substr($target_file,3);
                        }
                }

                $name_escaped = mysqli_real_escape_string($conn, $name);
                $text_escaped = mysqli_real_escape_string($conn, $text);
                $image_escaped = mysqli_real_escape_string($conn, $image);
                $link_escaped = mysqli_real_escape_string($conn, $link);
                $sql = "INSERT INTO slides (name,text,image,link,dd) VALUES ('$name_escaped','$text_escaped','$image_escaped','$link_escaped','$dd')";                            
                if (mysqli_query($conn,$sql))
                  {
                    $slides_id = mysqli_insert_id($conn);
                    ?>
                    <div class="alert alert-success" role="alert">
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
                    <div class="alert alert-danger" role="alert">
                      Алдаа гарлаа. <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error'($conn);?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div><!-- alert --> 
                    <?php

                  }
                ?>
              </div><!-- col-6 -->
            </div><!-- row -->
            <div class="btn-group">
              <a href="slides?action=edit&id=<?php echo htmlspecialchars($slides_id ?? 0);?>" class="btn btn-success"><i class="icon ion-edit"></i> Засах</a>
              <a href="slides" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бүх зураг</a>
            </div>
            <?php
          }
          ?>

          <?php
          if ($action =="edit")
          {
            if (isset($_GET["id"])) {
                $slides_id = intval($_GET["id"]);
            } else {
                header("location:slides");
                exit;
            }
            $sql = "SELECT * FROM slides WHERE id='$slides_id' LIMIT 1";
            $result = mysqli_query($conn,$sql);
            if ($result && mysqli_num_rows($result) == 1)
            {
              $data = mysqli_fetch_array($result);
              if ($data) {
                  $id = isset($data["id"]) ? intval($data["id"]) : 0;
                  $image = isset($data["image"]) ? htmlspecialchars($data["image"]) : '';
                  $name = isset($data["name"]) ? htmlspecialchars($data["name"]) : '';
                  $text = isset($data["text"]) ? htmlspecialchars($data["text"]) : '';
                  $link = isset($data["link"]) ? htmlspecialchars($data["link"]) : '';
                  $dd = isset($data["dd"]) ? htmlspecialchars($data["dd"]) : '';  
              ?>
              <form action="slides?action=editing" method="post" enctype="multipart/form-data">
                <input type="hidden" name="slides_id" value="<?php echo htmlspecialchars($id ?? 0);?>">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body">
                        <div class="media-list mg-t-25">
                          <div class="media">
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">Текст (*)</h6>
                              <input type="text" name="name" class="form-control" required="required" value="<?php echo htmlspecialchars($name ?? '');?>">
                            </div><!-- media-body -->
                          </div><!-- media -->

                          <div class="media">
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">Текст 2</h6>
                              <input type="text" name="text" class="form-control" required="required" value="<?php echo htmlspecialchars($text ?? '');?>">
                            </div><!-- media-body -->
                          </div><!-- media -->

                          <div class="media mg-t-10">
                            <div class="media-body mg-l-15 mg-t-4">
                              <img src="../<?php echo htmlspecialchars($image ?? '');?>" style="width: 100%;">

                              <h6 class="tx-14 tx-gray-700">Зураг</h6>
                              <div class="custom-file">
                                <input type="file" name="image" class="form-control">
                              </div><!-- custom-file -->
                            </div><!-- media-body -->
                          </div><!-- media -->

                          <div class="media mg-t-10">
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">Линк (*)</h6>
                              <input type="text" name="link" class="form-control" value="<?php echo htmlspecialchars($link ?? '');?>" required="required" >
                            </div><!-- media-body -->
                          </div><!-- media -->

                          <div class="media mg-t-10">
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">Дэс дугаар (*)</h6>
                              <input type="number" name="dd" class="form-control" value="<?php echo htmlspecialchars($dd ?? '');?>" required="required">
                            </div><!-- media-body -->
                          </div><!-- media -->
                          
                        </div><!-- media-list -->

                        <input type="submit" class="btn btn-success" value="Зураг оруулах">
                      </div>
                    </div>
                  </div>
                </div><!-- row -->
              </form>
              <?php
              }
            }
            else 
            {
              ?>
              <div class="alert alert-danger mg-b-10" role="alert">
                Слайд олдсонгүй.
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
            $slides_id = $_POST["slides_id"];
            $name = $_POST["name"];
            $text = $_POST["text"];
            $link = $_POST["link"];
            $dd = $_POST["dd"];
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
              mysqli_query($conn,"UPDATE slides SET image='$image' WHERE id='$slides_id'");
            }

            ?>
            <div class="row row-xs mg-t-10">
              <div class="col-lg-12">
                <?php
                $sql = "UPDATE slides SET `name`='$name',`text`='$text', dd='$dd', `link`='$link' WHERE id='$slides_id'";
                if (mysqli_query($conn,$sql))
                {
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
                <a href="slides?action=edit&id=<?php echo htmlspecialchars($slides_id ?? 0);?>" class="btn btn-success"><i class="icon ion-edit"></i> Засах</a>
                <a href="slides" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бүх зураг</a>
              </div>
            </div><!-- row -->
            <?php
          }
          ?>

          <?php
          if ($action=="delete")
          {
            if (isset($_GET["id"])) $slides_id=$_GET["id"]; else header("location:slides");
            ?>
            <a href="slides?action=new" class="btn btn-success pull-right mg-b-10"><i class="icon ion-plus"></i> Нэмэх</a>
            <div class="clearfix"></div>
                  <?php
                  $sql = "SELECT * FROM slides WHERE id=$slides_id LIMIT 1";
                  $result= mysqli_query($conn,$sql);
                  if (mysqli_num_rows($result)==1)
                  {                  
                    $data = mysqli_fetch_array($result);
                    $image = $data["image"];

                    if (mysqli_query($conn,"DELETE FROM slides WHERE id=$slides_id")) 
                      {
                        if (file_exists("../".$image)) unlink("../".$image);

                        ?>
                        <div class="alert alert-success mg-b-10" role="alert">
                          Устгагдлаа.
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
                          Алдаа гарлаа. <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error'($conn);?>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div><!-- alert --> 
                        <?php
                      }                   
                  }
                  ?>
              <div class="btn-group">
                <a href="slides" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бүх зураг</a>
              </div>
            
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