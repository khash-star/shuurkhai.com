<div class="panel panel-primary">
  <div class="panel-heading">Дараа тооцоо төлөх</div>
  <div class="panel-body">
<?
	$contacts = $_POST["contacts"];
	$query = $this->db->query("SELECT * FROM customer WHERE tel='".$contacts."' LIMIT 1");
	if ($query->num_rows() == 1)
	{
		$row = $query->row();
		$customer_id = $row ->customer_id;
		$init_balance = $_POST["balance"];
		$payment = $_POST["payment"];
		$date = $_POST["date"];
		$description = $_POST["description"];
		$final_balance = $init_balance-$payment;

			$data = array(
			'd_customer'=>$customer_id,
			'init_balance'=>$init_balance,
			'payment'=>$payment,
			'date'=>$date,
			'description'=>$description,
			'final_balance'=>$final_balance);
				if ($this->db->insert('later_payment', $data))
					{
						echo "<table class='table table-hover'>";
						echo "<tr>";
						echo "<th>Огноо</th>"; 
				      	echo "<th>Төлсөн</th>"; 
					   	echo "<th>Эхний үлдэгдэл</th>"; 
					   	echo "<th>Төлбөр</th>"; 
					   	echo "<th>Үлдэгдэл</th>"; 
					   	echo "<th>Төлөв</th>"; 
					   	echo "</tr>";

					   	echo "<tr>";
						echo "<td>$date</td>"; 
				      	echo "<td>".customer($customer_id,"name")."</td>"; 
					   	echo "<td>$init_balance</td>"; 
					   	echo "<td>$payment</td>"; 
					   	echo "<td>$final_balance</td>"; 
					   	echo "<td>Төлсөн</td>"; 
					   	echo "</tr>";
					   	echo "</table>";
					 }
					 else echo "Бичиглэл оруулахад алдаа гарлаа";

	}
	else echo "Хэрэглэгчийн мэдээлэл олдсонгүй";		
?>


</div>
</div>