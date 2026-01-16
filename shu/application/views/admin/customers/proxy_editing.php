<? if ($_POST["customer_id"]=="") redirect('admin/customers'); else $customer_id=$_POST["customer_id"]; ?>
<? if ($_POST["proxy_id"]=="") redirect('admin/customers/'.$customer_id); else $proxy_id=$_POST["proxy_id"]; ?>


<div class="panel panel-primary">
  <div class="panel-heading">Proxy засах</div>
  <div class="panel-body">
<? 
 	$query = $this->db->query("SELECT * FROM proxies WHERE proxy_id=$proxy_id AND customer_id=".$customer_id);
	if ($query->num_rows() == 1)
	{
        $proxy_name=$_POST["proxy_name"];
        $proxy_surname=$_POST["proxy_surname"]; 
        $proxy_contacts=$_POST["proxy_contacts"]; 
        $proxy_address=$_POST["proxy_address"];

        $sql="UPDATE proxies SET name='$proxy_name',surname='$proxy_surname',tel='$proxy_contacts',`address`='".$proxy_address."' WHERE proxy_id=$proxy_id AND customer_id=$customer_id LIMIT 1";
        $this->db->query($sql);

	    echo anchor("admin/customers_proxy_edit/".$customer_id."/".$proxy_id,"Ахин засах",array("class"=>"btn btn-primary"));
	}
	else echo '<div class="alert alert-danger" role="alert">Хэрэглэгчийн мэдээлэл олдсонгүй</div>'; 
?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->
