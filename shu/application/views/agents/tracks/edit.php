<? if (!$this->uri->segment(3)) redirect('agents/tracks'); else $order_id=$this->uri->segment(3) ?>
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
})
</script>
<div class="panel panel-primary">
  	<div class="panel-heading">Трак засах</div>
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
				$is_online=$row->is_online;
				$owner=$row->owner;

					$query_receiver = $this->db->query('SELECT * FROM customer WHERE customer_id="'.$receiver.'"');
				 	$costumer_row = $query_receiver->row();
					$no_proxy = $costumer_row -> no_proxy;

				if ($status=="item_missing" && $owner=2)
				{
						echo "<b>Хүлээн авагч</b>: ".customer($receiver,"name")."<br>";
						echo "<b>Жин</b>: ".$weight."Кг<br>";
						echo "<b>Трак</b>: ".$third_party."<br>";

						echo form_open('agents/tracks_editing');
						echo form_hidden("order_id",$order_id);
						echo "<p>Ачааг шалгаж барааны тайлбарыг заавал оруулна</p>";
						
						echo "<table class='table table-hover'>";
						echo "<tr>";
						echo "<td>".form_input("package1_name","",array("class"=>"form-control","placeholder"=>"Цамц, Цүнх, Утас г.м","required"=>"true"))."</td>";
						echo "<td>".form_input("package1_num","",array("class"=>"form-control ","placeholder"=>"Тоо ширхэг","placeholder"=>"Цамц, Цүнх, Утас г.м","required"=>"true"))."</td>";
						echo "<td>".form_input("package1_price","",array("class"=>"form-control ","placeholder"=>"Үнэ ($)","required"=>"true"))."</td>";
						echo "</tr>";
						
						echo "<tr>";
						echo "<td>".form_input("package2_name","",array("class"=>"form-control","placeholder"=>"Цамц, Цүнх, Утас г.м"))."</td>";
						echo "<td>".form_input("package2_num","",array("class"=>"form-control ","placeholder"=>"Тоо ширхэг"))."</td>";
						echo "<td>".form_input("package2_price","",array("class"=>"form-control ","placeholder"=>"Үнэ ($)"))."</td>";
						echo "</tr>";
						
						echo "<tr>";
						echo "<td>".form_input("package3_name","",array("class"=>"form-control","placeholder"=>"Цамц, Цүнх, Утас г.м"))."</td>";
						echo "<td>".form_input("package3_num","",array("class"=>"form-control ","placeholder"=>"Тоо ширхэг"))."</td>";
						echo "<td>".form_input("package3_price","",array("class"=>"form-control ","placeholder"=>"Үнэ ($)"))."</td>";
						echo "</tr>";
					
						echo "<tr>";
						echo "<td>".form_input("package4_name","",array("class"=>"form-control","placeholder"=>"Цамц, Цүгх, Утас г.м"))."</td>";
						echo "<td>".form_input("package4_num","",array("class"=>"form-control ","placeholder"=>"Тоо ширхэг"))."</td>";
						echo "<td>".form_input("package4_price","",array("class"=>"form-control ","placeholder"=>"Үнэ ($)"))."</td>";
						echo "</tr>";
						echo "</table>";


						$options = array(
					  	'yes' => 'proxy авна',
					  	'no' => 'үгүй'
	                	);
						if ($weight<3.8)
							{
								if ($no_proxy==0)
								echo form_dropdown("proxy",$options,'yes',array("class"=>"form-control"));
								else echo "Proxy авдаггүй дугаар<br>";
							}
						else echo "Их жинтэй proxy авахгүй<br>";


						echo form_submit("submit","засах",array('class'=>'btn btn-success'));
					echo form_close();

				}
				else 
					echo '<div class="alert alert-danger" role="alert">Зөвхөн өөрийн оруулсан item_missing төлөвт буй ачааны тайлбарыг оруулах боломжтой. </div>';
		}
		else echo '<div class="alert alert-danger" role="alert">Илгээмж олдсонгүй</div>';
		?>

	</div>
</div>