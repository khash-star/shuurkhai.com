<div class="panel panel-primary">
  <div class="panel-heading">Box Related Settings</div>
  <div class="panel-body">
<? 
		$options=$_POST["options"];
		$agent_id=$this->session->userdata("agent_id");
		switch ($options)
	    {
		case "onair":$new_status = "onair";break;
		case "delete": $new_status = "delete";break;
		}

	if(isset($_POST['boxes'])) {$boxes=$_POST['boxes'];$N = count($options);}
	if(isset($_POST['boxes_id'])) {$boxes_id=$_POST['boxes_id'];$N = 1;} else {$N = count($boxes); $boxes_id="";}
	if ($N!=0 || $boxes_id!="")
	{
	$count=1;
		
   	echo "<table class='table table-hover'>";
    echo "<tr>";
	   echo "<th>№</th>"; 
	   echo "<th>Нэр</th>"; 
	   echo "<th>Тоо</th>"; 
	   echo "<th>Огноо</th>"; 
	   echo "<th>Төлөв</th>"; 
	   echo "<th>Жин</th>"; 
	   echo "<th></th>"; 
	   echo "</tr>";
    for($i=0; $i < $N; $i++)
    {
	 	$boxes_id=$boxes[$i];
		$query = $this->db->query("SELECT * FROM boxes WHERE box_id='".$boxes_id."' LIMIT 1");
		$row=$query->row();
		$name=$row->name;
		$packages=$row->packages;
		$created_date=$row->created_date;
		$weight=$row->weight;

		if ($new_status=="onair")
		{
			$count=1;		
			$query = $this->db->query("SELECT * FROM boxes WHERE box_id=$boxes_id LIMIT 1");
				if ($query->num_rows()==1)
				{
				$row= $query->row();
				$box_id= $row->box_id; 
				$name= $row->name; 
				$packages= box_inside($box_id,"packages");
				$created_date = $row->created_date;
				$weight= box_inside($box_id,"weight");
				$status = $row->status;
				$packages_query = $this->db->query("SELECT * FROM boxes_packages WHERE box_id=$box_id");
				if ($packages_query->num_rows()>0)
					{
					$inside_item =$packages_query->num_rows();
					$inside_count =0;
				
					foreach($packages_query->result() as $package_row)
					{
					$barcode=$package_row->barcode;
					$combined=$package_row->combined;
					$order_id=$package_row->order_id;
					$barcodes=$package_row->barcodes;
					$order_id=$package_row->order_id;
					if ($combined!=1) //SINGLE
						{
						$order_query= $this->db->query("SELECT * FROM orders WHERE barcode='$barcode'");
						if ($order_query->num_rows()==1)
							{
							$row_orders = $order_query->row();
							if(!($row_orders->status=="delivered" || $row_orders->status=="warehouse" || $row_orders->status=="custom")) 
							$this->db->query("UPDATE orders SET status='onair',onair_date='".date("Y-m-d H:i:s")."' WHERE order_id=$order_id");
						$inside_count++;
							}
						} //SINGLE ENDING
					if ($combined==1) //COMBINED
						{
							foreach(explode(",",$barcodes) as $barcode_each)
							{
							$order_query= $this->db->query("SELECT * FROM orders WHERE barcode='$barcode_each'");
							if ($order_query->num_rows()==1)
								{
								$row_orders = $order_query->row();
								if(!($row_orders->status=="delivered" || $row_orders->status=="warehouse" || $row_orders->status=="custom")) 
								$this->db->query("UPDATE orders SET status='onair',onair_date='".date("Y-m-d H:i:s")."' WHERE barcode='$barcode_each'");
								}
							}
						$this->db->query("UPDATE box_combine SET status='onair',onair_date='".date("Y-m-d H:i:s")."' WHERE barcode='$barcode'");
						$inside_count++;
						} //COMBINED ENDING
				
					}
					if ($inside_item==$inside_count)
						$this->db->query("UPDATE boxes SET status='onair' WHERE box_id='$boxes_id' LIMIT 1");
					echo "<tr>";
					echo "<td>".$count."</td>";
					echo "<td>".anchor('admin/boxes_detail/'.$row->box_id,$name)."</td>"; 
					echo "<td>".$packages."</td>"; 
					echo "<td>".substr($created_date,0,10)."</td>"; 
					echo "<td>";
					if ($inside_item==$inside_count) echo "onair";
					echo "</td>"; 
					echo "<td>".$weight."</td>"; 
					echo "</tr>";
					}
				}
			}
		
		if ($new_status=="delete")  //DELETE BOXES
			{
			$count=1;		
			$query = $this->db->query("SELECT * FROM boxes WHERE box_id=$boxes_id LIMIT 1");
			if ($query->num_rows()==1)
				{
				$row= $query->row();
				$box_id= $row->box_id; 
				$name= $row->name; 
				$created_date = $row->created_date;
				$status = $row->status;
				$agent= $row->agent; 
				if ($status=="new")
					 if ($agent==$agent_id)
				   		{
					$delete_boxes = $this->db->query("DELETE FROM boxes WHERE box_id='$boxes_id'");
					$delete_boxes = $this->db->query("DELETE FROM boxes_packages WHERE box_id='$boxes_id'");
					$delete_status="delete";
				   		}
					else  $delete_status="not yours";
			  else $delete_status="Should be only new box";
				   echo "<tr>";
				   echo "<td>".$count."</td>";
				   echo "<td>".anchor('admin/boxes_detail/'.$row->box_id,$name)."</td>"; 
				   echo "<td>".$packages."</td>"; 
				   echo "<td>".substr($created_date,0,10)."</td>"; 
				   echo "<td>".$delete_status."</td>"; 
					echo "<td>".$weight."</td>"; 
					echo "</tr>";
				  
				}
			}
		}
	echo "</table>";
	}
	
	else echo "Хайрцаг тэмдэглэгдээгүй байна";
?>

</div>
</div>