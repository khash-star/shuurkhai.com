<? if (!isset($_POST["order_id"])) redirect('customer/orders'); else $order_id=$_POST["order_id"]; ?>

<div class="panel panel-success">
  <div class="panel-heading">Илгээмж үүсгэх</div>
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
			$track=$_POST["track"];
			$track = str_replace(" ","",$track);

			$package1_name=$_POST["package1_name"];
			$package1_num =$_POST["package1_num"];
			$package1_price =$_POST["package1_price"];
			$package2_name=$_POST["package2_name"];
			$package2_num =$_POST["package2_num"];
			$package2_price =$_POST["package2_price"];
			$package3_name=$_POST["package3_name"];
			$package3_num =$_POST["package3_num"];
			$package3_price =$_POST["package3_price"];
			$package4_name=$_POST["package4_name"];
			$package4_num =$_POST["package4_num"];
			$package4_price =$_POST["package4_price"];
			
			$package_array = array(
			$package1_name, $package1_num,$package1_price,
			$package2_name, $package2_num, $package2_price,
			$package3_name, $package3_num, $package3_price,
			$package4_name, $package4_num, $package4_price
			);
			
			$package =implode("##",$package_array);
			$package_price = $package1_price + $package2_price + $package3_price + $package4_price;
			
			$data = array(
				'created_date'=>date("y-m-d h:i:s"),
				'third_party'=>$track,
				'package'=>$package,
				'price'=>$package_price,
				'status' => "weight_missing",
            );
			
			$this->db->where('order_id', $order_id);
			if ($this->db->update('orders', $data)) 
			echo '<div class="alert alert-success" role="alert">Илгээмжийн мэдээллийг заслаа.</div>';
			else echo '<div class="alert alert-danger" role="alert">Илгээмжийн мэдээллийг засахад алдаа гарлаа.</div>';
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

<?=anchor("customer/orders","Миний илгээмжүүд",array("class"=>"btn btn-success"));?>