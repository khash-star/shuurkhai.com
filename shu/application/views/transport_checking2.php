<? if (!isset($_POST["password"]) && $_POST["password"]=="") redirect("welcome/transport"); 
else {
	$password=$_POST["password"]; 
	$password = str_replace(" ","",$password);
	$password = str_replace("script","***",$password);
	$password = str_replace("php","***",$password);
	$password = str_replace("<?","***",$password);
}
$tel = $_POST["tel"];
?>
<div class="panel panel-success">
  <div class="panel-heading">Хүргэлт авсан байдал</div>
  <div class="panel-body">
<? 
	$sql = "SELECT customer_id FROM customer WHERE tel = '$tel' AND password='$password'";
	$query = $this->db->query($sql);
	if ($query->num_rows() == 1) 
		{
			form_open ("admin/transport_checking2");
			form_close();
			$rows = $query->row();
			$customer_id = $rows->customer_id;
			$sql_transport = "SELECT * FROM orders WHERE receiver='$customer_id' AND status IN ('onair','warehouse')";
			$query_transport = $this->db->query($sql_transport);
			if ($query_transport->num_rows()>0)
			{
			echo "Ирж яваа болон агуулахад байгаа ".$query_transport->num_rows()." ачааг хүргэхээр боллоо.";
			$sql_transport = "UPDATE orders SET transport=1 WHERE receiver='$customer_id' AND status IN ('onair','warehouse')";
			$this->db->query($sql_transport);
			}
			if ($query_transport->num_rows()==0) echo '<div class="alert alert-danger" role="alert">Хүргэлт авах ачаа олдсонгүй. '.anchor("welcome/transport","Энд").' дарж ахин оролдоно уу</div>';
		}
		else echo '<div class="alert alert-danger" role="alert">Бүртгэл олдсонгүй. '.anchor("welcome/transport","Энд").' дарж ахин оролдоно уу</div>';
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

