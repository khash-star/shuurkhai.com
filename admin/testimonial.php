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
                    <?php
                    $sql = "SELECT * FROM testimonial ORDER BY dd,name DESC";
                    $result = mysqli_query($conn,$sql);
                    if ($result && mysqli_num_rows($result) > 0)
                    {
                      while ($data = mysqli_fetch_array($result))
                      {
                        if (!$data) continue;
                        $id = isset($data["id"]) ? intval($data["id"]) : 0;
                        $thumbnail = isset($data["thumbnail"]) ? htmlspecialchars($data["thumbnail"]) : '';
                        $name = isset($data["name"]) ? htmlspecialchars($data["name"]) : '';
                        $description = isset($data["description"]) ? htmlspecialchars($data["description"]) : '';
                        $words = isset($data["words"]) ? htmlspecialchars($data["words"]) : '';
                        $dd = isset($data["dd"]) ? htmlspecialchars($data["dd"]) : '';

                        ?>
                        <tr>
                          <td><img src="../<?php echo $thumbnail;?>" class="avatar_list"></td>
                          <td><?php echo $name;?></td>
                          <td class="text-wrap"><?php echo $description;?></td>
                          <td  class="text-wrap"><?php echo $words;?></td>
                          <td><?php echo $dd;?></td>
                          <td class="tx-18">
                            <div class="btn-group">
                              <a href="testimonial?action=detail&id=<?php echo htmlspecialchars($id);?>" class="btn btn-success btn-icon btn-xs" title="Харах"><i data-feather="user"></i></a>
                              <a href="testimonial?action=edit&id=<?php echo htmlspecialchars($id);?>"  class="btn btn-warning btn-icon text-white btn-xs" title="Засах"><i data-feather="edit"></i></a>
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
            <a href="testimonial?action=register" class="btn btn-primary">Азтан нэмэх</a>

            <?php
          }
          ?>

          <?php
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
                                <input type="text" name="dd" class="form-control" value="0">
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
            <?php
          }
          ?>


          <?php
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
                        <?php
                          $error = 0;
                          $error_msg = "";
                          $name = isset($_POST["name"]) ? protect($_POST["name"]) : '';
                          $words = isset($_POST["words"]) ? protect($_POST["words"]) : '';
                          $description = isset($_POST["description"]) ? protect($_POST["description"]) : '';
                          $dd = isset($_POST["dd"]) ? intval($_POST["dd"]) : 0;
    
                          $image = ""; 
                          $thumb = "";
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

                          $name_escaped = mysqli_real_escape_string($conn, $name);
                          $description_escaped = mysqli_real_escape_string($conn, $description);
                          $words_escaped = mysqli_real_escape_string($conn, $words);
                          $image_escaped = mysqli_real_escape_string($conn, $image);
                          $thumb_escaped = mysqli_real_escape_string($conn, $thumb);
                          
                          $sql = "INSERT INTO testimonial (name,avatar,thumbnail,description,words,dd) 
                          VALUES ('$name_escaped','$image_escaped','$thumb_escaped','$description_escaped','$words_escaped','$dd')";                   
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
                                <a href="testimonial?action=detail&id=<?php echo htmlspecialchars($testimonial_id);?>" class="btn btn-success"><i data-feather="edit"></i> Дэлгэрэнгүй</a>
                                <a href="testimonial?action=edit&id=<?php echo htmlspecialchars($testimonial_id);?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
                                <a href="testimonial" class="btn btn-primary"><i data-feather="list"></i> Бүх азтангууд</a>
                              </div>
                              <?php
                            }
                            else 
                            {
                              ?>
                              <div class="alert alert-danger mg-b-10" role="alert">
                               алдаа гарлаа. <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error';?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div><!-- alert --> 
                              <div class="btn-group">
                                <a href="#" class="btn btn-success"><i data-feather="edit"></i> Буцах</a>
                              </div>
                              <?php
                            }
                          ?>                            
                    </div><!-- card-body -->
                  </div><!-- card -->
              </div><!-- col-6 -->
            </div><!-- row -->
            <?php
          }
          ?>

          <?php
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
                      <?php
                      if (isset($_GET["id"])) {
                        $id = intval(protect($_GET["id"]));
                      } else {
                        header("location:testimonial");
                        exit;
                      }
                      $id_escaped = mysqli_real_escape_string($conn, $id);
                      $sql = "SELECT * FROM testimonial WHERE id=" . $id_escaped . " LIMIT 1";
                      $result = mysqli_query($conn,$sql);
                      if ($result && mysqli_num_rows($result) == 1)
                      {
                        $data = mysqli_fetch_array($result);
                        if (!$data) {
                          echo "Мэдээлэл олдсонгүй.";
                        } else {
                          $data_id = isset($data["id"]) ? intval($data["id"]) : 0;
                          $data_avatar = isset($data["avatar"]) ? htmlspecialchars($data["avatar"]) : '';
                          $data_name = isset($data["name"]) ? htmlspecialchars($data["name"]) : '';
                          $data_description = isset($data["description"]) ? htmlspecialchars($data["description"]) : '';
                          $data_words = isset($data["words"]) ? htmlspecialchars($data["words"]) : '';
                          $data_dd = isset($data["dd"]) ? htmlspecialchars($data["dd"]) : '';
                        ?>
                      <div class="row">
                        <div class="col-6">
                          <div class="media-list">
                            <div class="media">
                              <div class="media-body">
                                  <img src="../<?php echo $data_avatar;?>" style="max-width: 100%; clear:both;">
                              </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media">
                              <div class="media-body mg-t-10">
                                <h6 class="tx-14 tx-gray-700">Нэр</h6>
                                <a href="" class="d-block"><?php echo $data_name;?></a>
                              </div><!-- media-body -->
                            </div><!-- media -->
                          </div><!-- media-list -->
                        </div>


                        <div class="col-6">
                              <div class="media-list">
                                <div class="media">
                                  <div class="media-body">
                                    <h6 class="tx-14 tx-gray-700">Тайлбар (*)</h6>
                                    <?php echo $data_description;?>
                                  </div><!-- media-body -->
                                </div><!-- media -->
                                <div class="media mg-t-25">
                                  <div class="media-body mg-t-2">
                                    <h6 class="tx-14 tx-gray-700">Хэлсэн үг</h6>
                                    <?php echo $data_words;?>
                                  </div><!-- media-body -->
                                </div><!-- media -->
                                <div class="media mg-t-25">
                                  <div class="media-body mg-t-2">
                                    <h6 class="tx-14 tx-gray-700">Дэс дугаар (*)</h6>
                                    <?php echo $data_dd;?>
                                  </div><!-- media-body -->
                                </div><!-- media -->
                              </div><!-- media-list -->

                              <div class="btn-group">
                                <a href="testimonial?action=edit&id=<?php echo htmlspecialchars($data_id);?>" class="btn btn-success btn-icon-text btn-xs"><i data-feather="edit"></i> Засах</a>
                                <a href="testimonial" class="btn btn-primary btn-icon-text btn-xs"><i data-feather="list"></i> Бусад хэрэглэгчид</a>
                              </div>
                        </div>
                        <?php
                        }
                      }
                      ?>
                  </div><!-- card-body -->
                </div><!-- card -->
              </div><!-- col-12 -->
            </div><!-- row -->
            <?php
          }
          ?>



          <?php
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
                        <?php
                        if (isset($_GET["id"])) {
                          $id = intval(protect($_GET["id"]));
                        } else {
                          header("location:testimonial");
                          exit;
                        }
                        $id_escaped = mysqli_real_escape_string($conn, $id);
                        $sql = "SELECT * FROM testimonial WHERE id=" . $id_escaped . " LIMIT 1";
                        $result = mysqli_query($conn,$sql);
                        if ($result && mysqli_num_rows($result) == 1)
                        {
                          $data = mysqli_fetch_array($result);
                          if (!$data) {
                            echo "Мэдээлэл олдсонгүй.";
                          } else {
                            $data_id = isset($data["id"]) ? intval($data["id"]) : 0;
                            $data_avatar = isset($data["avatar"]) ? htmlspecialchars($data["avatar"]) : '';
                            $data_name = isset($data["name"]) ? htmlspecialchars($data["name"]) : '';
                            $data_description = isset($data["description"]) ? htmlspecialchars($data["description"]) : '';
                            $data_words = isset($data["words"]) ? htmlspecialchars($data["words"]) : '';
                            $data_dd = isset($data["dd"]) ? htmlspecialchars($data["dd"]) : '';
                          ?>
                          <input type="hidden" name="id" value="<?php echo htmlspecialchars($data_id);?>">
                          <div class="row">
                            <div class="col-6">


                              <div class="media-list">
                                <div class="media">
                                  <div class="media-body">
                                    <img src="../<?php echo $data_avatar;?>" style="max-width: 100%; clear:both;">
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
                                    <input type="text" name="name" value="<?php echo $data_name;?>" class="form-control" required="required">
                                  </div><!-- media-body -->
                                </div><!-- media -->
                                
                              </div><!-- media-list -->
                            </div>
                            <div class="col-6">
                              <div class="media-list mg-t-25">
                                <div class="media mg-t-25">
                                  <div class="media-body mg-t-2">
                                    <h6 class="tx-14 tx-gray-700">Тайлбар (*)</h6>
                                    <input type="text" name="description" value="<?php echo $data_description;?>" class="form-control" required="required">
                                  </div><!-- media-body -->
                                </div><!-- media -->
                                <div class="media mg-t-25">
                                  <div class="media-body mg-t-2">
                                    <h6 class="tx-14 tx-gray-700">Хэлсэн үг</h6>
                                    <input type="text" name="words" value="<?php echo $data_words;?>" class="form-control" >
                                  </div><!-- media-body -->
                                </div><!-- media -->
                                <div class="media mg-t-25">
                                  <div class="media-body mg-t-2">
                                    <h6 class="tx-14 tx-gray-700">Дэс дугаар (*)</h6>
                                    <input type="text" name="dd" value="<?php echo $data_dd;?>" class="form-control" required="required">
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
                            <a href="testimonial?action=delete&id=<?php echo htmlspecialchars($id);?>" class="btn btn-danger btn-xs btn-icon-text"><i data-feather="trash"></i> Устгах</a>
                            <a href="testimonial" class="btn btn-primary btn-xs btn-icon-text"><i data-feather="list"></i> Бусад азтангууд</a>
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
              <div class="col-lg-12 mg-t-10 order-lg-2">
                <div class="card card-customer-overview">
                  <div class="card-header">
                    <h6 class="slim-card-title">Азтанг засах</h6>
                  </div><!-- card-header -->
                  <div class="card-body">
                      <?php
                      if (isset($_POST["id"])) {
                        $id = intval(protect($_POST["id"]));
                      } else {
                        header("location:testimonial");
                        exit;
                      }
                      $id_escaped = mysqli_real_escape_string($conn, $id);
                      $sql = "SELECT * FROM testimonial WHERE id=" . $id_escaped . " LIMIT 1";
                      $result = mysqli_query($conn,$sql);
                      if ($result && mysqli_num_rows($result) == 1)
                      {
                        $error = 0;
                        $error_msg = "";
                        $name = isset($_POST["name"]) ? protect($_POST["name"]) : '';
                        $description = isset($_POST["description"]) ? protect($_POST["description"]) : '';
                        $words = isset($_POST["words"]) ? protect($_POST["words"]) : '';
                        $dd = isset($_POST["dd"]) ? intval($_POST["dd"]) : 0;
                      

                        $image = ""; 
                        $thumb = "";
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
                                    $image_escaped = mysqli_real_escape_string($conn, $image);
                                    $thumb_escaped = mysqli_real_escape_string($conn, $thumb);
                                    $update_image_sql = "UPDATE testimonial SET avatar='$image_escaped',thumbnail='$thumb_escaped' WHERE id=" . $id_escaped;
                                    if (!mysqli_query($conn, $update_image_sql))
                                    {
                                       $error++; $error_msg="Зураг хуулахад алдаа гарлаа.";
                                    }
                                }
                        }
        
                        $name_escaped = mysqli_real_escape_string($conn, $name);
                        $description_escaped = mysqli_real_escape_string($conn, $description);
                        $words_escaped = mysqli_real_escape_string($conn, $words);
                        $update_sql = "UPDATE testimonial SET name='$name_escaped',description='$description_escaped',words='$words_escaped',dd='$dd' WHERE id=" . $id_escaped . " LIMIT 1";
                        if (mysqli_query($conn, $update_sql)) 
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
                          <a href="testimonial?action=edit&id=<?php echo htmlspecialchars($id);?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
                          <a href="testimonial" class="btn btn-primary"><i data-feather="list"></i> Бусад азтангууд</a>
                        </div>
                        <?php
                      }
                      else echo "Үгний дугаар буруу байна.";
                      ?>
                  </div><!-- card-body -->
                </div><!-- card -->
              </div><!-- col-12 -->
            </div><!-- row -->
            <?php
          }
          ?>


          <?php
          if ($action =="delete")
          {
            ?>
            <div class="row row-xs mg-t-10">
              <div class="col-lg-12 mg-1-10 order-lg-2">
                <div class="card card-customer-overview">
                  <div class="card-header">
                    <h6 class="slim-card-title">Бүртгэл устгах</h6>
                  </div><!-- card-header -->
                  <div class="card-body">
                      <?php
                      if (isset($_GET["id"])) {
                        $id = intval(protect($_GET["id"]));
                      } else {
                        header("location:testimonial");
                        exit;
                      }
                      $id_escaped = mysqli_real_escape_string($conn, $id);
                      $sql = "SELECT * FROM testimonial WHERE id=" . $id_escaped . " LIMIT 1";
                      $result = mysqli_query($conn,$sql);
                      if ($result && mysqli_num_rows($result) == 1)
                      {
                        $data = mysqli_fetch_array($result);
                        if ($data) {
                          $data_avatar = isset($data["avatar"]) ? $data["avatar"] : '';
                          $data_thumbnail = isset($data["thumbnail"]) ? $data["thumbnail"] : '';
                          if ($data_avatar && file_exists("../".$data_avatar)) unlink("../".$data_avatar);
                          if ($data_thumbnail && file_exists("../".$data_thumbnail)) unlink("../".$data_thumbnail);
                        }
                        
                        $delete_sql = "DELETE FROM testimonial WHERE id=" . $id_escaped;
                        if (mysqli_query($conn, $delete_sql)) 
                          {
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
                              Алдаа гарлаа. <?php echo $conn ? htmlspecialchars(mysqli_error($conn)) : 'Database connection error';?>
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div><!-- alert --> 
                            <?php
                          }
                          ?>                            
                          <div class="btn-group">
                            <a href="testimonial" class="btn btn-primary"><i data-feather="list"></i> Бусад хэрэглэгчид</a>
                          </div>
                          <?php
                        }
                        ?>
                    </div><!-- card-body -->
                  </div><!-- card -->
              </div><!-- col-6 -->
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