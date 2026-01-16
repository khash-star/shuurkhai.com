<script type="application/javascript">
$(function() {
	$('.container_info').hide();
	$("input[name='package1_name']").prop('required',true);
	$("input[name='package1_num']").prop('required',true);
	$("input[name='package1_price']").prop('required',true);
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

	$("[name='container_trigger']").change(function() {
        if ($(this).is(':checked')) {
           $('.container_info').show();
        }
        else  $('.container_info').hide();
    })



	
   $("[id='button_trigger']").click(function(){
	$("#toggle").toggle(100);
	$("#toggle1").toggle(100);
	$("#toggle2").toggle(100);
	$("#toggle3").toggle(100);
	$("#toggle4").toggle(100);
	$("[name='trigger']").val(1);
	
	if ($("[name='name']").prop('required')) 
            $("[name='name']").prop('required', false); else  $("[name='name']").prop('required', true);
			
	if ($("[name='surname']").prop('required')) 
            $("[name='surname']").prop('required', false); else  $("[name='surname']").prop('required', true);

        
	if ($("[name='tel']").prop('required')) 
            $("[name='tel']").prop('required', false); else $("[name='tel']").prop('required', true);
			
	if ($("[name='address']").prop('required')) 
            $("[name='address']").prop('required', false); else $("[name='address']").prop('required', true);

	})	
	
		$("#submit").click(function(){
			$("[name='trigger']").val(0);
		 $("[name='name']").prop('required', false);
		 $("[name='surname']").prop('required', false);
		  $("[name='tel']").prop('required', false); 
		  $("[name='address']").prop('required', false); 
		 // alert('asdas');
		  $this.parent().submit();
		 // $('#form').submit();
	})

})
</script>
<? if (!isset($_POST["track"]) && $_POST["track"]=="") redirect("customer/create"); else $track=$_POST["track"]; 
$track = str_replace(" ","",$track);

if(isset($_POST["transport"])) $transport = 1; else $transport=0;


?>
<div class="panel panel-success">
  <div class="panel-heading">Та Тракаа бүртгүүлснээр 1&cent; таны хуримтлалын санд нэмэгдэнэ.</div>
  <div class="panel-body">
<? 

$customer_id = $this->session->userdata('customer_id');
$track_eliminated = substr($track,-8,8);
$sql = "SELECT * FROM orders WHERE SUBSTRING(third_party,-8,8) = '$track_eliminated' LIMIT 1";

$query = $this->db->query($sql);
if ($query->num_rows() == 1)
{
	$row = $query->row();
	$receiver = $row->receiver;
	$status = $row->status;
	if ($receiver!=$customer_id)
	{
		if ($status!="order")
		{
		echo '<div class="alert alert-danger" role="alert">Таны илгээмж биш байна.<br>Бидэнтэй холбогож тодруулна уу. Утас: 99037509</div>';
		echo anchor ("customer/orders_create/","Ахин оруулах",array("class"=>"btn btn-primary btn-xs"));
		}
		if ($status=="order")
		{
		echo '<div class="alert alert-success" role="alert">Манайх дээр хүргэгдсэн ба та барааны тайлбар оруулах шаардлагатай.<br>Track:'.$track.'</div>';
		echo form_open("customer/orders_completing");
		echo form_hidden("track",$track);
		echo form_hidden("transport",$transport);
		echo "<h3>Барааны тайлбар</h3>";
		echo "<table class='table table-hover'>";
		echo "<tr>";
		
		echo "<td>".form_input("package1_name","",array("class"=>"form-control","placeholder"=>"Цамц, Цүнх, Утас г.м"))."</td>";
		echo "<td>".form_input("package1_num","",array("class"=>"form-control ","placeholder"=>"Тоо ширхэг"))."</td>";
		echo "<td>".form_input("package1_price","",array("class"=>"form-control ","placeholder"=>"Үнэ ($)"))."</td>";
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
		
		echo form_submit("Үүсгэх","Дуусгах",array("class"=>"btn btn-primary"));
		echo form_close();
		//echo anchor ("customer/orders_create/","Ахин оруулах",array("class"=>"btn btn-primary btn-xs"));
		}
	}
	
	if ($receiver==$customer_id)
	{
		if ($status=="item_missing")
		{
		echo '<div class="alert alert-danger" role="alert">Та барааны тайлбар оруулах шаардлагатай.<br>
		Track:'.$track.'</div>';
		echo form_open("customer/orders_completing");
		echo form_hidden("track",$track);
		echo form_hidden("transport",$transport);
		echo "<h3>Барааны тайлбар</h3>";
		echo "<table class='table table-hover'>";
		echo "<tr>";
		
		echo "<td>".form_input("package1_name","",array("class"=>"form-control","placeholder"=>"Цамц, Цүнх, Утас г.м"))."</td>";
		echo "<td>".form_input("package1_num","",array("class"=>"form-control ","placeholder"=>"Тоо ширхэг"))."</td>";
		echo "<td>".form_input("package1_price","",array("class"=>"form-control ","placeholder"=>"Үнэ ($)"))."</td>";
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
		
		echo form_submit("Үүсгэх","Үргэлжлэх",array("class"=>"btn btn-primary"));
		echo form_close();
		
		}
		
		if ($status!="item_missing")
		{
		echo '<div class="alert alert-success" role="alert">Танд бүртгэлтэй Track байна.</div>';
		echo anchor ("customer/orders/","Миний захиалга",array("class"=>"btn btn-success btn-xs"));
		}
		
	}
	
}

if ($query->num_rows() == 0)  //Бүтргэлгүй
{
	echo form_open("customer/orders_completing");
	echo form_hidden("track",$track);
	echo form_hidden("transport",$transport);
	
	echo "<h3>Барааны тайлбар</h3>";
	echo "<table class='table table-hover'>";
	echo "<tr>";
	
	echo "<td>".form_input("package1_name","",array("class"=>"form-control","placeholder"=>"Цамц, Цүнх, Утас г.м"))."</td>";
	echo "<td>".form_input("package1_num","",array("class"=>"form-control ","placeholder"=>"Тоо ширхэг"))."</td>";
	echo "<td>".form_input("package1_price","",array("class"=>"form-control ","placeholder"=>"Үнэ ($)"))."</td>";
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
	echo "</td></tr>";

	
	echo "</table>";
	
	echo form_submit("Үүсгэх","Би авна!",array("class"=>"btn btn-primary","id"=>"submit"));
	echo form_button("Үүсгэх","Өөр хүн авна",array("class"=>"btn btn-primary","id"=>"button_trigger"));
	echo "Чингэлэгээр ирэх: ".form_checkbox("container_trigger","1");
	echo form_hidden("trigger",0);
	echo "<div class='container_info'>
		<h3>Чингэлэг</h3>
		<ul>
			<li>Та ачаагаа чингэлэг-р сонгосоноор таны ачаа 45 хоногын дотор далайгаар ирнэ.</li>
			<li>Төлбөрийн хувьд уяан хатан нөхцөлтэй.</li>
		</ul>
	</div>";

	echo form_hidden("trigger",0);

	echo "<table class='table table-hover'>";
				//	echo "<tr><td colspan='2'>Өөрөө хүлээн авах ".form_checkbox("trigger","1",array("class"=>"form-control","required"=>"true"))."<br><span  id='toggle3' style='color:#a61212;'><i>Доор оруулсан хүн ирж авах боломжтой</i></span></td></tr>";					
					echo "<tr id='toggle'><td>Нэр(*)</td><td>".form_input("name","",array("placeholder"=>"Нэр","class"=>"form-control"))."</td></tr>";
					echo "<tr id='toggle1'><td>Овог(*)</td><td>".form_input("surname","",array("placeholder"=>"Овог","class"=>"form-control"))."</td></tr>";
					echo "<tr id='toggle2'><td>Утасны дугаар(*)</td><td>".form_input("tel","",array("placeholder"=>"Утасны дугаар","class"=>"form-control"))."</td></tr>";
					echo "<tr id='toggle3'><td>Хаяг</td><td>".form_textarea("address","",array("placeholder"=>"Гэрийн хаяг","class"=>"form-control"))."</td></tr>";
					echo "<tr id='toggle4'><td>".form_submit("Үүсгэх","Баталгаажуулах",array("class"=>"btn btn-primary"))."</td><td></td></tr>";
	echo "</table>";
					
					
					
	echo form_close();
	
}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

