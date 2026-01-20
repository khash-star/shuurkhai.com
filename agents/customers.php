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
                            <a href="?action=register" class="btn btn-success mr-2">Шинэ хэрэглэгч бүртгэх</a>
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
                                        $city_name = '';
                                        if (!empty($data["address_city"])) {
                                            $sql_city =  "SELECT *FROM city WHERE id='".intval($data["address_city"])."'";
                                            $result_city = mysqli_query($conn,$sql_city);
                                            if ($result_city && mysqli_num_rows($result_city) > 0) {
                                                $data_city = mysqli_fetch_array($result_city);
                                                $city_name = isset($data_city["name"]) ? $data_city["name"] : '';
                                            }
                                        }
                                        ?>
                                        <a href="#" class="d-block"><?=$city_name ? $city_name : '-';?></a>
                                        </div>
                                    </div>

                                    <div class="media">
                                        <div class="media-body mg-l-15 mg-t-4">
                                        <label>Дүүрэг, сум</label>
                    <?php 
                                        $district_name = '';
                                        if (!empty($data["address_district"])) {
                                            $sql_district =  "SELECT *FROM district WHERE id='".intval($data["address_district"])."'";
                                            $result_district = mysqli_query($conn,$sql_district);
                                            if ($result_district && mysqli_num_rows($result_district) > 0) {
                                                $data_district = mysqli_fetch_array($result_district);
                                                $district_name = isset($data_district["name"]) ? $data_district["name"] : '';
                                            }
                                        }
                                        ?>
                                        <a href="#" class="d-block"><?=$district_name ? $district_name : '-';?></a>
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


                <?php 
                if ($action =="register")
                {
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
                                    <?php
                                    $sql_city =  "SELECT * FROM city";
                                    $result_city = mysqli_query($conn,$sql_city);
                                    while ($data_city = mysqli_fetch_array($result_city))
                                    {
                                      ?>
                                      <option value="<?php echo $data_city["id"];?>"><?php echo $data_city["name"];?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                                </div>
                              </div>

                              <div class="media">
                                <div class="media-body mg-l-15 mg-t-4">
                                  <label for="district">Дүүрэг, сум</label>
                                  <select name="district" class="form-control" id="district">
                                    <?php
                                    $sql_district =  "SELECT * FROM district";
                                    $result_district = mysqli_query($conn,$sql_district);
                                    while ($data_district = mysqli_fetch_array($result_district))
                                    {
                                      ?>
                                      <option value="<?php echo $data_district["id"];?>" data-chained="<?php echo $data_district["city_id"];?>"><?php echo $data_district["name"];?></option>
                                      <?php
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
                                      <?php
                                      $sql_cat = "SELECT * FROM customer_category ORDER BY dd";
                                      $result_cat= mysqli_query($conn,$sql_cat);
                                      while ($data_cat = mysqli_fetch_array($result_cat))
                                      {
                                        ?>
                                        <option value="<?php echo $data_cat["id"];?>"><?php echo $data_cat["name"];?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                    
                                  </div>
                                </div>
                              </div>
                              
                            </div>
                          </div>
                        </div> 
                      </div>
                    </form>
                    <?php
                }
                ?>


                <?php
                if ($action =="registering")
                {
                    ?>
                    <div class="row row-xs mg-t-10">
                      <div class="col-lg-12 order-lg-2">
                          <div class="card">
                            <div class="card-header">
                              <h6 class="slim-card-title">Бүртгэл</h6>
                            </div>
                            <div class="card-body">
                                <?php
                                  $error = 0;
                                  $error_msg = "";
                                  $rd = protect($_POST["rd"]);
                                  $surname = protect($_POST["surname"]);
                                  $name = protect($_POST["name"]);
                                  $tel = protect($_POST["tel"]);
                                  $email = protect($_POST["email"]);
                                  $username = protect($_POST["username"]);
                                  $password = protect($_POST["password"]);
                                  $category = intval($_POST["category"]);

                                  $address = protect($_POST["address"]);
                                  $address_extra = protect($_POST["address_extra"]);
                                  $city = intval($_POST["city"]);
                                  $district = intval($_POST["district"]);
                                  $khoroo = protect($_POST["khoroo"]);
                                  $build = protect($_POST["build"]);
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
                                      if ($category > 0) {
                                          mysqli_query ($conn,"UPDATE customer_category SET count=count+1 WHERE id='".$category."' LIMIT 1");
                                      }
                                      ?>
                                      <div class="alert alert-success mg-b-10" role="alert">
                                        Амжилттай бүртгэлээ.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="btn-group">
                                        <a href="customers?action=detail&id=<?php echo $customer_id;?>" class="btn btn-success"><i data-feather="edit"></i> Дэлгэрэнгүй</a>
                                        <a href="customers?action=search" class="btn btn-primary"><i class="icon ion-ios-list"></i> Хэрэглэгч хайх</a>
                                      </div>
                                      <?php
                                    }
                                    else 
                                    {
                                      ?>
                                      <div class="alert alert-danger mg-b-10" role="alert">
                                       алдаа гарлаа. <?php echo mysqli_error($conn);?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="btn-group">
                                        <a href="customers?action=register" class="btn btn-success"><i data-feather="edit"></i> Ахин оролдох</a>
                                      </div>
                                      <?php
                                    }


                                  ?>                            
                                  
                                  

                            </div>
                          </div>
                      </div>
                    </div>
                    <?php
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
