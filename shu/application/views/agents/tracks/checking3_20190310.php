<? if (!isset($_POST["track"])) redirect("agents/check"); else $track=$_POST["track"];

require_once('assets/class/BCGFontFile.php');
require_once('assets/class/BCGDrawing.php');
require_once('assets/class/BCGcode128.barcode.php');
require_once("barcode_writer.php");


?>

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

<script>
$(document).ready(function(e) {
    $("input[name='package1_name']").focus();
	
	
	
	  $('form#check3').submit(function() {
		  if($("input[name='package1_name']").val()!="" && $("input[name='package1_num']").val()!="")
		  form.submit();
		  else 
		  {
			  return false;
		  	$("input[name='package1_name']").focus();
			}
		  
		  
	  })
	
});
</script>
<div class="panel panel-primary">
  <div class="panel-heading">Track: тайлбар</div>
  <div class="panel-body">
<? 
$track = string_clean($track);
$track_eliminated = substr($track,-8,8);
if (isset($_POST["contact"])) $contact=$_POST["contact"]; else $contact="";
$order_id=tracksearch($track);

if ($order_id!="")
		{
			$query = $this->db->query("SELECT * FROM orders WHERE order_id = '$order_id'");
			$row = $query->row();
			$third_party=$row->third_party;
			$receiver_id=$row->receiver;
			$created_date=$row->created_date;
			$weight=$row->weight;
			$status=$row->status;
			if ($status=="order") 
			{
				$query_receiver = $this->db->query('SELECT * FROM customer WHERE tel="'.$contact.'"');
				if ($query_receiver->num_rows() == 1)
				 {
					 	$costumer_row = $query_receiver->row();
						$costumer_id = $costumer_row -> customer_id;
						$no_proxy = $costumer_row -> no_proxy;
						$new_status="item_missing";
					
						
						$data = array(
						'receiver' => $costumer_id,
						'status'=> $new_status
						);
						
						$this->db->where('order_id', $order_id);
						$this->db->update('orders', $data);
						
						echo '<div class="alert alert-success" role="alert">Хүлээн авагчтай</div>';
						echo form_open('agents/tracks_checking4');
						echo form_hidden("track",$track);
						echo "<p>Ачааг шалгаж барааны тайлбарыг заавал оруулна</p>";
						
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

						$options = array(
					  		'yes' => 'proxy авна',
					  		'no' => 'үгүй'
	                		);
						if ($weight<3.8)
							{
								if ($no_proxy==0)
								echo form_dropdown("proxy",$options,'yes',array("class"=>"form-control"));
								else echo "Proxy авдаггүй дугаар<br>";
							}
						else echo "Их жинтэй proxy авахгүй<br>";




						echo form_submit("submit","add",array('class'=>'btn btn-success'));
						echo form_close();

				 }
				 else 	{
				 			echo '<div class="alert alert-danger" role="alert">Хэрэглэгийн утасны дугаар бүртгэлгүй байна. Үүнийг хэрэглэгчээс өөрийн болгоно. </div>';
					
						}
				
			}
			if ($status=="item_missing") 
			echo '<div class="alert alert-danger" role="alert">Барааны дэлгэрэнгүй бичигдээгүй байна. устгаад ахин оруулна уу.</div>';

			if ($status=="weight_missing") 
			echo '<div class="alert alert-danger" role="alert">Жин ороогүй төлөвт байна.</div>';
			  
		}
	
if ($order_id=="")
{
	$container_id = containersearch($track);
	if ($container_id) echo "чингэлэгээр ирэх.";
	else echo $track."[ORder:".$order_id."] Ачааны дугаар буруу байна.";
}
?>

</div> <!-- PANEL-BODY -->
</div><!-- PANEL -->
<? //anchor('agents/tracks_insert/','New track',array('class'=>'btn btn-primary'));?>
