<? //if ($_POST["box_id"]=="" && $_POST["barcode"]=="") redirect('agents/boxes_display');  ?>
<? 
if (isset($_POST["box_id"])) $box_id = $_POST["box_id"]; 
if (isset($_POST["barcode"]))$barcode = strtoupper($_POST["barcode"]);
//if ($this->uri->segment(3)) $box_id =$this->uri->segment(3);
//if ($this->uri->segment(4)) $barcode=$this->uri->segment(4);
//echo "box:".$box_id;
//echo "barcode:".$barcode;
//echo "===============";


$combined=0;
$order_id=0;
$weight=0;
$error=0;
	if ($box_id!="" && $barcode!="")
	{
	 	$query = $this->db->query("SELECT * FROM orders WHERE barcode='".$barcode."' LIMIT 1");
	 	if ($query->num_rows()==1)
		{
		$row = $query->row();
		$order_id = $row->order_id;
		$error=0;
		$weight=$row->weight;
		$receiver=$row->receiver;
		$combined=0;
		if ($row->boxed==1) {$error=1;
		$sql_already = "SELECT name FROM boxes_packages LEFT JOIN boxes ON boxes_packages.box_id = boxes.box_id WHERE  barcode='$barcode' LIMIT 1";
		$query_already=$this->db->query($sql_already);
		if ($query_already->num_rows()==1)
		$data_already = $query_already->row();
		
		 redirect("agents/boxes_fill/".$box_id."/already/".$data_already->name);}
		}

		$query_combine = $this->db->query("SELECT * FROM box_combine WHERE barcode='".$barcode."' LIMIT 1");
		if ($query_combine->num_rows()==1)
		{
		$row_combine = $query_combine->row();
		$combined=1;
		$barcodes = $row_combine->barcodes;
		$error=0;
		$weight=$row_combine->weight;
		$receiver=$row_combine->receiver;
		if ($row_combine->boxed==1) {$error=1;
		$sql_already = "SELECT name FROM boxes_packages LEFT JOIN boxes ON boxes_packages.box_id = boxes.box_id WHERE  barcode='$barcode' LIMIT 1";
		$query_already=$this->db->query($sql_already);
		if ($query_already->num_rows()==1)
		$data_already = $query_already->row();
		
		 redirect("agents/boxes_fill/".$box_id."/already/".$data_already->name);}
		}
		
		if(substr($weight,-2)=="kg" || substr($weight,-2)=="Kg") $weight = substr($weight,0,strlen($weight)-2);
		
		if ($error==0)
		{
		$query2 = $this->db->query("SELECT * FROM boxes WHERE box_id='".$box_id."' LIMIT 1");
		if ($query2->num_rows() == 1 )
			{
			$row_box=$query2->row();
			$box_status=$row_box->status;
			
				if ($box_status!="onair"&&$box_status!="delivered" && $box_status!="warehouse")
				{
				$sql = "SELECT * FROM boxes_packages WHERE box_id='$box_id' AND barcode='$barcode' LIMIT 1";
				$query=$this->db->query($sql);
					if ($query->num_rows()==0)
						{
							if ($combined==1)
								$data = array('box_id' => $box_id,'barcode' => $barcode,'barcodes'=>$barcodes,'combined'=>1,'weight'=>$weight,'receiver'=>$receiver);
							if ($combined==0)
								$data = array('box_id' => $box_id,'barcode' => $barcode,'order_id'=>$order_id,'combined'=>0,'weight'=>$weight,'receiver'=>$receiver);
							if ($this->db->insert('boxes_packages', $data)) 
							{
							echo '<div class="alert alert-success" role="alert">Succesdfully addded</div>';
							$this->db->query("UPDATE boxes SET packages=packages+1,weight=weight+".$weight." WHERE box_id='$box_id'");								
							
							if ($combined==1)
								{
								foreach(explode(',',$barcodes) as $each_barcode)
									{
									if ($each_barcode!="")
									$this->db->query("UPDATE orders SET boxed=1 WHERE barcode='$each_barcode'");	
									}
								$this->db->query("UPDATE box_combine SET boxed=1 WHERE barcode='$barcode'");
								}
							if ($combined==0)
							$this->db->query("UPDATE orders SET boxed=1 WHERE barcode='$barcode'");
							redirect("agents/boxes_fill/".$box_id."/ok");
							}
							else //echo '<div class="alert alert-danger" role="alert">Error:'.$this->db->error().'</div>';
							redirect("agents/boxes_fill/".$box_id."/sql_error");
						}
					else //echo '<div class="alert alert-danger" role="alert">Order already inside the box</div>'; 	
					redirect("agents/boxes_fill/".$box_id."/already");
				}
				else// echo '<div class="alert alert-danger" role="alert">Box status is onair or delivered</div>';
				redirect("agents/boxes_fill/".$box_id."/onair");
			}
			else //echo '<div class="alert alert-danger" role="alert">Box not found</div>';
			redirect("agents/boxes_fill/".$box_id."/box_not_found");
			
		}
		else//echo '<div class="alert alert-danger" role="alert">Barcode not found</div>';
		redirect("agents/boxes_fill/".$box_id."/barcode_not_found");
	}
	else //echo '<div class="alert alert-danger" role="alert">Barcode, хайрцаг оруулаагүй байна.</div>';
	redirect("agents/boxes_fill/".$box_id."/no_inputs");

?>