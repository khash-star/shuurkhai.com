<div class="panel panel-success">
  <div class="panel-heading">Нэхэмжлэх</div>
  <div class="panel-body">
<? 
$sixmonthsback = date("Y-m-d", strtotime("-3 months"));

if ($this->uri->segment(3)!="") $sql = "SELECT * FROM envoice WHERE customer_id ='".$this->uri->segment(3)."' ORDER BY created_date DESC";
	else $sql = "SELECT * FROM envoice WHERE created_date>'$sixmonthsback'  ORDER BY created_date  DESC";
	//$envoice_id=$this->uri->segment(3);
$query = $this->db->query($sql);
if ($query->num_rows() > 0)
{
		$i=1;
		echo "<table class='table table-hover'>";
		foreach ($query->result() as $row)
		{  
		$envoice_id=$row->envoice_id;
		$customer_id=$row->customer_id;
		$orders_array=$row->orders;
		$created_date=$row->created_date;
		$amount=$row->amount;
		$orders = explode(",",$orders_array);
		
		echo "<tr>";
			echo "<td>".$i++."</td>";
			echo "<td>".substr($created_date,0,10)."<h3>№".$envoice_id."</h3></td>";
			echo "<td>".anchor("admin/envoices/".$customer_id,customer($customer_id,"full_name")."<br>".customer($customer_id,"tel"))."</td>";
			echo "<td>".number_format($amount)."</td>";
		echo "<td>";
		foreach($orders as $order)
		{
			echo order($order,"barcode").", ";
		}
		echo "</td>";
		echo "<td>";
		foreach($orders as $order)
		{
			$sql = "SELECT * FROM orders WHERE receiver=".$customer_id." AND order_id='".$order."'";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() ==1)
		{
			$row = $query->row();
			$package=$row->package;
			
			$package_array=explode("##",$package);
			$package1_name = $package_array[0];
			$package1_num = $package_array[1];
			$package1_value = $package_array[2];
			$package2_name = $package_array[3];
			$package2_num = $package_array[4];
			$package2_value = $package_array[5];
			$package3_name = $package_array[6];
			$package3_num = $package_array[7];
			$package3_value = $package_array[8];
			$package4_name = $package_array[9];
			$package4_num = $package_array[10];
			$package4_value = $package_array[11];
				
			
			//if ($third_party!="")
			//echo "<a href='".track($third_party)."' target='_blank' title='Хаана явна'>$third_party<span class='glyphicon glyphicon-globe'></span></a>";
			if ($package1_name!="")
			echo "$package1_name ($package1_num)";
			if ($package2_name!="")
			echo ",$package2_name ($package2_num)";
			if ($package3_name!="")
			echo ",$package3_name ($package3_num)";
			if ($package4_name!="")
			echo ",$package4_name ($package4_num)";
		}
		}
		echo "</td>";
		
		echo "<td>";
		echo anchor("admin/envoice/".$envoice_id,"Харах",array("class"=>"btn btn-xs btn-success","target"=>"new"));
	
		echo "</td>";
		echo "</tr>";	
		}
		echo "</table>";
}
else //$query->num_rows() ==0
{
echo '<div class="alert alert-danger" role="alert">Нэхэмжлэх олдсонгүй.</div>';
}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<? //$this->load->view("shops");?>


<script language="javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>