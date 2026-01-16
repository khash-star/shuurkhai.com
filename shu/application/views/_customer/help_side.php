<? $customer_id = $this->session->userdata('customer_id');?>

<div class="panel panel-danger">
  <div class="panel-heading">Тусламжийн цэс</div>
  <div class="panel-body">
   <ul class="list-group">
	<li class="list-group-item">
  	<?	$sql= "SELECT * FROM help WHERE receiver='".$customer_id."' AND `read`='0'";
	$query = $this->db->query($sql);
  	echo anchor("customer/help","Тусламжын хариу <span class='badge'>".$query->num_rows()."</span>");?>
  	</li>
   	<li class="list-group-item">
  	<?=anchor("customer/help_create","Тусламж үүсгэх");?>
  	</li>
	<li class="list-group-item">
  	<?=anchor("customer/help_history","Таны үүсгэсэн тусламжууд");?>
  	</li>
  </ul>
  </div><!-- panel-body -->
  </div><!-- panel --> 
