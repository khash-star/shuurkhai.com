<? if (isset($_POST["contacts"])) 
	{
	 $tel=$_POST["contacts"];
	 if ($tel == "")
	 redirect('customers/pre_register/406');
	 
	 if (!ctype_digit($tel))
	 redirect('customers/pre_register/405');
	 
	 if (ctype_digit($tel))
		{
			$query = $this->db->query("SELECT * FROM customer WHERE tel='".$tel."' LIMIT 1");
			if ($query->num_rows() == 1)
			{
				$row = $query->row();
				$customer_id = $row->customer_id ;
				redirect('customers/pre_order/'.$tel);
			}
			if ($query->num_rows() == 0)
				redirect('customers/register/'.$tel);
		}
	
	}
	else redirect('customers/pre_register/409');
?>