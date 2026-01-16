<script>
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
	
	
	
	 $('select[name="options"]').change(function(){
		if ($('select[name="options"]').val()=="delivered")
			{
			$('#more').empty();
			
			$('#more').append('<div class="box">');
			$('#more').append('<h4 class="legend">Хүлээн авагч</h4>');
			$('#more').append("<span class='formspan'>Утас:</span>");
			$('#more').append('<? echo form_input ("deliver_contact")."<div id=\"deliver_result\"></div><br>"?>');
			$('#more').append("<span class='formspan'>Нэр:</span>");
			$('#more').append('<? echo form_input ("deliver_name")."";?>');
			$('#more').append("<span class='formspan'>Овог:</span>");
			$('#more').append('<? echo form_input ("deliver_surname")."";?>');
			$('#more').append("<span class='formspan'>РД:</span>");
			$('#more').append('<? echo form_input ("deliver_rd")."<br>";?>');
			$('#more').append("<span class='formspan'>И-мейл:</span>");
			$('#more').append('<? echo form_input ("deliver_email")."<br>";?>');
			$('#more').append("<span class='formspan'>Хаяг:</span>");
			$('#more').append('<? echo form_textarea("deliver_address")."<br>";?>');
			$('#more').append('</div>');
			
			$('input[name="deliver_contact"]').change(function(){
			$('#deliver_result').append('<img src="<?=base_url()?>assets/ajax-loader.gif" id="loading">');
			var tel= $('input[name="deliver_contact"]').val();
			$.ajax 
			({
			url: '<?=base_url()?>/admin/customers_check',
			type:'POST',
			data:'tel='+tel,
			success: function(responce){
										$('#responce').remove();
										$('#deliver_result').append('<p id="responce">'+responce+'</p>');	
										$('#loading').remove();
										if (responce=="Found user") 
										{
											$.ajax ({
											url: '<?=base_url()?>/admin/customers_check',
											type:'POST',
											data:'tel='+tel+'&value=rd',
											success: function(responce0){
												$('input[name="deliver_rd"]').val(responce0);
																		}
													});	
													
											$.ajax ({
											url: '<?=base_url()?>/admin/customers_check',
											type:'POST',
											data:'tel='+tel+'&value=surname',
											success: function(responce1){
												$('input[name="deliver_surname"]').val(responce1);
																		}
													});	
													
											$.ajax ({
											url: '<?=base_url()?>/admin/customers_check',
											type:'POST',
											data:'tel='+tel+'&value=name',
											success: function(responce2){
												$('input[name="deliver_name"]').val(responce2);
																		}
													});	
													
											$.ajax ({
											url: '<?=base_url()?>/admin/customers_check',
											type:'POST',
											data:'tel='+tel+'&value=email',
											success: function(responce3){
												$('input[name="deliver_email"]').val(responce3);
																		}
													});	
													
											$.ajax ({
											url: '<?=base_url()?>/admin/customers_check',
											type:'POST',
											data:'tel='+tel+'&value=address',
											success: function(responce4){
												$('textarea[name="deliver_address"]').text(responce4);
																		}
													});	
										}
										}
			});	
			});	
			}
			
		if ($('select[name="options"]').val()=="onair")
			{
			$('#more').empty();
			}
			
		if ($('select[name="options"]').val()=="custom")
			{
			$('#more').empty();
			}
		if ($('select[name="options"]').val()=="")
			{
			$('#more').empty();
			}
			
		if ($('select[name="options"]').val()=="warehouse")
			{
			$('#more').empty();
			<?
			$bench = array(
				   "1"  => "1-р тавиур",
                   "2"  => "2-р тавиур",
                   "3"  => "3-р тавиур",
                   "4"  => "4-р тавиур",
                   "5"  => "5-р тавиур",
                );
			?>

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
			'</select>');
			}
		 })
   
});
</script>

<? 
require_once('../../orders/assets/PHP_XLSXWriter/xlsxwriter.class.php');
if(isset($_POST["search"])) 
	{
	$search_term=str_replace(" ","%",$_POST["search"]);
	echo "Xайлт:".$search_term."<br>";
	}
	else $search_term="";
if (isset($_POST["search_status"])) $search_status=$_POST["search_status"]; else $search_status='all';
//echo "Хайх:".$search_term."<br>";
//echo "search:".$_POST["search"];
//echo "<h3>Идэвхитэй захиалгууд</h3>";
$sql="SELECT orders.*,senders.name AS sender_name,senders.surname AS sender_surname,senders.tel AS sender_contact,senders.address AS sender_address,receivers.surname AS receiver_surname,receivers.name AS receiver_name,receivers.tel AS receiver_contact,receivers.address AS receiver_address FROM orders  JOIN customer AS senders ON orders.sender=senders.customer_id LEFT JOIN customer AS receivers ON orders.receiver=receivers.customer_id";

if ($search_status=="all") 
$sql.=" WHERE orders.status NOT IN('completed','delivered')";
else  $sql.=" WHERE orders.status ='$search_status'";
//if(isset($_POST["search"])) 
$sql.=" AND CONCAT_WS(barcode,package,senders.name,senders.tel,receivers.name,receivers.tel,created_date) LIKE '%".$search_term."%'";
$sql.=" ORDER BY created_date DESC";
//echo $sql;
$query = $this->db->query($sql);
//$query = $this->db->like("barcode","CP87");
if ($query->num_rows() > 0)
{
	echo form_open("orders/changing");
     echo "<table class='table table-hover'>";
	 echo "<tr>";
	   echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders'))."</th>";
	   echo "<th>№</th>"; 
	   echo "<th>Үүсгэсэн огноо</th>"; 
       echo "<th>Илгээгч</th>"; 
	   echo "<th>Хүлээн авагч</th>"; 
	   echo "<th>Хүлээн авагчын утас</th>"; 
	   echo "<th>Barcode</th>"; 
	   echo "<th>Хоног</th>"; 
	   echo "<th>Төлөв</th>"; 
	   echo "<th>Төлбөр</th>";
	   echo "<th></th>"; 
	   echo "</tr>";
	   $count=1;
	   $data = array(
    array('Илгээгч','','','','Хүлээн авагч','','','','Төлөв','Төлбөртэй','Баглаа боодлын тоо','Жин','Үнэлгээ','Тайлбар','Barcode'),
	array('Овог','Нэр','Утас','Хаяг','Овог','Нэр','Утас','Хаяг','','','','','',''));
	foreach ($query->result() as $row)
	{  
		$created_date=$row->created_date;
		$order_id=$row->order_id;
		$weight=$row->weight;
		$price=$row->price;
		$description=$row->description;
		$sender_id=$row->sender;
  	 	$sender=$row->sender_name;
		$sender_surname=$row->sender_surname;
		$sender_contact=$row->sender_contact;
		$sender_address=$row->sender_address;
   		$receiver=$row->receiver_name;
		$receiver_id=$row->receiver;
		$receiver_surname=$row->receiver_surname;
		$receiver_contact=$row->receiver_contact;
		$receiver_address=$row->receiver_address;
		$barcode=$row->barcode;
		$package=$row->package;
		$description=$row->description;
		$Package_advance = $row->advance;
		$Package_advance_value = $row->advance_value;
		$extra=$row->extra;
		$status=$row->status;
		$tr=0;
		$days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;		
		
	  	if ($Package_advance==1&&!$tr)
		{echo "<tr class=\"red\" title=\"Үлдэгдэл:".$Package_advance_value."$\">"; $tr=1;}
		
		if($status=="warehouse"&&$extra!="") $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status; 
		if (!$tr) echo "<tr>";else $tr=0;
	   echo "<td>".form_checkbox("orders[]",$order_id)."</td>"; 
	   echo "<td>".$count++."</td>"; 
	   echo "<td>".$created_date."</td>"; 
       echo "<td>".$sender."</td>"; 
	   echo "<td>".$receiver."</td>";
	   echo "<td>".$receiver_contact."</td>"; 
	   echo "<td>".$barcode."</td>"; 
	   echo "<td>".$days."</td>"; 
	   echo "<td>".$temp_status."</td>";
	   echo "<td>".$Package_advance_value."</td>"; 
	   echo "<td>".anchor('orders/detail/'.$row->order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
	   echo "</tr>";
 array_push($data,array($sender_surname,$sender,$sender_contact,$sender_address,$receiver_surname,$receiver,$receiver_contact,$receiver_address,$temp_status,$Package_advance_value,'',$weight,$price,$description,$barcode));

	} 
	$writer = new XLSXWriter();
	$writer->writeSheet($data);
	$writer->writeToFile('assets/orders.xlsx');
	echo "</table>";
	
	$options = array(
				  ''  => 'Шинэ төлөвийн сонго',
                  'delivered'  => 'Хүргэж өгөх',
                  'onair'    => 'Онгоцоор ирж байгаа',
                  'warehouse'   => 'Агуулахад орсон',
                  'custom' => 'Гааль',
				 // 'delete' => 'Barcode устгах',
                );


	echo form_dropdown('options', $options, '');
	echo "<div id=\"more\"></div>";
	echo form_submit("submit","өөрчил");
	echo form_close();
}
else echo "Илгээмж олдсонгүй<br>";


?>