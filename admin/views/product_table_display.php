<div class="table-responsive">
    <table id="dataTableExample" class="table">
        <thead>
        <tr>
            <th>№</th>
            <th>Зураг</th>
            <th>Нэр</th>
            <th>Үнэ</th>
            <th>Тээвэр</th>
            <th>Оруулсан</th>
            <th>Үйлдэл</th>
        </tr>
        </thead>
        <tbody>
        <?
            $result = mysqli_query($conn,$sql);
            if (mysqli_num_rows($result)>0)
            {
                $count =1;
                while ($data = mysqli_fetch_array($result))
                {

                    ?>
                    <tr>
                    <td><?=$count++;?></td>
                    <td><?=($data["image"]<>"" && file_exists("../".$data["image"]))?'<img src="../'.$data["image"].'" class="product_tiny">':'';?></td>
                    <td class="text-wrap"><?=$data["name"];?></td>
                    <td class="text-wrap"><?=$data["price"];?></td>
                    <td class="text-wrap"><?=$data["transportation"];?></td>
                    <td><?=substr($data["created_date"],0,10);?></td>
                    <td class="tx-18">
                        <div class="btn-group">
                            <a href="products?action=detail&id=<?=$data["id"];?>" class="btn btn-success btn-xs text-white btn-icon" title="Харах"><i data-feather="archive"></i></a>
                            <a href="products?action=edit&id=<?=$data["id"];?>"  class="btn btn-warning btn-xs text-white btn-icon btn-icon" title="Засах"><i data-feather="archive"></i></a>
                        </div>
                    </td>
                    </tr>
                    <?
                }
            }
            ?>
        
        </tbody>
    </table>
</div>