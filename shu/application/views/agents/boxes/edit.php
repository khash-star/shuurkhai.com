<? if (!$this->uri->segment(3)) redirect('agents/customers_display'); else $customer_id=$this->uri->segment(3) ?>
<script src="<?=base_url();?>assets/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/jquery.ui.themes/flick/jquery.ui.theme.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/jquery.ui.themes/flick/jquery-ui.css"/>

<script>
$(document).ready(function() {
	$("#delete_button").click(function(){
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
<script>
jQuery(function($){
   $("input[name='rd']").mask("өө99999999");
   $("input[name='contacts']").mask("99999999");
})
</script>

<div id="dialog-confirm" title="Үйлчлүүлэгчийн мэдээлэл устгах" style="display:none;">
<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Энэ Үйлчлүүлэгчийн мэдээллийг баазаас бүрэн устгах уу?</p>
</div>

<div class="panel panel-success">
  <div class="panel-heading">Shuurkhai.Com</div>
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
	$email=$row->email;
	echo "<table class='table table-hover'>";
	echo "<tr><td>Нэр</td><td>".$name."</td></tr>";	
	echo "<tr><td>Овог</td><td>".$surname."</td></tr>";
	echo "<tr><td>РД</td><td>".$rd."</td></tr>";
	echo "<tr><td>Утас</td><td>".$contacts."</td></tr>";	
	echo "<tr><td>Э-мэйл</td><td>".$email."</td></tr>";
	echo "<tr><td>Хаяг</td><td>".$address."</td></tr>";	
	echo "</table>";

	echo form_open('agents/customers_editing');
	echo form_hidden('customer_id',$customer_id);
	echo "<span class='formspan'>Нэр:(*)</span>";
	echo form_input ("name",$name)."<br>";
	echo "<span class='formspan'>Овог:(*)</span>";
	echo form_input ("surname",$surname)."<br>";
	echo "<span class='formspan'>РД:(*)</span>";
	echo form_input ("rd",$rd)."<br>";
	echo "<span class='formspan'>Утас:</span>";
	echo form_input ("contacts",$contacts)."<br>";
	echo "<span class='formspan'>Э-мэйл:</span>";
	echo form_input ("email",$email)."<br>";
	echo "<span class='formspan'>Хаяг:</span>";
	echo form_textarea("address",$address)."<br>";
	
	echo form_submit("submit","засах");
	echo form_close();
	$data = array(
	'type'=>'button',
	'name' =>'delete_button',
    'id' => 'delete_button',
	'value' => 'устгах'
	);
	 echo form_input($data);
    //echo anchor("customers/deleting/".$customer_id,"устгах");

}
else echo "Зээлдэгч байхгүй";

?>

</div>

<div id="right_side">
<? $this->load->view("calendar");?>
<div id="side_menu">
<ul>
<li><?=anchor('agents/customers', 'Үйлчлүүлэгчид')?></li>
<li><?=anchor('agents/customers_insert', 'Үйлчлүүлэгч оруулах')?></li>
</ul>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div> <!--wrapper-->