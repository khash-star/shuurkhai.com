<? if (!$this->uri->segment(3)) redirect('online_orders'); else $order_id=$this->uri->segment(3) ?>
<script type="application/javascript">
$(function() {
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


	$('input[name="receiver_contact"]').change(function(){
		$('#sender_result').append('<img src="<?=base_url()?>assets/ajax-loader.gif" id="loading">');
		var tel= $('input[name="receiver_contact"]').val();
	$.ajax ({
		url: '<?=base_url()?>/admin/customers_check',
		type:'POST',
		data:'tel='+tel,
		success: function(responce){
									$('#responce').remove();
									$('#receiver_result').append('<p id="responce">'+responce+'</p>');	
									$('#loading').remove();
									if (responce=="Found user") 
									{
										$.ajax ({
										url: '<?=base_url()?>/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=rd',
										success: function(responce0){
											$('input[name="receiver_rd"]').val(responce0);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=surname',
										success: function(responce1){
											$('input[name="receiver_surname"]').val(responce1);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=name',
										success: function(responce2){
											$('input[name="receiver_name"]').val(responce2);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=email',
										success: function(responce3){
											$('input[name="receiver_email"]').val(responce3);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=address',
										success: function(responce4){
											$('textarea[name="receiver_address"]').text(responce4);
																	}
												});	
									}
									}
		});	
	});
	$( "span#more_toggle" ).click(function() {
			$( "div.more" ).toggle( "slow", function() {});
			if ($(this).text()=="more") 
			$(this).text('less'); else $(this).text('more');
			});

	})
</script>
<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 

$query = $this->db->query("SELECT * FROM orders WHERE order_id='".$order_id."'");
if ($query->num_rows() == 1)
{
   		$row = $query->row();
   		$created_date=$row->created_date;
		$order_id=$row->order_id;
  	 	//$sender=$row->sender;
   		$receiver=$row->receiver;
		$deliver=$row->deliver;
		$barcode=$row->barcode;
		$package=$row->package;
		//$description=$row->description;
		$insurance=$row->insurance;
		$insurance_value=$row->insurance_value;
		$Package_advance=$row->advance;
		$Package_advance_value=$row->advance_value;
		$weight=$row->weight;
		$price=$row->price;
		$third_party=$row->third_party;
		$way=$row->way;
		$inside=$row->inside;
		$deliver_time=$row->deliver_time;
		$return_type=$row->return_type;
		$return_day=$row->return_day;
		$return_way=$row->return_way;
		$return_address=$row->return_address;
		$status=$row->status;
		$timestamp=$row->timestamp;
		$extra=$row->extra;
   
		//RECIEVER
		if ($receiver!=1)
		{
		$query_reciever = $this->db->query("SELECT * FROM customer WHERE customer_id=\"$receiver\" LIMIT 1");
		if ($query_reciever->num_rows() == 1)
		{
			$row_reciever = $query_reciever->row();
			$reciever_name=$row_reciever->name;
			$reciever_surname=$row_reciever->surname;
			$reciever_address=$row_reciever->address;
			$reciever_rd=$row_reciever->rd;
			$reciever_email=$row_reciever->email;
			$reciever_contact=$row_reciever->tel;
		} 
		}
		//}
		//else {$reciever_name="";$reciever_contact="";}
		
		//DELIVER
		if ($deliver!="")
		{
		$query_deliver = $this->db->query("SELECT * FROM customer WHERE customer_id=\"$deliver\" LIMIT 1");
		foreach ($query_deliver->result() as $row_deliver)
		{
			$deliver_name=$row_deliver->name;
			$deliver_contact=$row_deliver->tel;
		}
		}else {$deliver_name="";$deliver_contact="";}
   if ($package!="")
   	{$package_array=explode("##",$package);
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
echo "<h3>Online илгээмж засах</h3>";
echo form_open('tracks/editing',array('id'=>'edit'));
echo form_hidden('order_id',$order_id);
echo "<div class=\"box\">";
echo "<h4 class=\"legend\">Хүлээн авагч</h4>";
echo "<span class='formspan'>Утас:</span>";
echo form_input ("receiver_contact",@$reciever_contact)."<span id=\"receiver_result\"></span><br>";
echo "<span class='formspan'>Нэр:</span>";
echo form_input ("receiver_name",@$reciever_name)."";
echo "<span class='formspan'>Овог:</span>";
echo form_input ("receiver_surname",@$reciever_surname)."";
echo "<span class='formspan'>РД:</span>";
echo form_input ("receiver_rd",@$reciever_rd)."<br>";

echo "<span class='formspan'>И-мейл:</span>";
echo form_input ("receiver_email",@$reciever_email)."<br>";
echo "<span class='formspan'>Хаяг:</span>";
echo form_textarea("receiver_address",@$reciever_address)."<br>";
echo "</div>";


echo "<div class=\"box\">";
echo "<h4 class=\"legend\">Бараа</h4>";


$this->table->set_heading(array('Тайлбар', 'Тоо', 'Үйлдвэрлэсэн','Жин /гр/','Үнэ /$/'));

$this->table->add_row( array(
form_input ("package1_name",@$package1_name), 
form_input ("package1_num",@$package1_num), 
form_input ("package1_value",@$package1_value)
));

$this->table->add_row( array(
form_input ("package2_name",@$package2_name), 
form_input ("package2_num",@$package2_num), 
form_input ("package2_value",@$package2_value)
));

$this->table->add_row( array(
form_input ("package3_name",@$package3_name), 
form_input ("package3_num",@$package3_num), 
form_input ("package3_value",@$package3_value)
));


$this->table->add_row( array(
form_input ("package4_name",@$package4_name), 
form_input ("package4_num",@$package4_num), 
form_input ("package4_value",@$package4_value)
));
echo $this->table->generate(); 
echo "<span class='formspan'>Нийт жин/кг/</span>";
echo form_input ("weight",$weight)."<br>";
echo "<span class='formspan'>Нийт үнэ/$/</span>";
echo form_input ("price",$price)."<br>";
//echo "<span class='formspan'>Тайлбар:</span>";
//cho form_textarea ("package_description","Энгийн илгээмж")."<br>";
echo "<span class='formspan'>Бусад Track№</span>";
echo form_input ("third_party",$third_party)."<br>";
echo "</div>";


echo "<div class=\"box\">";
echo "<h4 class=\"legend\">Төлбөр</h4>";
echo "<span class='formspan'>Төлбөргүй</span>";
echo form_radio('Package_advance', '0', $Package_advance==0?TRUE:FALSE);
echo "<span class='formspan'>Үлдэгдэлтэй</span>";
echo form_radio('Package_advance', '1',  $Package_advance==1?TRUE:FALSE)."<br>";
echo "<span class='formspan'>Үлдэгдэл</span>";
echo form_input('Package_advance_value', $Package_advance_value);
echo "</div>";

echo "<div class=\"more\">";
echo "<div class=\"box\">";
echo "<h4 class=\"legend\">Илгээмж явах хэлбэр</h4>";
echo "<span class='formspan'>Агаараар</span>";
echo form_radio('way', 'air', $way=='air'?TRUE:FALSE)."<br>";
echo "<span class='formspan'>Газраар</span>";
echo form_radio('way', 'surface', $way=='surface'?TRUE:FALSE)."<br>";
echo "<span class='formspan'>Хосолсон</span>";
echo form_radio('way', 'sal', $way=='sal'?TRUE:FALSE)."<br>";
echo "<h4>Хүргэлтийн хэлбэр</h4>";
echo "<span class='formspan'>Express</span>";
echo form_radio('deliver_time', 'express', $deliver_time=='express'?TRUE:FALSE)."";
echo "<span class='formspan'>Advice of delivery</span>";
echo form_radio('deliver_time', 'advice', $deliver_time=='advice'?TRUE:FALSE)."<br>";
echo "</div>";



echo "<div class=\"box\">";
echo "<h4 class=\"legend\">Илгээмж доторхи зүйл</h4>";
echo form_radio('Package_inside', 'gift',  $inside=='gift'?TRUE:FALSE);
echo "Бэлэг<br>";
echo form_radio('Package_inside', 'sample', $inside=='sample'?TRUE:FALSE);
echo "Арилжааны шинж чанаргүй загвар<br>";
echo form_radio('Package_inside', 'document', $inside=='document'?TRUE:FALSE);
echo "Арилжааны шинж чанаргүй бичиг баримт<br>";
echo "</div>";


echo "<div class=\"box\">";
echo "<h4 class=\"legend\">Даатгал</h4>";
echo "<span class='formspan'>Даатгалтай</span>";
echo form_checkbox('insurance', '1', $insurance==1?TRUE:FALSE)."<br>";
echo "<span class='formspan'>Даатгалын төлбөр</span>";
echo form_input('insurance_value', $insurance_value);
echo "</div>";


echo "<div class=\"box\">";
echo "<h4 class=\"legend\">Хүргэгдээгүй тохиолдолд</h4>";
echo form_radio('Package_return_type', 'return_1',  $return_type=="return_1"?TRUE:FALSE);
echo "Явуулагч талруу яаралтай буцаах<br>";
echo form_radio('Package_return_type', 'return_2',  $return_type=="return_2"?TRUE:FALSE);
echo "Явуулагч талруу __ өдрийн дараа буцаах";
echo " Өдөр";
echo form_input('Package_return_day', $return_day)."<br>";
echo form_radio('Package_return_type', 'return_3',  $return_type=="return_3"?TRUE:FALSE);
echo "Өөр хаягруу явуулах"."<br>";
echo "Өөр хаяг";
echo form_textarea ("Package_return_address",$return_address)."<br>";
echo form_radio('Package_return_type', 'return_4',  $return_type=="return_4"?TRUE:FALSE);
echo "Тэнд нь устгах<br>";
echo "<h4>Буцах хаягруу явуулах</h4>";
echo "<span class='formspan'>Агаараар</span>";
echo form_radio('Package_return_way', 'air',  $return_way=="air"?TRUE:FALSE);
echo "<span class='formspan'>Газраар</span>";
echo form_radio('Package_return_way', 'surface',  $return_way=="surface"?TRUE:FALSE);
echo "</div>";

echo "</div>";  //MORE DIV CLOSE


echo "<span id=\"more_toggle\">more</span>";
echo form_submit("submit","засах");
echo form_close();
}
else echo "Илгээмж олдсонгүй";

?>

</div>
<div id="right_side">
<? $this->load->view("calendar");?>
<div id="side_menu">
<ul>
<li><?=anchor('agents', 'Home')?></li>
<li><?=anchor('agents/tracks', 'Tracks')?></li>
<li><?=anchor('agents/tracks_deleting/'.$order_id, 'Track delete')?></li>
<li><?=anchor('agents/tracks_insert', 'Track оруулах')?></li>
</ul>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->