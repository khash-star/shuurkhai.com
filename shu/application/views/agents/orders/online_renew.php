<? if (!$this->uri->segment(3)) redirect('online_orders/online'); else $online_id=$this->uri->segment(3) ?>
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

	$( "span#more_toggle" ).click(function() {
			$( "div.more" ).toggle( "slow", function() {});
			if ($(this).text()=="more") 
			$(this).text('less'); else $(this).text('more');
			});
	})
</script>




<div class="panel panel-success">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
echo "<h3>Online захиалгууд</h3>";
$query = $this->db->query("SELECT * FROM online WHERE online_id='".$online_id."'");

if ($query->num_rows() == 1)
{
		 echo "<table class='table table-hover'>";
		 echo "<tr>";
	   	 echo "<th>Үүсгэсэн огноо</th>"; 
		 echo "<th>Хүлээн авагчийн нэр</th>"; 
		 echo "<th>Хүлээн авагчийн утас</th>"; 
		 echo "<th>Барааны веблинк</th>"; 
		 echo "<th>Тоо</th>"; 
		 echo "<th>Размер</th>"; 
		 echo "<th>Өнгө</th>"; 
		 echo "</tr>";
		 
		 foreach ($query->result() as $row)
			{  
			$online_id=$row->online_id;
			$created_date=$row->created_date;
			$receiver=$row->receiver;
			$url=$row->url;
			$size=$row->size;
			$color=$row->color;
			$number=$row->number;
			$status=$row->status;
   			
   	
			//receiver
			if ($receiver!="")
			{
			$query_receiver = $this->db->query("SELECT * FROM customer WHERE customer_id=\"$receiver\" LIMIT 1");
				$row_receiver= $query_receiver->row();
				$receiver_name = $row_receiver->name;
				$receiver_contact = $row_receiver->tel;
			
			} 
			else {$receiver_name="";$receiver_contact="";}
		
			 echo "<tr>";
			 echo "<td>".$created_date."</td>"; 
			 echo "<td>".$receiver_name."</td>"; 
			 echo "<td>".$receiver_contact."</td>"; 
			 echo "<td><a href='".$url."' target='new' title='".$url."'>".substr($url,0,100)."...</a></td>"; 
			 echo "<td>".$number."</td>"; 
			 echo "<td>".$size."</td>"; 
			 echo "<td>".$color."</td>"; 
			 echo "</tr>";
			}
   			echo "</table>";
			echo form_open('online_orders/online_renewing');
			echo form_hidden("online_id",$online_id);
			echo "<div class=\"box\">";
			
			echo "<h4 class=\"legend\">Бараа</h4>";
			
			
			$this->table->set_heading(array('Тайлбар', 'Тоо', 'Үйлдвэрлэсэн','Жин /гр/','Үнэ /$/'));
			
			$this->table->add_row( array(
			form_input ("package1_name"), 
			form_input ("package1_num"), 
			form_input ("package1_produced","USA"),
			form_input ("package1_weight"),
			form_input ("package1_value")
			));
			
			$this->table->add_row( array(
			form_input ("package2_name"), 
			form_input ("package2_num"), 
			form_input ("package2_produced","USA"),
			form_input ("package2_weight"),
			form_input ("package2_value")
			));
			
			$this->table->add_row( array(
			form_input ("package3_name"), 
			form_input ("package3_num"), 
			form_input ("package3_produced","USA"),
			form_input ("package3_weight"),
			form_input ("package3_value")
			));
			
			
			$this->table->add_row( array(
			form_input ("package4_name"), 
			form_input ("package4_num"), 
			form_input ("package4_produced","USA"),
			form_input ("package4_weight"),
			form_input ("package4_value")
			));
			echo $this->table->generate(); 
			echo "<span class='formspan'>Нийт жин/кг/</span>";
			echo form_input ("weight")."<br>";
			echo "<span class='formspan'>Нийт үнэ/$/</span>";
			echo form_input ("price")."<br>";
			//echo "<span class='formspan'>Тайлбар:</span>";
			//cho form_textarea ("package_description","Энгийн илгээмж")."<br>";
			echo "<span class='formspan'>Бусад Track№</span>";
			echo form_input ("third_party","")."<br>";
			echo "</div>";
			
			
			echo "<div class=\"box\">";
			echo "<h4 class=\"legend\">Төлбөр</h4>";
			echo "<span class='formspan'>Төлбөргүй</span>";
			echo form_radio('Package_advance', '0',  TRUE);
			echo "<span class='formspan'>Үлдэгдэлтэй</span>";
			echo form_radio('Package_advance', '1',  FALSE)."<br>";
			echo "<span class='formspan'>Үлдэгдэл</span>";
			echo form_input('Package_advance_value', '');
			echo "</div>";
			
			echo "<div class=\"more\">";
			echo "<div class=\"box\">";
			echo "<h4 class=\"legend\">Илгээмж явах хэлбэр</h4>";
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
			
			
			
			echo "<div class=\"box\">";
			echo "<h4 class=\"legend\">Илгээмж доторхи зүйл</h4>";
			echo form_radio('Package_inside', 'gift',  TRUE);
			echo "Бэлэг<br>";
			echo form_radio('Package_inside', 'sample', FALSE);
			echo "Арилжааны шинж чанаргүй загвар<br>";
			echo form_radio('Package_inside', 'document', FALSE);
			echo "Арилжааны шинж чанаргүй бичиг баримт<br>";
			echo "</div>";
			
			
			echo "<div class=\"box\">";
			echo "<h4 class=\"legend\">Даатгал</h4>";
			echo "<span class='formspan'>Даатгалтай</span>";
			echo form_checkbox('insurance', '1')."<br>";
			echo "<span class='formspan'>Даатгалын төлбөр</span>";
			echo form_input('insurance_value', '');
			echo "</div>";
			
			
			echo "<div class=\"box\">";
			echo "<h4 class=\"legend\">Хүргэгдээгүй тохиолдолд</h4>";
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
			
			
			
			echo "<span id=\"more_toggle\">more</span>";
			echo form_submit("submit","нэмэх");
			echo form_close();
	
   }
   else echo "Илгээмж олдсонгүй олдсонгүй<br>";

?>

</div>
<div id="right_side">
<? $this->load->view("calendar");?>
<div id="side_menu">
<ul>
<li><?=anchor('orders', 'Илгээмжүүд')?></li>
<li><?=anchor('orders/create', 'Илгээмж оруулах')?></li>
<? if ($query->num_rows() == 1)
	{
	echo "<li>".anchor('online_orders/online_renew/'.$online_id,'Илгээмж болгох')."</li>";
	//echo anchor('orders/deliver/'.$order_id,'Хүргэж өгсөн')."<br>";
    echo "<li>".anchor('online_orders/online_delete/'.$online_id,'Устгах')."</li>";
   	//echo "<li>".anchor('orders/track/'.$order_id,'Хаана явна')."</li>";
	}
?>
</ul>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->