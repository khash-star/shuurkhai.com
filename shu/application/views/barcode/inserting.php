<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<?php
	$barcode=$_POST["barcode"];
	$barcode_array = explode("\r\n",$barcode);
	foreach ($barcode_array as $barcode_single)
	{
		
		if ($barcode_single!="")
		{
		echo $barcode_single."->";
		$query = $this->db->query("SELECT * FROM orders WHERE barcode='".$barcode_single."' OR third_party='".$barcode_single."' LIMIT 1");
		if ($query->num_rows() == 1)
		{
			$row=$query->row();
			$status= $row->status;
			if ($status=="delivered") echo "Order already delivered";
			if ($status=="custom") echo "Order in custom";
			if ($status!="delivered" && $status!="custom") // NOT DELIVERED BARCODE FOUND
			{
			$barcode_only=$row->barcode;
			$sub_query=$this->db->query("SELECT * FROM barcode WHERE barcode='".$barcode_only."' LIMIT 1");
			if ($sub_query->num_rows() == 1) echo "Barcode already inserted";
			else 
			{
			$this->db->query("INSERT INTO barcode (barcode,status) VALUES ('".$barcode_only."','catched')");
			echo "Barcode Inserted";
			}
			}// NOT DELIVERED BARCODE FOUND ending
		} 
		else echo "No order found this barcode";
		}  // if ($barcode_single!="") ending
		echo "<br>";
	}
	echo anchor ("admin/barcode_insert","Ахин оруулах",array("class"=>"button"));
	?>
	</div>
    </div>