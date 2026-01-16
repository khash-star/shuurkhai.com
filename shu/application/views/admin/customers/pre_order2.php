<? if ($this->uri->segment(3)) $tel = $this->uri->segment(3); else redirect('pre_register');?>
<script type="application/javascript">

$(function() {
	
	$( "a#add" ).click(function() {
			var track = $("input[name='third_party']").val();
			
			var package1_name = $("input[name='package1_name']").val();
			var package1_num = $("input[name='package1_num']").val();
			var package1_value = $("input[name='package1_value']").val();
			
			var package2_name = $("input[name='package1_name']").val();
			var package2_num = $("input[name='package1_num']").val();
			var package2_value = $("input[name='package1_value']").val();
			
			var package3_name = $("input[name='package1_name']").val();
			var package3_num = $("input[name='package1_num']").val();
			var package3_value = $("input[name='package1_value']").val();

			var package4_name = $("input[name='package1_name']").val();
			var package4_num = $("input[name='package1_num']").val();
			var package4_value = $("input[name='package1_value']").val();
			
			var package = package1_name+"##"+package1_num+"##USA####"+package1_value+
			package2_name+"##"+package2_num+"##USA####"+package2_value+
			package3_name+"##"+package3_num+"##USA####"+package3_value+
			package4_name+"##"+package4_num+"##USA####"+package4_value;
			
				if (track!="" && package1_name!="")
				{
				alert(track+' захиалга нэмэгдлээ');
				$("#description").append("Track№ <b>"+track+'</b>('+package1_name+" "+package1_num+'..)<br>');
				$("#other").val($("#other").val()+"%%"+track+'$$'+package);
				$("input[name='third_party']").val("");
				$("input[name='package1_name']").val("");
				$("input[name='package2_name']").val("");
				$("input[name='package3_name']").val("");
				$("input[name='package4_name']").val("");
				
				$("input[name='package1_num']").val("");
				$("input[name='package2_num']").val("");
				$("input[name='package3_num']").val("");
				$("input[name='package4_num']").val("");
				
				$("input[name='package1_value']").val("");
				$("input[name='package2_value']").val("");
				$("input[name='package3_value']").val("");
				$("input[name='package4_value']").val("");

				}
			
			});
	})
</script>
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
	
	echo form_open('customers/pre_ordering/'.$tel);
	echo "<input type='hidden' id='other' name='other'>";
	echo "<div class=\"box\">";
	
	echo "<h4 class=\"legend\">Бараа</h4>";
	echo "<div id='description'></div>";
	
	echo "<span class='formspan'>Track№ (*)</span>";
	echo "<input type='text' name='third_party' required='required' required oninvalid='this.setCustomValidity(\"Track № заавал оруулна\")'>";
	//echo form_input ("third_party","")."<br>";
	
	$this->table->set_heading(array('Барааны нэр(*)', 'Тоо(*)','Үнэ /$/ (*)'));
	
	$this->table->add_row( array(
	"<input type='text' name='package1_name' required='required' required oninvalid='this.setCustomValidity(\"Барааны тухай заавал оруулна\")'>",
	"<input type='text' name='package1_num' required='required' required oninvalid='this.setCustomValidity(\"Барааны тухай заавал оруулна\")'>",
	"<input type='text' name='package1_value' required='required' required oninvalid='this.setCustomValidity(\"Барааны тухай заавал оруулна\")'>"
	

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
	
	//echo "<br><a id='add' class='button' href='#'> + нэмэх </a><br>";

	echo form_submit("submit","Хадгал");
	echo "<br><br>(*) - тэмдэглэгээтэй талбарыг заавал бөглөнө.";
	

	form_close();
	
	
}

if ($query->num_rows() == 0)
  redirect('customers/register/'.$tel);
?>
</div>
