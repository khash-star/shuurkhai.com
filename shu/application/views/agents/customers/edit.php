<? if (!$this->uri->segment(3)) redirect('agents/customers_display'); else $customer_id=$this->uri->segment(3) ?>
<script src="<?=base_url();?>assets/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/jquery.ui.themes/flick/jquery.ui.theme.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/jquery.ui.themes/flick/jquery-ui.css"/>
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery.chained.min.js"></script>



<div id="dialog-confirm" title="Үйлчлүүлэгчийн мэдээлэл устгах" style="display:none;">
<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Энэ Үйлчлүүлэгчийн мэдээллийг баазаас бүрэн устгах уу?</p>
	<? $sql= "SELECT * FROM orders WHERE (receiver=".$customer_id." OR sender=".$customer_id." OR deliver=".$customer_id.") AND status='delivered'";
	$query = $this->db->query($sql);
	echo "Баазах энэ хэрэглэгчийн ".$query->num_rows()." бичиглэл байна";
	?>
</div>

<div class="panel panel-success">
  <div class="panel-heading">Хэрэглэгчийн мэдээлэл засах</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT customer.* FROM customer 
WHERE customer_id=".$customer_id);

if ($query->num_rows() == 1)
{
	$row = $query->row();
	$name=$row->name;
	$surname=$row->surname; 
	$rd=$row->rd;
	$contacts=$row->tel;
	$address=$row->address;
	$email=$row->email;
	$city_id=$row->address_city;
	$district_id = $row->address_district;
	$khoroo = $row->address_khoroo;
	$build = $row->address_build;

	//$cities =array();
	

	echo "<table class=\"table table-hover\">";
	 echo "<tr>";
	   echo "<th>№</th>"; 
	   echo "<th>Нэр</th>"; 
	   //echo "<th>Овог</th>"; 
	  // echo "<th>РД</th>"; 
	   echo "<th>Утас</th>"; 
	   //echo "<th>Э-мэйл</th>"; 
	   echo "<th>Хаяг</th>"; 
	   echo "<th></th>"; 
	   echo "</tr>";
	   //$count=$total_costumers - $page*50;
	   
	foreach ($query->result() as $row)

	
	//$username=$row->username;
	//$password=$row->password;
	echo form_open("agents/customers_editing");
	echo form_hidden("customer_id",$customer_id);
	echo "<table class='table table-hover'>";
	echo "<tr><td>Нэр</td><td>".form_input("name",$name,array("class"=>"form-control","readonly"=>"true"))."</td></tr>";	
	echo "<tr><td>Овог</td><td>".form_input("surname",$surname,array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>РД</td><td>".form_input("rd",$rd,array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>Утас</td><td>".form_input("contacts",$contacts,array("class"=>"form-control","readonly"=>"true"))."</td></tr>";	
	echo "<tr><td>Э-мэйл</td><td>".form_input("email",$email,array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>Хаяг</td><td>".form_textarea("address",$address,array("class"=>"form-control"))."</td></tr>";	
	echo "<tr><td>Хот, аймаг</td><td>";
	?>
		<select name="city" class="form-control" id="city">
		<?
		$sql =  "SELECT *FROM city";
		$query_cities = $this->db->query($sql);
		foreach ($query_cities->result() as $row)
		{
			?>
			<option value="<?=$row->id;?>" <?=($row->id==$city_id)?'SELECTED="SELECTED"':'';?>><?=$row->name;?></option>
			<?
		}
		?>
		</select>
	<?
	echo "</td></tr>";
	echo "<tr><td>Дүүрэг, сум</td><td>";
	?>
		<select name="district" class="form-control" id="district">
		<?
		$sql =  "SELECT *FROM district";
		$query_cities = $this->db->query($sql);
		foreach ($query_cities->result() as $row)
		{
			?>
			<option value="<?=$row->id;?>" data-chained="<?=$row->city_id;?>" <?=($row->id==$district_id)?'SELECTED="SELECTED"':'';?>><?=$row->name;?></option>
			<?
		}
		?>
		</select>
	<?
	echo "</td></tr>";

	echo "<tr><td>Баг, хороо</td><td>".form_input("khoroo",$khoroo,array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>Байр, гудамж</td><td>".form_input("build",$build,array("class"=>"form-control"))."</td></tr>";
	//echo "<tr><td>Нэвтрэх нэр</td><td>".form_input("username",$username,array("class"=>"form-control"))."</td></tr>";	

	//echo "<tr><td>Нууц үг</td><td>".form_password("password",$password,array("class"=>"form-control"))."</td></tr>";	
	echo "</table>";
	
	echo form_submit("Засах","Засах",array("class"=>"btn btn-success"));
	echo form_close();	

}
else echo "Үйлчлүүлэгч одсонгүй";

?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<script>
$(document).ready(function() {
	$("#district").chained("#city");
	$("button[name='Устгах']").click(function(){
	$( "#dialog-confirm" ).dialog({
		resizable: false,
		height:200,
		modal: true,
		buttons: 
		{
			
			"Үгүй": function() {
			$( this ).dialog( "close" );
			},
	
			"Тийм": function() {
			$( this ).dialog( "close" );
			window.location="<?=base_url()?>index.php/agents/customers_deleting/<?=$customer_id?>";
			}
		}
	});
	});
});
</script>
<? //form_button("Устгах","Устгах",array("class"=>"btn btn-danger","id"=>"delete_button"));?>


