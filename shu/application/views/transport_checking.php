<? if (!isset($_POST["track"]) && $_POST["track"]=="") redirect("welcome/track_search"); 
else {
	$track=$_POST["track"]; 
	$track = str_replace(" ","",$track);
	$track = str_replace("script","***",$track);
	$track = str_replace("php","***",$track);
	$track = str_replace("<?","***",$track);
}

?>
<div class="panel panel-success">
<? 
if (strlen($track)==8) //TEL 
	{
	?>
    <div class="panel-heading text-center">Нууц үг оруулна уу.</div>
   <div class="panel-body">

	<?
	$sql = "SELECT customer_id FROM customer WHERE tel = '$track'";
	$query = $this->db->query($sql);
	if ($query->num_rows() == 1) 
		{
			echo form_open ("welcome/transport_checking2");
			echo "<table class='table table-hover'>";
			echo form_hidden("tel",$track);
			echo "<tr><td>Нууц үг</td><td>".form_password("password","",array("class"=>"form-control"))."</td></tr>";
			echo "</table>";
	
			echo form_submit("submit","Үргэлжлүүлэх",array("class"=>"btn btn-primary"));

			form_close();
			
		}
		else echo '<div class="alert alert-danger" role="alert">Бүртгэл олдсонгүй. '.anchor("welcome/transport","Энд").' дарж ахин оролдоно уу</div>';

	}
if (substr($track,0,2) == "GO") // BARCODE
	{
	?>
    <div class="panel-heading text-center">Та илгээмж Хүргэлттэй боллоо</div>
   <div class="panel-body">

	<?
	$sql = "SELECT receiver FROM orders WHERE barcode = '$track'";
	$query = $this->db->query($sql);
	if ($query->num_rows() == 1) 
		{
			$rows = $query->row();
			$customer_id = $rows->receiver;
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
		else echo '<div class="alert alert-danger" role="alert">Barcode олдсонгүй. '.anchor("welcome/transport","Энд").' дарж ахин оролдоно уу</div>';		
	}
if (substr($track,0,2) != "GO" && strlen($track)>8) // TRACK
	{
	?>
    <div class="panel-heading text-center">Та илгээмж Хүргэлттэй боллоо</div>
   <div class="panel-body">

	<?
	$track_eliminated = substr($track,-8,8);
	$sql = "SELECT receiver FROM orders WHERE SUBSTRING(third_party,-8,8) = '$track_eliminated'";
	$query = $this->db->query($sql);
	if ($query->num_rows() == 1) 
		{
			$rows = $query->row();
			$customer_id = $rows->receiver;
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
		else echo '<div class="alert alert-danger" role="alert">Barcode олдсонгүй. '.anchor("welcome/transport","Энд").' дарж ахин оролдоно уу</div>';		
	}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

