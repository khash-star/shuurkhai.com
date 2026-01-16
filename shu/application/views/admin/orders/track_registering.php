<? if (isset($_POST["contacts"])) 
	{
	$track=$_POST["track"];
	 $tel=$_POST["contacts"];
	 if ($tel == "")
	 redirect('orders/track_resigter/'.$track);
	 
	 if (!ctype_digit($tel))
	 redirect('orders/track_resigter/'.$track);
	 
	 if (ctype_digit($tel))
		{
			$query = $this->db->query("SELECT * FROM customer WHERE tel='".$tel."' LIMIT 1");
			if ($query->num_rows() == 1)
			{
				$row = $query->row();
				$customer_id = $row->customer_id ;
				redirect('orders/track_detail/'.$track."/".$tel);
			}
			if ($query->num_rows() == 0)
				redirect('orders/track_create/'.$track."/".$tel);
		}
	
	}
	else redirect('orders/track_register/'.$track);
?>