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
                                <th>PAID</th>
                                <th>COLLECT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $grand_total = 0;
                            $grand_weight = 0;
                            $grand_paid = 0;
                            $grand_collect = 0;
                            // Calculate paid weight and collect weight separately for each onair_date
                            // PAID = orders with advance=1 or advance_value > 0 (Америкт төлсөн)
                            // COLLECT = orders with advance=0 or advance_value = 0 (Монголд төлөх)
                            $sql = "SELECT 
                                onair_date,
                                COUNT(order_id) as Count, 
                                SUM(weight) as total,
                                SUM(CASE WHEN (advance=1 OR advance_value > 0) THEN weight ELSE 0 END) as paid_weight,
                                SUM(CASE WHEN (advance=0 OR advance_value = 0 OR advance_value IS NULL) THEN weight ELSE 0 END) as collect_weight
                            FROM orders  
                            WHERE status not IN('new','order','weight_missing') 
                            AND onair_date!='0000-00-00 00:00:00' 
                            AND onair_date IS NOT NULL
                            GROUP BY onair_date 
                            ORDER BY onair_date DESC";
                            $result = mysqli_query($conn,$sql);
                            if (mysqli_num_rows($result) > 0)
                                    {
                                
                                    $count=1;
                                    while ($data = mysqli_fetch_array($result))
                                        {  
                                            $weight = floatval($data["total"]);
                                            $onair_date = $data["onair_date"];
                                            $count_order = $data["Count"];
                                            $paid_weight = floatval($data["paid_weight"] ?? 0);
                                            $collect_weight = floatval($data["collect_weight"] ?? 0);
                                            
                                            // Verify: paid_weight + collect_weight should equal total weight
                                            // If not, adjust collect_weight to match
                                            if (abs(($paid_weight + $collect_weight) - $weight) > 0.01) {
                                                $collect_weight = $weight - $paid_weight;
                                            }
                                            
                                            // PAID = paid_weight * paymentrate_selfdrop (Америкт төлсөн)
                                            $paid = 0;
                                            if ($paid_weight > 0) {
                                                $selfdrop_rate = floatval(settings("paymentrate_selfdrop") ?? 0);
                                                $paid = $paid_weight * $selfdrop_rate;
                                            }
                                            
                                            // COLLECT = collect_weight * cfg_price_rate (Монголд төлөх)
                                            // 0.5кг-аас доош бол 10$, түүнээс дээш бол cfg_price
                                            $collect = 0;
                                            if ($collect_weight > 0) {
                                                if ($collect_weight < 0.5) {
                                                    $collect = 10; // 0.5кг-аас доош бол 10$
                                                } else {
                                                    $collect = cfg_price($collect_weight); // 0.5кг-аас дээш бол cfg_price
                                                }
                                            }
                                            
                                            $grand_weight += $weight;
                                            $grand_paid += $paid;
                                            $grand_collect += $collect;
                                            ?>
                                            <tr>
                                            <td><?php echo $count++;?></td>
                                            <td><?php echo htmlspecialchars($onair_date ?? '');?></td>
                                            <td><?php echo htmlspecialchars($count_order ?? '');?></td>
                                            <td><?php echo number_format($weight ?? 0, 2);?></td>
                                            <td><?php echo number_format($paid, 2, '.', ',');?>$</td>
                                            <td><?php echo number_format($collect, 2, '.', ',');?>$</td>
                                            </tr>
                                            <?php
                                        } 
                                
                                    } 
                                ?>
                        </tbody>
                        <tfoot>
                            <tr style="background-color: #f0f0f0; font-weight: bold;">
                                <td colspan="3" style="text-align: right;">Нийт:</td>
                                <td><?php echo number_format($grand_weight, 2, '.', ',');?></td>
                                <td><?php echo number_format($grand_paid, 2, '.', ',');?>$</td>
                                <td><?php echo number_format($grand_collect, 2, '.', ',');?>$</td>
                            </tr>
                        </tfoot>
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
