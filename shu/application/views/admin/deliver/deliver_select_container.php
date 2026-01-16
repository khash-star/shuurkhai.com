<?
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<? //if (!isset($_POST["deliver"]) || !isset($_POST["tel"])) redirect("admin/deliver");?>
<script type="application/javascript">
$(document).ready(function() {
			$(".alert").hide();
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

$('input[name="contacts"]').change(function(){
		$('#result').append('<img src="<?=base_url()?>assets/images/ajax-loader.gif" id="loading">');
		var tel= $('input[name="contacts"]').val();
	$.ajax ({
		url: '<?=base_url()?>index.php/admin/customers_check2',
		type:'POST',
		data:'tel='+tel,
		success: function(responce){
			//alert("LOADING...");
					
					//alert(responce_json.name);
				//	alert(responce);
					if (responce!="")
					{
						var responce_json = JSON.parse(responce);
						$('input[name="rd"]').val(responce_json.rd);
						$('input[name="surname"]').val(responce_json.surname);
						$('input[name="name"]').val(responce_json.name);
						$('input[name="email"]').val(responce_json.email);
						$('textarea[name="address"]').val(responce_json.address);
					}
					else 
					{	
						$('input[name="rd"]').val("");
						$('input[name="surname"]').val("");
						$('input[name="name"]').val("");
						$('input[name="email"]').val("");
						$('textarea[name="address"]').val("");
						alert("Хэрэглэгч олдсонгүй");
					}
				}
			});	
		});			
})
</script>


<div class="panel panel-primary">
  <div class="panel-heading">Чингэлэгийн гардуулалт</div>
  <div class="panel-body">
	<? 
	$count=0;

	if (isset($_POST["tel"]))
	{
		$tel = $_POST["tel"];
		$query=$this->db->query("SELECT * FROM customer WHERE tel='$tel' LIMIT 1");
			if ($query->num_rows()==1)
				{
					$row=$query ->row();
					$customer_id = $row->customer_id;
				 	echo "Хүлээн авагч:".customer($customer_id,"name")."<br>";
				 	echo "Утас:".customer($customer_id,"tel")."<br>";
				 	echo "РД:".customer($customer_id,"rd")."<br>";


				 	echo form_open("admin/delivering_container");

				 	echo '<h3>Хүлээн авагч</h3>';
					    echo "<table class='table table-hover'>";
						    echo "<tr><td>Утас:(*)</td><td>".form_input ("contacts","",array("class"=>"form-control"))."</td></tr>";
						    echo "<tr><td colspan='2'><span id='result' class='alert alert-danger alert-small' role='alert'></span></td></tr>";
						    echo "<tr><td>Нэр(*)</td><td>".form_input ("name","",array("class"=>"form-control"))."</td></tr>";
						    echo "<tr><td>Овог</td><td>".form_input ("surname","",array("class"=>"form-control"))."</td></tr>";
						    echo "<tr><td>РД</td><td>".form_input ("rd","",array("class"=>"form-control"))."</td></tr>";
						    echo "<tr><td>И-мейл(*)</td><td>".form_input ("email","",array("class"=>"form-control"))."</td></tr>";
						    echo "<tr><td>Хаяг(*)</td><td>".form_textarea ("address","",array("class"=>"form-control"))."</td></tr>";
					    echo "</table>";
			
		 
	   				
				    ?>
				    <h3>Төлбөр төлөх дүн</h3>
				    <input type="text" name="count" placeholder="Ачааны тоо ширхэг"  class="form-control"><br>
				     <table>
				     	<tr>
				    		<td>
				    			<input type="text" name="cash_value" id="cash_value" placeholder="Бэлэн" value="" class="form-control">
				    		</td>
				    		<td>
				    			<input type="text" name="pos_value" id="pos_value" placeholder="Картаар"  value="" class="form-control">
				    		</td>
				    		<td>
				    			<input type="text" name="account_value" id="account_value" placeholder="Данс"  value="" class="form-control">     		
				    		</td>
				    		<td>
				    			<input type="text" name="later_value" id="later_value" placeholder="Дараа"  value="" class="form-control">     		
				    		</td>
				     	</tr>
				     </table>
					
					<br>      
					<button type="submit" class="btn btn-primary">Гүйцэтгэх</button>
					<?
					echo form_close();
				}
				else 
					echo "Хэрэглэгч олдсонгүй.";
	}
	else 
	redirect("admin/deliver_container/notfound");
	
	?>
    </div>
</div>