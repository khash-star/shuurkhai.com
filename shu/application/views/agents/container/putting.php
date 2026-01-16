<? 
 $item_id=$_POST["item_id"];
 $container=$_POST["container"];

?>
<div class="panel panel-success">
  <div class="panel-heading">Чингэлэгт ачаа оруулах</div>
  <div class="panel-body">
	<? 
	//require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');
	$query = $this->db->query("SELECT * FROM container_item WHERE id=".$item_id);
	if ($query->num_rows()==1)
	{
		$row = $query->row();
		$sender= 	$row ->sender;
		$receiver= 	$row ->receiver;
		$description = $row ->description;
		$weight= 	$row ->weight;
		$payment= 	$row ->payment;
		$pay_in_mongolia= 	$row ->pay_in_mongolia;
		$container_id= 	$row ->container;


		if ($container_id==0) 
			{
				$query = $this->db->query("SELECT * FROM container WHERE container_id=".$container);
				if ($query->num_rows()==1)
				{
					$row = $query->row();
					$container_status = $row->status;
					if ($container_status=="new")
						if ($this->db->query("UPDATE container_item SET container=$container WHERE id=".$item_id))
							echo '<div class="alert alert-success" role="alert">Ачаа чингэлэгт орууллаа.</div>';
							else echo '<div class="alert alert-danger" role="alert">Алдаа:'.$query->error().'</div>';
				}
			}
		else echo '<div class="alert alert-danger" role="alert">Ачаа чингэлэгт байна.</div>';
	}
	else echo '<div class="alert alert-danger" role="alert">Ачааны дугаар алдаатай байна</div>'; ?>
		</div>
	</div>