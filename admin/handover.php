<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once("config.php");
require_once("views/helper.php");
require_once("views/login_check.php");
require_once("views/init.php");
?>
<link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">

<body class="sidebar-dark">
	<div class="main-wrapper">
		<?php  require_once("views/navbar.php"); ?>
	
		<div class="page-wrapper">
		<?php  require_once("views/sidebar.php"); ?>
				

		<div class="page-content">
			<?php
			if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="insert";
			$action_title = "Хүргэлт"; // Default value
			switch ($action)
			{
				case "select": $action_title="Barcode-г сонгож өөрчлөх";break;
				case "insert": $action_title="Barcode-г оруулах";break;
				case "inserting": $action_title="Ачааг сонгож үргэлжлүүлэх";break;
				case "handovering": $action_title="Хүргэлтээр гаргах";break;
				default: $action_title="Хүргэлт";break;
			}
			?>
			<nav class="page-breadcrumb">
				<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="handover">Хүргэлт</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?php echo $action_title;?></li>
				</ol>
			</nav>

            <?php
           
            if ($action=="insert")
            {
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">Хүргэлтээр гаргах</div>
                            <div class="card-body">
                                <div class="alert alert-warning">Та хүргэлтээр гаргах барааны Barcode оруулна уу</div>
                                <form action="?action=select" method="POST">
                                    <textarea name='handover' style="min-height:200px;" autofocus='autofocus' required='required' class='form-control mb-3'></textarea>
                                    <div id="result"></div>
                                    <button type="submit" class="btn btn-success">Оруулах</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            if ($action=="select")
            {
                if (isset($_POST["handover"]))
                    {
                    $deliver = $_POST["handover"];
                    $deliver_array=explode("\r\n",$deliver);
                    $deliver_array =array_unique ($deliver_array);
                    }
                    ?>
                        
                <script type="application/javascript">
                            $(document).ready(function() {
                                        $(".alert").hide();
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

                                $("#cash_value").hide();
                                $("#pos_value").hide();
                                $("#account_value").hide();
                        
                        
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
                        
                        
                        $(document).on('click', 'input[type="checkbox"][name="orders[]"]', function(event) {
                            var sum=0;
                            var count=0;
                            var total_price = 0;
                            var sum_weight=0;
                            var total_advance=0;
                            var grand_total=0;
                            var total_admin_value=0;
                            $('input[type="checkbox"][name="orders[]"]').each(function() {
                            if (this.checked == true) { 
                                var weight = $(this).attr('weight');
                                var advance = $(this).attr('advance');
                                var admin_value = $(this).parent().next().next().next().next().next().next().next().next().next().text();
                                
                                // Debug
                                console.log('Checkbox Click - weight:', weight, 'advance:', advance, 'checked:', this.checked);
                                
                                if (!isNaN(parseFloat(admin_value)))
                                    total_admin_value +=parseFloat(admin_value);

                                // Жин нэмэх - зөвхөн advance байхгүй үед (is_online==1 эсвэл advance==0)
                                if (weight && weight!="0" && weight!="")
                                    {
                                        if (!advance || advance=="" || advance=="0" || advance==0)
                                        sum_weight+=parseFloat(weight);
                                    }
                                // advance attribute-аас шууд утгыг авна - монголд тооцоотой илгээмж
                                if (advance !== undefined && advance !== null && advance !== "" && String(advance) !== "0")
                                    {
                                        var advance_num = parseFloat(advance);
                                        console.log('Checkbox click - Parsing advance:', advance, 'to number:', advance_num, 'isNaN:', isNaN(advance_num));
                                        if (!isNaN(advance_num) && advance_num > 0)
                                        {
                                            console.log('Checkbox click - Adding advance:', advance_num, 'to total_advance (current:', total_advance, ')');
                                            total_advance += advance_num;
                                            console.log('Checkbox click - New total_advance:', total_advance);
                                        }
                                    } else {
                                        console.log('Checkbox click - Advance not added, value:', advance);
                                    }			 
                                }
                                
                                })

                                if (sum_weight>1) total_price=7*sum_weight;
                                if (sum_weight>0.5 && sum_weight<=1) total_price=7;
                                if (sum_weight>0 && sum_weight<=0.5) total_price=5;
                                if (sum_weight==0) total_price=0;
                                
                                var grand_total = total_price+total_advance;
                                var grand_total_tug = grand_total*<?php echo cfg_rate();?>;

                                //alert (grand_total.toFixed(2));
                                $('#total_weight').val(sum_weight.toFixed(2));
                                $('#total_advance').val(total_advance.toFixed(2));
                                $('#total_admin').val(total_admin_value.toFixed(2));
                                $('#grand_total').val(grand_total.toFixed(2));
                                $('#grand_total_tug').val(grand_total_tug.toFixed(2));
                                //$('#grand_total').hide(100);
                                
                                $('#total_weight_inmodal').val(sum_weight.toFixed(2));
                                $('#grand_total_inmodal').val(grand_total.toFixed(2));
                                $('#total_admin_inmodal').val(total_admin_value.toFixed(2));
                                $('#grand_total_inmodal_tug').val(grand_total_tug.toFixed(2));
                                
                                // Модал цонхны "Дараа тооцоо /USD/" талбарт үлдэгдэл оруулах
                                var $total_advance_inmodal = $('#total_advance_inmodal');
                                if ($total_advance_inmodal.length > 0) {
                                    var value_to_set = total_advance.toFixed(2);
                                    $total_advance_inmodal.val(value_to_set);
                                    console.log('Checkbox clicked - Set #total_advance_inmodal to:', value_to_set, 'Current value:', $total_advance_inmodal.val());
                                } else {
                                    console.warn('Checkbox clicked - #total_advance_inmodal not found!');
                                }
                                
                                console.log('Checkbox clicked - total_advance:', total_advance, 'sum_weight:', sum_weight);
                            })
                            
                            // Модал цонхны талбаруудыг шинэчлэх функц
                            var updateModalFields = function() {
                                // Хүснэгтийн хөл хэсгийн "Төлбөртэй илгээмж ($)" талбарын утгыг авах
                                var total_advance_from_table = parseFloat($('#total_advance').val()) || 0;
                                var total_admin_from_table = parseFloat($('#total_admin').val()) || 0;
                                var total_weight_from_table = parseFloat($('#total_weight').val()) || 0;
                                var grand_total_from_table = parseFloat($('#grand_total').val()) || 0;
                                
                                console.log('updateModalFields - Table values:', {
                                    total_advance: total_advance_from_table,
                                    total_admin: total_admin_from_table,
                                    total_weight: total_weight_from_table,
                                    grand_total: grand_total_from_table
                                });
                                
                                // Хэрэв хүснэгтийн талбарт утга байвал түүнийг ашиглах
                                if (total_advance_from_table > 0 || total_admin_from_table > 0 || total_weight_from_table > 0) {
                                    var rate = <?php echo cfg_rate(); ?>;
                                    
                                    $('#total_weight_inmodal').val(parseFloat(total_weight_from_table).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                                    $('#total_advance_inmodal').val(parseFloat(total_advance_from_table).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                                    $('#total_admin_inmodal').val(parseFloat(total_admin_from_table).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                                    $('#grand_total_inmodal').val(parseFloat(grand_total_from_table).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                                    $('#grand_total_inmodal_tug').val(parseFloat(grand_total_from_table * rate).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '₮');
                                    
                                    console.log('updateModalFields - Using table values, set total_advance_inmodal to:', total_advance_from_table.toFixed(2));
                                } else {
                                    // Хэрэв хүснэгтийн талбар хоосон бол checkbox-уудаас тооцоолох
                                    var sum_weight = 0, total_advance = 0, total_price = 0, total_admin_value = 0;

                                    $('input[type="checkbox"][name="orders[]"]:checked').each(function() {
                                        var weight_attr = $(this).attr('weight');
                                        var advance_attr = $(this).attr('advance');
                                        var admin_attr = $(this).attr('admin-value');
                                        
                                        var weight = parseFloat(weight_attr) || 0;
                                        var advance = parseFloat(advance_attr) || 0;
                                        var admin = parseFloat(admin_attr) || 0;
                                        
                                        console.log('Checkbox - order_id:', $(this).val(), 'weight_attr:', weight_attr, 'advance_attr:', advance_attr, 'admin_attr:', admin_attr, 'parsed:', {weight: weight, advance: advance, admin: admin});

                                        total_admin_value += admin;

                                        if (advance > 0) {
                                            total_advance += advance;
                                        } else if (weight > 0) {
                                            sum_weight += weight;
                                        }
                                    });

                                    console.log('updateModalFields - Calculated from checkboxes:', {
                                        sum_weight: sum_weight,
                                        total_advance: total_advance,
                                        total_admin_value: total_admin_value
                                    });

                                    // Тээврийн зардлын логик
                                    if (sum_weight > 1) total_price = 7 * sum_weight;
                                    else if (sum_weight > 0.5) total_price = 7;
                                    else if (sum_weight > 0) total_price = 5;

                                    var grand_total = total_price + total_advance + total_admin_value;
                                    var rate = <?php echo cfg_rate(); ?>;

                                    $('#total_weight_inmodal').val(sum_weight.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                                    $('#total_advance_inmodal').val(total_advance.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                                    $('#total_admin_inmodal').val(total_admin_value.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                                    $('#grand_total_inmodal').val(grand_total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                                    $('#grand_total_inmodal_tug').val((grand_total * rate).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '₮');
                                    
                                    console.log('updateModalFields - Set total_advance_inmodal to:', total_advance.toFixed(2));
                                }
                            };
                            
                            // Модал цонх бүрэн нээгдсэний дараа утгыг шинэчлэх
                            $(document).on('shown.bs.modal', '#exampleModal', function (event) {
                                console.log('Modal opened (shown.bs.modal), updating fields...');
                                setTimeout(function() {
                                    updateModalFields();
                                }, 200);
                            });
                            
                            // Checkbox click үед модал цонхны талбаруудыг шинэчлэх
                            $(document).on('click', 'input[type="checkbox"][name="orders[]"]', function() {
                                setTimeout(updateModalFields, 50);
                            });

                        $('input[type="radio"]').change(function(){
                            if ($('input[type="radio"]:checked').val()=="mix")
                                {
                                $("#cash_value").show();
                                $("#pos_value").show();
                                $("#account_value").show();
                                }
                            })	
                    })
                </script>

                <form method="POST" action="?action=handovering">                
                    <div class="card">
                        <div class="card-header">Хүргэлтээр гаргах</div>
                            <div class="card-body">
                                <?php 
                                if (isset($_POST["handover"]))
                                {
                                    $deliver = $_POST["handover"];
                                    $deliver_array=explode("\r\n",$deliver);
                                    $deliver_array =array_unique ($deliver_array);
                                }
                                
                                if (isset($_POST["tel"]))
                                {
                                    $tel = $_POST["tel"];
                                }   
                                ?>
                                <table class='table table-hover'>
                                    <thead>
                                        <tr>
                                            <th><input type='checkbox' name='select_all' title='Select all orders'  checked='checked'></th>
                                            <th>№</th>
                                            <th>Илгээгч</th>
                                            <th>Х/а утас</th>
                                            <th class='track_td'>Barcode/Track</th>
                                            <th>Хоног</th>
                                            <th>Төлөв</th>
                                            <th>Жин</th>
                                            <th>Тооцоо /$/</th>
                                            <th>Админ тооцоо</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $count=1;$total_weight=0;$total_advance=0; $grand_total=0; $total_admin_value=0;
                                            if (isset($deliver))
                                            {
                                                foreach($deliver_array as $deliver_barcode)
                                                {
                                                        
                                                    if ($deliver_barcode!="")
                                                        {
                                                            $sql = "SELECT * FROM box_combine WHERE barcode='$deliver_barcode' LIMIT 1";

                                                            $result =mysqli_query($conn,$sql);
                                                            if (mysqli_num_rows($result)==0)
                                                            //if (substr($deliver_barcode,0,3)=="GO1" || substr($deliver_barcode,0,3)!="GO2") //SINGLE BARCODE
                                                            {
                                                                $sql="SELECT * FROM orders WHERE (barcode='$deliver_barcode' OR third_party='$deliver_barcode') LIMIT 1";
                                                                $result =mysqli_query($conn,$sql);
                                                                if (mysqli_num_rows($result)==1)
                                                                    {
                                                                        $data=mysqli_fetch_array($result);
                                                                        $order_id=$data["order_id"];
                                                                        $created_date=$data["created_date"];
                                                                        $sender=$data["sender"];
                                                                        $receiver=$data["receiver"];
                                                                        $barcode=$data["barcode"];
                                                                        $track=$data["third_party"];
                                                                        $weight=$data["weight"];
                                                                        $advance=$data["advance"];
                                                                        $advance_value=$data["advance_value"];
                                                                        $extra=$data["extra"];
                                                                        $status=$data["status"];
                                                                        $admin_value=$data["admin_value"];
                                                                        $proxy=$data["proxy_id"];
                                                                        $proxy_type=$data["proxy_type"];
                                                                        //$price=$weight*cfg_paymentrate();
                                                                        $is_online=$data["is_online"];
                                                                        $Package_advance = $data["advance"];
                                                                        $Package_advance_value =$data["advance_value"];
                                                                        $tr=0;
                                                                        if($status=="warehouse"&&$extra!="") 
                                                                        $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status;
                                                                        if ($Package_advance==1&&$is_online==0)
                                                                        {echo "<tr class='red' title='Үлдэгдэлтэй илгээмж:".number_format($Package_advance_value, 2, '.', ',')."$' alt='order'>"; $tr=1;}
                                                                        
                                                                        if ($Package_advance==0&&$is_online==0&&$tr==0)
                                                                        {echo "<tr class='green' title='Илгээмжийг шууд олго төлбөргүй' alt='order'>"; $tr=1;}
                                                                    
                                                                        if (!$tr) echo "<tr>";else $tr=0;
                                                                        
                                                                        
                                                                        
                                                                        ?>
                                                                        <tr>
                                                                            <td><input type="checkbox" name="orders[]" value="<?php echo $order_id;?>" checked="checked" weight="<?php echo $weight;?>" advance="<?php echo ($Package_advance==1) ? $Package_advance_value : '0';?>" admin-value="<?php echo ($admin_value!=0) ? $admin_value : '0';?>"></td>                                                                    
                                                                            <td><?php echo $count++;?></td>
                                                                            <td><a href="customers?action=detail&id=<?php echo $sender;?>"><?php echo substr(customer($sender,"surname"),0,2).".".customer($sender,"name");?></a></td>
                                                                            <td>
                                                                                <a href="customers?action=detail&id=<?php echo $receiver;?>"><?php echo substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name");?></a>
                                                                                <br><?php echo customer($receiver,"tel");?>
                                                                                <br><?php echo proxy2($proxy,$proxy_type,"name");?></td>
                                                                
                                                                
                                                                            <td class='track_td'>
                                                                                <?php echo barcode_comfort($barcode);?><br>
                                                                                <?php echo $track;?>
                                                                            </td>
                                                                            <td><?php echo days($created_date);?></td>
                                                                            <td><?php echo $temp_status;?></td>
                                                                            <td><?php echo $weight;?></td>                                                                    
                                                                            
                                                                            <td>
                                                                            <?php echo ($is_online==0)?number_format($Package_advance_value, 2, '.', ','):'';?>
                                                                            </td>
                                                                            
                                                                            <td>
                                                                            <?php echo ($admin_value!=0)?number_format($admin_value, 2, '.', ','):'';?>
                                                                            </td>
                                                                
                                                                            <td><a href="orders?action=detail&id=<?php echo $data["order_id"];?>"><span class="glyphicon glyphicon-edit"></span></a></td>
                                                                        </tr>
                                                            
                                                                        <?php
                                                                        if ($is_online==1) $total_weight+=$weight;
                                                            
                                                                        $total_admin_value+=$admin_value;
                                                            
                                                                        if ($Package_advance==1)
                                                                        $total_advance+=$Package_advance_value;
                                                                        
                                                                        //if ($is_online==1) $grand_total+=cfg_price($weight); else $grand_total+=$Package_advance_value;
                                                                        
                                                                        
                                                                    }
                                                            }
                                                        
                                                            $sql = "SELECT * FROM box_combine WHERE barcode='$deliver_barcode' LIMIT 1";
                                                            $result= mysqli_query($conn,$sql);
                                                            if (mysqli_num_rows($result)==1)

                                                            //if (substr($deliver_barcode,2,1)=="2") //COMBINE BARCODE
                                                            {
                                                                $sql="SELECT * FROM box_combine WHERE barcode='$deliver_barcode'";
                                                                $result= mysqli_query($conn,$sql);
                                                                if (mysqli_num_rows($result)==1)
                                                                {
                                                                    $data = mysqli_fetch_array($result);
                                                                    $barcodes = $data["barcodes"];
                                                                    foreach(explode(",",$barcodes) as $barcode_single)
                                                                    {
                                                                    if ($barcode_single!="")
                                                                        {
                                                                        $query_single = mysqli_query($conn, "SELECT * FROM orders WHERE barcode = '".mysqli_real_escape_string($conn, $barcode_single)."'");
                                                                        if ($query_single && mysqli_num_rows($query_single) > 0)
                                                                        {
                                                                        while ($data_single = mysqli_fetch_array($query_single))
                                                                        {
                                                                        $order_id=$data_single["order_id"];
                                                                        $created_date=$data_single["created_date"];
                                                                        $sender=$data_single["sender"];
                                                                        $receiver=$data_single["receiver"];
                                                                        $barcode=$data_single["barcode"];
                                                                        $track=$data_single["third_party"];
                                                                        $weight=$data_single["weight"];
                                                                        $advance=$data_single["advance"];
                                                                        $advance_value=$data_single["advance_value"];
                                                                        $extra=$data_single["extra"];
                                                                        $status=$data_single["status"];
                                                                        $admin_value=$data_single["admin_value"];
                                                                        $proxy=$data_single["proxy_id"];
                                                                        //$price=$weight*cfg_paymentrate();
                                                                        $is_online=$data_single["is_online"];
                                                                        $Package_advance = $data_single["advance"];
                                                                        $Package_advance_value =$data_single["advance_value"];
                                                                        $tr=0;
                                                                        if($status=="warehouse"&&$extra!="") 
                                                                        $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status;
                                                                        if ($Package_advance==1&&$is_online==0)
                                                                        {echo "<tr class='red' title='Үлдэгдэлтэй илгээмж:".number_format($Package_advance_value, 2, '.', ',')."$' alt='order'>"; $tr=1;}
                                                                        
                                                                        if ($Package_advance==0&&$is_online==0&&$tr==0)
                                                                        {echo "<tr class='green' title='Илгээмжийг шууд олго төлбөргүй' alt='order'>"; $tr=1;}
                                                                    
                                                                        if (!$tr) echo "<tr>";else $tr=0;
                                                                
                                                                
                                                                            $advance_attr = ($Package_advance==1) ? $Package_advance_value : '0';
                                                                            $admin_attr = ($admin_value != 0) ? $admin_value : '0';
                                                                            echo "<td><input type='checkbox' name='orders[]' value='".$order_id."' checked='checked' weight='$weight' advance='$advance_attr' admin-value='$admin_attr'></td>"; 
                                                                            echo "<td>".$count++."</td>"; 
                                                                            echo "<td><a href='customers?action=detail&id=".$sender."'>".substr(customer($sender,"surname"),0,2).".".customer($sender,"name")."</a></td>";
                                                                            echo "<td>";
                                                                            echo customer($receiver,"tel");
                                                                            echo "<br>".proxy($proxy,"name")."</td>";
                                                                
                                                                
                                                                            echo "<td class='track_td'>".barcode_comfort($barcode)."<br>"; 
                                                                            echo $track."</td>";
                                                                            echo "<td>".days($created_date)."</td>"; 
                                                                            echo "<td>".$temp_status."</td>"; 
                                                                            echo "<td>".$weight."</td>"; 
                                                                        //	echo "<td>".$weight*cfg_paymentrate()."</td>"; 
                                                                            
                                                                            echo "<td>";
                                                                            if ($is_online==0) echo number_format($Package_advance_value, 2, '.', ',');
                                                                            echo "</td>"; 
                                                                            
                                                                            echo "<td>";
                                                                            if ($admin_value!=0) echo number_format($admin_value, 2, '.', ',');
                                                                            echo "</td>"; 
                                                                
                                                                            echo "<td><a href='orders?action=detail&id=".$order_id."'><span class='glyphicon glyphicon-edit'></span></a></td>";
                                                                        echo "</tr>";
                                                            
                                                                        if ($is_online==1) $total_weight+=$weight;
                                                            
                                                                        $total_admin_value+=$admin_value;
                                                            
                                                                        if ($Package_advance==1)
                                                                        $total_advance+=$Package_advance_value;
                                                                
                                                                        //if ($is_online==1) $grand_total+=cfg_price($weight); else $grand_total+=$Package_advance_value;
                                                                
                                                                
                                                                        }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                }
                                                if ($total_advance==0) $grand_total = cfg_price($total_weight);
                                                else $grand_total =$total_advance;
                                                echo "<tr class='total'><td colspan='5'>Нийт жин (Kg)</td><td colspan='5'>";
                                                echo "<input type='text' id='total_weight' value='".number_format($total_weight,2)."' readonly='readonly' name='total_weight'></td></tr>";
                                                echo "<tr class='total'><td colspan='5'>Төлбөртэй илгээмж($)</td><td colspan='5'>";
                                                echo "<input type='text' id='total_advance' value='".number_format($total_advance,2)."' readonly='readonly' name='total_advance'></td></tr>";
                                                
                                                echo "<tr class='total'><td colspan='5'>Дараа тооцоо ($) /Хашбал/</td><td colspan='5'>";
                                                echo "<input type='text' id='total_admin' value='".number_format($total_admin_value,2)."' readonly='readonly' name='total_admin'></td></tr>";
                                                
                                                echo "<tr class='total'><td colspan='5'>Нийт төлбөр зохих ($)</td><td colspan='5'>";
                                                echo "<input type='text' id='grand_total' value='".number_format($grand_total+$total_admin_value,2)."' readonly='readonly' name='grand_total'></td></tr>";
                                                echo "<tr class='total'><td colspan='5'>Нийт төлбөр зохих (₮)</td><td colspan='5'>";
                                                echo "<input type='text' id='grand_total_tug' value='".number_format(($grand_total+$total_admin_value)*cfg_rate(), 2, '.', ',')."₮' readonly='readonly' name='grand_total_tug'></td></tr>";
                                            }
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                            if (isset($tel))
                                                {
                                                    $sql="SELECT orders.*,orders.status AS realstatus FROM orders LEFT JOIN customer ON orders.receiver=customer.customer_id WHERE customer.tel='".mysqli_real_escape_string($conn, $tel)."' AND orders.status NOT IN('weight_missing')";
                                                    $query = mysqli_query($conn, $sql);
                                                    if ($query && mysqli_num_rows($query) > 0)
                                                    {
                                                    while ($data = mysqli_fetch_array($query))
                                                        {
                                                            $order_id=$data["order_id"];
                                                            $created_date=$data["created_date"];
                                                            $sender=$data["sender"];
                                                            $receiver=$data["receiver"];
                                                            $barcode=$data["barcode"];
                                                            $track=$data["third_party"];
                                                            $weight=$data["weight"];
                                                            $advance=$data["advance"];
                                                            $advance_value=$data["advance_value"];
                                                            $status=$data["realstatus"];
                                                            $extra=$data["extra"];
                                                            $proxy=$data["proxy_id"];
                                                            $proxy_type=$data["proxy_type"];
                                                            //$price=$weight*cfg_paymentrate();
                                                            $is_online=$data["is_online"];
                                                            $Package_advance = $data["advance"];
                                                            $Package_advance_value =$data["advance_value"];
                                                            $admin_value = $data["admin_value"];
                                                            $tr=0;
                                                            if($status=="warehouse"&&$extra!="") 
                                                            $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status;
                                                            if ($Package_advance==1&&$is_online==0&&$tr==0)
                                                            {echo "<tr class='red' title='Үлдэгдэлтэй илгээмж:".$Package_advance_value."$'>"; $tr=1;}

                                                            if ($Package_advance==0&&$is_online==0&&$tr==0)
                                                            {echo "<tr class='green' title='Илгээмжийг шууд олго төлбөргүй'>"; $tr=1;}
                                                            if (!$tr) echo "<tr>";else $tr=0;

                                                            
                                                            $advance_attr = ($Package_advance==1) ? $Package_advance_value : '0';
                                                            $admin_attr = ($admin_value != 0) ? $admin_value : '0';
                                                            echo "<td><input type='checkbox' name='orders[]' value='".$order_id."' checked='checked' weight='".$weight."' advance='".$advance_attr."' admin-value='".$admin_attr."'></td>"; 
                                                            echo "<td>".$count++."</td>"; 
                                                            echo "<td><a href='customers?action=detail&id=".$sender."'>".substr(customer($sender,"surname"),0,2).".".customer($sender,"name")."</a></td>";
                                                            echo "<td><a href='customers?action=detail&id=".$receiver."'>".substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name")."</a><br>";
                                                            echo customer($receiver,"tel");
                                                            echo "<br>".proxy2($proxy,$proxy_type,"name")."</td>";

                                                            echo "<td>".barcode_comfort($barcode)."<br>"; 
                                                            echo $track."</td>";
                                                            echo "<td>".days($created_date)."</td>"; 
                                                            echo "<td>".$temp_status."</td>"; 
                                                            echo "<td>".$weight."</td>"; 
                                                            
                                                            echo "<td>";
                                                            if ($is_online==0) echo number_format($Package_advance_value, 2, '.', ',');
                                                            echo "</td>"; 
                                                            
                                                            echo "<td>";
                                                            if ($admin_value!=0) echo number_format($admin_value, 2, '.', ',');
                                                            echo "</td>"; 

                                                            echo "<td><a href='orders?action=detail&id=".$data["order_id"]."'><span class='glyphicon glyphicon-edit'></span></a></td>";
                                                            echo "</tr>";
                                                            
                                                            
                                                            
                                                            if ($is_online==1) $total_weight+=$weight;

                                                            if ($is_online==0&&$Package_advance==1)
                                                            $total_advance+=$Package_advance_value;
                                                            $total_admin_value+=$admin_value;
                                                            //if ($is_online==1) $grand_total+=cfg_price($weight); else $grand_total+=$Package_advance_value;
                                                        }
                                                    }
                                                    if ($total_advance==0) $grand_total = cfg_price($total_weight);
                                                        else $grand_total =$total_advance;


                                                            echo "<tr class='total'><td colspan='5'>Нийт жин (Kg)</td><td colspan='6'>";
                                                            echo "<input type='text' id='total_weight' value='".number_format($total_weight,2)."' readonly='readonly' name='total_weight'></td></tr>";
                                                            echo "<tr class='total'><td colspan='5'>Төлбөртэй илгээмж($)</td><td colspan='6'>";
                                                            echo "<input type='text' id='total_advance' value='".number_format($total_advance,2)."' readonly='readonly' name='total_advance'></td></tr>";
                                                            
                                                            echo "<tr class='total'><td colspan='5'>Дараа тооцоо ($) /Хашбал/</td><td colspan='6'>";
                                                            echo "<input type='text' id='total_admin' value='".number_format($total_admin_value,2)."' readonly='readonly' name='total_admin'></td></tr>";
                                                            
                                                            echo "<tr class='total'><td colspan='5'>Нийт төлбөр зохих ($)</td><td colspan='6'>";
                                                            echo "<input type='text' id='grand_total' value='".number_format($grand_total+$total_admin_value,2)."' readonly='readonly' name='grand_total'></td></tr>";
                                                            echo "<tr class='total'><td colspan='5'>Нийт төлбөр зохих (₮)</td><td colspan='6'>";
                                                            echo "<input type='text' id='grand_total_tug' value='".number_format(($grand_total+$total_admin_value)*cfg_rate(), 2, '.', ',')."₮' readonly='readonly' name='grand_total_tug'></td></tr>";

                                                }

                                                ?>                            
                                    </tbody>
                                </table>
                            </div>
                        </div>
                                
                                
                        
                        
                        
                        
                        
                        
                        
                            <!--button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Open modal for @mdo</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat">Open modal for @fat</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Open modal for @getbootstrap</button-->


                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel">Тооцоо бодох</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Тооцоо /КГ/ </label>
                                    <input type="text" class="form-control" id="total_weight_inmodal" readonly="readonly" value="<?php echo number_format($total_weight, 2, '.', ',');?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Тооцоо /USD/ </label>
                                    <input type="text" class="form-control" id="grand_total_inmodal" readonly="readonly"  value="<?php echo number_format($grand_total, 2, '.', ',');?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Дараа тооцоо /USD/ (Ачааны үлдэгдэл)</label>
                                    <input type="text" class="form-control" id="total_advance_inmodal" readonly="readonly"  value="<?php echo number_format($total_advance, 2, '.', ',');?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Дараа тооцоо /USD/ (Хашбал)</label>
                                    <input type="text" class="form-control" id="total_admin_inmodal" readonly="readonly"  value="<?php echo number_format($total_admin_value, 2, '.', ',');?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Тооцоо /Төг/ </label>
                                    <input type="text" class="form-control" id="grand_total_inmodal_tug" readonly="readonly"  value="<?php echo number_format(($grand_total+$total_admin_value)*cfg_rate(), 2, '.', ',');?>₮">
                                </div>
                                
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Арга</label>
                                    
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-primary active ">
                                            <input type="radio" name="method" id="option1" autocomplete="off" checked value="cash"> Бэлэн 
                                        </label>
                                        <label class="btn btn-primary ">
                                            <input type="radio" name="method" id="option2" autocomplete="off" value="pos"> POS машинаар
                                        </label>
                                        <label class="btn btn-primary ">
                                            <input type="radio" name="method" id="option3" autocomplete="off" value="account"> Дансаар
                                        </label>
                                        <label class="btn btn-primary ">
                                            <input type="radio" name="method" id="option4" autocomplete="off" value="later"> Дараа тооцоо
                                        </label>
                                        <label class="btn btn-primary ">
                                            <input type="radio" name="method" id="option5" autocomplete="off" value="mix"> Холимог
                                        </label>
                                        </div>
                                </div>
                                <input type="text" name="cash_value" id="cash_value" placeholder="Бэлэн" value="0">
                                <input type="text" name="pos_value" id="pos_value" placeholder="Картаар"  value="0">
                                <input type="text" name="account_value" id="account_value" placeholder="Данс"  value="0">          
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Гүйцэтгэх</button>
                            </div>
                            </div>
                        </div>
                        </div>
                
                
                    
                        <!--div class="panel panel-success">
                        <div class="panel-heading">Хүргэлтээр гаргах мэдээлэл</div>
                        <div class="panel-body"-->
                        <?php
                        if ($count>1) 
                        {
                            /*echo "<table class='table table-hover'>";

                            echo "<tr><td>Утас:(*)</td><td>".form_input ("contacts","",array("class"=>"form-control"))."</td></tr>";
                            echo "<tr><td colspan='2'><span id='result' class='alert alert-danger alert-small' role='alert'></span></td></tr>";
                            echo "<tr><td>Нэр(*)</td><td>".form_input ("name","",array("class"=>"form-control"))."</td></tr>";
                            echo "<tr><td>Овог</td><td>".form_input ("surname","",array("class"=>"form-control"))."</td></tr>";
                            echo "<tr><td>РД</td><td>".form_input ("rd","",array("class"=>"form-control"))."</td></tr>";
                            echo "<tr><td>И-мейл(*)</td><td>".form_input ("email","",array("class"=>"form-control"))."</td></tr>";
                            echo "<tr><td>Хаяг(*)</td><td>".form_textarea ("address","",array("class"=>"form-control"))."</td></tr>";
                            echo "</table>";
                            //if($query->num_rows()>0) echo form_submit("Олгох","Олгох",array("class"=>"btn btn-success"));

                            */
                            // echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Хүргэлтээр гаргах</button>';
                            echo '<input type="submit" class="btn btn-success" value="Хүргэлтээр гаргах">';
                            ?>
                            <?php
                        }
                        ?>
                            </form>
            <?php
            }
                
	
    
    
	
	


	



            }

            if ($action=="handovering")
            {
                $error = TRUE;

                if(isset($_POST['orders'])) 
                {
                    $orders=$_POST['orders'];$N = count($orders);
                       $barcodes=array();
                    for($i=0; $i < $N; $i++)
                    {
                        $order_id = intval($orders[$i]); // Sanitize as integer
                        $order_id_escaped = mysqli_real_escape_string($conn, $order_id);
                        $sql="SELECT * FROM orders WHERE order_id='".$order_id_escaped."' LIMIT 1";
                        
                        $result= mysqli_query($conn,$sql);
                        if ($result && mysqli_num_rows($result) == 1)
                        {
                            $data=mysqli_fetch_array($result);
                            $status = $data["status"];                        
                
                            $warehouse_date = date("Y-m-d H:i:s");
                            $warehouse_date_escaped = mysqli_real_escape_string($conn, $warehouse_date);
                            $sql = "UPDATE orders SET status='warehouse',warehouse_date='".$warehouse_date_escaped."',extra='999' WHERE order_id='".$order_id_escaped."' LIMIT 1";
                            // 999-Хүргэлтээр гарсан
                            array_push($barcodes,$data["barcode"]);
                            if (mysqli_query($conn,$sql)) {
                                $error=FALSE;
                            } else {
                                $error = TRUE;
                                error_log("UPDATE failed for order_id: ".$order_id." - ".mysqli_error($conn));
                            }
                        } else {
                            $error = TRUE;
                            error_log("Order not found: ".$order_id);
                        }
                    }
                }

                
                if(!$error&&isset($_POST['orders'])) {
                    echo '<div class="alert alert-success" role="alert">Амжилттай өөрчиллөө</div>';
                } else if(isset($_POST['orders'])) {
                    echo '<div class="alert alert-danger" role="alert">Хүргэлтээр гаргахад алдаа гарлаа. Error: '.htmlspecialchars(mysqli_error($conn)).'</div>';
                }
                
                if(isset($_POST['orders'])) 
                {
                    echo "<table class='table table-hover'>";
                    echo "<tr>";
                    echo "<th>№</th>"; 
                    echo "<th>Х/авах</th>"; 
                    echo "<th>Утас</th>";
                       echo "<th>Barcode/track</th>"; 
                       echo "<th>Жин</th>"; 
                       //echo "<th>Төлбөр</th>"; 
                       //echo "<th>Үлдэгдэл</th>";
                    //echo "<th>Арга</th>";
                       echo "<th></th>"; 
                       echo "</tr>";
                    $count=1;$total_weight=0;$total_admin_value=0;$total_advance =0; 
                    $orders=$_POST['orders'];$N = count($orders);
            
                    for($i=0; $i < $N; $i++)
                        {
                            $order_id_safe = mysqli_real_escape_string($conn, intval($orders[$i]));
                            $sql="SELECT * FROM orders WHERE order_id='".$order_id_safe."' LIMIT 1";
                            $result= mysqli_query($conn,$sql);
                            if (mysqli_num_rows($result)==1)
                            {
                                $data=mysqli_fetch_array($result);
                                $order_id=$data["order_id"];                            
                                $receiver=$data["receiver"];                            
                                $barcode=$data["barcode"];
                                $track=$data["third_party"];
                                $weight=$data["weight"];
                                $admin_value=$data["admin_value"];
                                $is_online =$data["is_online"];
                                $deliver =$data["deliver"];
                                $advance =$data["advance"];
                                $advance_value =$data["advance_value"];
                                ?>

                                <tr>
                                    <td><?php echo $count++;?></td>
                                
                                    <td><a href="customers?action=detail&id=<?php echo $receiver;?>"><?php echo substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name");?></a></td>
                                    <td><a href="customers?action=detail&id=<?php echo $deliver;?>"><?php echo substr(customer($deliver,"surname"),0,2).".".customer($deliver,"name");?></a></td>
                                
                                    <td><?php echo $barcode;?><br><?php echo $track;?></td>
                                
                                    <td><?php echo $weight;?></td>
                                
                                </tr>
                                    <?php            
                                    $total_weight+=$weight;
                                    $total_admin_value+=$admin_value;
                                    if ($is_online==0&&$advance==1)
                                        $total_advance+=$advance_value;
                            }
                        }   

                    ?>
                    <tr class='total'><td colspan='4'>Нийт</td><td id='total_weight'><?php echo $total_weight;?></td></tr>
                </table>

                    <?php
                    if ($count>0)
                        {
                        ?>
                        <script type="text/javascript" language="Javascript">window.open('handover_bill?orders=<?php echo implode(",",$orders);?>');</script>
                        
                        <?php
                        }
                    ?>

                <?php
                }
	
            }
            ?>
           




		</div>

		<?php require_once("views/footer.php");?>
		
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