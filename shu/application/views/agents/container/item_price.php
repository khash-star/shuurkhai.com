<? if (!$this->uri->segment(3)) redirect('agents/container'); else $item_id=$this->uri->segment(3) ?>
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
			
	
	$("#weight").on('change',function(){
		var str = $(this).val();
		var str = str.replace(",", "."); 
		var str = str.replace("Kg", ""); 
		var str = str.replace("kg", ""); 
		var str = str.replace("KG", ""); 
		var str = str.replace("Кг", ""); 
		var str = str.replace("кг", ""); 
		var str = str.replace("КГ", ""); 
		//var weight = parseFloat(str);
		$(this).val(str);
		});
	})
</script>


<div class="panel panel-success">
  <div class="panel-heading">Чингэлэгийн ачааны жин оруулах</div>
  <div class="panel-body">
<? 
//require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');
$query = $this->db->query("SELECT * FROM container_item WHERE id=".$item_id);
if ($query->num_rows()==1)
{
	$row = $query->row();
	$sender= 	$row ->sender;
	$receiver= 	$row ->receiver;
	$description = $row ->description;
	$weight= 	$row ->weight;
	$payment= 	$row ->payment;
	$pay_in_mongolia= 	$row ->pay_in_mongolia;
	$container_id= 	$row ->container;
	$status= 	$row ->status;

	

	if ((isset($status) && $status=="new") || $container_id==0)
	{
	echo form_open('agents/container_item_pricing');
	echo form_hidden("item_id",$item_id);
	echo "<table class='table table-hover'>";

	


	echo "<tr><td>Авсан төлбөр/$/ (*)</td><td>".form_input ("payment",$payment,array("class"=>"form-control","required"=>"required"))."</td></tr>";

	echo "<tr><td>Монголд авах төлбөр/$/ (*)</td><td>".form_input ("pay_in_mongolia",$pay_in_mongolia,array("class"=>"form-control","required"=>"required"))."</td></tr>";

	echo "<tr><td>Жин, хэмжээ, тоо ширхэг</td><td>".form_input ("weight",$weight,array("class"=>"form-control","id"=>"weight"))."</td></tr>";

	echo "</table>";

	echo form_submit("submit","Засах",array("class"=>"btn btn-success"));
	echo form_close();
	}
	else echo '<div class="alert alert-danger" role="alert">Чинэглэгийн төлөв засаж болохгүй төлөвт байна</div>';
}
else echo '<div class="alert alert-danger" role="alert">Ачааны дугаар алдаатай байна</div>';




?>


  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->