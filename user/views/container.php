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
                            <th>Жин</th>
                            <th>Трак/хүлээн авагч</th>
                            <th>Баркод</th>
                            <th>Чингэлэг</th>
                            <th>Тайлбар</th>
                            <th class="no-content">Үйлдэл</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?
                    $result = mysqli_query($conn,$sql);
                    $i=mysqli_num_rows($result);
                    $count=0;
                    $sum_weight=0;
                    while ($data = mysqli_fetch_array($result))
                        {  
                            $order_id=$data["id"];
                            $weight=$data["weight"];
                            $price=$data["price"];
                            $container_id=$data["container"];
                            $container_name=$data["container_name"];
                            
                            
                            $created_date=$data["created_date"];
                            $onair_date=$data["onair_date"];
                            $warehouse_date=$data["warehouse_date"];
                            $delivered_date=$data["delivered_date"];
                            
                            
                            $barcode=$data["barcode"];
                            $package=$data["package"];
                            $price=$data["price"];
                            
                            $sender=$data["sender"];
                            $receiver=$data["receiver"];
                            $deliver=$data["deliver"];
                            
                            $insurance=$data["insurance"];
                            $insurance_value=$data["insurance_value"];
                            $advance=$data["advance"];
                            $advance_value=$data["advance_value"];
                            $third_party=$data["third_party"];
                            
                           $track = $data["track"];
                            
                            $extra=$data["extra"];
                            $timestamp=$data["timestamp"];
                            $transport=$data["transport"];
                            $status=$data["status"];
                            $agents=$data["agents"];
                            $is_online=$data["is_online"];
                            $proxy=$data["proxy_id"];
                            
                            if ($status=="warehouse" && $extra=='999') $status="handover";
                            $package_array=explode("##",$package);
                            if (count($package_array)>11)
                            {
                            $package1_name = $package_array[0];
                            $package1_num = $package_array[1];
                            $package1_value = $package_array[2];
                            $package2_name = $package_array[3];
                            $package2_num = $package_array[4];
                            $package2_value = $package_array[5];
                            $package3_name = $package_array[6];
                            $package3_num = $package_array[7];
                            $package3_value = $package_array[8];
                            $package4_name = $package_array[9];
                            $package4_num = $package_array[10];
                            $package4_value = $package_array[11];
                            }
                            ?>
                            <tr>
                            <td><?=++$count;?></td>
                            <td>
                            <?=substr($created_date,0,10);?>
                            </td>
                            <td><span class="badge badge-info badge-pills"><?=$status;?></span></td>
                            <td><? if($weight!="") echo $weight."кг";?></td>
                            <td><?=$track;?>
                                <? 
                                    if ($proxy!=0) 
                                {
                                    ?>
                                    <br>
                                    <span class="badge outline-badge-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>                                   
                                        <?=proxy($proxy,"name");?> 
                                    </span>
                                    <?
                                }
                                else 
                                {
                                    ?>
                                    <br>
                                    <span class="badge outline-badge-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>                                   
                                        <?=customer($user_id,"name");?> 
                                    </span>
                                    <?
                                }
                                ?>
                            </td>
                           
                            <td><?=$barcode;?></td>
                            <td><?=$container_name;?></td>
                            <td>
                            <?
                            if ($third_party!="")
                            {
                                if ($package1_name!="")
                                echo "$package1_name ($package1_num)<br>";
                                if ($package2_name!="")
                                echo "$package2_name ($package2_num)<br>";
                                if ($package3_name!="")
                                echo "$package3_name ($package3_num)<br>";
                                if ($package4_name!="")
                                echo "$package4_name ($package4_num)<br>";

                            }
                            ?>
                            </td>
                            <td>
                                <a href="packages?action=container_detail&id=<?=$order_id;?>" class="btn btn-success btn-xs">Дэлгэрэнгүй</a>
                            </td>
                            </tr>
                            <?
                            $sum_weight+=$weight;
                        }
                        ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th><?=$count;?>ш</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><?=($sum_weight!="")?$sum_weight.'кг':'';?></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
