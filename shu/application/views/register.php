<? if ($this->uri->segment(3)) $tel=$this->uri->segment(3); else $tel=""; ?>

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
	//$("#agreement").hide();
	
   $("[name='trigger']").click(function(){
	$("#agreement").toggle(100);
	})	
	
	$("input[name='name']").validate(function()
	{  alert("with error");});
})
</script>
<?
echo "<div class='panel panel-default'>";
echo "<div class='panel-heading'>Хэрэглэгч бүртгүүлэх</div>";
echo "<div class='panel-body'>";
if ($tel!="") echo '<div class="alert alert-warning" role="alert">Хэрэглэгчийн мэдээлэл олдсонгүй та бүртгүүлэн Track-аа бүртгүүлэх боломжтой болно.</div>';
echo form_open('welcome/registering',array("id"=>"register_form"));
echo "<table class='table table-hover'>";
echo "<tr><td>Нэр(*)</td><td>".form_input("name","",array("placeholder"=>"Нэр","class"=>"form-control","required"=>"true"))."</td></tr>";
echo "<tr><td>Овог(*)</td><td>".form_input("surname","",array("placeholder"=>"Овог","class"=>"form-control","required"=>"true"))."</td></tr>";
echo "<tr><td>Утасны дугаар(*)</td><td>".form_input("tel",$tel,array("placeholder"=>"Утасны дугаар","class"=>"form-control","required"=>"true"))."</td></tr>";
echo "<tr><td>И-мэйл(*)</td><td>".form_input("email","",array("placeholder"=>"И-мэйл","class"=>"form-control","required"=>"true"))."</td></tr>";
echo "<tr><td>Хаяг</td><td>".form_textarea("address","",array("placeholder"=>"Гэрийн хаяг","class"=>"form-control","required"=>"true"))."</td></tr>";
echo "<tr><td>Нэвтрэх нэр(*)</td><td>".form_input("username",$tel,array("placeholder"=>"Нэвтрэх нэр сонгох","class"=>"form-control","required"=>"true"))."</td></tr>";

echo "<tr><td>Нууц үг (*)</td><td>".form_password("password","",array("placeholder"=>"Нууц үгээ сонгох","class"=>"form-control","required"=>"true"))."</td></tr>";

echo "<tr><td>Гэрээ(*)</td><td>".form_checkbox("trigger","",array("class"=>"form-control","required"=>"true"))." Зөвшөөрөх</td></tr>";
	echo "<tr id='agreement'><td colspan='2'>";
	echo '<div class="panel panel-warning">';
  	echo '<div class="panel-heading">Гэрээ</div>';
  	echo '<div class="panel-body">';
	echo '<p>Энэ гэрээ нь  SHUURKHAI CARGO LLC түүний нийлүүлж байгаа цахим худалдаатай холбоотой үйлчилгээг хэрэглэж байгаа хүн Хэрэглэгч хоорондын хоёр талын эрх үүрэг хариуцлагыг тодорхойлсон сайт ашиглахтай холбоотой хуулийн бичиг юм</p>
<p>1. Дүрэм, дотоод журам, хориглох зүйлс :<br>
А. Бид дараах зүйлийг анхааруулж байна.<br>
 Монгол руу илгээж буй илгээмжиндээ мэдүүлээгүй бараа , валют мөнгөн тэмдэгт, үнэт цаас, галт зэвсэг, газ, бензин, шүдэнз, асаагуур, нойтон цэнэглэгч, хүчил, аюултай тэсэрч дэлбэрэх бодис , химийн урвалт бодис, хар тамхи, хумсны ацетон, үсний лак, гутлын шүршдэг арчилгааны тос зэрэг болон садар самууныг суртчилсан хуурцаг, DVD, VCD зэрэг хориотой бараа хийж явуулахыг хориглоно. Монголын гаалын байгуулагад мэдүүлээгүй бараа , хориотой эд зүйлсийг хурааж авсан тохиолдолд бид хариуцлага хүлээхгүй болохыг анхааруулж байна.<br>
Б. Илгээмж доторх зүйлсийг ГААЛИЙН МЭДҮҮЛЭГТ бичгээр хийж өгдөг учир та бүхэн доорх дурдсан зүйлийг бичиж, хуснэгтийн дагуу бөглөх <br>
1. Хүлээн авагчийн нэр , утас, хаяг<br>
2. Илгээмж доторх зүйлсийн жагсаалт , үнийн дүн<br>
Эдгээр зүйлсийг бичиж явуулаагүй тохиолдолд монголын гаалиар оруулахгүй болсныг мэдэгдэж байна
Нэмэлт журмыг сайтар уншана уу !!!<br>
Шинэ хуучин холилдсон хувцас , бараа болон шинэ бараа илгээмж нь 1000$- оос дээш хэтрэхгүй байх eстой.
Дан хуучин хувцас, гутал , хуучин зуйлсийг илгээж байгаа бол yнийн дyнгийн хязгаарлалт байхгуй та бухэн өөрсдөө унэ бичиж миний тараасан хуснэгт дээр бөглөөд явуулна. {гэхдээ шинэ хувцас дотор нь хийж болохгуй }<br><br>

В. Илгээмж нь 3-7 хоногтоо ирэх бөгөөд МИАТ-н ачаалал болон онгоцны эвдрэл гарсан тохиолдолд ачаа хоцрох буюу хойшлогдох тохиолдол гардаг учраас үүнийг анхааралдаа авахыг хүсч байна. Гэхдээ 1 хайрцагны хязгаарлалт нь 60 кг- с илүү байж болохгүйг анхааруулж байна .<br>
Анхаарах зүйл нь: илгээмжийн сав, баглаа боодлыг сайтар боож таарсан хайрцаганд хийхгүй бол хөндий хайрцаг цөмрөх аюултайг анхаарна уу! Хагарах , няцрах зүйлийг хагарна болгоомжтой гэж бичихээс гадна улаан зориулалтын скочоор наахыг сануулж байна. Та бүхэн өөрийн илгээмждээ хулгайд алдагдахаас сэргийлсэн даатгал хийлгэхийг зөвлөж байна. <br>
Г. Монголын гаальд бараа үлдсэн тохиолдолд хүлээн авагч нь манай комрианаас баримт аваад гааль дээрээс очиж авна.
Жич: Үнийн өөрчлөлт гарсан тохиолдолд тухайн үед нь байнга мэдээлж байх болно.<br></p>';
	echo '</div>';	
	echo '</div>';	
	echo "</td></tr>";



echo "</table>";


echo form_submit("submit","Бүртгүүлэх",array("class"=>"btn btn-success"));
echo form_close();
echo "</div>"; //panel body
echo "</div>";  //panel
//echo anchor ("welcome/register","Шинээр бүртгүүлэх",array("class"=>"btn btn-primary"));

?>