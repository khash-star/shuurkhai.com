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
  <div class="panel-heading">Бүртгэл</div>
  <div class="panel-body">
<? 	
	$sql2 = "SELECT customer_id FROM customer WHERE tel='".$_POST["contact"]."' LIMIT 1";
	$query2 = $this->db->query($sql2);
	if ($query2->num_rows() == 1)
	{
	echo form_open("welcome/online_registering");
		echo form_hidden("url",$_POST["url"]);
		echo form_hidden("number",$_POST["number"]);
		echo form_hidden("size",$_POST["size"]);
		echo form_hidden("color",$_POST["color"]);
		echo form_hidden("description",$_POST["description"]);
		echo form_hidden("contact",$_POST["contact"]);
	echo "<h3>Нууц үгээ оруулна уу.</h3>";
	echo form_password("password","",array("class"=>"form-control"))."<br>";	
	echo form_submit("Засах","Шалгах",array("class"=>"btn btn-primary"));
	}
	
	
	if ($query2->num_rows() == 0)
	{
	echo form_open("welcome/online_completing");
		echo form_hidden("url",$_POST["url"]);
		echo form_hidden("number",$_POST["number"]);
		echo form_hidden("size",$_POST["size"]);
		echo form_hidden("color",$_POST["color"]);
		echo form_hidden("description",$_POST["description"]);
		echo form_hidden("contact",$_POST["contact"]);
	echo "<h3>Бүртгэл олдсонгүй.</h3>";
		echo "<table class='table table-striped'>";
		echo "<tr><td>Нэр(*)</td><td>".form_input("name","",array("placeholder"=>"Нэр","class"=>"form-control","required"=>"true"))."</td></tr>";
		echo "<tr><td>Овог(*)</td><td>".form_input("surname","",array("placeholder"=>"Овог","class"=>"form-control","required"=>"true"))."</td></tr>";
		echo "<tr><td>Хаяг</td><td>".form_textarea("address","",array("placeholder"=>"Гэрийн хаяг","class"=>"form-control","required"=>"true"))."</td></tr>";		
		echo "<tr><td>Нууц үг (*)</td><td>".form_password("password","",array("placeholder"=>"Нууц үгээ сонгох","class"=>"form-control","required"=>"true"))."</td></tr>";
		echo "</table>";
		echo form_submit("Засах","Бүртгэх",array("class"=>"btn btn-primary"));
	}
	
	
	
	echo form_close();
?>
<br />


  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<!--a href="<? //base_url();?>index.php/welcome/faqs" class="btn btn-warning">Түгээмэл асуултууд</a>

<a href="<? //base_url();?>index.php/welcome/tutor" class="btn btn-warning">Заавар</a-->