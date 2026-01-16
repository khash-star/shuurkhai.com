<? require_once("login_check.php");?>
<? require_once("config.php");?>
<? require_once("helper.php");?>
<? require_once("init.php");?>
    <link href="lib/datatables/css/jquery.dataTables.css" rel="stylesheet">

  <body>
    <? require_once("header.php");?>

    <div class="slim-mainpanel">
      <div class="container">
        <div class="slim-pageheader">
          <ol class="breadcrumb slim-breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Хэрэглэгч</li>
            <li class="breadcrumb-item active" aria-current="page">Баталгаажаагүй хэрэглэгч</li>
          </ol>
          <h6 class="slim-pagetitle">Баталгаажаагүй хэрэглэгчид</h6>
        </div><!-- slim-pageheader -->


        <? require_once("top_numbers.php");?>

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
                    $sql = "SELECT *FROM user ORDER BY lastlogin DESC";
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
                      $sql = "SELECT *FROM user WHERE id=$user_id LIMIT 1";
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



          <?
          if ($action =="edit")
          {
            ?>
            <div class="row row-xs">
              <div class="col-md-6 col-lg-3 order-lg-1">
                <? require_once("left_new_order.php");?>
              </div><!-- col-3 -->
              <div class="col-md-6 col-lg-3 mg-md-t-0 order-lg-3">
                 <? require_once("right_new_feedback.php");?>
              </div><!-- col-3 -->
              <div class="col-lg-6 order-lg-2 mg-t-10">
                <form action="user.php?action=editing" method="post" enctype="multipart/form-data">
                  <div class="card card-customer-overview">
                    <div class="card-header">
                      <h6 class="slim-card-title">Бүртгэлийг засах</h6>
                    </div><!-- card-header -->
                    <div class="card-body">
                        <?
                        if (isset($_GET["id"])) $user_id=$_GET["id"]; else header("location:user.php");
                        $sql = "SELECT *FROM user WHERE id=$user_id LIMIT 1";
                        $result= mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)==1)
                        {
                          $data = mysqli_fetch_array($result);
                          ?>
                          <input type="hidden" name="id" value="<?=$data["id"];?>">
                          <div class="media-list mg-t-25">
                            <div class="media">
                              <div><i class="icon ion-ios-person tx-24 lh-0"></i></div>
                              <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">Нэр (*)</h6>
                                <input type="text" name="orgname" value="<?=$data["orgname"];?>" class="form-control" required="required">
                              </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media mg-t-25">
                              <div><i class="icon ion-ios-telephone-outline tx-24 lh-0"></i></div>
                              <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">Утасны дугаар (*)</h6>
                                <input type="text" name="orgcontact" value="<?=$data["orgcontact"];?>" class="form-control" required="required">
                              </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media mg-t-25">
                              <div><i class="icon ion-ios-orgemail-outline tx-24 lh-0"></i></div>
                              <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">И-мэйл</h6>
                                <input type="text" name="orgemail" value="<?=$data["orgemail"];?>" class="form-control">
                              </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media mg-t-25">
                              <div><i class="icon ion-ios-person tx-18 lh-0"></i></div>
                              <div class="media-body mg-l-15 mg-t-2">
                                <h6 class="tx-14 tx-gray-700">Нэвтрэх нэр (*)</h6>
                                <input type="text" name="username" value="<?=$data["username"];?>" class="form-control" required="required">
                              </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media mg-t-25">
                              <div><i class="icon ion-android-lock tx-18 lh-0"></i></div>
                              <div class="media-body mg-l-15 mg-t-2">
                                <h6 class="tx-14 tx-gray-700">Нууц үг (*)</h6>
                                <input type="text" name="password" value="<?=$data["password"];?>" class="form-control" required="required">
                              </div><!-- media-body -->
                            </div><!-- media -->

                            <div class="media mg-t-25">
                              <div><i class="icon ion-ios-person tx-18 lh-0"></i></div>
                              <div class="media-body mg-l-15 mg-t-2">
                                <h6 class="tx-14 tx-gray-700">Санхүүгийн бүртгэл (*)</h6>
                                <input type="text" name="username" value="<?=$data["username"];?>" class="form-control" required="required">
                              </div><!-- media-body -->
                            </div><!-- media -->

                            <div class="media mg-t-25">
                              <div><i class="icon ion-ios-person tx-18 lh-0"></i></div>
                              <div class="media-body mg-l-15 mg-t-2">
                                <h6 class="tx-14 tx-gray-700">Үнийн зэрэглэл (*)</h6>
                                <select name="rank" class="form-control">
                                  <option value="G1" <?=($data["rank"]=="G1")?'SELECTED="SELECTED"':'';?>>G1</option>
                                  <option value="G2" <?=($data["rank"]=="G2")?'SELECTED="SELECTED"':'';?>>G2</option>
                                  <option value="G3" <?=($data["rank"]=="G3")?'SELECTED="SELECTED"':'';?>>G3</option>
                                  <option value="G4" <?=($data["rank"]=="G4")?'SELECTED="SELECTED"':'';?>>G4</option>
                                  <option value="G5" <?=($data["rank"]=="G5")?'SELECTED="SELECTED"':'';?>>G5</option>
                                  <option value="G6" <?=($data["rank"]=="G6")?'SELECTED="SELECTED"':'';?>>G6</option>
                                  <option value="G7" <?=($data["rank"]=="G7")?'SELECTED="SELECTED"':'';?>>G7</option>
                                  <option value="G8" <?=($data["rank"]=="G8")?'SELECTED="SELECTED"':'';?>>G8</option>
                                  <option value="G9" <?=($data["rank"]=="G9")?'SELECTED="SELECTED"':'';?>>G9</option>
                                  <option value="G10" <?=($data["rank"]=="G10")?'SELECTED="SELECTED"':'';?>>G10</option>
                                </select>
                              </div><!-- media-body -->
                            </div><!-- media -->

                          </div><!-- media-list -->
                            <input type="submit" class="btn btn-success btn-lg" value="Засах">
                            
                          <div class="clearfix"></div><br>
                          <div class="clearfix"></div><br>

                          <div class="btn-group">
                            <a href="user.php?action=delete&id=<?=$user_id;?>" class="btn btn-danger btn-sm"><i class="icon ion-ios-trash"></i> Устгах</a>
                            <a href="sell_report_personal.php?id=<?=$data["id"];?>"  class="btn btn-warning btn-sm" title="Худалдан авалтын тайлан"><i class="icon ion-ios-list"></i> Тайлан</a>

                            <a href="user.php" class="btn btn-primary btn-sm"><i class="icon ion-ios-list"></i> Бусад хэрэглэгчид</a>
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
              <div class="col-md-6 col-lg-3 order-lg-1">
                <? require_once("left_new_order.php");?>
              </div><!-- col-3 -->
              <div class="col-md-6 col-lg-3 mg-md-t-0 order-lg-3">
                 <? require_once("right_new_feedback.php");?>
              </div><!-- col-3 -->

              <div class="col-lg-6 mg-t-10 order-lg-2">
                <form action="user.php?action=editing" method="post" enctype="multipart/form-data">
                  <div class="card card-customer-overview">
                    <div class="card-header">
                      <h6 class="slim-card-title">Бүртгэлийг засах</h6>
                    </div><!-- card-header -->
                    <div class="card-body">
                        <?
                        if (isset($_POST["id"])) $user_id=$_POST["id"]; else header("location:user.php");
                        $sql = "SELECT *FROM user WHERE id=$user_id LIMIT 1";
                        $result= mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)==1)
                        {
                          $error = 0;
                          $error_msg = "";
                          $orgname = $_POST["orgname"];
                          $orgcontact = $_POST["orgcontact"];
                          $orgemail = $_POST["orgemail"];
                          $username = $_POST["username"];
                          $password = $_POST["password"];
                          $finnumber = $_POST["finnumber"];
                          $rank = $_POST["rank"];
                          $data = mysqli_fetch_array($result);

                          if ($data["username"]!=$username && $username!="") 
                          {
                            $sql = "SELECT username FROM user WHERE username = '$username'";
                            $result_check = mysqli_query($conn,$sql);
                            if (mysqli_num_rows($result_check)>0)
                              {
                                $error++; $error_msg="Нэвтрэх нэр давхцалтай байна.";
                              }
                            else
                              {
                                 if (!mysqli_query($conn,"UPDATE user SET username='$username' WHERE id=$user_id LIMIT 1")) 
                                  { 
                                    $error++; $error_msg="Нэвтрэх нэр оруулахад алдаа гарлаа.";
                                  }

                              }
                          }

                          if ($data["orgcontact"]!=$orgcontact && $orgcontact!="") 
                          {
                            $sql = "SELECT orgcontact FROM user WHERE orgcontact = '$orgcontact' LIMIT 1";
                            $result_check = mysqli_query($conn,$sql);
                            if (mysqli_num_rows($result_check)>0)
                              {
                                $error++; $error_msg="Утасны дугаар давхцалтай байна.";
                              }
                            else
                              {
                                 if (!mysqli_query($conn,"UPDATE user SET orgcontact='$orgcontact' WHERE id=$user_id LIMIT 1")) 
                                  { 
                                    $error++; $error_msg="Утасны дугаар оруулахад алдаа гарлаа.";
                                  }
                              }
                          }

                          if ($data["finnumber"]!=$finnumber && $finnumber!="") 
                          {
                            $sql = "SELECT finnumber FROM user WHERE finnumber = '$finnumber' LIMIT 1";
                            $result_check = mysqli_query($conn,$sql);
                            if (mysqli_num_rows($result_check)>0)
                              {
                                $error++; $error_msg="Санхүүгийн бүртгэл давхцалтай байна.";
                              }
                            else
                              {
                                 if (!mysqli_query($conn,"UPDATE user SET finnumber='$finnumber' WHERE  id=$user_id LIMIT 1")) 
                                  { 
                                    $error++; $error_msg="Санхүүгийн бүртгэл оруулахад алдаа гарлаа.";
                                  }
                              }
                          }


                          if ($data["orgname"]!=$orgname && $orgname!="") 
                            if (!mysqli_query($conn,"UPDATE user SET orgname='$orgname' WHERE id=$user_id LIMIT 1")) 
                              { 
                                    $error++; $error_msg="Нэр оруулахад алдаа гарлаа.";
                              }

                          if ($data["orgemail"]!=$orgemail && $orgemail="") 
                            if (!mysqli_query($conn,"UPDATE user SET orgemail='$orgemail' WHERE id=$user_id LIMIT 1")) 
                              { 
                                $error++; $error_msg="И-мэйл оруулахад алдаа гарлаа.";
                              }

                          if ($data["rank"]!=$rank && $rank="") 
                            if (!mysqli_query($conn,"UPDATE user SET rank='$rank' WHERE id=$user_id LIMIT 1")) 
                              { 
                                $error++; $error_msg="Үнийн зэрэглэл оруулахад алдаа гарлаа.";
                              }

                           if ($data["password"]!=$password && $password!="") 
                            if (!mysqli_query($conn,"UPDATE user SET password='$password' WHERE id=$user_id LIMIT 1")) 
                              { 
                                    $error++; $error_msg="Нууц үг солиход алдаа гарлаа.";
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
                              </div><!-- alert --> 
                              <?
                            }


                          ?>                            
                          <div class="btn-group">
                            <a href="user.php?action=edit&id=<?=$data["id"];?>" class="btn btn-success"><i class="icon ion-edit"></i> Засах</a>
                            <a href="sell_report_personal.php?id=<?=$data["id"];?>"  class="btn btn-warning btn-sm" title="Худалдан авалтын тайлан"><i class="icon ion-ios-list"></i> Тайлан</a>

                            <a href="user.php" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бусад хэрэглэгчид</a>
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
              <div class="col-lg-6 mg-t-10 order-lg-2">
                <div class="card card-customer-overview">
                  <div class="card-header">
                    <h6 class="slim-card-title">Бүртгэл устгах</h6>
                  </div><!-- card-header -->
                  <div class="card-body">
                      <?
                      if (isset($_GET["id"])) $user_id=$_GET["id"]; else header("location:user.php");
                      $sql = "SELECT *FROM user WHERE id=$user_id LIMIT 1";
                      $result= mysqli_query($conn,$sql);
                      if (mysqli_num_rows($result)==1)
                      {
                        // ORDEr ShALGAH ShAARDLAGATAI

                      
                        if (mysqli_query($conn,"DELETE FRom user WHERE id=$user_id")) 
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







          
        












        <!------------------------------------------------------------------------------------->

      </div><!-- container -->
    </div><!-- slim-mainpanel -->

    <? require_once("footer.php");?>

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
