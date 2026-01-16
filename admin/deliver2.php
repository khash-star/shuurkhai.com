<?
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
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
            <li class="breadcrumb-item active" aria-current="page">Олголт</li>
          </ol>
          <h6 class="slim-pagetitle">Олголт</h6>
        </div><!-- slim-pageheader -->


        <!------------------------------------------------------------------------------------->
        
          <!--label class="section-title">Basic Responsive DataTable</label>
          <p class="mg-b-20 mg-sm-b-40">Searching, ordering and paging goodness will be immediately added to the table, as shown in this example.</p-->
          <?  if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="init";?>


          
          <?
          if ($action =="init")
          {
            ?>
             <div class="row mg-t-10">
              <div class="col-lg-12">
                <div class="card card-customer-overview">
                  <div class="card-header">
                    <h6 class="slim-card-title">Гардуулалт хийх баркод</h6>
                  </div><!-- card-header -->
                  <div class="card-body">
                    <div class="alert alert-warning">Энэ хэсэг түр ажиллахгүй. Баркод уншигчаа авахаар ажиллуулъя</div>
                     <form action="deliver2.php?action=create_search" method="post"  enctype="multipart/form-data">
                        <div class="media-list mg-t-25">
                          <div class="media">
                            <div><i class="icon ion-ios-person tx-24 lh-0"></i></div>
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">Баркод</h6>
                              <textarea name="search" value="" class="form-control" required="required" placeholder="Нэг мөрөнд нэг баркод оруулна"></textarea>
                              <input type="submit" class="btn btn-success mg-t-10" value="Хайх">
                            </div><!-- media-body -->
                          </div><!-- media -->
                        </div>
                      </form>
                    </div>
                  </div><!-- card-body -->
              </div><!-- col-6 -->
            </div><!-- row -->
            <?
          }
          ?>

          <?
          if ($action =="create_search")
          {
            $barcode=$_POST["search"];
            $barcode_array = explode("\r\n",$barcode);
            foreach ($barcode_array as $barcode_single)
            $search = $_POST["search"];
            $sql = "SELECT *FROM customers WHERE barcode='$search'";
            $result= mysqli_query ($conn,$sql);
            if (mysqli_num_rows($result)==1)
            {
              $data = mysqli_fetch_array($result);
              header("location:deliver2.php?action=select&customer=".$data["id"]);
            }
            else 
            {
              header("location:deliver2.php?action=init&msg=not_found");
            }
          }
          ?>

          <?
          if ($action =="select")
          {
            if (isset($_GET["customer"])) $customer_id=protect($_GET["customer"]); else header("location:deliver2.php");
            ?>
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <?
                  $sql = "SELECT *FROM customers WHERE id='$customer_id' LIMIT 1";
                  $result = mysqli_query($conn,$sql);
                  if (mysqli_num_rows($result)==1)
                    {
                      $data = mysqli_fetch_array($result);
                      ?>
                      <div class="col-lg-2 col-xs-12">
                          <img src="../<?=$data["avatar"];?>" style="max-width: 100%; clear:both;">
                          <div class="media-list mg-t-25">
                          <div class="media">
                            <div><i class="icon ion-ios-person tx-24 lh-0"></i></div>
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">РД</h6>
                              <input type="text" name="rd" value="<?=$data["rd"];?>" class="form-control" readonly="readonly">
                            </div><!-- media-body -->
                          </div><!-- media -->
                          
                          <div class="media">
                            <div><i class="icon ion-ios-person tx-24 lh-0"></i></div>
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">Нэр</h6>
                              <input type="text" name="name" value="<?=$data["name"];?>" class="form-control" readonly="readonly">
                            </div><!-- media-body -->
                          </div><!-- media -->
                          <div class="media mg-t-25">
                            <div><i class="icon ion-ios-telephone-outline tx-24 lh-0"></i></div>
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">Утасны дугаар (*)</h6>
                              <input type="text" name="contact" value="<?=$data["contact"];?>" class="form-control" readonly="readonly">
                            </div><!-- media-body -->
                          </div><!-- media -->
                           <div class="media mg-t-25">
                            <div><i class="icon ion-ios-telephone-outline tx-24 lh-0"></i></div>
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">Утасны дугаар 2</h6>
                              <input type="text" name="contact2" value="<?=$data["contact2"];?>" class="form-control" readonly="readonly">
                            </div><!-- media-body -->
                          </div>
                          <div class="media mg-t-25">
                            <div><i class="icon ion-ios-email-outline tx-24 lh-0"></i></div>
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">Хаяг</h6>
                              <input type="text" name="address" value="<?=$data["address"];?>" class="form-control" readonly="readonly">
                            </div><!-- media-body -->
                          </div><!-- media -->

                          </div><!-- media-list -->
                      </div>
                      <div class="col-10 col-xs-12">
                         <?
                          $sql = "SELECT * FROM orders WHERE receiver=$customer_id AND status NOT IN ('weight_missing','delivered')";
                          $result = mysqli_query($conn,$sql);
                          if (mysqli_num_rows($result)>0)
                          {
                            ?>
                            <div class="table-wrapper">
                              <form action="deliver2.php?action=delivering" method="post">
                                <input type="hidden" name="customer_id" value="<?=$customer_id;?>">
                                <input type="hidden" name="cargo_rate" value="<?=settings("cargo_rate");?>">
                                <input type="hidden" name="dollar_rate" value="<?=settings("dollar_rate");?>">
                                <table id="datatable1" class="table display responsive nowrap">
                                  <thead>
                                    <tr>
                                      <th class="wd-5p">№</th>
                                      <th class="wd-5p"><input type="checkbox" name="select_all" id="select_all" alt=0></th>
                                      <th class="wd-20p">Баркод</th>
                                      <th class="wd-20p">Track</th>
                                      <th class="wd-20p">Бараа</th>
                                      <th class="wd-20p">Төлөв</th>
                                      <th class="wd-10p">Жин</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?
                                      $count=1;
                                      while ($data = mysqli_fetch_array($result))
                                      {
                                        $order_id = $data["order_id"];
                                        $barcode = $data["barcode"];
                                        $created_date = $data["created_date"];
                                        $weight_date = $data["weight_date"];
                                        $onair_date = $data["onair_date"];
                                        $warehouse_date = $data["warehouse_date"];
                                        $kargo_date = $data["kargo_date"];
                                        $delivered_date = $data["delivered_date"];
                                        $package = $data["package"];
                                        $weight = $data["weight"];
                                        $price = $data["price"];
                                        $receiver = $data["receiver"];
                                        //$sender = $data["sender"];
                                        $proxy_id = $data["proxy_id"];
                                        $proxy_type = $data["proxy_type"];
                                        $timestamp=$data["timestamp"];
                                        $timestamp = gmt(settings("gmt"),$timestamp);
                                        $advance = $data["advance"];
                                        $advance_value = $data["advance_value"];
                                        $third_party=$data["third_party"];
                                        $extra=$data["extra"];
                                        $method=$data["method"];
                                        $print=$data["print"];
                                        $boxed=$data["boxed"];
                                        $agents=$data["agents"];
                                        $owner=$data["owner"];
                                        $is_online=$data["is_online"];
                                        $customer_hide=$data["customer_hide"];
                                        $transport=$data["transport"];
                                        $status=$data["status"];
                                        $status_text=order_status($status);

                                        $package_array=explode("##",$package);
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
                                        $customer_data = customer($receiver);
                                         
                                        ?>
                                        <tr>
                                          <td><?=$count++;?></td>
                                          <td><input type="checkbox" name="orders[]" value="<?=$order_id;?>" alt="<?=$weight;?>"></td>
                                          <td><?=$third_party;?><br>
                                          <span class="tx-10 tx-danger"><?=$barcode;?></span></td>
                                          <td><?=substr($created_date,0,10);?></td>
                                          <td>
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
                                          ?>
                                        </td>
                                            

                                          <td><?=$status_text;?></td>
                                          <td><?=$weight;?></td>
                                        </tr>
                                        <?
                                    }
                                    ?>
                                  </tbody>
                                </table>
                                <div class="clearfix">
                                  <table class="table">
                                    <tr>
                                      <td>Нийт ачаа</td><td  width="100"><span id="total_count" class="tx-danger">0</span></td>
                                    </tr>
                                    <tr>
                                      <td>Нийт жин</td><td><span id="total_weight" class="tx-danger">0</span></td>
                                    </tr>
                                    <tr>
                                      <td>Нийт төлбөр /$/</td><td><span id="total_price_usd" class="tx-danger">0</span></td>
                                    </tr>
                                    <tr>
                                      <td>Нийт төлбөр /₮/</td><td><span id="total_price_mnt" class="tx-danger">0</span></td>
                                    </tr>
                                  </table>
                                </div>
                                <input type="submit" class="btn btn-success" value="Гардуулах">
                              </form>
                            </div><!-- table-wrapper -->
                            <?
                          }
                          ?>
                         
                      </div>
                      <?
                    }
                    else header("location:deliver2.php");
                    ?>
                </div>
              </div>
            </div>
            <? 
          }
          ?>

          <?
          if ($action =="delivering")
          {
            if (isset($_POST["customer_id"])) $customer_id=protect($_POST["customer_id"]); else header("location:deliver2.php");
            ?>
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <?
                  $sql = "SELECT *FROM customers WHERE id='$customer_id' LIMIT 1";
                  $result = mysqli_query($conn,$sql);
                  if (mysqli_num_rows($result)==1)
                    {
                      $data = mysqli_fetch_array($result);
                      ?>
                      <div class="col-lg-2 col-xs-12">
                          <img src="../<?=$data["avatar"];?>" style="max-width: 100%; clear:both;">
                          <div class="media-list mg-t-25">
                          <div class="media">
                            <div><i class="icon ion-ios-person tx-24 lh-0"></i></div>
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">РД</h6>
                              <input type="text" name="rd" value="<?=$data["rd"];?>" class="form-control" readonly="readonly">
                            </div><!-- media-body -->
                          </div><!-- media -->
                          
                          <div class="media">
                            <div><i class="icon ion-ios-person tx-24 lh-0"></i></div>
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">Нэр</h6>
                              <input type="text" name="name" value="<?=$data["name"];?>" class="form-control" readonly="readonly">
                            </div><!-- media-body -->
                          </div><!-- media -->
                          <div class="media mg-t-25">
                            <div><i class="icon ion-ios-telephone-outline tx-24 lh-0"></i></div>
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">Утасны дугаар (*)</h6>
                              <input type="text" name="contact" value="<?=$data["contact"];?>" class="form-control" readonly="readonly">
                            </div><!-- media-body -->
                          </div><!-- media -->
                           <div class="media mg-t-25">
                            <div><i class="icon ion-ios-telephone-outline tx-24 lh-0"></i></div>
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">Утасны дугаар 2</h6>
                              <input type="text" name="contact2" value="<?=$data["contact2"];?>" class="form-control" readonly="readonly">
                            </div><!-- media-body -->
                          </div>
                          <div class="media mg-t-25">
                            <div><i class="icon ion-ios-email-outline tx-24 lh-0"></i></div>
                            <div class="media-body mg-l-15 mg-t-4">
                              <h6 class="tx-14 tx-gray-700">Хаяг</h6>
                              <input type="text" name="address" value="<?=$data["address"];?>" class="form-control" readonly="readonly">
                            </div><!-- media-body -->
                          </div><!-- media -->

                          </div><!-- media-list -->
                      </div>
                      <div class="col-10 col-xs-12">
                         <?
                         //echo $_POST["orders"];
                         if (!empty($_POST["orders"]))
                         {

                           $sql = "SELECT * FROM orders WHERE receiver=$customer_id AND order_id IN (".implode($_POST["orders"],",").")";
                            $result = mysqli_query($conn,$sql);
                            if (mysqli_num_rows($result)>0)
                            {
                              ?>
                              <div class="table-wrapper">
                                <!--form action="deliver2.php?action=delivering" method="post"-->
                                  <!--input type="hidden" name="customer_id" value="<?=$customer_id;?>"-->
                                  <table id="datatable1" class="table display responsive nowrap">
                                    <thead>
                                      <tr>
                                        <th class="wd-5p">№</th>
                                        <th class="wd-20p">Баркод</th>
                                        <th class="wd-20p">Track</th>
                                        <th class="wd-20p">Бараа</th>
                                        <th class="wd-20p">Төлөв</th>
                                        <th class="wd-10p">Жин</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?
                                        $count=0;
                                        $total_weight=0;
                                        $barcodes=array();
                                        while ($data = mysqli_fetch_array($result))
                                        {
                                          $count++;
                                          $order_id = $data["order_id"];
                                          $barcode = $data["barcode"];
                                          $created_date = $data["created_date"];
                                          $weight_date = $data["weight_date"];
                                          $onair_date = $data["onair_date"];
                                          $warehouse_date = $data["warehouse_date"];
                                          $kargo_date = $data["kargo_date"];
                                          $delivered_date = $data["delivered_date"];
                                          $package = $data["package"];
                                          $weight = $data["weight"];
                                          $price = $data["price"];
                                          $receiver = $data["receiver"];
                                          //$sender = $data["sender"];
                                          $proxy_id = $data["proxy_id"];
                                          $proxy_type = $data["proxy_type"];
                                          $timestamp=$data["timestamp"];
                                          $timestamp = gmt(settings("gmt"),$timestamp);
                                          $advance = $data["advance"];
                                          $advance_value = $data["advance_value"];
                                          $third_party=$data["third_party"];
                                          $extra=$data["extra"];
                                          $method=$data["method"];
                                          $print=$data["print"];
                                          $boxed=$data["boxed"];
                                          $agents=$data["agents"];
                                          $owner=$data["owner"];
                                          $is_online=$data["is_online"];
                                          $customer_hide=$data["customer_hide"];
                                          $transport=$data["transport"];
                                          $status=$data["status"];
                                          $status_text=order_status($status);

                                          $package_array=explode("##",$package);
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
                                          $customer_data = customer($receiver);
                                           
                                          ?>
                                          <tr>
                                            <td><?=$count;?></td>
                                            <td><?=$third_party;?><br>
                                            <span class="tx-10 tx-danger"><?=$barcode;?></span></td>
                                            <td><?=substr($created_date,0,10);?></td>
                                            <td>
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
                                            ?>
                                          </td>
                                              

                                            <td><?=$status_text;?></td>
                                            <td><?=$weight;?></td>
                                          </tr>
                                          <?
                                          $total_weight+=$weight;
                                          array_push($barcodes,$barcode);
                                      }
                                      ?>
                                    </tbody>
                                  </table>
                                  <div class="clearfix">
                                    <table class="table">
                                      <tr>
                                        <td>Нийт ачаа</td><td  width="100"><span id="total_count" class="tx-danger"><?=$count;?>ш</span></td>
                                      </tr>
                                      <tr>
                                        <td>Нийт жин</td><td><span id="total_weight" class="tx-danger"><?=$total_weight;?>кг</span></td>
                                      </tr>
                                      <tr>
                                        <td>Нийт төлбөр /$/</td><td><span id="total_price_usd" class="tx-danger"><?=$total_weight*settings("cargo_rate");?>$</span></td>
                                      </tr>
                                      <tr>
                                        <td>Нийт төлбөр /₮/</td><td><span id="total_price_mnt" class="tx-danger"><?=number_format($total_weight*settings("cargo_rate")*settings("dollar_rate"));?>₮</span></td>
                                      </tr>
                                    </table>
                                  </div>
                                  <!--input type="submit" class="btn btn-success" value="Тооцоо хийх"-->
                                <!--/form-->
                              </div><!-- table-wrapper -->
                              <?

                              /******************************************************
                              *******************************************************
                              ****** ОЛГОЛТ******************************************
                              ******************************************************/
                               $sql = "UPDATE orders 
                               SET status='delivered',delivered_date='".date("Y-m-d H:i:s")."',deliver=$customer_id
                               WHERE receiver=$customer_id AND order_id IN (".implode($_POST["orders"],",").")";
                               $sql2="INSERT INTO bills (`timestamp`,deliver,barcode,orders,weight,type,count,cash,account,pos,later,total) VALUES('".date("Y-m-d H:i:s")."',$customer_id,'".implode(',',$barcodes)."','".implode(',',$_POST["orders"])."',$total_weight,0,$count,".$total_weight*settings("cargo_rate")*settings("dollar_rate").",0,0,0,".$total_weight*settings("cargo_rate")*settings("dollar_rate").")";

                               if (mysqli_query($conn,$sql) && mysqli_query($conn,$sql2)) 
                                echo '<div class="alert alert-success">Амжилттай олгогдлоо.</div>';
                              else echo '<div class="alert alert-danger">Олголтод баазын алдаа гарлаа.</div>';

                            }
                          }
                          else 
                            {
                              echo '<div class="alert alert-danger">Ачаа тэмдэглээгүй байна.</div>';
                              echo '<a class="btn btn-success" href="javascript:history.go(-1)">Буцах</a>';
                            }
                          ?>
                         
                      </div>
                      <?
                    }
                    else header("location:deliver2.php");
                    ?>
                </div>
              </div>
            </div>
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
    <script src="lib/jquery-ui/js/jquery-ui.js"></script>

    <script>
      $(document).ready(function() {
        //alert("asdasdas");
        //$('input[name="select_all"]').hide(100);
        $('input[name="select_all"]').click(function(event) {
        if(this.checked) { 
           //alert("checked");
            $('input[type="checkbox"]').each(function() {
                this.checked = true;            
            });
          }
          else
          {
          //alert("unchecked");
            $('input[type="checkbox"]').each(function() {
                this.checked = false; 
            }); 
                   
          }        
      });
      $('input[type="checkbox"]').change(function(){
        var total_weight=0;
        var total_count=0;
        var cargo_rate= parseFloat($('input[name="cargo_rate"]').val());
        var dollar_rate= parseFloat($('input[name="dollar_rate"]').val());

        $('input[type="checkbox"]').each(function() {
              if (this.checked)
                {
                  total_count+=1;
                  total_weight+=parseFloat(this.alt,10); 
                }               

            });
        $("#total_count").html(total_count+'ш');
        $("#total_weight").html(total_weight+'кг');
        $("#total_price_usd").html(total_weight*cargo_rate+'$');
        $("#total_price_mnt").html(total_weight*cargo_rate*dollar_rate+'₮');
        
      })
    });
    </script>

   
  </body>
</html>
