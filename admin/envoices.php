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
          if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="dashboard";
          $action_title = "Удирдлага"; // Default value
          switch ($action)
          {
            case "dashboard": $action_title="Удирдлага";break;
            case "unpaid": $action_title="Төлөгдөөгүй нэхэмэжлэх";break;
            case "paid": $action_title="Төлөгдсөн нэхэмэжлэх";break;
            case "detail": $action_title="Дэлгэрэнгүй";break;

            
          }
          ?>
          <nav class="page-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="envoices">Нэхэмжлэх</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($action_title);?></li>
            </ol>
          </nav>

          <?php
          if ($action =="dashboard")
          {
            $sql = "SELECT * FROM envoice";
            $result = mysqli_query($conn,$sql);
            $total = mysqli_num_rows($result);
            ?>
            <div class="row">
              <div class="col-12 col-xl-12 stretch-card">
                <div class="row flex-grow">
                  <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                          <h6 class="card-title mb-0">Нийт нэхэмжлэх</h6>
                          <div class="dropdown mb-2">
                            <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <a class="dropdown-item d-flex align-items-center" href="customer?action=display"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">Харах</span></a>
                              <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Excel татах</span></a>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-6 col-md-12 col-xl-5">
                            <h3 class="mb-2"><?php echo number_format($total ?? 0);?></h3>
                            <div class="d-flex align-items-baseline">
                              <p class="text-success">
                                <span>+3.3%</span>
                                <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                              </p>
                            </div>
                          </div>
                          <div class="col-6 col-md-12 col-xl-7">
                            <div id="apexChart1" class="mt-md-3 mt-xl-0"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                          <h6 class="card-title mb-0">Шинэ нэхэмжлэх</h6>
                          <div class="dropdown mb-2">
                            <button class="btn p-0" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <a class="dropdown-item d-flex align-items-center" href="customer?action=active"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">Харах</span></a>
                              <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Excel татах</span></a>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-6 col-md-12 col-xl-5">
                            <h3 class="mb-2">841</h3>
                            <div class="d-flex align-items-baseline">
                              <p class="text-danger">
                                <span>-2.8%</span>
                                <i data-feather="arrow-down" class="icon-sm mb-1"></i>
                              </p>
                            </div>
                          </div>
                          <div class="col-6 col-md-12 col-xl-7">
                            <div id="apexChart2" class="mt-md-3 mt-xl-0"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                          <h6 class="card-title mb-0">Төлөгдсөн төлбөр</h6>
                          <div class="dropdown mb-2">
                            <button class="btn p-0" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                            <a class="dropdown-item d-flex align-items-center" href="customer?action=incoming"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">Харах</span></a>
                              <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Excel татах</span></a>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-6 col-md-12 col-xl-5">
                            <h3 class="mb-2">98</h3>
                            <div class="d-flex align-items-baseline">
                              <p class="text-success">
                                <span>+2.8%</span>
                                <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                              </p>
                            </div>
                          </div>
                          <div class="col-6 col-md-12 col-xl-7">
                            <div id="apexChart3" class="mt-md-3 mt-xl-0"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> <!-- row -->
           
            <?php
          }
          ?>

          <?php
          if ($action =="unpaid")
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
                            <th>Утас</th>
                            <th>Үүсгэсэн</th>
                            <th>Ачаа</th>
                            <th>Төлбөр</th>
                            <th>Төлөв</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $sql = "SELECT envoice.*,customer.name,customer.tel FROM envoice LEFT JOIN customer ON envoice.customer_id=customer.customer_id WHERE amount>0 ORDER BY envoice_id DESC";
                            $result = mysqli_query($conn,$sql);
                            if ($result && mysqli_num_rows($result)>0)
                            {
                              while ($data = mysqli_fetch_array($result))
                              {
                                if ($data) {
                                ?>
                                <tr>
                                  <td><?php echo isset($data["envoice_id"]) ? $data["envoice_id"] : '';?></td>
                                  <td><?php echo isset($data["name"]) ? $data["name"] : '';?></td>
                                  <td><?php echo isset($data["tel"]) ? $data["tel"] : '';?></td>
                                  <td><?php echo isset($data["created_date"]) ? substr($data["created_date"],0,10) : '';?></td>
                                  <td class="text-wrap"><?php echo isset($data["orders"]) ? $data["orders"] : '';?></td>
                                  <td><?php echo isset($data["amount"]) ? number_format($data["amount"]) : '0';?></td>
                                  <td><?php echo isset($data["status"]) ? $data["status"] : '';?></td>
                                  <td><?php echo isset($data["amount"]) ? number_format($data["amount"]) : '0';?></td>
                                </tr>
                                <?php
                                }
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
          if ($action =="paid")
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
                            <th>Утас</th>
                            <th>Үүсгэсэн</th>
                            <th>Ачаа</th>
                            <th>Төлбөр</th>
                            <th>Төлөв</th>
                            <th>Төлсөн</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $sql = "SELECT envoice.*,customer.name,customer.tel FROM envoice LEFT JOIN customer ON envoice.customer_id=customer.customer_id WHERE envoice.status='paid'";
                            $result = mysqli_query($conn,$sql);
                            if ($result && mysqli_num_rows($result)>0)
                            {
                              while ($data = mysqli_fetch_array($result))
                              {
                                if ($data) {
                                ?>
                                <tr>
                                  <td><?php echo isset($data["envoice_id"]) ? $data["envoice_id"] : '';?></td>
                                  <td><?php echo isset($data["name"]) ? $data["name"] : '';?></td>
                                  <td><?php echo isset($data["tel"]) ? $data["tel"] : '';?></td>
                                  <td><?php echo isset($data["created_date"]) ? substr($data["created_date"],0,10) : '';?></td>
                                  <td class="text-wrap"><?php echo isset($data["orders"]) ? $data["orders"] : '';?></td>
                                  <td><?php echo isset($data["amount"]) ? number_format($data["amount"]) : '0';?></td>
                                  <td><?php echo isset($data["status"]) ? $data["status"] : '';?></td>
                                  <td><?php echo isset($data["qpay_paid"]) ? $data["qpay_paid"] : '';?></td>
                                </tr>
                                <?php
                                }
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
          if ($action =="categorize")
          {
            if (isset($_GET["category"])) $category_id = $_GET["category"]; else header("location:envoices?action=category");
            ?>
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="dataTableExample" class="table">
                    <thead>
                      <tr>
                        <th>№</th>
                        <th>Нэр</th>
                        <th>Утас</th>
                        <th>Имэйл</th>
                        <th>Нэвтрэх нэр</th>
                        <th>Нэвтэрсэн</th>
                        <th>Үйлдэл</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $sql = "SELECT * FROM customer WHERE category='$category_id'";
                        $result = mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)>0)
                        {
                          while ($data = mysqli_fetch_array($result))
                          {

                            ?>
                            <tr>
                              <td><?php echo htmlspecialchars($data["customer_id"] ?? '');?></td>
                              <td class="text-wrap"><?php echo htmlspecialchars($data["name"] ?? '');?></td>
                              <td><?php echo htmlspecialchars($data["tel"] ?? '');?></td>
                              <td class="text-wrap"><?php echo htmlspecialchars($data["email"] ?? '');?></td>
                              <td class="text-wrap"><?php echo htmlspecialchars($data["username"] ?? '');?></td>
                              <td><?php echo isset($data["last_log"]) ? htmlspecialchars(substr($data["last_log"],0,10)) : '';?></td>
                              <td class="tx-18">
                                <div class="btn-group">
                                  <a href="envoices?action=detail&id=<?php echo htmlspecialchars($data["customer_id"] ?? '');?>" class="btn btn-success btn-xs text-white btn-icon" title="Харах"><i data-feather="user"></i></a>
                                  <a href="envoices?action=edit&id=<?php echo htmlspecialchars($data["customer_id"] ?? '');?>"  class="btn btn-warning btn-xs text-white btn-icon" title="Засах"><i data-feather="edit"></i></a>
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
            <?php
          }
          ?>

        <!-------------------------------------------------------------------->
        <!-------------------------------------------------------------------->
        <!-------------------           CATEGORY           ------------------->
        <!-------------------------------------------------------------------->
        <!-------------------------------------------------------------------->



        <?php
          if ($action =="category")
          {
            $count =1;
            ?>
            <div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table responsive">
                        <thead>
                          <tr>
                            <th class="wd-5p">№</th>
                            <th class="wd-200p">Ангиллын нэр</th>
                            <th class="wd-10p">Харилцагч</th>
                            <th class="wd-5p">Үйлдэл</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sql = "SELECT * FROM customer_category ORDER BY dd,name";
                          $result = mysqli_query($conn,$sql);
                          if ($result && mysqli_num_rows($result)>0)
                          {
                            while ($data = mysqli_fetch_array($result))
                            {
                              if ($data) {
                              ?>
                              <tr>
                                <td><?php echo $count++;?></td>
                                <td><a href="envoices?action=category_edit&id=<?php echo isset($data["id"]) ? $data["id"] : '';?>"><?php echo isset($data["name"]) ? $data["name"] : '';?></a></td>
                                <td><a href="envoices?action=categorize&category=<?php echo isset($data["id"]) ? $data["id"] : '';?>"><?php echo isset($data["count"]) ? $data["count"] : '0';?></a></td>
                                <td>
                                  <div class="btn-group">
                                    <a href="envoices?action=category_edit&id=<?php echo isset($data["id"]) ? $data["id"] : '';?>" title="Засах"><i data-feather="edit"></i></a>

                                  </div>
                                </td>
                              </tr>
                              <?php
                              }
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
            <a href="envoices?action=category_new" class="btn btn-success mg-t-10"><i class="icon ion-ios-plus"></i> Ангилал нэмэх</a>
            <?php
          }
          ?>

          <?php
          if ($action =="category_new")
          {
            ?>
            <div class="card">
              <div class="card-body">
                <form action="envoices?action=category_adding" method="post" enctype="multipart/form-data">
                  <div class="media-list ">
                    <div class="media">
                      <div class="media-body mg-l-15 mg-t-4">
                        <label for="name">Нэр (*)</label>
                        <input type="text" name="name" id="name" class="form-control" required="required">
                      </div>
                    </div>
                  </div>
                  <input type="submit" class="btn btn-success btn-lg mg-t-10" value="Үүсгэх">
                </form>
              </div>
            </div>
            <?php
          }
          ?>

         <?php
          if ($action =="category_adding")
          {
            ?>
            <div class="card">
              <div class="card-body">
                        <?php
                          $name = protect($_POST["name"]);

                            $sql = "INSERT INTO customer_category (name) VALUES ('$name')";
                            if (mysqli_query($conn,$sql))
                            {
                              $category_id = mysqli_insert_id($conn);
                              ?>
                              <div class="alert alert-success mg-b-10" role="alert">
                                Амжилттай нэмэгдлээ.
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
                                Алдаа гарлаа. <?php echo mysqli_error($conn);?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <?php
                            }


                          ?>                            
                          <div class="btn-group">
                            <a href="envoices?action=edit&id=<?php echo isset($category_id) ? $category_id : '';?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
                            <a href="envoices?action=category" class="btn btn-primary"><i data-feather="list"></i> Бүх ангилал</a>
                          </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <?php
          }
          ?>


          <?php
          if ($action =="category_edit")
          {
            ?>
            <div class="card">
              <div class="card-body">
                <form action="envoices?action=category_editing" method="post" enctype="multipart/form-data">
                  <?php
                  if (isset($_GET["id"])) $category_id=intval($_GET["id"]); else { header("location:envoices"); exit; }
                  $sql = "SELECT * FROM customer_category WHERE id=$category_id LIMIT 1";
                  $result= mysqli_query($conn,$sql);
                  if ($result && mysqli_num_rows($result)==1)
                  {
                    $data = mysqli_fetch_array($result);
                    if ($data) {
                    ?>
                    <input type="hidden" name="id" value="<?php echo isset($data["id"]) ? $data["id"] : '';?>">
                    <div class="media-list">
                      <div class="media">
                        <div class="media-body">
                          <label for="name">Нэр (*)</label>
                          <input type="text" name="name" id="name" value="<?php echo isset($data["name"]) ? htmlspecialchars($data["name"]) : '';?>" class="form-control" required="required">
                        </div>
                      </div>
                    </div>
                    <input type="submit" class="btn btn-success btn-lg mg-t-10" value="Засах">
                    <?php
                    }
                  }
                  ?>
                </form>
              </div>
            </div>

            <div class="btn-group mg-t-10">
              <a href="envoices?action=cateogory_delete&id=<?php echo isset($category_id) ? $category_id : '';?>" class="btn btn-danger btn-xs"><i class="icon ion-ios-trash"></i> Устгах</a>
              <a href="envoices?action=category" class="btn btn-primary btn-xs"><i data-feather="list"></i> Бүх ангилал</a>
            </div>
            <?php
          }
          ?>


          <?php
          if ($action =="category_editing")
          {
            ?>
              <div class="card">
                <div class="card-body">                
                        <?php
                        if (isset($_POST["id"])) $category_id=intval($_POST["id"]); else { header("location:envoices"); exit; }
                        $name = protect($_POST["name"]);
                        $sql = "UPDATE customer_category SET name='".mysqli_real_escape_string($conn, $name)."' WHERE id=$category_id LIMIT 1";
                       
                          if (mysqli_query($conn,$sql)) 
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
                               Алдаа гарлаа. <?php echo mysqli_error($conn);?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <?php
                            }


                          ?>                            
                          
                    </div>
                  </div>
             
            <div class="btn-group mg-t-10">
              <a href="envoices?action=category_edit&id=<?php echo isset($category_id) ? $category_id : '';?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
              <a href="envoices?action=category" class="btn btn-primary btn-xs"><i data-feather="list"></i> Бүх ангилал</a>
            </div>
            <?php
          }
          ?>


          <?php
          if ($action =="category_delete")
          {
            ?>
            <div class="row row-xs mg-t-10">
              
              <div class="col-lg-12 mg-t-10 order-lg-2">
                <div class="card card-customer-overview">
                  <div class="card-header">
                    <h6 class="slim-card-title">Мэдээний ангилал устгах</h6>
                  </div><!-- card-header -->
                  <div class="card-body">
                      <?php
                      if (isset($_GET["id"])) $category_id=intval($_GET["id"]); else { header("location:envoices"); exit; }
                      $sql = "SELECT * FROM customer_category WHERE id=$category_id LIMIT 1";
                      $result= mysqli_query($conn,$sql);
                      if ($result && mysqli_num_rows($result)==1)
                      {
                        // ORDEr ShALGAH ShAARDLAGATAI

                      
                        if (mysqli_query($conn,"DELETE FROM customer_category WHERE id=$category_id")) 
                          {
                            ?>
                            <div class="alert alert-success mg-b-10" role="alert">
                              Устгагдлаа.
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
                              Алдаа гарлаа. <?php echo mysqli_error($conn);?>
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <?php
                          }
                      }
                      ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="btn-group mg-t-10">
              <a href="envoices?action=category" class="btn btn-primary btn-xs"><i data-feather="list"></i> Бүх ангилал</a>
            </div>
            <?php
          }
          ?>


        <!-------------------------------------------------------------------->
        <!-------------------------------------------------------------------->
        <!-------------------           CATEGORY           ------------------->
        <!-------------------------------------------------------------------->
        <!-------------------------------------------------------------------->


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
  <script src="assets/js/jquery.chained.min.js"></script>
  <script src="assets/js/dashboard.js"></script>
  <script src="assets/js/apexcharts.js"></script>

  <script>
    $(document).ready(function() {
      $("#district").chained("#city");
    })
  </script>
    <script>
      $(function() {
    'use strict';

    $(function() {
      $('#dataTableExample').DataTable({
        "aLengthMenu": [
          [10, 30, 50, -1],
          [10, 30, 50, "All"]
        ],
        order: [[7, 'desc']],
        "iDisplayLength": 10,
        "language": {
          search: ""
        }
      });
      $('#dataTableExample').each(function() {
        var datatable = $(this);
        // SEARCH - Add the placeholder for Search and Turn this into in-line form control
        var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
        search_input.attr('placeholder', 'Search');
        search_input.removeClass('form-control-sm');
        // LENGTH - Inline-Form control
        var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
        length_sel.removeClass('form-control-sm');
      });
    });

  });
  </script>


	<!-- endinject -->

</body>
</html>    