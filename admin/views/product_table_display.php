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
        <?php
            $result = mysqli_query($conn,$sql);
            if ($result && mysqli_num_rows($result)>0)
            {
                $count =1;
                while ($data = mysqli_fetch_array($result))
                {
                    if ($data) {
                    ?>
                    <tr>
                    <td><?php echo $count++;?></td>
                    <td><?php echo (isset($data["image"]) && $data["image"]<>"" && file_exists("../".$data["image"]))?'<img src="../'.htmlspecialchars($data["image"]).'" class="product_tiny">':'';?></td>
                    <td class="text-wrap"><?php echo htmlspecialchars($data["name"] ?? '');?></td>
                    <td class="text-wrap"><?php echo htmlspecialchars($data["price"] ?? '');?></td>
                    <td class="text-wrap"><?php echo htmlspecialchars($data["transportation"] ?? '');?></td>
                    <td><?php echo isset($data["created_date"]) ? htmlspecialchars(substr($data["created_date"],0,10)) : '';?></td>
                    <td class="tx-18">
                        <div class="btn-group">
                            <a href="products?action=detail&id=<?php echo htmlspecialchars($data["id"] ?? '');?>" class="btn btn-success btn-xs text-white btn-icon" title="Харах"><i data-feather="archive"></i></a>
                            <a href="products?action=edit&id=<?php echo htmlspecialchars($data["id"] ?? '');?>"  class="btn btn-warning btn-xs text-white btn-icon btn-icon" title="Засах"><i data-feather="archive"></i></a>
                        </div>
                    </td>
                    </tr>
                    <?php
                    }
                }
            }
            ?>
        
        </tbody>
    </table>
</div>