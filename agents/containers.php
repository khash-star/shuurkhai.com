<? require_once("config.php");?>
<? require_once("views/helper.php");?>
<? require_once("views/login_check.php");?>
<? require_once("views/init.php");?>
  <body>
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
      <div class="layout-container">
        <? require_once("views/header.php");?>

        <? if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="dashboard";?>

        <div class="layout-page">          
          <div class="content-wrapper">
            <? require_once("views/topmenu.php");?>

            <div class="container-xxl flex-grow-1 container-p-y">
                <?
                if ($action=="all")
                {                    
                    
                    $sql="SELECT * FROM container WHERE status NOT IN ('delivered') ORDER BY created DESC";
                    $result = mysqli_query($conn,$sql);
                    $total_weight =0;

                    if (mysqli_num_rows($result) > 0)
                    {
                        echo "<table class='table table-hover table-striped'>";
                        echo "<tr>";
                        echo "<th>№</th>"; 
                        echo "<th>Нэр</th>"; 
                        echo "<th>Үүсгэсэн</th>"; 
                        echo "<th>Төлөв</th>";
                        echo "<th>Доторхи ачаа</th>"; 
                        echo "<th>Монголд</th>"; 
                        echo "<th></th>"; 
                        echo "</tr>";
                        $count=1;
                        while ($data = mysqli_fetch_array($result))
                        { 
                            $container_id= $data["container_id"]; 
                            $name= $data["name"]; 
                            $created= $data["created"];
                            $status = $data["status"];
                            $expected = $data["expected"];
                            ?>
                                                
                            <tr>
                            <td><?=$count++;?></td>
                            <td><?=$name;?></td>
                            <td><?=$created;?></td>
                            <td><?=$status;?></td>
                            <td>
                            <?
                                $sql="SELECT * FROM container_item WHERE container=$container_id";
                                $query_container = mysqli_query($conn,$sql);
                                echo mysqli_num_rows($query_container);
                            ?>
                            </td>
                            <td><?=$expected;?></td>
                            <td><a href="?action=detail&id=<?=$container_id;?>"><i class="ti ti-edit"></i></a></td>
                            </tr>
                            <?
                        }
                        echo "</table>";
                    }
                    else echo '<div class="alert alert-danger" role="alert">No container</div>';
                }

                if ($action=="detail")
                {                    
                    if (isset($_GET["id"])) 
                    {
                        $container_id = intval($_GET["id"]);
                        $sql = "SELECT * FROM container WHERE container_id=".$container_id;
                        $result = mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)==1)
                        {
                            $data = mysqli_fetch_array($result);
                            $name=$data["name"];
                            $created=$data["created"];
                            $departed=$data["departed"];
                            $expected=$data["expected"];
                            $description=$data["description"];
                            $status=$data["status"];
                            echo "<h1>".$name; echo '<a href="container?action=edit&id='.$container_id.'" class="btn btn-success btn-xs">засах</a></h1>';
                            if ($status=="new") echo '<a href="container?action=filling&id='.$container_id.'" class="btn btn-warning btn-xs">Ачаа оруулах</a><br>';
                            echo "Үүсгэсэн огноо:".$created."<br>";
                            echo "Төлөв:".$status."<br>";
                            echo "Америкаас гарсан огноо:".$departed."<br>";
                            echo "Монголд очих огноо:".$expected."<br>";
                            echo "<p>".$description."</p>";

                            // $data = array(array('Чингэлэгийн дугаар',$name."(".$expected.")",'','','','','','','','',''));

                        }
                        echo "<b>Чингэлэг лог</b><br>";
                        $result=mysqli_query($conn,"SELECT * FROM container_log WHERE container='".$container_id."' ORDER BY date DESC");
                        if (mysqli_num_rows($result) > 0)
                        {	 
                                echo "<table class='table table-hover'>";
                                echo "<tr>";
                                echo "<th>№</th>"; 
                                echo "<th>Огноо</th>"; 
                                echo "<th>Тайлбар</th>";
                                echo "<th>Үйлдэл</th>"; 
                                echo "</tr>";
                                $count=1;
                                foreach ($query->result() as $row)
                                    { 
                                $date=$data["date"];
                                $description=$data["description"];
                                
                                echo "<tr>";
                                echo "<td>".$count++."</td>";
                                echo "<td>".$date."</td>";
                                echo "<td>".$description."</td>";
                                echo "<td>";
                                echo anchor("agents/container_log_edit/".$container_id,"Засах");
                                    //echo anchor("agents/container_log_delete/".$container_id,"устгах",array("class"=>"btn btn-alert btn-xs"));

                                echo "</td>";
                                echo "</tr>";
                                }
                            echo "</table>";
                        }
                        else echo "No log";

                        echo "<hr>";

                            echo "<b>Доторхи ачаа</b><br>";

                        $result=mysqli_query($conn,"SELECT * FROM container_item WHERE container='".$container_id."'");
                        if (mysqli_num_rows($result) > 0)
                        {	 	
                                $total_weight=$total_payment=$total_pay_in_mongolia=$grandtotalprice=0;
                                // array_push($data,array('Barcode','Илгээгч','Илгээгч дугаар','Хүлээн авагч','Х/а дугаар','Тайлбар','Барааны тайлбар','Барааны үнэ','Хэмжээ','Төлбөр','Монголд Тооцоо'));
                                ?>

                                <table class='table table-hover'>
                                    <thead>
                                        <tr>
                                        <th>№</th>
                                        <th>Barcode / Тайлбар</th>
                                        <th>Илгээгч/ Хүлээн авагч</th>
                                        <th>Хэмжээ</th>
                                        <th>Төлбөр</th>
                                        <th>Монголд Тооцоо</th>
                                        <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                            $count=1;
                                            while ($data=mysqli_fetch_array($result))
                                                {
                                                $item=$data["id"];
                                                $sender=$data["sender"];
                                                $receiver=$data["receiver"];
                                                $description=$data["description"];
                                                $barcode=$data["barcode"];
                                                $weight=$data["weight"];
                                                $payment=$data["payment"];
                                                $pay_in_mongolia=$data["pay_in_mongolia"];
                                                $package=$data["package"];
                                                $total_weight+=$weight;
                                                $total_payment+=$payment;
                                                $total_pay_in_mongolia+=$pay_in_mongolia;

                                                $package_array=explode("##",$package);
                                                $package1_name = $package_array[0];
                                                $package1_num = $package_array[1];
                                                $package1_price = intval($package_array[2]);
                                                $package2_name = $package_array[3];
                                                $package2_num = $package_array[4];
                                                $package2_price = intval($package_array[5]);
                                                $package3_name = $package_array[6];
                                                $package3_num = $package_array[7];
                                                $package3_price = intval($package_array[8]);
                                                $package4_name = $package_array[9];
                                                $package4_num = $package_array[10];
                                                $package4_price = intval($package_array[11]);			

                                                $product_detail ="";
                                                $price =0;
                                                if ($package1_name!="")
                                                    {
                                                        $product_detail.=$package1_name;
                                                        $price+=$package1_price;
                                                    }
                                                if ($package2_name!="")
                                                {
                                                    $product_detail.="/".$package2_name;
                                                    $price+=$package2_price;
                                                }
                                                if ($package3_name!="")
                                                {
                                                    $product_detail.="/".$package3_name;
                                                    $price+=$package3_price;
                                                }
                                                if ($package4_name!="")
                                                {
                                                $product_detail.="/".$package4_name;
                                                $price+=$package4_price;
                                                }
                                                
                                                $grandtotalprice +=$price;
                                                ?>
                                                

                                                    <tr>
                                                        <td><?=$count++;?></td>
                                                        <td>
                                                            <a href="?action=item_detail&id=<?=$item;?>"><?=$barcode;?></a>
                                                            <br><?=$description.$product_detail;?>
                                                        </td>
                                                        <td>
                                                            <a href="customers?action=detail&id=<?=$sender;?>"><?=substr(customer($sender,"surname"),0,2).".".customer($sender,"name");?></a><br>
                                                            <a href="customers?action=detail&id=<?=$receiver;?>"><?=substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name");?></a><br>
                                                        </td>
                                                        <td><?=$weight;?></td>
                                                        <td><?=$payment;?>$</td>
                                                        <td><?=$pay_in_mongolia;?>$</td>
                                                        <td>
                                                            <a href="?action=item_edit&id=<?=$item;?>">Засах</a>
                                                            <a href="?action=item_out&id=<?=$item;?>">Гаргах</a>                                                    
                                                        </td>
                                                    </tr>
                                                    <?
                                                }
                                                ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan='3'>Нийт</td>
                                            <td><?=$total_weight;?>Kg</td>
                                            <td><?=$total_payment;?>$</td>
                                            <td><?=$total_pay_in_mongolia;?>$</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                            </table>
                            <?                            
                        }
                        else echo "No log";
                    }
                    else echo "container id not found";
                }

                if ($action=="edit")
                {                    
                    if (isset($_GET["id"])) 
                    {
                        $container_id = intval($_GET["id"]);
                        $sql = "SELECT * FROM container WHERE container_id=".$container_id;
                        $result = mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)==1)
                        {
                        $data = mysqli_fetch_array($result);
                        $name= $data["name"];
                        $created= $data["created"];
                        $departed= $data["departed"];
                        $description= $data["description"];
                        $expected= $data["expected"];
                        if ($expected=="0000-00-00") $expected="";
                        $status= $data["status"];
                        if ($status=="new")
                        {
                            ?>
                            <form method="post" action="?action=editing">
                                <input type="hidden" name="container_id" value="<?=$container_id;?>">
                                
                                <table class='table table-hover'>
                                <tr><td> Чингэлэгийн дугаар:</td><td><input type="text" name="name" class="form-control" value="<?=$name;?>" placeholder="Жишээ: WLL928374" readonly></td></tr>
                                <tr><td> Монгол очих урьдчилсан огноо:(*)</td><td><input type="text" name="expected" value="<?=$expected;?>" class="form-control" placeholder="Жишээ: 2017-06-02" required="required"></td></tr>
                                <tr><td>Тайлбар:</td><td><textarea name="description" class="form-control"><?=$description;?></textarea></td></tr>
                                <tr><td>Төлөв:</td>
                                    <td>
                                        <select name='status' class='form-control'>
                                            <option value='new' selected='selected'>Америкаас хөдлөөгүй</option>
                                            <option value='onway'>Америкаас гарсан (өөрчлөлт оруулах боломжгүй)</option>
                                        </select>
                                    </td>
                                </tr>
                                </table>
                                <button class="btn btn-success" type="submit">Засах</button>                                                            
                            </form>
                            <a href="?action=delete&id=<?=$container_id;?>" class="btn btn-xs btn-danger">Хоосон чингэлэгийг устгах</a>
                            <?
                        }
                        
                        if ($status=="onway")
                        {
                            ?>
                            <form method="post" action="?action=editing">
                            <input type="hidden" name="container_id" value="<?=$container_id;?>">
                            <table class='table table-hover'>
                                <tr><td> Монгол очих урьдчилсан огноо:(*)</td><td><input type="text" name="expected" value="<?=$expected;?>" class="form-control" placeholder="Жишээ: 2017-06-02" required></td></tr>
                                <tr><td>Тайлбар:</td><td><textarea name="description" class="form-control"><?=$description;?></textarea></td></tr>
                            </table>
                            <button class="btn btn-success" type="submit">Засах</button>                                                            
                            </form> 
                            <?

                        }
                        //else echo '<div class="alert alert-danger" role="alert">Чинэглэгийн төлөв засаж болохгүй төлөвт байна</div>';
                        }
                        else echo '<div class="alert alert-danger" role="alert">Чинэглэгийн дугаар алдаатай байна</div>';
                    }
                    else echo "container id not found";
                    
                }

                if ($action=="editing")
                {
                    if (isset($_POST["container_id"])) 
                    {
                        $container_id = intval($_POST["container_id"]);
                        $sql = "SELECT * FROM container WHERE container_id='".$container_id."'";
                        $result = mysqli_query($conn,$sql);
                        if (mysqli_num_rows($result)==1)
                        {
                            $data = mysqli_fetch_array($result);
                            $status= $data["status"];
                            if ($status=="new")
                                {
                                    $expected= $_POST["expected"];
                                    $description=  $_POST["description"];
                                    $new_status=  $_POST["status"];
                                    $sql = "UPDATE container SET expected='$expected', description='$description' WHERE container_id='$container_id'";

                                    if (mysqli_query($conn,$sql)) 
                                        echo "Амжилттай заслаа.<br>";
                                        else echo "ERROR:".mysqli_error($conn);

                                    if ($new_status=="onway")
                                        {
                                            $sql = "UPDATE container SET status='$status', departed='".date("Y-m-d")."',status='onway', onway_date='".date("Y-m-d")."' WHERE container_id='$container_id'";
                                            
                                            if (mysqli_query($conn,$sql)) 
                                            echo "Амжилттай төлөв өөрчиллөө.<br>";
                                            else echo "ERROR:".mysqli_error($conn);

                                        }
                                }

                            if ($status=="onway")
                                {
                                    $expected= $_POST["expected"];
                                    $description=  $_POST["description"];
                                    $sql = "UPDATE container SET expected='$expected', description='$description' WHERE container_id='$container_id'";

                                    if (mysqli_query($conn,$sql)) 
                                        echo "Амжилттай заслаа.<br>";
                                        else echo "ERROR:".mysqli_error($conn);

                                }
                        }
                        else echo '<div class="alert alert-danger" role="alert">Чинэглэгийн дугаар алдаатай байна</div>';
                    }
                    else echo '<div class="alert alert-danger" role="alert">container id not found</div>';
                    ?>
                    <a href="?action=detail&id=<?=$container_id;?>" class="btn btn-success">Дэлгэрэнгүй</a>
                    <?
                }

                if ($action=="create")
                {
                    ?>
                    <form action="?action=creating" method="post">
                        <table class='table table-hover'>
                        <tr><td> Чингэлэгийн дугаар:</td><td>Өнөөдрийн огноогоор үүснэ</td></tr>
                        <tr><td>Тайлбар:</td><td><textarea class="form-control" name="description"></textarea></td></tr>
                        </table>
                        <button type="submit" class="btn btn-success">Add</button>
                    </form>
                    <?
                    
                }

                if ($action=="creating")
                {
                    $name=date("Y.m.d");
                    $description=$_POST["description"];
                    $sql = "INSERT INTO container (name,created,description,agent,status) VALUES ('$name','".date('Y-m-d H:i:s')."','$description','$g_agent_logged_id','new')";

                       if(mysqli_query($conn,$sql)) 
                            {
                                $container= mysqli_insert_id($conn);
                                echo '<div class="alert alert-success">Амжилттай нэмэгдлээ</div>';
                                echo '<a href="?action=put&id='.$container.'" class="btn btn-primary btn-xs">Ачаа оруулах</a>';
                            }
                            else 
                            echo '<div class="alert alert-danger" role="alert">Алдаа гарлаа</div>';


                }

                if ($action=="delete")
                {
                    $container_id = intval($_GET["id"]);
                    $sql = "SELECT * FROM container_item WHERE container=".$container_id;
                    $result = mysqli_query($conn,$sql);
                    if (mysqli_num_rows($result)> 0)
                    echo '<div class="alert alert-danger" role="alert">Чингэлэгт ачаа байна. Чингэлэгээс ачааг бүгдийг гаргаж байгаад устгах боломжтой</div>';

                    if (mysqli_num_rows($result) == 0) // Чингэлэгт ачаа байхгүй устгаж болно
                    {
                    if (mysqli_query($conn,"DELETE FROM container WHERE container_id=".$container_id)) 
                    echo '<div class="alert alert-success" role="alert">Амжилттай устгалаа</div>';
                    else echo '<div class="alert alert-danger" role="alert">Error:'.mysqli_error($conn).'</div>';
                    }
                }


                if ($action=="insert")
                {
                    if (isset($_GET["id"])) $container_id = intval($_GET["id"]); else $container_id=0;

                    ?>
                    <div class="panel panel-primary">
                    <div class="panel-heading">Чингэлэгийн ачаа үүсгэх</div>
                    <div class="panel-body">
                    <form action="?action=inserting" method="post">
                        <input type="hidden" name="container_id" value="<?=$container_id;?>">

                    <? 
                        echo "<table class='table table-hover'>";

                        echo "<tr><th colspan='2'><h4>Илгээгч</h4></th></tr>";
                        echo "<tr><td>Утас:(*)</td><td><input type='text' name='sender_contact' class='form-control' required></td></tr>";
                        echo "<tr><td colspan='2'><span id='sender_result' class='alert alert-danger small' role='alert'></span></td></tr>";
                        echo "<tr><td>Нэр(*)</td><td><input type='text' name='sender_name' class='form-control'></td></tr>";
                        echo "<tr><td>Овог</td><td><input type='text' name='sender_surname' class='form-control'></td></tr>";
                        echo "<tr><td>И-мейл(*)</td><td><input type='text' name='sender_email' class='form-control'></td></tr>";
                        echo "<tr><td>Хаяг(*)</td><td><input type='text' name='sender_address' class='form-control'></td></tr>";

                        echo "<tr><th colspan='2'><h4>Хүлээн авагч</h4></th></tr>";
                        echo "<tr><td>Утас:(*)</td><td><input type='text' name='receiver_contact' class='form-control' required>";
                        echo "<span id='receiver_result' class='alert alert-danger' role='alert'></span></td></tr>";
                        echo "<tr><td>Нэр(*)</td><td><input type='text' name='receiver_name' class='form-control'></td></tr>";
                        echo "<tr><td>Овог</td><td><input type='text' name='receiver_surname' class='form-control'></td></tr>";
                        echo "<tr><td>И-мейл(*)</td><td><input type='text' name='receiver_email' class='form-control'></td></tr>";
                        echo "<tr><td>Хаяг(*)</td><td><input type='text' name='receiver_address' class='form-control'></td></tr>";




                        echo "<tr><td>Барааны тайлбар</td><td>";
                            echo "<table class='table table-hover'>";
                            echo "<tr>";
                            echo "<td><input type='text' name='package1_name' class='form-control' placeholder='Цамц, Цүнх, Утас г.м' required></td>";
                            echo "<td><input type='text' name='package1_num' class='form-control' placeholder='Тоо ширхэг'></td>";
                            echo "<td><input type='text' name='package1_price' class='form-control' placeholder='Үнэ ($)'></td>";
                            echo "</tr>";
                            
                            echo "<tr>";
                            echo "<td><input type='text' name='package2_name' class='form-control' placeholder='Цамц, Цүнх, Утас г.м'></td>";
                            echo "<td><input type='text' name='package2_num' class='form-control' placeholder='Тоо ширхэг'></td>";
                            echo "<td><input type='text' name='package2_price' class='form-control' placeholder='Үнэ ($)'></td>";
                            echo "</tr>";
                            
                            echo "<tr>";
                            echo "<td><input type='text' name='package3_name' class='form-control' placeholder='Цамц, Цүнх, Утас г.м'></td>";
                            echo "<td><input type='text' name='package3_num' class='form-control' placeholder='Тоо ширхэг'></td>";
                            echo "<td><input type='text' name='package3_price' class='form-control' placeholder='Үнэ ($)'></td>";
                            echo "</tr>";

                            echo "<tr>";
                            echo "<td><input type='text' name='package4_name' class='form-control' placeholder='Цамц, Цүнх, Утас г.м'></td>";
                            echo "<td><input type='text' name='package4_num' class='form-control' placeholder='Тоо ширхэг'></td>";
                            echo "<td><input type='text' name='package4_price' class='form-control' placeholder='Үнэ ($)'></td>";
                            echo "</tr>";

                            echo "</table>";


                        echo "<tr><td>Тайлбар: (*)</td><td><textarea name='description' class='form-control'></textarea></td></tr>";

                       
                        echo "<tr><td>Нийт жин эсвэл хэмжээ /кг/(*)</td><td><input type='text' class='form-control' name='weight' id='weight' required></td></tr>";


                        echo "<tr><td>Авсан төлбөр/$/</td><td><input type='text' class='form-control' name='payment' ></td></tr>";

                        echo "<tr><td>Монголд авах төлбөр/$/</td><td><input type='text' class='form-control' name='pay_in_mongolia' ></td></tr>";
                        echo "</td>";
                        echo "</tr>";

                        /*echo "<div class='more'>";
                        echo "<div class='box'>";
                        echo "<h4 class='legend'>Илгээмж явах хэлбэр</h4>";
                        echo "<span class='formspan'>Агаараар</span>";
                        echo form_radio('way', 'air', TRUE)."<br>";
                        echo "<span class='formspan'>Газраар</span>";
                        echo form_radio('way', 'surface', FALSE)."<br>";
                        echo "<span class='formspan'>Хосолсон</span>";
                        echo form_radio('way', 'sal', FALSE)."<br>";
                        echo "<h4>Хүргэлтийн хэлбэр</h4>";
                        echo "<span class='formspan'>Express</span>";
                        echo form_radio('deliver_time', 'express', TRUE)."";
                        echo "<span class='formspan'>Advice of delivery</span>";
                        echo form_radio('deliver_time', 'advice', FALSE)."<br>";
                        echo "</div>";



                        echo "<div class='box'>";
                        echo "<h4 class='legend'>Илгээмж доторхи зүйл</h4>";
                        echo form_radio('Package_inside', 'gift',  TRUE);
                        echo "Бэлэг<br>";
                        echo form_radio('Package_inside', 'sample', FALSE);
                        echo "Арилжааны шинж чанаргүй загвар<br>";
                        echo form_radio('Package_inside', 'document', FALSE);
                        echo "Арилжааны шинж чанаргүй бичиг баримт<br>";
                        echo "</div>";


                        echo "<div class='box'>";
                        echo "<h4 class='legend'>Даатгал</h4>";
                        echo "<span class='formspan'>Даатгалтай</span>";
                        echo form_checkbox('insurance', '1')."<br>";
                        echo "<span class='formspan'>Даатгалын төлбөр</span>";
                        echo form_input('insurance_value', '');
                        echo "</div>";


                        echo "<div class='box'>";
                        echo "<h4 class='legend'>Хүргэгдээгүй тохиолдолд</h4>";
                        echo form_radio('Package_return_type', 'return_1',  TRUE);
                        echo "Явуулагч талруу яаралтай буцаах<br>";
                        echo form_radio('Package_return_type', 'return_2',  FALSE);
                        echo "Явуулагч талруу __ өдрийн дараа буцаах";
                        echo " Өдөр";
                        echo form_input('Package_return_day', '')."<br>";
                        echo form_radio('Package_return_type', 'return_3',  TRUE);
                        echo "Өөр хаягруу явуулах"."<br>";
                        echo "Өөр хаяг";
                        echo form_textarea ("Package_return_address","")."<br>";
                        echo form_radio('Package_return_type', 'return_4',  FALSE);
                        echo "Тэнд нь устгах<br>";
                        echo "<h4>Буцах хаягруу явуулах</h4>";
                        echo "<span class='formspan'>Агаараар</span>";
                        echo form_radio('Package_return_way', 'air',  TRUE);
                        echo "<span class='formspan'>Газраар</span>";
                        echo form_radio('Package_return_way', 'surface',  FALSE);
                        echo "</div>";

                        echo "</div>";  //MORE DIV CLOSE


                        echo "<span id='more_toggle'>more</span>";*/
                        echo "</table>";
                    ?>
                        <button type="submit" class="btn btn-success">нэмэх</button>                     
                    </form>
                    <?
                }

                if ($action=="inserting")
                {
                    $container_id=$_POST["container_id"];

                    $result = mysqli_query($conn,"SELECT * FROM container WHERE container_id=".$container_id);
                    if (mysqli_num_rows($result)==1)
                        {
                        $data = mysqli_fetch_array($result);
                        $name= 	$data["name"];
                        $created= 	$data["created"];
                        $departed= 	$data["departed"];
                        $expected= 	$data["expected"];
                        $description= 	$data["description"];
                        $status= 	$data["status"];
                        echo "<b>".$name."</b><br>";
                        echo "Үүсгэсэн огноо:".$created."<br>";
                        echo "Төлөв:".$status."<br>";
                        echo "Америкаас гарсан огноо:".$departed."<br>";
                        echo "Монголд очих огноо:".$expected."<br>";
                        echo "<p>".$description."</p>";
                        }
                        else { $container_id=0; $status="new";}

                                
                    if ($status=="new")
                    {    
                        /* SENDER */
                        $sender_contact = $_POST["sender_contact"];
                        $sender_name = $_POST["sender_name"];
                        $sender_surname = $_POST["sender_surname"];
                        $sender_email = $_POST["sender_email"];
                        $sender_address = $_POST["sender_address"];

                        $query_sender = mysqli_query($conn,'SELECT customer_id FROM customer WHERE tel="'.$sender_contact.'"');
                        if (mysqli_num_rows($query_sender)==0&&$sender_contact!="")
                            {	
                            mysqli_query($conn,"INSERT INTO customer (name,surname,tel,email,address,username,password,status) VALUES ('$sender_name','$sender_surname','$sender_contact','$sender_email','$sender_address','$sender_contact','$sender_contact','regular')");                    
                            $sender_id=mysqli_insert_id($conn)  ;
                            }
                        else {
                            $data = mysqli_fetch_array($query_sender);
                            $sender_id = $data["customer_id"];

                            // $row=$query_sender->row();
                            // $sender_id=$data["customer_id;
                            // $data = array(
                            //     'name'=>$sender_name,
                            //     'surname'=>$sender_surname,
                            //     'email'=>$sender_email,
                            //     'address'=>$sender_address,
                            //     );
                            // $this->db->where('customer_id', $sender_id);
                            // $this->db->update('customer', $data);
                            }	
                        //if (!isset($sender_id)) $sender_id =1;
                        /* RECEIVER */
                        $receiver_contact = $_POST["receiver_contact"];
                        $receiver_name = $_POST["receiver_name"];
                        $receiver_surname = $_POST["receiver_surname"];
                        $receiver_email = $_POST["receiver_email"];
                        $receiver_address = $_POST["receiver_address"];
                        $query_receiver = mysqli_query($conn,'SELECT customer_id FROM customer WHERE tel="'.$receiver_contact.'"');
                        
                        if (mysqli_num_rows($query_receiver)==0&&$receiver_contact!="")
                            {	
                                mysqli_query($conn,"INSERT INTO customer (name,surname,tel,email,address,username,password,status) 
                                VALUES ('$receiver_name','$receiver_surname','$receiver_contact','$receiver_email','$receiver_address','$receiver_contact','$receiver_contact','regular')");                    
                                $receiver_id=mysqli_insert_id($conn)  ;
        
                            }
                        else {
                            $data = mysqli_fetch_array($query_receiver);
                            $receiver_id = $data["customer_id"];
                            // $row=$query_receiver->row();
                            // $receiver_id=$data["customer_id;
                            // $data = array(
                            //     'name'=>$receiver_name,
                            //     'surname'=>$receiver_surname,
                            //     'email'=>$receiver_email,
                            //     'address'=>$receiver_address,
                            //     );
                            // $this->db->where('customer_id', $receiver_id);
                            // $this->db->update('customer', $data);
                            }	
                        


                        $created_date = date("Y-m-d H:i:s");
                        /* Package */
                        $package1_name=$_POST["package1_name"];
                        $package1_num =$_POST["package1_num"];
                        $package1_price =intval($_POST["package1_price"]);
                        $package2_name=$_POST["package2_name"];
                        $package2_num =$_POST["package2_num"];
                        $package2_price =intval($_POST["package2_price"]);
                        $package3_name=$_POST["package3_name"];
                        $package3_num =$_POST["package3_num"];
                        $package3_price =intval($_POST["package3_price"]);
                        $package4_name=$_POST["package4_name"];
                        $package4_num =$_POST["package4_num"];
                        $package4_price =intval($_POST["package4_price"]);
                        
                        $package_array = array(
                        $package1_name, $package1_num,$package1_price,
                        $package2_name, $package2_num,$package2_price,
                        $package3_name, $package3_num,$package3_price,
                        $package4_name, $package4_num,$package4_price
                        );
                        
                        $package =implode("##",$package_array);
                        $package_price = $package1_price + $package2_price + $package3_price + $package4_price;

                        $description=$_POST["description"];
                        $weight=$_POST["weight"];
                        $payment=$_POST["payment"];
                        $pay_in_mongolia=$_POST["pay_in_mongolia"];


                        $barcode='CO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
                        do {
                        $barcode='CO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
                        $query = mysqli_query($conn,"SELECT barcode FROM container_item WHERE barcode='$barcode'");
                        } while (mysqli_num_rows($query) == 1); 
                        $agent_id=$g_agent_logged_id;

                        
                        
                        $sql = "INSERT INTO container_item (barcode,container,sender,receiver,description,package,weight,payment,pay_in_mongolia,agent,owner,status) 
                        VALUES ('$barcode','$container_id','$sender_id','$receiver_id','$description','$package','$weight','$payment','$pay_in_mongolia',$agent_id,2,'new')";
                            
                        if (mysqli_query($conn,$sql)) 
                        {
                        $item_id=mysqli_insert_id($conn);	
                        echo '<div class="alert alert-success" role="alert">Чингэлэгт ачаа орууллаа</div>';
                        // log_write("Container-t ачаа нэмэв id =$item_id ".json_encode($data)," container item added");
                        echo "<a href='container_cp72?id=".$item_id."' target='new' class='btn btn-primary'>CP72 хэвлэх</a>";
                        echo "<a href='container_item_print?id=".$item_id."' target='new' class='btn btn-warning'>Пайз хэвлэх</a>";
                        }
                        else echo '<div class="alert alert-danger" role="alert">Error:'.mysqli_error($conn).'</span>';
                    }
                    else echo '<div class="alert alert-danger" role="alert">Чинэглэгийн төлөв засаж болохгүй төлөвт байна</div>';

                }

                if ($action=="fill")
                {
                    if (isset($_GET["message"]))
                    {
                        $message = $_GET["message"];
                        ?>
                        <div class="alert <?=$message=="ok"?'alert-success':'alert-danger';?>"><?=$message;?></div>
                        <?
                    }

                    if (isset($_GET["id"])) $container_id=intval($_GET["id"]); else $container_id=0; 
                    if (isset($_POST["container"])) $container_id=intval($_POST["container"]);

                    
                    if ($container_id==0)
                    {
                        ?>
                        <form action="?action=fill" id="select_container" method="post">
                            <table class='table table-hover'>
                            <tr><th colspan='2'><h4>Бэлэн чингэлэг</h4></th></tr>
                            <tr><td>Чингэлэг:(*)</td><td>
                            <select name='container' class='form-control'>
                            <?
                            $result = mysqli_query($conn,"SELECT * FROM container WHERE status='new' ORDER BY container_id DESC");
                            while ($data = mysqli_fetch_array($result))
                              {
                                  ?>
                                  <option value="<?=$data["container_id"];?>"><?=$data["name"];?></option>
                                  <?
                              }
                              ?>
                            </select>
                            </td></tr>
                            </table>
                        <button type="submit" class="btn btn-success">Ачаа оруулах</button>
                        </form>
                        <?
                    }
                    ?>

                    <? 
                    if ($container_id!=0)
                    {	
                        $result = mysqli_query($conn,"SELECT * FROM container WHERE container_id=".$container_id);
                        if (mysqli_num_rows($result)==1)
                            {
                                $data = mysqli_fetch_array($result);
                                $name = $data["name"];
                                $created = $data["created"];
                                $departed =	$data["departed"];
                                $expected =	$data["expected"];
                                $description = $data["description"];
                                $status = $data["status"];

                                echo "<h1>".$name;	
                                if ($status=="new") echo '<a href="?action=edit&id='.$container_id.'" class="btn btn-success btn-xs">засах</a></h1>';

                                echo "Үүсгэсэн огноо:".$created."<br>";
                                echo "Төлөв:".$status."<br>";
                                echo "Америкаас гарсан огноо:".$departed."<br>";
                                echo "Монголд очих огноо:".$expected."<br>";
                                echo "<p>".$description."</p>";
                                if ($status="new")
                                {
                                    ?>
                                    <form action="?action=filling" method="POST">
                                        <input type="hidden" name="container_id" value="<?=$container_id;?>">

                                        <h4 class='legend'>Track or Barcode</h4>
                                        <input type="text" name="barcode" value="" class="form-control" placeholder="CO1712249999MN">

                                        <!-- if ($this->uri->segment(4)=="already") echo $this->uri->segment(5)." хайрцагт байна."; -->
                                        <!-- else echo $this->uri->segment(4); -->
                                        <br>

                                        <button type="submit" class="btn btn-success">Оруулах</button>
                                    </form>
                                    <?
                                }
                                else echo "Контайнерийн төлөв шинэ биш байна.";
                            // echo "<br><br><div id=\"result\"></div><br>";
                            }
                        else echo "Контайнерийн дугаар алдаатай байна.";			
                    }
                    

                }

                if ($action=="filling")
                {
                    if (isset($_POST["container_id"])) $container_id = $_POST["container_id"];  else header("Location:agents/container_fill");
                    if (isset($_POST["barcode"])) $barcode = strtoupper($_POST["barcode"]); else header("Location:agents/container_fill");

                    if ($container_id!="" && $barcode!="")
                    {
                        $result =mysqli_query($conn,"SELECT * FROM container WHERE container_id=".$container_id);
                        if (mysqli_num_rows($result)==1)
                            {
                                $data = mysqli_fetch_array($result);
                                $container_status =	$data["status"];
                                if ($container_status=="new")
                                {

                                    $result =mysqli_query($conn,"SELECT * FROM container_item WHERE barcode='".$barcode."' OR track='".$barcode."'");
                                    if (mysqli_num_rows($result)==1)
                                    {
                                        $data = mysqli_fetch_array($result);
                                        $item_id = $data["id"];
                                        $status = $data["status"];                                

                                        $current_container = $data["container"];

                                        if ($current_container==0 && $status=="new")
                                            {
                                                mysqli_query($conn,"UPDATE container_item SET container=$container_id WHERE id='".$item_id."'");
                                                header("Location:?action=fill&id=".$container_id."&message=ok");
                                                
                                            }
                                            else header("Location:?action=fill&id=".$container_id."&message=item_cant_change_due_to_its_status");
                                        }
                                        
                                    }
                                    else//echo '<div class="alert alert-danger" role="alert">Barcode not found</div>';
                                    header("Location:?action=fill&id=".$container_id."&message=container_not_new");
                            }
                            else//echo '<div class="alert alert-danger" role="alert">Barcode not found</div>';
                            header("Location:?action=fill&id=".$container_id."&message=container_not_found");

                    }
                    else //echo '<div class="alert alert-danger" role="alert">Barcode, хайрцаг оруулаагүй байна.</div>';
                    header("Location:?action=fill&id=".$box_id."&message=no_inputs");
                }

                if ($action =="outside")
                {
                    $result=mysqli_query($conn,"SELECT * FROM container_item WHERE container=0 ORDER BY id DESC");
                    if (mysqli_num_rows($result) > 0)
                        {	 
                        echo "<table class='table table-hover'>";
                        echo "<tr>";
                        echo "<th>№</th>"; 
                        echo "<th>Barcode / Тайлбар</th>"; 
                        echo "<th>Илгээгч/ Хүлээн авагч</th>";
                        echo "<th>Жин</th>";
                        echo "<th>Төлбөр</th>";
                        echo "<th>Монголд Тооцоо</th>"; 
                        echo "<th>Төлөв</th>"; 
                        echo "</tr>";
                        $count=1;
                        while ($data = mysqli_fetch_array($result))
                            {
                            $item=$data["id"]; 
                            $sender=$data["sender"];
                            $receiver=$data["receiver"];
                            $description=$data["description"];
                            $barcode=$data["barcode"];
                            $weight=$data["weight"];
                            $payment=$data["payment"];
                            $pay_in_mongolia=$data["pay_in_mongolia"];
                            $status=$data["status"];
                        
                            echo "<tr>";
                                    echo "<td>".$count++."</td>";
                                    echo "<td><a href='?action=item_detail&id=$item'>$barcode</a><br>".$description."</td>";
                                    echo "<td>";
                                    echo "<a href='customers?action=detail&id=$sender'>".substr(customer($sender,"surname"),0,2).".".customer($sender,"name")."</a><br>";
                                    echo "<a href='customers?action=detail&id=$receiver'>".substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name")."</a>";
                                    echo "</td>";
                                    echo "<td>".$weight."</td>";
                                    echo "<td>".$payment."$</td>";
                                    echo "<td>".$pay_in_mongolia."$</td>";
                                    echo "<td>".$status."</td>";
                            echo "</tr>";
                            }
                        echo "</table>";
                    } 
                }

                if ($action=="item_detail")
                {                    
                    if (isset($_GET["id"])) 
                    {
                        $item_id = intval($_GET["id"]);
                        $result = mysqli_query($conn,"SELECT * FROM container_item WHERE id=".$item_id);
                        if (mysqli_num_rows($result)==1)
                        {
                            $data = mysqli_fetch_array($result);
                            $sender=$data["sender"];
                            $receiver=$data["receiver"];
                            $description = $data["description"];
                            $weight=$data["weight"];
                            $payment=$data["payment"];
                            $pay_in_mongolia=$data["pay_in_mongolia"];
                            $container_id=$data["container"];
                            
                            $created_date=$data["created_date"];
                            $onway_date=$data["onway_date"];
                            $warehouse_date=$data["warehouse_date"];
                            $delivered_date=$data["delivered_date"];
                            
                            
                            $barcode=$data["barcode"];
                            $track=$data["track"];
                            $package=$data["package"];

                            $sender=$data["sender"];
                            $receiver=$data["receiver"];
                            $deliver=$data["deliver"];
                            $container = $data["container"];
                            $expected_date=$data["expected_date"];
                            $description = $data["description"];
                            $status=$data["status"];
                            $agents=$data["agent"];
                            $is_online=$data["is_online"];
                            $transport=$data["transport"];
                            $item_status = $data["status"];
                            $container_description=$data["container_description"];

                            //$proxy_type = $data["proxy_type;
                            $package_array =$data["package"];
                            if ($package_array!="")
                            {
                                $package_array=explode("##",$package);
                                    $package1_name = $package_array[0];
                                    $package1_num = $package_array[1];
                                    $package1_price = $package_array[2];
                                    $package2_name = $package_array[3];
                                    $package2_num = $package_array[4];
                                    $package2_price = $package_array[5];
                                    $package3_name = $package_array[6];
                                    $package3_num = $package_array[7];
                                    $package3_price = $package_array[8];
                                    $package4_name = $package_array[9];
                                    $package4_num = $package_array[10];
                                    $package4_price = $package_array[11];
                            }


                            if ($container_id!=0)
                                {
                                $result_container = mysqli_query($conn,"SELECT * FROM container WHERE container_id=".$container_id);
                                $data_container = mysqli_fetch_array($result_container);
                                $name= 	$data_container["name"];
                                $created= 	$data_container["created"];
                                $departed= 	$data_container["departed"];
                                $expected= 	$data_container["expected"];
                                $description_container= 	$data_container["description"];
                                $status= 	$data_container["status"];
                                echo "<b>".$name."</b><br>";
                                echo "Үүсгэсэн огноо:".$created."<br>";
                                echo "Төлөв:".$status."<br>";
                                echo "Америкаас гарсан огноо:".$departed."<br>";
                                echo "Монголд очих огноо:".$expected."<br>";
                                echo "<p>".$description_container."</p>";
                                }


                            echo "<table class='table table-hover'>";		
                            echo "<tr><td>Хэрэглэгчийн тайлбар</td><td>".$container_description."</td></tr>";
                            echo "<tr><td>Barcode</td><td>".$barcode."</td></tr>";
                            if ($track!="")
                            echo "<tr><td>Track</td><td>".$track."</td></tr>";
                            
                            //echo "<tr><td>Үүсгэсэн</td><td>".$created_date."</td></tr>";
                            if ($onway_date!="0000-00-00 00:00:00")
                            echo "<tr><td>Америкаас наашаа гарсан</td><td>".$onway_date."</td></tr>";
                            if ($warehouse_date!="0000-00-00 00:00:00")
                            echo "<tr><td>Агуулахад ирсэн</td><td>".$warehouse_date."</td></tr>";
                            echo "<tr><td>Илгээгч</td><td>".customer($sender,"full_name")."</td></tr>";
                            echo "<tr><td>Хүлээн авагч</td><td>".customer($receiver,"full_name")."</td></tr>";
                            //if ($proxy!=0) echo "<tr><td>Хэн авах</td><td>".proxy2($proxy,$proxy_type,"name")."</td></tr>" ;
                            if ($item_status=='delivered')
                            echo "<tr><td>Гардан авсан (огноо)</td><td>".customer($deliver,"full_name")." (".$delivered_date.")</td></tr>";
                            if ($item_status=='new')
                                {
                                    echo "<tr><td>Төлсөн</td><td>".$payment."кг</td></tr>";
                                    echo "<tr><td>Монголд төлөх</td><td>".$pay_in_mongolia."кг</td></tr>";
                                }
                            if ($item_status=='weight_missing')
                            echo "<tr><td>Төлөв</td><td>Америкт хүргэгдээгүй</td></tr>";



                            echo "<tr><td>Чингэлэг</td><td>";
                                if ($container==0)  echo "Одоогоор чингэлэгт ороогүй байна";
                                if ($container!=0) 
                                    {
                                        $query = mysqli_query($conn,"SELECT * FROM container WHERE container_id=".$container_id);
                                        $data = mysqli_fetch_array($result);
                                        echo $data["name"]." ирэх хугацаа: ".$data["expected"];
                                    }
                            echo "</td></tr>";
                            if (isset($package1_name) && $package1_name!="")
                            echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package1_name ($package1_num) - $package1_price $</td></tr>";
                            if (isset($package2_name) && $package2_name!="")
                            echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package2_name ($package2_num) - $package2_price $</td></tr>";
                            if (isset($package3_name) && $package3_name!="")
                            echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package3_name ($package3_num) - $package3_price $</td></tr>";
                            if (isset($package4_name) && $package4_name!="")
                            echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package4_name ($package4_num) - $package4_price $</td></tr>";

                            if ($description!="") echo "<tr><td>Нэмэлт тайлбар</td><td>$description</td></tr>";

                            echo "<tr><td>Төлөв</td><td>".status_comfort($status)."</td></tr>";
                            echo "</table>";

                            if ($item_status=="new")
                            {
                                ?>
                                <a href="container_cp72?id=<?=$item_id;?>" target="new" class="btn btn-primary">CP72 хэвлэх</a>
                                <a href="container_item_print?id=<?=$item_id;?>" target="new" class="btn btn-warning">Пайз хэвлэх</a>
                                <?
                            }

                            if ($item_status=='weight_missing')
                            {
                                ?>
                                <a href="?action=item_price&id=<?=$item_id;?>" class="btn btn-success">Үнэ оруулах</a><br>
                                <?
                            }

                            if ($status=='weight_missing')
                            {
                                ?>
                                <a href="?action=item_delete&id=<?=$item_id;?>" class="btn btn-danger btn-xs">Устгах</a><br>
                                <a href="?action=item_edit&id=<?=$item_id;?>" class="btn btn-warning btn-xs">Засах</a><br>
                                <?
                            }                            
                            

                        }
                        else echo '<div class="alert alert-danger" role="alert">Ачааны дугаар алдаатай байна</div>';

                    }
                    else echo "item id not found";
                }

                if ($action=="item_delete")
                {
                    if (isset($_GET["id"])) 
                    {
                        $item_id = intval($_GET["id"]);
                        $result = mysqli_query($conn,"SELECT * FROM container_item WHERE id=".$item_id);
                        if (mysqli_num_rows($result)==1)
                        {
                            $data = mysqli_fetch_array($result);
                            if ($data["status"]=="weight_missing" && $data["owner"]==2 && $data["agent"] == $g_agent_logged_id)
                                    {
                                        $sql="DELETE FROM container_item WHERE id=$item_id";
                                        if (mysqli_query($conn,$sql))
                                        {
                                        echo '<div class="alert alert-success" role="alert">Ачааг устгалаа.</div>';
                                        // $this->db->query("UPDATE customer SET cent=cent-1 WHERE customer_id='$customer_id'");
                                        }
                                        else echo '<div class="alert alert-danger" role="alert">Ачааг устгахад алдаа гарлаа.</div>';
                                    }
                                    else //$row->status=="weight_missing"
                                    echo '<div class="alert alert-danger" role="alert">Ачаа таны оруулсан ачаа биш учираас устгах боломжгүй.</div>';
                        }
                        else echo '<div class="alert alert-danger" role="alert">Ачааны дугаар алдаатай байна</div>';
                    }
                    else echo "item id not found";
                }

                if ($action=="item_price")
                {
                    if (isset($_GET["id"])) 
                    {
                        $item_id = intval($_GET["id"]);
                        $result = mysqli_query($conn,"SELECT * FROM container_item WHERE id=".$item_id);
                        if (mysqli_num_rows($result)==1)
                        {
                            $data = mysqli_fetch_array($result);
                            $sender=$data["sender"];
                            $receiver=$data["receiver"];
                            $description = $data["description"];
                            $weight=$data["weight"];
                            $payment=$data["payment"];
                            $pay_in_mongolia=$data["pay_in_mongolia"];
                            $container_id=$data["container"];
                            $status=$data["status"];
                           
                            if ((isset($status) && $status=="new") || $container_id==0)
                            {
                                ?>
                                <form action="?action=item_pricing" method="post">
                                    <input type="hidden" name="item_id" value="<?=$item_id;?>">
                                    <table class='table table-hover'>
                                    <tr><td>Авсан төлбөр/$/ (*)</td><td><input type="text" name="payment" value="<?=$payment;?>" class="form-control" required></td></tr>
                                    <tr><td>Монголд авах төлбөр/$/ (*)</td><td><input type="text" name="pay_in_mongolia" value="<?=$pay_in_mongolia;?>" class="form-control" required></td></tr>
                                    <tr><td>Жин, хэмжээ, тоо ширхэг</td><td><input type="text" name="weight" value="<?=$weight;?>" class="form-control" id="weight"></td></tr>
                                    </table>
                                    <button type="submit" class="btn btn-success">Засах</button>
                                </form>
                                <?
                            }
                            else echo '<div class="alert alert-danger" role="alert">Чинэглэгийн төлөв засаж болохгүй төлөвт байна</div>';
                        }
                        else echo '<div class="alert alert-danger" role="alert">Ачааны дугаар алдаатай байна</div>';
                    }
                    else echo "item id not found";
                }

                if ($action=="item_pricing")
                {
                    if (isset($_POST["item_id"])) 
                    {
                        $item_id = intval($_POST["item_id"]);
                        $result = mysqli_query($conn,"SELECT * FROM container_item WHERE id=".$item_id);
                        if (mysqli_num_rows($result)==1)
                        {
                            $data = mysqli_fetch_array($result);
                            $sender=$data["sender"];
                            $receiver=$data["receiver"];
                            $description = $data["description"];
                            $weight=$data["weight"];
                            $payment=$data["payment"];
                            $pay_in_mongolia=$data["pay_in_mongolia"];
                            $container_id=$data["container"];
                            $status=$data["status"];
                           
                            if ((isset($status) && $status=="new") || $container_id==0)
                            {
                                $weight=$_POST["weight"];
                                $payment=$_POST["payment"];
                                $pay_in_mongolia=$_POST["pay_in_mongolia"];
                                if ($payment>0 || $pay_in_mongolia>0) 
                                    if ($status=="weight_missing") $status= "new";
                                $sql = "UPDATE container_item SET 
                                price_date='".date("Y-m-d H:i:s")."',
                                weight='$weight',
                                payment='$payment',
                                pay_in_mongolia = '$pay_in_mongolia',
                                status='$status' 
                                WHERE id='$item_id'";
                                if (mysqli_query($conn,$sql))
                                {		
                                    ?>  
                                    <div class="alert alert-success" role="alert">Чингэлэгийн ачааг үнийг орууллаа</div>
                                    <a href="container_cp72?id=<?=$item_id;?>" target="new" class="btn btn-primary">CP72 хэвлэх</a>
                                    <a href="container_item_print?id=<?=$item_id;?>" target="new" class="btn btn-warning">Пайз хэвлэх</a>
                                    <?
                                }
                            }
                            else echo '<div class="alert alert-danger" role="alert">Чинэглэгийн төлөв засаж болохгүй төлөвт байна</div>';
                        }
                        else echo '<div class="alert alert-danger" role="alert">Ачааны дугаар алдаатай байна</div>';
                    }
                    else echo "item id not found";
                }

                if ($action=="item_edit")
                {                    
                    if (isset($_GET["id"])) 
                    {
                        $item_id = intval($_GET["id"]);
                        $result = mysqli_query($conn,"SELECT * FROM container_item WHERE id=".$item_id);

                        echo "SELECT * FROM container_item WHERE id=".$item_id;

                        if (mysqli_num_rows($result)==1)
                        {
                            ?>
                            <form action="?action=item_editing" method="POST">
                                <input type="hidden" name="item_id" value="<?=$item_id;?>">
                                <?
                                $data = mysqli_fetch_array($result);
                                $sender=$data["sender"];
                                $receiver=$data["receiver"];
                                $description = $data["description"];
                                $weight=$data["weight"];
                                $payment=$data["payment"];
                                $pay_in_mongolia=$data["pay_in_mongolia"];
                                $container_id=$data["container"];
                                
                                $created_date=$data["created_date"];
                                $onway_date=$data["onway_date"];
                                $warehouse_date=$data["warehouse_date"];
                                $delivered_date=$data["delivered_date"];
                                
                                
                                $barcode=$data["barcode"];
                                $track=$data["track"];
                                $package=$data["package"];

                                $sender=$data["sender"];
                                $receiver=$data["receiver"];
                                $deliver=$data["deliver"];
                                $container = $data["container"];
                                $expected_date=$data["expected_date"];
                                $status=$data["status"];
                                $agents=$data["agent"];
                                $is_online=$data["is_online"];
                                $transport=$data["transport"];
                                $item_status = $data["status"];

                                //$proxy_type = $data["proxy_type;
                                $package_array =$data["package"];
                                if ($package_array!="")
                                {
                                    $package_array=explode("##",$package);
                                        $package1_name = $package_array[0];
                                        $package1_num = $package_array[1];
                                        $package1_price = $package_array[2];
                                        $package2_name = $package_array[3];
                                        $package2_num = $package_array[4];
                                        $package2_price = $package_array[5];
                                        $package3_name = $package_array[6];
                                        $package3_num = $package_array[7];
                                        $package3_price = $package_array[8];
                                        $package4_name = $package_array[9];
                                        $package4_num = $package_array[10];
                                        $package4_price = $package_array[11];
                                }


                                if ($container_id!=0)
                                    {
                                    $result_container = mysqli_query($conn,"SELECT * FROM container WHERE container_id=".$container_id);
                                    $data_container = mysqli_fetch_array($result_container);
                                    $name= 	$data_container["name"];
                                    $created= 	$data_container["created"];
                                    $departed= 	$data_container["departed"];
                                    $expected= 	$data_container["expected"];
                                    $description_container= 	$data_container["description"];
                                    $status= 	$data_container["status"];
                                    echo "<b>".$name."</b><br>";
                                    echo "Үүсгэсэн огноо:".$created."<br>";
                                    echo "Төлөв:".$status."<br>";
                                    echo "Америкаас гарсан огноо:".$departed."<br>";
                                    echo "Монголд очих огноо:".$expected."<br>";
                                    echo "<p>".$description_container."</p>";
                                    }

                                    echo "<table class='table table-hover'>";

                                        echo "<tr><th colspan='2'><h4>Илгээгч</h4></th></tr>";
                                        echo "<tr><td>Утас:(*)</td><td><input type='text' name='sender_contact' class='form-control' value='".customer($sender,"tel")."' required></td></tr>";
                                        echo "<tr><td colspan='2'><span id='sender_result' class='alert alert-danger small' role='alert'></span></td></tr>";
                                        echo "<tr><td>Нэр(*)</td><td><input type='text' name='sender_name' class='form-control' value='".customer($sender,"name")."'></td></tr>";
                                        echo "<tr><td>Овог</td><td><input type='text' name='sender_surname' class='form-control' value='".customer($sender,"surname")."'></td></tr>";
                                        echo "<tr><td>И-мейл(*)</td><td><input type='text' name='sender_email' class='form-control' value='".customer($sender,"email")."'></td></tr>";
                                        echo "<tr><td>Хаяг(*)</td><td><input type='text' name='sender_address' class='form-control' value='".customer($sender,"address")."'></td></tr>";

                                        echo "<tr><th colspan='2'><h4>Хүлээн авагч</h4></th></tr>";
                                        echo "<tr><td>Утас:(*)</td><td><input type='text' name='receiver_contact' class='form-control' value='".customer($receiver,"tel")."' required>";
                                        echo "<span id='receiver_result' class='alert alert-danger' role='alert'></span></td></tr>";
                                        echo "<tr><td>Нэр(*)</td><td><input type='text' name='receiver_name' class='form-control' value='".customer($receiver,"name")."'></td></tr>";
                                        echo "<tr><td>Овог</td><td><input type='text' name='receiver_surname' class='form-control' value='".customer($receiver,"surname")."'></td></tr>";
                                        echo "<tr><td>И-мейл(*)</td><td><input type='text' name='receiver_email' class='form-control' value='".customer($receiver,"email")."'></td></tr>";
                                        echo "<tr><td>Хаяг(*)</td><td><input type='text' name='receiver_address' class='form-control' value='".customer($receiver,"address")."'></td></tr>";




                                        echo "<tr><td>Барааны тайлбар</td><td>";
                                            echo "<table class='table table-hover'>";
                                            echo "<tr>";
                                            echo "<td><input type='text' name='package1_name' class='form-control' value='".$package1_name."' placeholder='Цамц, Цүнх, Утас г.м' required></td>";
                                            echo "<td><input type='text' name='package1_num' class='form-control' value='".$package1_num."' placeholder='Тоо ширхэг'></td>";
                                            echo "<td><input type='text' name='package1_price' class='form-control' value='".$package1_price."' placeholder='Үнэ ($)'></td>";
                                            echo "</tr>";
                                            
                                            echo "<tr>";
                                            echo "<td><input type='text' name='package2_name' class='form-control' value='".$package2_name."' placeholder='Цамц, Цүнх, Утас г.м'></td>";
                                            echo "<td><input type='text' name='package2_num' class='form-control' value='".$package2_num."' placeholder='Тоо ширхэг'></td>";
                                            echo "<td><input type='text' name='package2_price' class='form-control'  value='".$package2_price."' placeholder='Үнэ ($)'></td>";
                                            echo "</tr>";
                                            
                                            echo "<tr>";
                                            echo "<td><input type='text' name='package3_name' class='form-control' value='".$package3_name."' placeholder='Цамц, Цүнх, Утас г.м'></td>";
                                            echo "<td><input type='text' name='package3_num' class='form-control' value='".$package3_num."' placeholder='Тоо ширхэг'></td>";
                                            echo "<td><input type='text' name='package3_price' class='form-control'  value='".$package3_price."' placeholder='Үнэ ($)'></td>";
                                            echo "</tr>";

                                            echo "<tr>";
                                            echo "<td><input type='text' name='package4_name' class='form-control' value='".$package4_name."' placeholder='Цамц, Цүнх, Утас г.м'></td>";
                                            echo "<td><input type='text' name='package4_num' class='form-control' value='".$package4_num."' placeholder='Тоо ширхэг'></td>";
                                            echo "<td><input type='text' name='package4_price' class='form-control'  value='".$package4_price."' placeholder='Үнэ ($)'></td>";
                                            echo "</tr>";

                                            echo "</table>";

                                        echo "<tr><td>Тайлбар: (*)</td><td><textarea name='description' class='form-control'>".$description."</textarea></td></tr>";

                                    
                                        echo "<tr><td>Нийт жин эсвэл хэмжээ /кг/(*)</td><td><input type='text' class='form-control' name='weight' id='weight'  value='".$weight."' required></td></tr>";


                                        echo "<tr><td>Авсан төлбөр/$/</td><td><input type='text' class='form-control' name='payment'  value='".$payment."' ></td></tr>";

                                        echo "<tr><td>Монголд авах төлбөр/$/</td><td><input type='text' class='form-control' name='pay_in_mongolia'  value='".$pay_in_mongolia."'></td></tr>";
                                        echo "</td>";
                                        echo "</tr>";

                                        /*echo "<div class='more'>";
                                        echo "<div class='box'>";
                                        echo "<h4 class='legend'>Илгээмж явах хэлбэр</h4>";
                                        echo "<span class='formspan'>Агаараар</span>";
                                        echo form_radio('way', 'air', TRUE)."<br>";
                                        echo "<span class='formspan'>Газраар</span>";
                                        echo form_radio('way', 'surface', FALSE)."<br>";
                                        echo "<span class='formspan'>Хосолсон</span>";
                                        echo form_radio('way', 'sal', FALSE)."<br>";
                                        echo "<h4>Хүргэлтийн хэлбэр</h4>";
                                        echo "<span class='formspan'>Express</span>";
                                        echo form_radio('deliver_time', 'express', TRUE)."";
                                        echo "<span class='formspan'>Advice of delivery</span>";
                                        echo form_radio('deliver_time', 'advice', FALSE)."<br>";
                                        echo "</div>";



                                        echo "<div class='box'>";
                                        echo "<h4 class='legend'>Илгээмж доторхи зүйл</h4>";
                                        echo form_radio('Package_inside', 'gift',  TRUE);
                                        echo "Бэлэг<br>";
                                        echo form_radio('Package_inside', 'sample', FALSE);
                                        echo "Арилжааны шинж чанаргүй загвар<br>";
                                        echo form_radio('Package_inside', 'document', FALSE);
                                        echo "Арилжааны шинж чанаргүй бичиг баримт<br>";
                                        echo "</div>";


                                        echo "<div class='box'>";
                                        echo "<h4 class='legend'>Даатгал</h4>";
                                        echo "<span class='formspan'>Даатгалтай</span>";
                                        echo form_checkbox('insurance', '1')."<br>";
                                        echo "<span class='formspan'>Даатгалын төлбөр</span>";
                                        echo form_input('insurance_value', '');
                                        echo "</div>";


                                        echo "<div class='box'>";
                                        echo "<h4 class='legend'>Хүргэгдээгүй тохиолдолд</h4>";
                                        echo form_radio('Package_return_type', 'return_1',  TRUE);
                                        echo "Явуулагч талруу яаралтай буцаах<br>";
                                        echo form_radio('Package_return_type', 'return_2',  FALSE);
                                        echo "Явуулагч талруу __ өдрийн дараа буцаах";
                                        echo " Өдөр";
                                        echo form_input('Package_return_day', '')."<br>";
                                        echo form_radio('Package_return_type', 'return_3',  TRUE);
                                        echo "Өөр хаягруу явуулах"."<br>";
                                        echo "Өөр хаяг";
                                        echo form_textarea ("Package_return_address","")."<br>";
                                        echo form_radio('Package_return_type', 'return_4',  FALSE);
                                        echo "Тэнд нь устгах<br>";
                                        echo "<h4>Буцах хаягруу явуулах</h4>";
                                        echo "<span class='formspan'>Агаараар</span>";
                                        echo form_radio('Package_return_way', 'air',  TRUE);
                                        echo "<span class='formspan'>Газраар</span>";
                                        echo form_radio('Package_return_way', 'surface',  FALSE);
                                        echo "</div>";

                                        echo "</div>";  //MORE DIV CLOSE


                                        echo "<span id='more_toggle'>more</span>";*/
                                        echo "</table>";
                                ?>
                                <button type="submit" class="btn btn-success">Хадгалах</button>
                            </form>
                            <?
                                     
                            

                        }
                        else echo '<div class="alert alert-danger" role="alert">Ачааны дугаар алдаатай байна</div>';

                    }
                    else echo "item id not found";
                }

                if ($action=="item_editing")
                {                    
                    if (isset($_POST["item_id"]))
                    {
                        $item_id=$_POST["item_id"];                   
    
                        $result = mysqli_query($conn,"SELECT * FROM container_item WHERE id=".$item_id);
                        if (mysqli_num_rows($result)==1)
                        {
                            $data = mysqli_fetch_array($result);
                            $sender_id= 	$data["sender"];
                            $receiver_id= 	$data["receiver"];
                            $description = $data["description"];
                            $weight= 	$data["weight"];
                            $payment= 	$data["payment"];
                            $pay_in_mongolia= 	$data["pay_in_mongolia"];
                            $container_id= 	$data["container"];
                            $status= 	$data["status"];
                            if ($container_id!=0)
                                {
                                $result = mysqli_query($conn,"SELECT * FROM container WHERE container_id=".$container_id);
                                $data =mysqli_fetch_array($result);
                                $name= 	$data["name"];
                                $created= 	$data["created"];
                                $departed= 	$data["departed"];
                                $expected= 	$data["expected"];
                                $description_container= 	$data["description"];
                                $container_status= 	$data["status"];
                                echo "<b>".$name."</b><br>";
                                echo "Үүсгэсэн огноо:".$created."<br>";
                                echo "Төлөв:".$container_status."<br>";
                                echo "Америкаас гарсан огноо:".$departed."<br>";
                                echo "Монголд очих огноо:".$expected."<br>";
                                echo "<p>".$description_container."</p>";
                                }
    
    
                            if ($status=="new" || $status=="weight_missing")
                            {
                                $sender_contact = $_POST["sender_contact"];
                                $sender_name = $_POST["sender_name"];
                                $sender_surname = $_POST["sender_surname"];
                                $sender_email = $_POST["sender_email"];
                                $sender_address = $_POST["sender_address"];
                                $query_sender = mysqli_query($conn,'SELECT customer_id FROM customer WHERE tel="'.$sender_contact.'"');
                                if (mysqli_num_rows($query_sender)==0&&$sender_contact!="")
                                    {	
                                    if (mysqli_query($conn,"INSERT INTO customer (name,surname,tel,email,address,username,password,status)
                                    VALUES ('$sender_name','$sender_surname','$sender_contact','$sender_email','$sender_address','$sender_contact','$sender_contact','regular')"))                                   
                                    $sender_id=mysqli_insert_id($conn);
                                    }

                                    
                                $receiver_contact = $_POST["receiver_contact"];
                                $receiver_name = $_POST["receiver_name"];
                                $receiver_surname = $_POST["receiver_surname"];
                                $receiver_email = $_POST["receiver_email"];
                                $receiver_address = $_POST["receiver_address"];
                                $query_sender = mysqli_query($conn,'SELECT customer_id FROM customer WHERE tel="'.$receiver_contact.'"');
                                if (mysqli_num_rows($query_sender)==0&&$sender_contact!="")
                                    {	
                                    if (mysqli_query($conn,"INSERT INTO customer (name,surname,tel,email,address,username,password,status)
                                    VALUES ('$receiver_name','$receiver_surname','$receiver_contact','$receiver_email','$receiver_address','$receiver_contact','$receiver_contact','regular')"))                                   
                                    $receiver_id=mysqli_insert_id($conn);
                                    }

                                $description=$_POST["description"];
                                $weight=$_POST["weight"];
                                $payment=$_POST["payment"];
                                $pay_in_mongolia=$_POST["pay_in_mongolia"];
                                if ($payment>0 || $pay_in_mongolia>0) 
                                    if( $status=="weight_missing") $status="new";
                                
                                
                                $sql = "UPDATE container_item SET 
                                        sender='$sender_id',                                        
                                        receiver='$receiver_id',
                                        description='$description',
                                        weight='$weight',
                                        payment='$payment',
                                        pay_in_mongolia='$pay_in_mongolia',
                                        status='$status'
                                        WHERE id = $item_id";
                                if (mysqli_query($conn,$sql))
                                {		
                                    ?>
                                    <div class="alert alert-success" role="alert">Чингэлэгийн ачааг заслаа</div>
                                    <a href="container_cp72?id=<?=$item_id;?>" target="new" class="btn btn-primary">CP72 хэвлэх</a>
                                    <a href="container_item_print?id=<?=$item_id;?>" target="new" class="btn btn-warning">Пайз хэвлэх</a>
                                    <?
                                }
                                else echo '<div class="alert alert-danger" role="alert">Error:'.mysqli_error($conn).'</span>';
                            }
                            else echo '<div class="alert alert-danger" role="alert">Чинэглэгийн төлөв засаж болохгүй төлөвт байна</div>';
                        }
                        else echo '<div class="alert alert-danger" role="alert">Ачааны дугаар алдаатай байна</div>';
                    }
                    else echo '<div class="alert alert-danger" role="alert">Ачааны дугаар олдсонгүй</div>';

                }

                
                ?>
            </div>

            <? require_once("views/footer.php");?>

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
    <script src="assets/vendor/libs/swiper/swiper.js"></script>
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

    
    <script type="application/javascript">
    $(function() {

                    $('select').change(function(){
                        $("form").submit();
                    });


                
                //$(".alert").hide();
                $('body').on('keydown', 'input, select, textarea', function(e) {
                var self = $(this)
                , form = self.parents('form:eq(0)')
                , focusable
                , next
                ;
                if (e.keyCode == 13) {
                    focusable = form.find('input,a,select,button,textarea').filter(':visible');
                    next = focusable.eq(focusable.index(this)+1);
                    if (next.length) {
                        next.focus();
                    } else {
                        form.submit();
                    }
                    return false;
                }
            });
                
        $("#weight").on('change',function(){
            var str = $(this).val();
            var payment_rate = <?=settings("paymentrate_selfdrop");?>;
            var str = str.replace(",", "."); 
            var str = str.replace("Kg", ""); 
            var str = str.replace("kg", ""); 
            var str = str.replace("KG", ""); 
            var str = str.replace("Кг", ""); 
            var str = str.replace("кг", ""); 
            var str = str.replace("КГ", ""); 
            var weight = parseFloat(str);
            $(this).val(weight);
            if (weight<=0.5)  $('#Package_advance_value').val(10);
            if (weight>0.5 && weight<=1) $('#Package_advance_value').val(payment_rate);
            if (weight>1) {var total = $(this).val()*payment_rate; $('#Package_advance_value').val(total.toFixed(2));}
            });
        $("div.more").hide();

        $( "span#more_toggle" ).click(function() {
                $( "div.more" ).toggle( "fast", function() {});
                if ($(this).html()=="more") 
                $(this).html('<span class="glyphicon glyphicon-menu-up"></span>less'); 
                else $(this).html('<span class="glyphicon glyphicon-menu-down"></span>more');
                });


                
	
	
        $('input[name="sender_contact"]').change(function(){
            $('#sender_result').append('<img src="assets/img/ajax-loader.gif" id="loading">');
            var tel= $('input[name="sender_contact"]').val();
        $.ajax ({
            url: 'customers_check2',
            type:'GET',
            data:'tel='+tel,
            success: function(responce){
                    $('#responce').remove();
                    $('#sender_result').append(responce);
                    $('#sender_result').show(500);
                    $('#loading').remove();
                    if (responce=="Found user") 
                    {
                        
                        $.ajax ({
                        url: 'customers_check2',
                        type:'GET',
                        data:'tel='+tel+'&value=surname',
                        success: function(responce1){
                            $('input[name="sender_surname"]').val(responce1);
                                                    }
                                });	
                                
                        $.ajax ({
                        url: 'customers_check2',
                        type:'GET',
                        data:'tel='+tel+'&value=name',
                        success: function(responce2){
                            $('input[name="sender_name"]').val(responce2);
                                                    }
                                });	
                                
                        $.ajax ({
                        url: 'customers_check2',
                        type:'GET',
                        data:'tel='+tel+'&value=email',
                        success: function(responce3){
                            $('input[name="sender_email"]').val(responce3);
                                                    }
                                });	
                                
                        $.ajax ({
                        url: 'customers_check2',
                        type:'GET',
                        data:'tel='+tel+'&value=address',
                        success: function(responce4){
                            $('textarea[name="sender_address"]').text(responce4);
                                                    }
                                });	
                    }
                    }
            });	
        });

        $('input[name="receiver_contact"]').change(function(){
            $('#sender_result').append('<img src="assets/img/ajax-loader.gif" id="loading">');
            var tel= $('input[name="receiver_contact"]').val();
        $.ajax ({
            url: 'customers_check2',
            type:'GET',
            data:'tel='+tel,
            success: function(responce){
                                        $('#receiver_result').html('');
                                        $('#receiver_result').append(responce);
                                        $('#receiver_result').show(500);	
                                        $('#loading').remove();
                                        if (responce=="Found user") 
                                        {												
                                            $.ajax ({
                                            url: 'customers_check2',
                                            type:'GET',
                                            data:'tel='+tel+'&value=surname',
                                            success: function(responce1){
                                                $('input[name="receiver_surname"]').val(responce1);
                                                                        }
                                                    });	
                                                    
                                            $.ajax ({
                                            url: 'customers_check2',
                                            type:'GET',
                                            data:'tel='+tel+'&value=name',
                                            success: function(responce2){
                                                $('input[name="receiver_name"]').val(responce2);
                                                                        }
                                                    });	
                                                    
                                            $.ajax ({
                                            url: 'customers_check2',
                                            type:'GET',
                                            data:'tel='+tel+'&value=email',
                                            success: function(responce3){
                                                $('input[name="receiver_email"]').val(responce3);
                                                                        }
                                                    });	
                                                    
                                            $.ajax ({
                                            url: 'customers_check2',
                                            type:'GET',
                                            data:'tel='+tel+'&value=address',
                                            success: function(responce4){
                                                $('textarea[name="receiver_address"]').text(responce4);
                                                                        }
                                                    });	
                                        }
                                        }
            });	
        });

        })
    </script>
  </body>
</html>
