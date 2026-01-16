<?
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
?>
<?php
  ob_start();
 ini_set('memory_limit','100M');
 ini_set('max_execution_time', 300);  
 ?>
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
            <li class="breadcrumb-item" aria-current="page">Тооцоо</li>
            <li class="breadcrumb-item active" aria-current="page">Төлбөр тооцоо</li>
          </ol>
          <h6 class="slim-pagetitle">Төлбөр тооцоо</h6>
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
                      <th class="wd-10p">№</th>
                      <th class="wd-20p">Бүртгэл</th>
                      <th class="wd-20p">Нэр</th>
                      <th class="wd-20p">Эхний үлдэгдэл</th>
                      <th class="wd-20p">Дебт</th>
                      <th class="wd-20p">Кредит</th>
                      <th class="wd-20p">Эцсийн үлдэгдэл</th>
                      <th class="wd-10p">-</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?
                    $count =1;
                    $sql = "SELECT *FROM balance ORDER BY finnumber";
                    $result = mysqli_query($conn,$sql);
                    if (mysqli_num_rows($result)>0)
                    {
                      while ($data = mysqli_fetch_array($result))
                      {

                        ?>
                        <tr>
                          <td><?=$count++;?></td>
                          <td><?=$data["finnumber"];?></td>
                          <td><?=$data["orgname"];?></td>
                          <td><?=$data["init_balance"];?></td>
                          <td><?=$data["debt"];?></td>
                          <td><?=$data["credit"];?></td>
                          <td><?=$data["balance"];?></td>
                          <td class="tx-18">
                            <div class="btn-group">
                              <a href="balance.php?action=edit&id=<?=$data["id"];?>"  class="btn btn-warning btn-sm" title="Засах"><i class="icon ion-edit"></i></a>
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

              <div class="col-lg-6 order-lg-2">
                <div class="card card-customer-overview">
                  <div class="card-header">
                    <h6 class="slim-card-title">Бүртгэлийн дэлгэрэнгүй</h6>
                  </div><!-- card-header -->
                  <div class="card-body">
                      <?
                      if (isset($_GET["id"])) $balance_id=$_GET["id"]; else header("location:balance.php");
                      $sql = "SELECT *FROM user WHERE id=$balance_id LIMIT 1";
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
                          <a href="balance.php?action=edit&id=<?=$data["id"];?>" class="btn btn-success"><i class="icon ion-edit"></i> Засах</a>
                          <a href="balance.php" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бусад хэрэглэгчид</a>
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
            <div class="row row-xs mg-t-10">
              <div class="col-lg-12 order-lg-2">
                <form action="balance.php?action=editing" method="post" enctype="multipart/form-data">
                  <div class="card card-customer-overview">
                    <div class="card-header">
                      <h6 class="slim-card-title">Тооцоог засах</h6>
                    </div><!-- card-header -->
                    <div class="card-body">
                        <?
                        if (isset($_GET["id"])) $balance_id=$_GET["id"]; else header("location:balance.php");
                        $sql = "SELECT *FROM balance WHERE id=$balance_id LIMIT 1";
                        $result= mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)==1)
                        {
                          $data = mysqli_fetch_array($result);
                          ?>
                          <input type="hidden" name="id" value="<?=$balance_id;?>">
                          <div class="media-list mg-t-25">
                            <div class="media">
                              <div><i class="icon ion-ios-person tx-24 lh-0"></i></div>
                              <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">Бүртгэлийн дугаар</h6>
                                <input type="text" name="finnumber" value="<?=$data["finnumber"];?>" class="form-control" readonly="readonly">
                              </div><!-- media-body -->
                            </div><!-- media -->

                            <div class="media">
                              <div><i class="icon ion-ios-person tx-24 lh-0"></i></div>
                              <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">Нэр</h6>
                                <input type="text" name="orgname" value="<?=$data["orgname"];?>" class="form-control" readonly="readonly">
                              </div><!-- media-body -->
                            </div><!-- media -->

                            <div class="media">
                              <div><i class="icon ion-ios-person tx-24 lh-0"></i></div>
                              <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">Шинэчлэгдсэн</h6>
                                <input type="text" name="orgname" value="<?=$data["date"];?>" class="form-control" readonly="readonly">
                              </div><!-- media-body -->
                            </div><!-- media -->

                            <div class="media mg-t-25">
                              <div><i class="icon ion-social-usd tx-24 lh-0"></i></div>
                              <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">Эхний үлдэгдэл (*)</h6>
                                <input type="text" name="init_balance" value="<?=$data["init_balance"];?>" class="form-control" required="required">
                              </div><!-- media-body -->
                            </div><!-- media -->

                            <div class="media mg-t-25">
                              <div><i class="icon ion-social-usd tx-24 lh-0"></i></div>
                              <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">Дебт (*)</h6>
                                <input type="text" name="debt" value="<?=$data["debt"];?>" class="form-control" required="required">
                              </div><!-- media-body -->
                            </div><!-- media -->


                            <div class="media mg-t-25">
                              <div><i class="icon ion-social-usd tx-24 lh-0"></i></div>
                              <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">Кредит (*)</h6>
                                <input type="text" name="kredit" value="<?=$data["credit"];?>" class="form-control" required="required">
                              </div><!-- media-body -->
                            </div><!-- media -->


                            <div class="media mg-t-25">
                              <div><i class="icon ion-social-usd tx-24 lh-0"></i></div>
                              <div class="media-body mg-l-15 mg-t-4">
                                <h6 class="tx-14 tx-gray-700">Эцсийн үлдэгдэл (*)</h6>
                                <input type="text" name="balance" value="<?=$data["balance"];?>" class="form-control" required="required">
                              </div><!-- media-body -->
                            </div><!-- media -->

                          </div><!-- media-list -->
                            <input type="submit" class="btn btn-success btn-lg" value="Засах">
                            
                          <div class="clearfix"></div><br>
                          <div class="clearfix"></div><br>

                          <div class="btn-group">
                            <a href="balance.php?action=delete&id=<?=$balance_id;?>" class="btn btn-danger btn-sm"><i class="icon ion-ios-trash"></i> Устгах</a>
                            <a href="balance.php" class="btn btn-primary btn-sm"><i class="icon ion-ios-list"></i> Бүх тооцоог харах</a>
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
              <div class="col-lg-12">
                <form action="balance.php?action=editing" method="post" enctype="multipart/form-data">
                  <div class="card card-customer-overview">
                    <div class="card-header">
                      <h6 class="slim-card-title">Төлбөх тооцоог засах</h6>
                    </div><!-- card-header -->
                    <div class="card-body">
                        <?
                        if (isset($_POST["id"])) $balance_id=$_POST["id"]; else header("location:balance.php");

                        $sql = "SELECT *FROM balance WHERE id=$balance_id LIMIT 1";

                        $result= mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)==1)
                        {
                          $orgname = $_POST["orgname"];
                          $finnumber = $_POST["finnumber"];
                          $init_balance = $_POST["init_balance"];
                          $balance = $_POST["balance"];
                          $debt = $_POST["debt"];
                          $kredit = $_POST["kredit"];

                          $sql = "UPDATE balance SET init_balance='$init_balance',balance='$balance',debt='$debt',credit='$kredit',`date`= '".date("Y-m-d")."' WHERE id=$balance_id LIMIT 1";
                          // echo $sql;
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
                          <div class="btn-group">
                            <a href="balance.php?action=edit&id=<?=$balance_id;?>" class="btn btn-success"><i class="icon ion-edit"></i> Засах</a>
                            <a href="balance.php" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бүх тооцоог харах</a>
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
              <div class="col-lg-12">
                <div class="card card-customer-overview">
                  <div class="card-header">
                    <h6 class="slim-card-title">Бүртгэлйиг устгалаа</h6>
                  </div><!-- card-header -->
                  <div class="card-body">
                      <?
                      if (isset($_GET["id"])) $balance_id=$_GET["id"]; else header("location:balance.php");
                      $sql = "SELECT *FROM balance WHERE id=$balance_id LIMIT 1";
                      $result= mysqli_query($conn,$sql);
                      if (mysqli_num_rows($result)==1)
                      {
                        // ORDEr ShALGAH ShAARDLAGATAI

                      
                        if (mysqli_query($conn,"DELETE FRom balance WHERE id=$balance_id")) 
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
                          <a href="balance.php" class="btn btn-primary"><i class="icon ion-ios-list"></i> Бусад төлбөрийг харах</a>
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
          if ($action =="import")
          {
            ?>
            <div class="row row-xs mg-t-10">
              <div class="col-lg-12 order-lg-2">
                <form action="balance.php?action=importing" method="post" enctype="multipart/form-data">
                  <div class="card card-customer-overview">
                    <div class="card-header">
                      <h6 class="slim-card-title">Тооцоог импортлох</h6>
                    </div><!-- card-header -->
                    <div class="card-body">
                        
                          <div class="media-list mg-t-25">
                            <div class="media">
                              <div class="media-body mg-l-15 mg-t-4">                                
                                <div class="custom-file">
                                  <input type="file" name="excel" required="required" class="form-control">
                                </div><!-- custom-file -->
                              </div><!-- media-body -->
                            </div><!-- media -->

                          </div><!-- media-list -->
                            <input type="submit" class="btn btn-success btn-lg mg-t-10" value="Оруулах">
                            
                          <div class="clearfix"></div><br>
                          <div class="clearfix"></div><br>

                          <div class="btn-group">
                            <a href="files/example_balance.xls" class="btn btn-warning btn-sm"> Жишээ файл татах</a>
                            <a href="balance.php" class="btn btn-primary btn-sm"><i class="icon ion-ios-list"></i> Бүх тооцоог харах</a>
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
          if ($action =="importing")
          {
            require_once('lib/excel/PHPExcel/IOFactory.php');?>                             
            <div class="row row-xs mg-t-10">
              <div class="col-lg-12 order-lg-2">
                <div class="card card-customer-overview">
                    <div class="card-header">
                      <h6 class="slim-card-title">Тооцоог импортлох</h6>
                    </div><!-- card-header -->
                    <div class="card-body">
                    <?
                    if(isset($_FILES['excel']))
                      {
                        $excel_balance_first_row = settings('excel_balance_first_row');
                        $folder = date("Ym");
                        if(!file_exists('uploads/'.$folder))
                        mkdir ( 'uploads/'.$folder,0777);
                        $target_dir = 'uploads/'.$folder;
                        $target_file = $target_dir."/"."balance". basename($_FILES["excel"]["name"]);
                        if (file_exists($target_file)) unlink($target_file);
                        if (move_uploaded_file($_FILES['excel']['tmp_name'], $target_file))
                           {
                             $sql = "TRUNCATE TABLE balance";
                             mysqli_query($conn,$sql);
                             echo mysqli_error($conn);
                             $import=$target_file;
                             chmod($import, 0777);
                             $count=0; $succees=0;
                             $objPHPExcel = PHPExcel_IOFactory::load($import);
                             $aSheet =$objPHPExcel->getActiveSheet();
                             $rows = $aSheet->getHighestRow();
                             ?>
                              <table class='table display responsive nowrap'>
                                <thead>
                                  <tr>
                                    <th class="wd-10p">№</th>
                                    <th class="wd-20p">Бүртгэл</th>
                                    <th class="wd-20p">Нэр</th>
                                    <th class="wd-20p">Эхний үлдэгдэл</th>
                                    <th class="wd-20p">Дебт</th>
                                    <th class="wd-20p">Кредит</th>
                                    <th class="wd-20p">Эцсийн үлдэгдэл</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?
                                   for ($i=$excel_balance_first_row; $i<=$rows; $i++)
                                    {
                                      $finnumber = $aSheet->getCell("B".$i)->getValue();
                                      $orgname = $aSheet->getCell("D".$i)->getValue();
                                      $init_balance = $aSheet->getCell("E".$i)->getValue();
                                      $debt = $aSheet->getCell("G".$i)->getValue();
                                      $kredit = $aSheet->getCell("H".$i)->getValue();
                                      $balance = $aSheet->getCell("I".$i)->getValue();

                                      if ($finnumber!="" && $orgname!="") 
                                        {
                                          $count++;
                                         
                                          $sql = "INSERT INTO balance (finnumber,orgname,init_balance,debt,credit,balance,`date`) VALUES
                                          ('$finnumber','$orgname','$init_balance','$debt','$kredit','$balance','".date("Y-m-d")."')";
                                          
                                          if (mysqli_query($conn,$sql)) $succees++; else echo mysqli_error($conn);
                                           ?>
                                          <tr>
                                            <td><?=$count;?></td> 
                                            <td><?=$finnumber;?></td>
                                            <td><?=$orgname;?></td>
                                            <td><?=$init_balance;?></td>
                                            <td><?=$debt;?></td>
                                            <td><?=$kredit;?></td>
                                            <td><?=$balance;?></td>
                                          </tr>
                                          <?
                                          $sql = "UPDATE user SET orgname='$orgname' WHERE finnumber='$finnumber' LIMIT 1";
                                          mysqli_query($conn,$sql);
                                        }
                                      }
                                      ?>
                                  </tbody>
                                </table>
                                <?
                                unlink($import);
                               // $sql = "UPDATE parameters SET value ='".date("Y-m-d")."' WHERE name='price_update'";
                               // mysqli_query($conn,$sql);
                                ?>
                                <div class="alert alert-success mg-b-10" role="alert">
                                  <?=$succees;?>/<?=$count;?> амжилттай.
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div><!-- alert --> 
                                <?
                              }
                           else
                           {
                              // file cannot copied
                              ?>
                              <div class="alert alert-danger mg-b-10" role="alert">
                                Эксел файлахад алдаа гарлаа.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div><!-- alert --> 
                              <?
                           }
                      }
                      else 
                      {
                        // empty
                        ?>
                        <div class="alert alert-danger mg-b-10" role="alert">
                          Файлаа зааж өгнө үү.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div><!-- alert --> 
                        <?
                      }
                    ?>
                    <div class="btn-group">
                      <a href="files/example_balance.xls" class="btn btn-warning btn-sm"> Жишээ файл татах</a>
                      <a href="balance.php" class="btn btn-primary btn-sm"><i class="icon ion-ios-list"></i> Бүх тооцоог харах</a>
                    </div>
                  </div><!-- card-body -->
                </div><!-- card -->
              </div><!-- col-12 -->
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
