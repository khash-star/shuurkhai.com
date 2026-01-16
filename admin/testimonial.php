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
          <?  if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="display";?>
          
          <?
          if ($action =="display")
          {
            ?>
            <div class="card">
              <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="wd-10p">Зураг</th>
                      <th class="wd-20p">Нэр</th>
                      <th class="wd-50p">Тайлбар</th>
                      <th class="wd-20p">Хэлсэн үг</th>
                      <th class="wd-5p">Эрэмбэ</th>
                      <th class="wd-10p">Үйлдэл</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?
                    $sql = "SELECT *FROM testimonial ORDER BY dd,name DESC";
                    $result = mysqli_query($conn,$sql);
                    if (mysqli_num_rows($result)>0)
                    {
                      while ($data = mysqli_fetch_array($result))
                      {

                        ?>
                        <tr>
                          <td><img src="../<?=$data["thumbnail"];?>" class="avatar_list"></td>
                          <td><?=$data["name"];?></td>
                          <td class="text-wrap"><?=$data["description"];?></td>
                          <td  class="text-wrap"><?=$data["words"];?></td>
                          <td><?=$data["dd"];?></td>
                          <td class="tx-18">
                            <div class="btn-group">
                              <a href="testimonial?action=detail&id=<?=$data["id"];?>" class="btn btn-success btn-icon btn-xs" title="Харах"><i data-feather="user"></i></a>
                              <a href="testimonial?action=edit&id=<?=$data["id"];?>"  class="btn btn-warning btn-icon text-white btn-xs" title="Засах"><i data-feather="edit"></i></a>
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
            <a href="testimonial?action=register" class="btn btn-primary">Азтан нэмэх</a>

            <?
          }
          ?>

          <?
          if ($action =="register")
          {
            ?>
            <div class="row row-xs">
              <div class="col-lg-12 mg-t-10 order-lg-2">
                <form action="testimonial?action=registering" method="post" enctype="multipart/form-data">
                  <div class="card card-customer-overview">
                    <div class="card-header">
                      <h6 class="slim-card-title">Азтан нэмэх</h6>
                    </div><!-- card-header -->
                    <div class="card-body">
                      <div class="row">
                        <div class="col-6">
                          <div class="media-list mg-t-25">
                            <div class="media">
                              <div class="media-body mg-t-4">
                                <h6 class="tx-14 tx-gray-700">Нэр (*)</h6>
                                <input type="text" name="name" value="" class="form-control" required="required">
                              </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media mg-t-25">
                              <div class="media-body mg-t-2">
                                <h6 class="tx-14 tx-gray-700">Цээж зураг (*)</h6>
                                <input type="file" name="image" required="required">
                              </div><!-- media-body -->
                            </div><!-- media -->
                          </div><!-- media-list -->
                        </div>
                        <div class="col-6">
                          <div class="media-list mg-t-25">
                            <div class="media mg-t-25">
                              <div class="media-body mg-t-2">
                                <h6 class="tx-14 tx-gray-700">тайлбар</h6>
                                <input type="text" name="description" value="" class="form-control">
                              </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media mg-t-25">
                              <div class="media-body mg-t-2">
                                <h6 class="tx-14 tx-gray-700">Хэлсэн үг (*)</h6>
                                <textarea name="words" class="form-control" required="required"></textarea>
                              </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media mg-t-25">
                              <div class="media-body mg-t-2">
                                <h6 class="tx-14 tx-gray-700">Дэс дугаар</h6>
                                <textarea name="dd" class="form-control" required="required" value="0"></textarea>
                              </div><!-- media-body -->
                            </div><!-- media -->
                          </div><!-- media-list -->
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <input type="submit" class="btn btn-success btn-lg mg-t-10" value="Оруулах">
                    </div><!-- card-body -->
                  </div><!-- card -->
                </form>
              </div><!-- col-6 -->
            </div><!-- row -->
            <?
          }
          ?>


          <?
          if ($action =="registering")
          {
            ?>
            <div class="row row-xs mg-t-10">
              <div class="col-lg-12 order-lg-2">
                  <div class="card card-customer-overview">
                    <div class="card-header">
                      <h6 class="slim-card-title">Азтан нэмэх</h6>
                    </div><!-- card-header -->
                    <div class="card-body">
                        <?
                          $error = 0;
                          $error_msg = "";
                          $name = $_POST["name"];
                          $words = $_POST["words"];
                          $description = $_POST["description"];
                          $dd = $_POST["dd"];

                          /*
                          echo "rd:".$rd."<br>";
                          echo "surname:".$surname."<br>";
                          echo "name:".$name."<br>";
                          echo "contact:".$contact."<br>";
                          echo "contact2:".$contact2."<br>";
                          echo "email:".$email."<br>";
                          echo "finnumber:".$finnumber."<br>";
                          echo "username:".$username."<br>";
                          echo "password:".$password."<br>";
                          echo "address:".$address."<br>";
                          */
    
                          $image =""; $thumb="";
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
                                      $image=$target_file;
                                      $thumb_image_content = resize_image($image,300,200);
                                      $thumb = substr($image,0,-4)."_thumb".substr($image,-4,4);
                                      imagejpeg($thumb_image_content,$thumb,75);
                                      $image = substr($image,3);
                                      $thumb = substr($thumb,3);
                                  }
                          }

                          $sql = "INSERT INTO testimonial (name,avatar,thumbnail,description,words,dd) 
                          VALUES ('$name','$image','$thumb','$description','$words','$dd')";                   
                          if (mysqli_query($conn,$sql))
                            {
                              $testimonial_id = mysqli_insert_id($conn);
                              ?>
                              <div class="alert alert-success mg-b-10" role="alert">
                                Амжилттай бүртгэлээ.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div><!-- alert --> 
                              <div class="btn-group">
                                <a href="testimonial?action=detail&id=<?=$testimonial_id;?>" class="btn btn-success"><i data-feather="edit"></i> Дэлгэрэнгүй</a>
                                <a href="testimonial?action=edit&id=<?=$testimonial_id;?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
                                <a href="testimonial" class="btn btn-primary"><i data-feather="list"></i> Бүх азтангууд</a>
                              </div>
                              <?
                            }
                            else 
                            {
                              ?>
                              <div class="alert alert-danger mg-b-10" role="alert">
                               алдаа гарлаа. <?=mysqli_error($conn);?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div><!-- alert --> 
                              <div class="btn-group">
                                <a href="#" class="btn btn-success"><i data-feather="edit"></i> Буцах</a>
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
          if ($action =="detail")
          {
            ?>
            <div class="row row-xs mg-t-10">
              <div class="col-lg-12 mg-t-10 order-lg-2">
                <div class="card card-customer-overview">
                  <div class="card-header">
                    <h6 class="slim-card-title">Үгний дэлгэрэнгүй</h6>
                  </div><!-- card-header -->
                  <div class="card-body">
                      <?
                      if (isset($_GET["id"])) $id=$_GET["id"]; else header("location:testimonial");
                      $sql = "SELECT *FROM testimonial WHERE id=$id LIMIT 1";
                      $result= mysqli_query($conn,$sql);
                      if (mysqli_num_rows($result)==1)
                      {
                        $data = mysqli_fetch_array($result);
                        ?>
                      <div class="row">
                        <div class="col-6">
                          <div class="media-list">
                            <div class="media">
                              <div class="media-body">
                                  <img src="../<?=$data["avatar"];?>" style="max-width: 100%; clear:both;">
                              </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media">
                              <div class="media-body mg-t-10">
                                <h6 class="tx-14 tx-gray-700">Нэр</h6>
                                <a href="" class="d-block"><?=$data["name"];?></a>
                              </div><!-- media-body -->
                            </div><!-- media -->
                          </div><!-- media-list -->
                        </div>


                        <div class="col-6">
                              <div class="media-list">
                                <div class="media">
                                  <div class="media-body">
                                    <h6 class="tx-14 tx-gray-700">Тайлбар (*)</h6>
                                    <?=$data["description"];?>
                                  </div><!-- media-body -->
                                </div><!-- media -->
                                <div class="media mg-t-25">
                                  <div class="media-body mg-t-2">
                                    <h6 class="tx-14 tx-gray-700">Хэлсэн үг</h6>
                                    <?=$data["words"];?>
                                  </div><!-- media-body -->
                                </div><!-- media -->
                                <div class="media mg-t-25">
                                  <div class="media-body mg-t-2">
                                    <h6 class="tx-14 tx-gray-700">Дэс дугаар (*)</h6>
                                    <?=$data["dd"];?>
                                  </div><!-- media-body -->
                                </div><!-- media -->
                              </div><!-- media-list -->

                              <div class="btn-group">
                                <a href="testimonial?action=edit&id=<?=$data["id"];?>" class="btn btn-success btn-icon-text btn-xs"><i data-feather="edit"></i> Засах</a>
                                <a href="testimonial" class="btn btn-primary btn-icon-text btn-xs"><i data-feather="list"></i> Бусад хэрэглэгчид</a>
                              </div>
                        </div>


                        
                        <?
                      }
                      ?>
                  </div><!-- card-body -->
                </div><!-- card -->
              </div><!-- col-12 -->
            </div><!-- row -->
            <?
          }
          ?>



          <?
          if ($action =="edit")
          {
            ?>
            <div class="row row-xs mg-t-10">
              <div class="col-lg-12 mg-t-10">
                <form action="testimonial?action=editing" method="post" enctype="multipart/form-data">
                  <div class="card card-customer-overview">
                    <div class="card-header">
                      <h6 class="slim-card-title">Бүртгэлийн дэлгэрэнгүй</h6>
                    </div><!-- card-header -->
                    <div class="card-body">
                        <?
                        if (isset($_GET["id"])) $id=$_GET["id"]; else header("location:testimonial");
                        $sql = "SELECT *FROM testimonial WHERE id=$id LIMIT 1";
                        $result= mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)==1)
                        {
                          $data = mysqli_fetch_array($result);
                          ?>
                          <input type="hidden" name="id" value="<?=$data["id"];?>">
                          <div class="row">
                            <div class="col-6">


                              <div class="media-list">
                                <div class="media">
                                  <div class="media-body">
                                    <img src="../<?=$data["avatar"];?>" style="max-width: 100%; clear:both;">
                                  </div>
                                </div>
                                
                                <div class="media mg-t-25">
                                  <div class="media-body mg-t-2">
                                    <h6 class="tx-14 tx-gray-700">Цээж зураг</h6>
                                    <input type="file" name="image">
                                  </div><!-- media-body -->
                                </div><!-- media -->

                                <div class="media">
                                  <div class="media-body mg-t-4">
                                    <h6 class="tx-14 tx-gray-700">Нэр (*)</h6>
                                    <input type="text" name="name" value="<?=$data["name"];?>" class="form-control" required="required">
                                  </div><!-- media-body -->
                                </div><!-- media -->
                                
                              </div><!-- media-list -->
                            </div>
                            <div class="col-6">
                              <div class="media-list mg-t-25">
                                <div class="media mg-t-25">
                                  <div class="media-body mg-t-2">
                                    <h6 class="tx-14 tx-gray-700">Тайлбар (*)</h6>
                                    <input type="text" name="description" value="<?=$data["description"];?>" class="form-control" required="required">
                                  </div><!-- media-body -->
                                </div><!-- media -->
                                <div class="media mg-t-25">
                                  <div class="media-body mg-t-2">
                                    <h6 class="tx-14 tx-gray-700">Хэлсэн үг</h6>
                                    <input type="text" name="words" value="<?=$data["words"];?>" class="form-control" >
                                  </div><!-- media-body -->
                                </div><!-- media -->
                                <div class="media mg-t-25">
                                  <div class="media-body mg-t-2">
                                    <h6 class="tx-14 tx-gray-700">Дэс дугаар (*)</h6>
                                    <input type="text" name="dd" value="<?=$data["dd"];?>" class="form-control" required="required">
                                  </div><!-- media-body -->
                                </div><!-- media -->
                              </div><!-- media-list -->
                            </div>
                          </div>
                          <div class="clearfix"></div>

                            <input type="submit" class="btn btn-success btn-xs" value="Засах">
                            
                          <div class="clearfix"></div><br>
                          <div class="clearfix"></div><br>

                          <div class="btn-group">
                            <a href="testimonial?action=delete&id=<?=$id;?>" class="btn btn-danger btn-xs btn-icon-text"><i data-feather="trash"></i> Устгах</a>
                            <a href="testimonial" class="btn btn-primary btn-xs btn-icon-text"><i data-feather="list"></i> Бусад азтангууд</a>
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
              <div class="col-lg-12 mg-t-10 order-lg-2">
                <div class="card card-customer-overview">
                  <div class="card-header">
                    <h6 class="slim-card-title">Азтанг засах</h6>
                  </div><!-- card-header -->
                  <div class="card-body">
                      <?
                      if (isset($_POST["id"])) $id=$_POST["id"]; else header("location:testimonial");
                      $sql = "SELECT *FROM testimonial WHERE id=$id LIMIT 1";
                      $result= mysqli_query($conn,$sql);
                      if (mysqli_num_rows($result)==1)
                      {
                        $error = 0;
                        $error_msg = "";
                        $name = $_POST["name"];
                        $description = $_POST["description"];
                        $words = $_POST["words"];
                        $dd = $_POST["dd"];
                      

                        $image =""; $thumb="";
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
                                    $image=$target_file;
                                    $thumb_image_content = resize_image($image,300,200);
                                    $thumb = substr($image,0,-4)."_thumb".substr($image,-4,4);
                                    imagejpeg($thumb_image_content,$thumb,75);
                                    $image = substr($image,3);
                                    $thumb = substr($thumb,3);
                                    $sql = "UPDATE testimonial SET avatar='$image',thumbnail='$thumb' WHERE id=$id";
                                    if (!mysqli_query($conn,$sql))
                                    {
                                       $error++; $error_msg="Зураг хуулахад алдаа гарлаа.";
                                    }
                                }
                        }
        
                        if (mysqli_query($conn,"UPDATE testimonial SET name='$name',description='$description',words='$words',dd='$dd' WHERE  id=$id LIMIT 1")) 
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
                          <a href="testimonial?action=edit&id=<?=$id;?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
                          <a href="testimonial" class="btn btn-primary"><i data-feather="list"></i> Бусад азтангууд</a>
                        </div>
                        <?
                      }
                      else echo "Үгний дугаар буруу байна.";
                      ?>
                  </div><!-- card-body -->
                </div><!-- card -->
              </div><!-- col-12 -->
            </div><!-- row -->
            <?
          }
          ?>


          <?
          if ($action =="delete")
          {
            ?>
            <div class="row row-xs mg-t-10">
              <div class="col-md-6 col-lg-3 order-lg-1">
                <? require_once("left_new_order.php");?>
              </div><!-- col-3 -->
              <div class="col-md-6 col-lg-3 mg-md-t-0 order-lg-3">
                 <? require_once("right_new_feedback.php");?>
              </div><!-- col-3 -->
              <div class="col-lg-6 mg-1-10 order-lg-2">
                <form action="testimonial?action=editing" method="post" enctype="multipart/form-data">
                  <div class="card card-customer-overview">
                    <div class="card-header">
                      <h6 class="slim-card-title">Бүртгэл устгах</h6>
                    </div><!-- card-header -->
                    <div class="card-body">
                        <?
                        if (isset($_GET["id"])) $id=$_GET["id"]; else header("location:testimonial");
                        $sql = "SELECT *FROM testimonial WHERE id=$id LIMIT 1";
                        $result= mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)==1)
                        {
                          $data = mysqli_fetch_array($result);
                          if (file_exists("../".$data["avatar"])) unlink("../".$data["avatar"]);
                          if (file_exists("../".$data["thumbnail"])) unlink("../".$data["thumbnail"]);
                          // ORDEr ShALGAH ShAARDLAGATAI

                        
                          if (mysqli_query($conn,"DELETE FROM testimonial WHERE id=$id")) 
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


                          ?>                            
                          <div class="btn-group">
                            <a href="testimonial" class="btn btn-primary"><i data-feather="list"></i> Бусад хэрэглэгчид</a>
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