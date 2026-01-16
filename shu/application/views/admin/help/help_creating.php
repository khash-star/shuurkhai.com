 <div class="panel panel-primary">
    <div class="panel-heading">Тусламж</div>
      <div class="panel-body">
<? 
	$contacts=$_POST["contacts"];
	
	if ($contacts!="")
		{	
		$query_deliver = $this->db->query('SELECT customer_id FROM customer WHERE tel="'.$contacts.'"');
		if($query_deliver->num_rows()==1)
			{
				$row=$query_deliver->row();
				$receiver=$row->customer_id;
				
				$data = array(
			   'context'=>$_POST["context"],
			   'sender'=>NULL,
			   'receiver'=>$receiver,
			   'ip' =>$_SERVER['REMOTE_ADDR']
            );

			if ($this->db->insert('help', $data))
				{
					$help_id = $this->db->insert_id();
				echo '<div class="alert alert-success" role="alert">
			<span class="glyphicon glyphicon-ok-circle"></span>Тусламж үүсгэлээ.</div>';	
				$data = array(
					'context'=>"Танд. Админаас зурвас ирлээ",
					'customer_id'=>$receiver,
					'target'=>'help_read.php?id='.$help_id
					
				);
				$this->db->insert('alert', $data);	
				}
			else
			echo '<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			</span>Алдаа:'.$this->db->error().'</div>';
			}
		else redirect("admin/help_create");	
		}
	else redirect("admin/help_create");	
?>
	


</div>
</div>

