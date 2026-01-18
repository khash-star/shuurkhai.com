<?php
    require_once("config.php");
    require_once("views/helper.php");
    require_once("views/login_check.php");
    require_once("views/init.php");
?>

<link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<body class="sidebar-dark">
	<div class="main-wrapper">
		<?php  require_once("views/navbar.php"); ?>
	
		<div class="page-wrapper">
      <?php  require_once("views/sidebar.php"); ?>
			

			<div class="page-content">

        <!------------------------------------------------------------------------------------->
        
          <!--label class="section-title">Basic Responsive DataTable</label>
          <p class="mg-b-20 mg-sm-b-40">Searching, ordering and paging goodness will be immediately added to the table, as shown in this example.</p-->
          <?php
          if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="display";
          $action_title = "Бүх агент"; // Default value
          switch ($action)
          {
            case "display": $action_title="Бүх агент";break;
            case "new": $action_title="Шинэ агент";break;
            case "adding": $action_title="агент бүртгэх";break;
            case "edit": $action_title="агентийн мэдээлэл засах";break;
            case "editing": $action_title="агентийн мэдээлэл засах";break;
            case "delete": $action_title="агентийн мэдээлэл устгах";break;            
          }
          ?>
          <nav class="page-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="agents">агент</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($action_title);?></li>
            </ol>
          </nav>

          <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
              <h4 class="mb-3 mb-md-0">Агентууд</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">            
              <a  class="btn btn-primary btn-icon-text mb-2 mb-md-0" href="?action=new">
                <i class="btn-icon-prepend" data-feather="plus"></i>
                Агент нэмэх
              </a>
            </div>
          </div>



          <?php
          if ($action =="display")
          {
            ?>
            <div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="dataTableExample" class="table">
                        <thead>
                          <tr>
                            <th>№</th>
                            <th>Нэр</th>
                            <th>Нэвтрэх нэр</th>
                            <th>Нэвтэрсэн</th>
                            <th>Үйлдэл</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $sql = "SELECT * FROM agents";
                            $result = mysqli_query($conn,$sql);
                            if (mysqli_num_rows($result)>0)
                            {
                              while ($data = mysqli_fetch_array($result))
                              {

                                ?>
                                <tr>
                                  <td><?php echo htmlspecialchars($data["agent_id"] ?? '');?></td>
                                  <td class="text-wrap"><?php echo htmlspecialchars($data["name"] ?? '');?></td>
                                  <td class="text-wrap"><?php echo htmlspecialchars($data["username"] ?? '');?></td>
                                  <td><?php echo isset($data["last_log"]) ? htmlspecialchars(substr($data["last_log"],0,10)) : '';?></td>
                                  <td class="tx-18">
                                    <div class="btn-group">
                                        <a href="agents?action=edit&id=<?php echo htmlspecialchars($data["agent_id"] ?? '');?>"  class="btn btn-warning btn-xs text-white btn-icon btn-icon" title="Засах"><i data-feather="edit"></i></a>
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
            <form action="agents?action=adding" method="post" enctype="multipart/form-data">
              
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                        <div class="card-body">
                            <div class="media-list ">
                            <div class="media">
                                <div class="media-body mg-l-15 mg-t-4">
                                <label for="name">Нэр (*)</label>
                                <input type="text" name="name" id="name" value="" class="form-control" required="required">
                                </div>
                            </div>
                            <div class="media">
                                <div class="media-body mg-l-15 mg-t-2">
                                <label for="username">Нэвтрэх нэр (*)</label>
                                <input type="text" name="username"  id="username" value="" class="form-control" required="required">
                                </div>
                            </div>
                            <div class="media">
                                <div class="media-body mg-l-15 mg-t-2">
                                <label for="password">Нууц үг (*)</label>
                                <input type="password" name="password" id="password" value="" class="form-control">
                                </div>
                            </div>
                            </div>

                            <input type="submit" class="btn btn-success mt-3" value="Үүсгэх">

                        </div>
                    </div>

                </div>
                
                </div> 
             
            </form>
            <?php
          }
          ?>


          <?php
          if ($action =="adding")
          {
            ?>
            <div class="row row-xs mg-t-10">
              <div class="col-lg-12 order-lg-2">
                  <div class="card">
                    <div class="card-header">
                      <h6 class="slim-card-title">Бүртгэл</label>
                    </div><!-- card-header -->
                    <div class="card-body">
                        <?php
                          $name = $_POST["name"];
                          $username = $_POST["username"];
                          $password = $_POST["password"];

                          $sql = "INSERT INTO agents (name,username,password) 
                          VALUES ('$name','$username','$password')";                   
                          if (mysqli_query($conn,$sql))
                            {
                              $agent_id = mysqli_insert_id($conn);
                              ?>
                              <div class="alert alert-success mg-b-10" role="alert">
                                Амжилттай бүртгэлээ.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="btn-group">
                                <a href="agents?action=edit&id=<?php echo htmlspecialchars($agent_id ?? '');?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
                                <a href="agents?action=new" class="btn btn-primary"><i class="icon ion-ios-list"></i> Шинэ агентид</a>
                              </div>
                              <?php
                            }
                            else 
                            {
                              ?>
                              <div class="alert alert-danger mg-b-10" role="alert">
                               алдаа гарлаа. <?php echo htmlspecialchars(mysqli_error($conn));?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="btn-group">
                                <a href="agents?action=new" class="btn btn-success"><i data-feather="edit"></i> Ахин оролдох</a>
                              </div>
                              <?php
                            }


                          ?>                            
                          
                          

                    </div>
                  </div>
                </form>
              </div>
            </div>
            <?php
          }
          ?>


          <?php
          if ($action =="edit")
          {
            ?>
            <form action="agents?action=editing" method="post" enctype="multipart/form-data">
              <?php
                if (isset($_GET["id"])) $agent_id=$_GET["id"]; else header("location:customers");
                $sql = "SELECT * FROM agents WHERE agent_id='$agent_id' LIMIT 1";
                $result= mysqli_query($conn,$sql);
                if (mysqli_num_rows($result)==1)
                {
                  $data = mysqli_fetch_array($result);
                  ?>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="card">
                        <div class="card-body">
                          <input type="hidden" name="id" value="<?php echo htmlspecialchars($data["agent_id"] ?? '');?>">
                          <div class="media-list ">
                            <div class="media">
                              <div class="media-body mg-l-15 mg-t-4">
                                <label for="name">Нэр (*)</label>
                                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($data["name"] ?? '');?>" class="form-control" required="required">
                              </div>
                            </div>
                            <div class="media">
                              <div class="media-body mg-l-15 mg-t-2">
                                <label for="username">Нэвтрэх нэр (*)</label>
                                <input type="text" name="username"  id="username" value="<?php echo htmlspecialchars($data["username"] ?? '');?>" class="form-control" required="required">
                              </div>
                            </div>
                            <div class="media">
                              <div class="media-body mg-l-15 mg-t-2">
                                <label for="password">Нууц үг (*)</label>
                                <input type="password" name="password" id="password" value="" class="form-control">
                                <i>Хоосон орхивол өөрчлөгдөхгүй</i>
                              </div>
                            </div>
                          </div>

                          <input type="submit" class="btn btn-success" value="Засах">


                        </div>
                      </div>
                    
                      
                    </div>
                 
                  </div> 
              
                <?php
              }
              ?>
            </form>
            <div class="btn-group mt-3">
              <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modaldemo"><i class="icon ion-ios-trash"></i> Устгах</a>
            </div>


             <div id="modaldemo" class="modal fade">
              <div class="modal-dialog" role="document">
                <div class="modal-content tx-size-sm">
                  <div class="modal-body tx-center pd-y-20 pd-x-20">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-danger mg-b-20">Устгахад итгэлтэй байна уу!</h4>
                    <p class="mg-b-20 mg-x-20">Ахин сэргээх боломжгүйгээр устах болно.</p>
                    <a href="agents?action=delete&id=<?php echo htmlspecialchars($agent_id ?? '');?>" class="btn btn-danger">Тийм устгах</a>
                    <button type="button" class="btn btn-success pd-x-25" data-dismiss="modal" aria-label="Close">Үгүй, үлдээе</button>
                  </div><!-- modal-body -->
                </div><!-- modal-content -->
              </div><!-- modal-dialog -->
            </div><!-- modal -->
            
            <?php
          }
          ?>


          <?php
          if ($action =="editing")
          {
            ?>
            <div class="row row-xs mg-t-10">
              <div class="col-lg-12 mg-t-10 order-lg-2">
                <div class="card">
                  <div class="card-header">
                    <h6 class="slim-card-title">Бүртгэлийн дэлгэрэнгүй</label>
                  </div><!-- card-header -->
                  <div class="card-body">
                      <?php
                      if (isset($_POST["id"])) $agent_id=$_POST["id"]; else header("location:customers");
                      $sql = "SELECT * FROM agents WHERE agent_id='$agent_id' LIMIT 1";
                      $result= mysqli_query($conn,$sql);
                      if (mysqli_num_rows($result)==1)
                      {
                        $name = $_POST["name"];
                        $username = $_POST["username"];
                        $password = $_POST["password"];
                        if ($password<>"")
                        mysqli_query($conn,"UPDATE agents SET password='$password' WHERE agent_id='$agent_id' LIMIT 1");


                        $sql = "UPDATE agents SET name='$name',username='$username' WHERE agent_id='$agent_id' LIMIT 1";

                        if (mysqli_query($conn,$sql) )
                           {

                            ?>
                            <div class="alert alert-success mg-b-10" role="alert">
                              Амжилттай шинэчиллээ.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <?php
                          }
                          else 
                          {
                            ?>
                            <div class="alert alert-danger mg-b-10" role="alert">
                             Алдаа гарлаа.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <?php
                          }


                        ?>                            
                        <div class="btn-group">
                          <a href="agents?action=edit&id=<?php echo htmlspecialchars($agent_id ?? '');?>" class="btn btn-success"> Засах</a>
                        </div>
                        <?php
                      }
                      ?>
                  </div>
                </div>
              </div><!-- col-12 -->
            </div>
            <?php
          }
          ?>



          <?php
          if ($action =="delete")
          {
            if (isset($_GET["id"])) $agent_id=$_GET["id"]; else header("location:agents");

            ?>
            <div class="row row-xs mg-t-10">
              <div class="col-lg-12 mg-t-10 order-lg-2">
                <div class="card">
                  <div class="card-header">
                    <h6 class="slim-card-title">Бүртгэл устах</label>
                  </div><!-- card-header -->
                  <div class="card-body">
                      <?php
                      $sql = "SELECT * FROM agents WHERE agent_id='$agent_id' LIMIT 1";
                      $result= mysqli_query($conn,$sql);
                      if (mysqli_num_rows($result)==1)
                      {
                          
                              if (mysqli_query($conn,"DELETE FROM agents WHERE  agent_id='$agent_id' LIMIT 1"))
                              {
                                ?>
                                    <div class="alert alert-success mg-b-10" role="alert">
                                        Амжилттай устгагдлаа.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php
                              }
                              else 
                              {
                                  ?>
                                    <div class="alert alert-danger mg-b-10" role="alert">
                                        Алдаа гарлаа.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                  <?php
                              }
                            
                         
                      }
                      else
                      {
                        ?>
                        <div class="alert alert-danger mg-b-10" role="alert">
                          Агент олдсонгүй
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <?php
                      }
                      ?>
                        <div class="btn-group">
                          <a href="agents" class="btn btn-primary"><i class="icon ion-ios-list"></i> агент</a>
                        </div>

                  </div>
                </div>
              </div><!-- col-12 -->
            </div>
            <?php
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
  <script src="assets/vendors/apexcharts/apexcharts.min.js"></script>

  <script src="assets/vendors/chartjs/Chart.min.js"></script>
  <script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="assets/js/data-table.js"></script>
  <script src="assets/js/jquery.chained.min.js"></script>
  <script src="assets/js/dashboard.js"></script>
  <script src="assets/js/apexcharts.js"></script>

  <script>
    $(document).ready(function() {
      $("#district").chained("#city");
    })
  </script>


	<!-- endinject -->

</body>
</html>    