<? if ($_POST["track"]=="" || !isset($_POST["weight"]) || $_POST["weight"]=="" ) redirect('agents/tracks_insert');  ?>


<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 

$barcode = $_POST["track"];
$weight = $_POST["weight"];
if(isset($_POST["contact"])) $contact = $_POST["contact"]; else  $contact="";

if (substr($barcode,0,2)=="CP")
	$query = $this->db->query("SELECT * FROM orders WHERE barcode=\"$barcode\" LIMIT 1");
	else 
	$query = $this->db->query("SELECT * FROM orders WHERE third_party=\"$barcode\" LIMIT 1");

	if ($query->num_rows() == 1)
		{
		$row=$query->row();
		$order_id= $row->order_id;
		$status = 'order';
		
		$data = array(
				'weight'=>$weight,
  			    'status'=> $status,
            );
		$this->db->where('order_id', $order_id);
		if ($this->db->update('orders', $data)) 
		echo "Амжилттай заслаа.<br>";
		
		}
		else 
		{
		if($contact)
		$query_receiver = $this->db->query('SELECT customer_id FROM customer WHERE tel="'.$contact.'"');
		if ($query_receiver->num_rows()>0)
		{
		$r_row= $query_receiver->row();
		$r_id = $r_row->customer_id; 
		}
		else $r_id=1;
		
		$receiver_id =$r_id; //RECEIVER NULL
		$created_date = date("c");
		if ($r_id!=1 && $weight!="")
		$status="new"; else $status = "order";
		$third_party=$barcode;
		$barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
do {
  $barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
  $query = $this->db->query("SELECT order_id FROM orders WHERE barcode='$barcode'");
} while ($query->num_rows() == 1); 
		//$Package_advance=1;
		$advance_value = $weight*cfg_paymentrate();
		$agent_id=$this->session->userdata("agent_id");
		
		$data = array(
			   'created_date'=>$created_date,
			   'barcode'=>$barcode,
			   'weight'=>$weight,
			   'receiver'=>$receiver_id,
			   'third_party'=>$third_party,
			   'status'=> $status,
			   'agents'=>$agent_id,
			   'advance'=>1,
			   'advance_value'=>$advance_value,
			   'is_online'=>1
			   
            );
	if ($this->db->insert('orders', $data)) 
	{
		$order_id= $this->db->insert_id();
		
		echo "Илгээмжийг орууллаа<br>";
		echo anchor("agents/tracks_edit/".$order_id,"засах");
	}
		else echo "Error".$this->db->error();
		}

?>

</div> <!-- PANEL-BODY -->
</div><!-- PANEL -->