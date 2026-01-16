<script type="application/javascript">
$(function() {
			$('body').on('keydown', 'input, select, textarea', function(e) {
			var self = $(this)
			  , form = self.parents('form:eq(0)')
			  , focusable
			  , next
			  ;
			if (e.keyCode == 13) {
				focusable = form.find('input,a,select,button,textarea').filter(':visible');
				next = focusable.eq(focusable.index(this)+1);
				if (next.length) {
					next.focus();
				} else {
					form.submit();
				}
				return false;
			}
		});
	//$("#agreement").hide();
	
   $("[name='trigger']").click(function(){
	$("#agreement").toggle(100);
	})	
})
</script>
<div class="panel panel-danger">
  <div class="panel-heading">Хувийн мэдээлэл</div>
  <div class="panel-body">
<? 
$customer_id = $this->session->userdata('customer_id');
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
	$username=$row->username;
	echo form_open("customer/profile_editing");
	echo "<table class='table table-hover'>";
	echo "<tr><td>Нэр</td><td>".form_input("name",$name,array("class"=>"form-control","readonly"=>"true"))."</td></tr>";	
	echo "<tr><td>Овог</td><td>".form_input("surname",$surname,array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>РД</td><td>".form_input("rd",$rd,array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>Утас</td><td>".form_input("contact",$contacts,array("class"=>"form-control","readonly"=>"true"))."</td></tr>";	
	echo "<tr><td>Э-мэйл</td><td>".form_input("email",$email,array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>Хаяг</td><td>".form_textarea("address",$address,array("class"=>"form-control"))."</td></tr>";	
	echo "</table>";
	echo form_submit("Засах","Засах",array("class"=>"btn btn-success"));
	echo form_close();	
}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->
<?	echo anchor('customer/profile','Буцах',array("class"=>"btn btn-warning"))."<br>"; ?>
