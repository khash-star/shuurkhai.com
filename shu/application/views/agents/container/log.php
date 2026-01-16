<? if (!$this->uri->segment(3)) redirect('agents/container'); else $container_id=$this->uri->segment(3) ?>


<div class="panel panel-success">
  <div class="panel-heading">Чингэлэг дэлгэрэнгүй мэдээлэл</div>
  <div class="panel-body">
<? 
//require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');
$query = $this->db->query("SELECT * FROM container WHERE container_id=".$container_id);
if ($query->num_rows()==1)
{
	$row = $query->row();
	$name= 	$row ->name;
	$created= 	$row ->created;
	$departed= 	$row ->departed;
	$expected= 	$row ->expected;
	$description= 	$row ->description;
	$status= 	$row ->status;
	echo "<b>".$name."</b><br>";
	echo "Үүсгэсэн огноо:".$created."<br>";
	echo "Төлөв:".$status."<br>";
	echo "Америкаас гарсан огноо:".$departed."<br>";
	echo "Монголд очих огноо:".$expected."<br>";
	echo "<p>".$description."</p>";

}

echo form_open('agents/container_log_inserting');
echo "<table class='table table-hover'>";
echo form_hidden("container_id",$container_id);
echo "<tr><td>Огноо:(*)</td><td>". form_input ("date",date("Y-m-d"),array("class"=>"form-control","placeholder"=>"Жишээ: 2017-06-02","required"=>"required"))."</td></tr>";
echo "<tr><td>Тайлбар: (*)</td><td>". form_textarea ("description","",array("class"=>"form-control"))."</td></tr>";
echo "</table>";

echo form_submit("submit","add",array("class"=>"btn btn-success"));
echo form_close();

?>


  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->