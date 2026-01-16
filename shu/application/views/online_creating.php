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
  <div class="panel-heading">Захиалга үүсгэх</div>
  <div class="panel-body">
<? 
echo form_open("welcome/online_creating2");
if (isset($_POST["url"])) $url = $_POST["url"]; else $url="";
echo form_hidden("url",$url);
	echo "<table class='table table-hover'>";
	
	/*echo "<tr>";
	echo "<td><span style='color:#F00'>Хүргэлт</span></td>";
	echo "<td>";
	echo form_checkbox("transport","1",FALSE)."<br><i>Улаанбаатар хот дотор хүргэлттэй</i>";
	echo "</td>";
	echo "</tr>";
*/

	echo "<tr><td>Линк</td><td>".form_textarea("url",$url,array("class"=>"form-control","placeholder"=>"Талбарт нэг линк оруулна уу"))."</td></tr>";	

	echo "<tr><td>Тоо /Quantity/</td><td>".form_input("number","",array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>Хэмжээ /Size/</td><td>".form_input("size","",array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>Өнгө /Color/</td><td>".form_input("color","",array("class"=>"form-control"))."</td></tr>";
	
	
	echo "<tr><td>Нэмэлт тайлбар</td><td>".form_textarea("description","",array("class"=>"form-control","placeholder"=>"Нэмэлт мэдээлэл оруулах боломжтой"))."</td></tr>";	

	echo "</table>";
	echo form_submit("Засах","Илгээх",array("class"=>"btn btn-primary"));
	//echo " ";
	//echo anchor("customer/online_create","Ахин нэмэх",array("class"=>"btn btn-default"));
	//echo " ";
	//echo anchor("customer/online","Бүх захиалгууд",array("class"=>"btn btn-default"));
echo form_close();
?>
<br />


  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<!--a href="<? //base_url();?>index.php/welcome/faqs" class="btn btn-warning">Түгээмэл асуултууд</a>

<a href="<? //base_url();?>index.php/welcome/tutor" class="btn btn-warning">Заавар</a-->