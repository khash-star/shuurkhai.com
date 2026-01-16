<? //if ($_POST["box_id"]=="" && $_POST["barcode"]=="") redirect('agents/boxes_display');  ?>
<? 
if (isset($_POST["box_id"])) $box_id = $_POST["box_id"]; else  $box_id="";
if (isset($_POST["barcode"]))$barcode = $_POST["barcode"]; else $barcode="";

	if (substr($barcode,0,2)=="CP")
	$query = $this->db->query("SELECT * FROM orders WHERE barcode='".$barcode."' LIMIT 1");
	else 
	$query = $this->db->query("SELECT * FROM orders WHERE third_party='".$barcode."' LIMIT 1");

	$query2 = $this->db->query("SELECT * FROM boxes WHERE box_id='".$box_id."' LIMIT 1");

	if ($query->num_rows() == 1 && $query2->num_rows() == 1 )
		{
		$row=$query->row();
		$order_id= $row->order_id;
		$status= $row->status;
		if ($status=="new")
		{
		$data = array(
               'box_id' => $box_id,
			   'order_id' => $order_id,
            );
		if ($this->db->insert('boxes_packages', $data)) 
			{
				echo "Order now in box"; 
			}
		}
		else echo "Order not ready to fill the box";
		}
	else echo "Barcode not found";
	
?>