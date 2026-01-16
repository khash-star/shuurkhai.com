<? if (!$this->uri->segment(3)) redirect('customers/display'); else $proxy_id=$this->uri->segment(3); ?>


<div class="panel panel-primary">
  <div class="panel-heading">Proxy устгах</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM proxies WHERE proxy_id=".$proxy_id);

if ($query->num_rows() == 1)
{
	$row = $query->row();
	$name=$row->name;
	$surname=$row->surname; 
	$contacts=$row->tel;
	$address=$row->address;
	$customer_id=$row->customer_id;
	
	echo "<table class='table table-hover'>";
	echo "<tr><td>Нэр</td><td>".$name."</td></tr>";	
	echo "<tr><td>Овог</td><td>".$surname."</td></tr>";
    echo "<tr><td>Утас</td><td>".$contacts."</td></tr>";	
	echo "<tr><td>Хаяг</td><td>".$address."</td></tr>";	
	echo "</table>";



		if ($this->db->query("DELETE FROM proxies WHERE proxy_id=".$proxy_id)) 
		echo '<div class="alert alert-success alert-dismissible" role="alert">Амжилттай устгалаа</div>';
		else '<div class="alert alert-danger alert-dismissible" role="alert">Error'.$this->db->error.'</div>';
		
	echo anchor ("admin/customers_proxy/".$customer_id,"Хэрэглэгч",array("class"=>"btn btn-primary"));

}
else echo '<div class="alert alert-danger alert-dismissible" role="alert">Proxy олдсонгүй</div>';

?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->