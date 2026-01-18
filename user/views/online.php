<div class="row layout-top-spacing" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="table-responsive mb-4 mt-4">
                <table id="zero-config" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="no-content">№</th>
                            <th>Огноо</th>
                            <th>Төлөв</th>
                            <th>URL хаяг</th>
                            <th>Тоо</th>
                            <th>Хэмжээ</th>
                            <th>Өнгө</th>
                            <th>Үндсэн үнэ</td>
                            <th>Татвар-US</th>
                            <th>Хүргэлт-US</th>
                            <th class="no-content"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $count = 0;
                    $sum_price = 0;
                    $sum_tax = 0;
                    $sum_shipping = 0;
                    if (isset($conn) && $conn && isset($sql)) {
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            $i = mysqli_num_rows($result);
                            while ($data = mysqli_fetch_array($result)) {
                                $price = isset($data["price"]) ? floatval($data["price"]) : 0;
                                $tax = isset($data["tax"]) ? floatval($data["tax"]) : 0;
                                $shipping = isset($data["shipping"]) ? floatval($data["shipping"]) : 0;
                                $sum_price += $price;
                                $sum_tax += $tax;
                                $sum_shipping += $shipping;

                                $created_date = isset($data["created_date"]) ? htmlspecialchars($data["created_date"]) : '';
                                $online_id = isset($data["online_id"]) ? intval($data["online_id"]) : 0;
                                $url = isset($data["url"]) ? htmlspecialchars($data["url"]) : ''; 
                                $size = isset($data["size"]) ? htmlspecialchars($data["size"]) : ''; 
                                $color = isset($data["color"]) ? htmlspecialchars($data["color"]) : '';
                                $number = isset($data["number"]) ? htmlspecialchars($data["number"]) : '';
                                $receiver = isset($data["receiver"]) ? intval($data["receiver"]) : 0;
                                $track = isset($data["track"]) ? htmlspecialchars($data["track"]) : '';
                                $comment = isset($data["comment"]) ? htmlspecialchars($data["comment"]) : '';
                                $status = isset($data["status"]) ? htmlspecialchars($data["status"]) : '';
                                $title = isset($data["title"]) ? htmlspecialchars($data["title"]) : '';
                                $transport = isset($data["transport"]) ? htmlspecialchars($data["transport"]) : '';
                                
                                if (mb_strlen($title, 'UTF-8') > 50) $title = mb_substr($title, 0, 50, 'UTF-8') . "...";
                                if (mb_strlen($title, 'UTF-8') == 0) $title = mb_substr($url, 0, 50, 'UTF-8') . "...";
                                ?>
                                <tr>
                                    <td><?php echo ++$count; ?></td>
                                    <td><?php echo !empty($created_date) ? htmlspecialchars(short_date(substr($created_date, 0, 10))) : ''; ?></td>
                                    <td><span class="badge badge-info badge-pills"><?php echo !empty($status) ? htmlspecialchars($status) : ''; ?></span></td>

                                    <td class="text-wrap"><a href='<?php echo htmlspecialchars($url ?? ''); ?>' target='new' title="<?php echo htmlspecialchars($title ?? ''); ?>"><?php echo htmlspecialchars($title ?? ''); ?></a></td>	
                                    <td><?php echo htmlspecialchars($number ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($size ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($color ?? ''); ?></td>
                                    <td>
                                    <?php
                                        if ($price > 0) {
                                            echo '<span style="color:#090; font-weight:bold;">' . htmlspecialchars($price) . '$</span>';
                                        } else {
                                            if (!empty($comment)) {
                                                echo htmlspecialchars($comment);
                                            } else {
                                                echo "-";
                                            }
                                        }
                                    ?>
                                    </td>
                                    <td>
                                    <?php
                                        if ($tax > 0) {
                                            echo '<span style="color:#090; font-weight:bold;">' . htmlspecialchars($tax) . '$</span>';
                                        }
                                    ?>
                                    </td>
                                    <td>
                                    <?php
                                        if ($shipping > 0) {
                                            echo '<span style="color:#090; font-weight:bold;">' . htmlspecialchars($shipping) . '$</span>';
                                        }
                                    ?>
                                    </td>
                                    <td>
                                    <?php
                                    if ($status == "online") {
                                        ?>
                                        <div class="btn-group btn-sm">
                                            <a href="online?action=delete&id=<?php echo htmlspecialchars($online_id ?? 0); ?>" class='btn btn-sm btn-danger'>Устгах</a>
                                            <a href="online?action=payment&id=<?php echo htmlspecialchars($online_id ?? 0); ?>" class='btn btn-sm btn-warning'>Төлөх</a>
                                            <a href="online?action=makelater&id=<?php echo htmlspecialchars($online_id ?? 0); ?>" class='btn btn-sm btn-primary'>Хойшлуулах</a>
                                        </div>
                                        <?php
                                    }
                                    if ($status == "later") {
                                        ?>
                                        <div class="btn-group btn-sm">
                                            <a href="online?action=delete&id=<?php echo htmlspecialchars($online_id ?? 0); ?>" class='btn btn-sm btn-danger'>Устгах</a>
                                            <a href="online?action=makeactive&id=<?php echo htmlspecialchars($online_id ?? 0); ?>" class='btn btn-sm btn-success'>Идэвхижүүлэх</a>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    </td>
                                    <!-- <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle table-cancel"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></td> -->
                                </tr>
                                <?php
                            }
                        }
                    }
                    ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th><?php echo htmlspecialchars($count ?? 0); ?>ш</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><?php echo number_format($sum_price ?? 0); ?>$</th>
                            <th><?php echo number_format($sum_tax ?? 0); ?>$</th>
                            <th><?php echo number_format($sum_shipping ?? 0); ?>$</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th colspan="3" class="text-right border">Нийт /$/: <?php echo number_format(($sum_price ?? 0) + ($sum_tax ?? 0) + ($sum_shipping ?? 0)); ?>$</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th colspan="3" class="text-right ">Нийт /₮/: <?php echo number_format((settings("rate") ?? 0) * (($sum_price ?? 0) + ($sum_tax ?? 0) + ($sum_shipping ?? 0))); ?>₮</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
