<?
require_once("config.php");
require_once("views/helper.php");
require_once("views/login_check.php");
require_once("views/init.php");
?>
<link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">

<body class="sidebar-dark">
	<div class="main-wrapper">
		<?  require_once("views/navbar.php"); ?>
	
		<div class="page-wrapper">
		<?  require_once("views/sidebar.php"); ?>
				

		<div class="page-content">
			<?
			if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="select";?>
			<?
			switch ($action)
			{
				case "select": $action_title="Barcode-г сонгож өөрчлөх";break;
				case "insert": $action_title="Barcode оруулах";break;
				case "inserting": $action_title="Barcode оруулах";break;
				case "elimination": $action_title="Barcode цэвэрлэх";break;
				
			}
			?>
			<nav class="page-breadcrumb">
				<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="barcodes">Түр хадгалах barcode</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$action_title;?></li>
				</ol>
			</nav>

            <?
            if ($action=="select")
            {
                $result = mysqli_query($conn,"SELECT barcode.* FROM barcode ORDER BY timestamp DESC");

                if (mysqli_num_rows($result) > 0)
                {
                    ?>
                    <form action="?action=elimination" method="POST">
                        
                        <table class='table table-hover'>
                            <tr>
                                <th><input type="checkbox" name="select_all" title="Select all barcodes"></th>
                                <th>№</th>
                                <th>Barcode оруулсан</th>
                                <th>Barcode</th>
                                <th>Захиалгын огноо</th>
                                <th>Илгээгч</th>
                                <th>Х/авагч</th>
                                <th>Х/авагч утас</th>
                                <th>Хоног</th>
                                <th>Төлөв</th>
                                <th></th>
                            </tr>
                            <?

                            $count=1;
                            while ($data = mysqli_fetch_array($result))
                            {  
                                $timestamp=$data["timestamp"];
                                $barcode=$data["barcode"];
                                $combine=$data["combine"];
                                $status=$data["combine"];
                                
                                if ($combine==0)
                                $result_inside=mysqli_query($conn,"SELECT * FROM orders WHERE barcode='$barcode'");
                                else 
                                $result_inside=mysqli_query($conn,"SELECT * FROM box_combine WHERE barcode='$barcode'");
                                
                                if (mysqli_num_rows($result_inside)==1)
                                    {                                    
                                        $data=mysqli_fetch_array($result_inside);
                                        $created_date=$data["created_date"];
                                        $sender_id=$data["sender"];
                                        $receiver_id=$data["receiver"];
                                        $package=$data["package"];
                                        $Package_advance =$data["advance"];
                                        $Package_advance_value =$data["advance_value"];
                                        $single_status=$data["status"];
                                        //$single_extra=$data["extra"];
                                        
                                        if ($combine==0)
                                        $order_id=$data["order_id"];
                                        else 
                                        $combine_id=$order_id=$data["combine_id"];
                                    }
        
        
                                
                                    
                                    $s_name=customer($sender_id,"name");
                                    $s_surname=customer($sender_id,"surname");
                                    $s_tel=customer($sender_id,"tel");
                                    $s_email=customer($sender_id,"email");
                                    $s_address=customer($sender_id,"address");
        
        
        
                                    $r_name=customer($receiver_id,"name");
                                    $r_surname=customer($receiver_id,"surname");
                                    $r_tel=customer($receiver_id,"tel");
                                    $r_email=customer($receiver_id,"email");
                                    $r_address=customer($receiver_id,"address");
        
                                
                            
                            
                                $days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;
        
                            
                                if ($Package_advance==1)
                                echo "<tr class='red' title='Үлдэгдэл:".$Package_advance_value."$'>"; 
                                else echo "<tr>";
                                        ?>
                                            <td><input type="checkbox" name="barcode_id[]" value="<?=$barcode;?>"></td>
                                            <td><?=$count++;?></td>
                                            <td><?=$timestamp;?></td>
                                            <td><?=$barcode;?></td>
                                            <td><?=$created_date;?></td>
                                            <td><?=($s_name!="")?'<a href="customers/detail/'.$sender_id.'">'.substr($s_surname,0,2).".".$s_name:'';?></a></td>
                                            <td><?=($r_name!="")?'<a href="customers/detail/'.$receiver_id.'">'.substr($r_surname,0,2).".".$r_name:'';?></a></td>
                                            <td><?=$r_tel;?></td>
                                            <td><?=$days;?></td>
                                            <td><?=$single_status;?></td>
                                            <td>
                                                <?
                                                if ($combine)
                                                {
                                                    ?>
                                                    <a href="combine_detail?id=<?=$combine_id;?>"><span class="glyphicon glyphicon-edit"></span></a>
                                                    <?
                                                } 
                                                    else
                                                    {
                                                        ?>
                                                        <a href="tracks_detail?id=<?=$order_id;?>"><span class="glyphicon glyphicon-edit"></span></a>

                                                        <?
                                                    } 

                                                ?>
                                            </td>
                                        <?                                                                       
                                    echo "</tr>";
                            } 
                            ?>
                        </table>

                     
                        <select name="options" class="form-control">
                            <option value="weight_missing">Жин ороогүй</option>
                            <option value="new">Нисэхэд бэлэн</option>
                            <option value="onair">Онгоцоор ирж байгаа</option>
                            <option value="warehouse">Агуулахад орсон</option>
                            <option value="hand">Хүргэлттэй</option>
                            <option value="unhandover">Хүргэлт цуцлах</option>
                            <option value="custom">Гааль</option>
                            <option value="delete">Barcode устгах</option>
                        </select>
                        <div id="more"></div>
                        <button class="btn btn-success" type="submit">Өөрчилөх</button>
                    </form>
                        <?
                }
                else echo "Barcode байхгүй";

            }   
            
            if ($action=="insert")
            {
                ?>
                <form action="barcodes?action=inserting" method="POST">
                    <textarea name='barcode' style="min-height:200px;" autofocus='autofocus' required='required' class='form-control mb-3'></textarea>
                    <div id="result"></div>
                    <button type="submit" class="btn btn-success">Оруулах</button>
                </form>
                <?
            }

            if ($action=="inserting")
            {
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <?
                        $barcode=$_POST["barcode"];
                        $barcode_array = explode("\r\n",$barcode);
                        $count=0;
                        foreach ($barcode_array as $barcode_single)
                        {
                            
                            if ($barcode_single!="")
                            {
                            echo $barcode_single."->";
                            $result = mysqli_query($conn,"SELECT * FROM orders WHERE barcode='".$barcode_single."' OR third_party='".$barcode_single."' LIMIT 1");
                            if (mysqli_num_rows($result) == 1)
                            {
                                $data=mysqli_fetch_array($result);
                                $status= $data["status"];
                                //if ($status=="delivered") echo "Order already delivered";
                                //if ($status=="custom") echo "Order in custom";
                                //if ($status!="delivered" && $status!="custom") // NOT DELIVERED BARCODE FOUND
                                //{
                                $barcode_only=$data["barcode"];
                                $result_sub = mysqli_query($conn,"SELECT * FROM barcode WHERE barcode='".$barcode_only."' LIMIT 1");
                                if (mysqli_num_rows($result_sub) == 1) 
                                {
                                    $count++;
                                    echo "<b class='red text-red'>".$count.". Barcode already inserted</b>";
                                }
                                else 
                                {
                                mysqli_query($conn,"INSERT INTO barcode (barcode,status) VALUES ('".$barcode_only."','catched')");
                                echo "Barcode Inserted";
                                }
                                //}// NOT DELIVERED BARCODE FOUND ending
                                echo "<br>";
                            } 
                            else 
                                {
                                $result_combine = mysqli_query($conn,"SELECT * FROM box_combine WHERE barcode='".$barcode_single."' LIMIT 1");
                                if (mysqli_num_rows($result_combine) == 1)
                                {
                                    
                                    
                                    $data_combine = mysqli_fetch_array($result_combine);
                                    $status= $data_combine["status"];
                                    //	if ($status=="delivered") echo "Order already delivered";
                                    //	if ($status=="custom") echo "Order in custom";
                                    //	if ($status!="delivered" && $status!="custom") // NOT DELIVERED BARCODE FOUND
                                    //	{
                                        $barcode_only=$data_combine["barcode"];
                                        $result_sub= mysqli_query($conn,"SELECT * FROM barcode WHERE barcode='".$barcode_only."' LIMIT 1");
                                        if (mysqli_num_rows($result_sub) == 1) 
                                        {
                                            $count++;
                                            echo "<b class='red text-red'>".$count.". Barcode already inserted</b>";
                                            
                                        }
                                        else 
                                        {
                                        mysqli_query($conn,"INSERT INTO barcode (barcode,status,combine) VALUES ('".$barcode_only."','catched',1)");
                                        echo "Combine box barcode Inserted";
                                        }
                                //		}
                                
                                } 
                                else echo "Barcode not found in both combine and single"; // if ($barcode_single!="") ending
                                echo "<br>";
                                }
                            }
                        }
                        ?>
                        <a href="?action=insert" class="btn btn-success">Ахин оруулах</a>
                        <?
                        if ($count>0) echo '<h3 class="text-center red">'.$count.' Давхардсан байна</h3><script>alert("'.$count.' давхардсан");</script>';
                        ?>
                    </div>
                </div>                                      
                <?

            }

            if ($action=="elimination")
            {
                $options=$_POST["options"];
                echo "<table class='table table-hover'>";
                echo "<tr>";
                echo "<th>Barcode оруулсан</th>"; 
                echo "<th>Barcode</th>"; 
                echo "<th>Захиалгын огноо</th>"; 
                echo "<th>Илгээгч</th>"; 
                echo "<th>Хүлээн авагч</th>"; 
                echo "<th>Хүлээн авагчын утас</th>"; 
                echo "<th>Хоног</th>"; 
                echo "<th>Төлөв</th>"; 
                echo "<th>Шинэ төлөв</th>"; 
                echo "<th></th>"; 
                echo "</tr>";
                $barcode_id=@$_POST['barcode_id'];
                $N = count($barcode_id);
                for($i=0; $i < $N; $i++)
                {
                    $result = mysqli_query($conn,"SELECT * FROM barcode WHERE barcode.barcode='".$barcode_id[$i]."' LIMIT 1");
                    while ($data = mysqli_fetch_array($result))
                    {
                    $barcode= $data["barcode"];
                    $combine=$data["combine"];
                    $timestamp=$data["timestamp"];
                    $status=$data["status"];
                    
                    if ($combine==0)
                    $result_sub = mysqli_query($conn,"SELECT * FROM orders WHERE barcode='$barcode'");
                    else 
                    $result_sub = mysqli_query($conn,"SELECT * FROM box_combine WHERE barcode='$barcode'");
                    
                    if (mysqli_num_rows($result_sub)==1)
                        {
                            $data=mysqli_fetch_array($result_sub);
                            $created_date=$data["created_date"];
                            $sender_id=$data["sender"];
                            $receiver_id=$data["receiver"];
                            $package=$data["package"];
                            $Package_advance =$data["advance"];
                            $Package_advance_value =$data["advance_value"];
                            $single_status=$data["status"];
                            //$single_extra=$data["extra"];
                            
                            if ($combine==0)
                            $order_id=$data["order_id"];
                            else 
                            { $combine_id=$order_id=$data["combine_id"]; $barcodes=$data["barcodes"];}
                        }


                    
                        
                        $s_name=customer($sender_id,"name");
                        $s_surname=customer($sender_id,"surname");
                        $s_tel=customer($sender_id,"tel");
                        $s_email=customer($sender_id,"email");
                        $s_address=customer($sender_id,"address");



                        $r_name=customer($receiver_id,"name");
                        $r_surname=customer($receiver_id,"surname");
                        $r_tel=customer($receiver_id,"tel");
                        $r_email=customer($receiver_id,"email");
                        $r_address=customer($receiver_id,"address");

                    
                
                
                         $days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;

                    
                        
                            switch ($options)
                            {
                                //case "delivered": $new_status = "delivered";break;
                                case "weight_missing":$new_status = "weight_missing";break;
                                case "new":$new_status = "new";break;
                                case "onair":$new_status = "onair";break;
                                case "warehouse":$new_status = "warehouse";$extra=$_POST["bench"];break;
                                case "hand":$new_status = "hand";break;
                                case "unhandover":$new_status = "unhandover";break;
                                case "custom":$new_status = "custom";$extra="";break;
                                case "delete":$new_status = "delete";$extra="";break;
                            }
                
                    echo "<tr>";
                    echo "<td>".$timestamp."</td>"; 
                    echo "<td>".$barcode."</td>"; 
                    echo "<td>".$created_date."</td>"; 
                    echo "<td>".$s_name."</td>"; 
                    echo "<td>".$r_name."</td>"; 
                    echo "<td>".$r_tel."</td>"; 
                    echo "<td>".$days."</td>"; 
                    echo "<td>".$status."</td>"; 
                
                    
                
                    if ($combine==0)
                        {
                    if($new_status=="weight_missing") 
                    $data = array(
                        'status' => $new_status,
                        'weight' =>""
                                );	
                    if($new_status=="new") 
                    $data = array(
                        'status' => $new_status,
                                );	
                
                    if($new_status=="onair") 
                    $data = array(
                        'status' => $new_status,
                        'onair_date'=>date("Y-m-d H:i:s")
                                );	
                                
                    if($new_status=="warehouse") 
                    $data = array(
                        'status' => $new_status,
                        'warehouse_date'=>date("Y-m-d H:i:s"),
                        'extra'=>$extra
                                );	
                                
                    if($new_status=="custom") 
                    $data = array(
                        'status' => $new_status,
                        'warehouse_date'=>date("Y-m-d H:i:s")
                                );	
                                            
                    if($new_status=="hand") 
                    $data=array(
                        'transport' => '1'
                    );	

                    if($new_status=="unhandover") 
                    $data=array(
                        'transport' => '0'
                    );	
                    
                    if($options=="warehouse" || $options=="custom" || $options=="hand" || $options=="onair" || $options=="new" ||  $options=="weight_missing" || $options=="unhandover")
                    {
                        //if ($single_status!='delivered')
                        //	{
                        $this->db->where('order_id', $order_id);
                        if ($this->db->update('orders', $data))
                            {
                            //	echo $this->db->sql;
                            $this->db->query("DELETE FROM barcode WHERE barcode='".$barcode_id[$i]."' LIMIT 1");
                            echo "<td>".$new_status."</td>"; 

                            if ($options=="warehouse")
                            {
                                // BOX OF THIS ITEM STATUS CHANGE

                                $sql = "SELECT *FROM boxes_packages WHERE barcode='".$barcode_id[$i]."' OR barcodes LIKE '%".$barcode_id[$i]."%' LIMIT 1";
                                $box_query = $this->db->query($sql);
                                if ($box_query->num_rows()==1)
                                {
                                    $box_rows = $box_query->row();
                                    $box_id = $box_rows->box_id;
                                    $packages_query = $this->db->query("SELECT * FROM boxes_packages WHERE box_id=$box_id");
                                    if ($packages_query->num_rows()>0)
                                        {
                                            $inside_item =$packages_query->num_rows();
                                            $inside_count =0;
                                        
                                            foreach($packages_query->result() as $package_row)
                                            {
                                                $barcode=$package_row->barcode;
                                                $combined=$package_row->combined;
                                                $order_id=$package_row->order_id;
                                                $barcodes=$package_row->barcodes;
                                                $order_id=$package_row->order_id;
                                                if ($combined!=1) //SINGLE
                                                    {
                                                    $order_query= $this->db->query("SELECT * FROM orders WHERE barcode='$barcode'");
                                                    if ($order_query->num_rows()==1)
                                                        {
                                                        $row_orders = $order_query->row();
                                                        $proxy_id = $row_orders->proxy_id;
                                                        $proxy_type = $row_orders->proxy_type;
                                                        proxy_available($proxy_id,$proxy_type,0);
                                                        if($row_orders->status=="warehouse" || $row_orders->status=="custom" || $row_orders->status=="delivered") 
                                                        $inside_count++;  // COUNT WAREHOUSE OR CUSTOM
                                                        }
                                                    } //SINGLE ENDING
                                                if ($combined==1) //COMBINED
                                                    {
                                                        
                                                    $box_query= $this->db->query("SELECT * FROM box_combine WHERE barcode='$barcode'");
                                                    if ($box_query->num_rows()==1)
                                                        {
                                                        $row_box = $box_query->row();

                                                        if($row_box->status=="warehouse" || $row_box->status=="custom" || $row_box->status=="delivered") 
                                                        //$this->db->query("UPDATE orders SET status='warehouse',warehouse_date='".date("Y-m-d H:i:s")."' WHERE order_id=$order_id");
                                                        $inside_count++;  // COUNT WAREHOUSE OR CUSTOM
                                                        }								
                                                    //$inside_count++;
                                                    } //COMBINED ENDING
                                            }

                                            if ($inside_item==$inside_count)
                                            $this->db->query("UPDATE boxes SET status='".$options."' WHERE box_id='$box_id' LIMIT 1");
                                        }
                                }
                                // BOX OF THIS ITEM STATUS CHANGE				 	
                            }
                            }
                        else echo "<td>Алдаа".$this->db->error()."</td>";
                    //	}
                        //else echo "<td>Алдаа: Хүргэгдсэн</td>"; 
                        
                    }
                    elseif ($options=="delete")
                        {
                            mysqli_query($conn,"DELETE FROM barcode WHERE barcode='".$barcode_id[$i]."' LIMIT 1");
                            echo "<td>".$new_status."</td>"; 
                        }
                echo "<td><a href='orders/detail/".$order_id."'><span class='glyphicon glyphicon-edit'></span></a></td>";
                    
                }
                
                
                
                
                
                if ($combine==1)
                {	
                if($new_status=="onair") 
                $data = array(
                    'status' => $new_status,
                    'onair_date'=>date("Y-m-d H:i:s")
                            );	

                
                
                if($new_status=="custom") 
                $data = array(
                    'status' => $new_status,
                    'delivered_date'=>date("Y-m-d H:i:s")
                            );	
                            
                if($new_status=="warehouse") 
                $data = array(
                    'status' => $new_status,
                    'warehouse_date'=>date("Y-m-d H:i:s"),
                    'extra'=>$extra
                            );	
                if($new_status=="hand") 
                $data=array(
                    'transport' => '1'
                );			

                if($new_status=="unhandover") 
                $data=array(
                    'transport' => '0'
                );	  
                if($options=="warehouse" || $options=="custom" || $options=="hand" || $options=="onair" || $options=="unhandover")
                {
                    //if ($single_status!='delivered')
                    //{
                    $barcodes_array = explode(",",$barcodes);
                        foreach($barcodes_array as $barcode_box_inside)
                        {
                            $this->db->where('barcode', $barcode_box_inside);
                            $this->db->update('orders', $data);
                        }
                    $this->db->where('barcode', $barcode_id[$i]);
                    if ($this->db->update('box_combine', $data))
                        {
                        $this->db->query("DELETE FROM barcode WHERE barcode='".$barcode_id[$i]."' LIMIT 1");
                        echo "<td>".$new_status."</td>"; 
                        }
                    else echo "<td>Алдаа".$this->db->error()."</td>";
                    //}
                    //else echo "<td>Алдаа: Хүргэгдсэн</td>"; 
                    
                }
                elseif ($options=="delete")
                    {
                        $this->db->query("DELETE FROM barcode WHERE barcode='".$barcode_id[$i]."' LIMIT 1");
                    echo "<td>".$new_status."</td>"; 
                    }
                echo "<td>".anchor('orders/detail/'.$order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>";
                            
                }
             echo "</tr>";	


                }
                }
                echo "</table>";
	
            }
            ?>
           




		</div>
		<? require_once("views/footer.php");?>
		
		</div>
	</div>

	<!-- core:js -->
	<script src="assets/vendors/core/core.js"></script>
	<!-- endinject -->
  
	<!-- inject:js -->
	<script src="assets/vendors/feather-icons/feather.min.js"></script>
	<script src="assets/js/template.js"></script>
    <script type="application/javascript">
        $(document).ready(function(e) {

            $('input[name="select_all"]').click(function(event) {
            if(this.checked) { 
                $('input[type="checkbox"]').each(function() {
                    this.checked = true;            
                });
            }else{
                $('input[type="checkbox"]').each(function() {
                    this.checked = false; 
                });        
            }
        });
        
            $("input[name='barcode']").focus();
            $('input[name="barcode"]').keypress(function(e) {
                if(e.which == 13) {
                    $('#result').append('<img src="assets/img/ajax-loader.gif" id="loading">');
                    var barcode= $('input[name="barcode"]').val();
                    $.ajax ({
                        url: 'barcodes?action=inserting',
                        type:'POST',
                        data:'barcode='+barcode,
                        success: function(responce){
                                            $('input[name="barcode"]').val('');
                                            $('#responce').remove();
                                            $('#result').append('<p id="responce">'+responce+'</p>');	
                                            $('#loading').remove();
                                                    }
                            });	
                }
            });
            
            $('select[name="options"]').change(function()
            {
                if ($('select[name="options"]').val()=="weight_missing")
                    {
                    $('#more').empty();
                    }
                if ($('select[name="options"]').val()=="new")
                    {
                    $('#more').empty();
                    }
                
                if ($('select[name="options"]').val()=="onair")
                    {
                    $('#more').empty();
                    }
                    
                if ($('select[name="options"]').val()=="custom")
                    {
                    $('#more').empty();
                    }

                if ($('select[name="options"]').val()=="unhandover")
                    {
                    $('#more').empty();
                    }
            
                if ($('select[name="options"]').val()=="warehouse")
                    {
                        $('#more').empty();
                        $('#more').append('<select name="bench" class="form-control">'+
                        '<option value="1">1-р тавиур</option>'+
                        '<option value="2">2-р тавиур</option>'+
                        '<option value="3">3-р тавиур</option>'+
                        '<option value="4">4-р тавиур</option>'+
                        '<option value="5">5-р тавиур</option>'+
                        '<option value="6">6-р тавиур</option>'+
                        '<option value="7">7-р тавиур</option>'+
                        '<option value="8">8-р тавиур</option>'+
                        '<option value="9">9-р тавиур</option>'+
                        '<option value="10">10-р тавиур</option>'+
                        '<option value="11">11-р тавиур</option>'+
                        '<option value="12">12-р тавиур</option>'+
                        '<option value="13">13-р тавиур</option>'+
                        '<option value="14">14-р тавиур</option>'+
                        '<option value="15">15-р тавиур</option>'+
                        '<option value="16">16-р тавиур</option>'+
                        '<option value="17">17-р тавиур</option>'+
                        '<option value="18">18-р тавиур</option>'+
                        '<option value="19">19-р тавиур</option>'+
                        '<option value="20">20-р тавиур</option>'+
                        '<option value="21">21-р тавиур</option>'+
                        '<option value="22">22-р тавиур</option>'+
                        '<option value="23">23-р тавиур</option>'+
                        '<option value="24">24-р тавиур</option>'+
                        '<option value="25">25-р тавиур</option>'+
                        '<option value="26">26-р тавиур</option>'+
                        '<option value="27">27-р тавиур</option>'+
                        '<option value="28">28-р тавиур</option>'+
                        '<option value="29">29-р тавиур</option>'+
                        '<option value="30">30-р тавиур</option>'+
                        '<option value="31">31-р тавиур</option>'+
                        '<option value="32">32-р тавиур</option>'+
                        '<option value="33">33-р тавиур</option>'+
                        '<option value="34">34-р тавиур</option>'+
                        '<option value="35">35-р тавиур</option>'+
                        '<option value="36">36-р тавиур</option>'+
                        '<option value="37">37-р тавиур</option>'+
                        '<option value="38">38-р тавиур</option>'+
                        '<option value="39">39-р тавиур</option>'+
                        '<option value="40">40-р тавиур</option>'+
                        '<option value="41">41-р тавиур</option>'+
                        '<option value="42">42-р тавиур</option>'+
                        '<option value="43">43-р тавиур</option>'+
                        '<option value="44">44-р тавиур</option>'+
                        '<option value="45">45-р тавиур</option>'+
                        '<option value="46">46-р тавиур</option>'+
                        '<option value="47">47-р тавиур</option>'+
                        '<option value="48">48-р тавиур</option>'+
                        '<option value="49">49-р тавиур</option>'+
                        '<option value="50">50-р тавиур</option>'+
                        '<option value="51">51-р тавиур</option>'+
                        '<option value="52">52-р тавиур</option>'+
                        '<option value="53">53-р тавиур</option>'+
                        '<option value="54">54-р тавиур</option>'+
                        '<option value="55">55-р тавиур</option>'+
                        '<option value="56">56-р тавиур</option>'+
                        '<option value="57">57-р тавиур</option>'+
                        '<option value="58">58-р тавиур</option>'+
                        '<option value="59">59-р тавиур</option>'+
                        '<option value="60">60-р тавиур</option>'+
                        '<option value="61">61-р тавиур</option>'+
                        '<option value="62">62-р тавиур</option>'+
                        '<option value="63">63-р тавиур</option>'+
                        '<option value="64">64-р тавиур</option>'+
                        '<option value="65">65-р тавиур</option>'+
                        '<option value="66">66-р тавиур</option>'+
                        '<option value="67">67-р тавиур</option>'+
                        '<option value="68">68-р тавиур</option>'+
                        '<option value="69">69-р тавиур</option>'+
                        '<option value="70">70-р тавиур</option>'+
                        '<option value="71">71-р тавиур</option>'+
                        '<option value="72">72-р тавиур</option>'+
                        '<option value="73">73-р тавиур</option>'+
                        '<option value="74">74-р тавиур</option>'+
                        '<option value="75">75-р тавиур</option>'+
                        '<option value="76">76-р тавиур</option>'+
                        '<option value="77">77-р тавиур</option>'+
                        '<option value="78">78-р тавиур</option>'+
                        '<option value="79">79-р тавиур</option>'+
                        '<option value="80">80-р тавиур</option>'+
                        '<option value="81">81-р тавиур</option>'+
                        '<option value="82">82-р тавиур</option>'+
                        '<option value="83">83-р тавиур</option>'+
                        '<option value="84">84-р тавиур</option>'+
                        '<option value="85">85-р тавиур</option>'+
                        '<option value="86">86-р тавиур</option>'+
                        '<option value="87">87-р тавиур</option>'+
                        '<option value="88">88-р тавиур</option>'+
                        '<option value="89">89-р тавиур</option>'+
                        '<option value="90">90-р тавиур</option>'+
                        '<option value="91">91-р тавиур</option>'+
                        '<option value="92">92-р тавиур</option>'+
                        '<option value="93">93-р тавиур</option>'+
                        '<option value="94">94-р тавиур</option>'+
                        '<option value="95">95-р тавиур</option>'+
                        '<option value="96">96-р тавиур</option>'+
                        '<option value="97">97-р тавиур</option>'+
                        '<option value="98">98-р тавиур</option>'+
                        '<option value="99">99-р тавиур</option>'+
                        '<option value="100">100-р тавиур</option>'+
                        '<option value="101">101-р тавиур</option>'+
                        '<option value="102">102-р тавиур</option>'+
                        '<option value="103">103-р тавиур</option>'+
                        '<option value="104">104-р тавиур</option>'+
                        '<option value="105">105-р тавиур</option>'+
                        '<option value="106">106-р тавиур</option>'+
                        '<option value="107">107-р тавиур</option>'+
                        '<option value="108">108-р тавиур</option>'+
                        '<option value="109">109-р тавиур</option>'+
                        '<option value="110">110-р тавиур</option>'+
                        '<option value="111">111-р тавиур</option>'+
                        '<option value="112">112-р тавиур</option>'+
                        '<option value="113">113-р тавиур</option>'+
                        '<option value="114">114-р тавиур</option>'+
                        '<option value="115">115-р тавиур</option>'+
                        '<option value="116">116-р тавиур</option>'+
                        '<option value="117">117-р тавиур</option>'+
                        '<option value="118">118-р тавиур</option>'+
                        '<option value="119">119-р тавиур</option>'+
                        '<option value="120">120-р тавиур</option>'+
                        '<option value="121">121-р тавиур</option>'+
                        '<option value="122">122-р тавиур</option>'+
                        '<option value="123">123-р тавиур</option>'+
                        '<option value="124">124-р тавиур</option>'+
                        '<option value="125">125-р тавиур</option>'+
                        '<option value="126">126-р тавиур</option>'+
                        '<option value="127">127-р тавиур</option>'+
                        '<option value="128">128-р тавиур</option>'+
                        '<option value="129">129-р тавиур</option>'+
                        '<option value="130">130-р тавиур</option>'+
                        '<option value="131">131-р тавиур</option>'+
                        '<option value="132">132-р тавиур</option>'+
                        '<option value="133">133-р тавиур</option>'+
                        '<option value="134">134-р тавиур</option>'+
                        '<option value="135">135-р тавиур</option>'+
                        '<option value="136">136-р тавиур</option>'+
                        '<option value="137">137-р тавиур</option>'+
                        '<option value="138">138-р тавиур</option>'+
                        '<option value="139">139-р тавиур</option>'+
                        '<option value="140">140-р тавиур</option>'+
                        '<option value="141">141-р тавиур</option>'+
                        '<option value="142">142-р тавиур</option>'+
                        '<option value="143">143-р тавиур</option>'+
                        '<option value="144">144-р тавиур</option>'+
                        '<option value="145">145-р тавиур</option>'+
                        '<option value="146">146-р тавиур</option>'+
                        '<option value="147">147-р тавиур</option>'+
                        '<option value="148">148-р тавиур</option>'+
                        '<option value="149">149-р тавиур</option>'+
                        '<option value="150">150-р тавиур</option>'+
                        '<option value="151">151-р тавиур</option>'+
                        '<option value="152">152-р тавиур</option>'+
                        '<option value="153">153-р тавиур</option>'+
                        '<option value="154">154-р тавиур</option>'+
                        '<option value="155">155-р тавиур</option>'+
                        '<option value="156">156-р тавиур</option>'+
                        '<option value="157">157-р тавиур</option>'+
                        '<option value="158">158-р тавиур</option>'+
                        '<option value="159">159-р тавиур</option>'+
                        '<option value="160">160-р тавиур</option>'+
                        '<option value="161">161-р тавиур</option>'+
                        '<option value="162">162-р тавиур</option>'+
                        '<option value="163">163-р тавиур</option>'+
                        '<option value="164">164-р тавиур</option>'+
                        '<option value="165">165-р тавиур</option>'+
                        '<option value="166">166-р тавиур</option>'+
                        '<option value="167">167-р тавиур</option>'+
                        '<option value="168">168-р тавиур</option>'+
                        '<option value="169">169-р тавиур</option>'+
                        '<option value="170">170-р тавиур</option>'+
                        '<option value="171">171-р тавиур</option>'+
                        '<option value="172">172-р тавиур</option>'+
                        '<option value="173">173-р тавиур</option>'+
                        '<option value="174">174-р тавиур</option>'+
                        '<option value="175">175-р тавиур</option>'+
                        '<option value="176">176-р тавиур</option>'+
                        '<option value="177">177-р тавиур</option>'+
                        '<option value="178">178-р тавиур</option>'+
                        '<option value="179">179-р тавиур</option>'+
                        '<option value="180">180-р тавиур</option>'+
                        '<option value="181">181-р тавиур</option>'+
                        '<option value="182">182-р тавиур</option>'+
                        '<option value="183">183-р тавиур</option>'+
                        '<option value="184">184-р тавиур</option>'+
                        '<option value="185">185-р тавиур</option>'+
                        '<option value="186">186-р тавиур</option>'+
                        '<option value="187">187-р тавиур</option>'+
                        '<option value="188">188-р тавиур</option>'+
                        '<option value="189">189-р тавиур</option>'+
                        '<option value="190">190-р тавиур</option>'+
                        '<option value="191">191-р тавиур</option>'+
                        '<option value="192">192-р тавиур</option>'+
                        '<option value="193">193-р тавиур</option>'+
                        '<option value="194">194-р тавиур</option>'+
                        '<option value="195">195-р тавиур</option>'+
                        '<option value="196">196-р тавиур</option>'+
                        '<option value="197">197-р тавиур</option>'+
                        '<option value="198">198-р тавиур</option>'+
                        '<option value="199">199-р тавиур</option>'+
                        '<option value="200">200-р тавиур</option>'+
                        '</select>');
                    }
                    
                if ($('select[name="options"]').val()=="delete")
                    {
                    $('#more').empty();
                    }
                    
                if ($('select[name="options"]').val()=="hand")
                    {
                    $('#more').empty();
                    }
            });
        })
    </script>
</body>
</html>    