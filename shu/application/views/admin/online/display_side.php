<? 
//$customer_id = $this->session->userdata('agent_id');
if (isset($_POST["search"])) $search =$_POST["search"]; else $search="";
?>

<!--div class="panel panel-primary">
  <div class="panel-heading">Шүүлтүүр</div>
  <div class="panel-body">
  
    <?
	/*echo form_open("admin/orders/");
	$options = array(
				  'all'  => 'Бүx идэвхитэй',
				  'new'  => 'Нисэхэд бэлэн',
				  'order'  => 'Хүлээн авагчгүй',
				  'filled'  => 'Х/авагч бөглөсөн',
				  'weight_missing'  => 'Жин нь бөглөгдөөгүй',
                  'onair'    => 'Онгоцоор ирж байгаа',
                  'warehouse'   => 'Агуулахад байгаа',
				  'delivered'  => 'Хүргэгдсэн',
                  'custom' => 'Гаальд саатсан',
				  'db' => 'Баазаас'
                );

 echo form_input("search","",array("class"=>"form-control","placeholder"=>"Хайх..."))."<br>";
 echo form_dropdown("status",$options,'all',array("class"=>"form-control"));

	$options = array(
				  'advance' => 'Төлбөртэйг',
				  'all' => 'Бүгдийг'
                );
 echo form_dropdown("status_type",$options,'all',array("class"=>"form-control"));
 echo form_submit("Хайх","Хайх",array("class"=>"btn btn-primary"))
 */
 ?>

  </div>
</div-->





<div class="panel panel-primary">
  <div class="panel-heading">Админы цэс</div>
  <div class="panel-body">
  
  <ul class="list-group">
	<li  class="list-group-item"><?=anchor('admin/online', 'Бүх online')?></li>
	<li  class="list-group-item"><?=anchor('admin/online_history', 'Түүх')?></li>
     <li  class="list-group-item"><?=anchor('admin/online_pendings', 'Pending track')?></li>
    <li  class="list-group-item"><?=anchor('admin/all_later', 'Дараа болгосон')?></li>
</ul>
</ul>
  </div>
</div>