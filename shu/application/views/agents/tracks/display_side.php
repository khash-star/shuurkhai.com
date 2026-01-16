<? 
$customer_id = $this->session->userdata('agent_id');
if (isset($_POST["search"])) $search =$_POST["search"]; else $search="";
if (isset($_POST["status"])) $status =$_POST["status"]; else $status="";
?>

<div class="panel panel-default">
  <div class="panel-heading">Шүүлтүүр</div>
  <div class="panel-body">
  
    <?
	echo form_open("agents/tracks/");
	$options = array(
				  'all'  => 'Бүx идэвхитэй',
				  'new'  => 'Нисэхэд бэлэн',
				  'order'  => 'Хүлээн авагчгүй',
				  'filled'  => 'Х/авагч бөглөсөн',
				  'weight_missing'  => 'Жин нь бөглөгдөөгүй',
                  'onair'    => 'Онгоцоор ирж байгаа',
                  'received'    => 'DE-д received',
                  'warehouse'   => 'Агуулахад байгаа',
				//  'delivered'  => 'Хүргэгдсэн',
                  //'custom' => 'Гаальд саатсан',
				  //'db' => 'Баазаас'
                );

 echo form_input("search",$search,array("class"=>"form-control","placeholder"=>"Хайх..."))."<br>";
 echo form_dropdown("status",$options,$status,array("class"=>"form-control"));

	$options = array(
				  'advance' => 'Төлбөртэйг',
				  'all' => 'Бүгдийг'
                );
 echo form_dropdown("status_type",$options,'all',array("class"=>"form-control"));
 echo form_submit("Хайх","Хайх",array("class"=>"btn btn-primary"))
 
 ?>

  </div>
</div>





<div class="panel panel-default">
  <div class="panel-heading">Агентийн цэс</div>
  <div class="panel-body">
  
  <ul class="list-group">
	<li class="list-group-item"><?=anchor('agents/tracks_insert', 'Track оруулах')?></li>
	<!--li><? //anchor(base_url().'assets/orders.xlsx', 'Excel файл татах')?></li-->
</ul>
</ul>
  </div>
</div>