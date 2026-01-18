<?php require_once("login_check.php");?>
<?php require_once("config.php");?>
<?php require_once("helper.php");?>
<?php require_once("init.php");?>
    <link href="lib/datatables/css/jquery.dataTables.css" rel="stylesheet">

  <body>
    <?php require_once("header.php");?>

    <div class="slim-mainpanel">
      <div class="container">
        <div class="slim-pageheader">
          <ol class="breadcrumb slim-breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Хэрэглэгч</li>
            <li class="breadcrumb-item active" aria-current="page">Баталгаажаагүй хэрэглэгч</li>
          </ol>
          <h6 class="slim-pagetitle">Баталгаажаагүй хэрэглэгчид</h6>
        </div><!-- slim-pageheader -->


        <?php require_once("top_numbers.php");?>

        <!------------------------------------------------------------------------------------->
        
          <!--label class="section-title">Basic Responsive DataTable</label>
          <p class="mg-b-20 mg-sm-b-40">Searching, ordering and paging goodness will be immediately added to the table, as shown in this example.</p-->
          <?  if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="display";?>





          <?
          if ($action =="display")
          {
            ?>
            <div class="section-wrapper mg-t-10">
              <div class="table-wrapper">
                <table id="datatable1" class="table display responsive nowrap">
                  <thead>
                    <tr>
                      <th class="wd-20p">Нэр</th>
                      <th class="wd-20p">Утас</th>
                      <th class="wd-20p">И-мэйл</th>
                      <th class="wd-20p">Санхүү</th>
                      <th class="wd-20p">Зэрэглэл</th>
                      <th class="wd-20p">Нэвтрэх нэр</th>
                      <th class="wd-20p">Нэвтэрсэн</th>
                      <th class="wd-10p">Үйлдэл</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?
                    $sql = "SELECT * FROM user ORDER BY lastlogin DESC";
                    $result = mysqli_query($conn,$sql);
                    if (mysqli_num_rows($result)>0)
                    {
                      while ($data = mysqli_fetch_array($result))
                      {

                        ?>
                        <tr>
                          <td><?=$data["orgname"];?></td>
                          <td><?=$data["orgcontact"];?></td>
                          <td><?=$data["orgemail"];?></td>
                          <td><?=$data["finnumber"];?></td>
                          <td><?=$data["rank"];?></td>
                          <td><?=$data["username"];?></td>
                          <td><?=$data["lastlogin"];?></td>
                          <td class="tx-18">
                            <div class="btn-group">
                              <a href="user.php?action=detail&id=<?=$data["id"];?>" class="btn btn-success btn-sm" title="Харах"><i class="icon ion-ios-person"></i></a>
                              <a href="user.php?action=edit&id=<?=$data["id"];?>"  class="btn btn-warning btn-sm" title="Засах"><i class="icon ion-edit"></i></a>
                              <a href="sell_report_personal.php?id=<?=$data["id"];?>"  class="btn btn-primary btn-sm" title="Худалдан авалтын тайлан"><i class="icon ion-ios-list"></i></a>

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
            <?
          }
          ?>

          <?
          if ($action =="detail")
          {
            ?>
            <div class="row row-xs mg-t-10">
              <div class="col-md-6 col-lg-3 order-lg-1">
                <? require_once("left_new_order.php");?>
              </div><!-- col-3 -->
              <div class="col-md-6 col-lg-3 mg-md-t-0 order-lg-3">
                 <? require_once("right_new_feedback.php");?>
              </div><!-- col-3 -->

              <div class="col-lg-6 mg-t-10 order-lg-2">
                <div class="card card-customer-overview">
                  <div class="card-header">
                    <h6 class="slim-card-title">Бүртгэлийн дэлгэрэнгүй</h6>
                  </div><!-- card-header -->
                  <div class="card-body">
                      <?
                      if (isset($_GET["id"])) $user_id=$_GET["id"]; else header("location:user.php");
                      $sql = "SELECT * FROM user WHERE id=$user_id LIMIT 1";
                      $result= mysqli_query($conn,$sql);
                      if (mysqli_num_rows($result)==1)
                      {
                        $data = mysqli_fetch_array($result);
                        ?>
                        <div class="media-list mg-t-25">
                          <div class="media">
                            <div><i class="icon ion-ios-person tx-24 lh-0"></i></div>
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">Нэр</h6>
                              <a href="" class="d-block"><?=$data["orgname"];?></a>
                            </div><!-- media-body -->
                          </div><!-- media -->
                          <div class="media mg-t-25">
                            <div><i class="icon ion-ios-telephone-outline tx-24 lh-0"></i></div>
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">Утасны дугаар</h6>
                              <span class="d-block"><?=$data["orgcontact"];?></span>
                            </div><!-- media-body -->
                          </div><!-- media -->
                          <div class="media mg-t-25">
                            <div><i class="icon ion-ios-orgemail-outline tx-24 lh-0"></i></div>
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">И-мэйл</h6>
                              <span class="d-block"><?=$data["orgemail"];?></span>
                            </div><!-- media-body -->
                          </div><!-- media -->
                          <div class="media mg-t-25">
                            <div><i class="icon ion-ios-person tx-18 lh-0"></i></div>
                            <div class="media-body mg-l-15 mg-t-2">
                              <h6 class="tx-14 tx-gray-700">Нэвтрэх нэр</h6>
                              <a href="#" class="d-block"><?=$data["username"];?></a>
                            </div><!-- media-body -->
                          </div><!-- media -->
                          <div class="media mg-t-25">
                            <div><i class="icon ion-android-lock tx-18 lh-0"></i></div>
                            <div class="media-body mg-l-15 mg-t-2">
                              <h6 class="tx-14 tx-gray-700">Нууц үг</h6>
                              <a href="#" class="d-block"><?=$data["password"];?></a>
                            </div><!-- media-body -->
                          </div><!-- media -->

                          <div class="media mg-t-25">
                            <div><i class="icon ion-ios-person tx-18 lh-0"></i></div>
                            <div class="media-body mg-l-15 mg-t-2">
                              <h6 class="tx-14 tx-gray-700">Санхүүгийн бүртгэл</h6>
                              <a href="#" class="d-block"><?=$data["finnumber"];?></a>
                            </div><!-- media-body -->
                          </div><!-- media -->
                          <div class="media mg-t-25">
                            <div><i class="icon ion-android-lock tx-18 lh-0"></i></div>
                            <div class="media-body mg-l-15 mg-t-2">
                              <h6 class="tx-14 tx-gray-700">Үнийн зэрэглэл</h6>
                              <a href="#" class="d-block"><?=$data["rank"];?></a>
                            </div><!-- media-body -->
                          </div><!-- media -->



                          <div class="media mg-t-25">
                            <div><i class="icon ion-calendar tx-18 lh-0"></i></div>
                            <div class="media-body mg-l-15 mg-t-2">
                              <h6 class="tx-14 tx-gray-700">Огноо</h6>
                              Бүртгүүлсэн <a href="#" class="d-block"><?=$data["registered"];?></a>
                              Сүүлд нэвтэрсэн <a href="#" class="d-block"><?=$data["lastlogin"];?></a>
                            </div><!-- media-body -->
                          </div><!-- media -->
                        </div><!-- media-list -->
                        <div class="btn-group">
                          <a href="user.php?action=edit&id=<?=$data["id"];?>" class="btn btn-success"><i class="icon ion-edit"></i> Засах</a>
                          <a href="sell_report_personal.php?id=<?=$data["id"];?>"  class="btn btn-warning" title="Худалдан авалтын тайлан"><i class="icon ion-ios-list"></i> Тайлан</a>
                          <a href="user.php" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бусад хэрэглэгчид</a>
                        </div>
                        <?
                      }
                      ?>
                  </div><!-- card-body -->
                </div><!-- card -->
              </div><!-- col-6 -->
            </div><!-- row -->
            <?
          }
          ?>



          <?php
          if ($action =="edit")
          {
            ?>
            <div class="row row-xs">
              <div class="col-md-6 col-lg-3 order-lg-1">
                <?php require_once("left_new_order.php");?>
              </div><!-- col-3 -->
              <div class="col-md-6 col-lg-3 mg-md-t-0 order-lg-3">
                 <?php require_once("right_new_feedback.php");?>
              </div><!-- col-3 -->
              <div class="col-lg-6 order-lg-2 mg-t-10">
                <form action="user.php?action=editing" method="post" enctype="multipart/form-data">
                  <div class="card card-customer-overview">
                    <div class="card-header">
                      <h6 class="slim-card-title">Бүртгэлийг засах</h6>
                    </div><!-- card-header -->
                    <div class="card-body">
                        <?php
                        if (isset($_GET["id"])) {
                            $user_id = intval($_GET["id"]);
                        } else {
                            header("location:user.php");
                            exit;
                        }
                        $sql = "SELECT * FROM user WHERE id=$user_id LIMIT 1";
                        $result = mysqli_query($conn,$sql);
                        if ($result && mysqli_num_rows($result) == 1)
                        {
                          $data = mysqli_fetch_array($result);
                          if ($data) {
                          ?>
                          <input type="hidden" name="id" value="<?php echo htmlspecialchars($data["id"] ?? '');?>">
                          <div class="media-list mg-t-25">
                            <div class="media">
                              <div><i class="icon ion-ios-person tx-24 lh-0"></i></div>
                              <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">Нэр (*)</h6>
                                <input type="text" name="orgname" value="<?php echo htmlspecialchars($data["orgname"] ?? '');?>" class="form-control" required="required">
                              </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media mg-t-25">
                              <div><i class="icon ion-ios-telephone-outline tx-24 lh-0"></i></div>
                              <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">Утасны дугаар (*)</h6>
                                <input type="text" name="orgcontact" value="<?php echo htmlspecialchars($data["orgcontact"] ?? '');?>" class="form-control" required="required">
                              </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media mg-t-25">
                              <div><i class="icon ion-ios-orgemail-outline tx-24 lh-0"></i></div>
                              <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">И-мэйл</h6>
                                <input type="text" name="orgemail" value="<?php echo htmlspecialchars($data["orgemail"] ?? '');?>" class="form-control">
                              </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media mg-t-25">
                              <div><i class="icon ion-ios-person tx-18 lh-0"></i></div>
                              <div class="media-body mg-l-15 mg-t-2">
                                <h6 class="tx-14 tx-gray-700">Нэвтрэх нэр (*)</h6>
                                <input type="text" name="username" value="<?php echo htmlspecialchars($data["username"] ?? '');?>" class="form-control" required="required">
                              </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media mg-t-25">
                              <div><i class="icon ion-android-lock tx-18 lh-0"></i></div>
                              <div class="media-body mg-l-15 mg-t-2">
                                <h6 class="tx-14 tx-gray-700">Нууц үг (*)</h6>
                                <input type="text" name="password" value="<?php echo htmlspecialchars($data["password"] ?? '');?>" class="form-control" required="required">
                              </div><!-- media-body -->
                            </div><!-- media -->

                            <div class="media mg-t-25">
                              <div><i class="icon ion-ios-person tx-18 lh-0"></i></div>
                              <div class="media-body mg-l-15 mg-t-2">
                                <h6 class="tx-14 tx-gray-700">Санхүүгийн бүртгэл (*)</h6>
                                <input type="text" name="finnumber" value="<?php echo htmlspecialchars($data["finnumber"] ?? '');?>" class="form-control" required="required">
                              </div><!-- media-body -->
                            </div><!-- media -->

                            <div class="media mg-t-25">
                              <div><i class="icon ion-ios-person tx-18 lh-0"></i></div>
                              <div class="media-body mg-l-15 mg-t-2">
                                <h6 class="tx-14 tx-gray-700">Үнийн зэрэглэл (*)</h6>
                                <select name="rank" class="form-control">
                                  <option value="G1" <?php echo (isset($data["rank"]) && $data["rank"]=="G1")?'SELECTED="SELECTED"':'';?>>G1</option>
                                  <option value="G2" <?php echo (isset($data["rank"]) && $data["rank"]=="G2")?'SELECTED="SELECTED"':'';?>>G2</option>
                                  <option value="G3" <?php echo (isset($data["rank"]) && $data["rank"]=="G3")?'SELECTED="SELECTED"':'';?>>G3</option>
                                  <option value="G4" <?php echo (isset($data["rank"]) && $data["rank"]=="G4")?'SELECTED="SELECTED"':'';?>>G4</option>
                                  <option value="G5" <?php echo (isset($data["rank"]) && $data["rank"]=="G5")?'SELECTED="SELECTED"':'';?>>G5</option>
                                  <option value="G6" <?php echo (isset($data["rank"]) && $data["rank"]=="G6")?'SELECTED="SELECTED"':'';?>>G6</option>
                                  <option value="G7" <?php echo (isset($data["rank"]) && $data["rank"]=="G7")?'SELECTED="SELECTED"':'';?>>G7</option>
                                  <option value="G8" <?php echo (isset($data["rank"]) && $data["rank"]=="G8")?'SELECTED="SELECTED"':'';?>>G8</option>
                                  <option value="G9" <?php echo (isset($data["rank"]) && $data["rank"]=="G9")?'SELECTED="SELECTED"':'';?>>G9</option>
                                  <option value="G10" <?php echo (isset($data["rank"]) && $data["rank"]=="G10")?'SELECTED="SELECTED"':'';?>>G10</option>
                                </select>
                              </div><!-- media-body -->
                            </div><!-- media -->

                          </div><!-- media-list -->
                            <input type="submit" class="btn btn-success btn-lg" value="Засах">
                            
                          <div class="clearfix"></div><br>
                          <div class="clearfix"></div><br>

                          <div class="btn-group">
                            <a href="user.php?action=delete&id=<?php echo htmlspecialchars($user_id);?>" class="btn btn-danger btn-sm"><i class="icon ion-ios-trash"></i> Устгах</a>
                            <a href="sell_report_personal.php?id=<?php echo htmlspecialchars($data["id"] ?? '');?>"  class="btn btn-warning btn-sm" title="Худалдан авалтын тайлан"><i class="icon ion-ios-list"></i> Тайлан</a>

                            <a href="user.php" class="btn btn-primary btn-sm"><i class="icon ion-ios-list"></i> Бусад хэрэглэгчид</a>
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
              <div class="col-md-6 col-lg-3 order-lg-1">
                <?php require_once("left_new_order.php");?>
              </div><!-- col-3 -->
              <div class="col-md-6 col-lg-3 mg-md-t-0 order-lg-3">
                 <?php require_once("right_new_feedback.php");?>
              </div><!-- col-3 -->

              <div class="col-lg-6 mg-t-10 order-lg-2">
                <form action="user.php?action=editing" method="post" enctype="multipart/form-data">
                  <div class="card card-customer-overview">
                    <div class="card-header">
                      <h6 class="slim-card-title">Бүртгэлийг засах</h6>
                    </div><!-- card-header -->
                    <div class="card-body">
                        <?php
                        if (isset($_POST["id"])) {
                            $user_id = intval($_POST["id"]);
                        } else {
                            header("location:user.php");
                            exit;
                        }
                        $sql = "SELECT * FROM user WHERE id=$user_id LIMIT 1";
                        $result = mysqli_query($conn,$sql);
                        if ($result && mysqli_num_rows($result) == 1)
                        {
                          $error = 0;
                          $error_msg = "";
                          $orgname = isset($_POST["orgname"]) ? protect($_POST["orgname"]) : '';
                          $orgcontact = isset($_POST["orgcontact"]) ? protect($_POST["orgcontact"]) : '';
                          $orgemail = isset($_POST["orgemail"]) ? protect($_POST["orgemail"]) : '';
                          $username = isset($_POST["username"]) ? protect($_POST["username"]) : '';
                          $password = isset($_POST["password"]) ? protect($_POST["password"]) : '';
                          $finnumber = isset($_POST["finnumber"]) ? protect($_POST["finnumber"]) : '';
                          $rank = isset($_POST["rank"]) ? protect($_POST["rank"]) : '';
                          $data = mysqli_fetch_array($result);
                          if (!$data) {
                              $error++;
                              $error_msg = "Хэрэглэгч олдсонгүй.";
                          } else {
                              if (isset($data["username"]) && $data["username"]!=$username && $username!="") 
                              {
                                $username_escaped = mysqli_real_escape_string($conn, $username);
                                $sql = "SELECT username FROM user WHERE username = '$username_escaped'";
                                $result_check = mysqli_query($conn,$sql);
                                if ($result_check && mysqli_num_rows($result_check) > 0)
                                  {
                                    $error++; $error_msg="Нэвтрэх нэр давхцалтай байна.";
                                  }
                                else
                                  {
                                     $username_escaped2 = mysqli_real_escape_string($conn, $username);
                                     if (!mysqli_query($conn,"UPDATE user SET username='$username_escaped2' WHERE id=$user_id LIMIT 1")) 
                                      { 
                                        $error++; $error_msg="Нэвтрэх нэр оруулахад алдаа гарлаа.";
                                      }

                                  }
                              }

                              if (isset($data["orgcontact"]) && $data["orgcontact"]!=$orgcontact && $orgcontact!="") 
                              {
                                $orgcontact_escaped = mysqli_real_escape_string($conn, $orgcontact);
                                $sql = "SELECT orgcontact FROM user WHERE orgcontact = '$orgcontact_escaped' LIMIT 1";
                                $result_check = mysqli_query($conn,$sql);
                                if ($result_check && mysqli_num_rows($result_check) > 0)
                                  {
                                    $error++; $error_msg="Утасны дугаар давхцалтай байна.";
                                  }
                                else
                                  {
                                     $orgcontact_escaped2 = mysqli_real_escape_string($conn, $orgcontact);
                                     if (!mysqli_query($conn,"UPDATE user SET orgcontact='$orgcontact_escaped2' WHERE id=$user_id LIMIT 1")) 
                                      { 
                                        $error++; $error_msg="Утасны дугаар оруулахад алдаа гарлаа.";
                                      }
                                  }
                              }

                              if (isset($data["finnumber"]) && $data["finnumber"]!=$finnumber && $finnumber!="") 
                              {
                                $finnumber_escaped = mysqli_real_escape_string($conn, $finnumber);
                                $sql = "SELECT finnumber FROM user WHERE finnumber = '$finnumber_escaped' LIMIT 1";
                                $result_check = mysqli_query($conn,$sql);
                                if ($result_check && mysqli_num_rows($result_check) > 0)
                                  {
                                    $error++; $error_msg="Санхүүгийн бүртгэл давхцалтай байна.";
                                  }
                                else
                                  {
                                     $finnumber_escaped2 = mysqli_real_escape_string($conn, $finnumber);
                                     if (!mysqli_query($conn,"UPDATE user SET finnumber='$finnumber_escaped2' WHERE  id=$user_id LIMIT 1")) 
                                      { 
                                        $error++; $error_msg="Санхүүгийн бүртгэл оруулахад алдаа гарлаа.";
                                      }
                                  }
                              }


                              if (isset($data["orgname"]) && $data["orgname"]!=$orgname && $orgname!="") {
                                  $orgname_escaped = mysqli_real_escape_string($conn, $orgname);
                                  if (!mysqli_query($conn,"UPDATE user SET orgname='$orgname_escaped' WHERE id=$user_id LIMIT 1")) 
                                    { 
                                          $error++; $error_msg="Нэр оруулахад алдаа гарлаа.";
                                    }
                              }

                              if (isset($data["orgemail"]) && $data["orgemail"]!=$orgemail && $orgemail!="") {
                                  $orgemail_escaped = mysqli_real_escape_string($conn, $orgemail);
                                  if (!mysqli_query($conn,"UPDATE user SET orgemail='$orgemail_escaped' WHERE id=$user_id LIMIT 1")) 
                                    { 
                                      $error++; $error_msg="И-мэйл оруулахад алдаа гарлаа.";
                                    }
                              }

                              if (isset($data["rank"]) && $data["rank"]!=$rank && $rank!="") {
                                  $rank_escaped = mysqli_real_escape_string($conn, $rank);
                                  if (!mysqli_query($conn,"UPDATE user SET rank='$rank_escaped' WHERE id=$user_id LIMIT 1")) 
                                    { 
                                      $error++; $error_msg="Үнийн зэрэглэл оруулахад алдаа гарлаа.";
                                    }
                              }

                               if (isset($data["password"]) && $data["password"]!=$password && $password!="") {
                                  $password_escaped = mysqli_real_escape_string($conn, $password);
                                  if (!mysqli_query($conn,"UPDATE user SET password='$password_escaped' WHERE id=$user_id LIMIT 1")) 
                                    { 
                                          $error++; $error_msg="Нууц үг солиход алдаа гарлаа.";
                                    }
                              }
                          }

                          if ($error==0) 
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
                                <?php echo htmlspecialchars($error);?> алдаа гарлаа. <?php echo htmlspecialchars($error_msg);?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div><!-- alert --> 
                              <?php
                            }


                          ?>                            
                          <div class="btn-group">
                            <a href="user.php?action=edit&id=<?php echo htmlspecialchars($data["id"] ?? $user_id);?>" class="btn btn-success"><i class="icon ion-edit"></i> Засах</a>
                            <a href="sell_report_personal.php?id=<?php echo htmlspecialchars($data["id"] ?? $user_id);?>"  class="btn btn-warning btn-sm" title="Худалдан авалтын тайлан"><i class="icon ion-ios-list"></i> Тайлан</a>

                            <a href="user.php" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бусад хэрэглэгчид</a>
                          </div>
                          <?php
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
          if ($action =="delete")
          {
            ?>
            <div class="row row-xs mg-t-10">
              <div class="col-md-6 col-lg-3 order-lg-1">
                <?php require_once("left_new_order.php");?>
              </div><!-- col-3 -->
              <div class="col-md-6 col-lg-3 mg-md-t-0 order-lg-3">
                 <?php require_once("right_new_feedback.php");?>
              </div><!-- col-3 -->
              <div class="col-lg-6 mg-t-10 order-lg-2">
                <div class="card card-customer-overview">
                  <div class="card-header">
                    <h6 class="slim-card-title">Бүртгэл устгах</h6>
                  </div><!-- card-header -->
                  <div class="card-body">
                      <?php
                      if (isset($_GET["id"])) {
                          $user_id = intval($_GET["id"]);
                      } else {
                          header("location:user.php");
                          exit;
                      }
                      $sql = "SELECT * FROM user WHERE id=$user_id LIMIT 1";
                      $result = mysqli_query($conn,$sql);
                      if ($result && mysqli_num_rows($result) == 1)
                      {
                        // ORDEr ShALGAH ShAARDLAGATAI

                      
                        if (mysqli_query($conn,"DELETE FROM user WHERE id=$user_id")) 
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
                          <a href="user.php" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бусад хэрэглэгчид</a>
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







          
        












        <!------------------------------------------------------------------------------------->

      </div><!-- container -->
    </div><!-- slim-mainpanel -->

    <?php require_once("footer.php");?>

    <script src="lib/jquery/js/jquery.js"></script>
    <script src="lib/popper.js/js/popper.js"></script>
    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script src="lib/jquery.cookie/js/jquery.cookie.js"></script>
    <script src="lib/datatables/js/jquery.dataTables.js"></script>

    <script>
      $(function(){
        'use strict';

        $('#datatable1').DataTable({
          pageLength: 100,
          lengthMenu: [100, 250, 500, { label: 'Бүгд', value: -1 }],
          responsive: true,
          language: {
            searchPlaceholder: 'Хайх...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
          }
        });
      });
    </script>

   
  </body>
</html>
