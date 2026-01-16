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
	$("#toggle").hide();
	$("#toggle1").hide();
	$("#toggle2").hide();
	$("#toggle3").hide();
	$("#toggle4").hide();
	
   $("[id='button_trigger']").click(function(){
	$("#toggle").show(100);
	$("#toggle1").show(100);
	$("#toggle2").show(100);
	$("#toggle3").show(100);
	$("#toggle4").show(100);
	$("[name='trigger']").val(1); 
	if ($("[name='name']").prop('required')) 
            $("[name='name']").prop('required', false); else  $("[name='name']").prop('required', true);
        
	if ($("[name='tel']").prop('required')) 
            $("[name='tel']").prop('required', false); else $("[name='tel']").prop('required', true);
			
	if ($("[name='address']").prop('required')) 
            $("[name='address']").prop('required', false); else $("[name='address']").prop('required', true);
	

	})	
	
	$("#submit").click(function(){
		 $("[name='name']").prop('required', false);
		  $("[name='tel']").prop('required', false); 
		  $("[name='address']").prop('required', false); 
		  $("[name='trigger']").val(0); 
		  $("#toggle").hide(100);
	$("#toggle1").hide(100);
	$("#toggle2").hide(100);
	$("#toggle3").hide(100);
	$("#toggle4").hide(100);
		 // alert('asdas');
		  $this.parent().submit();
		 // $('#form').submit();
	})
})
</script>

<? if (!isset($_POST["track"]) && $_POST["track"]=="") redirect("welcome/track_search"); 
else {
	$track=$_POST["track"]; 
	$track = str_replace(" ","",$track);
	$track = str_replace("script","***",$track);
	$track = str_replace("php","***",$track);
	$track = str_replace("<?","***",$track);
}
	if (isset($_POST["contact"]) && $_POST["contact"]=="") redirect("welcome/track_search");
	{
	$contact=$_POST["contact"]; 
	$contact = str_replace(" ","",$contact);
	$contact = str_replace("script","***",$contact);
	$contact = str_replace("php","***",$contact);
	$contact = str_replace("<?","***",$contact);
	} 
	
	
	if (isset($_POST["password"]) && $_POST["password"]=="") redirect("welcome/track_search");
	{
	$password=$_POST["password"]; 
	$password = str_replace(" ","",$password);
	$password = str_replace("script","***",$password);
	$password = str_replace("php","***",$password);
	$password = str_replace("<?","***",$password);
	} 
?>
<div class="panel panel-success">
  <div class="panel-heading">Та Тракаа бүртгүүлснээр 1&cent; таны хуримтлалын санд нэмэгдэнэ.</div>
  <div class="panel-body">
<? 
$track_eliminated = substr($track,-8,8);
$sql = "SELECT * FROM orders WHERE SUBSTRING(third_party,-8,8) = '$track_eliminated'";
$query = $this->db->query($sql);
if ($query->num_rows() > 1) echo "1-с олон track олдлоо. Та хайлтын утгаа ихэсгэж ахин оролдоно уу? <br>".anchor("welcome/track_search","Ахин оролдох",array("class"=>"btn btn-xs btn-primary"));
if ($query->num_rows() == 1)
{
	$row = $query->row();
	//$receiver = $row->receiver;
	$status = $row->status;
	if ($status=="new") echo "USА оффис-д байгаа Монголруу нисэхэд бэлэн болсон.";
	if ($status=="item_missing") echo "Задаргаагүй. Илгээмжийн доторх мэдээллийг оруулаагүй байна. Иймд Монголруу гарах боложгүй. Та нэвтэрч орон Track-aa өөр дээрээ бүртгүүлж барааны тайлбараа бөглөнө үү";
	if ($status=="warehouse") echo "Монгол дахь агуулахад ирсэн байна. Та өөрийн биеэр ирж авах боломжтой.";
	if ($status=="onair") echo "Америкаас Монголруу ирж яваа.";
	if ($status=="delivered") echo "Илгээмжийг хүлээн авч олгосон.";
	if ($status=="filled") echo "Барааны мэдээллийн бүрэн оруулсан байна. Бид мэдээллийг шалган наашаа гаргахад бэлэн төлөвт оруулах болно.";
	if ($status=="weight_missing") echo "Ачаа манай Америк дахь салбарт хүргэгдээгүй байна. Та Track дугаар дээрээ дарж хаана явааг харах боломжтой.";
	if ($status=="custom") echo "Гаальд саатсан байна.";
	echo "<br><br>";
	echo "<i>Хэрэв таны ачаа хүргэгдсэн төлөв байгаад манайд бүртгэгдээгүй бол бидэнд яаралтай мэдэгдэнэ үү.</i>";
	
}

if ($query->num_rows() == 0)  //Бүтргэлгүй
{
	$sql2 = "SELECT customer_id FROM customer WHERE tel='$contact' AND password='$password' LIMIT 1";
	$query2 = $this->db->query($sql2);
	if ($query2->num_rows() == 1)
	{
		
					echo form_open('welcome/tracks_completing',array("id"=>"form"));
					echo form_hidden("track",$track);
					echo form_hidden("contact",$contact);
					echo form_hidden("password",$password);
					echo form_hidden("trigger",0);
					
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
					
					
					echo form_submit("Үүсгэх","Би авна!",array("class"=>"btn btn-primary","id"=>"submit"));
	echo form_button("Үүсгэх","Өөр хүн авна",array("class"=>"btn btn-primary","id"=>"button_trigger"));

	echo "<table class='table table-hover'>";

					echo "<tr id='toggle'><td>Нэр(*)</td><td>".form_input("name","",array("placeholder"=>"Нэр","class"=>"form-control"))."</td></tr>";
					echo "<tr id='toggle1'><td>Утасны дугаар(*)</td><td>".form_input("tel","",array("placeholder"=>"Утасны дугаар","class"=>"form-control"))."</td></tr>";
					echo "<tr id='toggle2'><td>Хаяг</td><td>".form_textarea("address","",array("placeholder"=>"Гэрийн хаяг","class"=>"form-control"))."</td></tr>";
					echo "<tr id='toggle4'><td>".form_submit("Үүсгэх","Баталгаажуулах",array("class"=>"btn btn-primary"))."</td><td></td></tr>";
	echo "</table>";
					echo form_close();
		
	}
	else  echo "<span style='color:#a61212;'><i>Нууц үг буруу байна та ахин эхэлнэ. ".anchor ("welcome/track_search","Энд")." дарна уу.</i></span>";
}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

<?=anchor("welcome/track_search","Ахин хайх",array("class"=>"btn btn-primary"));?>