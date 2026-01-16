<? if (!$this->uri->segment(3)) redirect('agents/container'); else $container_id=$this->uri->segment(3) ?>

<div class="panel panel-success">
  <div class="panel-heading">Чингэлэг засах</div>
 <div class="panel-body">
<? 
	$query = $this->db->query("SELECT * FROM container WHERE container_id='".$container_id."'");
	if ($query->num_rows()==1)
	{
	$row = $query->row();
	$name= $row ->name;
	$created= $row ->created;
	$departed= $row ->departed;
	$description= $row ->description;
	$expected= $row ->expected;
	if ($expected=="0000-00-00") $expected="";
	$status= $row ->status;
	if ($status=="new")
	{
		echo form_open('agents/container_editing');
		echo form_hidden("container_id",$container_id);
		echo "<table class='table table-hover'>";
		echo "<tr><td> Чингэлэгийн дугаар:</td><td>". form_input ("name",$name,array("class"=>"form-control","placeholder"=>"Жишээ: WLL928374","readonly"=>"readonly"))."</td></tr>";
		echo "<tr><td> Монгол очих урьдчилсан огноо:(*)</td><td>". form_input ("expected",$expected,array("class"=>"form-control","placeholder"=>"Жишээ: 2017-06-02","required"=>"required"))."</td></tr>";
		echo "<tr><td>Тайлбар:</td><td>". form_textarea ("description",$description,array("class"=>"form-control"))."</td></tr>";
		echo "<tr><td>Төлөв:</td><td><select name='status' class='form-control'>";
		echo "<option value='new' selected='selected'>Америкаас хөдлөөгүй</option>";
		echo "<option value='onway'>Америкаас гарсан (өөрчлөлт оруулах боломжгүй)</option>";
		echo "</td></tr>";
		echo "</table>";

		echo form_submit("submit","Засах",array("class"=>"btn btn-success"));
		echo form_close();
	}

		if ($status=="onway")
	{
		echo form_open('agents/container_editing');
		echo form_hidden("container_id",$container_id);
		echo "<table class='table table-hover'>";
		//echo "<tr><td> Чингэлэгийн дугаар:(*)</td><td>". form_input ("name",$name,array("class"=>"form-control","placeholder"=>"Жишээ: WLL928374","required"=>"required"))."</td></tr>";
		echo "<tr><td> Монгол очих урьдчилсан огноо:(*)</td><td>". form_input ("expected",$expected,array("class"=>"form-control","placeholder"=>"Жишээ: 2017-06-02","required"=>"required"))."</td></tr>";
		echo "<tr><td>Тайлбар:</td><td>". form_textarea ("description",$description,array("class"=>"form-control"))."</td></tr>";
		//echo "<tr><td>Төлөв:</td><td><select name='status' class='form-control'>";
		//echo "<option value='new' selected='selected'>Америкаас хөдлөөгүй</option>";
		//echo "<option value='onway'>Америкаас гарсан (өөрчлөлт оруулах боломжгүй)</option>";
		//echo "</td></tr>";
		echo "</table>";

		echo form_submit("submit","Засах",array("class"=>"btn btn-success"));
		echo form_close();
	}
	//else echo '<div class="alert alert-danger" role="alert">Чинэглэгийн төлөв засаж болохгүй төлөвт байна</div>';
}
else echo '<div class="alert alert-danger" role="alert">Чинэглэгийн дугаар алдаатай байна</div>';

?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

<?=anchor("agents/container_delete/".$container_id,"Хоосон чингэлэгийг устгах",array("class"=>"btn btn-xs btn-danger"));?>