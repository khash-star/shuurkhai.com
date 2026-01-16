<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<?php
	$barcode=$_POST["barcode"];
	$barcode_array = explode("\r\n",$barcode);
	$count=0;
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
			//if ($status=="delivered") echo "Order already delivered";
			//if ($status=="custom") echo "Order in custom";
			//if ($status!="delivered" && $status!="custom") // NOT DELIVERED BARCODE FOUND
			//{
			$barcode_only=$row->barcode;
			$sub_query=$this->db->query("SELECT * FROM barcode WHERE barcode='".$barcode_only."' LIMIT 1");
			if ($sub_query->num_rows() == 1) 
			{
				$count++;
				echo "<b class='red text-red'>".$count.". Barcode already inserted</b>";
			}
			else 
			{
			$this->db->query("INSERT INTO barcode (barcode,status) VALUES ('".$barcode_only."','catched')");
			echo "Barcode Inserted";
			}
			//}// NOT DELIVERED BARCODE FOUND ending
			echo "<br>";
		} 
		else 
			{
			$query_combine = $this->db->query("SELECT * FROM box_combine WHERE barcode='".$barcode_single."' LIMIT 1");
			if ($query_combine->num_rows() == 1)
			{
				
				
				$data_combine = $query_combine->row();
				$status= $data_combine->status;
				//	if ($status=="delivered") echo "Order already delivered";
				//	if ($status=="custom") echo "Order in custom";
				//	if ($status!="delivered" && $status!="custom") // NOT DELIVERED BARCODE FOUND
				//	{
					$barcode_only=$data_combine->barcode;
					$sub_query=$this->db->query("SELECT * FROM barcode WHERE barcode='".$barcode_only."' LIMIT 1");
					if ($sub_query->num_rows() == 1) 
					{
						$count++;
						echo "<b class='red text-red'>".$count.". Barcode already inserted</b>";
						
					}
					else 
					{
					$this->db->query("INSERT INTO barcode (barcode,status,combine) VALUES ('".$barcode_only."','catched',1)");
					echo "Combine box barcode Inserted";
					}
			//		}
			
			} 
			else echo "Barcode not found in both combine and single"; // if ($barcode_single!="") ending
			echo "<br>";
			}
		}
	}
	echo anchor ("admin/barcode_insert","Ахин оруулах",array("class"=>"button"));
	?>
	</div>
    </div>
	<?
	if ($count>0) echo '<h3 class="text-center red">'.$count.' Давхардсан байна</h3><script>alert("'.$count.' давхардсан");</script>';
	?>