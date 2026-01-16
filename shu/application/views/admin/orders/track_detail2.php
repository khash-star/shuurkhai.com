<? if ($this->uri->segment(3)) $track = $this->uri->segment(3); else redirect('orders/track');?>
<? if ($this->uri->segment(4)) $tel = $this->uri->segment(4); else redirect('orders/track_register/'.$track);?>

<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<?
	$query = $this->db->query("SELECT * FROM customer WHERE tel='".$tel."' LIMIT 1");
if ($query->num_rows() == 1)
{
	$row = $query->row();
	$customer_id = $row->customer_id ;
	$name = $row->name;
	$surname = $row->surname;
	
	echo "<div class=\"box\">";
	echo "<h4 class=\"legend\">Хэрэглэгч</h4>";
	
	echo "Таны дугаар <b style='font-size:larger'>".substr($surname,0,2).".".$name." </b> нэр дээр бүртгэлтэй байна.<br>";
	echo "</div>";
	
	echo form_open('orders/track_completing/'.$track."/".$tel);
	echo "<div class=\"box\">";
	echo "<h4 class=\"legend\">Бараа</h4>";
	echo "Track №<b>".$track."</b>";
	

	$this->table->set_heading(array('Барааны нэр(*)', 'Тоо(*)','Үнэ /$/ (*)'));
	
	$this->table->add_row( array(
	"<input type='text' name='package1_name' required oninvalid='this.setCustomValidity(\"Барааны тухай заавал оруулна\")'>",
	"<input type='text' name='package1_num' required oninvalid='this.setCustomValidity(\"Барааны тухай заавал оруулна\")'>",
	"<input type='text' name='package1_value' required oninvalid='this.setCustomValidity(\"Барааны тухай заавал оруулна\")'>"
	

	/*form_input ("package1_name","",array('required'=>'required')), 
	form_input ("package1_num","",array('required'=>'required')), 
	form_input ("package1_value","",array('required'=>'required'))*/
	));
	
	$this->table->add_row( array(
	form_input ("package2_name"), 
	form_input ("package2_num"), 
	form_input ("package2_value")
	));
	
	$this->table->add_row( array(
	form_input ("package3_name"), 
	form_input ("package3_num"), 
	form_input ("package3_value")
	));
	
	
	$this->table->add_row( array(
	form_input ("package4_name"), 
	form_input ("package4_num"), 
	form_input ("package4_value")
	));
	echo $this->table->generate(); 

	echo "</div>";
	
	echo form_submit("submit","Хадгал");
	
	

	form_close();
	
	
}

if ($query->num_rows() == 0)
  redirect('customers/register/'.$tel);
?>
</div>
