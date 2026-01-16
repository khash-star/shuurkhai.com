<? //if ($_POST["box_id"]=="" && $_POST["barcode"]=="") redirect('agents/boxes_display');  ?>
<? 
//if (isset($_POST["box_id"])) $box_id = $_POST["box_id"]; 
//if (isset($_POST["barcode"]))$barcode = strtoupper($_POST["barcode"]);
if ($this->uri->segment(3)) $barcode =$this->uri->segment(3);
//if ($this->uri->segment(4)) $barcode=$this->uri->segment(4);
//echo "box:".$box_id;
//echo "barcode:".$barcode;
//echo "===============";

$weight=0;
if (substr($barcode,0,4)=="GO20" || substr($barcode,0,4)=="GO21" || substr($barcode,0,4)=="GO22" || substr($barcode,0,4)=="GO23" || substr($barcode,0,4)=="GO24" || substr($barcode,0,4)=="GO25") // SINGLE BARCODE
	{
	$query = $this->db->query("SELECT * FROM orders WHERE barcode='".$barcode."' LIMIT 1");
	if ($query->num_rows()==1)
		{
		$row = $query->row();
		$order_id = $row->order_id;
		$weight= $row->weight;
		if(substr($weight,-2)=="kg" || substr($weight,-2)=="Kg") $weight = substr($weight,0,strlen($weight)-2);

		
		$query2 = $this->db->query("SELECT * FROM boxes_packages WHERE order_id='".$order_id."' LIMIT 1");
		if ($query2->num_rows()==1)
			{
				$row2= $query2->row();
				$box_id = $row2->box_id;
				$this->db->query("DELETE FROM boxes_packages WHERE order_id='".$order_id."'");
				$this->db->query("UPDATE boxes SET weight=weight-$weight,packages=packages-1 WHERE box_id='".$box_id."'");
				$this->db->query("UPDATE orders SET boxed=0 WHERE barcode='".$barcode."'");
				redirect("agents/boxes_detail/".$box_id);
			}	
			// else single not found in boxes_packages	
		}
		// else single not found	
	}
	
if (substr($barcode,0,3)=="GO5") // COMBINE BARCODE	
	{
	$query_combine = $this->db->query("SELECT * FROM box_combine WHERE barcode='".$barcode."' LIMIT 1");
	if ($query_combine->num_rows()==1)
		{
		$row_combine= $query_combine->row();
		$barcodes = $row_combine->barcodes;
		$weight = $row_combine->weight;
		$combine_id = $row_combine->combine_id;
		if(substr($weight,-2)=="kg" || substr($weight,-2)=="Kg") $weight = substr($weight,0,strlen($weight)-2);

		$query2 = $this->db->query("SELECT * FROM boxes_packages WHERE barcode='".$barcode."' LIMIT 1");
		if ($query2->num_rows()==1)
				$row2= $query2->row();
				$box_id = $row2->box_id;
				$this->db->query("DELETE FROM boxes_packages WHERE barcode='".$barcode."'");
				$this->db->query("UPDATE boxes SET weight=weight-$weight,packages=packages-1 WHERE box_id='".$box_id."'");
				$this->db->query("UPDATE box_combine SET boxed=0 WHERE barcode='".$barcode."'");
				redirect("agents/boxes_detail/".$box_id);

		}
	}
	
redirect("agents/boxes_detail/".$box_id."/error");
?>