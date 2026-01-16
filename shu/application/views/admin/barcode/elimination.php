<div class="panel panel-primary">
  <div class="panel-heading">Barcode:Eliminating</div>
  <div class="panel-body">
<? 
$options=$_POST["options"];
	   echo "<table class='table table-hover'>";
	   echo "<tr>";
	   echo "<th>Barcode оруулсан</th>"; 
	   echo "<th>Barcode</th>"; 
	   echo "<th>Захиалгын огноо</th>"; 
       echo "<th>Илгээгч</th>"; 
	   echo "<th>Хүлээн авагч</th>"; 
	   echo "<th>Хүлээн авагчын утас</th>"; 
	   echo "<th>Хоног</th>"; 
	   echo "<th>Төлөв</th>"; 
	   echo "<th>Шинэ төлөв</th>"; 
	   echo "<th></th>"; 
	   echo "</tr>";
	$barcode_id=@$_POST['barcode_id'];
  	$N = count($barcode_id);
    for($i=0; $i < $N; $i++)
    {
 	$query = $this->db->query("SELECT * FROM barcode WHERE barcode.barcode='".$barcode_id[$i]."' LIMIT 1");
		foreach ($query->result() as $row)
		{
		$barcode= $row->barcode;
		$combine=$row->combine;
		$timestamp=$row->timestamp;
		$status=$row->status;
		
		if ($combine==0)
		$inside_query=$this->db->query("SELECT * FROM orders WHERE barcode='$barcode'");
		else 
		$inside_query=$this->db->query("SELECT * FROM box_combine WHERE barcode='$barcode'");
		
		if ($inside_query->num_rows()==1)
			{
			$data=$inside_query->row();
			$created_date=$data->created_date;
			$sender_id=$data->sender;
			$receiver_id=$data->receiver;
			$package=$data->package;
			$Package_advance =$data->advance;
			$Package_advance_value =$data->advance_value;
			$single_status=$data->status;
			//$single_extra=$data->extra;
			
			if ($combine==0)
			$order_id=$data->order_id;
			else 
			{ $combine_id=$order_id=$data->combine_id; $barcodes=$data->barcodes;}
			}


		
			
			$s_name=customer($sender_id,"name");
			$s_surname=customer($sender_id,"surname");
			$s_tel=customer($sender_id,"tel");
			$s_email=customer($sender_id,"email");
			$s_address=customer($sender_id,"address");



			$r_name=customer($receiver_id,"name");
			$r_surname=customer($receiver_id,"surname");
			$r_tel=customer($receiver_id,"tel");
			$r_email=customer($receiver_id,"email");
			$r_address=customer($receiver_id,"address");

		
	
	
		$days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;

		
	   
		 switch ($options)
	    {
		//case "delivered": $new_status = "delivered";break;
		case "weight_missing":$new_status = "weight_missing";break;
		case "new":$new_status = "new";break;
		case "onair":$new_status = "onair";break;
		case "warehouse":$new_status = "warehouse";$extra=$_POST["bench"];break;
		case "hand":$new_status = "hand";break;
		case "unhandover":$new_status = "unhandover";break;
		case "custom":$new_status = "custom";$extra="";break;
		case "delete":$new_status = "delete";$extra="";break;
		}
	
	   echo "<tr>";
	   echo "<td>".$timestamp."</td>"; 
	   echo "<td>".$barcode."</td>"; 
	   echo "<td>".$created_date."</td>"; 
       echo "<td>".$s_name."</td>"; 
	   echo "<td>".$r_name."</td>"; 
	   echo "<td>".$r_tel."</td>"; 
	   echo "<td>".$days."</td>"; 
	   echo "<td>".$status."</td>"; 
	  
	    
	   
	  if ($combine==0)
	  	{
		if($new_status=="weight_missing") 
		$data = array(
               'status' => $new_status,
			   'weight' =>""
            		  );	
		if($new_status=="new") 
		$data = array(
               'status' => $new_status,
            		  );	
	
		if($new_status=="onair") 
		$data = array(
               'status' => $new_status,
			   'onair_date'=>date("Y-m-d H:i:s")
            		  );	
					  
		if($new_status=="warehouse") 
		$data = array(
               'status' => $new_status,
			   'warehouse_date'=>date("Y-m-d H:i:s"),
			   'extra'=>$extra
            		  );	
					  
		if($new_status=="custom") 
		$data = array(
               'status' => $new_status,
			   'warehouse_date'=>date("Y-m-d H:i:s")
            		  );	
					  			  
		if($new_status=="hand") 
		$data=array(
			'transport' => '1'
		);	

		if($new_status=="unhandover") 
		$data=array(
			'transport' => '0'
		);	
		
	   if($options=="warehouse" || $options=="custom" || $options=="hand" || $options=="onair" || $options=="new" ||  $options=="weight_missing" || $options=="unhandover")
	   	{
			//if ($single_status!='delivered')
		//	{
			$this->db->where('order_id', $order_id);
			if ($this->db->update('orders', $data))
				{
				//	echo $this->db->sql;
				 $this->db->query("DELETE FROM barcode WHERE barcode='".$barcode_id[$i]."' LIMIT 1");
				 echo "<td>".$new_status."</td>"; 

				 if ($options=="warehouse")
				 {
				 	// BOX OF THIS ITEM STATUS CHANGE

				 	$sql = "SELECT *FROM boxes_packages WHERE barcode='".$barcode_id[$i]."' OR barcodes LIKE '%".$barcode_id[$i]."%' LIMIT 1";
				 	$box_query = $this->db->query($sql);
					if ($box_query->num_rows()==1)
					{
						$box_rows = $box_query->row();
						$box_id = $box_rows->box_id;
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
											$proxy_id = $row_orders->proxy_id;
											$proxy_type = $row_orders->proxy_type;
											proxy_available($proxy_id,$proxy_type,0);
											if($row_orders->status=="warehouse" || $row_orders->status=="custom" || $row_orders->status=="delivered") 
											$inside_count++;  // COUNT WAREHOUSE OR CUSTOM
											}
										} //SINGLE ENDING
									if ($combined==1) //COMBINED
										{
											
										$box_query= $this->db->query("SELECT * FROM box_combine WHERE barcode='$barcode'");
										if ($box_query->num_rows()==1)
											{
											$row_box = $box_query->row();

											if($row_box->status=="warehouse" || $row_box->status=="custom" || $row_box->status=="delivered") 
											//$this->db->query("UPDATE orders SET status='warehouse',warehouse_date='".date("Y-m-d H:i:s")."' WHERE order_id=$order_id");
											$inside_count++;  // COUNT WAREHOUSE OR CUSTOM
											}								
										//$inside_count++;
										} //COMBINED ENDING
								}

								if ($inside_item==$inside_count)
								$this->db->query("UPDATE boxes SET status='".$options."' WHERE box_id='$box_id' LIMIT 1");
							}
					}
					// BOX OF THIS ITEM STATUS CHANGE				 	
				 }
				}
		 	else echo "<td>Алдаа".$this->db->error()."</td>";
		//	}
			//else echo "<td>Алдаа: Хүргэгдсэн</td>"; 
			
		}
		elseif ($options=="delete")
		  	   {
				$this->db->query("DELETE FROM barcode WHERE barcode='".$barcode_id[$i]."' LIMIT 1");
			   echo "<td>".$new_status."</td>"; 
			   }
		echo "<td>".anchor('orders/detail/'.$order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>";
			
		}
		
		
		
		
		
	if ($combine==1)
		{	
		if($new_status=="onair") 
		$data = array(
               'status' => $new_status,
			   'onair_date'=>date("Y-m-d H:i:s")
            		  );	

		
		
		if($new_status=="custom") 
		$data = array(
               'status' => $new_status,
			   'delivered_date'=>date("Y-m-d H:i:s")
            		  );	
					  
		if($new_status=="warehouse") 
		$data = array(
               'status' => $new_status,
			   'warehouse_date'=>date("Y-m-d H:i:s"),
			   'extra'=>$extra
            		  );	
		if($new_status=="hand") 
		$data=array(
			'transport' => '1'
		);			

		if($new_status=="unhandover") 
		$data=array(
			'transport' => '0'
		);	  
	   if($options=="warehouse" || $options=="custom" || $options=="hand" || $options=="onair" || $options=="unhandover")
	   	{
			//if ($single_status!='delivered')
			//{
			$barcodes_array = explode(",",$barcodes);
				foreach($barcodes_array as $barcode_box_inside)
				{
					$this->db->where('barcode', $barcode_box_inside);
					$this->db->update('orders', $data);
				}
			$this->db->where('barcode', $barcode_id[$i]);
			if ($this->db->update('box_combine', $data))
				{
				 $this->db->query("DELETE FROM barcode WHERE barcode='".$barcode_id[$i]."' LIMIT 1");
				 echo "<td>".$new_status."</td>"; 
				}
		 	else echo "<td>Алдаа".$this->db->error()."</td>";
			//}
			//else echo "<td>Алдаа: Хүргэгдсэн</td>"; 
			
		}
		elseif ($options=="delete")
		  	   {
				$this->db->query("DELETE FROM barcode WHERE barcode='".$barcode_id[$i]."' LIMIT 1");
			   echo "<td>".$new_status."</td>"; 
			   }
		echo "<td>".anchor('orders/detail/'.$order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>";
					
		}
	echo "</tr>";	


    	}
	}
	echo "</table>";
	
	
	
?>

</div>
</div>