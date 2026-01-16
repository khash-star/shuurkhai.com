<? if (!$this->uri->segment(3)) redirect('admin/online'); else $online_id=$this->uri->segment(3) ?>

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
  <div class="panel-heading">Илгээмж оруулах</div>
  <div class="panel-body">
<? 
echo form_open('admin/online_renewing');
echo form_hidden("online_id",$online_id);
$query = $this->db->query("SELECT * FROM online WHERE online_id='".$online_id."'");
		if ($query->num_rows() == 1)
		{
		echo "<table class='table table-hover'>";
		$row=$query->row();
		$online_id=$row->online_id;
		$created_date=$row->created_date;
		$receiver=$row->receiver;
		$url=$row->url;
		$size=$row->size;
		$color=$row->color;
		$number=$row->number;
		$comment=$row->comment;
		$status=$row->status;
		$price=$row->price;
		$title=$row->title;

		echo "<tr><td colspan='2'><h4>Хүлээн авагч</h4></td></tr>";

		echo "<tr><td>Нэр</td><td>".form_input("name",customer($receiver,"name"),array("class"=>"form-control","readonly"=>"true"))."</td></tr>";	
		echo "<tr><td>Овог</td><td>".form_input("surname",customer($receiver,"surname"),array("class"=>"form-control"))."</td></tr>";
		echo "<tr><td>РД</td><td>".form_input("rd",customer($receiver,"rd"),array("class"=>"form-control"))."</td></tr>";
		echo "<tr><td>Утас</td><td>".form_input("contacts",customer($receiver,"tel"),array("class"=>"form-control","readonly"=>"true"))."</td></tr>";	
		echo "<tr><td>Э-мэйл</td><td>".form_input("email",customer($receiver,"email"),array("class"=>"form-control"))."</td></tr>";
		echo "<tr><td>Хаяг</td><td>".form_textarea("address",customer($receiver,"address"),array("class"=>"form-control"))."</td></tr>";


	echo "<tr><td>Барааны тайлбар</td><td>";
	echo "<table class='table table-hover'>";
	echo "<tr>";
	echo "<td>".form_input("package1_name",$title,array("class"=>"form-control","placeholder"=>"Цамц, Цүнх, Утас г.м"))."</td>";
	echo "<td>".form_input("package1_num",$number,array("class"=>"form-control ","placeholder"=>"Тоо ширхэг"))."</td>";
	echo "<td>".form_input("package1_price",$price,array("class"=>"form-control ","placeholder"=>"Үнэ ($)"))."</td>";
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



	echo "<tr><td>TRACK(*)</td><td>".form_input ("track","",array("class"=>"form-control"))."</td></tr>";
	
	
	echo "<tr>";
	echo "<td>Тооцоо<br><i>Зөвхөн тоооцоо хийхэд харагдана.</i></td>";
	echo "<td>";
	echo 'Тооцоотой эсэх: <div class="input-group">';
	echo '<span class="input-group-addon" id="basic-addon1">Тооцоотой</span>';
	echo '<span class="input-group-addon">'.form_checkbox("admin_advance","1",FALSE).'</span>';
	echo form_input('admin_value', '',array("class"=>"form-control"));
	echo "</td>";
	
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
		}
echo form_submit("submit","Оруулах",array("class"=>"btn btn-success"));
echo form_close();

?>

</div>
</div>
<?=anchor("admin/online","Бүх online захиалгууд",array("class"=>"btn btn-primary"));?>