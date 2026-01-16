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
                    <?
                    $result = mysqli_query($conn,$sql);
                    $i=mysqli_num_rows($result);
                    $count=0;
                    $sum_price=0;
                    $sum_tax=0;
                    $sum_shipping=0;
                    while ($data = mysqli_fetch_array($result))
                        {  
                            $sum_price+=$data["price"];
                            $sum_tax+=$data["tax"];
                            $sum_shipping+=$data["shipping"];


                            $created_date=$data["created_date"];
                            $online_id=$data["online_id"];
                            $url=$data["url"]; 
                            $size=$data["size"]; 
                            $color=$data["color"];
                            $number=$data["number"];
                            $receiver=$data["receiver"];
                            $track=$data["track"];
                            $comment=$data["comment"];
                            $status=$data["status"];
                            $price=$data["price"];
                            $tax=$data["tax"];
                            $shipping=$data["shipping"];
                            $title=$data["title"];
                            $comment=$data["comment"];
                            $transport = $data["transport"];
                            ?>
                            <tr>
                                <td><?=++$count;?></td>
                                <td><?=short_date(substr($created_date,0,10));?></td>
                                <td><span class="badge badge-info badge-pills"><?=$status;?></span></td>

                                <?
                                if (strlen($title)>50) $title=substr($title,0,50)."...";
                                if (strlen($title)==0) $title=substr($url,0,50)."...";
                                ?>
                                <td class="text-wrap"><a href='<?=$url;?>' target='new' title="<?=$title;?>"><?=$title;?></a></td>	
                                <td><?=$number;?></td>
                                <td><?=$size;?></td>
                                <td><?=$color;?></td>
                                <td>
                                <?
                                    if ($price>0)
                                    echo '<span style="color:#090; font-weight:bold;">'.$price.'$</span>';
                                    else {	if ($comment!="") echo $comment; else echo "-";	}
                                ?>
                                </td>
                                <td>
                                <?
                                    if ($tax>0)
                                    echo '<span style="color:#090; font-weight:bold;">'.$tax.'$</span>';
                                ?>
                                </td>
                                <td>
                                <?
                                    if ($shipping>0)
                                    echo '<span style="color:#090; font-weight:bold;">'.$shipping.'$</span>';
                                ?>
                                </td>
                                <td>
                                <?
                                if ($status=="online")
                                    {
                                        ?>
                                        <div class="btn-group btn-sm">
                                            <a href="online?action=delete&id=<?=$online_id;?>" class='btn btn-sm btn-danger'>Устгах</a>
                                            <a href="online?action=payment&id=<?=$online_id;?>" class='btn btn-sm btn-warning'>Төлөх</a>
                                            <a href="online?action=makelater&id=<?=$online_id;?>" class='btn btn-sm btn-primary'>Хойшлуулах</a>
                                        </div>
                                        <?
                                    }
                                if ($status=="later")
                                    {
                                        ?>
                                        <div class="btn-group btn-sm">
                                            <a href="online?action=delete&id=<?=$online_id;?>" class='btn btn-sm btn-danger'>Устгах</a>
                                            <a href="online?action=makeactive&id=<?=$online_id;?>" class='btn btn-sm btn-success'>Идэвхижүүлэх</a>
                                        </div>
                                        <?
                                    }
                                ?>
                                </td>
                                <!-- <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle table-cancel"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></td> -->
                            </tr>
                            <?
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
                            <th></th>
                            <th></th>
                            <th><?=number_format($sum_price);?>$</th>
                            <th><?=number_format($sum_tax);?>$</th>
                            <th><?=number_format($sum_shipping);?>$</th>
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
                            <th colspan="3" class="text-right border">Нийт /$/: <?=number_format($sum_price+$sum_tax+$sum_shipping);?>$</th>
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
                            <th colspan="3" class="text-right ">Нийт /₮/: <?=number_format(settings("rate")*($sum_price+$sum_tax+$sum_shipping));?>$</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
