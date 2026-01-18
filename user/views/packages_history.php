<div class="row layout-top-spacing" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="table-responsive mb-4 mt-4">
                <table id="zero-config" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="no-content">№</th>
                            <th>Авсан огноо</th>
                            <th>Жин</th>
                            <th>Трак</th>
                            <th>Тайлбар</th>
                            <th>Barcode</th>
                            
                            <th class="no-content"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $count = 0;
                    $sum_weight = 0;
                    $package1_name = '';
                    $package1_num = '';
                    $package2_name = '';
                    $package2_num = '';
                    $package3_name = '';
                    $package3_num = '';
                    $package4_name = '';
                    $package4_num = '';
                    if (isset($conn) && $conn && isset($sql)) {
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            $i = mysqli_num_rows($result);
                            while ($data = mysqli_fetch_array($result)) {
                                $order_id = isset($data["order_id"]) ? intval($data["order_id"]) : 0;
                                $weight = isset($data["weight"]) ? htmlspecialchars($data["weight"]) : '';
                                $price = isset($data["price"]) ? htmlspecialchars($data["price"]) : '';
                                
                                $created_date = isset($data["created_date"]) ? htmlspecialchars($data["created_date"]) : '';
                                $onair_date = isset($data["onair_date"]) ? htmlspecialchars($data["onair_date"]) : '';
                                $warehouse_date = isset($data["warehouse_date"]) ? htmlspecialchars($data["warehouse_date"]) : '';
                                $delivered_date = isset($data["delivered_date"]) ? htmlspecialchars($data["delivered_date"]) : '';
                                
                                $barcode = isset($data["barcode"]) ? htmlspecialchars($data["barcode"]) : '';
                                $package = isset($data["package"]) ? htmlspecialchars($data["package"]) : '';
                                
                                $sender = isset($data["sender"]) ? intval($data["sender"]) : 0;
                                $receiver = isset($data["receiver"]) ? intval($data["receiver"]) : 0;
                                $deliver = isset($data["deliver"]) ? htmlspecialchars($data["deliver"]) : '';
                                
                                $insurance = isset($data["insurance"]) ? htmlspecialchars($data["insurance"]) : '';
                                $insurance_value = isset($data["insurance_value"]) ? htmlspecialchars($data["insurance_value"]) : '';
                                $advance = isset($data["advance"]) ? htmlspecialchars($data["advance"]) : '';
                                $advance_value = isset($data["advance_value"]) ? htmlspecialchars($data["advance_value"]) : '';
                                $third_party = isset($data["third_party"]) ? htmlspecialchars($data["third_party"]) : '';
                                
                                $way = isset($data["way"]) ? htmlspecialchars($data["way"]) : '';
                                $deliver_time = isset($data["deliver_time"]) ? htmlspecialchars($data["deliver_time"]) : '';
                                $inside = isset($data["inside"]) ? htmlspecialchars($data["inside"]) : '';
                                $return_type = isset($data["return_type"]) ? htmlspecialchars($data["return_type"]) : '';
                                $return_day = isset($data["return_day"]) ? htmlspecialchars($data["return_day"]) : '';
                                $return_way = isset($data["return_way"]) ? htmlspecialchars($data["return_way"]) : '';
                                $return_address = isset($data["return_address"]) ? htmlspecialchars($data["return_address"]) : '';
                                
                                $extra = isset($data["extra"]) ? htmlspecialchars($data["extra"]) : '';
                                $timestamp = isset($data["timestamp"]) ? htmlspecialchars($data["timestamp"]) : '';
                                $transport = isset($data["transport"]) ? htmlspecialchars($data["transport"]) : '';
                                $status = isset($data["status"]) ? htmlspecialchars($data["status"]) : '';
                                $agents = isset($data["agents"]) ? htmlspecialchars($data["agents"]) : '';
                                $is_online = isset($data["is_online"]) ? intval($data["is_online"]) : 0;
                                $proxy = isset($data["proxy_id"]) ? intval($data["proxy_id"]) : 0;
                                
                                if ($status == "warehouse" && $extra == '999') $status = "handover";
                                
                                $package1_name = '';
                                $package1_num = '';
                                $package2_name = '';
                                $package2_num = '';
                                $package3_name = '';
                                $package3_num = '';
                                $package4_name = '';
                                $package4_num = '';
                                
                                if (!empty($package)) {
                                    $package_array = explode("##", $package);
                                    if (count($package_array) > 11) {
                                        $package1_name = isset($package_array[0]) ? htmlspecialchars($package_array[0]) : '';
                                        $package1_num = isset($package_array[1]) ? htmlspecialchars($package_array[1]) : '';
                                        $package1_value = isset($package_array[2]) ? htmlspecialchars($package_array[2]) : '';
                                        $package2_name = isset($package_array[3]) ? htmlspecialchars($package_array[3]) : '';
                                        $package2_num = isset($package_array[4]) ? htmlspecialchars($package_array[4]) : '';
                                        $package2_value = isset($package_array[5]) ? htmlspecialchars($package_array[5]) : '';
                                        $package3_name = isset($package_array[6]) ? htmlspecialchars($package_array[6]) : '';
                                        $package3_num = isset($package_array[7]) ? htmlspecialchars($package_array[7]) : '';
                                        $package3_value = isset($package_array[8]) ? htmlspecialchars($package_array[8]) : '';
                                        $package4_name = isset($package_array[9]) ? htmlspecialchars($package_array[9]) : '';
                                        $package4_num = isset($package_array[10]) ? htmlspecialchars($package_array[10]) : '';
                                        $package4_value = isset($package_array[11]) ? htmlspecialchars($package_array[11]) : '';
                                    }
                                }
                                ?>
                                <tr>
                                <td><?php echo ++$count; ?></td>
                                <td><?php echo !empty($delivered_date) ? htmlspecialchars(substr($delivered_date, 0, 10)) : ''; ?></td>
                                <td><?php echo !empty($weight) ? htmlspecialchars($weight) . "кг" : ''; ?></td>
                                <td><?php echo htmlspecialchars($third_party ?? ''); ?>
                                <?php 
                                    if ($proxy != 0) {
                                        ?>
                                        <br>
                                        <span class="badge outline-badge-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>                                   
                                            <?php echo htmlspecialchars(proxy($proxy, "name") ?? ''); ?> 
                                        </span>
                                        <?php
                                    } else {
                                        ?>
                                        <br>
                                        <span class="badge outline-badge-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>                                   
                                            <?php echo htmlspecialchars(customer($user_id ?? 0, "name") ?? ''); ?> 
                                        </span>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                <?php
                                if (!empty($third_party)) {
                                    if (!empty($package1_name)) {
                                        echo htmlspecialchars($package1_name) . " (" . htmlspecialchars($package1_num) . ")<br>";
                                    }
                                    if (!empty($package2_name)) {
                                        echo htmlspecialchars($package2_name) . " (" . htmlspecialchars($package2_num) . ")<br>";
                                    }
                                    if (!empty($package3_name)) {
                                        echo htmlspecialchars($package3_name) . " (" . htmlspecialchars($package3_num) . ")<br>";
                                    }
                                    if (!empty($package4_name)) {
                                        echo htmlspecialchars($package4_name) . " (" . htmlspecialchars($package4_num) . ")<br>";
                                    }
                                }
                                ?>
                                </td>
                                <td><?php echo htmlspecialchars($barcode ?? ''); ?></td>
                                
                                
                                <td>
                                    <a href="packages?action=detail&id=<?php echo htmlspecialchars($order_id ?? 0); ?>" class="btn btn-success btn-xs">Дэлгэрэнгүй</a>
                                </td>
                                </tr>
                                <?php
                                if (!empty($weight)) {
                                    $sum_weight += floatval($weight);
                                }
                            }
                        }
                    }
                    ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th><?php echo htmlspecialchars($count ?? 0); ?>ш</th>
                            <th></th>
                            <th><?php echo (!empty($sum_weight)) ? htmlspecialchars($sum_weight) . 'кг' : ''; ?></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
