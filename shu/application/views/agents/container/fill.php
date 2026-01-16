<? if ($this->uri->segment(3)) $container_id=$this->uri->segment(3); else $container_id=0; ?>
<? if (isset($_POST["container"])) $container_id=$_POST["container"]; ?>

<div class="panel panel-success">
  	<div class="panel-heading">Контайнер-т ачаа оруулах
		<span title="Чингэлэгт ороогүй ачаа">(<?=anchor("agents/container_outside",container_outside());?> Чингэлэгт ороогүй ачаа)</span>
	</div>
  <div class="panel-body">

  		<?
  		if ($container_id==0)
  		{
  			echo form_open("agents/container_fill",array("id"=>"select_container"));
	  			echo "<table class='table table-hover'>";
				echo "<tr><th colspan='2'><h4>Бэлэн чингэлэг</h4></th></tr>";
				echo "<tr><td>Чингэлэг:(*)</td><td>";
				echo "<select name='container' class='form-control'>";
					$query_container = $this->db->query("SELECT * FROM container WHERE status='new'");
						foreach ($query_container->result() as $row_container)
							{
								echo "<option value='".$row_container->container_id."'>".$row_container->name."</option>";
							}
				echo "</select>";
				echo "</td></tr>";
				echo "</table>";
				echo form_submit("submit","Ачаа оруулах",array("class"=>"btn btn-success"));
			echo form_close();
  		}
  		?>

		<? 
		if ($container_id!=0)
  		{	
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

					echo "<h1>".$name;	if ($status=="new") echo anchor("agents/container_edit/".$container_id,"засах",array("class"=>"btn btn-success btn-xs"));echo "</h1>";

					echo "Үүсгэсэн огноо:".$created."<br>";
					echo "Төлөв:".$status."<br>";
					echo "Америкаас гарсан огноо:".$departed."<br>";
					echo "Монголд очих огноо:".$expected."<br>";
					echo "<p>".$description."</p>";
					if ($status="new")
					{
						echo form_open("agents/container_filling");
						echo form_hidden("container_id",$container_id);
				        echo "<h4 class='legend'>Track or Barcode</h4>";
				        echo form_input ("barcode","",array("class"=>"form-control","placeholder"=>"CO1712249999MN"));
						 if ($this->uri->segment(4)=="already") echo $this->uri->segment(5)." хайрцагт байна.";
						 else echo $this->uri->segment(4);
						 echo "<br>";
						echo form_submit("Оруулах","оруулах",array("class"=>"btn btn-success"));
						echo form_close();
					}
					else echo "Контайнерийн төлөв шинэ биш байна.";
			       // echo "<br><br><div id=\"result\"></div><br>";
				}
			else echo "Контайнерийн дугаар алдаатай байна.";			
		}
        ?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->
<script type="application/javascript">
$(document).ready(function(e) {
	$('select').change(function(){
		$("form").submit();
	});

	//$('input[name="barcode"]').focus();
})
</script>
