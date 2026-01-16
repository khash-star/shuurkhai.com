<? if (!$this->uri->segment(3)) redirect('admin/customers'); else $customer_id=$this->uri->segment(3) ?>
<? if (!$this->uri->segment(4)) redirect('admin/customers/'.$customer_id); else $proxy_id=$this->uri->segment(4) ?>



<div class="panel panel-primary">
  <div class="panel-heading">Хэрэглэгчийн удирдлагын хэсэг</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM customer WHERE customer_id=".$customer_id);

if ($query->num_rows() == 1)
{
	$row = $query->row();
	$name=$row->name;
	$surname=$row->surname; 
	$rd=$row->rd; 
	$contacts=$row->tel;
	$address=$row->address;
	$username=$row->username;
	$password=$row->password;
	$email=$row->email;
	echo "<table class='table table-hover'>";
	echo "<tr><td>Нэр</td><td>".$name."</td></tr>";	
	echo "<tr><td>Овог</td><td>".$surname."</td></tr>";
	echo "<tr><td>РД</td><td>".$rd."</td></tr>";
	echo "<tr><td>Утас</td><td>".$contacts."</td></tr>";	
	echo "<tr><td>Э-мэйл</td><td>".$email."</td></tr>";
	echo "<tr><td>Хаяг</td><td>".$address."</td></tr>";	
	echo "</table>";
	echo anchor('admin/customers_edit/'.$row->customer_id,'Мэдээлэллийг засах',array("class"=>"btn btn-primary"));
}
?>

</div>
</div>




<div class="panel panel-primary">
  <div class="panel-heading">Proxy засах</div>
  <div class="panel-body">
    <? 

    $query = $this->db->query("SELECT * FROM proxies WHERE proxy_id='$proxy_id' AND customer_id=".$customer_id);

    if ($query->num_rows() == 1)
    {
        $row = $query->row();

        $name=$row->name;
        $surname=$row->surname;
        $tel=$row->tel;
        $address=$row->address;

        echo form_open('admin/customers_proxy_editing');
        echo "<table class='table table-hover'>";
        echo "<tr><td>Нэр:(*)</td><td>".form_input ("proxy_name",$name,array("class"=>"form-control"))."</td></tr>";
        echo "<tr><td>Овог:</td><td>".form_input ("proxy_surname",$surname,array("class"=>"form-control"))."</td></tr>";
        echo "<tr><td>Утас:(*)</td><td>".form_input ("proxy_contacts",$tel,array("class"=>"form-control"))."</td></tr>";
        echo "<tr><td>Хаяг:</td><td>".form_textarea ("proxy_address",$address,array("class"=>"form-control"))."</td></tr>";
        echo "</table>";
        echo form_hidden ("customer_id",$customer_id);
        echo form_hidden ("proxy_id",$proxy_id);
        echo form_submit("submit","Засах",array("class"=>"btn btn-primary"));
        echo form_close();
    }
    else redirect('admin/customers/'.$customer_id); 

    ?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

<?=anchor("admin/customers_proxy/".$customer_id,"Бүх proxy",array("class"=>"btn btn-primary")); ?>