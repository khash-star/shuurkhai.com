<script src="<?=base_url();?>assets/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/jquery.ui.themes/flick/jquery.ui.theme.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/jquery.ui.themes/flick/jquery-ui.css"/>



<script type="application/javascript">			
$(function() {
    $( "input[name='start_date']" ).datepicker();
	 $( "input[name='finish_date']" ).datepicker();
  });
			
</script>
<? 
$customer_id = $this->session->userdata('agent_id');
if (isset($_POST["search"])) $search =$_POST["search"]; else $search="";
if (isset($_POST["status"])) $status =$_POST["status"]; else $status="";
if (isset($_POST["search_date"])) $search_date =$_POST["search_date"]; else $search_date="created";
if (isset($_POST["start_date"])) $start_date =$_POST["start_date"]; else $start_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 month'));
if (isset($_POST["finish_date"])) $finish_date =$_POST["finish_date"]; else $finish_date=date("Y-m-d");

?>

<div class="panel panel-default">
  <div class="panel-heading">Шүүлтүүр</div>
  <div class="panel-body">
  
    <?
	echo form_open("admin/tracks/");
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
                  'received' => 'Delaware-д бүртгэгдсэн',
				  'transport'  => 'Хүргэлттэй',
				  'db' => 'Баазаас'
                );

 echo form_input("search",$search,array("class"=>"form-control","placeholder"=>"Хайх..."))."<br>";
 echo form_dropdown("status",$options,$status,array("class"=>"form-control"));

	$options = array(
				  'advance' => 'Төлбөртэйг',
				  'all' => 'Бүгдийг'
                );
 echo form_dropdown("status_type",$options,'all',array("class"=>"form-control"))."<br>";
 
 	$options = array(
				  'created' => 'created',
				  'onair' => 'onair',
				  'warehouse' => 'warehouse',
				  'delivered' => 'delivered',
                );
 echo "<span>Хайх огноо:</span>".form_dropdown("search_date",$options,$search_date,array("class"=>"form-control"));
 
  echo "<span>Эхлэх хугацаа:</span>".form_input("start_date",$start_date,array("class"=>"form-control"));?>
<? echo "<span>Дуусах хугацаа:</span>".form_input("finish_date",$finish_date,array("class"=>"form-control"))."<br>";

 echo form_submit("Хайх","Хайх",array("class"=>"btn btn-primary"))
 
 ?>

  </div>
</div>