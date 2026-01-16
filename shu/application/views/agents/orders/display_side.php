<? 
$customer_id = $this->session->userdata('agent_id');
if (isset($_POST["search"])) $search =$_POST["search"]; else $search="";
if (isset($_POST["status"])) $status =$_POST["status"]; else $status="";
?>

<div class="panel panel-default">
  <div class="panel-heading">Filter</div>
  <div class="panel-body">
  
    <?
	echo form_open("agents/orders/");
	$options = array(
				  'all'  => 'All active',
				  'new'  => 'Ready to fly',
				  'order'  => 'No deliverer',
				  'filled'  => 'Deliverer filled',
				  'weight_missing'  => 'No weight',
                  'onair'    => 'On flight',
                  'warehouse'   => 'In warehouse',
				 // 'delivered'  => 'Хүргэгдсэн',
                  'custom' => 'Customs',
				//  'db' => 'Баазаас'
                );

 echo form_input("search",$search,array("class"=>"form-control","placeholder"=>"Search..."))."<br>";
 echo form_dropdown("status",$options,$status,array("class"=>"form-control"));

	$options = array(
				  'advance' => 'With advance',
				  'all' => 'All'
                );
 echo form_dropdown("status_type",$options,'all',array("class"=>"form-control"));
 echo form_submit("Searcg","Search",array("class"=>"btn btn-primary"))
 
 ?>

  </div>
</div>





<div class="panel panel-default">
  <div class="panel-heading">Agent menu</div>
  <div class="panel-body">
  
  <ul class="list-group">
 	 <li class="list-group-item"><?=anchor('agents/orders', 'All orders')?></li>
	<li class="list-group-item"><?=anchor('agents/create', 'Place order')?></li>
	<!--li><? //anchor(base_url().'assets/orders.xlsx', 'Excel файл татах')?></li-->
</ul>
</ul>
  </div>
</div>