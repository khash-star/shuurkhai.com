<?php require_once("config.php");?>
<?php require_once("views/helper.php");?>
<?php require_once("views/login_check.php");?>
<?php require_once("views/init.php");?>
  <body>
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
      <div class="layout-container">
        <?php require_once("views/header.php");?>

        
        <div class="layout-page">          
          <div class="content-wrapper">
            <?php require_once("views/topmenu.php");?>

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row g-6">
                  <div class="col-lg-12">
                    <table id="report_table" class='table table-hover small'>
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Onair</th>
                                <th>Тоо ширхэг</th>
                                <th>Жин</th>
                                <th>Төлбөр</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $grand_total = 0;
                            $sql = "SELECT orders.* ,count(order_id) as Count, sum(weight) as total FROM orders  WHERE status not IN('new','order','weight_missing') AND onair_date!='0000-00-00 00:00:00' GROUP BY onair_date ORDER BY onair_date DESC";
                            $result =mysqli_query($conn,$sql);
                            if (mysqli_num_rows($result) > 0)
                                    {
                                
                                    $count=1;
                                    while ($data = mysqli_fetch_array($result))
                                        {  
                                            $weight = $data["total"];
                                            $onair_date = $data["onair_date"];
                                            $count_order = $data["Count"];
                                            ?>
                                            <tr>
                                            <td><?php echo $count++;?></td>
                                            <td><?php echo htmlspecialchars($onair_date ?? '');?></td>
                                            <td><?php echo htmlspecialchars($count_order ?? '');?></td>
                                            <td><?php echo number_format($weight ?? 0, 2);?></td>
                                            <td><?php echo htmlspecialchars(cfg_price($weight) ?? '');?>$</td>
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
