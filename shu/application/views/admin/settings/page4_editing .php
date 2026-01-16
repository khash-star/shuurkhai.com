<div class="panel panel-primary">
  <div class="panel-heading">Онлайн захиалга хуудас</div>
  <div class="panel-body">
<? 
	$file_name = "application/views/online.php";
	$data ="";
	  $fp = fopen($file_name, "w");
		$content=stripslashes($_POST["page_content"]);
		if (file_put_contents($file_name, $content)) 
		echo '<div class="alert alert-success" role="alert">Амжилттай бичигдлээ</div>'; 
		else echo '<div class="alert alert-danger" role="alert">Файл бичихэд алдаа гарлаа</div>';
		fclose($fp);
?>


</div> <!--PANEL-BODY-->
</div> <!--PANEL-->