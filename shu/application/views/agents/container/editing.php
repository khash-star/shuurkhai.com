<? if ($_POST["container_id"]=="") redirect('agents/container'); else $container_id=$_POST["container_id"]; ?>


<div class="panel panel-success">
  <div class="panel-heading">Чингэлэг засах</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM container WHERE container_id='".$container_id."'");
	if ($query->num_rows()==1)
	{
	$row = $query->row();
	$status= $row ->status;
	if ($status=="new")
	{
		//$name= $_POST["name"];

		$expected= $_POST["expected"];
		//$today = date("Y-m-d");// current date

		//$date = strtotime(date("Y-m-d", strtotime($today)) . " +48 day");
		//if ($expected=="0000-00-00") $expected =  date('Y-m-d',strtotime('+48 days',$today));

		$description=  $_POST["description"];
		$new_status=  $_POST["status"];

		//echo "today:".$today;
		//echo "expected:".$expected;

		$data = array(
				   'expected' => $expected,
				   'description' => $description,
	            );
		$this->db->where('container_id', $container_id);
		if ($this->db->update('container', $data)) echo "Амжилттай заслаа.<br>";
		else echo "ERROR".$this->db->error();

		if ($new_status=="onway")
			{
				$data = array(
		               'status' => $new_status,
					   'departed' => date("Y-m-d")
		            );
				$this->db->where('container_id', $container_id);
				$this->db->update('container', $data);

				$data = array(
		               'status' => 'onway',
					   'onway_date' => date("Y-m-d")
		            );
				$this->db->where('container', $container_id);
				$this->db->update('container_item', $data);
			}
	}

		if ($status=="onway")
	{
		//$name= $_POST["name"];
		$expected= $_POST["expected"];
		//$today = date("Y-m-d");// current date

		//$date = strtotime(date("Y-m-d", strtotime($today)) . " +48 day");
		//if ($expected=="0000-00-00") $expected =  date('Y-m-d',strtotime('+48 days',$today));
		$description=  $_POST["description"];
		//$new_status=  $_POST["status"];

		$data = array(
	               //'name' => $name,
				   'expected' => $expected,
				   'description' => $description,
	            );
		$this->db->where('container_id', $container_id);
		if ($this->db->update('container', $data)) echo "Амжилттай заслаа.<br>";
		else echo "ERROR".$this->db->error();
	}

	//if ($new_status!="onway" && $new_status!="onway")
	//else echo '<div class="alert alert-danger" role="alert">Чинэглэгийн төлөв засаж болохгүй төлөвт байна</div>';
}
else echo '<div class="alert alert-danger" role="alert">Чинэглэгийн дугаар алдаатай байна</div>';

echo anchor ("agents/container_detail/".$container_id,"Дэлгэрэнгүй",array("class"=>"btn btn-success"));
?>
</div>
</div>