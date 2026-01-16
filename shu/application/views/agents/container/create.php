<div class="panel panel-success">
  <div class="panel-heading">Чингэлэг үүсгэх</div>
 <div class="panel-body">
<? 
echo form_open('agents/container_inserting');
echo "<table class='table table-hover'>";
echo "<tr><td> Чингэлэгийн дугаар:</td><td>Өнөөдрийн огноогоор үүснэ</td></tr>";
//echo "<tr><td> Монгол очих урьдчилсан огноо:(*)</td><td>". form_input ("expected","",array("class"=>"form-control","placeholder"=>"Жишээ: 2017-06-02","required"=>"required"))."</td></tr>";
echo "<tr><td>Тайлбар:</td><td>". form_textarea ("description","",array("class"=>"form-control"))."</td></tr>";
echo "</table>";

echo form_submit("submit","add",array("class"=>"btn btn-success"));
echo form_close();

?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->