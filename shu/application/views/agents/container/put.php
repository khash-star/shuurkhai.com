<? if (!$this->uri->segment(3)) redirect('agents/container'); else $item_id=$this->uri->segment(3) ?>
<div class="panel panel-success">
  <div class="panel-heading">Чингэлэгт ачаа оруулах</div>
  <div class="panel-body">
<? 
//require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');
$query = $this->db->query("SELECT * FROM container_item WHERE id=".$item_id);
if ($query->num_rows()==1)
{
	$row = $query->row();
	$sender= 	$row ->sender;
	$receiver= 	$row ->receiver;
	$description = $row ->description;
	$weight= 	$row ->weight;
	$payment= 	$row ->payment;
	$pay_in_mongolia= 	$row ->pay_in_mongolia;
	$container_id= 	$row ->container;


	if ($container_id==0) 
		{
		echo form_open('agents/container_item_putting');
		echo form_hidden("item_id",$item_id);
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

		echo form_submit("submit","Оруулах",array("class"=>"btn btn-success"));
		echo form_close();
		}
	else echo '<div class="alert alert-danger" role="alert">Ачаа чингэлэгт байна.</div>';
}
else echo '<div class="alert alert-danger" role="alert">Ачааны дугаар алдаатай байна</div>';




?>


  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->