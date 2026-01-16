<? if (!$this->uri->segment(3)) redirect('customer/online'); else $online_id=$this->uri->segment(3) ?>

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


<div class="panel panel-default">
  <div class="panel-heading">Захиалга засах</div>
  <div class="panel-body">
<? 
$customer_id = $this->session->userdata('customer_id');

$query = $this->db->query("SELECT * FROM online WHERE online_id=".$online_id);

if ($query->num_rows() == 1)
{
	
	$row = $query->row();
	if ($row->customer_id==$customer_id)
	{
		if ($row->status=='online')
		{
		echo form_open("customer/online_editing");
		echo form_hidden("online_id",$online_id);
		echo "<table class='table table-hover'>";
		echo "<tr><td>Линк</td><td>".form_textarea("url",$row->url,array("class"=>"form-control","placeholder"=>"Талбарт нэг линк оруулна уу"))."</td></tr>";	

	echo "<tr><td>Тоо</td><td>".form_input("number",$row->number,array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>Хэмжээ</td><td>".form_input("size",$row->size,array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>Өнгө</td><td>".form_input("color",$row->color,array("class"=>"form-control"))."</td></tr>";
	
	echo "<tr><td>Нэмэлт тайлбар</td><td>".form_textarea("description",$row->context,array("class"=>"form-control","placeholder"=>"Нэмэлт мэдээлэл оруулах боломжтой"))."</td></tr>";	
	echo "</table>";
	echo form_submit("Засах","Засах",array("class"=>"btn btn-primary"));
	echo " ";
	echo anchor("customer/online_create","Шинээр оруулах",array("class"=>"btn btn-default"));
	echo " ";
	echo anchor("customer/online","Бүх захиалгууд",array("class"=>"btn btn-default"));
	echo form_close();
		}
		else echo '<div class="alert alert-success" role="alert">Энэхүү захиалгийг гүйцэтгэсэн учир өөрчлөх устгах боломжгүй</div>';
	}
	else echo '<div class="alert alert-success" role="alert">Таны оруулсан захиалга биш байна.</div>';
}
else //if ($query->num_rows() == 1)
echo '<div class="alert alert-danger" role="alert">Захиалга олдсонгүй.</div>';
?>
<br />


  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<a href="<?=base_url();?>index.php/welcome/faqs" class="btn btn-warning">Түгээмэл асуултууд</a>

<a href="<?=base_url();?>index.php/welcome/tutor" class="btn btn-warning">Заавар</a>