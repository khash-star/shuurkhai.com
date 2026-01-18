<?php
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
			if (isset($_GET["action"])) $action=protect($_GET["action"]); else $action="dashboard";
			$action_title = "Чингэлэг"; // Default value
			switch ($action)
			{
				case "dashboard": $action_title="Хянах самбар";break;
				case "active": $action_title="Идэвхитэй чингэлэг";break;
				case "detail": $action_title="Чингэлэгийн ачаа";break;
				default: $action_title="Чингэлэг";break;
			}
			?>
			<nav class="page-breadcrumb">
				<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="container">Чингэлэг</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?php echo $action_title;?></li>
				</ol>
			</nav>

            <?php
                if ($action=="active")
                {                    
                    
                    $sql="SELECT * FROM container WHERE status NOT IN ('delivered') ORDER BY created DESC";
                    $result = mysqli_query($conn,$sql);
                    $total_weight =0;

                    if ($result && mysqli_num_rows($result) > 0)
                    {
                        echo "<table class='table table-hover table-striped'>";
                        echo "<tr>";
                        echo "<th>№</th>"; 
                        echo "<th>Нэр</th>"; 
                        echo "<th>Үүсгэсэн</th>"; 
                        echo "<th>Төлөв</th>";
                        echo "<th>Доторхи ачаа</th>"; 
                        echo "<th>Монголд</th>"; 
                        echo "<th width='100'>Үйлдэл</th>"; 
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
                            <td><?php echo $count++;?></td>
                            <td><?php echo htmlspecialchars($name);?></td>
                            <td><?php echo htmlspecialchars($created);?></td>
                            <td><?php echo htmlspecialchars($status);?></td>
                            <td>
                            <?php
                                $sql="SELECT * FROM container_item WHERE container=".intval($container_id);
                                $query_container = mysqli_query($conn,$sql);
                                if ($query_container) {
                                    echo mysqli_num_rows($query_container);
                                } else {
                                    echo "0";
                                }
                            ?>
                            </td>
                            <td><?php echo htmlspecialchars($expected);?></td>
                            <td><a href="?action=detail&id=<?php echo $container_id;?>" class="btn btn-primary">Чингэлэгийн ачаа</a></td>
                            </tr>
                            <?php
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
                        if ($result && mysqli_num_rows($result)==1)
                        {
                            $data = mysqli_fetch_array($result);
                            $name=$data["name"];
                            $created=$data["created"];
                            $departed=$data["departed"];
                            $expected=$data["expected"];
                            $description=$data["description"];
                            $status=$data["status"];
                            echo "<h1>".$name.'</h1>';
                            echo "Үүсгэсэн огноо:".$created."<br>";
                            echo "Төлөв:".$status."<br>";
                            echo "Америкаас гарсан огноо:".$departed."<br>";
                            echo "Монголд очих огноо:".$expected."<br>";
                            echo "<p>".$description."</p>";

                            // $data = array(array('Чингэлэгийн дугаар',$name."(".$expected.")",'','','','','','','','',''));

                        }
                        echo "<b>Чингэлэг лог</b><br>";
                        $result=mysqli_query($conn,"SELECT * FROM container_log WHERE container='".intval($container_id)."' ORDER BY date DESC");
                        if ($result && mysqli_num_rows($result) > 0)
                        {	 
                                echo "<table class='table table-hover table-stripe table-bordered'>";
                                echo "<tr>";
                                echo "<th>№</th>"; 
                                echo "<th>Огноо</th>"; 
                                echo "<th>Тайлбар</th>";
                                echo "<th>Үйлдэл</th>"; 
                                echo "</tr>";
                                $count=1;
                                while ($data = mysqli_fetch_array($result))
                                    { 
                                $date = isset($data["date"]) ? $data["date"] : "";
                                $description = isset($data["description"]) ? $data["description"] : "";
                                
                                echo "<tr>";
                                echo "<td>".$count++."</td>";
                                echo "<td>".htmlspecialchars($date)."</td>";
                                echo "<td>".htmlspecialchars($description)."</td>";
                                echo "<td>";
                                echo "<a href='agents?action=container_log_edit&id=".$container_id."' class='btn btn-primary'>Засах</a>";
                                    //echo anchor("agents/container_log_delete/".$container_id,"устгах",array("class"=>"btn btn-alert btn-xs"));

                                echo "</td>";
                                echo "</tr>";
                                }
                            echo "</table>";
                        }
                        else echo "No log";

                        echo "<hr>";

                            echo "<b>Доторхи ачаа</b><br>";

                        $result=mysqli_query($conn,"SELECT * FROM container_item WHERE container='".intval($container_id)."'");
                        if ($result && mysqli_num_rows($result) > 0)
                        {	 	
                                $total_weight=$total_payment=$total_pay_in_mongolia=$grandtotalprice=0;
                                // array_push($data,array('Barcode','Илгээгч','Илгээгч дугаар','Хүлээн авагч','Х/а дугаар','Тайлбар','Барааны тайлбар','Барааны үнэ','Хэмжээ','Төлбөр','Монголд Тооцоо'));
                                ?>

                                <table class='table table-hover table-striped table-bordered'>
                                    <thead>
                                        <tr>
                                        <th>№</th>
                                        <th width="200">Barcode / Тайлбар</th>
                                        <th width="150">Илгээгч/ Хүлээн авагч</th>
                                        <th>Хэмжээ</th>
                                        <th>Барааны үнэ</th>
                                        <th>Төлбөр</th>
                                        <th>Монголд Тооцоо</th>
                                        <th width="20"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $count=1;
                                            while ($data=mysqli_fetch_array($result))
                                                {
                                                $item=isset($data["id"]) ? $data["id"] : 0;
                                                $sender=isset($data["sender"]) ? $data["sender"] : 0;
                                                $receiver=isset($data["receiver"]) ? $data["receiver"] : 0;
                                                $description=isset($data["description"]) ? $data["description"] : "";
                                                $barcode=isset($data["barcode"]) ? $data["barcode"] : "";
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
                                                        <td><?php echo $count++;?></td>
                                                        <td class="text-wrap">
                                                            <a href="?action=item_detail&id=<?php echo $item;?>"><?php echo $barcode;?></a>
                                                            <br><?php echo $description.$product_detail;?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if (function_exists('customer')) {
                                                                $sender_surname = customer($sender,"surname");
                                                                $sender_name = customer($sender,"name");
                                                                $receiver_surname = customer($receiver,"surname");
                                                                $receiver_name = customer($receiver,"name");
                                                            } else {
                                                                $sender_surname = "";
                                                                $sender_name = "";
                                                                $receiver_surname = "";
                                                                $receiver_name = "";
                                                            }
                                                            ?>
                                                            <a href="customers?action=detail&id=<?php echo $sender;?>"><?php echo htmlspecialchars(substr($sender_surname,0,2).".".$sender_name);?></a><br>
                                                            <a href="customers?action=detail&id=<?php echo $receiver;?>"><?php echo htmlspecialchars(substr($receiver_surname,0,2).".".$receiver_name);?></a><br>
                                                        </td>
                                                        <td><?php echo $weight;?></td>
                                                        <td><?php echo $price;?>$</td>
                                                        <td><?php echo $payment;?>$</td>
                                                        <td><?php echo $pay_in_mongolia;?>$</td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="?action=item_edit&id=<?php echo $item;?>" class="btn btn-success">Засах</a>
                                                                <a href="?action=item_out&id=<?php echo $item;?>" class="btn btn-danger">Гаргах</a>                                                    
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan='3'>Нийт</td>
                                            <td><?php echo $total_weight;?>Kg</td>
                                            <td><?php echo $total_payment;?>$</td>
                                            <td><?php echo $total_pay_in_mongolia;?>$</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                            </table>
                            <?php                            
                        }
                        else echo "No log";
                    }
                    else echo "container id not found";
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