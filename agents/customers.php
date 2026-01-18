<?php require_once("config.php");?>
<?php require_once("views/helper.php");?>
<?php require_once("views/login_check.php");?>
<?php require_once("views/init.php");?>
  <body>
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
      <div class="layout-container">
        <?php require_once("views/header.php");?>

        <?php if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="search";?>

        <div class="layout-page">          
          <div class="content-wrapper">
            <?php require_once("views/topmenu.php");?>

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row g-6">              
                    <?php 
                if ($action =="search")
                {
                    if(isset($_POST["search"])) $search = $_POST["search"]; else $search="";
                    ?>
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Харилцагч хайх</h6>
                            <form action="?action=search" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" id="search" autocomplete="off" placeholder="Утас, нэр, нэвтрэх нэр, ииэйл, регистрийн дугаараар хайх" value="<?=$search;?>" name="search" minlength="3"> 
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Хайх</button>
                            </form>
                        </div>
                        </div>
                    </div>
                    </div>
                    <?php 
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
                    <?php 
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
                                                    <a href="?action=detail&id=<?=$data["customer_id"];?>" class="btn btn-primary btn-sm" title="Харах"><i class="ti ti-edit ti-xs align-middle"></i></a>
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
                        
                    <?php 
                    }
                    
                }
                ?>


                    <?php 
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
                    <?php 
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
                    <?php 
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

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="media-list ">
                    <?php 
                                    if ($data["avatar"]<>"" && file_exists('../'.$data["avatar"]))
                                    {
                                        ?>
                                        <div class="media">
                                        <img src="../<?=$data["avatar"];?>" style="max-width:100%">
                                        </div>
                    <?php 
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
                    <?php 
                            if ($data["no_proxy"]==0)
                            {
                            $count=1;
                            ?>
                            <div class="card mt-3 mb-3">
                                <div class="card-body">
                                <h5 class="card-title">
                                    Proxy 
                                </h5>
                                    <table class="table table-responsive table-striped">
                                    <thead>
                                        <tr>
                                        <th>№</th>
                                        <th>Нэр / Овог</th>
                                        <th>Утас</th>
                                        <th>Хаяг</th>
                                        <th>Ашигласан</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                    <?php 
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
                                        </tr>
                    <?php 
                                        }
                                        }
                                        ?>
                                    </tbody>
                                    </table>
                                
                                
                                </div>
                            </div>
                    <?php 
                            }          
                            ?>
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                            <div class="card-body">
                            <h5 class="card-title">
                                Идэвхитэй ачаа
                                </h5>
                    <?php $count=1;?>
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
                    <?php 
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
                                            <td><?php echo $count++;?></td>
                                            <td class="text-wrap"><?php echo htmlspecialchars($data_order["barcode"] ?? '');?><br><?php echo htmlspecialchars($data_order["third_party"] ?? '');?></td>
                                            
                                            <td class="text-wrap">
                    <?php echo htmlspecialchars($package1_name ?? '');?> (<?php echo htmlspecialchars($package1_num ?? '');?>) - <?php echo htmlspecialchars($package1_price ?? '');?> $<br>
                    <?php if (isset($package2_name) && $package2_name!="")
                                            {
                                            ?>
                    <?php echo htmlspecialchars($package2_name ?? '');?> (<?php echo htmlspecialchars($package2_num ?? '');?>) - <?php echo htmlspecialchars($package2_price ?? '');?> $<br>
                    <?php 
                                            }

                                            if (isset($package3_name) && $package3_name!="")
                                            {
                                            ?>
                    <?php echo htmlspecialchars($package3_name ?? '');?> (<?php echo htmlspecialchars($package3_num ?? '');?>) - <?php echo htmlspecialchars($package3_price ?? '');?> $
                    <?php 
                                            }
                                            if (isset($package4_name) && $package4_name!="")
                                            {
                                            ?>
                    <?php echo htmlspecialchars($package4_name ?? '');?> (<?php echo htmlspecialchars($package4_num ?? '');?>) - <?php echo htmlspecialchars($package4_price ?? '');?> $
                    <?php 
                                            }
                                            ?>
                                            </td>
                                            <td class="text-wrap"><?=substr($data_order["timestamp"],0,10);?></td>
                                            <td class="text-wrap"><?=$data_order["status"];?></td>
                                            <td>
                                            <div class="btn-group">
                                                <a href="orders?action=detail&proxy=<?=$data_order["order_id"];?>" title="Засах"><i class="ti ti-edit"></i></a>
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
                        
                    <?php 
                    }
                    else header("location:customer");
                }
                ?>

                  
              </div>
            </div>

                    <?php require_once("views/footer.php");?>

            <div class="content-backdrop fade"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="layout-overlay layout-menu-toggle"></div>
    <div class="drag-target"></div>
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/libs/hammer/hammer.js"></script>
    <script src="assets/vendor/libs/i18n/i18n.js"></script>
    <script src="assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="assets/vendor/js/menu.js"></script>
    <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="assets/vendor/libs/swiper/swiper.js"></script>
    <script src="assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="assets/js/main.js"></script>

    <link href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.bootstrap5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>

    <script>
        $('#report_table').DataTable({
            layout: {
            topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print','pageLength'],                
                }         
            }
        });
    </script>

    
  </body>
</html>
