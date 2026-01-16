<script src="<?=base_url();?>assets/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/jquery.ui.themes/flick/jquery.ui.theme.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/jquery.ui.themes/flick/jquery-ui.css"/>
<?
  if (isset($_POST["contacts"])) $contacts=$_POST["contacts"]; else $contacts ="";
?>


<script type="application/javascript">			
$(function() {
    $( "input[name='start_date']" ).datepicker();
	 $( "input[name='finish_date']" ).datepicker();
  });
			
</script>
<? 
if (isset($_POST["start_date"])) $start_date =$_POST["start_date"]; else $start_date=$start_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -3 days'));
if (isset($_POST["finish_date"])) $finish_date =$_POST["finish_date"]; else $finish_date=date("Y-m-d");
?>
<div class="panel panel-primary">
  <div class="panel-heading">Шүүлтүүр</div>

  <div class="panel-body">
  
  <? echo form_open("admin/later_transaction");?>
 <? echo "<span>Хайх утас:</span>".form_input("contacts",$contacts,array("class"=>"form-control"))."<br>";?>


<? echo "<span>Эхлэх хугацаа:</span>".form_input("start_date",$start_date,array("class"=>"form-control"))."<br>";?>
<? echo "<span>Дуусах хугацаа:</span>".form_input("finish_date",$finish_date,array("class"=>"form-control"))."<br><br>";?>
    <? echo form_submit ("submit","хайх",array("class"=>"btn btn-primary")); ?>
    <? echo form_close();?>
      </div>
</div>


<div class="panel panel-primary">
  <div class="panel-heading">Админы цэс</div>
  <div class="panel-body">
  
  <ul class="list-group">
	<li  class="list-group-item"><?=anchor('admin/delivered', 'Гардуулсан илгээмж')?></li>
	<li class="list-group-item"><?=anchor('admin/deliver', 'Олголт')?></li>
</ul>
  </div>
</div>