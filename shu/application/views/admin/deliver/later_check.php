<? 
$final_balance = 0;
if (isset($_POST["tel"])) $tel=$_POST["tel"];
$query = $this->db->query("SELECT * FROM customer WHERE tel='".$tel."' LIMIT 1");
if ($query->num_rows() == 1)
{
	$row_customer = $query->row();
	$customer_id = $row_customer ->customer_id;
	$query_later= $this->db->query("SELECT * FROM later_payment WHERE d_customer='".$customer_id."' ORDER BY id DESC LIMIT 1");
	if ($query_later->num_rows() == 1)
		{
		$row_later = $query_later->row();
		$final_balance =$row_later->final_balance;
		}
	if ($query_later->num_rows() == 0)
		{
			$query_orders= $this->db->query( "SELECT * FROM orders WHERE deliver=$customer_id AND (status='delivered' OR status='custom') AND method ='later'");
			$final_balance =0;$weight=0;$admin=0;$admin_value=0;$advance_value=0;$advance=0;$weight_noooo=0;
			foreach ($query_orders->result() as $row_orders)
				{  
				if ($row_orders->is_online == 0)
					{
					$advance+=$row_orders->advance_value;
					$weight_noooo +=$row_orders->weight;
					}
				if ($row_orders->is_online == 1)
					{
					$admin+=floatval($row_orders->admin_value);
					$weight+=floatval($row_orders->weight);
					}
					$final_balance += $advance+$admin+cfg_price($weight);
				}
			
		}
}
echo $final_balance;
?>