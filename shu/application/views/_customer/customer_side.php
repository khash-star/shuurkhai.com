<?
$customer_id = $this->session->userdata('customer_id');
?>
<div class="panel panel-success">
  <div class="panel-heading">Хэрэглэгчийн цэс</div>
  <div class="panel-body">
   <ul class="list-group">
	<li class="list-group-item"  style="text-align:center; background:#FF9;">
    Таны хуримтлалын сан:<br />
    <span style="font-size:50px; color:#090; text-align:center;">
	<? if (customer($customer_id,"cent")<100) echo customer($customer_id,"cent")."&cent;";
	if (customer($customer_id,"cent")>100) echo customer($customer_id,"cent")/100 ."$";
	
	?></span>
    <span style="color:#600;"><br />Трак бүртгүүлэх бүрт 1&cent хуримтлагдана</span>
    </li>
    </ul>
  <ul class="list-group">
	<li class="list-group-item">
    <?=anchor("customer/orders_create","Shipping track оруулах");?>
    </li>
   <li class="list-group-item">
   	<? 
	$sql= "SELECT * FROM orders WHERE receiver='".$customer_id."' AND status NOT IN('delivered','completed','custom') AND created_date>'2015-09-01'";
	$query = $this->db->query($sql);
	echo  "<span class='badge'>".$query->num_rows()."</span>";
	echo anchor("customer/orders","Бүртгэлтэй илгээмж");?>
  </li>
  
  <li class="list-group-item">
   	<? 
	$sql= "SELECT * FROM orders WHERE receiver='".$customer_id."' AND status IN ('delivered','custom') AND created_date>'2015-09-01'";
	$query = $this->db->query($sql);
	echo  "<span class='badge'>".$query->num_rows()."</span>";
	echo anchor("customer/orders_history","Илгээмжийн түүх");?>
  </li>
  
	<!--li class="divider list-group-item"></li-->
    </ul>
    	</div>


	<div class="panel-body">
	  <ul class="list-group">
		<li class="list-group-item">
	    	<?=anchor("customer/container","Чингэлэг");?>
	    </li>
	  </ul>
    </div>


    
      <!--div class="panel-heading">Захиалгын сагс</div-->
      <div class="panel-body">
	<li class="list-group-item">
   	<? 
	$sql= "SELECT * FROM online WHERE (customer_id='".$customer_id."' OR receiver='".$customer_id."') AND status ='online'";
	$query = $this->db->query($sql);
	$online_count= $query->num_rows();
	
	
	echo  "<span class='badge'>".$online_count."</span>";
	
	echo anchor("customer/online","<span class='glyphicon glyphicon-shopping-cart'></span> Сагс");?>
  </li>





  	<li class="list-group-item">
    <?=anchor("customer/online_create","<span class='glyphicon glyphicon-shopping-cart'></span> Сагсанд нэмэх",array("title"=>"сагсанд нэмэх"));?>
  </li>
  
  <li class="list-group-item">
   	<? 
	$sql= "SELECT * FROM online WHERE (customer_id='".$customer_id."' OR receiver='".$customer_id."') AND status='pending'";
	$query = $this->db->query($sql);
	echo  "<span class='badge'>".$query->num_rows()."</span>";
	
	echo anchor("customer/online_pending","Shipping Track хүлээж буй");?>
  </li>
  
  
  <li class="list-group-item">
   	<? 
	$sql= "SELECT * FROM online WHERE (customer_id='".$customer_id."' OR receiver='".$customer_id."') AND status ='later'";
	$query = $this->db->query($sql);
	$later_count= $query->num_rows();
	
	
	echo  "<span class='badge'>".$later_count."</span>";
	
	echo anchor("customer/online_all_later","Хойшлуулсан захиалга");?>
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


