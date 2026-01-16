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
                <a href="feedback?action=not_list" class="btn btn-danger btn-sm pull-right mg-b-10">Боломжгүй хүсэлтүүд</a>
                <a href="feedback?action=done_list" class="btn btn-success btn-sm pull-right mg-b-10">Шийдвэрлэсэн хүсэлтүүд</a>
                <a href="feedback" class="btn btn-primary btn-sm pull-right mg-b-10">Идэвхитэй санал хүсэлт</a>

            <?  if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="display";?>
            
            <?
          if ($action=="display")
          {
            ?>
            <div class="row">
              <?

              $sql = "SELECT *FROM feedback WHERE archive=0 ORDER BY timestamp DESC";
              $result = mysqli_query($conn,$sql);
              if (mysqli_num_rows($result)>0)
              {
                $count =1;
                while ($data = mysqli_fetch_array($result))
                {
                  $id = $data["id"];
                  $title = $data["title"];
                  $content = $data["content"];
                  $read = $data["read"];
                  $name = $data["name"];
                  $contact = $data["contact"];
                  $email = $data["email"];
                  $timestamp = $data["timestamp"];

                  ?>
                  <div class="col-md-6 mg-md-t-10">
                    <div class="card">
                      <div class="card-body">
                      <h5 class="card-title tx-dark tx-medium mg-b-10"><?=$title;?></h5>
                        Бичсэн 
                            <?=$name;?>  - <?=$email;?> (<?=$contact;?>)                          
                       
                        <p class="card-subtitle tx-normal mg-b-15"><?=substr($timestamp,0,10);?></p>

                        <p class="card-text"><?=$content;?></p>
                        <a href="feedback?action=done&id=<?=$id;?>" class="card-link" title="Санал хүсэлтийг шийдвэрлэсэн болгох"><i class="icon ion-checkmark"></i> Шийдвэрлэсэн</a>
                        <a href="feedback?action=not_done&id=<?=$id;?>" class="card-link" title="Санал хүсэлтийг шийдвэрлэх боломжгүй"><i class="icon ion-close"></i> Боломжгүй</a>
                        <a href="feedback?action=delete&id=<?=$id;?>" class="card-link" title="Санал хүсэлтийг устгах"><i class="icon ion-ios-trash"></i> Устгах</a>
                      </div>
                    </div><!-- card -->
                  </div><!-- col -->
                  <?
                  $count++;
                }
              }
              else 
              {
                ?>
                <div class="alert alert-danger mg-b-10 col-lg-12" role="alert">
                  Идвэхитэй санал хүсэлт байхгүй.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div><!-- alert --> 
                <?
              }
              ?>              
            </div><!-- row -->
            <?
            if($count>4)
            {
              ?>
              <a href="feedback?action=done_list" class="btn btn-danger btn-sm pull-right mg-b-10">Боломжгүй хүсэлтүүд</a>
              <a href="feedback?action=done_list" class="btn btn-success btn-sm pull-right mg-b-10">Шийдвэрлэгдсэн хүсэлтүүд</a>
              <?
            }
          }
          ?>



          <?
          if ($action=="done_list")
          {
            ?>
            <div class="row">
              <?
              $sql = "SELECT *FROM feedback WHERE archive=1 ORDER BY timestamp DESC";
              $result = mysqli_query($conn,$sql);
              if (mysqli_num_rows($result)>0)
              {
                while ($data = mysqli_fetch_array($result))
                {
                  $id = $data["id"];
                  $title = $data["title"];
                  $content = $data["content"];
                  $read = $data["read"];
                  $name = $data["name"];
                  $contact = $data["contact"];
                  $email = $data["email"];
                  $timestamp = $data["timestamp"];
                  ?>
                  <div class="col-md-6 mg-md-t-10">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title tx-medium mg-b-10"><?=$title;?></h5>
                        Бичсэн 
                            <?=$name;?>  - <?=$email;?> (<?=$contact;?>)                          
                       
                        <p class="card-subtitle tx-normal mg-b-15"><?=substr($timestamp,0,10);?></p>



                        <p class="card-text"><?=$content;?></p>
                        <a href="feedback?action=not_done&id=<?=$id;?>" class="card-link tx-white" title="Санал хүсэлтийг шийдвэрлэх боломжгүй"><i class="icon ion-close"></i> Боломжгүй</a>
                        <a href="feedback?action=delete&id=<?=$id;?>" class="card-link tx-white" title="Санал хүсэлтийг устгах"><i class="icon ion-ios-trash"></i> Устгах</a>
                      </div>
                    </div><!-- card -->
                  </div><!-- col -->
                  <?

                }
              }
              else 
              {
                ?>
                <div class="alert alert-danger mg-b-10 col-lg-12" role="alert">
                  Шийдвэрлэгдсэн санал хүсэлт байхгүй.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div><!-- alert --> 
                <?
              }
              ?>              
            </div><!-- row -->
            <?
            if ($count>4)
            {
              ?>
              <a href="feedback?action=done_list" class="btn btn-danger btn-sm pull-right mg-b-10">Боломжгүй хүсэлтүүд</a>
              <a href="feedback?action=done_list" class="btn btn-primary btn-sm pull-right mg-b-10">Идэвхитэй хүсэлтүүд</a>
              <?
            }
          }
          ?>

          <?
          if ($action=="not_list")
          {
            ?>
            <div class="row">
              <?
              $sql = "SELECT *FROM feedback WHERE archive=2 ORDER BY timestamp DESC";
              $result = mysqli_query($conn,$sql);
              if (mysqli_num_rows($result)>0)
              {
                while ($data = mysqli_fetch_array($result))
                {
                  $id = $data["id"];
                  $title = $data["title"];
                  $content = $data["content"];
                  $read = $data["read"];
                  $name = $data["name"];
                  $contact = $data["contact"];
                  $email = $data["email"];
                  $timestamp = $data["timestamp"];
                  ?>
                  <div class="col-md-6 mg-md-t-10">
                    <div class="card">
                      <div class="card-body bg-purple tx-white">
                        <h5 class="card-title tx-dark tx-medium mg-b-10"><?=$title;?></h5>
                        Бичсэн 
                            <?=$name;?>  - <?=$email;?> (<?=$contact;?>)                          
                       
                        <p class="card-subtitle tx-normal mg-b-15"><?=substr($timestamp,0,10);?></p>

                        <p class="card-text"><?=$content;?></p>
                        <a href="feedback?action=done&id=<?=$id;?>" class="card-link" title="Санал хүсэлтийг шийдвэрлэсэн болгох"><i class="icon ion-checkmark"></i> Шийдвэрлэсэн</a>
                        <a href="feedback?action=delete&id=<?=$id;?>" class="card-link tx-white" title="Санал хүсэлтийг устгах"><i class="icon ion-ios-trash"></i> Устгах</a>
                      </div>
                    </div><!-- card -->
                  </div><!-- col -->
                  <?

                }
              }
              else 
              {
                ?>
                <div class="alert alert-danger mg-b-10 col-lg-12" role="alert">
                  Архивлагдсан санал хүсэлт байхгүй.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div><!-- alert --> 
                <?
              }
              ?>              
            </div><!-- row -->
            <?
            if ($count>4)
            {
              ?>
              ?>
              <a href="feedback?action=done_list" class="btn btn-success btn-sm pull-right mg-b-10">Шийдвэрлэгдсэн хүсэлтүүд</a>
              <a href="feedback" class="btn btn-primary btn-sm pull-right mg-b-10">Идэвхитэй хүсэлтүүд</a>
              <?
            }
          }
          ?>

          <?
          if ($action=="done")
          {
            if (isset($_GET["id"])) $feedback_id=$_GET["id"]; else header("location:feedback");
            ?>
                  <?
                  $sql = "SELECT *FROM feedback WHERE id=$feedback_id LIMIT 1";
                  $result= mysqli_query($conn,$sql);
                  if (mysqli_num_rows($result)==1)
                  {                  
                    if (mysqli_query($conn,"UPDATE feedback SET archive=1 WHERE id=$feedback_id")) 
                      {
                        ?>
                        <div class="alert alert-success mg-b-10" role="alert">
                          Шийдвэрлэв.
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
            
            <?
          }
          ?>

          <?
          if ($action=="not_done")
          {
            if (isset($_GET["id"])) $feedback_id=$_GET["id"]; else header("location:feedback");
            ?>
                  <?
                  $sql = "SELECT *FROM feedback WHERE id=$feedback_id LIMIT 1";
                  $result= mysqli_query($conn,$sql);
                  if (mysqli_num_rows($result)==1)
                  {                  
                    if (mysqli_query($conn,"UPDATE feedback SET archive=2 WHERE id=$feedback_id")) 
                      {
                        ?>
                        <div class="alert alert-success mg-b-10" role="alert">
                          Боломжгүй болгов.
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
            
            <?
          }
          ?>


          <?
          if ($action=="delete")
          {
            if (isset($_GET["id"])) $feedback_id=$_GET["id"]; else header("location:feedback");
            ?>
            <div class="clearfix"></div>
                  <?
                  $sql = "SELECT *FROM feedback WHERE id=$feedback_id LIMIT 1";
                  $result= mysqli_query($conn,$sql);
                  if (mysqli_num_rows($result)==1)
                  {                  
                    if (mysqli_query($conn,"DELETE FRom feedback WHERE id=$feedback_id")) 
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