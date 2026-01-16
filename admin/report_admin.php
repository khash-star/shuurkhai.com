<? require_once("login_check.php");?>
<? require_once("config.php");?>
<? require_once("helper.php");?>
<? require_once("init.php");?>
  <body>
    <? require_once("header.php");?>

    <div class="slim-mainpanel">
      <div class="container">
        <div class="slim-pageheader">
          <ol class="breadcrumb slim-breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Тайлан</li>
          </ol>
          <h6 class="slim-pagetitle">Олголтын тайлан</h6>
        </div><!-- slim-pageheader -->
        <?
        if (isset($_POST["start"])) $start = $_POST["start"]; else $start = date("Y-m-01");
        if (isset($_POST["finish"])) $finish = $_POST["finish"]; else $finish = date("Y-m-d");
        ?>
        <div class="row row-xs mg-t-10">
          <div class="col-lg-12">
            <div class="card card-people-list pd-20">
              <div class="slim-card-title">Тайлан харах хугацаа</div>  
              <form method="post" action="report_admin.php">
                <div class="row">            
                  <div class="col-lg-6 col-sm-12">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                        </div>
                      </div>
                      <input type="text" value="<?=$start;?>" name="start" class="form-control fc-datepicker" id="start">
                    </div>
                  </div>
                  <div class="col-lg-5 col-sm-12">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                        </div>
                      </div>
                      <input type="text" value="<?=$finish;?>" name="finish" class="form-control fc-datepicker" id="finish">
                    </div>
                  </div>

                  <div class="col-lg-1 col-sm-12"><input type="submit" value="Харах" class="btn btn-success"></div>
                </div>
              </form>
            </div><!-- card -->
          </div><!-- col-12 -->
          <div class="col-md-6 mg-t-10">
            <div class="card">
              <div class="card-body">
                <?
                $sql = "SELECT COUNT(*) AS TOTAL_COUNT, SUM(weight) AS TOTAL_WEIGHT FROM orders WHERE (status='delivered' OR status='customs') AND delivered_date>='$start' AND  delivered_date<='$finish 23:59:59'";
                //echo $sql;
                $result = mysqli_query($conn,$sql);
                $data = mysqli_fetch_array($result);
                $TOTAL_COUNT = $data["TOTAL_COUNT"];
                $TOTAL_WEIGHT = $data["TOTAL_WEIGHT"];


                $sql = "SELECT COUNT(receiver) AS TOTAL_RECEIVER FROM orders WHERE (status='delivered' OR status='customs') AND delivered_date>='$start' AND  delivered_date<='$finish 23:59:59' GROUP BY receiver";
                $result = mysqli_query($conn,$sql);
                $data = mysqli_fetch_array($result);
                $TOTAL_RECEIVER = $data["TOTAL_RECEIVER"];

                ?>
                <ul class="list-group list-group-striped">
                  <li class="list-group-item">
                    <p class="mg-b-0">Олгогдсон нийт ачааны тоо <strong class="tx-inverse tx-medium"><?=$TOTAL_COUNT;?>ш</strong></p>
                  </li>
                  <li class="list-group-item">
                    <p class="mg-b-0">Олгогдсон нийт жин <strong class="tx-inverse tx-medium tx-danger"><?=$TOTAL_WEIGHT;?>кг</strong></p>
                  </li>
                  <li class="list-group-item">
                    <p class="mg-b-0">Олгогдсон нийт орлого <strong class="tx-inverse tx-medium tx-danger"><?=settings("cargo_rate")*$TOTAL_WEIGHT;?>$</strong></p>
                  </li>
                   <li class="list-group-item">
                    <p class="mg-b-0">Олгогдсон нийт орлого <strong class="tx-inverse tx-medium tx-danger"><?=number_format(settings("dollar_rate")*settings("cargo_rate")*$TOTAL_WEIGHT);?>₮</strong></p>
                  </li>
                  <li class="list-group-item">
                    <p class="mg-b-0">Тус хугацаанд үйлчлүүлэгсэд <strong class="tx-inverse tx-medium tx-danger"><?=$TOTAL_RECEIVER;?></strong></p>
                  </li>
                  
                </ul>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-12 -->
          <div class="col-md-6 mg-t-10">
            <div class="card">
              <div class="card-body">
                 <div class="list-group">
                  <div class="list-group-item pd-y-20">
                    <div class="media">
                      <div class="d-flex mg-r-10 wd-50">
                        <i class="fa fa-file-excel-o tx-primary tx-40 tx"></i>
                      </div><!-- d-flex -->
                      <div class="media-body">
                        <h6 class="tx-inverse">Гардуулсан ачааны жагсаалт</h6>
                        <p class="mg-b-0">Тайлант хугацаанд гардуулсан ачааны жагсаалтыг файлаар татах</p>
                        <a href="#">Энд дарна уу</a>
                      </div><!-- media-body -->
                    </div><!-- media -->
                  </div><!-- list-group-item -->
                  <div class="list-group-item pd-y-20">
                    <div class="media">
                      <div class="d-flex mg-r-10 wd-50">
                        <i class="fa fa-file-excel-o tx-primary tx-40 tx"></i>
                      </div><!-- d-flex -->
                      <div class="media-body">
                        <h6 class="tx-inverse">Үйлчлүүлэгчдийн жагсаалт</h6>
                        <p class="mg-b-0">Тайлант хугацаанд ачаа гардаж авсан үйлчлүүлэгчдийг файлаар татах</p>
                        <a href="#">Энд дарна уу</a>
                      </div><!-- media-body -->
                    </div><!-- media -->
                  </div><!-- list-group-item -->
                </div><!-- list-group -->
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-12 -->
        </div><!-- row -->
      </div><!-- container -->
    </div><!-- slim-mainpanel -->

    <? require_once("footer.php");?>

    <script src="lib/jquery/js/jquery.js"></script>
    <script src="lib/popper.js/js/popper.js"></script>
    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script src="lib/jquery.cookie/js/jquery.cookie.js"></script>
    <script src="lib/moment/js/moment.js"></script>
    <script src="lib/jquery-ui/js/jquery-ui.js"></script>


    <script src="js/slim.js"></script>
        <script>
      $(function(){
        'use strict'

        // Datepicker
        $('#start').datepicker({
          showOtherMonths: true,
          dateFormat: "yy-mm-dd"
        });
        $('#finish').datepicker({
          showOtherMonths: true,
          dateFormat: "yy-mm-dd"
        });

      });
    </script>
  </body>
</html>
