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
            if ($action =="display")
            {
              $count =1;
              ?>
              <div class="card">
                <div class="card-body">
                  <table id="datatable1" class="table display responsive nowrap">
                    <thead>
                      <tr>
                        <th class="wd-5p">№</th>
                        <th class="wd-200p">Ангиллын нэр</th>
                        <th class="wd-5p">Үйлдэл</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?
                      $sql = "SELECT *FROM news_category ORDER BY name";
                      $result = mysqli_query($conn,$sql);
                      if (mysqli_num_rows($result)>0)
                      {
                        while ($data = mysqli_fetch_array($result))
                        {

                          ?>
                          <tr>
                            <td><?=$count++;?></td>
                            <td><a href="news_category?action=edit&id=<?=$data["id"];?>"><?=$data["name"];?></a></td>
                            <td class="tx-18">
                              <div class="btn-group">
                                <a href="news_category?action=edit&id=<?=$data["id"];?>"  class="btn btn-success btn-xs btn-icon text-white" title="Засах"><i data-feather="edit"></i></a>

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
              <a href="news_category?action=new" class="btn btn-success mt-3"><i class="icon ion-ios-plus"></i> Ангилал нэмэх</a>
              <?
            }
            ?>

            <?
            if ($action =="new")
            {
              ?>
              <div class="row row-xs">
                <div class="col-lg-12 order-lg-2 mg-t-10">
                  <form action="news_category?action=adding" method="post" enctype="multipart/form-data">
                    <div class="card card-customer-overview">
                      <div class="card-header">
                        <h6 class="slim-card-title">Мэдээнй ангилал нэмэх</h6>
                      </div><!-- card-header -->
                      <div class="card-body">
                          
                        <div class="media-list mg-t-25">
                          <div class="media">
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">Нэр (*)</h6>
                              <input type="text" name="name" class="form-control" required="required">
                            </div><!-- media-body -->
                          </div><!-- media -->
                        </div><!-- media-list -->
                          <input type="submit" class="btn btn-success btn-lg mg-t-10" value="Үүсгэх">
                              
                      </div><!-- card-body -->
                    </div><!-- card -->
                  </form>
                </div><!-- col-6 -->
              </div><!-- row -->
              <?
            }
            ?>

          <?
            if ($action =="adding")
            {
              ?>
              <div class="row row-xs mg-t-10">

                <div class="col-lg-12 mg-t-10 order-lg-2">
                    <div class="card card-customer-overview">
                      <div class="card-header">
                        <h6 class="slim-card-title">Мэдээний ангилал үүсгэх</h6>
                      </div><!-- card-header -->
                      <div class="card-body">
                          <?
                            $name = $_POST["name"];

                              $sql = "INSERT INTO news_category (name) VALUES ('$name')";
                              if (mysqli_query($conn,$sql))
                              {
                                $category_id = mysqli_insert_id($conn);
                                ?>
                                <div class="alert alert-success mg-b-10" role="alert">
                                  Амжилттай нэмэгдлээ.
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
                              <a href="news_category?action=edit&id=<?=$category_id;?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>

                              <a href="news_category" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бусад бүх ангилал</a>
                            </div>
                      </div><!-- card-body -->
                    </div><!-- card -->
                  </form>
                </div><!-- col-6 -->
              </div><!-- row -->
              <?
            }
            ?>


            <?
            if ($action =="edit")
            {
              ?>
              <div class="row row-xs">
                <div class="col-lg-12 order-lg-2 mg-t-10">
                  <form action="news_category?action=editing" method="post" enctype="multipart/form-data">
                    <div class="card card-customer-overview">
                      <div class="card-header">
                        <h6 class="slim-card-title">Мэдээний ангилал засах</h6>
                      </div><!-- card-header -->
                      <div class="card-body">
                          <?
                          if (isset($_GET["id"])) $category_id=$_GET["id"]; else header("location:news_category");
                          $sql = "SELECT *FROM news_category WHERE id=$category_id LIMIT 1";
                          $result= mysqli_query($conn,$sql);
                          if (mysqli_num_rows($result)==1)
                          {
                            $data = mysqli_fetch_array($result);
                            ?>
                            <input type="hidden" name="id" value="<?=$data["id"];?>">
                            <div class="media-list">
                              <div class="media">
                                <div class="media-body">
                                  <h6 class="tx-14 tx-gray-700">Нэр (*)</h6>
                                  <input type="text" name="name" value="<?=$data["name"];?>" class="form-control" required="required">
                                </div><!-- media-body -->
                              </div><!-- media -->
                            </div><!-- media-list -->
                            <input type="submit" class="btn btn-success btn-lg mg-t-10" value="Засах">
                            <?
                          }
                          ?>
                      </div><!-- card-body -->
                    </div><!-- card -->
                  </form>
                </div><!-- col-6 -->
              </div><!-- row -->

              <div class="btn-group mg-t-10">
                <a href="news_category?action=delete&id=<?=$category_id;?>" class="btn btn-danger btn-sm"><i class="icon ion-ios-trash"></i> Устгах</a>
                <a href="news_category" class="btn btn-primary btn-sm"><i class="icon ion-ios-list"></i> Бусад бүх ангилал</a>
              </div>
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
                        <h6 class="slim-card-title">Мэдээний ангилал засах</h6>
                      </div><!-- card-header -->
                      <div class="card-body">
                          <?
                          if (isset($_POST["id"])) $category_id=$_POST["id"]; else header("location:news_category");
                          $name = $_POST["name"];
                          $sql = "UPDATE news_category SET name='$name' WHERE id=$category_id LIMIT 1";
                        
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
                            
                      </div><!-- card-body -->
                    </div><!-- card -->
                </div><!-- col-6 -->
              </div><!-- row -->
              <div class="btn-group mg-t-10">
                <a href="news_category?action=edit&id=<?=$category_id;?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
                <a href="news_category" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бусад бүх ангилал</a>
              </div>
              <?
            }
            ?>


            <?
            if ($action =="delete")
            {
              ?>
              <div class="row row-xs mg-t-10">
                
                <div class="col-lg-12 mg-t-10 order-lg-2">
                  <div class="card card-customer-overview">
                    <div class="card-header">
                      <h6 class="slim-card-title">Мэдээний ангилал устгах</h6>
                    </div><!-- card-header -->
                    <div class="card-body">
                        <?
                        if (isset($_GET["id"])) $category_id=$_GET["id"]; else header("location:news_category");
                        $sql = "SELECT *FROM news_category WHERE id=$category_id LIMIT 1";
                        $result= mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)==1)
                        {
                          // ORDEr ShALGAH ShAARDLAGATAI

                        
                          if (mysqli_query($conn,"DELETE FRom news_category WHERE id=$category_id")) 
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
                    </div><!-- card-body -->
                  </div><!-- card -->
                </div><!-- col-6 -->
              </div><!-- row -->
              <div class="btn-group mg-t-10">
                  <a href="news_category" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бусад бүх ангилал</a>
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