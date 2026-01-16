<?
    require_once("config.php");
    require_once("views/helper.php");
    require_once("views/login_check.php");
    require_once("views/init.php");
?>

<link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<body class="sidebar-dark">
	<div class="main-wrapper">
		<?  require_once("views/navbar.php"); ?>
	
		<div class="page-wrapper">
      <?  require_once("views/sidebar.php"); ?>
			

			<div class="page-content">

        <!------------------------------------------------------------------------------------->
        
          <!--label class="section-title">Basic Responsive DataTable</label>
          <p class="mg-b-20 mg-sm-b-40">Searching, ordering and paging goodness will be immediately added to the table, as shown in this example.</p-->
          <?
          if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="dashboard";?>
          <?
          switch ($action)
          {
            case "display": $action_title="Бүх харилцагч";break;
            case "new": $action_title="Шинэ харилцагч";break;
            case "active": $action_title="Идэвхитэй харилцагч";break;
            case "warehouse": $action_title="Агуулахад ачаатай харилцагч";break;
            case "incoming": $action_title="Ирж буй ачаатай харилцагч";break;
            case "category": $action_title="Харилцагчийн ангилал";break;          
            case "category_new": $action_title="Ангилал нэмэх";break;          
            case "category_adding": $action_title="Ангилал нэмэх";break;          
            case "category_edit": $action_title="Ангилал засах";break;          
            case "category_editing": $action_title="Ангилал засах";break;          
            case "category_delete": $action_title="Ангилал устгах";break;          
            case "categorize": $action_title="Ангилсан харилцагч";break;
            case "register": $action_title="Харилцагч бүртгэх";break;
            case "registering": $action_title="Харилцагч бүртгэх";break;
            case "detail": $action_title="Харилцагчийн дэлгэрэнгүй";break;
            case "edit": $action_title="Харилцагчийн мэдээлэл засах";break;
            case "editing": $action_title="Харилцагчийн мэдээлэл засах";break;
            case "delete": $action_title="Харилцагчийн мэдээлэл устгах";break;
            case "dashboard": $action_title="Удирдлага";break;
            case "search": $action_title="Харилцагч хайх";break;
            case "proxy_clear": $action_title="Proxy чөлөөлөх";break;
            case "error": $action_title="Мэдээлэл алдаатай";break;

            
          }
          ?>
          <nav class="page-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="customers">Харилцагч</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?=$action_title;?></li>
            </ol>
          </nav>

          <?
          if ($action =="dashboard")
          {
            $sql = "SELECT *FROM customer";
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
                          <h6 class="card-title mb-0">Нийт харилцагч</h6>
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
                            <h3 class="mb-2"><?=number_format($total);?></h3>
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
                          <h6 class="card-title mb-0">Идэвхитэй харилцагч</h6>
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
                          <h6 class="card-title mb-0">Ирж буй ачаатай харилцагч</h6>
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
            <div class="row">
              <div class="col-lg-6">
                <div class="card">
                  <div class="card-body">
                    <h6 class="card-title">Харилцагч хайх</h6>
                    <form action="customers?action=search" method="post">
                      <div class="form-group">
                        <input type="text" class="form-control" id="search" autocomplete="off" placeholder="Утас, нэр, нэвтрэх нэр, ииэйл, регистрийн дугаараар хайх" name="search">
                      </div>
                      <button type="submit" class="btn btn-primary mr-2">Хайх</button>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h6 class="card-title">Харилцагчийн ангилал</h6>
                    <div id="apexDonut"></div>
                  </div>
                </div>
              </div>
            </div>
            <?
          }
          ?>

          <?
          if ($action =="search")
          {
            if(isset($_POST["search"])) $search = $_POST["search"]; else $search="";
            ?>
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-body">
                    <h6 class="card-title">Харилцагч хайх</h6>
                    <form action="customers?action=search" method="post">
                      <div class="form-group">
                        <label for="search">Хэрэглэгч хайх</label>
                        <input type="text" class="form-control" id="search" autocomplete="off" placeholder="Утас, нэр, нэвтрэх нэр, ииэйл, регистрийн дугаараар хайх" value="<?=$search;?>" name="search"> 
                      </div>
                      <button type="submit" class="btn btn-primary mr-2">Хайх</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <? 
            if (strlen($search)>=3)
            {
              ?>
              <div class="row mt-3">
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
                              <th>Имэйл</th>
                              <th>Нэвтрэх нэр</th>
                              <th>Нэвтэрсэн</th>
                              <th>Үйлдэл</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?
                              $sql= "SELECT * FROM customer WHERE CONCAT_WS(name,surname,tel,rd,email,username) LIKE '%".$search."%'";
                              $result = mysqli_query($conn,$sql);
                              if (mysqli_num_rows($result)>0)
                              {
                                while ($data = mysqli_fetch_array($result))
                                {

                                  ?>
                                  <tr>
                                    <td><?=$data["customer_id"];?></td>
                                    <td class="text-wrap"><?=$data["name"];?></td>
                                    <td><?=$data["tel"];?></td>
                                    <td class="text-wrap"><?=$data["email"];?></td>
                                    <td class="text-wrap"><?=$data["username"];?></td>
                                    <td><?=substr($data["last_log"],0,10);?></td>
                                    <td class="tx-18">
                                      <div class="btn-group">
                                    <a href="customers?action=detail&id=<?=$data["customer_id"];?>" class="btn btn-success btn-xs text-white btn-icon" title="Харах"><i data-feather="user"></i></a>
                                    <a href="customers?action=edit&id=<?=$data["customer_id"];?>"  class="btn btn-warning btn-xs text-white btn-icon" title="Засах"><i data-feather="edit"></i></a>
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
                  </div>
                </div>
              </div>
              <?
            }
            
            if (strlen($search)<3)
            {
              ?>
              <div class="row mt-3">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="alert alert-icon-danger" role="alert">
                        <i data-feather="alert-circle"></i>
                        Хайх утгыг 3 үсгээс их тэмдэгтээр хайна уу.
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            
              <?
            }
            
          }
          ?>

          <?
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
                            <th>Утас</th>
                            <th>Имэйл</th>
                            <th>Нэвтрэх нэр</th>
                            <th>Нэвтэрсэн</th>
                            <th>Үйлдэл</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?
                            $sql = "SELECT *FROM customer";
                            $result = mysqli_query($conn,$sql);
                            if (mysqli_num_rows($result)>0)
                            {
                              while ($data = mysqli_fetch_array($result))
                              {

                                ?>
                                <tr>
                                  <td><?=$data["customer_id"];?></td>
                                  <td class="text-wrap"><?=$data["name"];?></td>
                                  <td><?=$data["tel"];?></td>
                                  <td class="text-wrap"><?=$data["email"];?></td>
                                  <td class="text-wrap"><?=$data["username"];?></td>
                                  <td><?=substr($data["last_log"],0,10);?></td>
                                  <td class="tx-18">
                                    <div class="btn-group">
                                  <a href="customers?action=detail&id=<?=$data["customer_id"];?>" class="btn btn-success btn-xs text-white btn-icon" title="Харах"><i data-feather="user"></i></a>
                                  <a href="customers?action=edit&id=<?=$data["customer_id"];?>"  class="btn btn-warning btn-xs text-white btn-icon btn-icon" title="Засах"><i data-feather="edit"></i></a>
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
                </div>
              </div>
            </div>
            <?
          }
          ?>

          <?
          if ($action =="new")
          {
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
                      <?
                        $sql = "SELECT *FROM customer WHERE registered_date IS NOT NULL ORDER BY registered_date DESC LIMIT 100";
                        $result = mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)>0)
                        {
                          while ($data = mysqli_fetch_array($result))
                          {

                            ?>
                            <tr>
                              <td><?=$data["customer_id"];?></td>
                              <td class="text-wrap"><?=$data["name"];?></td>
                              <td><?=$data["tel"];?></td>
                              <td class="text-wrap"><?=$data["email"];?></td>
                              <td class="text-wrap"><?=$data["username"];?></td>
                              <td><?=substr($data["last_log"],0,10);?></td>
                              <td class="tx-18">
                                <div class="btn-group">
                                  <a href="customers?action=detail&id=<?=$data["customer_id"];?>" class="btn btn-success btn-xs text-white btn-icon" title="Харах"><i data-feather="user"></i></a>
                                  <a href="customers?action=edit&id=<?=$data["customer_id"];?>"  class="btn btn-warning btn-xs text-white btn-icon" title="Засах"><i data-feather="edit"></i></a>
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
            </div>
            <?
          }
          ?>


          <?
          if ($action =="categorize")
          {
            if (isset($_GET["category"])) $category_id = $_GET["category"]; else header("location:customers?action=category");
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
                      <?
                        $sql = "SELECT *FROM customer WHERE category='$category_id'";
                        $result = mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)>0)
                        {
                          while ($data = mysqli_fetch_array($result))
                          {

                            ?>
                            <tr>
                              <td><?=$data["customer_id"];?></td>
                              <td class="text-wrap"><?=$data["name"];?></td>
                              <td><?=$data["tel"];?></td>
                              <td class="text-wrap"><?=$data["email"];?></td>
                              <td class="text-wrap"><?=$data["username"];?></td>
                              <td><?=substr($data["last_log"],0,10);?></td>
                              <td class="tx-18">
                                <div class="btn-group">
                                  <a href="customers?action=detail&id=<?=$data["customer_id"];?>" class="btn btn-success btn-xs text-white btn-icon" title="Харах"><i data-feather="user"></i></a>
                                  <a href="customers?action=edit&id=<?=$data["customer_id"];?>"  class="btn btn-warning btn-xs text-white btn-icon" title="Засах"><i data-feather="edit"></i></a>
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
            </div>
            <?
          }
          ?>


          <?
          if ($action =="error")
          {
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
                      <?
                        $sql = "SELECT *FROM customer WHERE name='' OR name='.' OR tel regexp '[a-z]'";
                        $result = mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)>0)
                        {
                          while ($data = mysqli_fetch_array($result))
                          {

                            ?>
                            <tr>
                              <td><?=$data["customer_id"];?></td>
                              <td class="text-wrap"><?=$data["name"];?></td>
                              <td><?=$data["tel"];?></td>
                              <td class="text-wrap"><?=$data["email"];?></td>
                              <td class="text-wrap"><?=$data["username"];?></td>
                              <td><?=substr($data["last_log"],0,10);?></td>
                              <td class="tx-18">
                                <div class="btn-group">
                                  <a href="customers?action=detail&id=<?=$data["customer_id"];?>" class="btn btn-success btn-xs text-white btn-icon" title="Харах"><i data-feather="user"></i></a>
                                  <a href="customers?action=edit&id=<?=$data["customer_id"];?>"  class="btn btn-warning btn-xs text-white btn-icon" title="Засах"><i data-feather="edit"></i></a>
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
            </div>
            <?
          }
          ?>



          <?
          if ($action =="active")
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
                            <th>Имэйл</th>
                            <th>Нэвтрэх нэр</th>
                            <th>Нэвтэрсэн</th>
                            <th>Үйлдэл</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?
                            $sql = "SELECT *FROM customer WHERE last_order_date IS NOT NULL ORDER BY last_order_date DESC LIMIT 100";
                            $result = mysqli_query($conn,$sql);
                            if (mysqli_num_rows($result)>0)
                            {
                              while ($data = mysqli_fetch_array($result))
                              {

                                ?>
                                <tr>
                                  <td><?=$data["customer_id"];?></td>
                                  <td class="text-wrap"><?=$data["name"];?></td>
                                  <td><?=$data["tel"];?></td>
                                  <td class="text-wrap"><?=$data["email"];?></td>
                                  <td class="text-wrap"><?=$data["username"];?></td>
                                  <td><?=substr($data["last_log"],0,10);?></td>
                                  <td class="tx-18">
                                    <div class="btn-group">
                                      <a href="customers?action=detail&id=<?=$data["customer_id"];?>" class="btn btn-success btn-xs text-white btn-icon" title="Харах"><i data-feather="user"></i></a>
                                      <a href="customers?action=edit&id=<?=$data["customer_id"];?>"  class="btn btn-warning btn-xs text-white btn-icon" title="Засах"><i data-feather="edit"></i></a>
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
                </div>
              </div>
            </div>
            <?
          }
          ?>

          <?
          if ($action =="register")
          {
            // $sql = "SELECT max(customer_id) as MAX FROM customer";
            // $result  = mysqli_query($conn,$sql);
            // $data = mysqli_fetch_array($result);
            // $max_number = $data["MAX"];
            // $max_number++;
            // $finnumber = settings("prefix").sprintf('%05d', $max_number);
            ?>
            
            <form action="customers?action=registering" method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-lg-6">
                  <div class="card">
                    <div class="card-body">
                      <div class="media-list ">
                        <div class="media">
                          <div class="media-body mg-l-15 mg-t-4">
                            <label for="surname">Овог (*)</label>
                            <input type="text" name="surname" id="surname" value="" class="form-control" required="required">
                          </div>
                        </div>
                        <div class="media">
                          <div class="media-body mg-l-15 mg-t-4">
                            <label for="name">Нэр (*)</label>
                            <input type="text" name="name" id="name" value="" class="form-control" required="required">
                          </div>
                        </div>
                        <div class="media">
                          <div class="media-body mg-l-15 mg-t-4">
                            <label for="tel">Утасны дугаар (*)</label>
                            <input type="text" name="tel" id="tel" value="" class="form-control" required="required">
                          </div>
                        </div>
                        <div class="media">
                          <div class="media-body mg-l-15 mg-t-4">
                            <label for="rd">РД</label>
                            <input type="text" name="rd" id="rd" value="" class="form-control">
                          </div>
                        </div>
                        <div class="media">
                          <div class="media-body mg-l-15 mg-t-4">
                            <label for="email">И-мэйл</label>
                            <input type="text" name="email" id="email" value="" class="form-control">
                          </div>
                        </div>

                        <div class="media">
                          <div class="media-body mg-l-15 mg-t-4">
                            <div class="form-check form-check-flat form-check-primary">
                              <label class="form-check-label">
                              <input type="checkbox" name="no_proxy" checked id="no_proxy" class="form-check-input">
                                Proxy авах эсэх
                              </label>
                            </div>
                          </div>
                        </div>
                        
                      </div>

                    </div>
                  </div>
                  <div class="card mt-3 mb-3">
                    <div class="card-body">
                      <div class="media-list">
                        <div class="media">
                          <div class="media-body mg-l-15 mg-t-4">
                            <label for="address">Хаяг</label>
                            <input type="text" name="address" id="address" value="" class="form-control">
                          </div>
                        </div>
                        <div class="media">
                          <div class="media-body mg-l-15 mg-t-4">
                            <label for="address_extra">Нэмэлт мэдээлэл</label>
                            <input type="text" name="address_extra" id="address_extra" value="" class="form-control">
                          </div>
                        </div>
                      </div>

                      <div class="media">
                        <div class="media-body mg-l-15 mg-t-4">
                          <label for="city">Хот, аймаг</label>
                          <select name="city" class="form-control" id="city">
                            <?
                            $sql_city =  "SELECT *FROM city";
                            $result_city = mysqli_query($conn,$sql_city);
                            while ($data_city = mysqli_fetch_array($result_city))
                            {
                              ?>
                              <option value="<?=$data_city["id"];?>"><?=$data_city["name"];?></option>
                              <?
                            }
                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="media">
                        <div class="media-body mg-l-15 mg-t-4">
                          <label for="city">Дүүрэг, сум</label>
                          <select name="district" class="form-control" id="district">
                            <?
                            $sql_district =  "SELECT *FROM district";
                            $result_district = mysqli_query($conn,$sql_district);
                            while ($data_district = mysqli_fetch_array($result_district))
                            {
                              ?>
                              <option value="<?=$data_district["id"];?>" data-chained="<?=$data_district["city_id"];?>"><?=$data_district["name"];?></option>
                              <?
                            }
                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="media">
                        <div class="media-body mg-l-15 mg-t-4">
                          <label for="khoroo">Баг, хороо</label>
                          <input type="text" name="khoroo" id="khoroo" value="" class="form-control">
                        </div>
                      </div>

                      <div class="media">
                        <div class="media-body mg-l-15 mg-t-4">
                          <label for="build">Байр, гудамж</label>
                          <input type="text" name="build" id="build" value="" class="form-control">
                        </div>
                      </div>
                    
                    </div>
                    
                  </div>
                  <input type="submit" class="btn btn-success btn-lg" value="Бүртгэх">
                </div>
                <div class="col-lg-6">
                  <div class="card">
                    <div class="card-body">
                      <div class="media-list">
                        <div class="media">
                          <div class="media-body mg-l-15 mg-t-2">
                            <label for="image">Цээж зураг</label>
                            <input type="file" id="image" name="image" class="form-control">
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
                            <input type="password" name="password" id="password" value="" class="form-control" required="required">
                          </div>
                        </div>

                        <div class="media">
                          <div class="media-body mg-l-15 mg-t-2">
                            <label for="category">Ангилал</label>
                            <select class="form-control" name="category" id="category">
                              <option value="0">Ангилалгүй</option>
                              <?
                              $sql_cat = "SELECT *FROM customer_category ORDER BY dd";
                              $result_cat= mysqli_query($conn,$sql_cat);
                              while ($data_cat = mysqli_fetch_array($result_cat))
                              {
                                ?>
                                <option value="<?=$data_cat["id"];?>"><?=$data_cat["name"];?></option>
                                <?
                              }
                              ?>
                            </select>
                            
                          </div>
                        </div>
                      </div>
                      
                    </div>
                  </div>
              </div> 
            </form>
            <?
          }
          ?>


          <?
          if ($action =="registering")
          {
            ?>
            <div class="row row-xs mg-t-10">
              <div class="col-lg-12 order-lg-2">
                  <div class="card">
                    <div class="card-header">
                      <h6 class="slim-card-title">Бүртгэл</label>
                    </div><!-- card-header -->
                    <div class="card-body">
                        <?
                          $error = 0;
                          $error_msg = "";
                          $rd = $_POST["rd"];
                          $surname = $_POST["surname"];
                          $name = $_POST["name"];
                          $tel = $_POST["tel"];
                          $email = $_POST["email"];
                          $username = $_POST["username"];
                          $password = $_POST["password"];
                          $category = $_POST["category"];

                          $address = $_POST["address"];
                          $address_extra = $_POST["address_extra"];
                          $city = $_POST["city"];
                          $district = $_POST["district"];
                          $khoroo = $_POST["khoroo"];
                          $build = $_POST["build"];
                          if (!isset($_POST["no_proxy"])) $no_proxy=1; else $no_proxy=0;
                          
    
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

                          $sql = "INSERT INTO customer (rd,name,surname,tel,avatar,thumb,username,password,email,category,address,address_extra,address_city,address_district,address_khoroo,address_build,no_proxy) 
                          VALUES ('$rd','$name','$surname','$tel','$image', '$thumb','$username','$password','$email','$category','$address','$address_extra','$city','$district','$khoroo','$build','$no_proxy')";                   
                          if (mysqli_query($conn,$sql))
                            {
                              $customer_id = mysqli_insert_id($conn);
                              mysqli_query ($conn,"UPDATE customer_category SET count=count+1 WHERE id='".$category."' LIMIT 1");
                              ?>
                              <div class="alert alert-success mg-b-10" role="alert">
                                Амжилттай бүртгэлээ.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="btn-group">
                                <a href="customers?action=detail&id=<?=$customer_id;?>" class="btn btn-success"><i data-feather="edit"></i> Дэлгэрэнгүй</a>
                                <a href="customers?action=edit&id=<?=$customer_id;?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
                                <a href="customers?action=new" class="btn btn-primary"><i class="icon ion-ios-list"></i> Шинэ харилцагчид</a>
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
                              </div>
                              <div class="btn-group">
                                <a href="customers?action=register" class="btn btn-success"><i data-feather="edit"></i> Ахин оролдох</a>
                              </div>
                              <?
                            }


                          ?>                            
                          
                          

                    </div>
                  </div>
                </form>
              </div>
            </div>
            <?
          }
          ?>

          <?
          if ($action =="detail")
          {
              if (isset($_GET["id"])) $id=$_GET["id"]; else header("location:customers");
              $sql = "SELECT *FROM customer WHERE customer_id='$id' LIMIT 1";
              $result= mysqli_query($conn,$sql);
              if (mysqli_num_rows($result)==1)
              {
                $data = mysqli_fetch_array($result);
                ?>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="media-list ">
                              <div class="media">
                                <div class="media-body mg-l-15 mg-t-4">
                                  <label>Овог</label>
                                  <a href="#" class="d-block"><?=$data["surname"];?></a>
                                </div>
                              </div>
                              <div class="media">
                                <div class="media-body mg-l-15 mg-t-4">
                                  <label>Нэр</label>
                                  <a href="#" class="d-block"><?=$data["name"];?></a>
                                </div>
                              </div>

                              <div class="media">
                                <div class="media-body mg-l-15 mg-t-4">
                                  <label>Утас</label>
                                  <a href="#" class="d-block"><?=$data["tel"];?></a>
                                </div>
                              </div>

                              <div class="media">
                                <div class="media-body mg-l-15 mg-t-4">
                                  <label>Имэйл</label>
                                  <a href="#" class="d-block"><?=$data["email"];?></a>
                                </div>
                              </div>

                              <div class="media">
                                <div class="media-body mg-l-15 mg-t-4">
                                  <label>РД</label>
                                  <a href="#" class="d-block"><?=$data["rd"];?></a>
                                </div>
                              </div>

                              <div class="media">
                                <div class="media-body mg-l-15 mg-t-4">
                                  <label>Хаяг</label>
                                  <a href="#" class="d-block"><?=$data["address"];?></a>
                                </div>
                              </div>

                              <div class="media">
                                <div class="media-body mg-l-15 mg-t-4">
                                  <label>Нэмэлт</label>
                                  <a href="#" class="d-block"><?=$data["address_extra"];?></a>
                                </div>
                              </div>

                              <div class="media">
                                <div class="media-body mg-l-15 mg-t-4">
                                  <label>Хот, аймаг</label>
                                  <?
                                  $sql_city =  "SELECT *FROM city WHERE id='".$data["address_city"]."'";
                                  $result_city = mysqli_query($conn,$sql_city);
                                  $data_city = mysqli_fetch_array($result_city);
                                  ?>
                                  <a href="#" class="d-block"><?=$data_city["name"];?></a>
                                </div>
                              </div>

                              <div class="media">
                                <div class="media-body mg-l-15 mg-t-4">
                                  <label>Дүүрэг, сум</label>
                                  <?
                                  $sql_district =  "SELECT *FROM district WHERE id='".$data["address_district"]."'";
                                  $result_district = mysqli_query($conn,$sql_district);
                                  $data_district = mysqli_fetch_array($result_district);
                                  ?>
                                  <a href="#" class="d-block"><?=$data_district["name"];?></a>
                                </div>
                              </div>

                              <div class="media">
                                <div class="media-body mg-l-15 mg-t-4">
                                  <label>Хороо, баг</label>
                                  <a href="#" class="d-block"><?=$data["address_khoroo"];?></a>
                                </div>
                              </div>

                              <div class="media">
                                <div class="media-body mg-l-15 mg-t-4">
                                  <label>Байр гудамж</label>
                                  <a href="#" class="d-block"><?=$data["address_build"];?></a>
                                </div>
                              </div>

                              <div class="btn-group">
                                <a href="customers?action=edit&id=<?=$data["customer_id"];?>" class="btn btn-success btn-icon-text"><i class="btn-icon-prepend" data-feather="edit"></i> Засах</a>
                              </div>

                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="media-list ">
                              <?
                              if ($data["avatar"]<>"" && file_exists('../'.$data["avatar"]))
                              {
                                ?>
                                <div class="media">
                                  <img src="../<?=$data["avatar"];?>" style="max-width:100%">
                                </div>
                                <?
                              }
                              ?>
                              <div class="media">
                                <div class="media-body mg-l-15 mg-t-2">
                                  <label for="exampleInputUsername1">Нэвтрэх нэр</label>
                                  <a href="#" class="d-block"><?=$data["username"];?></a>
                                </div>
                              </div>
                              <div class="media">
                                <div class="media-body mg-l-15 mg-t-2">
                                  <label for="exampleInputUsername1">Нууц үг</label>
                                  <a href="#" class="d-block"><?=$data["password"];?></a>
                                </div>
                              </div>
                              <div class="media">
                                <div class="media-body mg-l-15 mg-t-2">
                                  <label for="exampleInputUsername1">Огноо</label>
                                  Бүртгүүлсэн <a href="#" class="d-block"><?=$data["registered_date"];?></a>
                                  Засварласан <a href="#" class="d-block"><?=$data["modified_date"];?></a>
                                  Сүүлд нэвтэрсэн <a href="#" class="d-block"><?=$data["last_log"];?></a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?
                    if ($data["no_proxy"]==0)
                    {
                      $count=1;
                      ?>
                      <div class="card mt-3 mb-3">
                        <div class="card-body">
                          <h5 class="card-title">
                            Proxy 
                            <a class="btn btn-danger btn-sm float-right" href="customers?action=proxy_clear&id=<?=$id;?>">Бүгдийг чөлөөлөх</a>
                          </h5>
                            <table class="table table-responsive table-striped">
                              <thead>
                                <tr>
                                  <th>№</th>
                                  <th>Нэр / Овог</th>
                                  <th>Утас</th>
                                  <th>Хаяг</th>
                                  <th>Ашигласан</th>
                                  <th>Үйлдэл</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?
                                $sql_proxy = "SELECT * FROM proxies WHERE customer_id='".$id."'";
                                $result_proxy = mysqli_query($conn,$sql_proxy);
                                if (mysqli_num_rows($result_proxy)>0)
                                {
                                  while ($data_proxy = mysqli_fetch_array($result_proxy))
                                  {
                                  ?>
                                  <tr>
                                    <td><?=$count++;?></td>
                                    <td class="text-wrap"><?=$data_proxy["name"];?><br><?=$data_proxy["surname"];?></td>
                                    <td class="text-wrap"><?=$data_proxy["tel"];?></td>
                                    <td class="text-wrap"><?=$data_proxy["address"];?></td>
                                    <td><?=(!$data_proxy["status"])?'Үгүй':'Тийм';?></td>
                                    <td>
                                      <div class="btn-group">
                                        <a href="customers?action=proxy_edit&proxy=<?=$data_proxy["proxy_id"];?>" title="Засах" class="btn btn-warning btn-icon btn-xs text-white"><i data-feather="edit"></i></a>
                                        <a href="customers?action=proxy_delete&proxy=<?=$data_proxy["proxy_id"];?>" title="Устгах" class="btn btn-danger btn-icon btn-xs text-white"><i data-feather="trash"></i></a>
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
                      <?
                    }          
                    ?>
                  </div>

                  <div class="col-lg-6">
                    <div class="card">
                      <div class="card-body">
                      <h5 class="card-title">
                          Идэвхитэй ачаа
                          </h5>
                            <? $count=1;?>
                            <table class="table table-responsive table-striped">
                              <thead>
                                <tr>
                                  <th>№</th>
                                  <th>Barcode / track</th>
                                  <th>Ачаа</th>
                                  <th>Шилжилт</th>
                                  <th>Төлөв</th>
                                  <th>Үйлдэл</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?
                                $sql_order = "SELECT * FROM orders WHERE receiver='".$id."' AND status NOT IN ('delivered','customs')";
                                $result_order = mysqli_query($conn,$sql_order);
                                if (mysqli_num_rows($result_order)>0)
                                {
                                  while ($data_order = mysqli_fetch_array($result_order))
                                  {

                                    $package_array=explode("##",$data_order["package"]);
                                    $package1_name = $package_array[0];
                                    $package1_num = $package_array[1];
                                    $package1_price = $package_array[2];
                                    $package2_name = $package_array[3];
                                    $package2_num = $package_array[4];
                                    $package2_price = $package_array[5];
                                    $package3_name = $package_array[6];
                                    $package3_num = $package_array[7];
                                    $package3_price = $package_array[8];
                                    $package4_name = $package_array[9];
                                    $package4_num = $package_array[10];
                                    $package4_price = $package_array[11];
                                    
                                  ?>
                                  <tr>
                                    <td><?=$count++;?></td>
                                    <td class="text-wrap"><?=$data_order["barcode"];?><br><?=$data_order["third_party"];?></td>
                                    
                                    <td class="text-wrap">
                                    <?=$package1_name;?> (<?=$package1_num;?>) - <?=$package1_price;?> $<br>
                                    <? if ($package2_name!="")
                                    {
                                      ?>
                                      <?=$package2_name;?> (<?=$package2_num;?>) - <?=$package2_price;?> $<br>
                                      <?
                                    }

                                      if ($package3_name!="")
                                    {
                                      ?>
                                      <?=$package3_name;?> (<?=$package3_num;?>) - <?=$package3_price;?> $
                                      <?
                                    }
                                      if ($package4_name!="")
                                    {
                                      ?>
                                      <?=$package4_name;?> (<?=$package4_num;?>) - <?=$package4_price;?> $
                                      <?
                                    }
                                    ?>
                                    </td>
                                    <td class="text-wrap"><?=substr($data_order["timestamp"],0,10);?></td>
                                    <td class="text-wrap"><?=$data_order["status"];?></td>
                                    <td>
                                      <div class="btn-group">
                                        <a href="orders?action=detail&proxy=<?=$data_order["id"];?>" title="Засах" class="btn btn-success btn-icon btn-xs text-white"><i data-feather="more-vertical"></i></a>
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
                    <div class="card mt-3 mb-3">
                      <div class="card-body">
                          <h5 class="card-title">Архивлагдсан ачаа</h5>
                          <table class="table table-responsive">
                            <thead>
                              <tr>
                                <th>Barcode / track</th>
                                <th>Ачаа</th>
                                <th>Гардуулсан</th>
                                <th>Үйлдэл</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?
                              $sql_order = "SELECT * FROM orders WHERE receiver='".$id."' AND status IN ('delivered','customs') LIMIT 1";
                              $result_order = mysqli_query($conn,$sql_order);
                              if (mysqli_num_rows($result_order)>0)
                              {
                                while ($data_order = mysqli_fetch_array($result_order))
                                {

                                  $package_array=explode("##",$data_order["package"]);
                                  $package1_name = $package_array[0];
                                  $package1_num = $package_array[1];
                                  $package1_price = $package_array[2];
                                  $package2_name = $package_array[3];
                                  $package2_num = $package_array[4];
                                  $package2_price = $package_array[5];
                                  $package3_name = $package_array[6];
                                  $package3_num = $package_array[7];
                                  $package3_price = $package_array[8];
                                  $package4_name = $package_array[9];
                                  $package4_num = $package_array[10];
                                  $package4_price = $package_array[11];
                                  
                                ?>
                                <tr>
                                  <td class="text-wrap"><?=$data_order["barcode"];?><br><?=$data_order["third_party"];?></td>
                                  <td class="text-wrap"><?=substr($data_order["timestamp"],0,10);?></td>
                                  <td class="text-wrap">
                                  <?=$package1_name;?> (<?=$package1_num;?>) - <?=$package1_price;?> $<br>
                                  <? if ($package2_name!="")
                                  {
                                    ?>
                                    <?=$package2_name;?> (<?=$package2_num;?>) - <?=$package2_price;?> $<br>
                                    <?
                                  }

                                    if ($package3_name!="")
                                  {
                                    ?>
                                    <?=$package3_name;?> (<?=$package3_num;?>) - <?=$package3_price;?> $
                                    <?
                                  }
                                    if ($package4_name!="")
                                  {
                                    ?>
                                    <?=$package4_name;?> (<?=$package4_num;?>) - <?=$package4_price;?> $
                                    <?
                                  }
                                  ?>
                                  </td>
                                  <td>
                                    <div class="btn-group">
                                      <a href="orders?action=detail&proxy=<?=$data_order["id"];?>" title="Засах" class="btn btn-success btn-icon btn-xs text-white"><i data-feather="more-vertical"></i></a>
                                    </div>
                                      
                                  </td>
                                </tr>
                                <?
                                }
                              }
                              ?>
                            </tbody>
                          </table>
                          <a href="orders?action=list&customer=<?=$id;?>" class="btn btn-success btn-icon-text mt-3"><i data-feather="list" class="btn-icon-prepend"></i>Архивыг харах</a>

                      </div>
                    </div>
                  </div>
                </div>

                <div class="btn-group">
                  <a href="customers" class="btn btn-primary btn-icon-text"><i class="btn-icon-prepend" data-feather="list"></i> Харилцагч</a>
                </div>
                
                <?
              }
              else header("location:customer");
          }
          ?>



          <?
          if ($action =="edit")
          {
            ?>
            <form action="customers?action=editing" method="post" enctype="multipart/form-data">
              <?
                if (isset($_GET["id"])) $id=$_GET["id"]; else header("location:customers");
                $sql = "SELECT *FROM customer WHERE customer_id='$id' LIMIT 1";
                $result= mysqli_query($conn,$sql);
                if (mysqli_num_rows($result)==1)
                {
                  $data = mysqli_fetch_array($result);
                  ?>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="card">
                        <div class="card-body">
                          <input type="hidden" name="id" value="<?=$data["customer_id"];?>">
                          <div class="media-list ">
                            <div class="media">
                              <div class="media-body mg-l-15 mg-t-4">
                                <label for="surname">Овог (*)</label>
                                <input type="text" name="surname" id="surname" value="<?=$data["surname"];?>" class="form-control" required="required">
                              </div>
                            </div>
                            <div class="media">
                              <div class="media-body mg-l-15 mg-t-4">
                                <label for="name">Нэр (*)</label>
                                <input type="text" name="name" id="name" value="<?=$data["name"];?>" class="form-control" required="required">
                              </div>
                            </div>
                            <div class="media">
                              <div class="media-body mg-l-15 mg-t-4">
                                <label for="tel">Утасны дугаар (*)</label>
                                <input type="text" name="tel" id="tel" value="<?=$data["tel"];?>" class="form-control" required="required">
                              </div>
                            </div>
                            <div class="media">
                              <div class="media-body mg-l-15 mg-t-4">
                                <label for="rd">РД</label>
                                <input type="text" name="rd" id="rd" value="<?=$data["rd"];?>" class="form-control">
                              </div>
                            </div>
                            <div class="media">
                              <div class="media-body mg-l-15 mg-t-4">
                                <label for="email">И-мэйл</label>
                                <input type="text" name="email" id="email" value="<?=$data["email"];?>" class="form-control">
                              </div>
                            </div>

                            <div class="media">
                              <div class="media-body mg-l-15 mg-t-4">
                                <div class="form-check form-check-flat form-check-primary">
                                  <label class="form-check-label">
                                  <input type="checkbox" name="no_proxy" <?=(!$data["no_proxy"])?'checked':'';?> id="no_proxy" class="form-check-input">
                                    Proxy авах эсэх
                                  </label>
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                      <div class="card mt-3 mb-3">
                        <div class="card-body">
                          <div class="media-list">
                            <div class="media">
                              <div class="media-body mg-l-15 mg-t-4">
                                <label for="address">Хаяг</label>
                                <input type="text" name="address" id="address" value="<?=$data["address"];?>" class="form-control">
                              </div>
                            </div>
                            <div class="media">
                              <div class="media-body mg-l-15 mg-t-4">
                                <label for="address_extra">Нэмэлт мэдээлэл</label>
                                <input type="text" name="address_extra" id="address_extra" value="<?=$data["address_extra"];?>" class="form-control">
                              </div>
                            </div>
                          </div>

                          <div class="media">
                            <div class="media-body mg-l-15 mg-t-4">
                              <label for="city">Хот, аймаг</label>
                              <select name="city" class="form-control" id="city">
                                <?
                                $sql_city =  "SELECT *FROM city";
                                $result_city = mysqli_query($conn,$sql_city);
                                while ($data_city = mysqli_fetch_array($result_city))
                                {
                                  ?>
                                  <option value="<?=$data_city["id"];?>" <?=($data_city["id"]==$data["address_city"])?'SELECTED="SELECTED"':'';?>><?=$data_city["name"];?></option>
                                  <?
                                }
                                ?>
                              </select>
                            </div>
                          </div>

                          <div class="media">
                            <div class="media-body mg-l-15 mg-t-4">
                              <label for="city">Дүүрэг, сум</label>
                              <select name="district" class="form-control" id="district">
                                <?
                                $sql_district =  "SELECT *FROM district";
                                $result_district = mysqli_query($conn,$sql_district);
                                while ($data_district = mysqli_fetch_array($result_district))
                                {
                                  ?>
                                  <option value="<?=$data_district["id"];?>" data-chained="<?=$data_district["city_id"];?>" <?=($data_district["id"]==$data["address_district"])?'SELECTED="SELECTED"':'';?>><?=$data_district["name"];?></option>
                                  <?
                                }
                                ?>
                              </select>
                            </div>
                          </div>

                          <div class="media">
                            <div class="media-body mg-l-15 mg-t-4">
                              <label for="khoroo">Баг, хороо</label>
                              <input type="text" name="khoroo" id="khoroo" value="<?=$data["address_khoroo"];?>" class="form-control">
                            </div>
                          </div>

                          <div class="media">
                            <div class="media-body mg-l-15 mg-t-4">
                              <label for="build">Байр, гудамж</label>
                              <input type="text" name="build" id="build" value="<?=$data["address_build"];?>" class="form-control">
                            </div>
                          </div>
                        
                        </div>
                        
                      </div>
                      <input type="submit" class="btn btn-success btn-lg" value="Засах">
                    </div>
                    <div class="col-lg-6">
                      <div class="card">
                        <div class="card-body">
                          <? if ($data["avatar"]<>"" && file_exists('../'.$data["avatar"]))
                          {
                            ?><img src="../<?=$data["avatar"];?>" style="max-width: 100%;"><?
                          }
                          ?>
                          <div class="media-list">
                            <div class="media">
                              <div class="media-body mg-l-15 mg-t-2">
                                <label for="image">Цээж зураг</label>
                                <input type="file" id="image" name="image" class="form-control">
                              </div>
                            </div>
                            
                            <div class="media">
                              <div class="media-body mg-l-15 mg-t-2">
                                <label for="username">Нэвтрэх нэр (*)</label>
                                <input type="text" name="username"  id="username" value="<?=$data["username"];?>" class="form-control" required="required">
                              </div>
                            </div>
                            <div class="media">
                              <div class="media-body mg-l-15 mg-t-2">
                                <label for="password">Нууц үг (*)</label>
                                <input type="password" name="password" id="password" value="<?=$data["password"];?>" class="form-control" required="required">
                              </div>
                            </div>

                            <div class="media">
                              <div class="media-body mg-l-15 mg-t-2">
                                <label for="category">Ангилал</label>
                                <select class="form-control" name="category" id="category">
                                  <option value="0" <?=($data["category"]==0)?'SELECTED="SELECTED"':'';?>>Ангилалгүй</option>
                                  <?
                                  $sql_cat = "SELECT *FROM customer_category ORDER BY dd";
                                  $result_cat= mysqli_query($conn,$sql_cat);
                                  while ($data_cat = mysqli_fetch_array($result_cat))
                                  {
                                    ?>
                                    <option value="<?=$data_cat["id"];?>" <?=($data_cat["id"]==$data["category"])?'SELECTED="SELECTED"':'';?>><?=$data_cat["name"];?></option>
                                    <?
                                  }
                                  ?>
                                </select>
                                
                              </div>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                  </div> 
              
                <?
              }
              ?>
            </form>
            <div class="btn-group mt-3">
              <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modaldemo"><i class="icon ion-ios-trash"></i> Устгах</a>
              <a href="customers" class="btn btn-primary btn-xs"><i class="icon ion-ios-list"></i> Харилцагч</a>
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
                    <a href="customers?action=delete&id=<?=$id;?>" class="btn btn-danger">Тийм устгах</a>
                    <button type="button" class="btn btn-success pd-x-25" data-dismiss="modal" aria-label="Close">Үгүй, үлдээе</button>
                  </div><!-- modal-body -->
                </div><!-- modal-content -->
              </div><!-- modal-dialog -->
            </div><!-- modal -->
            
            <?
          }
          ?>


          <?
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
                      <?
                      if (isset($_POST["id"])) $id=$_POST["id"]; else header("location:customers");
                      $sql = "SELECT *FROM customer WHERE customer_id='$id' LIMIT 1";
                      $result= mysqli_query($conn,$sql);
                      if (mysqli_num_rows($result)==1)
                      {
                        $error = 0;
                        $error_msg = "";
                        $rd = $_POST["rd"];
                        $surname = $_POST["surname"];
                        $name = $_POST["name"];
                        $tel = $_POST["tel"];
                        $email = $_POST["email"];
                        $username = $_POST["username"];
                        $password = $_POST["password"];
                        $category = $_POST["category"];

                        $address = $_POST["address"];
                        $address_extra = $_POST["address_extra"];
                        $city = $_POST["city"];
                        $district = $_POST["district"];
                        $khoroo = $_POST["khoroo"];
                        $build = $_POST["build"];
                        if (!isset($_POST["no_proxy"])) $no_proxy=1; else $no_proxy=0;


                        

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
                                    $sql = "UPDATE customer SET avatar='$image',thumb='$thumb' WHERE customer_id=$id";
                                    if (!mysqli_query($conn,$sql))
                                    {
                                       $error++; $error_msg="Зураг хуулахад алдаа гарлаа.";
                                    }
                                }
                        }
                        $data = mysqli_fetch_array($result);


                        if ($data["username"]!=$username && $username!="") 
                        {
                          $sql = "SELECT username FROM customer WHERE username = '$username'";
                          $result_check = mysqli_query($conn,$sql);
                          if (mysqli_num_rows($result_check)>0)
                            {
                              $error++; $error_msg="Нэвтрэх нэр давхцалтай байна.";
                            }
                          else
                            {
                               if (!mysqli_query($conn,"UPDATE customer SET username='$username' WHERE customer_id='$id' LIMIT 1")) 
                                { 
                                  $error++; $error_msg="Нэвтрэх нэр оруулахад алдаа гарлаа.";
                                }

                            }
                        }

                        if ($data["tel"]!=$tel && $tel!="") 
                        {
                          $sql = "SELECT tel FROM customer WHERE tel = '$tel' LIMIT 1";
                          $result_check = mysqli_query($conn,$sql);
                          if (mysqli_num_rows($result_check)>0)
                            {
                              $error++; $error_msg="Утасны дугаар давхцалтай байна.";
                            }
                          else
                            {
                               if (!mysqli_query($conn,"UPDATE customer SET tel='$tel' WHERE  customer_id='$id' LIMIT 1")) 
                                { 
                                  $error++; $error_msg="Утасны дугаар оруулахад алдаа гарлаа.";
                                }
                            }
                        }

                        if ($data["name"]!=$name && $name!="") 
                          if (!mysqli_query($conn,"UPDATE customer SET name='$name' WHERE  customer_id='$id' LIMIT 1")) 
                            { 
                                  $error++; $error_msg="Нэр оруулахад алдаа гарлаа.";
                            }

                        if ($data["surname"]!=$surname && $surname!="") 
                          if (!mysqli_query($conn,"UPDATE customer SET surname='$surname' WHERE  customer_id='$id' LIMIT 1")) 
                            { 
                                  $error++; $error_msg="Овог оруулахад алдаа гарлаа.";
                            }
                        
                         if ($data["email"]!=$email) 
                          if (!mysqli_query($conn,"UPDATE customer SET email='$email' WHERE  customer_id='$id' LIMIT 1")) 
                            { 
                                  $error++; $error_msg="Имэйл засахад алдаа гарлаа.";
                            }


                         if ($data["password"]!=$password && $password!="") 
                          if (!mysqli_query($conn,"UPDATE customer SET password='$password' WHERE customer_id='$id' LIMIT 1")) 
                            { 
                              $error++; $error_msg="Нууц үг солиход алдаа гарлаа.";
                            }

                          if (!mysqli_query($conn,"UPDATE customer SET address='$address',address_extra='$address_extra',address_city='$city',address_district='$district',address_khoroo='$khoroo',address_build='$build' WHERE customer_id='$id' LIMIT 1")) 
                            { 
                              $error++; $error_msg="Хаяг солиход алдаа гарлаа.";
                            }

                          if (!mysqli_query($conn,"UPDATE customer SET no_proxy='$no_proxy' WHERE customer_id='$id' LIMIT 1")) 
                            { 
                              $error++; $error_msg="Proxy авдаг эсэхийг солиход алдаа гарлаа.";
                            }
                            
                          if ($data["category"]<>$category) 
                            if (!mysqli_query($conn,"UPDATE customer SET category='$category' WHERE customer_id='$id' LIMIT 1")) 
                              { 
                                $error++; $error_msg="Ангилал солиход алдаа гарлаа.";
                              }
                          

                        if ($error==0) 
                          {
                            mysqli_query ($conn,"UPDATE customer SET modified='".date("Y-m-d")."' WHERE customer_id='$id' LIMIT 1");
                            mysqli_query ($conn,"UPDATE customer_category SET count=count-1 WHERE id='".$data["category"]."' LIMIT 1");
                            mysqli_query ($conn,"UPDATE customer_category SET count=count+1 WHERE id='$category' LIMIT 1");                            
                            
                            ?>
                            <div class="alert alert-success mg-b-10" role="alert">
                              Амжилттай шинэчиллээ.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <?
                          }
                          else 
                          {
                            ?>
                            <div class="alert alert-danger mg-b-10" role="alert">
                              <?=$error;?> алдаа гарлаа. <?=$error_msg;?>
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <?
                          }


                        ?>                            
                        <div class="btn-group">
                          <a href="customers?action=edit&id=<?=$data["customer_id"];?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
                          <a href="customers" class="btn btn-primary"><i class="icon ion-ios-list"></i> Харилцагч</a>
                        </div>
                        <?
                      }
                      ?>
                  </div>
                </div>
              </div><!-- col-12 -->
            </div>
            <?
          }
          ?>


          
          <?
          if ($action =="proxy_clear")
          {
            ?>
            <div class="row row-xs mg-t-10">
              <div class="col-lg-12 mg-t-10 order-lg-2">
                <div class="card">
                  <div class="card-body">
                      <?
                      if (isset($_GET["id"])) $id=$_GET["id"]; else header("location:customers");
                      $sql = "UPDATE proxies SET status=0 WHERE customer_id='$id'";
                    
                        if (mysqli_query($conn,$sql)) 
                          {
                            ?>
                            <div class="alert alert-success mg-b-10" role="alert">
                              <?=mysqli_affected_rows($conn);?> proxy-г амжилттай чөлөөллөө.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
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
                            </div>
                            <?
                          }


                        ?>                            
                        <div class="btn-group">
                          <a href="customers?action=detail&id=<?=$id;?>" class="btn btn-success"> Дэлгэрэнгүй</a>
                          <a href="customers" class="btn btn-primary"> Харилцагч</a>
                        </div>
                       
                  </div>
                </div>
              </div><!-- col-12 -->
            </div>
            <?
          }
          ?>


          <?
          if ($action =="delete")
          {
            if (isset($_GET["id"])) $id=$_GET["id"]; else header("location:customers");

            ?>
            <div class="row row-xs mg-t-10">
              <div class="col-lg-12 mg-t-10 order-lg-2">
                <div class="card">
                  <div class="card-header">
                    <h6 class="slim-card-title">Бүртгэл устах</label>
                  </div><!-- card-header -->
                  <div class="card-body">
                      <?
                      $sql = "SELECT *FROM customer WHERE customer_id='$id' LIMIT 1";
                      $result= mysqli_query($conn,$sql);
                      if (mysqli_num_rows($result)==1)
                      {
                            $sql = "SELECT *FROM orders WHERE receiver='$id'";
                            $result = mysqli_query($conn,$sql);
                            if (mysqli_num_rows($result)==0)
                            {
                              mysqli_query($conn,"DELETE FROM customer WHERE  customer_id='$id' LIMIT 1");
                              ?>
                              <div class="alert alert-success mg-b-10" role="alert">
                                Амжилттай устгагдлаа.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <?
                            }
                          else 
                          {
                            ?>
                            <div class="alert alert-danger mg-b-10" role="alert">
                              Ачаатай хэрэглэгч устгах боломжгүй
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <?
                          }
                      }
                      else
                      {
                        ?>
                        <div class="alert alert-danger mg-b-10" role="alert">
                          Хэрэглэгч олдсонгүй
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <?
                      }
                      ?>
                        <div class="btn-group">
                          <a href="customers" class="btn btn-primary"><i class="icon ion-ios-list"></i> Харилцагч</a>
                        </div>

                  </div>
                </div>
              </div><!-- col-12 -->
            </div>
            <?
          }
          ?>

        <!-------------------------------------------------------------------->
        <!-------------------------------------------------------------------->
        <!-------------------           CATEGORY           ------------------->
        <!-------------------------------------------------------------------->
        <!-------------------------------------------------------------------->



        <?
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
                          <?
                          $sql = "SELECT *FROM customer_category ORDER BY dd,name";
                          $result = mysqli_query($conn,$sql);
                          if (mysqli_num_rows($result)>0)
                          {
                            while ($data = mysqli_fetch_array($result))
                            {

                              ?>
                              <tr>
                                <td><?=$count++;?></td>
                                <td><a href="customers?action=category_edit&id=<?=$data["id"];?>"><?=$data["name"];?></a></td>
                                <td><a href="customers?action=categorize&category=<?=$data["id"];?>"><?=$data["count"];?></a></td>
                                <td>
                                  <div class="btn-group">
                                    <a href="customers?action=category_edit&id=<?=$data["id"];?>" title="Засах"><i data-feather="edit"></i></a>

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
                </div>
              </div>
            </div>
            <a href="customers?action=category_new" class="btn btn-success mg-t-10"><i class="icon ion-ios-plus"></i> Ангилал нэмэх</a>
            <?
          }
          ?>

          <?
          if ($action =="category_new")
          {
            ?>
            <div class="card">
              <div class="card-body">
                <form action="customers?action=category_adding" method="post" enctype="multipart/form-data">
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
            <?
          }
          ?>

         <?
          if ($action =="category_adding")
          {
            ?>
            <div class="card">
              <div class="card-body">
                        <?
                          $name = $_POST["name"];

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
                              </div>
                              <?
                            }


                          ?>                            
                          <div class="btn-group">
                            <a href="customers?action=edit&id=<?=$category_id;?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
                            <a href="customers?action=category" class="btn btn-primary"><i data-feather="list"></i> Бүх ангилал</a>
                          </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <?
          }
          ?>


          <?
          if ($action =="category_edit")
          {
            ?>
            <div class="card">
              <div class="card-body">
                <form action="customers?action=category_editing" method="post" enctype="multipart/form-data">
                  <?
                  if (isset($_GET["id"])) $category_id=$_GET["id"]; else header("location:customers");
                  $sql = "SELECT *FROM customer_category WHERE id=$category_id LIMIT 1";
                  $result= mysqli_query($conn,$sql);
                  if (mysqli_num_rows($result)==1)
                  {
                    $data = mysqli_fetch_array($result);
                    ?>
                    <input type="hidden" name="id" value="<?=$data["id"];?>">
                    <div class="media-list">
                      <div class="media">
                        <div class="media-body">
                          <label for="name">Нэр (*)</label>
                          <input type="text" name="name" id="name" value="<?=$data["name"];?>" class="form-control" required="required">
                        </div>
                      </div>
                    </div>
                    <input type="submit" class="btn btn-success btn-lg mg-t-10" value="Засах">
                    <?
                  }
                  ?>
                </form>
              </div>
            </div>

            <div class="btn-group mg-t-10">
              <a href="customers?action=cateogory_delete&id=<?=$category_id;?>" class="btn btn-danger btn-xs"><i class="icon ion-ios-trash"></i> Устгах</a>
              <a href="customers?action=category" class="btn btn-primary btn-xs"><i data-feather="list"></i> Бүх ангилал</a>
            </div>
            <?
          }
          ?>


          <?
          if ($action =="category_editing")
          {
            ?>
              <div class="card">
                <div class="card-body">                
                        <?
                        if (isset($_POST["id"])) $category_id=$_POST["id"]; else header("location:customers");
                        $name = $_POST["name"];
                        $sql = "UPDATE customer_category SET name='$name' WHERE id=$category_id LIMIT 1";
                       
                          if (mysqli_query($conn,$sql)) 
                            {
                              ?>
                              <div class="alert alert-success mg-b-10" role="alert">
                                Амжилттай шинэчиллээ.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
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
                              </div>
                              <?
                            }


                          ?>                            
                          
                    </div>
                  </div>
             
            <div class="btn-group mg-t-10">
              <a href="customers?action=category_edit&id=<?=$category_id;?>" class="btn btn-success"><i data-feather="edit"></i> Засах</a>
              <a href="customers?action=category" class="btn btn-primary btn-xs"><i data-feather="list"></i> Бүх ангилал</a>
            </div>
            <?
          }
          ?>


          <?
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
                      <?
                      if (isset($_GET["id"])) $category_id=$_GET["id"]; else header("location:customers");
                      $sql = "SELECT *FROM customer_category WHERE id=$category_id LIMIT 1";
                      $result= mysqli_query($conn,$sql);
                      if (mysqli_num_rows($result)==1)
                      {
                        // ORDEr ShALGAH ShAARDLAGATAI

                      
                        if (mysqli_query($conn,"DELETE FRom customer_category WHERE id=$category_id")) 
                          {
                            ?>
                            <div class="alert alert-success mg-b-10" role="alert">
                              Устгагдлаа.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
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
                            </div>
                            <?
                          }
                      }
                      ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="btn-group mg-t-10">
              <a href="customers?action=category" class="btn btn-primary btn-xs"><i data-feather="list"></i> Бүх ангилал</a>
            </div>
            <?
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