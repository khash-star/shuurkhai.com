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
  <div class="panel-heading">Track оруулах</div>
  <div class="panel-body">
<? 
echo form_open('admin/online_track_renewing');
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

	echo "<tr><td>TRACK(*)</td><td>".form_input ("track","",array("class"=>"form-control"))."</td></tr>";
	
	
	//echo "<tr>";
	//echo "<td>Төлбөр</td>";
	//echo "<td>";
	//echo 'Үлдэгдэл төлбөртэй: <div class="input-group">';
	//echo '<span class="input-group-addon" id="basic-addon1">Төлбөр</span>';
	//echo '<span class="input-group-addon">'.form_checkbox("Package_advance","1",TRUE).'</span>';
	//echo form_input('Package_advance_value', '',array("class"=>"form-control"));
	//echo "</td>";
	
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