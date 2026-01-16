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
            <li class="breadcrumb-item" aria-current="page">Админ цэс</li>
            <li class="breadcrumb-item active" aria-current="page">Параметр</li>
          </ol>
          <h6 class="slim-pagetitle">Параметр</h6>
        </div><!-- slim-pageheader -->


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
                <table id="datatable1" class="table display responsive">
                  <thead>
                    <tr>
                      <th class="wd-5p">№</th>
                      <th class="wd-70p">Нэр</th>
                      <th class="wd-20p">Утга</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?
                    $count =1;
                    $sql = "SELECT *FROM parameters ORDER BY name DESC";
                    $result = mysqli_query($conn,$sql);
                    if (mysqli_num_rows($result)>0)
                    {
                      while ($data = mysqli_fetch_array($result))
                      {

                        ?>
                        <tr>
                          <td><?=$count++;?></td>
                          <td><h4><?=$data["name"];?></h4></td>
                          <td><?=$data["value"];?></td>
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
