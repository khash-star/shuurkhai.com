<? 
$customer_id = $this->session->userdata('customer_id');
?>
<div class="panel panel-success">
  <div class="panel-heading">Хэрэглэгчийн цэс</div>
  <div class="panel-body">
  
  <ul class="list-group">
	<li class="list-group-item">
    <?=anchor("customer/orders_create","Track бүртгүүлэх");?>
  </li>
   <li class="list-group-item">
   	<? 
	$sql= "SELECT * FROM orders WHERE receiver='".$customer_id."' AND status NOT IN('delivered','completed') AND created_date>'2015-09-01'";
	$query = $this->db->query($sql);
	echo  "<span class='badge'>".$query->num_rows()."</span>";
	
	echo anchor("customer/orders","Идэвхитэй илгээмжүүд");?>
  </li>
  
  <li class="list-group-item">
   	<? 
	$sql= "SELECT * FROM orders WHERE receiver=".$customer_id." AND status='delivered' AND created_date>'2015-09-01'";
	$query = $this->db->query($sql);
	echo  "<span class='badge'>".$query->num_rows()."</span>";
	
	echo anchor("customer/orders_history","Илгээмжийн түүх");?>
  </li>
	<li class="divider list-group-item"></li>

  	<li class="list-group-item">
    <?=anchor("customer/online_create","Захиалга өгөх");?>
  </li>
   <li class="list-group-item">
   	<? 
	$sql= "SELECT * FROM online WHERE (customer_id='".$customer_id."' OR receiver='".$customer_id."') AND status ='online'";
	$query = $this->db->query($sql);
	echo  "<span class='badge'>".$query->num_rows()."</span>";
	
	echo anchor("customer/online","Миний захиалгууд");?>
  </li>
  
  <li class="list-group-item">
   	<? 
	$sql= "SELECT * FROM online WHERE (customer_id='".$customer_id."' OR receiver='".$customer_id."') AND status IN ('complete','order')";
	$query = $this->db->query($sql);
	echo  "<span class='badge'>".$query->num_rows()."</span>";
	
	echo anchor("customer/online_history","Захиалгын түүх");?>
  </li>

</ul>
  </div><!-- panel-body -->
  </div><!-- panel --> 
  
  
  
  
  <!--div class="panel panel-default">
  <div class="panel-body">
 <? //$this->load->view("page2");?>
  </div>
  </div><!-- panel --> 


