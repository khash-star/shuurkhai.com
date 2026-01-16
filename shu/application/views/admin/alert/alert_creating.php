<div class="panel panel-primary">
  <div class="panel-heading">Мэдээ: Оруулах</div>
  <div class="panel-body">

<? 
	$context=$_POST["context"];
	$link=$_POST["link"];
	$query = $this->db->query("SELECT customer_id FROM customer");
		foreach ($query->result() as $row)
		{
			$customer_id = $row->customer_id;
			$data = array(
		               'type' => 1,
		               'customer_id' => $customer_id,
					   'context' => $context,
					   'target' => $link,
		            );
			$this->db->insert('alert', $data);
		}
	


?>

</div>
</div>