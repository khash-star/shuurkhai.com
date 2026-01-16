<div class="panel panel-success">
  <div class="panel-heading text-center">Та хүргэлт сонгож байгаа бол Трак, Barcode, утасны дугаарын аль нэгийг оруулна уу</div>
  <div class="panel-body">
  Таны ачааны аль нэгийг мэдээллийг оруулж хот дотор хүргэлтээр авах боломжтой 8кг хүртэл 2500төг, 8кг-с дээш бол 5000төг байна.
<? 
echo form_open("welcome/transport_checking");
	echo "<table class='table table-hover'>";
	echo "<tr><td>Track</td><td>".form_input("track","",array("class"=>"form-control","placeholder"=>"Трак, Barcode, утасны дугаарын аль нэгийг оруулна уу"))."</td></tr>";
	echo "</table>";
	
	echo form_submit("submit","Хүргэлтээр авъя",array("class"=>"btn btn-primary"));
	echo form_close();
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->