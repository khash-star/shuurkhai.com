<div class="panel panel-success">
  <div class="panel-heading">Та Тракаа бүртгүүлснээр 1&cent; таны хуримтлалын санд нэмэгдэнэ.</div>
  <div class="panel-body">
<? 
echo form_open("welcome/track_searching");
	echo "<table class='table table-hover'>";
	echo "<tr><td>Track</td><td>".form_input("track","",array("class"=>"form-control","placeholder"=>"Жишээ нь: 1Z9999999999999999"))."</td></tr>";
	echo "</table>";
	
	echo form_submit("submit","Шалгах",array("class"=>"btn btn-primary"));
	echo form_close();
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->