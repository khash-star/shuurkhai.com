<? if (!$this->uri->segment(3)) redirect('customer/orders'); else $order_id=$this->uri->segment(3) ?>

<div class="panel panel-success">
  <div class="panel-heading">Илгээмж засах</div>
  <div class="panel-body">
<? 
	$customer_id = $this->session->userdata('customer_id');
	
	$query = $this->db->query("SELECT * FROM orders WHERE order_id=".$order_id);
	
	if ($query->num_rows() == 1)
		{
			$row = $query->row();
			if ($row->status=="weight_missing")
			{
			if ($row->sender==$customer_id || $row->receiver==$customer_id)
			{
			$track = $row->third_party;
			$sender = $row->sender;
			$receiver = $row->receiver;
			$package = $row->package;
			$package_array=explode("##",$package);
			$package1_name = $package_array[0];
			$package1_num = $package_array[1];
			$package1_price = $package_array[2];
			$package2_name = $package_array[3];
			$package2_num = $package_array[4];
			$package2_price = $package_array[5];
			$package3_name = $package_array[6];
			$package3_num = $package_array[7];
			$package3_price = $package_array[8];
			$package4_name = $package_array[9];
			$package4_num = $package_array[10];
			$package4_price = $package_array[11];
			
			echo form_open("customer/orders_editing");
			echo form_hidden("order_id",$order_id);
			echo "<table class='table table-hover'>";
			echo "<tr><td>Track</td><td>".form_input("track",$track,array("class"=>"form-control","placeholder"=>"Жишээ нь: 1Z9999999999999999"))."</td></tr>";
			
			echo "<tr><td>Барааны тайлбар</td><td>";
			echo "<table class='table table-hover'>";
			echo "<tr>";
			echo "<td>".form_input("package1_name",$package1_name,array("class"=>"form-control","placeholder"=>"Цамц, Цүх, Утас г.м"))."</td>";
			echo "<td>".form_input("package1_num",$package1_num,array("class"=>"form-control ","placeholder"=>"Тоо ширхэг"))."</td>";
			echo "<td>".form_input("package1_price",$package1_price,array("class"=>"form-control ","placeholder"=>"Үнэ ($)"))."</td>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td>".form_input("package2_name",$package2_name,array("class"=>"form-control","placeholder"=>"Цамц, Цүх, Утас г.м"))."</td>";
			echo "<td>".form_input("package2_num",$package2_num,array("class"=>"form-control ","placeholder"=>"Тоо ширхэг"))."</td>";
			echo "<td>".form_input("package2_price",$package2_price,array("class"=>"form-control ","placeholder"=>"Үнэ ($)"))."</td>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td>".form_input("package3_name",$package3_name,array("class"=>"form-control","placeholder"=>"Цамц, Цүх, Утас г.м"))."</td>";
			echo "<td>".form_input("package3_num",$package3_num,array("class"=>"form-control ","placeholder"=>"Тоо ширхэг"))."</td>";
			echo "<td>".form_input("package3_price",$package3_price,array("class"=>"form-control ","placeholder"=>"Үнэ ($)"))."</td>";
			echo "</tr>";
		
			echo "<tr>";
			echo "<td>".form_input("package4_name",$package4_name,array("class"=>"form-control","placeholder"=>"Цамц, Цүх, Утас г.м"))."</td>";
			echo "<td>".form_input("package4_num",$package4_num,array("class"=>"form-control ","placeholder"=>"Тоо ширхэг"))."</td>";
			echo "<td>".form_input("package4_price",$package4_price,array("class"=>"form-control ","placeholder"=>"Үнэ ($)"))."</td>";
			echo "</tr>";
		
			echo "</table>";
			echo "</td></tr>";
		
			
			echo "</table>";
			echo form_submit("Засах","Засах",array("class"=>"btn btn-primary"));
			echo form_close();
			}
			else  //$row->sender==$customer_id || $row->receiver==$customer_id
			echo '<div class="alert alert-danger" role="alert">Таны илгээмж биш байна.</div>';
			}
			else //$row->status=="weight_missing"
			echo '<div class="alert alert-danger" role="alert">Илгээмж манайх салбарт ирсэн учираас устгах боломжгүй.</div>';
		}
else //$query->num_rows() == 1
echo '<div class="alert alert-danger" role="alert">Илгээмж олдсонгүй.</div>';
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

<?=anchor("customer/orders","Миний илгээмж",array("class"=>"btn btn-success"));?>


<script>
$(document).ready(function() {
	$("#receiver_trigger_content").hide();
	$("#sender_trigger_content").hide();
	
   $("[name='sender_trigger']").click(function(){
	$("#sender_trigger_content").toggle(100);
	})
	
	$("[name='receiver_trigger']").click(function(){
	$("#receiver_trigger_content").toggle(100);
	})
	
});
  
</script>