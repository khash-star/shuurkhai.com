<? if (!$this->uri->segment(3)) redirect('admin/customers'); else $customer_id=$this->uri->segment(3) ?>

<script>
$(document).ready(function(e) {
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
			
	
	
	
   //$("input[name='reg_number']").mask("өө99999999");
   $("input[name='contacts']").mask("999999?9999");
   
   
   
   $('input[name="contacts"]').change(function(){
		$('#customers_result').append('<img src="<?=base_url()?>assets/images/ajax-loader.gif" id="loading">');
		var tel= $('input[name="contacts"]').val();
	$.ajax ({
		url: '<?=base_url()?>index.php/admin/customers_check',
		type:'POST',
		data:'tel='+tel,
		success: function(responce){
									$('#responce').remove();
									$('#customers_result').append('<p id="responce">'+responce+'</p>');
									$('#loading').remove();
									if (responce=="Found user") 
									{
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=rd',
										success: function(responce0){
											$('input[name="customers_rd"]').val(responce0);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=surname',
										success: function(responce1){
											$('input[name="customers_surname"]').val(responce1);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=name',
										success: function(responce2){
											$('input[name="customers_name"]').val(responce2);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=email',
										success: function(responce3){
											$('input[name="email"]').val(responce3);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=address',
										success: function(responce4){
											$('textarea[name="address"]').text(responce4);
																	}
												});	
									}
									}
		});	
	});
})
</script>

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
  <div class="panel-heading">Proxy нэмэх</div>
  <div class="panel-body">
<? 
echo form_open('admin/customers_proxy_adding');
echo "<table class='table table-hover'>";
echo "<tr><td>Нэр:(*)</td><td>".form_input ("proxy_name","",array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>Овог:</td><td>".form_input ("proxy_surname","",array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>Утас:(*)</td><td>".form_input ("proxy_contacts","",array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>Хаяг:</td><td>".form_textarea ("proxy_address","",array("class"=>"form-control"))."</td></tr>";
echo "</table>";
echo form_hidden ("customer_id",$customer_id);
echo form_submit("submit","нэмэх",array("class"=>"btn btn-primary"));
echo form_close();

?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

<?=anchor("admin/customers_proxy/".$customer_id,"Бүх proxy",array("class"=>"btn btn-primary")); ?>