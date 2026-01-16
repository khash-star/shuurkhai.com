<script type="application/javascript">
$(document).ready(function() {
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
	
	
	$('input[name="contacts"]').change(function(){
		$('#result').append('<img src="<?=base_url()?>assets/images/ajax-loader.gif" id="loading">');
		var tel= $('input[name="contacts"]').val();
	$.ajax ({
		url: '<?=base_url()?>index.php/admin/customers_check',
		type:'POST',
		data:'tel='+tel,
		success: function(responce){
									$('#responce').remove();
									$('#result').append(responce);
									$('#result').show(500);
									$('#loading').remove();

									if (responce=="Found user") 
									{
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=rd',
										success: function(responce0){
											$('input[name="rd"]').val(responce0);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=surname',
										success: function(responce1){
											$('input[name="surname"]').val(responce1);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=name',
										success: function(responce2){
											$('input[name="name"]').val(responce2);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=email',
										success: function(responce3){
											$('input[name="email"]').val(responce3);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=address',
										success: function(responce4){
											$('textarea[name="address"]').text(responce4);
																	}
												});	
									}
									}
		});	
	});
		
		$('select[name="options"]').change(function()
		{
		if ($('select[name="options"]').val()=="onair")
			{
			$('#more').empty();
			}
			
		if ($('select[name="options"]').val()=="custom")
			{
			$('#more').empty();
			}
		
		if ($('select[name="options"]').val()=="warehouse")
			{
			$('#more').empty();
			$('#more').append('<select name="bench">'+
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
			'</select>');
			}
		})
		 
   
});
</script>
<div class="panel panel-primary">
  <div class="panel-heading">Barcode:Selecting</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT barcode.*,barcode.timestamp AS tsp,orders.* FROM barcode LEFT JOIN orders ON barcode.barcode=orders.barcode ORDER BY tsp DESC");

if ($query->num_rows() > 0)
{
	echo form_open ("admin/barcode_elimination");
	echo "<table class='table table-hover'>";
	 echo "<tr>";
	   echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all barcodes'))."</th>"; 
	   echo "<th>№</th>"; 
	   echo "<th>Barcode оруулсан</th>"; 
	   echo "<th>Barcode</th>"; 
	   echo "<th>Захиалгын огноо</th>"; 
       echo "<th>Илгээгч</th>"; 
	   echo "<th>Х/авагч</th>"; 
	   echo "<th>Х/авагч утас</th>"; 
	   echo "<th>Хоног</th>"; 
	   echo "<th>Төлөв</th>"; 
	   echo "<th></th>"; 
	   echo "</tr>";
	   $count=1;
	foreach ($query->result() as $row)
	{  
		$timestamp=$row->tsp;
		$created_date=$row->created_date;
		$order_id=$row->order_id;
  	 	$sender_id=$row->sender;
   		$receiver_id=$row->receiver;
		$barcode=$row->barcode;
		$package=$row->package;
		$insurance=$row->insurance;
		$insurance_value=$row->insurance_value;
		$status=$row->status;
		$Package_advance = $row->advance;
		$Package_advance_value = $row->advance_value;

		//SENDER 
		if ($sender_id!="" && $sender_id!=1)
			{
			$query_sender = $this->db->query("SELECT * FROM customer WHERE customer_id='$sender_id' LIMIT 1");
			$row_sender = $query_sender->row();
			$s_name=$row_sender->name;
			$s_surname=$row_sender->surname;
			$s_tel=$row_sender->tel;
			$s_email=$row_sender->email;
			}
			else {$s_name="";$s_surname="";$s_tel="";$s_email="";}
		
		//RECIEVER
	if ($receiver_id!="" && $receiver_id!=1)
		{
			$query_receiver = $this->db->query("SELECT * FROM customer WHERE customer_id='$receiver_id' LIMIT 1");
			$row_receiever =  $query_receiver->row();
			$r_name=$row_receiever->name;
			$r_surname=$row_receiever->surname;
			$r_tel=$row_receiever->tel;
			$r_email=$row_receiever->email;
		}
		else {$r_name="";$r_surname="";$r_tel="";$r_email="";}
		$days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;

	
	  	if ($Package_advance==1)
		echo "<tr class='red' title='Үлдэгдэл:".$Package_advance_value."$'>"; 
		else echo "<tr>";
		
	   echo "<td>".form_checkbox("barcode_id[]",$barcode)."</td>"; 
	   echo "<td>".$count++."</td>";
	   echo "<td>".$timestamp."</td>"; 
	   echo "<td>".$barcode."</td>"; 
	   echo "<td>".$created_date."</td>"; 
	   echo "<td>"; if($s_name!="") echo anchor("customers/detail/".$sender_id,substr($s_surname,0,2).".".$s_name); echo "</td>"; 

 		echo "<td>"; if($r_name!="") echo anchor("customers/detail/".$receiver_id,substr($r_surname,0,2).".".$r_name); echo "</td>"; 	 
		
	   echo "<td>".$r_tel."</td>"; 
	   echo "<td>".$days."</td>"; 
	   echo "<td>".$status."</td>"; 
	   echo "<td>".anchor('orders/detail/'.$row->order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
	   echo "</tr>";
	} 
	echo "</table>";
	
	$options = array(
                  'delivered'  => 'Хүргэж өгсөн',
                 // 'onair'    => 'Онгоцоор ирж байгаа',
                  'warehouse'   => 'Агуулахад орсон',
                  'custom' => 'Гааль',
				  'delete' => 'Barcode устгах',
                );


	echo form_dropdown('options', $options,'delivered');
	echo "<div id='more'></div>";
	echo form_submit("submit","өөрчил");
	echo form_close();
}
else echo "Barcode байхгүй";


?>

</div>
</div>